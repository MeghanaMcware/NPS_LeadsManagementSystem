<?php

namespace Tests\Feature;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class LeadImportTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);
    }

    public function test_can_download_sample_file(): void
    {
        $response = $this->actingAs($this->user)->get(route('leadsimport.sample'));

        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Admission for which grade?', $response->streamedContent());
    }

    public function test_can_save_single_lead(): void
    {
        $response = $this->actingAs($this->user)->postJson(route('leadsimport.single'), [
            'name' => 'Nithya Sharma',
            'phone' => '8971137295',
            'email' => 'nithya@example.com',
            'city' => 'Bengaluru',
            'interested_in' => 'Grade 1',
            'preferred_time_to_call' => 'Afternoon',
            'source' => 'Google Form',
            'status' => 'new',
            'remarks' => 'Requested campus tour',
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('leads', [
            'name' => 'Nithya Sharma',
            'phone' => '8971137295',
            'source' => 'Google Form',
            'interested_in' => 'Grade 1',
        ]);
    }

    public function test_preview_spreadsheet_and_suggest_mappings(): void
    {
        Storage::fake('local');

        $csvContent = "Sl No,Name,Phone Number,Admission for which grade?,Remarks\n"
                    ."1,Gowdham,8508130608,Grade 1,Incoming calls barred\n"
                    ."2,Ramadevi,+91 9945348884,PP1,Continuously Busy\n";

        $file = UploadedFile::fake()->createWithContent('leads.csv', $csvContent);

        $response = $this->actingAs($this->user)->post(route('leadsimport.preview'), [
            'file' => $file,
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'total_rows' => 2,
            'duplicate_count' => 0,
        ]);

        $json = $response->json();
        $this->assertEquals('skip', $json['suggested_mapping'][0]);
        $this->assertEquals('name', $json['suggested_mapping'][1]);
        $this->assertEquals('phone', $json['suggested_mapping'][2]);
        $this->assertEquals('interested_in', $json['suggested_mapping'][3]);
        $this->assertEquals('remarks', $json['suggested_mapping'][4]);
    }

    public function test_process_import_with_duplicates_skip_and_update(): void
    {
        Storage::fake('local');

        // Existing lead in DB
        Lead::create([
            'name' => 'Old Gowdham',
            'phone' => '8508130608',
            'source' => 'Website',
            'status' => 'new',
        ]);

        $csvContent = "Sl No,Name,Phone Number,Admission for which grade?,Remarks\n"
                    ."1,Gowdham Updated,8508130608,Grade 1,Updated remark\n"
                    ."2,Harish T,9686622272,Grade 3,Looking for day boarding\n";

        $file = UploadedFile::fake()->createWithContent('leads_batch.csv', $csvContent);

        $previewResponse = $this->actingAs($this->user)->post(route('leadsimport.preview'), [
            'file' => $file,
        ]);

        $previewData = $previewResponse->json();
        $this->assertEquals(1, $previewData['duplicate_count']);

        // Process with 'update' mode
        $processResponse = $this->actingAs($this->user)->postJson(route('leadsimport.process'), [
            'file_token' => $previewData['file_token'],
            'mapping' => $previewData['suggested_mapping'],
            'dup_mode' => 'update',
            'default_source' => 'Google Form',
        ]);

        $processResponse->assertOk();
        $processResponse->assertJson(['success' => true]);

        // Assert Harish T was imported
        $this->assertDatabaseHas('leads', [
            'name' => 'Harish T',
            'phone' => '9686622272',
            'source' => 'Google Form',
            'interested_in' => 'Grade 3',
        ]);

        // Assert Gowdham was updated
        $this->assertDatabaseHas('leads', [
            'phone' => '8508130608',
            'name' => 'Gowdham Updated',
            'interested_in' => 'Grade 1',
        ]);
    }

    public function test_can_parse_native_xlsx_spreadsheet(): void
    {
        Storage::fake('local');

        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        // Header row matching school sheet
        $sheet->setCellValue('A1', 'Sl No');
        $sheet->setCellValue('C1', 'Name');
        $sheet->setCellValue('D1', 'Phone Number');
        $sheet->setCellValue('H1', 'Admission for which grade?');
        $sheet->setCellValue('I1', 'Remarks');

        // Data row
        $sheet->setCellValue('A2', '1');
        $sheet->setCellValue('C2', 'Sheshadri');
        $sheet->setCellValue('D2', '9900868733');
        $sheet->setCellValue('H2', 'Grade - 4');
        $sheet->setCellValue('I2', 'Kanminike BDA | Visited the Campus');

        $tempPath = tempnam(sys_get_temp_dir(), 'test_xlsx_');
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        $uploadedFile = new UploadedFile($tempPath, 'leads_school.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);

        $previewResponse = $this->actingAs($this->user)->post(route('leadsimport.preview'), [
            'file' => $uploadedFile,
        ]);

        $previewResponse->assertOk();
        $previewData = $previewResponse->json();

        $this->assertTrue($previewData['success']);
        $this->assertEquals(1, $previewData['total_rows']);

        // Process import
        $processResponse = $this->actingAs($this->user)->postJson(route('leadsimport.process'), [
            'file_token' => $previewData['file_token'],
            'mapping' => $previewData['suggested_mapping'],
            'dup_mode' => 'skip',
            'default_source' => 'Google Form',
        ]);

        $processResponse->assertOk();

        $this->assertDatabaseHas('leads', [
            'name' => 'Sheshadri',
            'phone' => '9900868733',
            'interested_in' => 'Grade - 4',
            'source' => 'Google Form',
        ]);

        @unlink($tempPath);
    }
}

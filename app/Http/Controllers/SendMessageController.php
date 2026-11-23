<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\EmailService;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SendMessageController extends Controller
{
    /**
     * Show the Send Message interface.
     */
    public function index(Request $request): View
    {
        $leads = Lead::query()
            ->latest('id')
            ->get();

        $selectedIds = [];
        if ($request->filled('lead_id')) {
            $selectedIds = [(int) $request->input('lead_id')];
        } elseif ($request->filled('lead_ids')) {
            $raw = is_array($request->input('lead_ids'))
                ? $request->input('lead_ids')
                : explode(',', (string) $request->input('lead_ids'));
            $selectedIds = array_values(array_filter(array_map('intval', $raw)));
        }

        $templates = $this->templateCatalog();

        return view('admin.sendmessage.index', [
            'leads' => $leads,
            'selectedIds' => $selectedIds,
            'templates' => $templates,
        ]);
    }

    /**
     * Send messages to the selected leads.
     */
    public function send(
        Request $request,
        WhatsAppService $wa,
        SmsService $sms,
        EmailService $email
    ): JsonResponse {
        $validated = $request->validate([
            'channel' => ['required', 'string', 'in:whatsapp,sms,email,WhatsApp,SMS,Email'],
            'template_key' => ['required', 'string', 'in:greeting,followup,appointment,thankyou,promotion'],
            'lead_ids' => ['required', 'array', 'min:1'],
            'lead_ids.*' => ['integer', 'exists:leads,id'],
            'visit_date' => ['nullable', 'string', 'max:50'],
            'visit_time' => ['nullable', 'string', 'max:50'],
            'academic_year' => ['nullable', 'string', 'max:50'],
        ]);

        $channel = strtolower($validated['channel']);
        $templateKey = $validated['template_key'];
        $visitDate = $validated['visit_date'] ?? date('d M Y', strtotime('+2 days'));
        $visitTime = $validated['visit_time'] ?? '10:30 AM';
        $academicYear = $validated['academic_year'] ?? '2026-2027';

        $leads = Lead::whereIn('id', $validated['lead_ids'])->get();

        $sentCount = 0;
        $failedCount = 0;
        $results = [];

        foreach ($leads as $lead) {
            $res = match ($channel) {
                'whatsapp' => match ($templateKey) {
                    'greeting' => $wa->sendGreeting($lead, $lead->grade_applying_for ?? 'Grade 1'),
                    'followup' => $wa->sendFollowup($lead),
                    'appointment' => $wa->sendAppointment($lead, $visitDate, $visitTime),
                    'thankyou' => $wa->sendThankYou($lead),
                    'promotion' => $wa->sendPromotion($lead, $academicYear),
                },
                'sms' => match ($templateKey) {
                    'greeting' => $sms->sendGreeting($lead, $lead->grade_applying_for ?? 'Grade 1'),
                    'followup' => $sms->sendFollowup($lead),
                    'appointment' => $sms->sendAppointment($lead, $visitDate, $visitTime),
                    'thankyou' => $sms->sendThankYou($lead),
                    'promotion' => $sms->sendPromotion($lead),
                },
                'email' => match ($templateKey) {
                    'greeting' => $email->sendGreeting($lead, $lead->grade_applying_for ?? 'Grade 1', $academicYear),
                    'followup' => $email->sendFollowup($lead),
                    'appointment' => $email->sendAppointment($lead, $lead->grade_applying_for ?? 'Grade 1', $visitDate, $visitTime),
                    'thankyou' => $email->sendThankYou($lead),
                    'promotion' => $email->sendPromotion($lead, $academicYear),
                },
            };

            $isSuccess = ! empty($res['success']);
            if ($isSuccess) {
                $sentCount++;
            } else {
                $failedCount++;
            }

            $results[] = [
                'lead_id' => $lead->id,
                'name' => $lead->parent_name ?? 'Lead #'.$lead->id,
                'status' => $isSuccess ? 'sent' : 'failed',
                'error' => $res['error'] ?? ($res['message'] ?? null),
            ];
        }

        $channelLabel = match ($channel) {
            'whatsapp' => 'WhatsApp',
            'sms' => 'SMS',
            'email' => 'Email',
            default => ucfirst($channel),
        };

        return response()->json([
            'success' => $sentCount > 0,
            'message' => "Message successfully dispatched to {$sentCount} lead(s) via {$channelLabel}".($failedCount > 0 ? " ({$failedCount} failed)" : ''),
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
            'results' => $results,
        ]);
    }

    /**
     * Provide the template definitions and copy for preview.
     *
     * @return array<string, array<int, array<string, mixed>>>
     */
    protected function templateCatalog(): array
    {
        return [
            'WhatsApp' => [
                [
                    'key' => 'greeting',
                    'name' => 'Welcome Greeting',
                    'body' => "Hello {name}! 👋\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nThank you for your interest in admissions at NPS KGL.\n\nWe have successfully received your admission enquiry for {grade}.\n\nOur admission team will contact you shortly and guide you through the admission process.\n\nWe look forward to welcoming your child to NPS KGL!\n\nWarm regards,\nAdmissions Team\nNPS KGL",
                ],
                [
                    'key' => 'followup',
                    'name' => 'Follow-up Reminder',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nWe are following up on your admission enquiry.\n\nWe would be happy to assist you with the admission process and address any questions or concerns you may have.\n\nWould you like to connect with our Admissions Counsellor for further guidance?\n\nPlease reply to this message, and our team will be glad to assist you.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout (NPS KGL)",
                ],
                [
                    'key' => 'appointment',
                    'name' => 'Appointment Confirm',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nYour appointment for an admission enquiry has been successfully confirmed.\n\nAppointment Details:\n• Appointment Date: {visit_date}\n• Appointment Time: {visit_time}\n• Venue: NPS KGL Campus\n\nWe look forward to meeting you and assisting you with the admission process.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout",
                ],
                [
                    'key' => 'thankyou',
                    'name' => 'Thank You',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nThank you for visiting our campus and taking the time to explore our facilities and academic environment.\n\nWe hope your visit gave you a better understanding of our school and the learning opportunities we offer.\n\nWe look forward to the opportunity of welcoming your child to NPS KGL.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout",
                ],
                [
                    'key' => 'promotion',
                    'name' => 'Offer / Promotion',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nAdmissions are now open for the Academic Year {academic_year} from Early Years to Senior Grades.\n\nAt NPS KGL, we offer a comprehensive academic curriculum designed to foster academic excellence, critical thinking, values, and holistic development in a state-of-the-art campus environment.\n\nLimited seats are available across grades. We invite you to begin your child's journey with NPS KGL today.\n\nTo know more about the admission process, visit our campus or contact our Admissions Team.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout",
                ],
            ],
            'SMS' => [
                [
                    'key' => 'greeting',
                    'name' => 'Welcome Greeting',
                    'body' => 'Dear {name}, thank you for your admission enquiry at National Public School – Kempegowda Layout (NPS KGL) for {grade}. Your enquiry has been received successfully. Our admission team will contact you shortly. Thank you!',
                ],
                [
                    'key' => 'followup',
                    'name' => 'Follow-up Reminder',
                    'body' => 'Dear {name}, this is a gentle reminder regarding your admission enquiry at National Public School – Kempegowda Layout (NPS KGL). Our Admissions Team would be pleased to assist you with the admission process. Please feel free to contact us for further information.',
                ],
                [
                    'key' => 'appointment',
                    'name' => 'Appointment Confirm',
                    'body' => 'Dear {name}, your appointment regarding the admission enquiry at National Public School – Kempegowda Layout (NPS KGL) has been confirmed on {visit_date} at {visit_time}. We look forward to meeting you. – Admissions Team, NPS KGL',
                ],
                [
                    'key' => 'thankyou',
                    'name' => 'Thank You',
                    'body' => 'Dear {name}, thank you for visiting NPS KGL. We appreciate your interest in our school and hope you had a wonderful experience. We look forward to welcoming your child to NPS KGL. For any admission-related assistance, please contact our team. – Admissions Team, NPS KGL',
                ],
                [
                    'key' => 'promotion',
                    'name' => 'Offer / Promotion',
                    'body' => 'Admissions Open for {academic_year} at National Public School – Kempegowda Layout (NPS KGL). Explore world-class education for your child. Limited seats available. Contact Admissions today: admissions@npskgl.com.',
                ],
            ],
            'Email' => [
                [
                    'key' => 'greeting',
                    'name' => 'Welcome Greeting',
                    'subject' => 'Admission Enquiry Received – NPS KGL',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nThank you for your interest in admissions at NPS KGL. We are pleased to confirm that we have successfully received your admission enquiry.\n\nEnquiry Details:\n• Grade Applied For: {grade}\n• Academic Year: {academic_year}\n\nOur Admissions Team will contact you shortly to guide you through the admission process and provide further information about our academic programmes and campus facilities.\n\nThank you for considering NPS KGL for your child's educational journey.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout (NPS KGL)",
                ],
                [
                    'key' => 'followup',
                    'name' => 'Follow-up Reminder',
                    'subject' => 'Follow-up on Your Admission Enquiry – NPS KGL',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nWe are following up on your recent admission enquiry.\n\nWe understand that choosing the right school is an important decision. Our Admissions Team would be delighted to assist you with information regarding the admission process, grade availability, school facilities, and campus visits.\n\nIf you wish to proceed with the admission process or have any questions, please feel free to reply to this email or contact our Admissions Team.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout (NPS KGL)",
                ],
                [
                    'key' => 'appointment',
                    'name' => 'Appointment Confirm',
                    'subject' => 'Campus Visit Appointment Confirmed – NPS KGL',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nWe are pleased to confirm your appointment regarding the admission enquiry for your child.\n\nAppointment Details:\n• Grade Applied For: {grade}\n• Appointment Date: {visit_date}\n• Appointment Time: {visit_time}\n• Venue: National Public School – Kempegowda Layout Campus\n\nOur Admissions Team will be happy to guide you through the admission process, provide information about the academic programmes, and address any questions you may have.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout (NPS KGL)",
                ],
                [
                    'key' => 'thankyou',
                    'name' => 'Thank You',
                    'subject' => 'Thank You for Visiting NPS KGL',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nThank you for taking the time to visit our campus and learn more about our academic programmes, facilities, and learning environment.\n\nWe hope your visit was informative and helped you gain a better understanding of the opportunities and experiences we offer our students.\n\nIf you wish to proceed with the admission process, please feel free to get in touch with our Admissions Team.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout (NPS KGL)",
                ],
                [
                    'key' => 'promotion',
                    'name' => 'Offer / Promotion',
                    'subject' => 'Admissions Open {academic_year} – NPS KGL',
                    'body' => "Dear {name},\n\nGreetings from National Public School – Kempegowda Layout (NPS KGL)!\n\nWe are pleased to announce that admissions are now open for the Academic Year {academic_year} across all grades from Early Years to Senior School.\n\nWhy Choose NPS KGL?\n• Academic Excellence rooted in proven pedagogical methods\n• Holistic Development spanning sports, arts, and innovation\n• Modern Infrastructure & Safe Campus\n• Dedicated & Experienced Faculty\n\nAdmissions are strictly on a first-come, first-served basis subject to seat availability. We encourage you to secure your child's seat early.\n\nWarm regards,\nAdmissions Team\nNational Public School – Kempegowda Layout (NPS KGL)",
                ],
            ],
        ];
    }
}

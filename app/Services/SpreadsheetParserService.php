<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;

class SpreadsheetParserService
{
    /**
     * Parse spreadsheet file (CSV, XLSX, XLS) into headers and rows.
     *
     * @return array{headers: array<int, string>, rows: array<int, array<int, string>>}
     */
    public function parse(string $filePath, string $extension): array
    {
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestColumn = $worksheet->getHighestDataColumn();
            $highestRow = $worksheet->getHighestDataRow();

            if ($highestRow < 1) {
                return ['headers' => [], 'rows' => []];
            }

            /** @var array<int, array<int, mixed>> $data */
            $data = $worksheet->rangeToArray(
                'A1:'.$highestColumn.$highestRow,
                null,
                true,
                true,
                false
            );

            if (empty($data)) {
                return ['headers' => [], 'rows' => []];
            }

            $rawHeaders = array_shift($data) ?? [];
            $headers = [];
            $colCount = count($rawHeaders);

            for ($i = 0; $i < $colCount; $i++) {
                $val = trim((string) ($rawHeaders[$i] ?? ''));
                $headers[$i] = $val !== '' ? $val : 'Column '.($i + 1);
            }

            $rows = [];
            foreach ($data as $r) {
                $row = [];
                $hasData = false;
                for ($i = 0; $i < $colCount; $i++) {
                    $cellVal = trim((string) ($r[$i] ?? ''));
                    $row[$i] = $cellVal;
                    if ($cellVal !== '') {
                        $hasData = true;
                    }
                }
                if ($hasData) {
                    $rows[] = $row;
                }
            }

            return [
                'headers' => $headers,
                'rows' => $rows,
            ];
        } catch (Throwable) {
            // Fallback for CSV files
            if (strtolower($extension) === 'csv' || strtolower($extension) === 'txt') {
                return $this->parseCsvFallback($filePath);
            }

            return ['headers' => [], 'rows' => []];
        }
    }

    /**
     * Fallback CSV parser with delimiter auto-detection and BOM stripping.
     *
     * @return array{headers: array<int, string>, rows: array<int, array<int, string>>}
     */
    protected function parseCsvFallback(string $filePath): array
    {
        $handle = fopen($filePath, 'r');
        if (! $handle) {
            return ['headers' => [], 'rows' => []];
        }

        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $firstLine = fgets($handle);
        rewind($handle);
        if ($bom === "\xEF\xBB\xBF") {
            fseek($handle, 3);
        }

        $delimiter = ',';
        if ($firstLine !== false) {
            $semicolons = substr_count($firstLine, ';');
            $commas = substr_count($firstLine, ',');
            $tabs = substr_count($firstLine, "\t");

            if ($semicolons > $commas && $semicolons > $tabs) {
                $delimiter = ';';
            } elseif ($tabs > $commas && $tabs > $semicolons) {
                $delimiter = "\t";
            }
        }

        $headers = [];
        $rows = [];
        $isFirst = true;

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $cleanData = array_map(fn ($val) => trim((string) $val), $data);

            if (empty(array_filter($cleanData, fn ($v) => $v !== ''))) {
                continue;
            }

            if ($isFirst) {
                $headers = $cleanData;
                $isFirst = false;
            } else {
                $rows[] = $cleanData;
            }
        }

        fclose($handle);

        return ['headers' => $headers, 'rows' => $rows];
    }

    /**
     * Guess standard target field based on raw spreadsheet column header.
     */
    public function guessTarget(string $header): string
    {
        $s = strtolower(trim($header));

        if ($s === '' || preg_match('/^(sl[\s\._]*no|s\.no|serial|id|row|#)$/i', $s)) {
            return 'skip';
        }

        if (preg_match('/name|student|parent|candidate|customer/i', $s)) {
            return 'name';
        }

        if (preg_match('/phone|mobile|contact|whatsapp|cell/i', $s)) {
            return 'phone';
        }

        if (preg_match('/grade|admission for|class|standard|course|interested in|looking for/i', $s)) {
            return 'interested_in';
        }

        if (preg_match('/remark|note|comment|status|visit|feedback/i', $s)) {
            return 'remarks';
        }

        if (preg_match('/city|location|town|place|address|area/i', $s)) {
            return 'city';
        }

        if (preg_match('/mail/i', $s)) {
            return 'email';
        }

        if (preg_match('/time|call time|preferred time/i', $s)) {
            return 'preferred_time_to_call';
        }

        return 'skip';
    }

    /**
     * Clean and normalize a mobile phone number to standard 10 digits.
     */
    public function normalizePhone(?string $rawPhone): ?string
    {
        if (! $rawPhone) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $rawPhone);

        if (strlen($digits) >= 10) {
            $digits = substr($digits, -10);
        }

        if (strlen($digits) === 10 && in_array($digits[0], ['6', '7', '8', '9'], true)) {
            return $digits;
        }

        return $digits ?: null;
    }
}

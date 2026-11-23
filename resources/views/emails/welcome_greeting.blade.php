@extends('emails.layout')

@section('subject', 'Admission Enquiry Received – NPS KGL')

@section('content')
    <div class="greeting">Dear {{ $parentName ?? 'Parent/Guardian' }},</div>

    <p>Greetings from <strong>National Public School – Kempegowda Layout (NPS KGL)</strong>!</p>

    <p>Thank you for your interest in admissions at NPS KGL. We are pleased to confirm that we have successfully received your admission enquiry.</p>

    <div class="details-box">
        <div class="details-title">Enquiry Details</div>
        <div class="detail-row">
            <span class="detail-label">• Parent/Guardian Name:</span>
            <span class="detail-val">{{ $parentName ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">• Student Name:</span>
            <span class="detail-val">{{ $studentName ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">• Grade Applied For:</span>
            <span class="detail-val">{{ $grade ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">• Academic Year:</span>
            <span class="detail-val">{{ $academicYear ?? '2027-28' }}</span>
        </div>
    </div>

    <p>Our Admissions Team will contact you shortly to guide you through the admission process and provide further information about our academic programmes and campus facilities.</p>

    <p>Thank you for considering NPS KGL for your child's educational journey.</p>

    <div class="closing">
        Warm regards,<br>
        <strong>Admissions Team</strong><br>
        National Public School – Kempegowda Layout (NPS KGL)
    </div>
@endsection

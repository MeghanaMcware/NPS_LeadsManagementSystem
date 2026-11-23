@extends('emails.layout')

@section('subject', 'Campus Visit Appointment Confirmed – NPS KGL')

@section('content')
    <div class="greeting">Dear {{ $parentName ?? 'Parent/Guardian' }},</div>

    <p>Greetings from <strong>National Public School – Kempegowda Layout (NPS KGL)</strong>!</p>

    <p>We are pleased to confirm your appointment regarding the admission enquiry for your child.</p>

    <div class="details-box">
        <div class="details-title">Appointment Details</div>
        <div class="detail-row">
            <span class="detail-label">• Grade Applied For:</span>
            <span class="detail-val">{{ $grade ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">• Appointment Date:</span>
            <span class="detail-val"><strong>{{ $appointmentDate ?? 'To be scheduled' }}</strong></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">• Appointment Time:</span>
            <span class="detail-val"><strong>{{ $appointmentTime ?? 'To be scheduled' }}</strong></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">• Venue:</span>
            <span class="detail-val">National Public School – Kempegowda Layout Campus</span>
        </div>
    </div>

    <p>Our Admissions Team will be happy to guide you through the admission process, provide information about the academic programmes, and address any questions you may have.</p>

    <p>We kindly request you to arrive on time for your scheduled appointment.</p>

    <p>We look forward to welcoming you to our campus.</p>

    <div class="closing">
        Warm regards,<br>
        <strong>Admissions Team</strong><br>
        National Public School – Kempegowda Layout (NPS KGL)
    </div>
@endsection

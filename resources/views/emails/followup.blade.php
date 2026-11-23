@extends('emails.layout')

@section('subject', 'Follow-up on Your Admission Enquiry – NPS KGL')

@section('content')
    <div class="greeting">Dear {{ $parentName ?? 'Parent/Guardian' }},</div>

    <p>Greetings from <strong>National Public School – Kempegowda Layout (NPS KGL)</strong>!</p>

    <p>We are following up on your recent admission enquiry.</p>

    <p>We understand that choosing the right school is an important decision. Our Admissions Team would be delighted to assist you with information regarding the admission process, grade availability, school facilities, and campus visits.</p>

    <p>If you wish to proceed with the admission process or have any questions, please feel free to reply to this email or contact our Admissions Team. We will be happy to guide you through the next steps.</p>

    <p>We look forward to assisting you and welcoming your family to NPS KGL.</p>

    <div class="closing">
        Warm regards,<br>
        <strong>Admissions Team</strong><br>
        National Public School – Kempegowda Layout (NPS KGL)
    </div>
@endsection

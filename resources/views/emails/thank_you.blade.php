@extends('emails.layout')

@section('subject', 'Thank You for Visiting NPS KGL')

@section('content')
    <div class="greeting">Dear {{ $parentName ?? 'Parent/Guardian' }},</div>

    <p>Greetings from <strong>National Public School – Kempegowda Layout (NPS KGL)</strong>!</p>

    <p>Thank you for taking the time to visit our campus and learn more about our academic programmes, facilities, and learning environment.</p>

    <p>We hope your visit was informative and helped you gain a better understanding of the opportunities and experiences we offer our students.</p>

    <p>We would be delighted to assist you with any further questions regarding the admission process, grade availability, or other admission-related details.</p>

    <p>If you wish to proceed with the admission process, please feel free to get in touch with our Admissions Team.</p>

    <p>Thank you for considering NPS KGL for your child's educational journey. We look forward to staying connected with you.</p>

    <div class="closing">
        Warm regards,<br>
        <strong>Admissions Team</strong><br>
        National Public School – Kempegowda Layout (NPS KGL)
    </div>
@endsection

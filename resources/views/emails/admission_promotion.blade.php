@extends('emails.layout')

@section('subject', 'Admissions Open – National Public School KGL')

@section('content')
    <div class="greeting">Dear {{ $parentName ?? 'Parent/Guardian' }},</div>

    <p>Greetings from <strong>National Public School – Kempegowda Layout (NPS KGL)</strong>!</p>

    <p>We are delighted to announce that admissions are now open for the Academic Year <strong>{{ $academicYear ?? '2027-28' }}</strong>.</p>

    <p>At NPS KGL, we strive to provide students with a supportive learning environment that encourages academic excellence, personal growth, creativity, and holistic development.</p>

    <div class="details-box">
        <div class="details-title">Why Choose NPS KGL?</div>
        <div class="detail-row">• Quality education and academic excellence.</div>
        <div class="detail-row">• A supportive and engaging learning environment.</div>
        <div class="detail-row">• Opportunities for overall development.</div>
        <div class="detail-row">• Well-equipped campus facilities.</div>
    </div>

    <p>Our Admissions Team would be happy to guide you through the admission process and provide further information about grade availability and campus visits.</p>

    <p>To learn more or enquire about admissions, please get in touch with our team.</p>

    <div class="closing">
        Warm regards,<br>
        <strong>Admissions Team</strong><br>
        National Public School – Kempegowda Layout (NPS KGL)
    </div>
@endsection

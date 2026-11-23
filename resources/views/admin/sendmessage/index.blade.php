@extends('admin.layouts.app')

@section('title', 'Send Message')

@section('style')
<style>
    /* ---------- Send Message (all classes prefixed sm- to avoid clashes) ---------- */
    .sm {
        --sm-blue: #021b45;
        --sm-link: #1b5fd1;
        --sm-tint: #e3ecfb;
        --sm-ink: #1b2233;
        --sm-muted: #6b7a90;
        --sm-line: #dfe5ee;
        --sm-bg: #ffffff;
        --sm-soft: #eef2f8;
        --sm-green: #00996b;
        --sm-sms: #1b5fd1;
        --sm-mail: #c4452d;
        color: var(--sm-ink);
    }

    /* Stepper */
    .sm-steps { display: flex; flex-wrap: wrap; gap: 14px 40px; margin: 0 0 18px; padding: 0; list-style: none; }
    .sm-step { display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--sm-muted); }
    .sm-step b {
        width: 32px; height: 32px; border-radius: 50%; display: grid; place-items: center;
        background: #d6dde8; color: #fff; font-size: 13px;
    }
    .sm-step.is-on { color: var(--sm-ink); font-weight: 700; }
    .sm-step.is-on b { background: var(--sm-blue); }

    /* Layout */
    .sm-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; align-items: start; }
    .sm-card { background: var(--sm-bg); border: 1px solid var(--sm-line); border-radius: 16px; padding: 22px; }
    .sm-title { margin: 0; font-size: 17px; font-weight: 700; }
    .sm-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 16px; }
    .sm-label { margin: 22px 0 10px; font-size: 14px; font-weight: 700; }
    .sm-cap { margin: 20px 0 10px; font-size: 11.5px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: var(--sm-muted); }
    .sm-side { display: grid; gap: 18px; }

    .sm-btn {
        border: 1px solid var(--sm-line); background: #fff; color: var(--sm-ink);
        height: 44px; padding: 0 20px; border-radius: 10px; font-size: 14px; font-weight: 700;
        cursor: pointer; white-space: nowrap; transition: background .15s, opacity .15s;
    }
    .sm-btn:hover:not(:disabled) { background: #f3f6fb; }
    .sm-btn:focus-visible, .sm-tpl:focus-visible, .sm-via button:focus-visible,
    .sm-remove:focus-visible { outline: 3px solid rgba(2,27,69,.28); outline-offset: 2px; }
    .sm-btn:disabled { opacity: .5; cursor: not-allowed; }
    .sm-btn-sm { height: 38px; padding: 0 16px; font-size: 13px; }
    .sm-btn-primary { background: var(--sm-blue); border-color: var(--sm-blue); color: #fff; width: 100%; height: 50px; }
    .sm-btn-primary:hover:not(:disabled) { background: #0a2d68; }
    .sm-btn-block { width: 100%; height: 48px; }

    /* Selected leads */
    .sm-lead-scroll { max-height: 290px; overflow-y: auto; padding-right: 4px; }
    .sm-lead {
        display: flex; align-items: center; gap: 14px;
        background: var(--sm-soft); border-radius: 12px; padding: 12px 14px; margin-bottom: 10px;
    }
    .sm-avatar {
        width: 38px; height: 38px; border-radius: 50%; flex: none; display: grid; place-items: center;
        background: #b3cffa; color: var(--sm-link); font-weight: 700; font-size: 14px;
    }
    .sm-lead-info { flex: 1; min-width: 0; }
    .sm-lead-info strong { display: block; font-size: 14px; }
    .sm-lead-info small { color: var(--sm-muted); font-size: 12px; }
    .sm-remove {
        border: 0; background: transparent; color: var(--sm-muted); font-size: 16px; line-height: 1;
        padding: 6px 8px; border-radius: 6px; cursor: pointer;
    }
    .sm-remove:hover { background: #dde4ef; color: var(--sm-ink); }
    .sm-empty { padding: 22px 12px; text-align: center; font-size: 13.5px; color: var(--sm-muted); background: var(--sm-soft); border-radius: 12px; }

    /* Send via */
    .sm-via { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .sm-via button {
        height: 44px; border: 1px solid var(--sm-line); background: #fff; color: var(--sm-ink);
        border-radius: 10px; font-size: 13.5px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 0 6px; transition: all .15s ease;
    }
    .sm-via button:hover:not(.is-on) { background: #f8fafc; border-color: #cbd5e1; }
    .sm-via button.is-on { background: var(--sm-tint); border-color: var(--sm-link); color: var(--sm-link); font-weight: 700; }

    /* Template column */
    .sm-select {
        width: 100%; height: 48px; padding: 0 40px 0 16px; border: 1px solid var(--sm-line); border-radius: 10px;
        background-color: #fff; font-size: 14px; font-weight: 700; color: var(--sm-ink); cursor: pointer;
        appearance: none; -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1.5l5 5 5-5' fill='none' stroke='%231b2233' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 16px center;
    }
    .sm-select:focus { outline: 3px solid rgba(2,27,69,.16); border-color: var(--sm-blue); }
    .sm-tpls { display: grid; gap: 10px; }
    .sm-tpl {
        width: 100%; height: 48px; text-align: left; padding: 0 16px; border: 1px solid var(--sm-line);
        border-radius: 10px; background: #fff; font-size: 14px; color: var(--sm-ink); cursor: pointer;
    }
    .sm-tpl:hover { background: #fafbfd; }
    .sm-tpl.is-on { background: var(--sm-tint); border-color: var(--sm-link); color: var(--sm-link); font-weight: 700; }
    .sm-edit { margin-top: 26px; }

    /* Preview */
    .sm-preview { background: #e4efe6; border-color: #d3e4d7; text-align: center; transition: background .2s, border-color .2s; }
    .sm-preview[data-ch="SMS"]   { background: #e6eefb; border-color: #d2def3; }
    .sm-preview[data-ch="Email"] { background: #fbece8; border-color: #f0d6cf; }
    .sm-preview .sm-title { margin-bottom: 16px; }
    .sm-phone {
        background: #fff; border: 2px solid #c3ccd9; border-radius: 26px 26px 34px 34px;
        padding: 0 0 22px; min-height: 380px; overflow: hidden; text-align: left;
    }
    .sm-phone-bar {
        margin: 0 -2px; padding: 15px 10px; background: var(--sm-green); color: #fff;
        text-align: center; font-size: 14px; font-weight: 700; border-radius: 24px;
    }
    .sm-preview[data-ch="SMS"]   .sm-phone-bar { background: var(--sm-sms); }
    .sm-preview[data-ch="Email"] .sm-phone-bar { background: var(--sm-mail); }
    .sm-bubble {
        margin: 24px 14px 0; padding: 14px 16px 8px; background: #d0f5c8; border-radius: 14px;
        font-size: 13px; line-height: 1.55; color: #111b21; word-break: break-word;
    }
    .sm-preview[data-ch="SMS"]   .sm-bubble { background: #dce8fb; }
    .sm-preview[data-ch="Email"] .sm-bubble { background: #f6f7f9; border: 1px solid #e3e7ee; }
    .sm-bubble .sm-subject { display: block; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #e3e7ee; font-weight: 700; }
    .sm-bubble p { margin: 0 0 4px; }
    .sm-time { display: block; text-align: right; font-size: 10.5px; color: #6b7a90; margin-top: 6px; }

    /* Actions (under preview) */
    .sm-actions { display: grid; gap: 12px; }
    .sm-actions-note { margin: 0; font-size: 12.5px; color: var(--sm-muted); text-align: center; }

    /* Dialogs */
    .sm-overlay {
        position: fixed; inset: 0; z-index: 2000; background: rgba(20,28,45,.45);
        display: none; align-items: center; justify-content: center; padding: 16px;
    }
    .sm-overlay.is-open { display: flex; }
    .sm-dialog { background: #fff; width: 100%; max-width: 720px; border-radius: 16px; padding: 24px; box-shadow: 0 20px 50px rgba(0,0,0,.25); }
    .sm-dialog h5 { margin: 0 0 4px; font-size: 18px; font-weight: 700; }
    .sm-dialog .sm-sub { margin: 0 0 16px; font-size: 13px; color: var(--sm-muted); }
    .sm-pick { max-height: 280px; overflow-y: auto; margin: 0 -4px 6px; padding: 0 4px; }
    .sm-pick label {
        display: flex; align-items: center; gap: 12px; padding: 10px 12px; margin: 0 0 8px;
        background: var(--sm-soft); border-radius: 10px; cursor: pointer;
    }
    .sm-pick input { width: 18px; height: 18px; accent-color: var(--sm-blue); flex: none; }
    .sm-foot { display: flex; justify-content: flex-end; gap: 10px; margin-top: 16px; }
    .sm-field { margin-bottom: 14px; }
    .sm-field label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px; }
    .sm-field input { width: 100%; height: 44px; padding: 0 12px; border: 1px solid #00000045; border-radius: 10px; font-size: 14px; }
    .sm-field input:focus { outline: 3px solid rgba(2,27,69,.16); border-color: var(--sm-blue); }
    .sm-err { display: none; font-size: 12.5px; color: #c62828; margin: -4px 0 10px; }
    .sm-err.is-on { display: block; }
    .sm-btn-dark { background: #021b45; border-color: #021b45; color: #fff; }
    .sm-btn-dark:hover:not(:disabled) { background: #0a2d68; }

    /* Toast */
    .sm-toast {
        position: fixed; right: 20px; bottom: 20px; z-index: 2100; max-width: 340px;
        background: var(--sm-ink); color: #fff; padding: 12px 18px; border-radius: 10px; font-size: 14px;
        opacity: 0; transform: translateY(10px); transition: opacity .25s, transform .25s; pointer-events: none;
    }
    .sm-toast.is-show { opacity: 1; transform: none; }

    @media (max-width: 1199.98px) { .sm-grid { grid-template-columns: 1fr 1fr; } .sm-side { grid-column: 1 / -1; } }
    @media (max-width: 767.98px) { .sm-grid { grid-template-columns: 1fr; } .sm-steps { gap: 12px 24px; } }
    @media (prefers-reduced-motion: reduce) { .sm-toast, .sm-preview { transition: none; } }
</style>
@endsection

@section('content')
<div class="">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Send Message</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Send Message</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="sm">

        {{-- Stepper --}}
        <ol class="sm-steps" id="smSteps">
            <li class="sm-step is-on" data-step="1"><b>1</b> Select leads</li>
            <li class="sm-step is-on" data-step="2"><b>2</b> Choose template</li>
            <li class="sm-step" data-step="3"><b>3</b> Preview &amp; send</li>
        </ol>

        <div class="sm-grid mb-3">

            {{-- ============ 1. SELECTED LEADS ============ --}}
            <section class="sm-card" aria-labelledby="smLeadsTitle">
                <div class="sm-head">
                    <h5 class="sm-title" id="smLeadsTitle">1. Selected leads (<span id="smCount">0</span>)</h5>
                    <button type="button" class="sm-btn sm-btn-sm" id="smAddMore">+ Add more</button>
                </div>

                <div class="sm-lead-scroll" id="smLeadList"></div>

                <h6 class="sm-label">Send via</h6>
                <div class="sm-via" id="smVia" role="radiogroup" aria-label="Send via">
                    <button type="button" class="is-on" role="radio" aria-checked="true" data-ch="WhatsApp"><i class="bi bi-whatsapp"></i> WhatsApp</button>
                    <button type="button" role="radio" aria-checked="false" data-ch="SMS"><i class="bi bi-chat-dots"></i> SMS</button>
                    <button type="button" role="radio" aria-checked="false" data-ch="Email"><i class="bi bi-envelope"></i> Email</button>
                </div>
            </section>

            {{-- ============ 2. CHOOSE TEMPLATE ============ --}}
            <section class="sm-card" aria-labelledby="smTplTitle">
                <h5 class="sm-title" id="smTplTitle" style="margin-bottom:16px;">2. Choose template</h5>

                <select class="sm-select" id="smTplSelect" aria-label="Template"></select>

                <div class="sm-cap" id="smTplCap">WhatsApp templates</div>
                <div class="sm-tpls" id="smTpls" role="radiogroup" aria-label="Templates"></div>

                {{-- Appointment Date & Time Picker (visible when Appointment Confirm is chosen) --}}
                <div id="smApptBox" style="display: none; margin-top: 16px; padding: 14px 16px; background: var(--sm-soft); border-radius: 12px; border: 1px solid var(--sm-line);">
                    <div style="font-size: 13px; font-weight: 700; margin-bottom: 8px; color: var(--sm-blue); display: flex; align-items: center; gap: 6px;">
                        <i class="bi bi-calendar-event"></i> Campus Visit Appointment Details
                    </div>
                    <div class="row g-2">
                        <div class="col-7">
                            <label for="smApptDate" style="font-size: 11.5px; font-weight: 600; color: var(--sm-muted); margin-bottom: 3px; display: block;">Visit Date</label>
                            <input type="date" id="smApptDate" class="form-control form-control-sm" style="border-radius: 8px;">
                        </div>
                        <div class="col-5">
                            <label for="smApptTime" style="font-size: 11.5px; font-weight: 600; color: var(--sm-muted); margin-bottom: 3px; display: block;">Visit Time</label>
                            <input type="time" id="smApptTime" class="form-control form-control-sm" value="10:30" style="border-radius: 8px;">
                        </div>
                    </div>
                    <small style="display: block; font-size: 11px; color: var(--sm-muted); margin-top: 6px;">
                        These values automatically populate the template preview and variables sent to parents.
                    </small>
                </div>

                <a href="{{ route('leads.index') }}" class="sm-btn sm-btn-block sm-edit text-center text-decoration-none d-flex align-items-center justify-content-center" id="smEdit">Back to Leads</a>
            </section>

            {{-- ============ 3. PREVIEW + ACTION BUTTONS ============ --}}
            <div class="sm-side">
                <section class="sm-card sm-preview" id="smPreviewCard" data-ch="WhatsApp" aria-labelledby="smPrevTitle">
                    <h5 class="sm-title" id="smPrevTitle">3. Preview</h5>
                    <div class="sm-phone">
                        <div class="sm-phone-bar" id="smPhoneBar">NPS KGL WhatsApp</div>
                        <div class="sm-bubble" id="smBubble"></div>
                    </div>
                </section>

                <div class="sm-card sm-actions">
                    <button type="button" class="sm-btn sm-btn-primary" id="smSend">Send now</button>
                    <button type="button" class="sm-btn sm-btn-block" id="smSchedule">Schedule for later</button>
                    <p class="sm-actions-note" id="smActionNote"></p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add more leads dialog --}}
<div class="sm-overlay" id="smAddOverlay" aria-hidden="true">
    <div class="sm-dialog" role="dialog" aria-modal="true" aria-labelledby="smAddTitle">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h5 id="smAddTitle" class="m-0">Add more leads</h5>
            <span class="badge bg-light text-dark" id="smPoolCount">0 available</span>
        </div>
        <p class="sm-sub">Pick from registered leads to include in this broadcast.</p>
        <div class="mb-3">
            <input type="text" id="smSearchLead" class="form-control" placeholder="Search by name, mobile, or grade..." style="height:42px; border-radius:10px; font-size:13.5px;">
        </div>
        <div class="sm-pick" id="smPick"></div>
        <div class="sm-foot">
            <button type="button" class="sm-btn sm-btn-sm" id="smAddCancel">Cancel</button>
            <button type="button" class="sm-btn sm-btn-sm sm-btn-dark" id="smAddConfirm">Add selected</button>
        </div>
    </div>
</div>

{{-- Schedule dialog --}}
<div class="sm-overlay" id="smSchedOverlay" aria-hidden="true">
    <div class="sm-dialog" role="dialog" aria-modal="true" aria-labelledby="smSchedTitle">
        <h5 id="smSchedTitle">Schedule for later</h5>
        <p class="sm-sub" id="smSchedSub"></p>
        <div class="sm-field">
            <label for="smDate">Date</label>
            <input type="date" id="smDate">
        </div>
        <div class="sm-field">
            <label for="smTime">Time</label>
            <input type="time" id="smTime" value="10:00">
        </div>
        <div class="sm-err" id="smSchedErr" role="alert">Choose a date and time in the future.</div>
        <div class="sm-foot">
            <button type="button" class="sm-btn sm-btn-sm" id="smSchedCancel">Cancel</button>
            <button type="button" class="sm-btn sm-btn-sm sm-btn-dark" id="smSchedConfirm">Schedule</button>
        </div>
    </div>
</div>

<div class="sm-toast" id="smToast" role="status" aria-live="polite"></div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    @php
        $jsLeads = $leads->map(function ($l) use ($selectedIds) {
            return [
                'id' => $l->id,
                'name' => $l->parent_name ?: 'Lead #' . $l->id,
                'phone' => $l->mobile_number ?: 'N/A',
                'email' => $l->email ?: 'N/A',
                'grade' => $l->grade_applying_for ?: 'Grade 1',
                'on' => in_array($l->id, $selectedIds, true),
            ];
        })->values();
    @endphp

    var leads = @json($jsLeads);
    var templates = @json($templates);
    var dispatchUrl = "{{ route('messages.send.dispatch') }}";
    var csrfToken = "{{ csrf_token() }}";

    var barTitle = {
        WhatsApp: 'NPS KGL WhatsApp',
        SMS: 'NPS KGL SMS',
        Email: 'NPS KGL Email'
    };

    // State: WhatsApp is default channel, greeting is default template
    var state = {
        channel: 'WhatsApp',
        templateKey: (templates.WhatsApp && templates.WhatsApp[0]) ? templates.WhatsApp[0].key : 'greeting',
        sent: false
    };

    var $ = function (id) { return document.getElementById(id); };

    function esc(s) {
        return String(s || '').replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function selected() {
        return leads.filter(function (l) { return l.on; });
    }

    function currentList() {
        return templates[state.channel] || [];
    }

    function currentTemplate() {
        var list = currentList();
        for (var i = 0; i < list.length; i++) {
            if (list[i].key === state.templateKey) return list[i];
        }
        return list[0] || { key: 'greeting', name: 'Welcome Greeting', body: '' };
    }

    var toastTimer;
    function toast(msg) {
        var t = $('smToast');
        if (!t) return;
        t.textContent = msg;
        t.classList.add('is-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { t.classList.remove('is-show'); }, 2800);
    }

    function notify(title, text, icon) {
        if (window.Swal) {
            Swal.fire({
                icon: icon || 'success',
                title: title,
                text: text,
                confirmButtonColor: '#021b45'
            });
        } else {
            toast(title + ' - ' + text);
        }
    }

    function pad(x) { return (x < 10 ? '0' : '') + x; }

    var apptDateInput = $('smApptDate');
    var apptTimeInput = $('smApptTime');
    if (apptDateInput) {
        var defaultApptDate = new Date();
        defaultApptDate.setDate(defaultApptDate.getDate() + 2);
        apptDateInput.value = defaultApptDate.getFullYear() + '-' + pad(defaultApptDate.getMonth() + 1) + '-' + pad(defaultApptDate.getDate());
        apptDateInput.min = (new Date()).toISOString().split('T')[0];
        apptDateInput.addEventListener('input', function () { renderPreview(); });
    }
    if (apptTimeInput) {
        apptTimeInput.addEventListener('input', function () { renderPreview(); });
    }

    function getFormattedAppointment() {
        var rawDate = apptDateInput ? apptDateInput.value : '';
        var rawTime = apptTimeInput ? apptTimeInput.value : '10:30';

        var formattedDate = '28 Nov 2026';
        if (rawDate) {
            var parts = rawDate.split('-');
            if (parts.length === 3) {
                var dObj = new Date(parseInt(parts[0], 10), parseInt(parts[1], 10) - 1, parseInt(parts[2], 10));
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                formattedDate = pad(dObj.getDate()) + ' ' + months[dObj.getMonth()] + ' ' + dObj.getFullYear();
            }
        }

        var formattedTime = '10:30 AM';
        if (rawTime) {
            var tParts = rawTime.split(':');
            var hours = parseInt(tParts[0], 10);
            var mins = tParts[1] || '00';
            var ampm = hours >= 12 ? 'PM' : 'AM';
            var h12 = hours % 12;
            if (h12 === 0) h12 = 12;
            formattedTime = (h12 < 10 ? '0' + h12 : h12) + ':' + mins + ' ' + ampm;
        }

        return { date: formattedDate, time: formattedTime };
    }

    /* ---------------- Render: template column ---------------- */
    function renderTemplates() {
        var list = currentList();
        $('smTplCap').textContent = state.channel + ' templates';

        $('smTplSelect').innerHTML = list.map(function (t) {
            return '<option value="' + esc(t.key) + '"' + (t.key === state.templateKey ? ' selected' : '') + '>' + esc(t.name) + '</option>';
        }).join('');

        $('smTpls').innerHTML = list.map(function (t) {
            var on = t.key === state.templateKey;
            return '<button type="button" class="sm-tpl' + (on ? ' is-on' : '') + '" role="radio" aria-checked="' + on +
                '" data-key="' + esc(t.key) + '">' + esc(t.name) + '</button>';
        }).join('');

        var apptBox = $('smApptBox');
        if (apptBox) {
            apptBox.style.display = (state.templateKey === 'appointment') ? 'block' : 'none';
        }
    }

    /* ---------------- Render: preview ---------------- */
    function fill(text, lead) {
        if (!text) return '';
        var name = lead && lead.name ? lead.name : 'Parent';
        var phone = lead && lead.phone ? lead.phone : '+91 99648 27788';
        var grade = lead && lead.grade ? lead.grade : 'Grade 1';
        var appt = getFormattedAppointment();
        var academicYear = '2026-2027';

        return text
            .replace(/\{name\}/g, name)
            .replace(/\{phone\}/g, phone)
            .replace(/\{grade\}/g, grade)
            .replace(/\{visit_date\}/g, appt.date)
            .replace(/\{visit_time\}/g, appt.time)
            .replace(/\{academic_year\}/g, academicYear);
    }

    function renderPreview() {
        var t = currentTemplate();
        var lead = selected()[0] || (leads.length ? leads[0] : null);
        var d = new Date();
        var time = (d.getHours() < 10 ? '0' : '') + d.getHours() + ':' + (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();

        $('smPreviewCard').setAttribute('data-ch', state.channel);
        $('smPhoneBar').textContent = barTitle[state.channel] || 'Preview';

        var html = '';
        if (state.channel === 'Email' && t.subject) {
            html += '<span class="sm-subject">' + esc(fill(t.subject, lead)) + '</span>';
        }
        html += '<p>' + esc(fill(t.body, lead)).replace(/\n/g, '<br>') + '</p>';
        html += '<span class="sm-time">' + time + '</span>';
        $('smBubble').innerHTML = html;
    }

    /* ---------------- Render: leads list & buttons ---------------- */
    function render() {
        var sel = selected();
        var n = sel.length;

        $('smCount').textContent = n;
        $('smLeadList').innerHTML = n ? sel.map(function (l) {
            var initial = (l.name || 'L').trim().charAt(0).toUpperCase();
            return '<div class="sm-lead" data-id="' + l.id + '">' +
                '<span class="sm-avatar" aria-hidden="true">' + esc(initial) + '</span>' +
                '<div class="sm-lead-info"><strong>' + esc(l.name) + '</strong><small>' + esc(l.phone) + (l.grade ? ' • ' + esc(l.grade) : '') + '</small></div>' +
                '<button type="button" class="sm-remove" aria-label="Remove ' + esc(l.name) + '">&times;</button></div>';
        }).join('') : '<div class="sm-empty">No leads selected. Click "+ Add more" to select leads.</div>';

        var send = $('smSend');
        send.disabled = n === 0;
        send.textContent = n === 0 ? 'Select leads to send' : 'Send to ' + n + (n === 1 ? ' lead now' : ' leads now');
        $('smSchedule').disabled = n === 0;

        var t = currentTemplate();
        $('smActionNote').textContent = n ? 'Via ' + state.channel + ' — ' + t.name : '';

        // Stepper: 1 = leads selected, 2 = template chosen, 3 = dispatched
        var s1 = n > 0, s2 = s1 && !!state.templateKey, s3 = s2 && state.sent;
        [s1, s2, s3].forEach(function (on, i) {
            var el = document.querySelector('#smSteps [data-step="' + (i + 1) + '"]');
            if (el) el.classList.toggle('is-on', on);
        });

        renderPreview();
    }

    // Remove lead from selected list
    $('smLeadList').addEventListener('click', function (e) {
        var btn = e.target.closest('.sm-remove');
        if (!btn) return;
        var leadEl = btn.closest('.sm-lead');
        if (!leadEl) return;
        var id = parseInt(leadEl.dataset.id, 10);
        leads.forEach(function (l) { if (l.id === id) l.on = false; });
        state.sent = false;
        render();
    });

    /* ---------------- Add more leads dialog ---------------- */
    function openOverlay(el) { el.classList.add('is-open'); el.setAttribute('aria-hidden', 'false'); }
    function closeOverlay(el) { el.classList.remove('is-open'); el.setAttribute('aria-hidden', 'true'); }
    var addOv = $('smAddOverlay'), schedOv = $('smSchedOverlay');

    function renderPicker(filterText) {
        var pool = leads.filter(function (l) { return !l.on; });
        if (filterText) {
            var q = filterText.toLowerCase();
            pool = pool.filter(function (l) {
                return (l.name && l.name.toLowerCase().indexOf(q) !== -1) ||
                       (l.phone && l.phone.toLowerCase().indexOf(q) !== -1) ||
                       (l.grade && l.grade.toLowerCase().indexOf(q) !== -1);
            });
        }

        $('smPoolCount').textContent = pool.length + ' available';

        $('smPick').innerHTML = pool.length ? pool.map(function (l) {
            return '<label><input type="checkbox" value="' + l.id + '"> <span class="sm-lead-info"><strong>' +
                esc(l.name) + '</strong><small>' + esc(l.phone) + (l.grade ? ' • ' + esc(l.grade) : '') + '</small></span></label>';
        }).join('') : '<div class="sm-empty">' + (leads.every(function (l) { return l.on; }) ? 'All leads are already selected.' : 'No matching leads found.') + '</div>';
    }

    $('smAddMore').addEventListener('click', function () {
        var searchInput = $('smSearchLead');
        if (searchInput) searchInput.value = '';
        renderPicker('');
        openOverlay(addOv);
    });

    $('smSearchLead').addEventListener('input', function () {
        renderPicker(this.value.trim());
    });

    $('smAddCancel').addEventListener('click', function () { closeOverlay(addOv); });
    $('smAddConfirm').addEventListener('click', function () {
        var ids = Array.prototype.map.call($('smPick').querySelectorAll('input:checked'), function (c) {
            return parseInt(c.value, 10);
        });
        leads.forEach(function (l) {
            if (ids.indexOf(l.id) !== -1) l.on = true;
        });
        closeOverlay(addOv);
        if (ids.length) {
            state.sent = false;
            render();
            toast(ids.length + (ids.length === 1 ? ' lead added' : ' leads added'));
        }
    });

    /* ---------------- Channel switcher (WhatsApp / SMS / Email) ---------------- */
    $('smVia').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-ch]');
        if (!b || b.dataset.ch === state.channel) return;

        state.channel = b.dataset.ch;
        var list = currentList();
        state.templateKey = list.length ? list[0].key : 'greeting';
        state.sent = false;

        this.querySelectorAll('button').forEach(function (x) {
            var on = x === b;
            x.classList.toggle('is-on', on);
            x.setAttribute('aria-checked', String(on));
        });

        renderTemplates();
        render();
    });

    /* ---------------- Template selection ---------------- */
    function setTemplate(key) {
        state.templateKey = key;
        state.sent = false;
        $('smTplSelect').value = key;
        document.querySelectorAll('#smTpls .sm-tpl').forEach(function (b) {
            var on = b.dataset.key === key;
            b.classList.toggle('is-on', on);
            b.setAttribute('aria-checked', String(on));
        });
        var apptBox = $('smApptBox');
        if (apptBox) {
            apptBox.style.display = (key === 'appointment') ? 'block' : 'none';
        }
        render();
    }

    $('smTpls').addEventListener('click', function (e) {
        var b = e.target.closest('.sm-tpl');
        if (b && b.dataset.key) setTemplate(b.dataset.key);
    });

    $('smTplSelect').addEventListener('change', function () {
        setTemplate(this.value);
    });

    /* ---------------- Real API Dispatch: Send now ---------------- */
    $('smSend').addEventListener('click', function () {
        var btn = this;
        var sel = selected();
        var n = sel.length;
        if (!n) {
            toast('Please select at least one lead.');
            return;
        }

        var leadIds = sel.map(function (l) { return l.id; });
        var tpl = currentTemplate();
        var appt = getFormattedAppointment();

        btn.disabled = true;
        var prevText = btn.textContent;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Sending...';

        fetch(dispatchUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                channel: state.channel,
                template_key: tpl.key,
                lead_ids: leadIds,
                academic_year: '2026-2027',
                visit_date: appt.date,
                visit_time: appt.time
            })
        })
        .then(function (res) {
            return res.json().then(function (data) {
                return { status: res.status, ok: res.ok, body: data };
            });
        })
        .then(function (response) {
            btn.disabled = false;
            btn.textContent = prevText;
            var data = response.body;

            if (response.ok && data.success) {
                state.sent = true;
                render();
                notify('Message Dispatched', data.message || 'Messages were sent successfully.', 'success');
            } else {
                notify('Dispatch Error', data.message || 'Failed to dispatch messages.', 'error');
            }
        })
        .catch(function (err) {
            btn.disabled = false;
            btn.textContent = prevText;
            notify('Network Error', 'Could not connect to the server to send messages.', 'error');
        });
    });

    /* ---------------- Schedule for later ---------------- */
    function pad(x) { return (x < 10 ? '0' : '') + x; }
    $('smSchedule').addEventListener('click', function () {
        var n = selected().length;
        var d = new Date();
        var today = d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
        $('smDate').min = today;
        if (!$('smDate').value) $('smDate').value = today;
        var t = currentTemplate();
        $('smSchedSub').textContent = n + (n === 1 ? ' lead' : ' leads') + ' via ' + state.channel + ' — ' + t.name;
        $('smSchedErr').classList.remove('is-on');
        openOverlay(schedOv);
    });

    $('smSchedCancel').addEventListener('click', function () { closeOverlay(schedOv); });
    $('smSchedConfirm').addEventListener('click', function () {
        var date = $('smDate').value, time = $('smTime').value;
        var when = date && time ? new Date(date + 'T' + time) : null;
        if (!when || isNaN(when.getTime()) || when.getTime() <= Date.now()) {
            $('smSchedErr').classList.add('is-on');
            return;
        }
        closeOverlay(schedOv);
        state.sent = true;
        render();
        notify('Message Scheduled', 'Broadcast scheduled for ' + when.toLocaleString([], { dateStyle: 'medium', timeStyle: 'short' }) + '.', 'info');
    });

    /* ---------------- Modal dismissal ---------------- */
    [addOv, schedOv].forEach(function (ov) {
        ov.addEventListener('click', function (e) { if (e.target === ov) closeOverlay(ov); });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeOverlay(addOv); closeOverlay(schedOv); }
    });

    /* ---------------- Initial boot ---------------- */
    renderTemplates();
    render();
})();
</script>
@endpush

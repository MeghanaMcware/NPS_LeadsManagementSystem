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
    .sm-via { display: flex; flex-wrap: wrap; gap: 10px; }
    .sm-via button {
        flex: 1 1 90px; height: 44px; border: 1px solid var(--sm-line); background: #fff; color: var(--sm-ink);
        border-radius: 10px; font-size: 14px; cursor: pointer;
    }
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
        position: fixed; right: 20px; bottom: 20px; z-index: 2100; max-width: 320px;
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
                        <li class="breadcrumb-item"><a href=""><i class="bi bi-house"></i></a></li>
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
                    <h5 class="sm-title" id="smLeadsTitle">1. Selected leads (<span id="smCount">3</span>)</h5>
                    <button type="button" class="sm-btn sm-btn-sm" id="smAddMore">+ Add more</button>
                </div>

                <div id="smLeadList"></div>

                <h6 class="sm-label">Send via</h6>
                <div class="sm-via" id="smVia" role="radiogroup" aria-label="Send via">
                    <button type="button" class="is-on" role="radio" aria-checked="true" data-ch="WhatsApp">WhatsApp</button>
                    <button type="button" role="radio" aria-checked="false" data-ch="SMS">SMS</button>
                    <button type="button" role="radio" aria-checked="false" data-ch="Email">Email</button>
                </div>
            </section>

            {{-- ============ 2. CHOOSE TEMPLATE (changes with "Send via") ============ --}}
            <section class="sm-card" aria-labelledby="smTplTitle">
                <h5 class="sm-title" id="smTplTitle" style="margin-bottom:16px;">2. Choose template</h5>

                <select class="sm-select" id="smTplSelect" aria-label="Template"></select>

                <div class="sm-cap" id="smTplCap">WhatsApp templates</div>
                <div class="sm-tpls" id="smTpls" role="radiogroup" aria-label="Templates"></div>


                <button type="button" class="sm-btn sm-btn-block sm-edit" id="smEdit">Edit templates</button>
            </section>

            {{-- ============ 3. PREVIEW + ACTION BUTTONS ============ --}}
            <div class="sm-side">
                <section class="sm-card sm-preview" id="smPreviewCard" data-ch="WhatsApp" aria-labelledby="smPrevTitle">
                    <h5 class="sm-title" id="smPrevTitle">3. Preview</h5>
                    <div class="sm-phone">
                        <div class="sm-phone-bar" id="smPhoneBar">NPS Digital</div>
                        <div class="sm-bubble" id="smBubble"></div>
                    </div>
                </section>

                <div class="sm-card sm-actions">
                    <button type="button" class="sm-btn sm-btn-primary" id="smSend">Send to 3 leads now</button>
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
        <h5 id="smAddTitle">Add more leads</h5>
        <p class="sm-sub">Pick the leads you want to message.</p>
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

    /* ---------------- Static data ---------------- */
    var leads = [
        { id: 1, name: 'Rahul Verma',  phone: '+91 98450 11223', on: true  },
        { id: 2, name: 'Anita Desai',  phone: '+91 99001 55678', on: true  },
        { id: 3, name: 'Mohan Kumar',  phone: '+91 96321 88470', on: true  },
        { id: 4, name: 'Sneha Iyer',   phone: '+91 98860 77123', on: false },
        { id: 5, name: 'Karthik R',    phone: '+91 97420 33410', on: false },
        { id: 6, name: 'Divya Nair',   phone: '+91 90350 66412', on: false },
        { id: 7, name: 'Suresh Babu',  phone: '+91 99720 18854', on: false },
        { id: 8, name: 'Lakshmi Rao',  phone: '+91 98450 90017', on: false },
        { id: 9, name: 'Imran Pasha',  phone: '+91 96320 44705', on: false }
    ];

    // Templates for each "Send via" channel. Email templates also have a subject.
    var templates = {
        WhatsApp: [
            { name: 'Welcome Greeting',    body: 'Hi {name},\nThank you for your interest in NPS Digital! I\'m {owner}.\nHow can I help you today?\n\n- Team NPS' },
            { name: 'Follow-up Reminder',  body: 'Hi {name},\nJust checking in about the {course} course. Would you like to talk this week?\n\n- {owner}, Team NPS' },
            { name: 'Appointment Confirm', body: 'Hi {name},\nYour counselling session is confirmed. Reply YES to confirm or RESCHEDULE to change the time.\n\n- {owner}, Team NPS' },
            { name: 'Thank You',           body: 'Hi {name},\nThank you for connecting with NPS Digital. We are happy to help you with {course}.\n\n- Team NPS' },
            { name: 'Offer / Promotion',   body: 'Hi {name},\nGood news! Enrol in {course} this month and get a special discount.\nReply to this message to know more.\n\n- {owner}, Team NPS' }
        ],
        SMS: [
            { name: 'Welcome Greeting',    body: 'Hi {name}, thanks for your interest in NPS Digital. I\'m {owner}. Call us on {phone} anytime.' },
            { name: 'Follow-up Reminder',  body: 'Hi {name}, a quick reminder about the {course} course. Reply YES and {owner} will call you.' },
            { name: 'Appointment Confirm', body: 'Hi {name}, your session with {owner} is confirmed. Reply 1 to confirm, 2 to reschedule.' },
            { name: 'Offer / Promotion',   body: 'NPS Digital: {name}, enrol in {course} this month and save more. Call {owner} for details.' }
        ],
        Email: [
            { name: 'Welcome Email',      subject: 'Welcome to NPS Digital, {name}', body: 'Hi {name},\n\nThank you for your interest in NPS Digital. I\'m {owner} and I will be your point of contact.\n\nPlease reply to this email or call us if you have any questions about {course}.\n\nRegards,\nTeam NPS' },
            { name: 'Course Details',     subject: 'Details about {course}',         body: 'Hi {name},\n\nAs discussed, here are the details of the {course} course: syllabus, duration and fees.\n\nLet me know a good time to talk.\n\nRegards,\n{owner}, Team NPS' },
            { name: 'Follow-up Reminder', subject: 'Following up, {name}',           body: 'Hi {name},\n\nI wanted to follow up on your enquiry about {course}. Are you still interested?\n\nRegards,\n{owner}, Team NPS' },
            { name: 'Thank You',          subject: 'Thank you, {name}',              body: 'Hi {name},\n\nThank you for choosing NPS Digital. We look forward to helping you with {course}.\n\nRegards,\nTeam NPS' },
            { name: 'Offer / Promotion',  subject: 'A special offer on {course}',    body: 'Hi {name},\n\nEnrol in {course} this month and get a special discount.\n\nReply to this email to claim it.\n\nRegards,\n{owner}, Team NPS' }
        ]
    };

    var barTitle = { WhatsApp: 'NPS Digital', SMS: 'Messages', Email: 'New email' };
    var sample = { owner: 'Priya', course: 'Digital Marketing' };

    // WhatsApp is the default channel; first template is selected by default
    var state = { channel: 'WhatsApp', template: templates.WhatsApp[0].name, sent: false };

    var $ = function (id) { return document.getElementById(id); };
    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    function selected() { return leads.filter(function (l) { return l.on; }); }
    function currentList() { return templates[state.channel]; }
    function currentTemplate() {
        var list = currentList();
        for (var i = 0; i < list.length; i++) { if (list[i].name === state.template) return list[i]; }
        return list[0];
    }

    var toastTimer;
    function toast(msg) {
        var t = $('smToast');
        t.textContent = msg;
        t.classList.add('is-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { t.classList.remove('is-show'); }, 2800);
    }
    // SweetAlert2 if the layout loads it, otherwise a toast
    function notify(title, text) {
        if (window.Swal) Swal.fire({ icon: 'success', title: title, text: text, confirmButtonColor: '#021b45' });
        else toast(title + ' - ' + text);
    }

    /* ---------------- Render: template column (depends on channel) ---------------- */
    function renderTemplates() {
        var list = currentList();

        $('smTplCap').textContent = state.channel + ' templates';

        $('smTplSelect').innerHTML = list.map(function (t) {
            return '<option value="' + esc(t.name) + '"' + (t.name === state.template ? ' selected' : '') + '>' + esc(t.name) + '</option>';
        }).join('');

        $('smTpls').innerHTML = list.map(function (t) {
            var on = t.name === state.template;
            return '<button type="button" class="sm-tpl' + (on ? ' is-on' : '') + '" role="radio" aria-checked="' + on +
                '" data-name="' + esc(t.name) + '">' + esc(t.name) + '</button>';
        }).join('');
    }

    /* ---------------- Render: preview (depends on channel + template + first lead) ---------------- */
    function fill(text, lead) {
        var name = lead ? lead.name.split(' ')[0] : 'Rahul';
        var phone = lead ? lead.phone : '+91 98450 11223';
        return text
            .replace(/\{name\}/g, name)
            .replace(/\{phone\}/g, phone)
            .replace(/\{owner\}/g, sample.owner)
            .replace(/\{course\}/g, sample.course);
    }
    function renderPreview() {
        var t = currentTemplate();
        var lead = selected()[0];
        var d = new Date();
        var time = (d.getHours() < 10 ? '0' : '') + d.getHours() + ':' + (d.getMinutes() < 10 ? '0' : '') + d.getMinutes();

        $('smPreviewCard').setAttribute('data-ch', state.channel);
        $('smPhoneBar').textContent = barTitle[state.channel];

        var html = '';
        if (state.channel === 'Email' && t.subject) {
            html += '<span class="sm-subject">' + esc(fill(t.subject, lead)) + '</span>';
        }
        html += '<p>' + esc(fill(t.body, lead)).replace(/\n/g, '<br>') + '</p>';
        html += '<span class="sm-time">' + time + '</span>';
        $('smBubble').innerHTML = html;
    }

    /* ---------------- Render: leads + buttons + stepper ---------------- */
    function render() {
        var sel = selected();
        var n = sel.length;

        $('smCount').textContent = n;
        $('smLeadList').innerHTML = n ? sel.map(function (l) {
            return '<div class="sm-lead" data-id="' + l.id + '">' +
                '<span class="sm-avatar" aria-hidden="true">' + esc(l.name.charAt(0)) + '</span>' +
                '<div class="sm-lead-info"><strong>' + esc(l.name) + '</strong><small>' + esc(l.phone) + '</small></div>' +
                '<button type="button" class="sm-remove" aria-label="Remove ' + esc(l.name) + '">x</button></div>';
        }).join('') : '<div class="sm-empty">No leads selected. Use "Add more" to pick leads.</div>';

        var send = $('smSend');
        send.disabled = n === 0;
        send.textContent = n === 0 ? 'Select leads to send' : 'Send to ' + n + (n === 1 ? ' lead now' : ' leads now');
        $('smSchedule').disabled = n === 0;
        $('smActionNote').textContent = n ? 'Via ' + state.channel + ' - ' + state.template : '';

        // stepper: 1 = leads picked, 2 = template chosen, 3 = after send / schedule
        var s1 = n > 0, s2 = s1 && !!state.template, s3 = s2 && state.sent;
        [s1, s2, s3].forEach(function (on, i) {
            document.querySelector('#smSteps [data-step="' + (i + 1) + '"]').classList.toggle('is-on', on);
        });

        renderPreview();
    }

    $('smLeadList').addEventListener('click', function (e) {
        var btn = e.target.closest('.sm-remove');
        if (!btn) return;
        var id = parseInt(btn.closest('.sm-lead').dataset.id, 10);
        leads.forEach(function (l) { if (l.id === id) l.on = false; });
        state.sent = false;
        render();
    });

    /* ---------------- Add more dialog ---------------- */
    function openOverlay(el) { el.classList.add('is-open'); el.setAttribute('aria-hidden', 'false'); }
    function closeOverlay(el) { el.classList.remove('is-open'); el.setAttribute('aria-hidden', 'true'); }
    var addOv = $('smAddOverlay'), schedOv = $('smSchedOverlay');

    $('smAddMore').addEventListener('click', function () {
        var pool = leads.filter(function (l) { return !l.on; });
        $('smPick').innerHTML = pool.length ? pool.map(function (l) {
            return '<label><input type="checkbox" value="' + l.id + '"> <span class="sm-lead-info"><strong>' +
                esc(l.name) + '</strong><small>' + esc(l.phone) + '</small></span></label>';
        }).join('') : '<div class="sm-empty">All leads are already selected.</div>';
        openOverlay(addOv);
    });
    $('smAddCancel').addEventListener('click', function () { closeOverlay(addOv); });
    $('smAddConfirm').addEventListener('click', function () {
        var ids = Array.prototype.map.call($('smPick').querySelectorAll('input:checked'), function (c) { return parseInt(c.value, 10); });
        leads.forEach(function (l) { if (ids.indexOf(l.id) !== -1) l.on = true; });
        closeOverlay(addOv);
        if (ids.length) { state.sent = false; render(); toast(ids.length + (ids.length === 1 ? ' lead added' : ' leads added')); }
    });

    /* ---------------- Send via: switches the template list ---------------- */
    $('smVia').addEventListener('click', function (e) {
        var b = e.target.closest('button[data-ch]');
        if (!b || b.dataset.ch === state.channel) return;

        state.channel = b.dataset.ch;
        state.template = currentList()[0].name;   // reset to first template of this channel
        state.sent = false;

        this.querySelectorAll('button').forEach(function (x) {
            var on = x === b;
            x.classList.toggle('is-on', on);
            x.setAttribute('aria-checked', String(on));
        });

        renderTemplates();
        render();
    });

    /* ---------------- Templates (dropdown + list stay in sync) ---------------- */
    function setTemplate(name) {
        state.template = name;
        state.sent = false;
        $('smTplSelect').value = name;
        document.querySelectorAll('#smTpls .sm-tpl').forEach(function (b) {
            var on = b.dataset.name === name;
            b.classList.toggle('is-on', on);
            b.setAttribute('aria-checked', String(on));
        });
        render();
    }
    $('smTpls').addEventListener('click', function (e) {
        var b = e.target.closest('.sm-tpl');
        if (b) setTemplate(b.dataset.name);
    });
    $('smTplSelect').addEventListener('change', function () { setTemplate(this.value); });

    $('smEdit').addEventListener('click', function () { toast('Template editor opens here'); });

    /* ---------------- Send now ---------------- */
    $('smSend').addEventListener('click', function () {
        var btn = this, n = selected().length;
        if (!n) return;
        btn.disabled = true;
        btn.textContent = 'Sending...';
        setTimeout(function () {
            state.sent = true;
            render();
            notify('Message sent', n + (n === 1 ? ' lead' : ' leads') + ' via ' + state.channel +
                ' using "' + state.template + '".');
        }, 1000);
    });

    /* ---------------- Schedule for later ---------------- */
    function pad(x) { return (x < 10 ? '0' : '') + x; }
    $('smSchedule').addEventListener('click', function () {
        var n = selected().length;
        var d = new Date();
        var today = d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
        $('smDate').min = today;
        if (!$('smDate').value) $('smDate').value = today;
        $('smSchedSub').textContent = n + (n === 1 ? ' lead' : ' leads') + ' via ' + state.channel + ' - ' + state.template;
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
        notify('Message scheduled', 'Will be sent on ' + when.toLocaleString([], { dateStyle: 'medium', timeStyle: 'short' }) + '.');
    });

    /* ---------------- Dialog dismissal ---------------- */
    [addOv, schedOv].forEach(function (ov) {
        ov.addEventListener('click', function (e) { if (e.target === ov) closeOverlay(ov); });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { closeOverlay(addOv); closeOverlay(schedOv); }
    });

    /* ---------------- Init (WhatsApp by default) ---------------- */
    renderTemplates();
    render();
})();
</script>
@endpush
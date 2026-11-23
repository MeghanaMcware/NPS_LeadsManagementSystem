@extends('admin.layouts.app')

@section('title', 'Lead Details')

@section('style')
<style>
    /* ---------- Lead details page (scoped under .ld) ---------- */
    .ld {
        --ld-blue: #001c45;
        --ld-blue-dark: #001c45;
        --ld-blue-soft: #e6ecf7;
        --ld-ink: #1b2233;
        --ld-muted: #7b8497;
        --ld-line: #e3e7ef;
        --ld-bg: #f1f4f9;
        --ld-card: #ffffff;
        --ld-radius: 14px;
        color: var(--ld-ink);
    }
    .ld * { box-sizing: border-box; }

    .ld .ld-card {
        background: var(--ld-card);
        border: 1px solid var(--ld-line);
        border-radius: var(--ld-radius);
        padding: 22px 24px;
        margin-bottom: 20px;
    }
    .ld .ld-card h5 {
        font-size: 17px;
        font-weight: 700;
        margin: 0 0 16px;
        color: var(--ld-ink);
    }

    /* Buttons */
    .ld .ld-btn {
        border: 1px solid var(--ld-line);
        background: #fff;
        color: var(--ld-ink);
        font-weight: 600;
        font-size: 14px;
        padding: 10px 22px;
        border-radius: 10px;
        cursor: pointer;
        transition: background .15s, border-color .15s, transform .1s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .ld .ld-btn:hover { background: var(--ld-bg); }
    .ld .ld-btn:active { transform: translateY(1px); }
    .ld .ld-btn:focus-visible,
    .ld .ld-input:focus-visible { outline: 3px solid rgba(11,111,240,.35); outline-offset: 1px; }
    .ld .ld-btn-primary { background: var(--ld-blue); border-color: var(--ld-blue); color: #fff; }
    .ld .ld-btn-primary:hover { background: var(--ld-blue-dark); border-color: var(--ld-blue-dark); color: #fff; }
    .ld .ld-btn-sm { padding: 8px 16px; font-size: 13px; }

    /* Profile header */
    .ld .ld-profile { display: flex; align-items: center; gap: 22px; flex-wrap: wrap; }
    .ld .ld-avatar {
        width: 78px; height: 78px; border-radius: 50%;
        background: #b7d0fb; color: var(--ld-blue);
        font-size: 34px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex: none;
    }
    .ld .ld-profile-info { flex: 1 1 280px; min-width: 0; }
    .ld .ld-name-row { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
    .ld .ld-name { font-size: 24px; font-weight: 700; margin: 0; }
    .ld .ld-meta { color: var(--ld-muted); font-size: 14px; margin-top: 8px; display: flex; flex-wrap: wrap; gap: 6px 18px; }
    .ld .ld-meta-sep { display: inline-block; width: 1px; height: 14px; background: var(--ld-line); align-self: center; }
    .ld .ld-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    /* Status pills */
    .ld .ld-pill {
        font-size: 12px; font-weight: 700;
        padding: 5px 14px; border-radius: 999px;
        display: inline-block;
    }
    .ld .ld-pill[data-status="New"]       { background: #e0ecff; color: #1a5fd0; }
    .ld .ld-pill[data-status="Contacted"] { background: #ffefd3; color: #e08700; }
    .ld .ld-pill[data-status="Follow-up"] { background: #ece4ff; color: #6d3fd1; }
    .ld .ld-pill[data-status="Converted"] { background: #d8f3e3; color: #15894a; }
    .ld .ld-pill[data-status="Lost"]      { background: #fde3e3; color: #c93434; }

    /* Status stepper */
    .ld .ld-steps { list-style: none; margin: 0; padding: 0; display: flex; }
    .ld .ld-step { flex: 1 1 0; position: relative; text-align: center; padding-top: 0; }
    .ld .ld-step::before {
        content: ""; position: absolute; top: 15px; left: -50%;
        width: 100%; height: 4px; background: var(--ld-line);
        transition: background .3s;
    }
    .ld .ld-step:first-child::before { display: none; }
    .ld .ld-step.is-done::before,
    .ld .ld-step.is-current::before { background: var(--ld-blue); }
    .ld .ld-dot {
        position: relative; z-index: 1;
        width: 34px; height: 34px; border-radius: 50%;
        margin: 0 auto 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700;
        background: #fff; border: 2px solid #b9c0d0; color: #6b7388;
        transition: all .25s;
    }
    .ld .ld-step.is-done .ld-dot,
    .ld .ld-step.is-current .ld-dot { background: var(--ld-blue); border-color: var(--ld-blue); color: #fff; }
    .ld .ld-step-label { font-size: 13px; color: var(--ld-muted); }
    .ld .ld-step.is-current .ld-step-label { color: var(--ld-ink); font-weight: 700; }
    .ld .ld-step.is-done .ld-step-label { color: var(--ld-ink); }

    /* ---------- Card header (Notes / Timeline) ---------- */
    .ld .ld-panel-head {
        display: flex; align-items: center; justify-content: space-between;
        gap: 12px; margin-bottom: 18px;
    }
    .ld .ld-panel-title { display: flex; align-items: center; gap: 10px; }
    .ld .ld-panel-title h5 { margin: 0; }
    .ld .ld-panel-icon {
        width: 34px; height: 34px; border-radius: 10px;
        background: var(--ld-blue-soft); color: var(--ld-blue);
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 16px; flex: none;
    }
    .ld .ld-count {
        font-size: 12px; font-weight: 700;
        background: var(--ld-bg); color: var(--ld-muted);
        padding: 3px 10px; border-radius: 999px;
    }

    /* ---------- Notes ---------- */
    .ld .ld-notes { list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 12px; }
    .ld .ld-note {
        position: relative;
        background: #fffbee;
        border: 1px solid #f6e8b8;
        border-left: 4px solid #f0b429;
        border-radius: 10px;
        padding: 12px 44px 12px 14px;
        animation: ld-pop .25s ease;
    }
    .ld .ld-note:nth-child(3n+2) { background: #f1f7ff; border-color: #d3e3fb; border-left-color: #4a8df0; }
    .ld .ld-note:nth-child(3n+3) { background: #f2fbf5; border-color: #d0eedb; border-left-color: #2fae67; }
    .ld .ld-note-text { font-size: 14.5px; line-height: 1.45; margin: 0; word-wrap: break-word; }
    .ld .ld-note-meta {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: var(--ld-muted); margin-top: 6px;
    }
    .ld .ld-note-del {
        position: absolute; top: 8px; right: 8px;
        width: 28px; height: 28px; border: 0; border-radius: 8px;
        background: transparent; color: var(--ld-muted);
        cursor: pointer; font-size: 14px;
        display: inline-flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity .15s, background .15s, color .15s;
    }
    .ld .ld-note:hover .ld-note-del,
    .ld .ld-note-del:focus-visible { opacity: 1; }
    .ld .ld-note-del:hover { background: rgba(201,52,52,.1); color: #c93434; }
    @media (hover: none) { .ld .ld-note-del { opacity: 1; } }

    .ld .ld-note-form {
        display: none; flex-direction: column; gap: 10px;
        background: var(--ld-bg); border-radius: 12px;
        padding: 12px; margin-bottom: 14px;
    }
    .ld .ld-note-form.is-open { display: flex; animation: ld-pop .2s ease; }
    .ld .ld-input {
        width: 100%; border: 1px solid var(--ld-line); background: #fff;
        border-radius: 10px; padding: 10px 14px; font-size: 14px;
        color: var(--ld-ink); resize: none; font-family: inherit;
    }
    .ld .ld-input::placeholder { color: var(--ld-muted); }
    .ld .ld-form-foot { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
    .ld .ld-form-hint { font-size: 12px; color: var(--ld-muted); }
    .ld .ld-form-btns { display: flex; gap: 8px; }

    .ld .ld-empty {
        text-align: center; color: var(--ld-muted); font-size: 14px;
        padding: 26px 10px; border: 1.5px dashed var(--ld-line); border-radius: 12px;
    }
    .ld .ld-empty i { display: block; font-size: 26px; margin-bottom: 6px; opacity: .6; }

    /* ---------- Activity timeline ---------- */
    .ld .ld-timeline {
        list-style: none; margin: 0; padding: 0;
        position: relative;
    }
    .ld .ld-timeline::before {
        content: ""; position: absolute;
        left: 17px; top: 8px; bottom: 8px; width: 2px;
        background: var(--ld-line);
    }
    .ld .ld-tl-item {
        position: relative;
        display: flex; align-items: flex-start; gap: 14px;
        padding: 8px 0;
        animation: ld-pop .25s ease;
    }
    .ld .ld-tl-icon {
        position: relative; z-index: 1; flex: none;
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        border: 3px solid #fff;
        box-shadow: 0 0 0 1px var(--ld-line);
    }
    .ld .ld-tl-icon.t-status  { background: #ffefd3; color: #e08700; }
    .ld .ld-tl-icon.t-message { background: #e0ecff; color: #1a5fd0; }
    .ld .ld-tl-icon.t-auto    { background: #ece4ff; color: #6d3fd1; }
    .ld .ld-tl-icon.t-import  { background: #d8f3e3; color: #15894a; }
    .ld .ld-tl-icon.t-note    { background: #fff3c9; color: #b98200; }
    .ld .ld-tl-body {
        flex: 1; min-width: 0;
        background: var(--ld-bg); border-radius: 10px;
        padding: 9px 14px;
    }
    .ld .ld-tl-text { font-size: 14.5px; font-weight: 600; margin: 0; }
    .ld .ld-tl-sub { font-size: 12.5px; color: var(--ld-muted); margin-top: 2px; }

    /* Toast */
    .ld-toast {
        position: fixed; right: 24px; bottom: 24px;
        background: #1b2233; color: #fff; font-size: 14px;
        padding: 12px 18px; border-radius: 10px;
        box-shadow: 0 12px 30px rgba(15,23,42,.3);
        opacity: 0; transform: translateY(10px);
        transition: opacity .2s, transform .2s;
        pointer-events: none; z-index: 1090;
    }
    .ld-toast.is-show { opacity: 1; transform: translateY(0); }

    @keyframes ld-pop {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: none; }
    }

    @media (max-width: 575.98px) {
        .ld .ld-card { padding: 18px; }
        .ld .ld-actions { width: 100%; }
        .ld .ld-actions .ld-btn { flex: 1; }
        .ld .ld-form-foot { flex-direction: column; align-items: stretch; }
        .ld .ld-form-btns { justify-content: flex-end; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ld .ld-step::before, .ld .ld-dot, .ld-toast { transition: none; }
        .ld .ld-note, .ld .ld-tl-item, .ld .ld-note-form.is-open { animation: none; }
    }
</style>
@endsection

@section('content')
<div class="">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Lead Details</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">List</a></li>
                        <li class="breadcrumb-item active">Lead Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="ld mt-3" id="leadPage">

        {{-- ============ Profile header ============ --}}
        <div class="ld-card">
            <div class="ld-profile">
                <div class="ld-avatar" id="leadAvatar">{{ strtoupper(substr($lead->name, 0, 1)) }}</div>

                <div class="ld-profile-info">
                    <div class="ld-name-row">
                        <h2 class="ld-name" id="leadName">{{ $lead->name }}</h2>
                        <span class="ld-pill" id="leadStatusPill" data-status="{{ ucfirst($lead->status) }}">{{ ucfirst($lead->status) }}</span>
                    </div>
                    <div class="ld-meta">
                        <span id="leadPhone"><i class="bi bi-telephone me-1"></i>{{ $lead->phone }}</span>
                        @if($lead->email)
                        <i class="ld-meta-sep"></i>
                        <span id="leadEmail"><i class="bi bi-envelope me-1"></i>{{ $lead->email }}</span>
                        @endif
                        @if($lead->city)
                        <i class="ld-meta-sep"></i>
                        <span id="leadCity"><i class="bi bi-geo-alt me-1"></i>{{ $lead->city }}</span>
                        @endif
                    </div>
                    <div class="ld-meta">
                        <span>Source: {{ $lead->source }}</span>
                        @if($lead->interested_in)
                        <span>Grade / Course: {{ $lead->interested_in }}</span>
                        @endif
                        <span>Created: {{ $lead->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="ld-actions">
                    <a href="{{ route('messages.send', ['lead_id' => $lead->id]) }}" class="ld-btn ld-btn-primary" id="btnSendMessage">Send message</a>
                </div>
            </div>
        </div>

        {{-- ============ Lead status ============ --}}
        <div class="ld-card">
            <h5>Lead status</h5>

            <ol class="ld-steps" id="statusSteps">
                <li class="ld-step" data-step="New">
                    <div class="ld-dot">1</div><div class="ld-step-label">New</div>
                </li>
                <li class="ld-step" data-step="Contacted">
                    <div class="ld-dot">2</div><div class="ld-step-label">Contacted</div>
                </li>
                <li class="ld-step" data-step="Follow-up">
                    <div class="ld-dot">3</div><div class="ld-step-label">Follow-up</div>
                </li>
                <li class="ld-step" data-step="Converted">
                    <div class="ld-dot">4</div><div class="ld-step-label">Converted</div>
                </li>
            </ol>
        </div>

        {{-- ============ Notes + Activity timeline ============ --}}
        <div class="row g-4  pb-3">

            {{-- Notes --}}
            <div class="col-12 col-lg-6">
                <div class="ld-card h-100">
                    <div class="ld-panel-head">
                        <div class="ld-panel-title">
                            <span class="ld-panel-icon"><i class="bi bi-journal-text"></i></span>
                            <h5>Notes</h5>
                            <span class="ld-count" id="notesCount">3</span>
                        </div>
                        <button type="button" class="ld-btn ld-btn-sm" id="btnAddNote">
                            <i class="bi bi-plus-lg"></i> Add note
                        </button>
                    </div>

                    <div class="ld-note-form" id="noteForm">
                        <textarea class="ld-input" id="noteInput" rows="3" maxlength="200"
                            placeholder="Write a note about this lead..."></textarea>
                        <div class="ld-form-foot">
                            <span class="ld-form-hint"><span id="noteChars">0</span>/200 &middot; Ctrl + Enter to save</span>
                            <div class="ld-form-btns">
                                <button type="button" class="ld-btn ld-btn-sm" id="btnNoteCancel">Cancel</button>
                                <button type="button" class="ld-btn ld-btn-primary ld-btn-sm" id="btnNoteSave">Save note</button>
                            </div>
                        </div>
                    </div>

                    <ul class="ld-notes" id="notesList">
                        @forelse($lead->remarks ?? [] as $index => $note)
                            <li class="ld-note" data-index="{{ $index }}">
                                <p class="ld-note-text">{{ $note['text'] ?? '' }}</p>
                                <div class="ld-note-meta">
                                    <i class="bi bi-person-circle"></i> {{ $note['author'] ?? 'Admissions' }} &middot; {{ $note['date'] ?? '' }}
                                    @if(!empty($note['type']))
                                        <span class="badge bg-light text-dark ms-1" style="font-size:10.5px; text-transform: capitalize;">{{ $note['type'] }}</span>
                                    @endif
                                </div>
                                <button type="button" class="ld-note-del" aria-label="Delete note" data-index="{{ $index }}"><i class="bi bi-trash3"></i></button>
                            </li>
                        @empty
                        @endforelse
                    </ul>

                    <div class="ld-empty" id="notesEmpty" {{ !empty($lead->remarks) ? 'hidden' : '' }}>
                        <i class="bi bi-journal-plus"></i>
                        No notes yet. Add the first note.
                    </div>
                </div>
            </div>

            {{-- Activity timeline --}}
            <div class="col-12 col-lg-6">
                <div class="ld-card h-100">
                    <div class="ld-panel-head">
                        <div class="ld-panel-title">
                            <span class="ld-panel-icon"><i class="bi bi-clock-history"></i></span>
                            <h5>Activity timeline</h5>
                        </div>
                    </div>

                    <ul class="ld-timeline" id="timelineList">
                        @forelse($lead->messages as $msg)
                            <li class="ld-tl-item">
                                @if($msg->channel === 'whatsapp')
                                    <span class="ld-tl-icon t-message" style="background: #25d366; color: #fff;"><i class="bi bi-whatsapp"></i></span>
                                @elseif($msg->channel === 'sms')
                                    <span class="ld-tl-icon t-message" style="background: #1b5fd1; color: #fff;"><i class="bi bi-chat-text-fill"></i></span>
                                @elseif($msg->channel === 'email')
                                    <span class="ld-tl-icon t-message" style="background: #ea4335; color: #fff;"><i class="bi bi-envelope-fill"></i></span>
                                @else
                                    <span class="ld-tl-icon t-auto"><i class="bi bi-sticky-fill"></i></span>
                                @endif
                                <div class="ld-tl-body">
                                    <p class="ld-tl-text">
                                        @if($msg->channel === 'note')
                                            Note added: {{ \Illuminate\Support\Str::limit($msg->note, 60) }}
                                        @else
                                            {{ ucfirst($msg->channel) }} ({{ ucwords(str_replace('_', ' ', $msg->template_type ?? 'Message')) }}) &middot; {{ ucfirst($msg->status) }}
                                        @endif
                                    </p>
                                    <div class="ld-tl-sub">{{ $msg->sent_at ? $msg->sent_at->format('d M Y, h:i A') : $msg->created_at->format('d M Y, h:i A') }}</div>
                                </div>
                            </li>
                        @empty
                        @endforelse

                        <li class="ld-tl-item">
                            <span class="ld-tl-icon t-status"><i class="bi bi-arrow-repeat"></i></span>
                            <div class="ld-tl-body">
                                <p class="ld-tl-text">Status: {{ ucfirst($lead->status) }}</p>
                                <div class="ld-tl-sub">{{ $lead->last_contact_at ? $lead->last_contact_at->format('d M Y') : $lead->created_at->format('d M Y') }}</div>
                            </div>
                        </li>
                        <li class="ld-tl-item">
                            <span class="ld-tl-icon t-import"><i class="bi bi-box-arrow-in-down"></i></span>
                            <div class="ld-tl-body">
                                <p class="ld-tl-text">Lead created via {{ $lead->source }}</p>
                                <div class="ld-tl-sub">{{ $lead->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="ld-toast" id="ldToast" role="status"></div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var $ = function (id) { return document.getElementById(id); };

    // ---------- Elements ----------
    var steps      = $('statusSteps');
    var timeline   = $('timelineList');
    var notesList  = $('notesList');
    var notesEmpty = $('notesEmpty');
    var notesCount = $('notesCount');
    var noteForm   = $('noteForm');
    var noteInput  = $('noteInput');
    var noteChars  = $('noteChars');
    var toastEl    = $('ldToast');

    var ORDER = ['New', 'Contacted', 'Follow-up', 'Converted'];
    var currentStatus = 'Contacted';
    var toastTimer = null;

    // ---------- Helpers ----------
    var MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    function shortDate(d) { return d.getDate() + ' ' + MONTHS[d.getMonth()]; }

    function toast(message) {
        toastEl.textContent = message;
        toastEl.classList.add('is-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toastEl.classList.remove('is-show'); }, 2400);
    }

    function el(tag, className, text) {
        var node = document.createElement(tag);
        if (className) node.className = className;
        if (text !== undefined) node.textContent = text;
        return node;
    }

    function icon(name) {
        var i = document.createElement('i');
        i.className = 'bi ' + name;
        return i;
    }

    // ---------- Status stepper (display only) ----------
    function renderStatus(status) {
        var idx = ORDER.indexOf(status);
        Array.prototype.forEach.call(steps.children, function (li, i) {
            var dot = li.querySelector('.ld-dot');
            li.classList.remove('is-done', 'is-current');
            dot.textContent = String(i + 1);
            if (i < idx) {
                li.classList.add('is-done');
                dot.textContent = '\u2713';
            } else if (i === idx) {
                li.classList.add('is-current');
                dot.textContent = '\u2713';
            }
        });
        var pill = $('leadStatusPill');
        pill.textContent = status;
        pill.setAttribute('data-status', status);
    }

    // ---------- Timeline ----------
    // type: status | message | auto | import | note
    var TL_ICONS = {
        status:  'bi-arrow-repeat',
        message: 'bi-chat-dots',
        auto:    'bi-robot',
        import:  'bi-box-arrow-in-down',
        note:    'bi-sticky'
    };

    function addTimeline(type, text) {
        var li = el('li', 'ld-tl-item');

        var ic = el('span', 'ld-tl-icon t-' + type);
        ic.appendChild(icon(TL_ICONS[type] || 'bi-dot'));

        var body = el('div', 'ld-tl-body');
        body.appendChild(el('p', 'ld-tl-text', text));
        body.appendChild(el('div', 'ld-tl-sub', shortDate(new Date())));

        li.appendChild(ic);
        li.appendChild(body);
        timeline.insertBefore(li, timeline.firstChild);
    }

    // ---------- Notes ----------
    function syncNotes() {
        var n = notesList.children.length;
        notesCount.textContent = n;
        notesEmpty.hidden = n > 0;
        notesList.hidden = n === 0;
    }

    function addNote(text) {
        var li = el('li', 'ld-note');
        li.appendChild(el('p', 'ld-note-text', text));

        var meta = el('div', 'ld-note-meta');
        meta.appendChild(icon('bi-person-circle'));
        meta.appendChild(document.createTextNode(' Priya \u00b7 ' + shortDate(new Date())));
        li.appendChild(meta);

        var del = el('button', 'ld-note-del');
        del.type = 'button';
        del.setAttribute('aria-label', 'Delete note');
        del.appendChild(icon('bi-trash3'));
        li.appendChild(del);

        notesList.insertBefore(li, notesList.firstChild);
        syncNotes();
    }

    function openForm() {
        noteForm.classList.add('is-open');
        noteInput.focus();
    }
    function closeForm() {
        noteForm.classList.remove('is-open');
        noteInput.value = '';
        noteChars.textContent = '0';
    }

    $('btnAddNote').addEventListener('click', function () {
        noteForm.classList.contains('is-open') ? closeForm() : openForm();
    });
    $('btnNoteCancel').addEventListener('click', closeForm);

    function saveNote() {
        var value = noteInput.value.trim();
        if (!value) {
            noteInput.focus();
            toast('Write something first');
            return;
        }

        var saveBtn = $('btnNoteSave');
        saveBtn.disabled = true;

        fetch('{{ route("leads.notes.store", $lead->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ note: value })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            saveBtn.disabled = false;
            if (data.success) {
                var newIdx = notesList.querySelectorAll('.ld-note').length;
                var li = el('li', 'ld-note');
                li.dataset.index = newIdx;
                li.appendChild(el('p', 'ld-note-text', data.note.text));

                var meta = el('div', 'ld-note-meta');
                meta.appendChild(icon('bi-person-circle'));
                meta.appendChild(document.createTextNode(' ' + data.note.author + ' \u00b7 ' + data.note.date));
                li.appendChild(meta);

                var del = el('button', 'ld-note-del');
                del.type = 'button';
                del.dataset.index = newIdx;
                del.setAttribute('aria-label', 'Delete note');
                del.appendChild(icon('bi-trash3'));
                li.appendChild(del);

                notesList.insertBefore(li, notesList.firstChild);
                syncNotes();
                addTimeline('note', 'Note added: ' + value.substring(0, 40));
                closeForm();
                toast('Note saved');
            } else {
                toast(data.message || 'Failed to save note');
            }
        })
        .catch(function () {
            saveBtn.disabled = false;
            toast('Network error saving note');
        });
    }

    $('btnNoteSave').addEventListener('click', saveNote);

    noteInput.addEventListener('input', function () {
        noteChars.textContent = noteInput.value.length;
    });
    noteInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) { e.preventDefault(); saveNote(); }
        if (e.key === 'Escape') { closeForm(); }
    });

    notesList.addEventListener('click', function (e) {
        var btn = e.target.closest('.ld-note-del');
        if (!btn) return;
        var noteEl = btn.closest('.ld-note');
        var index = btn.dataset.index || noteEl.dataset.index;

        btn.disabled = true;
        fetch('{{ url("/leads/{$lead->id}/notes") }}/' + index, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                noteEl.remove();
                syncNotes();
                toast('Note deleted');
            }
        })
        .catch(function () {
            btn.disabled = false;
            toast('Failed to delete note');
        });
    });

    // ---------- Init ----------
    renderStatus(currentStatus);
    syncNotes();
})();
</script>
@endpush
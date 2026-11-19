@extends('admin.layouts.app')

@section('title', 'Lead Details')

@section('style')
<style>
    /* ---------- Lead details page (scoped under .ld) ---------- */
    .ld {
        --ld-blue: #001c45;
        --ld-blue-dark: #001c45;
        --ld-ink: #1b2233;
        --ld-muted: #7b8497;
        --ld-line: #e3e7ef;
        --ld-bg: #f1f4f9;
        --ld-card: #ffffff;
        --ld-green-bg: #d4f5c8;
        --ld-grey-bg: #eef1f6;
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
        transition: background .15s, border-color .15s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .ld .ld-btn:hover { background: var(--ld-bg); }
    .ld .ld-btn:focus-visible,
    .ld .ld-input:focus-visible,
    .ld .ld-select:focus-visible { outline: 3px solid rgba(11,111,240,.35); outline-offset: 1px; }
    .ld .ld-btn-primary { background: var(--ld-blue); border-color: var(--ld-blue); color: #fff; }
    .ld .ld-btn-primary:hover { background: var(--ld-blue-dark); border-color: var(--ld-blue-dark); }
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
    .ld .ld-meta span + span { padding-left: 0; }
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
    .ld .ld-status-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 6px; }
    .ld .ld-status-head h5 { margin: 0; }
    .ld .ld-select-wrap { position: relative; }
    .ld .ld-select {
        appearance: none; -webkit-appearance: none;
        border: 1px solid var(--ld-line); background: #fff;
        font-weight: 600; font-size: 14px; color: var(--ld-ink);
        padding: 10px 38px 10px 16px; border-radius: 10px; cursor: pointer;
    }
    .ld .ld-select-wrap::after {
        content: "";
        position: absolute; right: 16px; top: 50%;
        width: 7px; height: 7px;
        border-right: 2px solid var(--ld-ink); border-bottom: 2px solid var(--ld-ink);
        transform: translateY(-70%) rotate(45deg);
        pointer-events: none;
    }

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
    .ld .ld-steps.is-lost .ld-step::before { background: var(--ld-line); }
    .ld .ld-steps.is-lost .ld-dot { background: #fff; border-color: #b9c0d0; color: #6b7388; }

    /* Message history */
    .ld .ld-chat { display: flex; flex-direction: column; padding: 0; overflow: hidden; }
    .ld .ld-chat h5 { padding: 22px 24px 0; }
    .ld .ld-chat-body {
        padding: 4px 24px 16px;
        height: 420px; overflow-y: auto;
        display: flex; flex-direction: column; gap: 18px;
        scroll-behavior: smooth;
    }
    .ld .ld-msg { max-width: 76%; padding: 12px 18px; border-radius: 12px; font-size: 14.5px; line-height: 1.45; word-wrap: break-word; }
    .ld .ld-msg-out { align-self: flex-end; background: var(--ld-green-bg); }
    .ld .ld-msg-in  { align-self: flex-start; background: var(--ld-grey-bg); }
    .ld .ld-msg-label { display: block; font-size: 12.5px; font-weight: 700; color: var(--ld-muted); margin-bottom: 3px; }
    .ld .ld-msg-time { display: block; font-size: 11px; color: var(--ld-muted); margin-top: 6px; }
    .ld .ld-composer {
        display: flex; gap: 12px; align-items: center;
        padding: 14px 24px 20px; border-top: 1px solid var(--ld-line);
        position: relative;
    }
    .ld .ld-input {
        flex: 1; border: 1px solid transparent; background: var(--ld-grey-bg);
        border-radius: 999px; padding: 12px 20px; font-size: 14px; color: var(--ld-ink);
        min-width: 0;
    }
    .ld .ld-input::placeholder { color: var(--ld-muted); }
    .ld .ld-tpl-btn { padding: 10px 14px; border-radius: 999px; }
    .ld .ld-tpl-menu {
        position: absolute; bottom: 70px; left: 24px;
        background: #fff; border: 1px solid var(--ld-line); border-radius: 12px;
        box-shadow: 0 12px 30px rgba(20,33,61,.14);
        min-width: 260px; padding: 6px; display: none; z-index: 20;
    }
    .ld .ld-tpl-menu.is-open { display: block; }
    .ld .ld-tpl-menu button {
        display: block; width: 100%; text-align: left;
        border: 0; background: transparent; padding: 10px 12px;
        border-radius: 8px; font-size: 14px; color: var(--ld-ink); cursor: pointer;
    }
    .ld .ld-tpl-menu button:hover { background: var(--ld-bg); }
    .ld .ld-tpl-menu small { display: block; color: var(--ld-muted); font-size: 12px; }

    /* Notes */
    .ld .ld-notes { list-style: none; margin: 0 0 18px; padding: 0; }
    .ld .ld-notes li {
        display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;
        font-size: 14.5px; padding: 7px 0;
    }
    .ld .ld-note-del {
        border: 0; background: transparent; color: var(--ld-muted);
        font-size: 16px; line-height: 1; cursor: pointer; padding: 2px 6px; border-radius: 6px;
    }
    .ld .ld-note-del:hover { background: var(--ld-bg); color: #c93434; }
    .ld .ld-note-form { display: none; gap: 8px; margin-bottom: 14px; }
    .ld .ld-note-form.is-open { display: flex; }
    .ld .ld-note-form .ld-input { border-radius: 10px; background: #fff; border-color: var(--ld-line); }
    .ld .ld-empty { color: var(--ld-muted); font-size: 14px; padding: 4px 0 12px; }

    /* Timeline */
    .ld .ld-timeline { list-style: none; margin: 0; padding: 0; }
    .ld .ld-timeline li {
        display: flex; align-items: center; gap: 14px;
        padding: 9px 0; font-size: 14.5px;
    }
    .ld .ld-timeline .ld-tl-dot { width: 11px; height: 11px; border-radius: 50%; background: var(--ld-blue); flex: none; }
    .ld .ld-timeline .ld-tl-text { flex: 1; }
    .ld .ld-timeline .ld-tl-date { color: var(--ld-muted); font-size: 13px; }

    /* Edit modal */
    .ld-modal-backdrop {
        position: fixed; inset: 0; background: rgba(15,23,42,.45);
        display: none; align-items: center; justify-content: center; z-index: 1080; padding: 16px;
    }
    .ld-modal-backdrop.is-open { display: flex; }
    .ld-modal {
        background: #fff; border-radius: 14px; width: 100%; max-width: 480px;
        padding: 26px; box-shadow: 0 24px 60px rgba(15,23,42,.3);
    }
    .ld-modal h5 { font-size: 18px; font-weight: 700; margin-bottom: 18px; }
    .ld-modal label { display: block; font-size: 13px; font-weight: 600; color: #7b8497; margin: 12px 0 5px; }
    .ld-modal input {
        width: 100%; border: 1px solid #e3e7ef; border-radius: 10px;
        padding: 10px 14px; font-size: 14px; color: #1b2233;
    }
    .ld-modal input:focus-visible { outline: 3px solid rgba(11,111,240,.35); outline-offset: 1px; }
    .ld-modal-foot { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }

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

    @media (max-width: 575.98px) {
        .ld .ld-card { padding: 18px; }
        .ld .ld-actions { width: 100%; }
        .ld .ld-actions .ld-btn { flex: 1; }
        .ld .ld-msg { max-width: 90%; }
        .ld .ld-chat-body { padding-left: 16px; padding-right: 16px; }
        .ld .ld-composer { padding-left: 16px; padding-right: 16px; }
        .ld .ld-status-head { flex-direction: column; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ld .ld-chat-body { scroll-behavior: auto; }
        .ld .ld-step::before, .ld .ld-dot, .ld-toast { transition: none; }
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
                        <li class="breadcrumb-item"><a href=""><i class="bi bi-house"></i></a></li>
                        <li class="breadcrumb-item"><a href="">List</a></li>
                        <li class="breadcrumb-item active">Lead Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="ld  mt-3" id="leadPage">

        {{-- ============ Profile header ============ --}}
        <div class="ld-card">
            <div class="ld-profile">
                <div class="ld-avatar" id="leadAvatar">A</div>

                <div class="ld-profile-info">
                    <div class="ld-name-row">
                        <h2 class="ld-name" id="leadName">Anita Desai</h2>
                        <span class="ld-pill" id="leadStatusPill" data-status="Contacted">Contacted</span>
                    </div>
                    <div class="ld-meta">
                        <span id="leadPhone">+91 99001 55678</span>
                        <i class="ld-meta-sep"></i>
                        <span id="leadEmail">anita.d@email.com</span>
                        <i class="ld-meta-sep"></i>
                        <span id="leadCity">Bengaluru</span>
                    </div>
                    <div class="ld-meta">
                        <span>Source: Facebook</span>
                        <span>Owner: Priya</span>
                        <span>Created: 12 Nov 2026</span>
                    </div>
                </div>

                <div class="ld-actions">
                    <button type="button" class="ld-btn ld-btn-primary" id="btnSendMessage">Send message</button>
                    <a class="ld-btn" id="btnCall" href="tel:+919900155678">Call</a>
                    <button type="button" class="ld-btn" id="btnEdit">Edit</button>
                </div>
            </div>
        </div>

        {{-- ============ Lead status ============ --}}
        <div class="ld-card">
            <div class="ld-status-head">
                <h5>Lead status</h5>
                <div class="ld-select-wrap">
                    <select class="ld-select" id="statusSelect" aria-label="Update status">
                        <option value="" selected disabled>Update status</option>
                        <option value="New">New</option>
                        <option value="Contacted">Contacted</option>
                        <option value="Follow-up">Follow-up</option>
                        <option value="Converted">Converted</option>
                        <option value="Lost">Lost</option>
                    </select>
                </div>
            </div>

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

        {{-- ============ Messages + side cards ============ --}}
        <div class="row g-4">
            <div class="col-12 col-lg-8">
                <div class="ld-card ld-chat">
                    <h5>Message history</h5>

                    <div class="ld-chat-body" id="chatBody" aria-live="polite">
                        <div class="ld-msg ld-msg-out">
                            <span class="ld-msg-label">Greeting sent</span>
                            Hi Anita, thank you for your interest in NPS Digital!
                            <span class="ld-msg-time">12 Nov, 10:42</span>
                        </div>
                        <div class="ld-msg ld-msg-in">
                            <span class="ld-msg-label">Anita</span>
                            Hi, I want to know more about the programme.
                            <span class="ld-msg-time">12 Nov, 11:05</span>
                        </div>
                        <div class="ld-msg ld-msg-out">
                            <span class="ld-msg-label">Follow-up sent</span>
                            Hi Anita, sharing the brochure as discussed.
                            <span class="ld-msg-time">14 Nov, 09:30</span>
                        </div>
                        <div class="ld-msg ld-msg-in">
                            <span class="ld-msg-label">Anita</span>
                            Thanks, will check and revert.
                            <span class="ld-msg-time">14 Nov, 09:48</span>
                        </div>
                    </div>

                    <div class="ld-composer">
                        <div class="ld-tpl-menu" id="tplMenu" role="menu">
                            <button type="button" role="menuitem" data-label="Greeting sent"
                                data-text="Hi {name}, thank you for your interest in NPS Digital! How can I help you today?">
                                Welcome Greeting<small>Greeting</small>
                            </button>
                            <button type="button" role="menuitem" data-label="Follow-up sent"
                                data-text="Hi {name}, just checking in. Did you get a chance to go through the brochure?">
                                Follow-up Reminder<small>Follow-up</small>
                            </button>
                            <button type="button" role="menuitem" data-label="Message sent"
                                data-text="Hi {name}, your appointment is confirmed. See you soon!">
                                Appointment Confirm<small>Reminder</small>
                            </button>
                            <button type="button" role="menuitem" data-label="Message sent"
                                data-text="Hi {name}, thank you for choosing NPS Digital. We look forward to working with you.">
                                Thank You<small>Closing</small>
                            </button>
                        </div>

                        <button type="button" class="ld-btn ld-tpl-btn" id="btnTemplates" aria-haspopup="true" aria-expanded="false" title="Pick a template">
                            <i class="bi bi-chat-square-text"></i>
                        </button>
                        <input type="text" class="ld-input" id="chatInput" placeholder="Type a message or pick a template..." autocomplete="off">
                        <button type="button" class="ld-btn ld-btn-primary" id="btnSend">Send</button>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                {{-- Notes --}}
                <div class="ld-card">
                    <h5>Notes</h5>
                    <ul class="ld-notes" id="notesList">
                        <li><span>- Interested in weekend batch.</span><button type="button" class="ld-note-del" aria-label="Delete note">&times;</button></li>
                        <li><span>- Call back on Friday 4 PM.</span><button type="button" class="ld-note-del" aria-label="Delete note">&times;</button></li>
                        <li><span>- Budget confirmed.</span><button type="button" class="ld-note-del" aria-label="Delete note">&times;</button></li>
                    </ul>
                    <div class="ld-empty" id="notesEmpty" hidden>No notes yet. Add the first note.</div>

                    <div class="ld-note-form" id="noteForm">
                        <input type="text" class="ld-input" id="noteInput" placeholder="Write a note..." maxlength="200">
                        <button type="button" class="ld-btn ld-btn-primary ld-btn-sm" id="btnNoteSave">Save</button>
                    </div>
                    <button type="button" class="ld-btn" id="btnAddNote">+ Add note</button>
                </div>

                {{-- Activity timeline --}}
                <div class="ld-card">
                    <h5>Activity timeline</h5>
                    <ul class="ld-timeline" id="timelineList">
                        <li><span class="ld-tl-dot"></span><span class="ld-tl-text">Status changed to Contacted</span><span class="ld-tl-date">14 Nov</span></li>
                        <li><span class="ld-tl-dot"></span><span class="ld-tl-text">Follow-up message sent</span><span class="ld-tl-date">14 Nov</span></li>
                        <li><span class="ld-tl-dot"></span><span class="ld-tl-text">Greeting sent automatically</span><span class="ld-tl-date">12 Nov</span></li>
                        <li><span class="ld-tl-dot"></span><span class="ld-tl-text">Lead imported</span><span class="ld-tl-date">12 Nov</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ Edit lead modal ============ --}}
    <div class="ld-modal-backdrop" id="editModal" role="dialog" aria-modal="true" aria-labelledby="editTitle">
        <div class="ld-modal">
            <h5 id="editTitle">Edit lead</h5>
            <label for="editName">Full name</label>
            <input type="text" id="editName">
            <label for="editPhone">Phone</label>
            <input type="text" id="editPhone">
            <label for="editEmail">Email</label>
            <input type="email" id="editEmail">
            <label for="editCity">City</label>
            <input type="text" id="editCity">
            <div class="ld-modal-foot">
                <button type="button" class="ld-btn ld-btn-sm" id="btnEditCancel" style="border:1px solid #e3e7ef;background:#fff;border-radius:10px;padding:8px 16px;font-weight:600;cursor:pointer">Cancel</button>
                <button type="button" class="ld-btn ld-btn-primary ld-btn-sm" id="btnEditSave" style="background:#0b6ff0;color:#fff;border:1px solid #0b6ff0;border-radius:10px;padding:8px 16px;font-weight:600;cursor:pointer">Save changes</button>
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
    var chatBody   = $('chatBody');
    var chatInput  = $('chatInput');
    var btnSend    = $('btnSend');
    var btnTpl     = $('btnTemplates');
    var tplMenu    = $('tplMenu');
    var statusSel  = $('statusSelect');
    var steps      = $('statusSteps');
    var pill       = $('leadStatusPill');
    var timeline   = $('timelineList');
    var notesList  = $('notesList');
    var notesEmpty = $('notesEmpty');
    var noteForm   = $('noteForm');
    var noteInput  = $('noteInput');
    var toastEl    = $('ldToast');
    var editModal  = $('editModal');

    var ORDER = ['New', 'Contacted', 'Follow-up', 'Converted'];
    var currentStatus = 'Contacted';
    var toastTimer = null;

    // ---------- Helpers ----------
    function pad(n) { return n < 10 ? '0' + n : '' + n; }
    var MONTHS = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    function shortDate(d) { return d.getDate() + ' ' + MONTHS[d.getMonth()]; }
    function dateTime(d)  { return shortDate(d) + ', ' + pad(d.getHours()) + ':' + pad(d.getMinutes()); }

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

    function scrollChatToBottom() { chatBody.scrollTop = chatBody.scrollHeight; }

    // ---------- Timeline ----------
    function addTimeline(text) {
        var li = el('li');
        li.appendChild(el('span', 'ld-tl-dot'));
        li.appendChild(el('span', 'ld-tl-text', text));
        li.appendChild(el('span', 'ld-tl-date', shortDate(new Date())));
        timeline.insertBefore(li, timeline.firstChild);
    }

    // ---------- Status stepper ----------
    function renderStatus(status) {
        var idx = ORDER.indexOf(status);
        var isLost = status === 'Lost';

        steps.classList.toggle('is-lost', isLost);

        Array.prototype.forEach.call(steps.children, function (li, i) {
            var dot = li.querySelector('.ld-dot');
            li.classList.remove('is-done', 'is-current');
            dot.textContent = String(i + 1);

            if (isLost) return;
            if (i < idx) {
                li.classList.add('is-done');
                dot.textContent = '\u2713';
            } else if (i === idx) {
                li.classList.add('is-current');
                dot.textContent = '\u2713';
            }
        });

        pill.textContent = status;
        pill.setAttribute('data-status', status);
    }

    statusSel.addEventListener('change', function () {
        var next = statusSel.value;
        if (!next || next === currentStatus) {
            statusSel.selectedIndex = 0;
            return;
        }
        currentStatus = next;
        renderStatus(next);
        addTimeline('Status changed to ' + next);
        toast('Status updated to ' + next);
        statusSel.selectedIndex = 0;
    });

    // ---------- Chat ----------
    function firstName() {
        return $('leadName').textContent.trim().split(' ')[0] || 'there';
    }

    function addMessage(label, text) {
        var wrap = el('div', 'ld-msg ld-msg-out');
        wrap.appendChild(el('span', 'ld-msg-label', label));
        wrap.appendChild(document.createTextNode(text));
        wrap.appendChild(el('span', 'ld-msg-time', dateTime(new Date())));
        chatBody.appendChild(wrap);
        scrollChatToBottom();
    }

    function sendMessage(label, text) {
        var message = (text || chatInput.value).trim();
        if (!message) {
            chatInput.focus();
            toast('Type a message first');
            return;
        }
        label = label || chatInput.dataset.label || 'Message sent';
        addMessage(label, message);
        addTimeline(label === 'Greeting sent' ? 'Greeting sent' : 'Message sent');
        chatInput.value = '';
        delete chatInput.dataset.label;
        closeTemplates();
    }

    btnSend.addEventListener('click', function () { sendMessage(); });
    chatInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    // Header "Send message" jumps to composer
    $('btnSendMessage').addEventListener('click', function () {
        document.querySelector('.ld-chat').scrollIntoView({ behavior: 'smooth', block: 'center' });
        chatInput.focus();
    });

    // ---------- Templates ----------
    function openTemplates() {
        tplMenu.classList.add('is-open');
        btnTpl.setAttribute('aria-expanded', 'true');
    }
    function closeTemplates() {
        tplMenu.classList.remove('is-open');
        btnTpl.setAttribute('aria-expanded', 'false');
    }

    btnTpl.addEventListener('click', function (e) {
        e.stopPropagation();
        tplMenu.classList.contains('is-open') ? closeTemplates() : openTemplates();
    });

    tplMenu.addEventListener('click', function (e) {
        var item = e.target.closest('button[data-text]');
        if (!item) return;
        chatInput.value = item.getAttribute('data-text').replace('{name}', firstName());
        chatInput.dataset.label = item.getAttribute('data-label') || 'Message sent';
        closeTemplates();
        chatInput.focus();
    });

    document.addEventListener('click', function (e) {
        if (!tplMenu.contains(e.target) && e.target !== btnTpl) closeTemplates();
    });

    // ---------- Notes ----------
    function syncNotesEmpty() {
        notesEmpty.hidden = notesList.children.length > 0;
    }

    function addNote(text) {
        var li = el('li');
        li.appendChild(el('span', '', '- ' + text));
        var del = el('button', 'ld-note-del', '\u00d7');
        del.type = 'button';
        del.setAttribute('aria-label', 'Delete note');
        li.appendChild(del);
        notesList.appendChild(li);
        syncNotesEmpty();
    }

    $('btnAddNote').addEventListener('click', function () {
        noteForm.classList.toggle('is-open');
        if (noteForm.classList.contains('is-open')) noteInput.focus();
    });

    function saveNote() {
        var value = noteInput.value.trim();
        if (!value) {
            noteInput.focus();
            return;
        }
        addNote(value);
        addTimeline('Note added');
        noteInput.value = '';
        noteForm.classList.remove('is-open');
        toast('Note added');
    }

    $('btnNoteSave').addEventListener('click', saveNote);
    noteInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') { e.preventDefault(); saveNote(); }
        if (e.key === 'Escape') { noteForm.classList.remove('is-open'); }
    });

    notesList.addEventListener('click', function (e) {
        var btn = e.target.closest('.ld-note-del');
        if (!btn) return;
        btn.parentNode.remove();
        syncNotesEmpty();
        toast('Note deleted');
    });

    // ---------- Edit lead modal ----------
    function openEdit() {
        $('editName').value  = $('leadName').textContent.trim();
        $('editPhone').value = $('leadPhone').textContent.trim();
        $('editEmail').value = $('leadEmail').textContent.trim();
        $('editCity').value  = $('leadCity').textContent.trim();
        editModal.classList.add('is-open');
        $('editName').focus();
    }
    function closeEdit() { editModal.classList.remove('is-open'); }

    $('btnEdit').addEventListener('click', openEdit);
    $('btnEditCancel').addEventListener('click', closeEdit);
    editModal.addEventListener('click', function (e) { if (e.target === editModal) closeEdit(); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeEdit(); });

    $('btnEditSave').addEventListener('click', function () {
        var name  = $('editName').value.trim();
        var phone = $('editPhone').value.trim();
        if (!name || !phone) {
            toast('Name and phone are required');
            return;
        }
        $('leadName').textContent  = name;
        $('leadPhone').textContent = phone;
        $('leadEmail').textContent = $('editEmail').value.trim();
        $('leadCity').textContent  = $('editCity').value.trim();
        $('leadAvatar').textContent = name.charAt(0).toUpperCase();
        $('btnCall').setAttribute('href', 'tel:' + phone.replace(/[^\d+]/g, ''));
        addTimeline('Lead details edited');
        closeEdit();
        toast('Lead details saved');
    });

    // ---------- Call ----------
    $('btnCall').addEventListener('click', function () {
        addTimeline('Call started');
    });

    // ---------- Init ----------
    renderStatus(currentStatus);
    syncNotesEmpty();
    scrollChatToBottom();
})();
</script>
@endpush
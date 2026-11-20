@extends('admin.layouts.app')

@section('title', 'Add / Import')

@section('style')
<style>
    /* ---------- Add / Import (all classes prefixed ai- to avoid clashes) ---------- */
    .ai {
        --ai-blue: #021b45;
        --ai-blue-tint: #e6ecf7;
        --ai-dash: #2f6fd6;
        --ai-ink: #1b2233;
        --ai-muted: #6b7a90;
        --ai-line: #dfe5ee;
        --ai-bg: #ffffff;
        --ai-head: #f4f6fa;
        --ai-orange: #e88700;
        --ai-red: #c62828;
        color: var(--ai-ink);
    }

    /* Radio switch */
    .ai-switch {
        display: inline-flex; gap: 4px; padding: 4px; margin-bottom: 18px;
        background: var(--ai-bg); border: 1px solid var(--ai-line); border-radius: 12px;
    }
    .ai-opt { position: relative; margin: 0; cursor: pointer; }
    .ai-opt input { position: absolute; opacity: 0; inset: 0; width: 100%; height: 100%; margin: 0; cursor: pointer; }
    .ai-opt span {
        display: block; padding: 9px 26px; border-radius: 9px;
        font-size: 14px; font-weight: 600; color: var(--ai-muted);
        transition: background .15s, color .15s;
    }
    .ai-opt input:checked + span { background: var(--ai-blue); color: #fff; }
    .ai-opt input:focus-visible + span { outline: 3px solid rgba(2,27,69,.3); outline-offset: 2px; }

    /* Cards */
    .ai-card { background: var(--ai-bg); border: 1px solid var(--ai-line); border-radius: 14px; padding: 26px 26px 28px; }
    .ai-card[hidden] { display: none; }
    .ai-card h4 { margin: 0 0 4px; font-size: 19px; font-weight: 700; }
    .ai-sub { margin: 0 0 22px; font-size: 13px; color: var(--ai-muted); }

    /* Card header row (title left, sample button right) */
    .ai-head-row {
        display: flex; align-items: flex-start; justify-content: space-between;
        flex-wrap: wrap; gap: 14px; margin-bottom: 22px;
    }
    .ai-head-row .ai-sub { margin: 0; }

    /* Highlighted "Download sample file" button */
    .ai-sample-btn {
        display: inline-flex; align-items: center; gap: 10px;
        height: 46px; padding: 0 20px 0 12px; cursor: pointer; white-space: nowrap;
        background: var(--ai-blue-tint); color: var(--ai-blue);
        border: 1.5px solid #c4d3ee; border-radius: 12px;
        font-size: 14px; font-weight: 700;
        transition: background .18s, color .18s, border-color .18s, box-shadow .18s, transform .1s;
    }
    .ai-sample-btn .ai-sample-ico {
        width: 28px; height: 28px; border-radius: 8px; flex: none;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--ai-blue); color: #fff; font-size: 14px;
        transition: background .18s, color .18s;
    }
    .ai-sample-btn:hover {
        background: var(--ai-blue); color: #fff; border-color: var(--ai-blue);
        box-shadow: 0 8px 18px rgba(2,27,69,.22);
    }
    .ai-sample-btn:hover .ai-sample-ico { background: #fff; color: var(--ai-blue); }
    .ai-sample-btn:active { transform: translateY(1px); }
    .ai-sample-btn:focus-visible { outline: 3px solid rgba(2,27,69,.28); outline-offset: 2px; }

    /* Form */
    .ai-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 20px; }
    .ai-full { grid-column: 1 / -1; }
    .ai-field label.ai-label {
        display: block; margin-bottom: 6px;
        font-size: 11.5px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: var(--ai-muted);
    }
    .ai-field label.ai-label i { color: var(--ai-red); font-style: normal; }
    .ai-input, .ai-select, .ai-textarea {
        width: 100%; height: 46px; padding: 0 14px;
        border: 1px solid var(--ai-line); border-radius: 10px; background-color: #fff;
        font-size: 14px; color: var(--ai-ink);
    }
    .ai-input::placeholder, .ai-textarea::placeholder { color: #98a4b6; }
    .ai-textarea { height: 120px; padding: 12px 14px; resize: vertical; }
    .ai-select {
        appearance: none; -webkit-appearance: none; cursor: pointer; padding-right: 36px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1.5l5 5 5-5' fill='none' stroke='%236b7a90' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 14px center;
    }
    .ai-input:focus, .ai-select:focus, .ai-textarea:focus,
    .ai-prefix:focus-within { outline: 3px solid rgba(2,27,69,.16); border-color: var(--ai-blue); }

    .ai-prefix {
        display: flex; align-items: center; height: 46px;
        border: 1px solid var(--ai-line); border-radius: 10px; background: #fff; overflow: hidden;
    }
    .ai-prefix span { padding: 0 4px 0 14px; font-size: 14px; color: var(--ai-ink); }
    .ai-prefix .ai-input { border: 0; border-radius: 0; height: 100%; padding-left: 6px; outline: 0; }

    .ai-field.has-error .ai-input,
    .ai-field.has-error .ai-prefix { border-color: var(--ai-red); }
    .ai-err { display: none; margin-top: 5px; font-size: 12px; color: var(--ai-red); }
    .ai-field.has-error .ai-err { display: block; }

    /* Checkbox / radio styled as checkbox */
    .ai-check { display: inline-flex; align-items: center; gap: 10px; font-size: 13.5px; cursor: pointer; margin: 0; }
    .ai-chk {
        appearance: none; -webkit-appearance: none; flex: none;
        width: 20px; height: 20px; margin: 0; cursor: pointer;
        border: 1.5px solid #b9c3d3; border-radius: 5px; background: #fff;
        display: inline-grid; place-content: center;
    }
    .ai-chk:checked { background: var(--ai-blue); border-color: var(--ai-blue); }
    .ai-chk:checked::after {
        content: ""; width: 5px; height: 10px; border: solid #fff; border-width: 0 2px 2px 0;
        transform: translateY(-1px) rotate(45deg);
    }
    .ai-chk:focus-visible { outline: 3px solid rgba(2,27,69,.25); outline-offset: 2px; }

    /* Buttons */
    .ai-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-top: 24px; }
    .ai-btn {
        height: 46px; padding: 0 30px; border-radius: 10px; cursor: pointer; white-space: nowrap;
        border: 1px solid var(--ai-line); background: #fff; color: var(--ai-ink);
        font-size: 14px; font-weight: 700; transition: background .15s, opacity .15s;
    }
    .ai-btn:hover:not(:disabled) { background: #f3f6fb; }
    .ai-btn:focus-visible { outline: 3px solid rgba(2,27,69,.28); outline-offset: 2px; }
    .ai-btn:disabled { opacity: .5; cursor: not-allowed; }
    .ai-btn-primary { background: var(--ai-blue); border-color: var(--ai-blue); color: #fff; }
    .ai-btn-primary:hover:not(:disabled) { background: #0a2d68; }

    /* Stepper */
    .ai-steps { display: flex; flex-wrap: wrap; gap: 14px 34px; margin-bottom: 22px; }
    .ai-step { display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--ai-muted); }
    .ai-step b {
        width: 28px; height: 28px; border-radius: 50%; display: grid; place-items: center;
        background: #e3e8f0; color: var(--ai-muted); font-size: 12.5px;
    }
    .ai-step.is-active { color: var(--ai-ink); font-weight: 700; }
    .ai-step.is-active b, .ai-step.is-done b { background: var(--ai-blue); color: #fff; }
    .ai-step.is-done { color: var(--ai-ink); }

    /* Dropzone */
    .ai-drop {
        border: 2px dashed var(--ai-dash); border-radius: 14px; background: #fbfcff;
        padding: 40px 20px; text-align: center; transition: background .15s, border-color .15s;
    }
    .ai-drop.is-over { background: #eef4ff; border-color: var(--ai-blue); }
    .ai-drop.has-error { border-color: var(--ai-red); }
    .ai-drop h6 { margin: 0 0 8px; font-size: 15px; font-weight: 700; }
    .ai-drop p { margin: 0 0 16px; font-size: 12px; color: var(--ai-muted); }
    .ai-file { display: none; align-items: center; justify-content: center; flex-wrap: wrap; gap: 14px; }
    .ai-file strong { font-size: 14px; word-break: break-all; }
    .ai-file small { display: block; color: var(--ai-muted); font-size: 12px; margin-top: 2px; }
    .ai-drop.has-file .ai-empty { display: none; }
    .ai-drop.has-file .ai-file { display: flex; }
    .ai-drop-err { display: none; margin-top: 8px; font-size: 12.5px; color: var(--ai-red); }
    .ai-drop-err.is-on { display: block; }

    /* Mapping + review (visible once a file is chosen) */
    .ai-after { display: none; }
    .ai-after.is-on { display: block; }
    .ai-h { margin: 26px 0 12px; font-size: 14.5px; font-weight: 700; }
    .ai-map { border: 1px solid var(--ai-line); border-radius: 12px; background: var(--ai-head); padding: 6px 14px 14px; }
    .ai-map-head, .ai-map-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; align-items: center; }
    .ai-map-head { padding: 12px 0 8px; font-size: 11px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: var(--ai-muted); }
    .ai-map-row { padding: 5px 0; font-size: 13.5px; }
    .ai-map-row .ai-select { height: 38px; font-size: 13px; }
    .ai-map-row .ai-col { word-break: break-word; }
    .ai-map-msg { display: none; margin: 10px 0 0; font-size: 12.5px; color: var(--ai-red); }
    .ai-map-msg.is-on { display: block; }

    .ai-dup { margin: 18px 0 12px; font-size: 13.5px; font-weight: 700; color: var(--ai-orange); }
    .ai-dup[hidden] { display: none; }
    .ai-dup-opts { display: flex; flex-wrap: wrap; gap: 14px 32px; }
    .ai-import-row { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; margin-top: 24px; }
    .ai-import-row .ai-btn-primary { min-width: 220px; }

    /* Toast */
    .ai-toast {
        position: fixed; right: 20px; bottom: 20px; z-index: 2100; max-width: 320px;
        background: var(--ai-ink); color: #fff; padding: 12px 18px; border-radius: 10px; font-size: 14px;
        opacity: 0; transform: translateY(10px); transition: opacity .25s, transform .25s; pointer-events: none;
    }
    .ai-toast.is-show { opacity: 1; transform: none; }

    @media (max-width: 575.98px) {
        .ai-grid { grid-template-columns: 1fr; }
        .ai-card { padding: 20px 16px 22px; }
        .ai-map-head, .ai-map-row { grid-template-columns: 1fr; gap: 6px; }
        .ai-map-head span:last-child { display: none; }
        .ai-sample-btn { width: 100%; justify-content: center; }
    }
    @media (prefers-reduced-motion: reduce) {
        .ai-toast, .ai-opt span, .ai-sample-btn, .ai-sample-ico { transition: none; }
    }
</style>
@endsection

@section('content')
<div class="">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Add / Import</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href=""><i class="bi bi-house"></i></a></li>
                        <li class="breadcrumb-item active">Add / Import</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mb-3 pb-3">
    <div class="ai">

        {{-- Radio switch --}}
        <div class="ai-switch" role="radiogroup" aria-label="Add or import leads">
            <label class="ai-opt">
                <input type="radio" name="aiMode" value="add" checked>
                <span>Add lead</span>
            </label>
            <label class="ai-opt">
                <input type="radio" name="aiMode" value="import">
                <span>Import leads</span>
            </label>
        </div>

        {{-- ============ ADD A SINGLE LEAD ============ --}}
        <section class="ai-card" id="aiAddPanel">
            <h4>Add a single lead</h4>
            <p class="ai-sub">Fill in the details and save</p>

            <form id="aiForm" novalidate>
                <div class="ai-grid">
                    <div class="ai-field" id="aiNameField">
                        <label class="ai-label" for="aiName">Full name <i>*</i></label>
                        <input type="text" class="ai-input" id="aiName" placeholder="Enter name" autocomplete="off">
                        <div class="ai-err">Enter the lead's full name.</div>
                    </div>

                    <div class="ai-field" id="aiPhoneField">
                        <label class="ai-label" for="aiPhone">Phone <i>*</i></label>
                        <div class="ai-prefix">
                            <span>+91</span>
                            <input type="tel" class="ai-input" id="aiPhone" placeholder="10-digit mobile number" maxlength="10" inputmode="numeric">
                        </div>
                        <div class="ai-err">Enter a valid 10-digit mobile number.</div>
                    </div>

                    <div class="ai-field" id="aiEmailField">
                        <label class="ai-label" for="aiEmail">Email</label>
                        <input type="email" class="ai-input" id="aiEmail" placeholder="name@email.com">
                        <div class="ai-err">Enter a valid email address.</div>
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiCity">City</label>
                        <input type="text" class="ai-input" id="aiCity" placeholder="Bengaluru">
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiSource">Source</label>
                        <select class="ai-select" id="aiSource">
                            <option>Website</option>
                            <option>Facebook</option>
                            <option>Instagram</option>
                            <option>Referral</option>
                            <option>Walk-in</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiInterest">Interested in</label>
                        <select class="ai-select" id="aiInterest">
                            <option>Course / Service</option>
                            <option>Product</option>
                            <option>Consultation</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="ai-field ">
                        <label class="ai-label" for="aiStatus">Status</label>
                        <select class="ai-select" id="aiStatus">
                            <option>New</option>
                            <option>Contacted</option>
                            <option>Follow-up</option>
                            <option>Converted</option>
                        </select>
                    </div>

                    <div class="ai-field ">
                        <label class="ai-label" for="aiNotes">Notes</label>
                        <textarea class="ai-textarea" id="aiNotes" placeholder="Add any notes about this lead..."></textarea>
                    </div>

                    <div class="ai-full">
                        <label class="ai-check">
                            <input type="checkbox" class="ai-chk" id="aiGreet" checked>
                            Send greeting message automatically after saving
                        </label>
                    </div>
                </div>

                <div class="ai-actions">
                    <button type="submit" class="ai-btn ai-btn-primary">Save Lead</button>
                    <button type="button" class="ai-btn" id="aiCancel">Cancel</button>
                </div>
            </form>
        </section>

        {{-- ============ IMPORT LEADS IN BULK ============ --}}
        <section class="ai-card" id="aiImportPanel" hidden>

            {{-- Header: title left, highlighted sample button right --}}
            <div class="ai-head-row">
                <div>
                    <h4>Import leads in bulk</h4>
                    <p class="ai-sub">Upload an Excel or CSV file</p>
                </div>

                <button type="button" class="ai-sample-btn" id="aiSample">
                    <span class="ai-sample-ico"><i class="bi bi-download"></i></span>
                    Download sample file
                </button>
            </div>

            <ol class="ai-steps" id="aiSteps" style="list-style:none;padding:0;">
                <li class="ai-step is-active" data-step="1"><b>1</b> Upload</li>
                <li class="ai-step" data-step="2"><b>2</b> Map columns</li>
                <li class="ai-step" data-step="3"><b>3</b> Review</li>
            </ol>

            {{-- Dropzone --}}
            <div class="ai-drop" id="aiDrop">
                <div class="ai-empty">
                    <h6>Drag &amp; drop your file here</h6>
                    <p>.xlsx &nbsp; .csv &nbsp; (max 5 MB)</p>
                    <button type="button" class="ai-btn" id="aiBrowse">Browse files</button>
                </div>
                <div class="ai-file">
                    <div>
                        <strong id="aiFileName"></strong>
                        <small id="aiFileMeta"></small>
                    </div>
                    <button type="button" class="ai-btn" id="aiRemove" style="height:38px;padding:0 18px;">Remove file</button>
                </div>
                <input type="file" id="aiFile" accept=".xlsx,.csv" hidden>
            </div>
            <div class="ai-drop-err" id="aiDropErr" role="alert"></div>

            {{-- Mapping + review (shown after a file is chosen) --}}
            <div class="ai-after" id="aiAfter">
                <h6 class="ai-h">Column mapping preview</h6>
                <div class="ai-map">
                    <div class="ai-map-head"><span>File column</span><span>Maps to</span></div>
                    <div id="aiMapRows"></div>
                </div>
                <p class="ai-map-msg" id="aiMapMsg" role="alert"></p>

                <p class="ai-dup" id="aiDup" hidden></p>
                <div class="ai-dup-opts">
                    <label class="ai-check">
                        <input type="radio" class="ai-chk" name="aiDupMode" value="skip" checked> Skip duplicates
                    </label>
                    <label class="ai-check">
                        <input type="radio" class="ai-chk" name="aiDupMode" value="update"> Update existing
                    </label>
                </div>

                <div class="ai-import-row">
                    <button type="button" class="ai-btn ai-btn-primary" id="aiImport" disabled>Import leads</button>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="ai-toast" id="aiToast" role="status" aria-live="polite"></div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var $ = function (id) { return document.getElementById(id); };
    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    var toastTimer;
    function toast(msg) {
        var t = $('aiToast');
        t.textContent = msg;
        t.classList.add('is-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { t.classList.remove('is-show'); }, 2800);
    }
    // SweetAlert2 if the layout loads it, otherwise a simple toast
    function notify(title, text) {
        if (window.Swal) {
            Swal.fire({ icon: 'success', title: title, text: text, confirmButtonColor: '#021b45' });
        } else {
            toast(title + ' - ' + text);
        }
    }

    /* =============== Radio switch =============== */
    var panels = { add: $('aiAddPanel'), 'import': $('aiImportPanel') };
    document.querySelectorAll('input[name="aiMode"]').forEach(function (r) {
        r.addEventListener('change', function () {
            Object.keys(panels).forEach(function (k) { panels[k].hidden = (k !== r.value); });
        });
    });

    /* =============== Add a single lead =============== */
    var form = $('aiForm');

    function setError(fieldId, on) { $(fieldId).classList.toggle('has-error', on); }

    $('aiPhone').addEventListener('input', function () { this.value = this.value.replace(/\D/g, ''); });
    ['aiName', 'aiPhone', 'aiEmail'].forEach(function (id) {
        $(id).addEventListener('input', function () {
            $(id + 'Field').classList.remove('has-error');
        });
    });

    function resetForm() {
        form.reset();
        ['aiNameField', 'aiPhoneField', 'aiEmailField'].forEach(function (f) { setError(f, false); });
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var name = $('aiName').value.trim();
        var phone = $('aiPhone').value.trim();
        var email = $('aiEmail').value.trim();

        var okName = name.length > 1;
        var okPhone = /^[6-9]\d{9}$/.test(phone);
        var okEmail = email === '' || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

        setError('aiNameField', !okName);
        setError('aiPhoneField', !okPhone);
        setError('aiEmailField', !okEmail);

        if (!okName) { $('aiName').focus(); return; }
        if (!okPhone) { $('aiPhone').focus(); return; }
        if (!okEmail) { $('aiEmail').focus(); return; }

        var msg = name + ' was added to leads.' + ($('aiGreet').checked ? ' Greeting message queued.' : '');
        notify('Lead saved', msg);
        resetForm();
        $('aiName').focus();
    });

    $('aiCancel').addEventListener('click', resetForm);

    /* =============== Bulk import =============== */
    var MAX_BYTES = 5 * 1024 * 1024;
    var TARGETS = [
        { v: 'name',     t: 'Full Name' },
        { v: 'phone',    t: 'Phone' },
        { v: 'email',    t: 'Email' },
        { v: 'city',     t: 'City' },
        { v: 'source',   t: 'Source' },
        { v: 'interest', t: 'Interested in' },
        { v: 'status',   t: 'Status' },
        { v: 'notes',    t: 'Notes' },
        { v: 'skip',     t: "Don't import" }
    ];
    var DEFAULT_HEADERS = ['Customer Name', 'Mobile', 'Email ID', 'Enquiry Source'];
    var DEMO_ROWS = 248;        // used for .xlsx files (not parsed in this static design)
    var DEMO_DUPLICATES = 3;

    var imp = { file: null, headers: [], rows: 0, dups: 0 };

    function fmtSize(b) {
        return b < 1024 * 1024 ? Math.max(1, Math.round(b / 1024)) + ' KB' : (b / 1024 / 1024).toFixed(1) + ' MB';
    }

    function guessTarget(h) {
        var s = h.toLowerCase();
        if (/name/.test(s)) return 'name';
        if (/phone|mobile|contact|cell/.test(s)) return 'phone';
        if (/mail/.test(s)) return 'email';
        if (/city|location/.test(s)) return 'city';
        if (/source|enquiry|inquiry|channel/.test(s)) return 'source';
        if (/interest|course|service/.test(s)) return 'interest';
        if (/status|stage/.test(s)) return 'status';
        if (/note|remark|comment/.test(s)) return 'notes';
        return 'skip';
    }

    function setStep(n) {
        document.querySelectorAll('#aiSteps .ai-step').forEach(function (li) {
            var i = parseInt(li.dataset.step, 10);
            li.classList.toggle('is-active', i === n);
            li.classList.toggle('is-done', i < n);
            li.querySelector('b').innerHTML = i < n ? '&#10003;' : i;
        });
    }

    function showDropError(msg) {
        var el = $('aiDropErr');
        el.textContent = msg || '';
        el.classList.toggle('is-on', !!msg);
        $('aiDrop').classList.toggle('has-error', !!msg);
    }

    /* ---- file handling ---- */
    function handleFile(file) {
        showDropError('');
        if (!file) return;

        if (!/\.(xlsx|csv)$/i.test(file.name)) {
            showDropError('Unsupported file type. Upload a .xlsx or .csv file.');
            return;
        }
        if (file.size > MAX_BYTES) {
            showDropError('File is too large (' + fmtSize(file.size) + '). The limit is 5 MB.');
            return;
        }

        imp.file = file;

        if (/\.csv$/i.test(file.name)) {
            var reader = new FileReader();
            reader.onload = function () {
                var lines = String(reader.result).split(/\r?\n/).filter(function (l) { return l.trim() !== ''; });
                if (lines.length < 2) {
                    imp.file = null;
                    showDropError('This file has no data rows.');
                    return;
                }
                imp.headers = splitCsv(lines[0]);
                imp.rows = lines.length - 1;
                imp.dups = Math.min(DEMO_DUPLICATES, imp.rows);
                afterFile();
            };
            reader.readAsText(file);
        } else {
            imp.headers = DEFAULT_HEADERS.slice();
            imp.rows = DEMO_ROWS;
            imp.dups = DEMO_DUPLICATES;
            afterFile();
        }
    }

    function splitCsv(line) {
        var out = [], cur = '', q = false;
        for (var i = 0; i < line.length; i++) {
            var c = line[i];
            if (c === '"') { q = !q; }
            else if (c === ',' && !q) { out.push(cur.trim()); cur = ''; }
            else { cur += c; }
        }
        out.push(cur.trim());
        return out.map(function (h) { return h || 'Column'; });
    }

    function afterFile() {
        $('aiFileName').textContent = imp.file.name;
        $('aiFileMeta').textContent = fmtSize(imp.file.size) + ' \u00b7 ' + imp.rows + ' rows';
        $('aiDrop').classList.add('has-file');

        // mapping rows
        $('aiMapRows').innerHTML = imp.headers.map(function (h, i) {
            var guess = guessTarget(h);
            var opts = TARGETS.map(function (t) {
                return '<option value="' + t.v + '"' + (t.v === guess ? ' selected' : '') + '>' + t.t + '</option>';
            }).join('');
            return '<div class="ai-map-row"><span class="ai-col">' + esc(h) + '</span>' +
                '<select class="ai-select" data-col="' + i + '" aria-label="Map ' + esc(h) + ' to">' + opts + '</select></div>';
        }).join('');

        // duplicates
        var dup = $('aiDup');
        dup.hidden = imp.dups === 0;
        dup.textContent = 'Duplicates detected: ' + imp.dups + ' (phone numbers already exist)';

        $('aiAfter').classList.add('is-on');
        refreshImport();
    }

    function resetImport() {
        imp = { file: null, headers: [], rows: 0, dups: 0 };
        $('aiFile').value = '';
        $('aiDrop').classList.remove('has-file');
        $('aiAfter').classList.remove('is-on');
        $('aiMapRows').innerHTML = '';
        showDropError('');
        setStep(1);
    }

    /* ---- mapping validation + import button ---- */
    function currentMapping() {
        return Array.prototype.map.call(document.querySelectorAll('#aiMapRows select'), function (s) { return s.value; });
    }

    function refreshImport() {
        var map = currentMapping();
        var used = map.filter(function (v) { return v !== 'skip'; });
        var seen = {}, dupTarget = null;
        used.forEach(function (v) { if (seen[v]) dupTarget = v; seen[v] = true; });

        var msg = '';
        if (dupTarget) {
            var label = TARGETS.filter(function (t) { return t.v === dupTarget; })[0].t;
            msg = '"' + label + '" is mapped more than once. Map each field to one column.';
        } else if (!seen.name || !seen.phone) {
            msg = 'Map one column to Full Name and one to Phone to continue.';
        }

        var m = $('aiMapMsg');
        m.textContent = msg;
        m.classList.toggle('is-on', !!msg);

        var ok = imp.file && !msg;
        var mode = document.querySelector('input[name="aiDupMode"]:checked').value;
        var count = mode === 'skip' ? Math.max(0, imp.rows - imp.dups) : imp.rows;

        var btn = $('aiImport');
        btn.disabled = !ok || count === 0;
        btn.textContent = 'Import ' + count + (count === 1 ? ' lead' : ' leads');

        setStep(!imp.file ? 1 : (ok ? 3 : 2));
    }

    $('aiMapRows').addEventListener('change', refreshImport);
    document.querySelectorAll('input[name="aiDupMode"]').forEach(function (r) {
        r.addEventListener('change', refreshImport);
    });

    $('aiImport').addEventListener('click', function () {
        var btn = this;
        var mode = document.querySelector('input[name="aiDupMode"]:checked').value;
        var count = mode === 'skip' ? Math.max(0, imp.rows - imp.dups) : imp.rows;
        var dups = imp.dups;

        btn.disabled = true;
        btn.textContent = 'Importing...';
        setTimeout(function () {
            var detail = count + ' leads imported.' +
                (dups ? (mode === 'skip' ? ' ' + dups + ' duplicates skipped.' : ' ' + dups + ' existing leads updated.') : '');
            notify('Import complete', detail);
            resetImport();
        }, 1200);
    });

    /* ---- dropzone events ---- */
    var drop = $('aiDrop');
    $('aiBrowse').addEventListener('click', function () { $('aiFile').click(); });
    $('aiFile').addEventListener('change', function () { handleFile(this.files[0]); });
    $('aiRemove').addEventListener('click', resetImport);

    ['dragenter', 'dragover'].forEach(function (ev) {
        drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('is-over'); });
    });
    ['dragleave', 'drop'].forEach(function (ev) {
        drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.remove('is-over'); });
    });
    drop.addEventListener('drop', function (e) {
        if (imp.file) return;
        handleFile(e.dataTransfer.files[0]);
    });
    // stop the browser from opening a file dropped outside the zone
    ['dragover', 'drop'].forEach(function (ev) {
        window.addEventListener(ev, function (e) { e.preventDefault(); });
    });

    /* ---- sample file ---- */
    function downloadSample() {
        var csv = 'Customer Name,Mobile,Email ID,Enquiry Source,City\r\n' +
                  'Rahul Verma,9845011223,rahul@example.com,Website,Bengaluru\r\n' +
                  'Anita Desai,9900155678,anita@example.com,Facebook,Mysuru\r\n';
        var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'leads-sample.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        setTimeout(function () { URL.revokeObjectURL(url); }, 500);
        toast('Sample file downloaded');
    }
    $('aiSample').addEventListener('click', downloadSample);
})();
</script>
@endpush
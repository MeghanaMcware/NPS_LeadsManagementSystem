@extends('admin.layouts.app')

@section('title', 'Add / Import Leads')

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

    /* Card header row */
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
        text-decoration: none;
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

    /* Mapping + review */
    .ai-after { display: none; }
    .ai-after.is-on { display: block; }
    .ai-h { margin: 26px 0 12px; font-size: 14.5px; font-weight: 700; }
    .ai-map { border: 1px solid var(--ai-line); border-radius: 12px; background: var(--ai-head); padding: 6px 14px 14px; }
    .ai-map-head, .ai-map-row { display: grid; grid-template-columns: 1.2fr 1fr; gap: 16px; align-items: center; }
    .ai-map-head { padding: 12px 0 8px; font-size: 11px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: var(--ai-muted); }
    .ai-map-row { padding: 5px 0; font-size: 13.5px; }
    .ai-map-row .ai-select { height: 38px; font-size: 13px; }
    .ai-map-row .ai-col { word-break: break-word; font-weight: 600; }
    .ai-map-msg { display: none; margin: 10px 0 0; font-size: 12.5px; color: var(--ai-red); }
    .ai-map-msg.is-on { display: block; }

    .ai-dup { margin: 18px 0 12px; font-size: 13.5px; font-weight: 700; color: var(--ai-orange); }
    .ai-dup[hidden] { display: none; }
    .ai-dup-opts { display: flex; flex-wrap: wrap; gap: 14px 32px; }
    .ai-import-row { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; margin-top: 24px; }

    /* Toast */
    .ai-toast {
        position: fixed; right: 20px; bottom: 20px; z-index: 2100;
        background: var(--ai-ink); color: #fff; padding: 12px 18px; border-radius: 10px; font-size: 14px;
        opacity: 0; transform: translateY(10px); transition: opacity .25s, transform .25s; pointer-events: none;
    }
    .ai-toast.is-show { opacity: 1; transform: none; }

    @media (max-width: 767.98px) {
        .ai-grid { grid-template-columns: 1fr; }
        .ai-map-head, .ai-map-row { grid-template-columns: 1fr; gap: 6px; }
    }
</style>
@endsection

@section('content')
<div class="">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Add / Import Leads</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-house"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Add / Import</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="ai">

        {{-- Radio-style switch: Add single lead vs Import leads in bulk --}}
        <div class="ai-switch" role="radiogroup" aria-label="Mode">
            <label class="ai-opt">
                <input type="radio" name="aiMode" value="add" checked>
                <span>Add single lead</span>
            </label>
            <label class="ai-opt">
                <input type="radio" name="aiMode" value="import">
                <span>Import leads in bulk</span>
            </label>
        </div>

        {{-- ============ ADD A SINGLE LEAD ============ --}}
        <section class="ai-card" id="aiAddPanel">
            <h4>Add a single lead</h4>
            <p class="ai-sub">Fill in the student or parent inquiry details and save</p>

            <form id="aiForm" novalidate>
                <div class="ai-grid">
                    <div class="ai-field" id="aiNameField">
                        <label class="ai-label" for="aiName">Full Name <i>*</i></label>
                        <input type="text" class="ai-input" id="aiName" placeholder="e.g. Anand Kumar" autocomplete="off" required>
                        <div class="ai-err">Enter the student or parent's name.</div>
                    </div>

                    <div class="ai-field" id="aiPhoneField">
                        <label class="ai-label" for="aiPhone">Phone Number <i>*</i></label>
                        <div class="ai-prefix">
                            <span>+91</span>
                            <input type="tel" class="ai-input" id="aiPhone" placeholder="10-digit mobile number" maxlength="10" inputmode="numeric" required>
                        </div>
                        <div class="ai-err">Enter a valid 10-digit mobile number.</div>
                    </div>

                    <div class="ai-field" id="aiEmailField">
                        <label class="ai-label" for="aiEmail">Email</label>
                        <input type="email" class="ai-input" id="aiEmail" placeholder="parent@example.com">
                        <div class="ai-err">Enter a valid email address.</div>
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiCity">City / Location</label>
                        <input type="text" class="ai-input" id="aiCity" placeholder="e.g. Anchepalya, Bengaluru">
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiInterest">Admission for which grade?</label>
                        <input type="text" class="ai-input" id="aiInterest" placeholder="e.g. Grade 1, UKG, PP1">
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiTime">Preferred time to call</label>
                        <input type="text" class="ai-input" id="aiTime" placeholder="e.g. Morning 10 AM - 12 PM">
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiSource">Source</label>
                        <select class="ai-select" id="aiSource">
                            <option value="Google Form" selected>Google Form</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Website">Website</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Walk-in">Walk-in</option>
                        </select>
                    </div>

                    <div class="ai-field">
                        <label class="ai-label" for="aiStatus">Status</label>
                        <select class="ai-select" id="aiStatus">
                            <option value="new" selected>New</option>
                            <option value="contacted">Contacted</option>
                            <option value="followup">Follow-up</option>
                            <option value="converted">Converted</option>
                            <option value="lost">Lost</option>
                        </select>
                    </div>

                    <div class="ai-full">
                        <label class="ai-label" for="aiRemarks">Remarks / Inquiry Notes</label>
                        <textarea class="ai-textarea" id="aiRemarks" placeholder="Add any initial remarks or enquiry details..."></textarea>
                    </div>
                </div>

                <div class="ai-actions">
                    <button type="submit" class="ai-btn ai-btn-primary" id="aiSaveBtn">Save Lead</button>
                    <button type="button" class="ai-btn" id="aiCancel">Reset Form</button>
                </div>
            </form>
        </section>

        {{-- ============ IMPORT LEADS IN BULK ============ --}}
        <section class="ai-card" id="aiImportPanel" hidden>

            <div class="ai-head-row">
                <div>
                    <h4>Import leads in bulk</h4>
                    <p class="ai-sub">Upload an Excel (.xlsx) or CSV spreadsheet from Google Forms or WhatsApp</p>
                </div>

                <a href="{{ route('leadsimport.sample') }}" class="ai-sample-btn" id="aiSample">
                    <span class="ai-sample-ico"><i class="bi bi-download"></i></span>
                    Download sample file
                </a>
            </div>

            <ol class="ai-steps" id="aiSteps" style="list-style:none;padding:0;">
                <li class="ai-step is-active" data-step="1"><b>1</b> Upload file</li>
                <li class="ai-step" data-step="2"><b>2</b> Column mapping</li>
                <li class="ai-step" data-step="3"><b>3</b> Review &amp; Import</li>
            </ol>

            {{-- Dropzone --}}
            <div class="ai-drop" id="aiDrop">
                <div class="ai-empty">
                    <h6>Drag &amp; drop your spreadsheet here</h6>
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
                <h6 class="ai-h">Column Mapping &amp; Normalization</h6>
                <div class="ai-map">
                    <div class="ai-map-head"><span>Spreadsheet Column Header</span><span>Maps to Lead Field</span></div>
                    <div id="aiMapRows"></div>
                </div>
                <p class="ai-map-msg" id="aiMapMsg" role="alert"></p>

                <div class="row g-3 mt-2 align-items-center">
                    <div class="col-12 col-md-6">
                        <label class="ai-label" for="aiBatchSource">Assign Lead Source</label>
                        <select class="ai-select" id="aiBatchSource">
                            <option value="Google Form" selected>Google Form</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Website">Website</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Walk-in">Walk-in</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="ai-dup mb-1" id="aiDup" hidden></p>
                        <div class="ai-dup-opts">
                            <label class="ai-check">
                                <input type="radio" class="ai-chk" name="aiDupMode" value="skip" checked> Skip duplicates
                            </label>
                            <label class="ai-check">
                                <input type="radio" class="ai-chk" name="aiDupMode" value="update"> Update existing leads
                            </label>
                        </div>
                    </div>
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

    var csrfToken = document.querySelector('meta[name="csrf-token"]') ?
                    document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}';

    var toastTimer;
    function toast(msg) {
        var t = $('aiToast');
        t.textContent = msg;
        t.classList.add('is-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { t.classList.remove('is-show'); }, 3000);
    }

    function notify(title, text, isSuccess) {
        if (window.Swal) {
            Swal.fire({
                icon: isSuccess !== false ? 'success' : 'error',
                title: title,
                text: text,
                confirmButtonColor: '#021b45'
            });
        } else {
            toast(title + ' - ' + text);
        }
    }

    /* =============== Tab Switch =============== */
    var panels = { add: $('aiAddPanel'), 'import': $('aiImportPanel') };
    document.querySelectorAll('input[name="aiMode"]').forEach(function (r) {
        r.addEventListener('change', function () {
            Object.keys(panels).forEach(function (k) { panels[k].hidden = (k !== r.value); });
        });
    });

    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('mode') === 'import' || window.location.hash === '#import') {
        var importRadio = document.querySelector('input[name="aiMode"][value="import"]');
        if (importRadio) {
            importRadio.checked = true;
            panels.add.hidden = true;
            panels.import.hidden = false;
        }
    }

    /* =============== Add Single Lead =============== */
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

        var okName = name.length >= 2;
        var okPhone = /^[6-9]\d{9}$/.test(phone);
        var okEmail = email === '' || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

        setError('aiNameField', !okName);
        setError('aiPhoneField', !okPhone);
        setError('aiEmailField', !okEmail);

        if (!okName) { $('aiName').focus(); return; }
        if (!okPhone) { $('aiPhone').focus(); return; }
        if (!okEmail) { $('aiEmail').focus(); return; }

        var saveBtn = $('aiSaveBtn');
        saveBtn.disabled = true;
        saveBtn.textContent = 'Saving...';

        fetch('{{ route("leadsimport.single") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: name,
                phone: phone,
                email: email,
                city: $('aiCity').value.trim(),
                interested_in: $('aiInterest').value.trim(),
                preferred_time_to_call: $('aiTime').value.trim(),
                source: $('aiSource').value,
                status: $('aiStatus').value,
                remarks: $('aiRemarks').value.trim()
            })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save Lead';
            if (data.success) {
                notify('Lead saved', data.message || (name + ' was saved successfully.'));
                resetForm();
            } else {
                notify('Error', data.message || 'Could not save lead.', false);
            }
        })
        .catch(function () {
            saveBtn.disabled = false;
            saveBtn.textContent = 'Save Lead';
            notify('Error', 'An unexpected network error occurred.', false);
        });
    });

    $('aiCancel').addEventListener('click', resetForm);

    /* =============== Bulk Import =============== */
    var MAX_BYTES = 5 * 1024 * 1024;
    var TARGETS = [
        { v: 'name',                   t: 'Name' },
        { v: 'phone',                  t: 'Phone Number' },
        { v: 'interested_in',          t: 'Admission for which grade?' },
        { v: 'remarks',                t: 'Remarks' },
        { v: 'city',                   t: 'City' },
        { v: 'preferred_time_to_call', t: 'Preferred time to call' },
        { v: 'email',                  t: 'Email' },
        { v: 'skip',                   t: "Don't import (Skip)" }
    ];

    var imp = { file: null, file_token: null, headers: [], rows: 0, dups: 0, mapping: {} };

    function fmtSize(b) {
        return b < 1024 * 1024 ? Math.max(1, Math.round(b / 1024)) + ' KB' : (b / 1024 / 1024).toFixed(1) + ' MB';
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

    function handleFile(file) {
        showDropError('');
        if (!file) return;

        if (!/\.(xlsx|csv)$/i.test(file.name)) {
            showDropError('Unsupported file type. Please upload a .xlsx or .csv file.');
            return;
        }
        if (file.size > MAX_BYTES) {
            showDropError('File is too large (' + fmtSize(file.size) + '). The limit is 5 MB.');
            return;
        }

        imp.file = file;
        $('aiFileName').textContent = file.name;
        $('aiFileMeta').textContent = fmtSize(file.size) + ' · Reading spreadsheet...';
        $('aiDrop').classList.add('has-file');

        var formData = new FormData();
        formData.append('file', file);
        formData.append('_token', csrfToken);

        fetch('{{ route("leadsimport.preview") }}', {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (!data.success) {
                resetImport();
                showDropError(data.message || 'Failed to parse file.');
                return;
            }

            imp.file_token = data.file_token;
            imp.headers = data.headers;
            imp.rows = data.total_rows;
            imp.dups = data.duplicate_count;
            imp.mapping = data.suggested_mapping || {};

            $('aiFileMeta').textContent = fmtSize(file.size) + ' · ' + data.total_rows + ' rows detected';

            // Render mapping rows
            $('aiMapRows').innerHTML = data.headers.map(function (h, i) {
                var suggested = imp.mapping[i] || 'skip';
                var opts = TARGETS.map(function (t) {
                    return '<option value="' + t.v + '"' + (t.v === suggested ? ' selected' : '') + '>' + t.t + '</option>';
                }).join('');
                return '<div class="ai-map-row">' +
                    '<span class="ai-col">' + esc(h) + '</span>' +
                    '<select class="ai-select" data-col="' + i + '" aria-label="Map ' + esc(h) + ' to">' + opts + '</select>' +
                    '</div>';
            }).join('');

            // Duplicates
            var dup = $('aiDup');
            dup.hidden = imp.dups === 0;
            dup.textContent = 'Duplicates detected: ' + imp.dups + ' (phone numbers already in system)';

            $('aiAfter').classList.add('is-on');
            refreshImport();
        })
        .catch(function () {
            resetImport();
            showDropError('Failed to upload and parse file. Please check file format.');
        });
    }

    function resetImport() {
        imp = { file: null, file_token: null, headers: [], rows: 0, dups: 0, mapping: {} };
        $('aiFile').value = '';
        $('aiDrop').classList.remove('has-file');
        $('aiAfter').classList.remove('is-on');
        $('aiMapRows').innerHTML = '';
        showDropError('');
        setStep(1);
    }

    function currentMapping() {
        var map = {};
        document.querySelectorAll('#aiMapRows select').forEach(function (s) {
            map[s.dataset.col] = s.value;
        });
        return map;
    }

    function refreshImport() {
        var map = currentMapping();
        var vals = Object.values(map);
        var used = vals.filter(function (v) { return v !== 'skip'; });
        var seen = {}, dupTarget = null;
        used.forEach(function (v) {
            if (seen[v] && v !== 'remarks') {
                dupTarget = v;
            }
            seen[v] = true;
        });

        var msg = '';
        if (dupTarget) {
            var label = TARGETS.filter(function (t) { return t.v === dupTarget; })[0].t;
            msg = '"' + label + '" is mapped to multiple columns. Map each field once.';
        } else if (!seen.name || !seen.phone) {
            msg = 'Map at least one column to Name and one column to Phone Number to proceed.';
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
        var defaultSource = $('aiBatchSource').value;

        btn.disabled = true;
        btn.textContent = 'Importing leads...';

        fetch('{{ route("leadsimport.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                file_token: imp.file_token,
                mapping: currentMapping(),
                dup_mode: mode,
                default_source: defaultSource
            })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            btn.disabled = false;
            btn.textContent = 'Import leads';

            if (data.success) {
                if (window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Import Successful',
                        text: data.message,
                        showCancelButton: true,
                        confirmButtonText: 'View Leads List',
                        cancelButtonText: 'Import Another File',
                        confirmButtonColor: '#021b45'
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            window.location.href = '{{ route("leads.index") }}';
                        } else {
                            resetImport();
                        }
                    });
                } else {
                    notify('Import Complete', data.message);
                    resetImport();
                }
            } else {
                notify('Import Error', data.message || 'Failed to process import.', false);
            }
        })
        .catch(function () {
            btn.disabled = false;
            btn.textContent = 'Import leads';
            notify('Error', 'An error occurred during import processing.', false);
        });
    });

    /* ---- Dropzone Events ---- */
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
        e.preventDefault();
        drop.classList.remove('is-over');
        if (e.dataTransfer.files.length) {
            handleFile(e.dataTransfer.files[0]);
        }
    });

    ['dragover', 'drop'].forEach(function (ev) {
        window.addEventListener(ev, function (e) { e.preventDefault(); });
    });
})();
</script>
@endpush

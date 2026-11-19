@extends('admin.layouts.app')

@section('title', 'Leads')

@section('style')
<style>
    /* ---------- Leads list (all classes prefixed ls- to avoid clashes) ---------- */
    .ls {
        --ls-blue: #021b45;
        --ls-blue-tint: #e6ecf7;
        --ls-ink: #1b2233;
        --ls-muted: #6b7a90;
        --ls-line: #dfe5ee;
        --ls-bg: #ffffff;
        --ls-head: #f4f6fa;
        color: var(--ls-ink);
    }

    /* Toolbar */
    .ls-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-bottom: 16px; }
    .ls-search { flex: 1 1 220px; min-width: 180px; }
    .ls-control {
        height: 44px;
        border: 1px solid var(--ls-line);
        background: var(--ls-bg);
        border-radius: 10px;
        padding: 0 14px;
        font-size: 14px;
        color: var(--ls-ink);
        width: 100%;
    }
    .ls-control::placeholder { color: var(--ls-muted); }
    .ls-control:focus { outline: 3px solid rgba(2,27,69,.18); border-color: var(--ls-blue); }
    .ls-select { flex: 0 0 auto; width: auto; min-width: 150px; cursor: pointer; }

    .ls-toggle {
        display: inline-flex; padding: 4px; gap: 2px;
        background: var(--ls-bg); border: 1px solid var(--ls-line); border-radius: 12px;
    }
    .ls-toggle button {
        border: 0; background: transparent; color: var(--ls-muted);
        font-size: 14px; font-weight: 600; padding: 8px 26px; border-radius: 9px; cursor: pointer;
    }
    .ls-toggle button.is-on { background: var(--ls-blue); color: #fff; }
    .ls-toggle button:focus-visible { outline: 2px solid var(--ls-blue); outline-offset: 1px; }

    .ls-btn {
        height: 44px;
        border: 1px solid var(--ls-line);
        background: var(--ls-bg);
        color: var(--ls-ink);
        font-size: 14px; font-weight: 700;
        padding: 0 22px; border-radius: 10px; cursor: pointer; white-space: nowrap;
        transition: background .15s;
    }
    .ls-btn:hover { background: #f3f6fb; }
    .ls-btn:focus-visible { outline: 3px solid rgba(2,27,69,.25); outline-offset: 2px; }
    .ls-btn-primary { background: var(--ls-blue); border-color: var(--ls-blue); color: #fff; }
    .ls-btn-primary:hover { background: #0a2d68; }

    /* Selection bar */
    .ls-selbar {
        display: none; align-items: center; flex-wrap: wrap; gap: 14px;
        background: var(--ls-blue-tint);
        border: 1px solid #cfd9ee;
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 16px;
    }
    .ls-selbar.is-open { display: flex; }
    .ls-selbar .ls-count { color: var(--ls-blue); font-weight: 700; font-size: 14px; min-width: 120px; }
    .ls-selbar .ls-clear {
        margin-left: auto; border: 0; background: transparent;
        color: var(--ls-blue); font-weight: 700; font-size: 13px; cursor: pointer; padding: 6px 4px;
    }
    .ls-selbar .ls-btn { height: 42px; }
    .ls-menu-wrap { position: relative; }

    /* Menus */
    .ls-menu {
        position: absolute; top: calc(100% + 6px); left: 0; z-index: 30;
        min-width: 170px; padding: 6px;
        background: #fff; border: 1px solid var(--ls-line); border-radius: 10px;
        box-shadow: 0 12px 30px rgba(20,28,45,.14);
        display: none;
    }
    .ls-menu.is-open { display: block; }
    /* row menus are fixed so the scrolling table wrapper never clips them */
    .ls-menu.ls-row-menu { position: fixed; top: 0; left: 0; z-index: 2000; }
    .ls-menu button {
        display: flex; align-items: center; gap: 8px; width: 100%;
        border: 0; background: transparent; text-align: left;
        font-size: 13px; padding: 8px 10px; border-radius: 7px; cursor: pointer; color: var(--ls-ink);
    }
    .ls-menu button:hover, .ls-menu button:focus-visible { background: var(--ls-head); outline: none; }
    .ls-menu button.is-danger { color: #c62828; }

    /* Table card */
    .ls-card { background: var(--ls-bg); border: 1px solid var(--ls-line); border-radius: 14px; overflow: hidden; }

    /* Show entries */
    .ls-lenbar { display: flex; align-items: center; padding: 14px 16px; border-bottom: 1px solid var(--ls-line); }
    .ls-len { display: inline-flex; align-items: center; gap: 10px; font-size: 14px; margin: 0; }
    .ls-len select {
        height: 38px; min-width: 76px; padding: 0 28px 0 12px;
        border: 1px solid var(--ls-line); border-radius: 8px; background-color: #fff;
        font-size: 14px; color: var(--ls-ink); cursor: pointer;
    }
    .ls-len select:focus { outline: 3px solid rgba(2,27,69,.18); border-color: var(--ls-blue); }

    .ls-table-wrap { overflow-x: auto; min-height: 260px; }
    .ls-table { width: 100%; border-collapse: collapse; min-width: 820px; }
    .ls-table thead th {
        background: var(--ls-head);
        color: var(--ls-muted);
        font-size: 11.5px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase;
        padding: 16px 14px; text-align: left; white-space: nowrap; border: 0;
    }
    .ls-table tbody td {
        padding: 16px 14px; font-size: 14px; border: 0; border-top: 1px solid var(--ls-line);
        vertical-align: middle; background: transparent;
    }
    .ls-table tbody tr:hover td { background: #fafbfd; }
    .ls-table tbody tr.is-selected td { background: var(--ls-blue-tint); }
    .ls-table .ls-chk-col { width: 52px; padding-right: 0; }
    .ls-name { font-weight: 700; }
    .ls-phone, .ls-last { color: var(--ls-muted); }
    .ls-actions-col { width: 60px; text-align: right; }

    /* Checkbox */
    .ls-chk {
        appearance: none; -webkit-appearance: none;
        width: 20px; height: 20px; margin: 0; cursor: pointer;
        border: 1.5px solid #b9c3d3; border-radius: 5px; background: #fff;
        display: inline-grid; place-content: center; vertical-align: middle;
    }
    .ls-chk:checked, .ls-chk:indeterminate { background: var(--ls-blue); border-color: var(--ls-blue); }
    .ls-chk:checked::after {
        content: ""; width: 5px; height: 10px; border: solid #fff; border-width: 0 2px 2px 0;
        transform: translateY(-1px) rotate(45deg);
    }
    .ls-chk:indeterminate::after { content: ""; width: 10px; height: 2px; background: #fff; }
    .ls-chk:focus-visible { outline: 3px solid rgba(2,27,69,.25); outline-offset: 2px; }

    /* Status badges */
    .ls-badge { display: inline-block; font-size: 11.5px; font-weight: 700; padding: 5px 14px; border-radius: 999px; white-space: nowrap; }
    .ls-badge.new       { background: #dde9fc; color: #1b4fb5; }
    .ls-badge.contacted { background: #fdebd1; color: #b86a00; }
    .ls-badge.followup  { background: #e9defa; color: #6a3dc4; }
    .ls-badge.converted { background: #d5f3e8; color: #00774f; }

    .ls-kebab {
        border: 0; background: transparent; color: var(--ls-muted);
        font-size: 20px; line-height: 1; padding: 4px 8px; border-radius: 6px; cursor: pointer;
    }
    .ls-kebab:hover { background: var(--ls-head); }
    .ls-kebab:focus-visible { outline: 2px solid var(--ls-blue); }

    .ls-empty { display: none; padding: 48px 16px; text-align: center; color: var(--ls-muted); font-size: 14px; }
    .ls-empty strong { display: block; color: var(--ls-ink); font-size: 15px; margin-bottom: 4px; }

    /* Footer: info + pagination */
    .ls-foot {
        display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;
        padding: 12px 16px; border-top: 1px solid var(--ls-line);
    }
    .ls-info { font-size: 13px; color: var(--ls-ink); }
    .ls-pager { display: inline-flex; border: 1px solid var(--ls-line); border-radius: 8px; overflow: hidden; }
    .ls-page {
        min-width: 40px; height: 38px; padding: 0 14px;
        border: 0; border-left: 1px solid var(--ls-line); background: #fff;
        font-size: 14px; color: var(--ls-ink); cursor: pointer;
    }
    .ls-page:first-child { border-left: 0; }
    .ls-page:hover:not(:disabled):not(.is-active) { background: var(--ls-head); }
    .ls-page.is-active { background: var(--ls-blue); color: #fff; font-weight: 700; cursor: default; }
    .ls-page:disabled { color: #b4bdca; cursor: not-allowed; }
    .ls-page.is-gap { cursor: default; color: var(--ls-muted); }
    .ls-page:focus-visible { outline: 2px solid var(--ls-blue); outline-offset: -2px; }

    /* Board view */
    .ls-board { display: none; grid-template-columns: repeat(4, minmax(220px, 1fr)); gap: 14px; overflow-x: auto; padding-bottom: 6px; }
    .ls-col { background: var(--ls-head); border-radius: 14px; padding: 12px; min-height: 160px; }
    .ls-col-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; font-size: 13px; font-weight: 700; }
    .ls-col-head span.n { color: var(--ls-muted); font-weight: 600; }
    .ls-lead-card {
        background: #fff; border: 1px solid var(--ls-line); border-radius: 10px;
        padding: 12px; margin-bottom: 10px; display: flex; gap: 10px; align-items: flex-start;
    }
    .ls-lead-card.is-selected { background: var(--ls-blue-tint); border-color: #b9c9e8; }
    .ls-lead-card .ls-name { font-size: 14px; }
    .ls-lead-card small { display: block; color: var(--ls-muted); font-size: 12px; margin-top: 2px; }

    /* Toast */
    .ls-toast {
        position: fixed; right: 20px; bottom: 20px; z-index: 2100;
        background: var(--ls-ink); color: #fff; padding: 12px 18px; border-radius: 10px; font-size: 14px;
        opacity: 0; transform: translateY(10px); transition: opacity .25s, transform .25s; pointer-events: none;
    }
    .ls-toast.is-show { opacity: 1; transform: none; }

    @media (max-width: 767.98px) {
        .ls-select { flex: 1 1 140px; }
        .ls-selbar .ls-clear { margin-left: 0; }
        .ls-foot { justify-content: center; }
    }
    @media (prefers-reduced-motion: reduce) { .ls-toast { transition: none; } }
</style>
@endsection

@section('content')
<div class="">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Leads</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href=""><i class="bi bi-house"></i></a></li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="ls">

        {{-- Toolbar --}}
        <div class="ls-toolbar">
            <div class="ls-search">
                <input type="search" class="ls-control" id="lsSearch" placeholder="Search leads..." aria-label="Search leads">
            </div>

            <select class="ls-control ls-select" id="lsStatus" aria-label="Filter by status">
                <option value="all">Status: All</option>
                <option value="new">Status: New</option>
                <option value="contacted">Status: Contacted</option>
                <option value="followup">Status: Follow-up</option>
                <option value="converted">Status: Converted</option>
            </select>

            <select class="ls-control ls-select" id="lsSource" aria-label="Filter by source">
                <option value="all">Source: All</option>
                <option value="Website">Source: Website</option>
                <option value="Facebook">Source: Facebook</option>
                <option value="Referral">Source: Referral</option>
                <option value="Walk-in">Source: Walk-in</option>
            </select>

            <select class="ls-control ls-select" id="lsDate" aria-label="Filter by date">
                <option value="0">Date: Today</option>
                <option value="7">Date: Last 7 days</option>
                <option value="30" selected>Date: This month</option>
                <option value="all">Date: All time</option>
            </select>

            <div class="ls-toggle" role="group" aria-label="View">
                <button type="button" class="is-on" id="lsListBtn" aria-pressed="true">List</button>
                <button type="button" id="lsBoardBtn" aria-pressed="false">Board</button>
            </div>

            <button type="button" class="ls-btn" id="lsImportBtn">Import</button>
            <input type="file" id="lsImportFile" accept=".csv,.xlsx,.xls" hidden>
        </div>

        {{-- Selection bar --}}
        <div class="ls-selbar" id="lsSelbar">
            <span class="ls-count" id="lsCount">0 leads selected</span>
            <button type="button" class="ls-btn ls-btn-primary" id="lsSendMsg">Send automatic message</button>
            <div class="ls-menu-wrap">
                <button type="button" class="ls-btn" id="lsChangeBtn" aria-haspopup="true" aria-expanded="false">Change status</button>
                <div class="ls-menu" id="lsChangeMenu" role="menu">
                    <button type="button" role="menuitem" data-status="new">New</button>
                    <button type="button" role="menuitem" data-status="contacted">Contacted</button>
                    <button type="button" role="menuitem" data-status="followup">Follow-up</button>
                    <button type="button" role="menuitem" data-status="converted">Converted</button>
                </div>
            </div>
            <button type="button" class="ls-clear" id="lsClear">Clear selection</button>
        </div>

        {{-- List view --}}
        <div class="ls-card mb-3 pb-3" id="lsList">

            {{-- Show entries --}}
            <div class="ls-lenbar">
                <label class="ls-len" for="lsSize">
                    Show
                    <select id="lsSize">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    entries
                </label>
            </div>

            <div class="ls-table-wrap">
                <table class="ls-table" id="lsTable">
                    <thead>
                        <tr>
                            <th class="ls-chk-col"><input type="checkbox" class="ls-chk" id="lsAll" aria-label="Select all leads on this page"></th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Last Contact</th>
                            <th>Owner</th>
                            <th class="ls-actions-col"><span class="visually-hidden">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody id="lsBody"></tbody>
                </table>
                <div class="ls-empty" id="lsEmpty">
                    <strong>No leads match these filters</strong>
                    Try a different status, source or date range.
                </div>
            </div>

            {{-- Info + pagination --}}
            <div class="ls-foot">
                <div class="ls-info" id="lsInfo"></div>
                <nav class="ls-pager" id="lsPager" aria-label="Pagination"></nav>
            </div>
        </div>

        {{-- Board view --}}
        <div class="ls-board" id="lsBoard"></div>
    </div>
</div>

<div class="ls-toast" id="lsToast" role="status" aria-live="polite"></div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* ---------------- Static data ---------------- */
    // created / last = days ago ( last: null = never contacted )
    var leads = [
        { id: 1,  name: 'Rahul Verma',    phone: '+91 98450 11223', source: 'Website',  status: 'new',       last: null, owner: 'Priya', created: 0  },
        { id: 2,  name: 'Anita Desai',    phone: '+91 99001 55678', source: 'Facebook', status: 'contacted', last: 0,    owner: 'Priya', created: 3  },
        { id: 3,  name: 'Karthik R',      phone: '+91 97420 33410', source: 'Referral', status: 'followup',  last: 2,    owner: 'Arun',  created: 6  },
        { id: 4,  name: 'Sneha Iyer',     phone: '+91 98860 77123', source: 'Website',  status: 'converted', last: 7,    owner: 'Priya', created: 18 },
        { id: 5,  name: 'Mohammed Faiz',  phone: '+91 98800 20931', source: 'Walk-in',  status: 'new',       last: null, owner: 'Arun',  created: 0  },
        { id: 6,  name: 'Divya Nair',     phone: '+91 90350 66412', source: 'Facebook', status: 'contacted', last: 1,    owner: 'Arun',  created: 9  },
        { id: 7,  name: 'Suresh Babu',    phone: '+91 99720 18854', source: 'Referral', status: 'followup',  last: 4,    owner: 'Priya', created: 12 },
        { id: 8,  name: 'Lakshmi Rao',    phone: '+91 98450 90017', source: 'Website',  status: 'new',       last: null, owner: 'Priya', created: 1  },
        { id: 9,  name: 'Imran Pasha',    phone: '+91 96320 44705', source: 'Walk-in',  status: 'converted', last: 14,   owner: 'Arun',  created: 27 },
        { id: 10, name: 'Meera Joshi',    phone: '+91 91080 53329', source: 'Facebook', status: 'contacted', last: 10,   owner: 'Priya', created: 45 },
        { id: 11, name: 'Vikram Shetty',  phone: '+91 98440 71290', source: 'Referral', status: 'new',       last: null, owner: 'Arun',  created: 2  },
        { id: 12, name: 'Pooja Kulkarni', phone: '+91 99860 30517', source: 'Website',  status: 'followup',  last: 3,    owner: 'Priya', created: 5  },
        { id: 13, name: 'Arjun Menon',    phone: '+91 94480 25631', source: 'Facebook', status: 'contacted', last: 2,    owner: 'Arun',  created: 8  },
        { id: 14, name: 'Fatima Sheikh',  phone: '+91 98450 66782', source: 'Walk-in',  status: 'converted', last: 9,    owner: 'Priya', created: 21 },
        { id: 15, name: 'Ravi Teja',      phone: '+91 97390 18045', source: 'Website',  status: 'new',       last: null, owner: 'Arun',  created: 0  },
        { id: 16, name: 'Nandini Hegde',  phone: '+91 99000 41376', source: 'Referral', status: 'followup',  last: 5,    owner: 'Priya', created: 11 },
        { id: 17, name: 'Sanjay Gowda',   phone: '+91 98800 53219', source: 'Facebook', status: 'contacted', last: 0,    owner: 'Arun',  created: 4  },
        { id: 18, name: 'Kavya Reddy',    phone: '+91 90190 72864', source: 'Website',  status: 'converted', last: 12,   owner: 'Priya', created: 24 },
        { id: 19, name: 'Rohit Bhat',     phone: '+91 96060 37428', source: 'Walk-in',  status: 'new',       last: null, owner: 'Priya', created: 1  },
        { id: 20, name: 'Deepa Murthy',   phone: '+91 98860 90153', source: 'Referral', status: 'contacted', last: 6,    owner: 'Arun',  created: 15 },
        { id: 21, name: 'Harish Kumar',   phone: '+91 97410 28607', source: 'Facebook', status: 'followup',  last: 1,    owner: 'Priya', created: 7  },
        { id: 22, name: 'Swati Patil',    phone: '+91 99720 64491', source: 'Website',  status: 'new',       last: null, owner: 'Arun',  created: 2  },
        { id: 23, name: 'Naveen Raj',     phone: '+91 98450 15936', source: 'Walk-in',  status: 'contacted', last: 8,    owner: 'Priya', created: 19 },
        { id: 24, name: 'Ayesha Khan',    phone: '+91 91080 82570', source: 'Referral', status: 'converted', last: 20,   owner: 'Arun',  created: 38 }
    ];

    var STATUS = {
        new:       'New',
        contacted: 'Contacted',
        followup:  'Follow-up',
        converted: 'Converted'
    };

    var state = { q: '', status: 'all', source: 'all', date: '30', view: 'list', page: 1, size: 10 };
    var selected = {};   // id -> true

    var $ = function (id) { return document.getElementById(id); };
    function esc(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }
    function lastText(d) {
        if (d === null) return '-';
        if (d === 0) return 'Today';
        if (d === 1) return 'Yesterday';
        if (d < 7) return d + ' days ago';
        var w = Math.floor(d / 7);
        return w + (w === 1 ? ' week ago' : ' weeks ago');
    }

    var toastTimer;
    function toast(msg) {
        var t = $('lsToast');
        t.textContent = msg;
        t.classList.add('is-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { t.classList.remove('is-show'); }, 2600);
    }

    /* ---------------- Filtering + paging ---------------- */
    function filteredLeads() {
        var q = state.q.trim().toLowerCase();
        return leads.filter(function (l) {
            if (state.status !== 'all' && l.status !== state.status) return false;
            if (state.source !== 'all' && l.source !== state.source) return false;
            if (state.date !== 'all' && l.created > parseInt(state.date, 10)) return false;
            if (q && (l.name + ' ' + l.phone).toLowerCase().indexOf(q) === -1) return false;
            return true;
        });
    }
    function totalPages(count) { return Math.max(1, Math.ceil(count / state.size)); }
    function pageRows(rows) {
        var start = (state.page - 1) * state.size;
        return rows.slice(start, start + state.size);
    }
    function selectedCount() { return Object.keys(selected).length; }

    /* ---------------- Rendering ---------------- */
    function render() {
        var rows = filteredLeads();
        var pages = totalPages(rows.length);
        if (state.page > pages) state.page = pages;      // e.g. after delete / filter

        var current = pageRows(rows);
        renderTable(current);
        renderBoard(rows);
        renderSelection(current);
        renderPager(rows.length, pages, current.length);
    }

    function renderTable(rows) {
        $('lsBody').innerHTML = rows.map(function (l) {
            var on = !!selected[l.id];
            return '<tr class="' + (on ? 'is-selected' : '') + '" data-id="' + l.id + '">' +
                '<td class="ls-chk-col"><input type="checkbox" class="ls-chk ls-row-chk" ' + (on ? 'checked' : '') +
                    ' aria-label="Select ' + esc(l.name) + '"></td>' +
                '<td class="ls-name">' + esc(l.name) + '</td>' +
                '<td class="ls-phone">' + esc(l.phone) + '</td>' +
                '<td>' + esc(l.source) + '</td>' +
                '<td><span class="ls-badge ' + l.status + '">' + STATUS[l.status] + '</span></td>' +
                '<td class="ls-last">' + lastText(l.last) + '</td>' +
                '<td>' + esc(l.owner) + '</td>' +
                '<td class="ls-actions-col"><div class="ls-menu-wrap">' +
                    '<button type="button" class="ls-kebab" aria-label="Actions for ' + esc(l.name) + '" aria-haspopup="true">&hellip;</button>' +
                    '<div class="ls-menu ls-row-menu" role="menu">' +
                        '<button type="button" role="menuitem" data-act="view" data-url="{{ url('/leads/view') }}">View lead</button>' +
                        '<button type="button" role="menuitem" data-act="message" data-url="{{ url('/sendmessage/index') }}">Send message</button>' +
                        '<button type="button" role="menuitem" data-act="delete" class="is-danger">Delete</button>' +
                    '</div></div></td>' +
            '</tr>';
        }).join('');

        $('lsEmpty').style.display = rows.length ? 'none' : 'block';
        $('lsTable').style.display = rows.length ? '' : 'none';
    }

    function renderBoard(rows) {
        $('lsBoard').innerHTML = Object.keys(STATUS).map(function (key) {
            var items = rows.filter(function (l) { return l.status === key; });
            var cards = items.map(function (l) {
                var on = !!selected[l.id];
                return '<div class="ls-lead-card ' + (on ? 'is-selected' : '') + '" data-id="' + l.id + '">' +
                    '<input type="checkbox" class="ls-chk ls-card-chk" ' + (on ? 'checked' : '') +
                        ' aria-label="Select ' + esc(l.name) + '">' +
                    '<div><div class="ls-name">' + esc(l.name) + '</div>' +
                    '<small>' + esc(l.phone) + '</small>' +
                    '<small>' + esc(l.source) + ' &middot; ' + esc(l.owner) + '</small>' +
                    '<small>Last contact: ' + lastText(l.last) + '</small></div></div>';
            }).join('');
            return '<div class="ls-col"><div class="ls-col-head"><span class="ls-badge ' + key + '">' + STATUS[key] +
                '</span><span class="n">' + items.length + '</span></div>' +
                (cards || '<small style="color:#6b7a90">No leads</small>') + '</div>';
        }).join('');
    }

    function renderSelection(current) {
        var n = selectedCount();
        $('lsSelbar').classList.toggle('is-open', n > 0);
        $('lsCount').textContent = n + (n === 1 ? ' lead selected' : ' leads selected');
        if (n === 0) closeMenus();

        // header checkbox reflects the rows on the current page
        var all = $('lsAll');
        var sel = current.filter(function (l) { return selected[l.id]; }).length;
        all.checked = current.length > 0 && sel === current.length;
        all.indeterminate = sel > 0 && sel < current.length;
        all.disabled = current.length === 0;
    }

    /* Page list with ellipsis: 1 2 3 4 … 8 */
    function pageList(cur, total) {
        if (total <= 7) {
            var all = [];
            for (var i = 1; i <= total; i++) all.push(i);
            return all;
        }
        var s = Math.max(2, cur - 1), e = Math.min(total - 1, cur + 1);
        if (cur <= 3) { s = 2; e = 4; }
        if (cur >= total - 2) { s = total - 3; e = total - 1; }
        var out = [1];
        if (s > 2) out.push('gap');
        for (var p = s; p <= e; p++) out.push(p);
        if (e < total - 1) out.push('gap');
        out.push(total);
        return out;
    }

    function renderPager(count, pages, shown) {
        var start = (state.page - 1) * state.size;
        var info = count === 0
            ? 'Showing 0 to 0 of 0 entries'
            : 'Showing ' + (start + 1) + ' to ' + (start + shown) + ' of ' + count + ' entries';
        if (count !== leads.length) info += ' (filtered from ' + leads.length + ' total entries)';
        $('lsInfo').textContent = info;

        var html = '<button type="button" class="ls-page" data-page="' + (state.page - 1) + '"' +
            (state.page === 1 ? ' disabled' : '') + '>Previous</button>';

        if (count > 0) {
            pageList(state.page, pages).forEach(function (p) {
                if (p === 'gap') {
                    html += '<button type="button" class="ls-page is-gap" disabled>&hellip;</button>';
                } else {
                    html += '<button type="button" class="ls-page' + (p === state.page ? ' is-active' : '') +
                        '" data-page="' + p + '"' + (p === state.page ? ' aria-current="page"' : '') + '>' + p + '</button>';
                }
            });
        }

        html += '<button type="button" class="ls-page" data-page="' + (state.page + 1) + '"' +
            (state.page >= pages || count === 0 ? ' disabled' : '') + '>Next</button>';
        $('lsPager').innerHTML = html;
    }

    /* ---------------- Pagination + page size events ---------------- */
    $('lsPager').addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-page]');
        if (!btn || btn.disabled) return;
        state.page = parseInt(btn.dataset.page, 10);
        render();
    });

    $('lsSize').addEventListener('change', function () {
        state.size = parseInt(this.value, 10);
        state.page = 1;
        render();
    });

    /* ---------------- Selection ---------------- */
    function toggle(id, on) {
        if (on) selected[id] = true; else delete selected[id];
        render();
    }

    // header checkbox selects / clears the rows on the current page
    $('lsAll').addEventListener('change', function () {
        var on = this.checked;
        pageRows(filteredLeads()).forEach(function (l) {
            if (on) selected[l.id] = true; else delete selected[l.id];
        });
        render();
    });

    $('lsBody').addEventListener('change', function (e) {
        if (!e.target.classList.contains('ls-row-chk')) return;
        toggle(parseInt(e.target.closest('tr').dataset.id, 10), e.target.checked);
    });
    $('lsBoard').addEventListener('change', function (e) {
        if (!e.target.classList.contains('ls-card-chk')) return;
        toggle(parseInt(e.target.closest('.ls-lead-card').dataset.id, 10), e.target.checked);
    });

    $('lsClear').addEventListener('click', function () { selected = {}; render(); });

    /* ---------------- Bulk actions ---------------- */
    $('lsSendMsg').addEventListener('click', function () {
        var n = selectedCount();
        toast('Automatic message queued for ' + n + (n === 1 ? ' lead' : ' leads'));
    });

    $('lsChangeBtn').addEventListener('click', function (e) {
        e.stopPropagation();
        var menu = $('lsChangeMenu');
        var open = !menu.classList.contains('is-open');
        closeMenus();
        menu.classList.toggle('is-open', open);
        this.setAttribute('aria-expanded', String(open));
    });

    $('lsChangeMenu').addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-status]');
        if (!btn) return;
        var status = btn.dataset.status;
        var n = 0;
        leads.forEach(function (l) {
            if (selected[l.id]) { l.status = status; n++; }
        });
        closeMenus();
        render();
        toast(n + (n === 1 ? ' lead' : ' leads') + ' moved to ' + STATUS[status]);
    });

    /* ---------------- Row menu (fixed position, never clipped) ---------------- */
    $('lsBody').addEventListener('click', function (e) {
        var kebab = e.target.closest('.ls-kebab');
        if (kebab) {
            e.stopPropagation();
            var menu = kebab.nextElementSibling;
            var open = !menu.classList.contains('is-open');
            closeMenus();
            if (!open) return;

            menu.classList.add('is-open');
            var r = kebab.getBoundingClientRect();
            var w = menu.offsetWidth, h = menu.offsetHeight;
            var top = (r.bottom + h + 8 > window.innerHeight) ? r.top - h - 4 : r.bottom + 4;
            menu.style.top = Math.max(8, top) + 'px';
            menu.style.left = Math.max(8, r.right - w) + 'px';
            return;
        }

        var act = e.target.closest('button[data-act]');
        if (!act) return;
        var id = parseInt(act.closest('tr').dataset.id, 10);
        var lead = leads.filter(function (l) { return l.id === id; })[0];
        closeMenus();

        if (act.dataset.act === 'view') window.location.href = act.dataset.url;
        if (act.dataset.act === 'message') window.location.href = act.dataset.url;
        if (act.dataset.act === 'delete') confirmDelete(lead);
    });

    /* ---------------- Delete with SweetAlert2 ---------------- */
    function removeLead(lead) {
        leads = leads.filter(function (l) { return l.id !== lead.id; });
        delete selected[lead.id];
        render();
    }

    function confirmDelete(lead) {
        // Fallback if SweetAlert2 is not loaded by the layout
        if (!window.Swal) {
            if (window.confirm('Delete ' + lead.name + '?')) {
                removeLead(lead);
                toast(lead.name + ' deleted');
            }
            return;
        }

        Swal.fire({
            title: 'Delete this lead?',
            html: 'You are about to delete <b>' + esc(lead.name) + '</b>. This cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#c62828',
            cancelButtonColor: '#6b7a90',
            reverseButtons: true,
            focusCancel: true
        }).then(function (result) {
            if (!result.isConfirmed) return;
            removeLead(lead);
            Swal.fire({
                icon: 'success',
                title: 'Deleted',
                text: lead.name + ' was removed from leads.',
                timer: 1600,
                showConfirmButton: false
            });
        });
    }

    function closeMenus() {
        document.querySelectorAll('.ls-menu.is-open').forEach(function (m) { m.classList.remove('is-open'); });
        $('lsChangeBtn').setAttribute('aria-expanded', 'false');
    }
    document.addEventListener('click', closeMenus);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenus(); });
    window.addEventListener('scroll', closeMenus, true);
    window.addEventListener('resize', closeMenus);

    /* ---------------- Filters (always back to page 1) ---------------- */
    $('lsSearch').addEventListener('input', function () { state.q = this.value; state.page = 1; render(); });
    $('lsStatus').addEventListener('change', function () { state.status = this.value; state.page = 1; render(); });
    $('lsSource').addEventListener('change', function () { state.source = this.value; state.page = 1; render(); });
    $('lsDate').addEventListener('change', function () { state.date = this.value; state.page = 1; render(); });

    /* ---------------- List / Board toggle ---------------- */
    function setView(view) {
        state.view = view;
        var isList = view === 'list';
        $('lsList').style.display = isList ? '' : 'none';
        $('lsBoard').style.display = isList ? 'none' : 'grid';
        $('lsListBtn').classList.toggle('is-on', isList);
        $('lsBoardBtn').classList.toggle('is-on', !isList);
        $('lsListBtn').setAttribute('aria-pressed', String(isList));
        $('lsBoardBtn').setAttribute('aria-pressed', String(!isList));
    }
    $('lsListBtn').addEventListener('click', function () { setView('list'); });
    $('lsBoardBtn').addEventListener('click', function () { setView('board'); });

    /* ---------------- Import ---------------- */
    $('lsImportBtn').addEventListener('click', function () { $('lsImportFile').click(); });
    $('lsImportFile').addEventListener('change', function () {
        if (!this.files.length) return;
        toast('Selected "' + this.files[0].name + '" for import');
        this.value = '';
    });

    /* ---------------- Init ---------------- */
    setView('list');
    render();
})();
</script>
@endpush
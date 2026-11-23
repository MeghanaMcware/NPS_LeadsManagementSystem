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
                <option value="Google Form">Source: Google Form</option>
                <option value="WhatsApp">Source: WhatsApp</option>
                <option value="WhatsApp Chatbot">Source: WhatsApp Chatbot</option>
                <option value="Website">Source: Website</option>
                <option value="Facebook">Source: Facebook</option>
                <option value="Walk-in">Source: Walk-in</option>
            </select>

            <select class="ls-control ls-select" id="lsDate" aria-label="Filter by date">
                <option value="0">Date: Today</option>
                <option value="7">Date: Last 7 days</option>
                <option value="30" selected>Date: This month</option>
                <option value="all">Date: All time</option>
            </select>

            <a href="{{ route('leadsimport.index', ['mode' => 'import']) }}" class="ls-btn d-inline-flex align-items-center justify-content-center" style="text-decoration:none;" id="lsImportBtn">Import</a>
        </div>

        {{-- Selection bar --}}
        <div class="ls-selbar" id="lsSelbar">
            <span class="ls-count" id="lsCount">0 leads selected</span>
            <a href="{{ route('sendmessage.index') }}" class="ls-btn ls-btn-primary d-flex align-items-center justify-content-center">Send automatic message</a>
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
                            <th class="ls-actions-col"><span class="">Actions</span></th>
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

    </div>
</div>

<div class="ls-toast" id="lsToast" role="status" aria-live="polite"></div>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* ---------------- Leads Data from Database ---------------- */
    var leads = {!! json_encode($leads) !!};

    var STATUS = {
        new:       'New',
        contacted: 'Contacted',
        followup:  'Follow-up',
        converted: 'Converted',
        lost:      'Lost'
    };

    var state = { q: '', status: 'all', source: 'all', date: '30', page: 1, size: 10 };
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
            if (state.source !== 'all') {
                var s = (l.source || '').toLowerCase();
                var f = state.source.toLowerCase();
                if (f === 'whatsapp') {
                    if (s !== 'whatsapp' && s !== 'whatsapp chatbot') return false;
                } else if (s !== f) {
                    return false;
                }
            }
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
                '<td class="ls-actions-col"><div class="ls-menu-wrap">' +
                    '<button type="button" class="ls-kebab" aria-label="Actions for ' + esc(l.name) + '" aria-haspopup="true">&hellip;</button>' +
                    '<div class="ls-menu ls-row-menu" role="menu">' +
                        '<button type="button" role="menuitem" data-act="view" data-url="{{ url('/leads/view') }}/' + l.id + '">View lead</button>' +
                        '<button type="button" role="menuitem" data-act="message" data-url="{{ route('sendmessage.index') }}?lead_id=' + l.id + '">Send message</button>' +
                    '</div></div></td>' +
            '</tr>';
        }).join('');

        $('lsEmpty').style.display = rows.length ? 'none' : 'block';
        $('lsTable').style.display = rows.length ? '' : 'none';
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

    $('lsClear').addEventListener('click', function () { selected = {}; render(); });

    /* ---------------- Bulk actions ---------------- */
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
    });

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

    /* ---------------- Init ---------------- */
    render();
})();
</script>
@endpush
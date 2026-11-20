@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">

<style>
/* ---------- Leads dashboard (all classes prefixed ld- to avoid clashes) ---------- */
.ld {
    --ld-blue: #021b45;
    --ld-blue-soft: #b3cffa;
    --ld-orange: #e88700;
    --ld-orange-soft: #f8d9a8;
    --ld-purple: #7a4bd6;
    --ld-green: #00996b;
    --ld-ink: #1b2233;
    --ld-muted: #6b7a90;
    --ld-line: #dfe5ee;
    --ld-bg: #ffffff;
    color: var(--ld-ink);
}

.ld-card {
    background: var(--ld-bg);
    border: 1px solid var(--ld-line);
    border-radius: 16px;
    height: 100%;
}

/* Stat cards */
.ld-stat {
    position: relative;
    padding: 18px 20px 16px 24px;
    overflow: hidden;
}

.ld-stat::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    background: var(--accent);
}

.ld-stat .ld-label {
    font-size: 13px;
    color: var(--ld-muted);
    margin-bottom: 6px;
}

.ld-stat .ld-value {
    font-size: 36px;
    font-weight: 700;
    line-height: 1.1;
    margin-bottom: 6px;
}

.ld-stat .ld-sub {
    font-size: 12px;
    color: var(--accent);
    font-weight: 500;
}

/* Chart cards */
.ld-chart {
    padding: 20px 22px 18px;
}

.ld-chart-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}

.ld-chart-head h6 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
}

.ld-chart-note {
    font-size: 12px;
    color: var(--ld-muted);
}

/* ---------- Custom dropdown ---------- */
.ld-dd {
    position: relative;
    display: inline-block;
}

.ld-dd-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f4f7fc;
    border: 1px solid var(--ld-line);
    border-radius: 10px;
    padding: 7px 12px;
    font-size: 13px;
    font-weight: 600;
    color: var(--ld-ink);
    cursor: pointer;
    transition: background .15s, border-color .15s, box-shadow .15s;
}

.ld-dd-btn:hover {
    background: #eaf0fa;
    border-color: #c9d5e8;
}

.ld-dd-btn:focus-visible,
.ld-dd.is-open .ld-dd-btn {
    outline: none;
    border-color: var(--ld-blue);
    box-shadow: 0 0 0 3px rgba(2, 27, 69, .12);
    background: #fff;
}

.ld-dd-btn .bi-calendar3 {
    color: var(--ld-muted);
    font-size: 13px;
}

.ld-dd-caret {
    font-size: 11px;
    color: var(--ld-muted);
    transition: transform .2s;
}

.ld-dd.is-open .ld-dd-caret {
    transform: rotate(180deg);
}

.ld-dd-menu {
    position: absolute;
    right: 0;
    top: calc(100% + 8px);
    min-width: 180px;
    margin: 0;
    padding: 6px;
    list-style: none;
    background: #fff;
    border: 1px solid var(--ld-line);
    border-radius: 12px;
    box-shadow: 0 12px 28px rgba(2, 27, 69, .14);
    z-index: 20;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-6px);
    transition: opacity .15s, transform .15s, visibility .15s;
}

.ld-dd.is-open .ld-dd-menu {
    opacity: 1;
    visibility: visible;
    transform: none;
}

.ld-dd-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 9px 10px;
    font-size: 13px;
    border-radius: 8px;
    cursor: pointer;
    color: var(--ld-ink);
    user-select: none;
}

.ld-dd-item:hover,
.ld-dd-item.is-focus {
    background: #f1f5fb;
}

.ld-dd-item.is-selected {
    font-weight: 700;
    color: var(--ld-blue);
}

.ld-dd-item .bi-check2 {
    font-size: 15px;
    opacity: 0;
}

.ld-dd-item.is-selected .bi-check2 {
    opacity: 1;
}

/* Bar chart */
.ld-bars {
    --bar-soft: var(--ld-blue-soft);
    --bar-on: var(--ld-blue);
    height: 230px;
    display: flex;
    align-items: flex-end;
    gap: 22px;
    padding: 0 6px;
    border-bottom: 1px solid transparent;
}

.ld-bars.is-alt {
    --bar-soft: var(--ld-orange-soft);
    --bar-on: var(--ld-orange);
}

.ld-bar-col {
    flex: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    align-items: center;
    position: relative;
    cursor: pointer;
    min-width: 0;
}

.ld-bar {
    width: 100%;
    max-width: 40px;
    background: var(--bar-soft);
    border-radius: 6px 6px 4px 4px;
    height: 0;
    transition: height .6s cubic-bezier(.2, .7, .2, 1), background .2s;
}

.ld-bar-col.is-active .ld-bar,
.ld-bar-col:hover .ld-bar {
    background: var(--bar-on);
}

.ld-bar-label {
    font-size: 11px;
    color: var(--ld-muted);
    margin-top: 8px;
}

.ld-tip {
    position: absolute;
    bottom: calc(var(--h, 0%) + 34px);
    left: 50%;
    transform: translateX(-50%);
    background: var(--ld-ink);
    color: #fff;
    font-size: 12px;
    padding: 4px 9px;
    border-radius: 6px;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity .15s;
    z-index: 2;
}

.ld-bar-col:hover .ld-tip,
.ld-bar-col:focus-visible .ld-tip {
    opacity: 1;
}

.ld-bar-col:focus-visible {
    outline: 2px solid var(--ld-blue);
    outline-offset: 2px;
    border-radius: 6px;
}

/* Donut */
.ld-donut-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 44px;
    flex-wrap: wrap;
    min-height: 230px;
}

.ld-donut {
    position: relative;
    width: 150px;
    height: 150px;
    flex: none;
}

.ld-donut svg {
    width: 100%;
    height: 100%;
    transform: rotate(-90deg);
}

.ld-donut circle.seg {
    fill: none;
    stroke-width: 28;
    cursor: pointer;
    transition: stroke-width .15s, opacity .2s;
}

.ld-donut circle.seg:hover {
    stroke-width: 32;
}

.ld-donut.has-focus circle.seg:not(.is-on) {
    opacity: .35;
}

.ld-donut-center {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    pointer-events: none;
}

.ld-donut-center strong {
    font-size: 18px;
    font-weight: 700;
}

.ld-donut-center span {
    font-size: 11px;
    color: var(--ld-muted);
}

.ld-legend {
    list-style: none;
    margin: 0;
    padding: 0;
}

.ld-legend li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    padding: 7px 0;
    cursor: pointer;
    user-select: none;
}

.ld-legend li.is-off {
    opacity: .4;
    text-decoration: line-through;
}

.ld-legend .dot {
    width: 14px;
    height: 14px;
    border-radius: 4px;
    flex: none;
}

/* Lead source */
.ld-sources {
    min-height: 230px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 20px;
}

.ld-src-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 13px;
    margin-bottom: 7px;
}

.ld-src-name {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.ld-src-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 14px;
}

.ld-src-val {
    color: var(--ld-muted);
    font-size: 12px;
}

.ld-src-val strong {
    color: var(--ld-ink);
    font-size: 13px;
    margin-right: 4px;
}

.ld-src-track {
    height: 10px;
    background: #eef2f8;
    border-radius: 999px;
    overflow: hidden;
}

.ld-src-fill {
    height: 100%;
    width: 0;
    border-radius: 999px;
    transition: width .7s cubic-bezier(.2, .7, .2, 1);
}

@media (max-width: 575.98px) {
    .ld-bars {
        gap: 8px;
    }

    .ld-stat .ld-value {
        font-size: 30px;
    }

    .ld-donut-wrap {
        gap: 24px;
    }
}

@media (prefers-reduced-motion: reduce) {

    .ld-bar,
    .ld-src-fill,
    .ld-dd-menu,
    .ld-dd-caret,
    .ld-donut circle.seg {
        transition: none;
    }
}

.newfont {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
}
</style>
@endsection

@section('content')
<div class="">
    <div class="">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href=""><i class="bi bi-house"></i></a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ld mt-0 pt-0">

    {{-- Row 1: stat cards --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ld-card ld-stat" style="--accent: var(--ld-blue)">
                <div class="ld-label">Total Leads</div>
                <div class="ld-value" id="ldTotal">1,248</div>
                <div class="ld-sub">+8% this week</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ld-card ld-stat" style="--accent: var(--ld-orange)">
                <div class="ld-label">New Today</div>
                <div class="ld-value" id="ldNewToday">12</div>
                <div class="ld-sub">Awaiting greeting</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ld-card ld-stat" style="--accent: var(--ld-purple)">
                <div class="ld-label">Contacted</div>
                <div class="ld-value" id="ldContacted">536</div>
                <div class="ld-sub" id="ldContactedPct">43% of total</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ld-card ld-stat" style="--accent: var(--ld-green)">
                <div class="ld-label">Converted</div>
                <div class="ld-value" id="ldConverted">214</div>
                <div class="ld-sub" id="ldConvertedPct">17% rate</div>
            </div>
        </div>
    </div>

    {{-- Row 2: Leads per week + Recent 7 days --}}
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-6">
            <div class="ld-card ld-chart">
                <div class="ld-chart-head">
                    <h6>Leads per week</h6>

                    {{-- Custom dropdown --}}
                    <div class="ld-dd" id="ldDd">
                        <button type="button" class="ld-dd-btn" id="ldDdBtn" aria-haspopup="listbox"
                            aria-expanded="false">
                            <i class="bi bi-calendar3"></i>
                            <span id="ldDdLabel">Last 8 weeks</span>
                            <i class="bi bi-chevron-down ld-dd-caret"></i>
                        </button>
                        <ul class="ld-dd-menu" id="ldDdMenu" role="listbox" tabindex="-1"></ul>
                    </div>
                </div>
                <div class="ld-bars" id="ldBars" role="list"></div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="ld-card ld-chart">
                <div class="ld-chart-head">
                    <h6>Recent 7 days</h6>
                    <span class="ld-chart-note">Daily new leads</span>
                </div>
                <div class="ld-bars is-alt" id="ldDays" role="list"></div>
            </div>
        </div>
    </div>

    {{-- Row 3: Lead status + Lead source --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="ld-card ld-chart">
                <div class="ld-chart-head">
                    <h6>Lead status</h6>
                </div>
                <div class="ld-donut-wrap">
                    <div class="ld-donut" id="ldDonut">
                        <svg viewBox="0 0 100 100" id="ldDonutSvg" aria-label="Lead status donut chart"></svg>
                        <div class="ld-donut-center">
                            <strong id="ldDonutValue">1,248</strong>
                            <span id="ldDonutLabel"></span>
                        </div>
                    </div>
                    <ul class="ld-legend" id="ldLegend"></ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="ld-card ld-chart">
                <div class="ld-chart-head">
                    <h6>Lead source</h6>
                    <span class="ld-chart-note" id="ldSrcTotal"></span>
                </div>
                <div class="ld-sources" id="ldSources"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header pb-0">
        <h6 class="newfont">Recent Leads</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="display table-bordered" id="basic-1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone No.</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Rahul Verma</td>
                        <td>123-456-7890</td>
                        <td>Website</td>
                        <td><span class="badge bg-primary">New</span></td>
                        <td><a class="btn btn-primary" href="{{ url('/leads/view') }}"> <i class="bi bi-eye-fill"></i> View</a></td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>123-456-7890</td>
                        <td>Referral</td>
                        <td><span class="badge bg-info text-white">Contacted</span></td>
                        <td><a class="btn btn-primary" href="{{ url('/leads/view') }}"> <i class="bi bi-eye-fill"></i> View</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
(function() {
    'use strict';

    /* ---------------- Static data ---------------- */
    var state = {
        // leads per week, oldest -> newest (12 weeks)
        weeks: [74, 91, 83, 120, 96, 138, 108, 172, 152, 201, 189, 230],
        days: [18, 25, 21, 30, 27, 16, 12], // last 7 days, oldest -> today
        newToday: 12,
        status: [
            { key: 'new',       label: 'New',       value: 374, color: '#0071ee' },
            { key: 'contacted', label: 'Contacted', value: 536, color: '#e88700' },
            { key: 'followup',  label: 'Follow-up', value: 124, color: '#7a4bd6' },
            { key: 'converted', label: 'Converted', value: 214, color: '#00996b' }
        ],
        sources: [
            { key: 'whatsapp', label: 'WhatsApp', value: 512, color: '#25d366', icon: 'bi-whatsapp' },
            { key: 'email',    label: 'Email',    value: 298, color: '#e88700', icon: 'bi-envelope-fill' },
            { key: 'sms',      label: 'SMS',      value: 241, color: '#7a4bd6', icon: 'bi-chat-dots-fill' },
            { key: 'facebook', label: 'Facebook', value: 197, color: '#1877f2', icon: 'bi-facebook' }
        ],
        hidden: {}, // legend toggles
        range: 8
    };

    var RANGES = [
        { value: 4,  label: 'Last 4 weeks' },
        { value: 8,  label: 'Last 8 weeks' },
        { value: 12, label: 'Last 12 weeks' }
    ];

    var $ = function(id) { return document.getElementById(id); };
    var fmt = function(n) { return Number(n).toLocaleString('en-IN'); };

    /* ---------------- Helpers ---------------- */
    function total() {
        return state.status.reduce(function(s, x) { return s + x.value; }, 0);
    }

    function visibleTotal() {
        return state.status.reduce(function(s, x) {
            return s + (state.hidden[x.key] ? 0 : x.value);
        }, 0);
    }

    function pct(v, t) {
        return t ? Math.round((v / t) * 100) : 0;
    }

    function get(key) {
        return state.status.filter(function(x) { return x.key === key; })[0];
    }

    /* ---------------- Stat cards ---------------- */
    function renderStats() {
        var t = total();
        $('ldTotal').textContent = fmt(t);
        $('ldNewToday').textContent = state.newToday;
        $('ldContacted').textContent = fmt(get('contacted').value);
        $('ldContactedPct').textContent = pct(get('contacted').value, t) + '% of total';
        $('ldConverted').textContent = fmt(get('converted').value);
        $('ldConvertedPct').textContent = pct(get('converted').value, t) + '% rate';
    }

    /* ---------------- Generic bar chart ----------------
       items: [{ label, value, tip, aria }]  */
    function renderBarChart(wrapId, items) {
        var wrap = $(wrapId);
        var max = Math.max.apply(null, items.map(function(i) { return i.value; })) || 1;
        var active = null;
        wrap.innerHTML = '';
        wrap.style.gap = items.length > 8 ? '8px' : ''; // tighter gap for many bars

        function setActive(col) {
            if (active) active.classList.remove('is-active');
            col.classList.add('is-active');
            active = col;
        }

        items.forEach(function(item, i) {
            var h = Math.round((item.value / max) * 100);
            var col = document.createElement('div');
            col.className = 'ld-bar-col' + (i === items.length - 1 ? ' is-active' : '');
            col.setAttribute('role', 'listitem');
            col.setAttribute('tabindex', '0');
            col.setAttribute('aria-label', item.aria);
            col.style.setProperty('--h', h + '%');
            col.innerHTML =
                '<div class="ld-tip">' + item.tip + '</div>' +
                '<div class="ld-bar"></div>' +
                '<div class="ld-bar-label">' + item.label + '</div>';

            col.addEventListener('click', function() { setActive(col); });
            col.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    setActive(col);
                }
            });
            wrap.appendChild(col);

            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    col.querySelector('.ld-bar').style.height = h + '%';
                });
            });
        });
        active = wrap.lastElementChild;
    }

    /* ---------------- Leads per week ---------------- */
    function renderWeeks() {
        var start = state.weeks.length - state.range;
        var items = state.weeks.slice(start).map(function(val, i) {
            var n = start + i + 1;
            return {
                label: 'W' + n,
                value: val,
                tip: 'W' + n + ': ' + val + ' leads',
                aria: 'Week ' + n + ': ' + val + ' leads'
            };
        });
        renderBarChart('ldBars', items);
    }

    /* ---------------- Custom dropdown ---------------- */
    (function initDropdown() {
        var dd = $('ldDd');
        var btn = $('ldDdBtn');
        var menu = $('ldDdMenu');
        var label = $('ldDdLabel');
        var focusIdx = -1;

        function items() { return menu.querySelectorAll('.ld-dd-item'); }

        function build() {
            menu.innerHTML = '';
            RANGES.forEach(function(r) {
                var li = document.createElement('li');
                li.className = 'ld-dd-item' + (r.value === state.range ? ' is-selected' : '');
                li.setAttribute('role', 'option');
                li.setAttribute('aria-selected', String(r.value === state.range));
                li.dataset.value = r.value;
                li.innerHTML = '<span>' + r.label + '</span><i class="bi bi-check2"></i>';
                li.addEventListener('click', function() { choose(r); });
                menu.appendChild(li);
            });
        }

        function setFocus(i) {
            var list = items();
            if (!list.length) return;
            focusIdx = (i + list.length) % list.length;
            list.forEach(function(el, idx) {
                el.classList.toggle('is-focus', idx === focusIdx);
            });
        }

        function open() {
            dd.classList.add('is-open');
            btn.setAttribute('aria-expanded', 'true');
            var sel = RANGES.findIndex(function(r) { return r.value === state.range; });
            setFocus(sel < 0 ? 0 : sel);
        }

        function close() {
            dd.classList.remove('is-open');
            btn.setAttribute('aria-expanded', 'false');
            focusIdx = -1;
            items().forEach(function(el) { el.classList.remove('is-focus'); });
        }

        function choose(r) {
            state.range = r.value;
            label.textContent = r.label;
            build();
            close();
            btn.focus();
            renderWeeks();
        }

        btn.addEventListener('click', function() {
            dd.classList.contains('is-open') ? close() : open();
        });

        btn.addEventListener('keydown', function(e) {
            var isOpen = dd.classList.contains('is-open');
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                if (!isOpen) open();
                else setFocus(focusIdx + (e.key === 'ArrowDown' ? 1 : -1));
            } else if ((e.key === 'Enter' || e.key === ' ') && isOpen && focusIdx > -1) {
                e.preventDefault();
                choose(RANGES[focusIdx]);
            } else if (e.key === 'Escape' && isOpen) {
                e.preventDefault();
                close();
            }
        });

        document.addEventListener('click', function(e) {
            if (!dd.contains(e.target)) close();
        });

        build();
    })();

    /* ---------------- Recent 7 days ---------------- */
    function renderDays() {
        var names = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var today = new Date();
        var n = state.days.length;
        var items = state.days.map(function(val, i) {
            var d = new Date(today);
            d.setDate(today.getDate() - (n - 1 - i));
            var name = names[d.getDay()];
            return {
                label: name,
                value: val,
                tip: name + ': ' + val + ' leads',
                aria: name + ': ' + val + ' leads'
            };
        });
        renderBarChart('ldDays', items);
    }

    /* ---------------- Donut chart ---------------- */
    var R = 36,
        C = 2 * Math.PI * R;

    function renderDonut() {
        var svg = $('ldDonutSvg');
        var vt = visibleTotal();
        svg.innerHTML = '';
        var offset = 0;

        state.status.forEach(function(s) {
            if (state.hidden[s.key] || !vt) return;
            var len = (s.value / vt) * C;
            var c = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
            c.setAttribute('class', 'seg');
            c.setAttribute('cx', 50);
            c.setAttribute('cy', 50);
            c.setAttribute('r', R);
            c.setAttribute('stroke', s.color);
            c.setAttribute('stroke-dasharray', len + ' ' + (C - len));
            c.setAttribute('stroke-dashoffset', -offset);
            c.dataset.key = s.key;
            c.addEventListener('mouseenter', function() { focusSeg(s.key); });
            c.addEventListener('mouseleave', clearFocus);
            svg.appendChild(c);
            offset += len;
        });
        clearFocus();
    }

    function focusSeg(key) {
        var s = get(key);
        $('ldDonut').classList.add('has-focus');
        $('ldDonutSvg').querySelectorAll('circle.seg').forEach(function(c) {
            c.classList.toggle('is-on', c.dataset.key === key);
        });
        $('ldDonutValue').textContent = fmt(s.value);
        $('ldDonutLabel').textContent = s.label;
    }

    function clearFocus() {
        $('ldDonut').classList.remove('has-focus');
        $('ldDonutSvg').querySelectorAll('circle.seg').forEach(function(c) {
            c.classList.remove('is-on');
        });
        $('ldDonutValue').textContent = fmt(visibleTotal());
        $('ldDonutLabel').textContent = '';
    }

    /* ---------------- Legend ---------------- */
    function renderLegend() {
        var ul = $('ldLegend');
        var t = total();
        ul.innerHTML = '';
        state.status.forEach(function(s) {
            var li = document.createElement('li');
            li.className = state.hidden[s.key] ? 'is-off' : '';
            li.setAttribute('tabindex', '0');
            li.setAttribute('role', 'button');
            li.setAttribute('aria-pressed', String(!state.hidden[s.key]));
            li.innerHTML = '<span class="dot" style="background:' + s.color + '"></span>' +
                '<span>' + s.label + '&nbsp; ' + pct(s.value, t) + '%</span>';

            li.addEventListener('click', function() { toggleSeg(s.key); });
            li.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleSeg(s.key);
                }
            });
            li.addEventListener('mouseenter', function() {
                if (!state.hidden[s.key]) focusSeg(s.key);
            });
            li.addEventListener('mouseleave', clearFocus);
            ul.appendChild(li);
        });
    }

    function toggleSeg(key) {
        var visibleCount = state.status.filter(function(x) { return !state.hidden[x.key]; }).length;
        if (!state.hidden[key] && visibleCount === 1) return; // keep at least one segment
        state.hidden[key] = !state.hidden[key];
        renderLegend();
        renderDonut();
    }

    /* ---------------- Lead source ---------------- */
    function renderSources() {
        var wrap = $('ldSources');
        var t = state.sources.reduce(function(s, x) { return s + x.value; }, 0);
        var max = Math.max.apply(null, state.sources.map(function(x) { return x.value; })) || 1;
        wrap.innerHTML = '';
        $('ldSrcTotal').textContent = fmt(t) + ' total';

        state.sources.forEach(function(s) {
            var row = document.createElement('div');
            row.className = 'ld-src-row';
            row.innerHTML =
                '<div class="ld-src-top">' +
                    '<span class="ld-src-name">' +
                        '<span class="ld-src-icon" style="background:' + s.color + '"><i class="bi ' + s.icon + '"></i></span>' +
                        s.label +
                    '</span>' +
                    '<span class="ld-src-val"><strong>' + fmt(s.value) + '</strong>' + pct(s.value, t) + '%</span>' +
                '</div>' +
                '<div class="ld-src-track"><div class="ld-src-fill" style="background:' + s.color + '"></div></div>';
            wrap.appendChild(row);

            var w = Math.round((s.value / max) * 100);
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    row.querySelector('.ld-src-fill').style.width = w + '%';
                });
            });
        });
    }

    /* ---------------- Init ---------------- */
    function renderAll() {
        renderStats();
        renderWeeks();
        renderDays();
        renderLegend();
        renderDonut();
        renderSources();
    }
    renderAll();
})();
</script>
@endpush
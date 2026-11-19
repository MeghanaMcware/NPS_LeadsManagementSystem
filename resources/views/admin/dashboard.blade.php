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

/* Greeting banner */
.ld-hero {
    background: var(--ld-blue);
    color: #fff;
    border-radius: 16px;
    padding: 28px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    height: 100%;
}

.ld-hero h2 {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 6px;
    color: #fff;
}

.ld-hero p {
    margin: 0;
    font-size: 14px;
    opacity: .92;
}

.ld-btn {
    border: 1px solid #fff;
    background: #fff;
    color: var(--ld-blue);
    font-weight: 600;
    font-size: 14px;
    padding: 10px 20px;
    border-radius: 10px;
    cursor: pointer;
    transition: background .15s, box-shadow .15s;
    white-space: nowrap;
}

.ld-btn:hover {
    background: #f3f6fb;
}

.ld-btn:focus-visible {
    outline: 3px solid rgba(255, 255, 255, .55);
    outline-offset: 2px;
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

.ld-range {
    border: 0;
    background: transparent;
    color: var(--ld-muted);
    font-size: 12px;
    cursor: pointer;
    padding: 2px 0;
}

.ld-range:focus-visible {
    outline: 2px solid var(--ld-blue);
}

/* Bar chart */
.ld-bars {
    height: 230px;
    display: flex;
    align-items: flex-end;
    gap: 22px;
    padding: 0 6px;
    border-bottom: 1px solid transparent;
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
}

.ld-bar {
    width: 100%;
    max-width: 40px;
    background: var(--ld-blue-soft);
    border-radius: 6px 6px 4px 4px;
    height: 0;
    transition: height .6s cubic-bezier(.2, .7, .2, 1), background .2s;
}

.ld-bar-col.is-active .ld-bar,
.ld-bar-col:hover .ld-bar {
    background: var(--ld-blue);
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

/* Toast */
.ld-toast {
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 2100;
    background: var(--ld-ink);
    color: #fff;
    padding: 12px 18px;
    border-radius: 10px;
    font-size: 14px;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity .25s, transform .25s;
    pointer-events: none;
}

.ld-toast.is-show {
    opacity: 1;
    transform: none;
}

@media (max-width: 575.98px) {
    .ld-hero {
        flex-direction: column;
        align-items: flex-start;
    }

    .ld-bars {
        gap: 8px;
    }

    .ld-stat .ld-value {
        font-size: 30px;
    }
}

@media (prefers-reduced-motion: reduce) {

    .ld-bar,
    .ld-toast,
    .ld-donut circle.seg {
        transition: none;
    }
}

.newfont{
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

<div class=" ld mt-0 pt-0">

    {{-- Row 1: greeting --}}
    <div class="row g-3 mb-3">
        <div class="col-12">
            <div class="ld-hero">
                <div>
                    <h2><span id="ldGreeting">Good morning</span>, {{ auth()->user()->name ?? 'Priya' }}!</h2>
                    <p>You have <span id="ldHeroNew">12</span> new leads today and <span id="ldHeroFollow">8</span>
                        follow-ups due. Let's get started.</p>
                </div>
                <a href="{{ url('/sendmessage/index') }}" class="ld-btn" id="ldMessageLeads">Message new leads</a>
            </div>
        </div>
    </div>

    {{-- Row 2: stat cards --}}
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

    {{-- Row 3: charts --}}
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6">
            <div class="ld-card ld-chart">
                <div class="ld-chart-head">
                    <h6>Leads per week</h6>
                    <select class="ld-range" id="ldRange" aria-label="Time range">
                        <option value="8" selected>Last 8 weeks</option>
                        <option value="4">Last 4 weeks</option>
                    </select>
                </div>
                <div class="ld-bars" id="ldBars" role="list"></div>
            </div>
        </div>
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
    </div>
</div>

<div class="ld-toast" id="ldToast" role="status" aria-live="polite"></div>


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
                        <td><a class="btn btn-primary" href="{{ url('/leads/view') }}">  <i class="bi bi-eye-fill"></i> View</a></td>
                    </tr>
                    <tr>
                        <td>Garrett Winters</td>
                        <td>123-456-7890</td>
                        <td>Referral</td>
                        <td><span class="badge bg-info text-white">Contacted</span></td>
                       <td><a class="btn btn-primary" href="{{ url('/leads/view') }}">  <i class="bi bi-eye-fill"></i> View</a></td>
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
        weeks: [96, 138, 108, 172, 152, 201, 189, 230], // leads per week (W1..W8)
        newToday: 12,
        followUpsDue: 8,
        status: [{
                key: 'new',
                label: 'New',
                value: 374,
                color: '#0071ee'
            },
            {
                key: 'contacted',
                label: 'Contacted',
                value: 536,
                color: '#e88700'
            },
            {
                key: 'followup',
                label: 'Follow-up',
                value: 124,
                color: '#7a4bd6'
            },
            {
                key: 'converted',
                label: 'Converted',
                value: 214,
                color: '#00996b'
            }
        ],
        hidden: {}, // legend toggles
        range: 8
    };

    var $ = function(id) {
        return document.getElementById(id);
    };
    var fmt = function(n) {
        return Number(n).toLocaleString('en-IN');
    };

    /* ---------------- Helpers ---------------- */
    function total() {
        return state.status.reduce(function(s, x) {
            return s + x.value;
        }, 0);
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
        return state.status.filter(function(x) {
            return x.key === key;
        })[0];
    }

    var toastTimer;

    function toast(msg) {
        var t = $('ldToast');
        t.textContent = msg;
        t.classList.add('is-show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function() {
            t.classList.remove('is-show');
        }, 2600);
    }

    /* ---------------- Greeting ---------------- */
    (function setGreeting() {
        var h = new Date().getHours();
        $('ldGreeting').textContent = h < 12 ? 'Good morning' : (h < 17 ? 'Good afternoon' : 'Good evening');
    })();

    /* ---------------- Stat cards + hero ---------------- */
    function renderStats() {
        var t = total();
        $('ldTotal').textContent = fmt(t);
        $('ldNewToday').textContent = state.newToday;
        $('ldHeroNew').textContent = state.newToday;
        $('ldHeroFollow').textContent = state.followUpsDue;
        $('ldContacted').textContent = fmt(get('contacted').value);
        $('ldContactedPct').textContent = pct(get('contacted').value, t) + '% of total';
        $('ldConverted').textContent = fmt(get('converted').value);
        $('ldConvertedPct').textContent = pct(get('converted').value, t) + '% rate';
    }

    /* ---------------- Bar chart ---------------- */
    var activeBar = null;

    function renderBars() {
        var wrap = $('ldBars');
        var all = state.weeks;
        var start = all.length - state.range;
        var data = all.slice(start);
        var max = Math.max.apply(null, data);
        wrap.innerHTML = '';

        data.forEach(function(val, i) {
            var weekNo = start + i + 1;
            var h = Math.round((val / max) * 100);
            var isLast = i === data.length - 1;

            var col = document.createElement('div');
            col.className = 'ld-bar-col' + (isLast ? ' is-active' : '');
            col.setAttribute('role', 'listitem');
            col.setAttribute('tabindex', '0');
            col.setAttribute('aria-label', 'Week ' + weekNo + ': ' + val + ' leads');
            col.style.setProperty('--h', h + '%');
            col.innerHTML =
                '<div class="ld-tip">W' + weekNo + ': ' + val + ' leads</div>' +
                '<div class="ld-bar"></div>' +
                '<div class="ld-bar-label">W' + weekNo + '</div>';

            col.addEventListener('click', function() {
                setActive(col);
            });
            col.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    setActive(col);
                }
            });
            wrap.appendChild(col);

            // animate height after insertion
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    col.querySelector('.ld-bar').style.height = h + '%';
                });
            });
        });
        activeBar = wrap.lastElementChild;
    }

    function setActive(col) {
        if (activeBar) activeBar.classList.remove('is-active');
        col.classList.add('is-active');
        activeBar = col;
    }
    $('ldRange').addEventListener('change', function(e) {
        state.range = parseInt(e.target.value, 10);
        renderBars();
    });

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
            c.addEventListener('mouseenter', function() {
                focusSeg(s.key);
            });
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

            li.addEventListener('click', function() {
                toggleSeg(s.key);
            });
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
        var visibleCount = state.status.filter(function(x) {
            return !state.hidden[x.key];
        }).length;
        if (!state.hidden[key] && visibleCount === 1) return; // keep at least one segment
        state.hidden[key] = !state.hidden[key];
        renderLegend();
        renderDonut();
    }

    /* ---------------- Message new leads ---------------- */
    $('ldMessageLeads').addEventListener('click', function() {
        toast('Greeting queued for ' + state.newToday + ' new leads');
        state.newToday = 0;
        renderStats();
    });

    /* ---------------- Init ---------------- */
    function renderAll() {
        renderStats();
        renderBars();
        renderLegend();
        renderDonut();
    }
    renderAll();
})();
</script>
@endpush
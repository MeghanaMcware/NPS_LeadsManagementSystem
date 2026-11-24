<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#002d62">
    <title>National Public School - Kempegowda Layout 7th Block | Admissions Open 2027-28</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --nps-navy: #002d62;
            --nps-deep-navy: #002147;
            --nps-gold: #fbbf24;
            --nps-red: #b91c1c;
            --nps-ink: #172554;
            --nps-muted: #526078;
            --nps-line: #dce5ef;
            --nps-heading: "Playfair Display", Georgia, serif;
            --nps-body: "Lato", Arial, sans-serif;
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--nps-ink);
            background: #f6f8fb;
            font-family: var(--nps-body);
            font-size: 14px;
            line-height: 1.5;
            overflow-x: clip;
            width: 100%;
        }

        a { color: inherit; }

        .page-shell {
            min-height: 100vh;
            margin: 0 auto;
            overflow-x: clip;
            background: #fff;
            box-shadow: 0 0 26px rgb(0 33 71 / 8%);
        }

        /* ================= HERO BANNER - ACTIVITIES STYLE ================= */
        .hero-section {
            position: relative;
            padding: 85px 24px 115px;
            min-height: 540px;
            display: flex;
            align-items: center;
            background-color: #0b1a36;
            background-image: 
                linear-gradient(90deg, #0b1a36 0%, rgba(11, 26, 54, 0.98) 32%, rgba(11, 26, 54, 0.5) 46%, transparent 54%),
                url("{{ asset('images/home-hero-activities-style.jpg') }}");
            background-repeat: no-repeat;
            background-position: center right;
            background-size: cover;
            color: #fff;
            overflow: hidden;
            isolation: isolate;
        }

        .hero-section::before {
            position: absolute;
            content: "";
            inset: 0;
            background: radial-gradient(circle at 85% 15%, rgba(251, 191, 36, 0.15) 0%, transparent 45%),
                        radial-gradient(circle at 10% 85%, rgba(185, 28, 28, 0.15) 0%, transparent 40%);
            z-index: 1;
            pointer-events: none;
        }

        .hero-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(251, 191, 36, 0.4);
            border-radius: 30px;
            color: #fef08a;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            backdrop-filter: blur(6px);
            margin-bottom: 16px;
        }

        .hero-headline {
            font-family: "Playfair Display", Georgia, serif;
            font-size: clamp(34px, 4.2vw, 54px);
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            margin-bottom: 14px;
        }

        .hero-headline span.hero-gold-accent {
            font-family: "Playfair Display", Georgia, serif;
            color: var(--nps-gold);
            font-style: italic;
            display: inline;
        }

        .grade-pill-wrap {
            margin-bottom: 14px;
        }

        .grade-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 18px;
            border-radius: 25px;
            color: var(--nps-navy);
            background: #fff;
            font-size: 13.5px;
            font-weight: 800;
            letter-spacing: .01em;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.16);
        }

        .hero-lead {
            font-size: clamp(15px, 1.25vw, 17px);
            color: #dbeafe;
            max-width: 620px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .quick-nav-pills {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
        }

        .quick-pill-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            backdrop-filter: blur(8px);
            transition: all 0.22s ease-in-out;
            cursor: pointer;
        }

        .quick-pill-btn:hover {
            background: rgba(255, 255, 255, 0.22);
            border-color: #fff;
            color: #fff;
            transform: translateY(-2px);
        }

        .quick-pill-gold {
            background: var(--nps-gold);
            color: var(--nps-navy);
            border-color: var(--nps-gold);
            box-shadow: 0 4px 16px rgba(251, 191, 36, 0.35);
        }

        .quick-pill-gold:hover {
            background: #f5ad12;
            color: var(--nps-deep-navy);
            border-color: #f5ad12;
            box-shadow: 0 6px 20px rgba(251, 191, 36, 0.45);
        }

        .quick-pill-video {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.6);
            color: #fff;
        }

        .quick-pill-video:hover {
            background: rgba(255, 255, 255, 0.22);
            border-color: #fff;
        }

        .play-circle {
            display: inline-flex;
            width: 18px;
            height: 18px;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #fff;
            border-radius: 50%;
        }

        .value-ribbon {
            position: relative;
            z-index: 3;
            margin: -24px 24px 0;
            padding: 12px 14px;
            border: 1px solid #edf1f5;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 6px 24px rgb(0 45 98 / 13%);
        }

        .value-item {
            display: flex;
            min-height: 46px;
            align-items: center;
            gap: 9px;
            padding: 0 10px;
            color: var(--nps-navy);
            font-size: 11.5px;
            font-weight: 800;
            line-height: 1.25;
        }

        .value-item + .value-item { border-left: 1px solid #edf1f5; }

        .section-pad { padding: 24px 26px 8px; }

        .section-heading {
            margin: 0;
            color: var(--nps-navy);
            font-family: var(--nps-heading);
            font-size: 22px;
            font-weight: 800;
            line-height: 1.2;
        }

        .section-eyebrow {
            margin-bottom: 4px;
            color: var(--nps-navy);
            font-size: 12px;
            font-weight: 800;
        }

        .heading-rule {
            width: 38px;
            height: 3px;
            margin: 6px 0 9px;
            border-radius: 3px;
            background: var(--nps-gold);
        }

        .about-copy { padding-right: 10px; }
        .about-description { margin: 8px 0 12px; color: var(--nps-muted); font-size: 13.5px; line-height: 1.55; }

        .button-outline {
            padding: 8px 15px;
            border: 1px solid var(--nps-navy);
            color: var(--nps-navy);
            background: #fff;
            font-size: 12.5px;
        }

        .button-outline:hover { color: #fff; background: var(--nps-navy); }

        .about-photo-frame,
        .rounded-photo {
            overflow: hidden;
            border: 1px solid var(--nps-line);
            border-radius: 13px;
        }

        .about-photo {
            display: block;
            width: 100%;
            height: 155px;
            object-fit: cover;
        }

        .school-stats { display: grid; gap: 10px; padding-left: 4px; }
        .stat-item { display: flex; align-items: center; gap: 9px; color: var(--nps-navy); }
        .stat-value { display: block; font-size: 18px; font-weight: 800; line-height: 1.1; }
        .stat-label { display: block; margin-top: 2px; color: #69758a; font-size: 11.5px; }

        .cards-section { padding-top: 6px; }

        .feature-card {
            display: flex;
            align-items: stretch;
            height: 100%;
            gap: 12px;
            padding: 10px 12px;
            border: 1px solid var(--nps-line);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 2px 8px rgb(0 33 71 / 4%);
        }

        .cards-section .col-md-6:first-child .feature-card { background: #eef5fc; border-color: #d8e5f3; }
        .cards-section .col-md-6:last-child .feature-card { background: #fdfbf7; border-color: #ede6dc; }

        .feature-photo {
            width: 100px;
            min-width: 100px;
            align-self: stretch;
            overflow: hidden;
            border-radius: 10px;
            background: #eef4fa;
        }

        .feature-photo img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .feature-content { display: flex; min-width: 0; flex: 1; flex-direction: column; justify-content: space-between; }
        .feature-header { margin-bottom: 7px; }
        .feature-title { margin: 0; color: var(--nps-navy); font-family: var(--nps-heading); font-size: 17px; font-weight: 800; line-height: 1.2; }
        .feature-accent {
            width: 30px;
            height: 2.5px;
            background: #f59e0b;
            border-radius: 2px;
            margin-top: 4px;
            margin-bottom: 6px;
        }
        .panel-title::after {
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 25px;
            height: 2px;
            border-radius: 2px;
            background: var(--nps-gold);
            content: "";
        }
        .feature-description { margin: 0 0 8px; color: #4b586d; font-size: 11.5px; line-height: 1.45; }
        .mini-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 6px; align-items: stretch; text-align: center; }
        .mini-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #dbe5f0;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgb(0 33 71 / 4%);
            text-align: center;
            color: var(--nps-navy);
            font-size: 9.5px;
            font-weight: 800;
            line-height: 1.2;
            padding: 8px 3px 7px;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }
        .mini-item:hover { transform: translateY(-1px); box-shadow: 0 3px 6px rgb(0 33 71 / 8%); }
        .academic-grid .mini-item { min-height: 72px; padding: 8px 3px 7px; font-size: 10px; }
        .activity-grid { gap: 5px 5px; }
        .activity-grid .mini-item { min-height: 48px; padding: 5px 2px 4px; font-size: 9px; }
        .mini-icon { display: flex; align-items: center; justify-content: center; margin-bottom: 4px; color: var(--nps-navy); }
        .mini-icon svg { width: 22px; height: 22px; stroke: currentColor; stroke-width: 1.9; }
        .academic-grid .mini-icon svg { width: 24px; height: 24px; }
        .activity-grid .mini-icon svg { width: 19px; height: 19px; }
        .mini-icon.eco-icon { color: #16a34a; }
        .mini-icon.eco-icon svg { stroke: #16a34a; }

        /* ===================================================
           CAMPUS SECTION - FULL DESIGN CODED
           =================================================== */
        .campus-section {
            padding-top: 14px;
            padding-bottom: 12px;
        }

        .nps-campus-showcase {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(238, 245, 253, 0.94) 0%, rgba(225, 238, 252, 0.96) 100%),
                        url('{{ asset('images/Modern NPS Corporate Campus.png') }}') center / cover no-repeat;
            border: 1px solid rgba(0, 37, 84, 0.12);
            box-shadow: 0 16px 40px rgba(0, 25, 65, 0.12);
            padding: 22px 22px 18px;
        }

        /* 3-Column Main Grid */
        .nps-campus-main-grid {
            display: grid;
            grid-template-columns: 220px 1fr 310px;
            gap: 16px;
            align-items: stretch;
        }

        /* Left Card - Deep Navy */
        .nps-campus-left-card {
            position: relative;
            background: linear-gradient(155deg, #001f46 0%, #00285a 50%, #001a3b 100%);
            border-radius: 20px;
            padding: 20px 18px 18px;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 28px rgba(0, 25, 65, 0.28);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        
        .nps-campus-crest {
            width: 44px;
            height: 44px;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .nps-campus-kicker {
            color: #f59e0b;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .15em;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .nps-campus-heading {
            font-family: var(--nps-heading);
            font-size: 32px;
            font-weight: 800;
            line-height: 1.08;
            margin: 0 0 6px;
            color: #ffffff;
        }

        .nps-campus-heading span {
            color: #f59e0b;
            font-family: var(--nps-body);
            font-weight: 900;
            display: block;
        }

        .nps-campus-heading-underline {
            width: 32px;
            height: 3px;
            background: #f59e0b;
            border-radius: 2px;
            margin-bottom: 10px;
        }

        .nps-campus-intro {
            font-size: 11.5px;
            line-height: 1.45;
            color: #dbeafe;
            margin-bottom: 14px;
        }

        .nps-campus-benefits-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
            margin-bottom: 16px;
        }

        .nps-campus-benefit-row {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #f8fafc;
            font-size: 11.5px;
            font-weight: 600;
        }

        .nps-campus-benefit-circle {
            width: 26px;
            height: 26px;
            flex: 0 0 26px;
            border-radius: 50%;
            border: 1.5px solid #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f59e0b;
        }

        .nps-campus-benefit-circle svg {
            width: 14px;
            height: 14px;
        }

        .nps-campus-explore-btn {
            background: #f59e0b;
            color: #001f46;
            font-size: 12.5px;
            font-weight: 800;
            padding: 8px 18px;
            border-radius: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4);
            transition: transform 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
            width: fit-content;
        }

        .nps-campus-explore-btn:hover {
            background: #d97706;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(245, 158, 11, 0.5);
        }

        /* Middle Card - 3D Map in White Frame */
        .nps-campus-middle-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .nps-campus-map-anchor {
            display: block;
            position: relative;
            width: 100%;
            height: 100%;
            border-radius: 14px;
            overflow: hidden;
            text-decoration: none;
            cursor: pointer;
        }

        .nps-campus-map-photo {
            display: block;
            width: 100%;
            height: 100%;
            min-height: 380px;
            object-fit: cover;
            border-radius: 14px;
            transition: transform 0.3s ease;
        }

        .nps-campus-map-anchor:hover .nps-campus-map-photo {
            transform: scale(1.015);
        }

        .nps-campus-map-zoom-pill {
            position: absolute;
            bottom: 12px;
            right: 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 13px;
            border-radius: 20px;
            background: rgba(0, 31, 70, 0.88);
            border: 1px solid #f59e0b;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            backdrop-filter: blur(4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: background 0.2s ease, color 0.2s ease;
        }

        .nps-campus-map-anchor:hover .nps-campus-map-zoom-pill {
            background: #f59e0b;
            color: #001f46;
        }

        /* Right Card - Facilities Index */
        .nps-campus-right-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .nps-facilities-header {
            background: #002554;
            color: #ffffff;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14.5px;
            font-weight: 800;
        }

        .nps-facilities-header-icon {
            color: #f59e0b;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .nps-facilities-list {
            padding: 7px 10px 8px;
            display: flex;
            flex-direction: column;
            gap: 3.5px;
            max-height: 400px;
            /* overflow-y: auto; */
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .nps-facilities-list::-webkit-scrollbar {
            width: 4px;
        }

        .nps-facilities-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .nps-facility-item {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 3px 5px;
            border-radius: 8px;
            transition: background 0.15s ease;
        }

        .nps-facility-item:hover {
            background: #f1f5f9;
        }

        .nps-facility-badge {
            width: 20px;
            height: 20px;
            flex: 0 0 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 800;
        }

        .badge-col-1  { background: #f59e0b; }
        .badge-col-2  { background: #2563eb; }
        .badge-col-3  { background: #ea580c; }
        .badge-col-4  { background: #16a34a; }
        .badge-col-5  { background: #9333ea; }
        .badge-col-6  { background: #0891b2; }
        .badge-col-7  { background: #ea580c; }
        .badge-col-8  { background: #78716c; }
        .badge-col-9  { background: #eab308; }
        .badge-col-10 { background: #16a34a; }
        .badge-col-11 { background: #7c3aed; }
        .badge-col-12 { background: #0d9488; }

        .nps-facility-icon {
            width: 17px;
            height: 17px;
            flex: 0 0 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e3a8a;
        }

        .nps-facility-icon svg {
            width: 14px;
            height: 14px;
        }

        .nps-facility-text {
            min-width: 0;
            line-height: 1.15;
        }

        .nps-facility-name {
            color: #002147;
            font-size: 14px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nps-facility-sub {
            color: #64748b;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Bottom Row - 4 Highlight Cards + Wave Ribbon */
        .nps-campus-bottom-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 14px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .nps-campus-bottom-pills {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .nps-bottom-pill {
            background: #ffffff;
            border-radius: 12px;
            padding: 7px 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #002147;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(226, 232, 240, 0.9);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .nps-bottom-pill:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .nps-bottom-pill-icon {
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nps-bottom-pill-icon.green  { color: #16a34a; }
        .nps-bottom-pill-icon.blue   { color: #0284c7; }
        .nps-bottom-pill-icon.navy   { color: #002554; }
        .nps-bottom-pill-icon.pink   { color: #e11d48; }

        .nps-campus-wave-banner {
            position: relative;
            background: linear-gradient(135deg, #001f46 0%, #002b66 100%);
            border-radius: 20px 0 0 20px;
            padding: 6px 20px 6px 24px;
            margin-right: -22px;
            display: flex;
            align-items: center;
            box-shadow: -4px 4px 14px rgba(0, 25, 65, 0.2);
            border-left: 3px solid #f59e0b;
        }

        .nps-campus-wave-text {
            color: #ffffff;
            font-family: "Lato", Arial, sans-serif;
            font-size: 17px;
            font-weight: 600;
            font-style: italic;
            letter-spacing: .08em;
            white-space: nowrap;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1199.98px) {
            .nps-campus-main-grid {
                grid-template-columns: 240px 1fr 245px;
                gap: 12px;
            }
            .nps-campus-heading { font-size: 28px; }
            .nps-campus-map-photo { min-height: 340px; }
            .nps-facilities-list { max-height: 360px; }
        }

        @media (max-width: 991.98px) {
            .nps-campus-main-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .nps-campus-left-card { text-align: center; align-items: center; }
            .nps-campus-heading-underline { margin: 0 auto 10px; }
            .nps-campus-benefits-list { flex-direction: row; flex-wrap: wrap; justify-content: center; }
            .nps-campus-explore-btn { margin: 0 auto; }
            .nps-campus-map-photo { min-height: 280px; max-height: 380px; }
            .nps-campus-right-card { max-width: 520px; margin: 0 auto; width: 100%; }
            .nps-facilities-list { max-height: 320px; }
            .nps-campus-wave-banner { border-radius: 14px; margin-right: 0; }
        }

        @media (max-width: 575.98px) {
            .nps-campus-showcase { padding: 14px; border-radius: 16px; }
            .nps-campus-heading { font-size: 24px; }
            .nps-campus-bottom-bar { flex-direction: column; align-items: stretch; }
            .nps-campus-bottom-pills { justify-content: center; }
            .nps-campus-wave-banner { justify-content: center; border-radius: 12px; margin: 0; }
        }

        .map-modal {
            position: fixed;
            z-index: 120;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(0, 15, 35, 0.88);
            backdrop-filter: blur(5px);
        }

        .map-modal.is-open { display: flex; }

        .map-dialog {
            position: relative;
            max-width: 1200px;
            width: 100%;
            max-height: 92vh;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            background: #001733;
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 12px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
        }

        .map-dialog-img {
            width: 100%;
            height: auto;
            max-height: 86vh;
            object-fit: contain;
            border-radius: 12px;
        }

        .map-modal-close {
            position: absolute;
            top: -14px;
            right: -14px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 0;
            background: var(--nps-gold);
            color: var(--nps-navy);
            font-size: 22px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
            z-index: 10;
        }

        .bottom-section { padding-top: 12px; padding-bottom: 20px; }
        .left-column { display: flex; flex-direction: column; gap: 14px; }
        .content-panel { padding: 14px; border: 1px solid var(--nps-line); border-radius: 13px; background: #fff; box-shadow: 0 2px 6px rgb(15 23 42 / 3%); }
        .panel-title { position: relative; margin: 0; color: var(--nps-navy); font-family: var(--nps-heading); font-size: 18px; font-weight: 800; line-height: 1.25; }
        .event-controls { display: flex; gap: 5px; }
        .event-control { display: flex; width: 26px; height: 26px; align-items: center; justify-content: center; border: 1px solid #cbd5e1; border-radius: 50%; color: #526078; background: #fff; }
        .event-grid { display: grid; grid-auto-columns: minmax(110px, 1fr); grid-auto-flow: column; gap: 10px; overflow-x: auto; padding-bottom: 3px; scrollbar-width: none; }
        .event-grid::-webkit-scrollbar { display: none; }
        .event-image-frame { aspect-ratio: 4 / 3; overflow: hidden; border: 1px solid #edf1f5; border-radius: 8px; }
        .event-image { width: 100%; height: 100%; object-fit: cover; }
        .event-title { margin: 5px 0 2px; color: var(--nps-navy); font-size: 13px; font-weight: 800; line-height: 1.2; }
        .event-description { margin: 0; color: #68758a; font-size: 11.5px; line-height: 1.4; }

        .process-row { display: flex; align-items: center; justify-content: space-between; text-align: center; }
        .process-step { display: flex; min-width: 0; flex: 1; flex-direction: column; align-items: center; color: #334155; font-size: 12px; font-weight: 700; line-height: 1.25; }
        .process-icon { display: flex; width: 32px; height: 32px; align-items: center; justify-content: center; margin-bottom: 5px; border: 1px solid var(--nps-line); border-radius: 7px; color: var(--nps-navy); }
        .process-icon.is-complete { border-color: #a7dfca; color: #16834f; background: #effcf6; }
        .process-arrow { flex: 0 0 auto; margin: -11px 2px 0; color: #7b8799; }

        .testimonial { display: flex; align-items: center; gap: 12px; }
        .testimonial-copy { flex: 1; }
        .quote-mark { color: var(--nps-gold); font-family: "Lato", Arial, sans-serif; font-size: 32px; font-weight: 800; line-height: .8; }
        .quote-text { margin: 3px 0 5px; color: #536176; font-size: 13px; font-style: italic; line-height: 1.45; }
        .quote-author { color: #334155; font-size: 12px; font-weight: 800; }
        .parent-photo { width: 62px; height: 62px; flex: 0 0 62px; overflow: hidden; border: 2px solid #fde68a; border-radius: 50%; }
        .parent-photo img { width: 100%; height: 100%; object-fit: cover; }
        .testimonial-slider-container { position: relative; overflow: hidden; width: 100%; }
        .testimonial-track { display: flex; width: 100%; transition: transform 0.5s cubic-bezier(0.25, 1, 0.5, 1); will-change: transform; }
        .testimonial-slide { flex: 0 0 100%; width: 100%; min-width: 100%; box-sizing: border-box; }
        .testimonial-dots { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 10px; }
        .testimonial-dot { width: 6px; height: 6px; border-radius: 999px; background: #cbd5e1; border: none; padding: 0; cursor: pointer; transition: all 0.3s ease; }
        .testimonial-dot:hover { background: #94a3b8; }
        .testimonial-dot.is-active { width: 18px; background: var(--nps-navy); }
        .event-control:hover { background: var(--nps-navy); color: #fff; border-color: var(--nps-navy); }

        .enquiry-column { display: flex; }

        .enquiry-panel {
            display: flex;
            width: 100%;
            flex-direction: column;
            justify-content: space-between;
            padding: 18px;
            border-radius: 16px;
            color: #fff;
            background: var(--nps-navy);
            box-shadow: 0 8px 20px rgb(0 33 71 / 18%);
        }

        .enquiry-heading { display: flex; align-items: center; gap: 8px; margin-bottom: 3px; }
        .enquiry-heading .icon { color: var(--nps-gold); }
        .enquiry-title { margin: 0; color: #fff; font-family: var(--nps-heading); font-size: 20px; font-weight: 800; }
        .enquiry-intro { margin: 5px 0 12px; color: #c7d9ee; font-size: 12.5px; line-height: 1.45; }
        .enquiry-form { display: grid; gap: 8px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; z-index: 1; top: 19px; left: 11px; width: 15px; height: 15px; transform: translateY(-50%); color: #8190a4; pointer-events: none; }
        .enquiry-input { width: 100%; min-height: 38px; padding: 8px 12px 8px 36px; border: 0; border-radius: 8px; color: #263449; background: #fff; font-family: var(--nps-body); font-size: 13px; }
        .enquiry-input::placeholder { color: #8894a6; opacity: 1; }
        .enquiry-input:focus { outline: 2px solid #fbbf24; outline-offset: 1px; }
        .was-validated .enquiry-input:invalid { border: 1px solid #fda4af; }
        .enquiry-form .invalid-feedback { margin: 3px 0 0 4px; color: #fecaca; font-size: 11px; line-height: 1.2; }
        .select-wrap::after { position: absolute; top: 50%; right: 12px; width: 7px; height: 7px; transform: translateY(-70%) rotate(45deg); border-right: 1.5px solid #738095; border-bottom: 1.5px solid #738095; content: ""; pointer-events: none; }
        .enquiry-select { appearance: none; }
        .submit-button { display: flex; min-height: 38px; align-items: center; justify-content: center; gap: 8px; margin-top: 2px; border: 0; border-radius: 8px; color: var(--nps-navy); background: var(--nps-gold); font-size: 13px; font-weight: 800; }
        .submit-button:hover { background: #f5ad12; }
        .whatsapp-link { display: flex; min-height: 36px; align-items: center; justify-content: center; gap: 7px; margin-top: 10px; border: 1px solid #a7dfca; border-radius: 8px; color: #087348; background: #fff; font-size: 13px; font-weight: 800; text-decoration: none; }
        .whatsapp-link:hover { background: #f0fdf4; }

        .footer-bg {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: 18px 0 16px;
            color: #fff;
            background-color: var(--nps-navy);
            background-image: linear-gradient(to bottom, #002d62 0%, #002d62 66%, rgb(0 45 98 / 76%) 83%, rgb(0 45 98 / 36%) 100%), url("{{ asset('images/footer-skyline.png') }}");
            background-position: center, center bottom;
            background-repeat: no-repeat;
            background-size: 100% 100%, 100% auto;
        }

        .footer-bg::before {
            position: absolute;
            z-index: -1;
            top: -9px;
            left: -2%;
            width: 104%;
            height: 18px;
            border-top: 3px solid var(--nps-gold);
            border-radius: 50% 50% 0 0 / 18px 18px 0 0;
            content: "";
        }

        .footer-brand { display: inline-flex; align-items: center; gap: 9px; color: #fff; text-decoration: none; }
        .footer-logo { width: 38px; height: 38px; border-radius: 50%; object-fit: contain; }
        .footer-name { display: block; color: #fff; font-size: 14px; font-weight: 800; line-height: 1.2; white-space: nowrap; }
        .footer-subtitle { display: block; margin-top: 2px; color: var(--nps-gold); font-size: 10.5px; font-weight: 800; letter-spacing: .035em; line-height: 1.2; white-space: nowrap; }
        .footer-details { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; gap: 8px 16px; }
        .footer-item { display: inline-flex; align-items: center; gap: 6px; color: #e7edf6; font-size: 12px; line-height: 1.3; text-decoration: none; white-space: nowrap; }
        .footer-item:hover { color: #fff; }
        .footer-item .icon { color: var(--nps-gold); }

        .video-modal {
            position: fixed;
            z-index: 100;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 18px;
            background: rgb(0 0 0 / 78%);
            backdrop-filter: blur(3px);
        }

        .video-modal.is-open { display: flex; }
        .video-dialog { position: relative; width: min(100%, 680px); padding: 12px; border: 1px solid #334155; border-radius: 16px; background: #0f172a; box-shadow: 0 20px 60px rgb(0 0 0 / 35%); }
        .video-close { position: absolute; top: -12px; right: -12px; display: flex; width: 30px; height: 30px; align-items: center; justify-content: center; border: 0; border-radius: 50%; color: #172554; background: #fff; }
        .video-frame { width: 100%; aspect-ratio: 16 / 9; overflow: hidden; border-radius: 10px; background: #000; }
        .video-frame iframe { width: 100%; height: 100%; border: 0; }
        .icon { width: 17px; height: 17px; flex: 0 0 auto; stroke-width: 2; }
        .icon-sm { width: 14px; height: 14px; }
        .icon-xs { width: 12px; height: 12px; }
        .icon-lg { width: 21px; height: 21px; }

        @media (min-width: 992px) {
            body { font-size: 15px; }
            .desktop-nav { gap: 22px; font-size: 13.5px; }
            .hero-section { min-height: 520px; padding: 85px 24px 115px; }
            .hero-headline { font-size: clamp(38px, 4vw, 50px); }
            .value-ribbon { padding: 12px 14px; }
            .value-item { gap: 10px; font-size: 12.5px; }
            .section-pad { padding-top: 28px; padding-bottom: 12px; }
            .section-heading { font-size: 24px; }
            .section-eyebrow { font-size: 13px; }
            #about-section { padding: 30px 22px 16px; }
            #about-section .row { --bs-gutter-x: 1.5rem; }
            #about-section .row > .col-md-4 { flex: 0 0 30%; max-width: 30%; }
            #about-section .row > .col-md-6 { flex: 0 0 47%; max-width: 47%; }
            #about-section .row > .col-md-2 { flex: 0 0 23%; max-width: 23%; }
            .about-copy { padding-right: 8px; }
            .about-description { margin: 10px 0 14px; font-size: 14.5px; line-height: 1.6; }
            .button-outline { padding: 9px 16px; font-size: 13px; }
            .about-photo-frame { max-width: none; margin-left: 0; border-radius: 15px; }
            .about-photo { height: clamp(175px, 14vw, 200px); }
            .school-stats { gap: 15px; padding-left: 12px; }
            .stat-item { gap: 10px; }
            .stat-value { font-size: 20px; }
            .stat-label { font-size: 12.5px; }
            .stat-item .icon { width: 22px; height: 22px; }
            .feature-title { font-size: 18px; }
            .feature-description { font-size: 12px; }
            .mini-grid { gap: 6px; }
            .academic-grid .mini-item { min-height: 72px; font-size: 10px; }
            .activity-grid .mini-item { min-height: 50px; font-size: 9.5px; }
            .campus-section { padding-top: 16px; padding-bottom: 12px; }
            .campus-showcase-card { border-radius: 24px; }
            .bottom-section { padding-top: 14px; padding-bottom: 22px; }
            .content-panel { padding: 14px; }
            .panel-title { font-size: 19px; }
            .event-title { font-size: 13.5px; }
            .event-description { font-size: 12px; }
            .process-step { font-size: 12.5px; }
            .quote-text { font-size: 13.5px; }
            .quote-author { font-size: 12px; }
            .enquiry-panel { padding: 20px; }
            .enquiry-title { font-size: 21px; }
            .enquiry-intro { font-size: 13px; }
            .enquiry-input { font-size: 13.5px; }
            .submit-button,
            .whatsapp-link { font-size: 13px; }
            .footer-bg { padding: 22px 0 20px; }
            .footer-name { font-size: 14.5px; }
            .footer-subtitle { font-size: 11px; }
            .footer-item { font-size: 12.5px; }
        }

        @media (min-width: 1200px) {
            .hero-section { min-height: 560px; padding: 95px 32px 125px; }
            .hero-headline { font-size: clamp(42px, 4.2vw, 54px); }
            .section-heading { font-size: 24px; }
            .about-copy { padding-right: 14px; }
            .about-photo { height: 200px; }
            .section-pad { padding-right: 34px; padding-left: 34px; }
        }

        @media (max-width: 991.98px) {
            .site-header { padding-right: 15px; padding-left: 15px; }
            .desktop-nav { gap: 11px; font-size: 10px; }
            .brand-divider { margin-left: 7px; }
            .value-ribbon { margin-right: 16px; margin-left: 16px; }
            .value-item { gap: 6px; padding-right: 5px; padding-left: 5px; font-size: 8px; }
            .section-pad { padding-right: 18px; padding-left: 18px; }
            .campus-panel { padding: 17px; }
            .campus-title { font-size: 21px; }
            .enquiry-panel { padding: 12px; }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .site-header { padding: 4px 10px 4px 36px; }
            .brand-link { gap: 12px; }
            .brand-logo { width: 38px; height: 38px; flex-basis: 38px; }
            .brand-name { font-size: 15px; }
            .brand-subtitle { font-size: 10.5px; }
            .brand-divider { margin-left: 38px; }
            .desktop-nav { gap: 14px; font-size: 12px; }
            .desktop-nav a,
            .nav-label { padding: 6px 0; }
            .nav-admissions { padding: 6px 14px !important; font-size: 12px; }
            .hero-section {
                min-height: 480px;
                padding: 65px 20px 95px;
                background-position: right center;
                background-image: 
                    linear-gradient(90deg, #0b1a36 0%, rgba(11, 26, 54, 0.98) 38%, rgba(11, 26, 54, 0.5) 48%, transparent 58%),
                    url("{{ asset('images/home-hero-activities-style.jpg') }}");
            }
            .hero-headline { font-size: 34px; }
            .hero-lead { font-size: 14.5px; }
            .value-ribbon { margin: -20px 13px 0 28px; padding: 2px 10px; }
            .value-ribbon .row { --bs-gutter-y: 0; }
            .value-ribbon .col { flex: 0 0 16.666667%; max-width: 16.666667%; }
            .value-ribbon .col + .col .value-item { border-left: 1px solid #edf1f5; }
            .value-item { min-height: 44px; gap: 6px; font-size: 11px; }
            .value-item .icon { width: 18px; height: 18px; }
            .section-pad { padding: 12px 16px 4px; }
            #about-section { padding: 12px 20px 10px; }
            #about-section .row { --bs-gutter-x: 12px; --bs-gutter-y: 0; }
            #about-section .col-md-4 { flex: 0 0 32%; max-width: 32%; }
            #about-section .col-md-6 { flex: 0 0 47%; max-width: 47%; }
            #about-section .col-md-2 { flex: 0 0 21%; max-width: 21%; }
            .section-heading { font-size: 20px; }
            .section-eyebrow { font-size: 11.5px; }
            .about-description { margin: 6px 0 8px; font-size: 13px; line-height: 1.45; }
            .button-outline { padding: 7px 12px; font-size: 11.5px; }
            .about-photo-frame { max-width: none; margin-left: 0; }
            .about-photo { height: 155px; }
            .school-stats { gap: 8px; padding-left: 3px; }
            .stat-item { gap: 6px; }
            .stat-value { font-size: 16px; }
            .stat-label { font-size: 11px; }
            .stat-item .icon { width: 19px; height: 19px; }
            .cards-section { padding: 2px 10px 10px; }
            .cards-section .row { --bs-gutter-x: 8px; --bs-gutter-y: 0; }
            .feature-card { height: auto; min-height: 140px; gap: 9px; padding: 8px; border-radius: 12px; }
            .feature-photo { width: 95px; min-width: 95px; min-height: 120px; }
            .feature-title { font-size: 16px; }
            .feature-description { margin: 3px 0 6px; font-size: 11px; }
            .mini-grid { gap: 5px 3px; }
            .academic-grid .mini-item { min-height: 64px; font-size: 9px; padding: 6px 2px; }
            .academic-grid .mini-icon svg { width: 20px; height: 20px; }
            .activity-grid .mini-item { min-height: 46px; font-size: 8.5px; padding: 4px 2px; }
            .activity-grid .mini-icon svg { width: 16px; height: 16px; }
            .campus-section { padding: 0; }
            .campus-panel { padding: 18px 22px; border-radius: 0; }
            .campus-title { font-size: 25px; }
            .campus-description { margin-bottom: 8px; font-size: 12.5px; }
            .campus-benefits { gap: 6px; font-size: 12px; }
            .campus-benefit { gap: 6px; }
            .campus-map { max-height: 245px; }
            .campus-panel > .row > .col-md-3:first-child { flex: 0 0 25%; max-width: 25%; }
            .campus-panel > .row > .col-md-6 { flex: 0 0 75%; max-width: 75%; }
            .campus-panel > .row > .col-md-3:last-child { flex: 0 0 100%; max-width: 100%; }
            .campus-legend { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px; padding: 9px; }
            .legend-item { gap: 6px; }
            .legend-number { width: 20px; height: 20px; flex-basis: 20px; font-size: 11px; }
            .legend-title { font-size: 12px; }
            .legend-description { font-size: 10px; }
            .bottom-section { padding: 14px 16px 0; }
            .bottom-section > .row {
                display: grid;
                grid-template-columns: minmax(0, 2.5fr) minmax(210px, 1fr);
                gap: 10px;
                margin-right: 0;
                margin-left: 0;
            }
            .bottom-section > .row > .col-lg-8,
            .bottom-section > .row > .col-lg-4 { width: auto; max-width: none; padding: 0; }
            .left-column { gap: 10px; }
            .content-panel { padding: 10px; border-radius: 10px; }
            .panel-title { font-size: 16px; }
            .event-controls { gap: 4px; }
            .event-control { width: 22px; height: 22px; }
            .event-grid { grid-auto-columns: minmax(85px, 1fr); gap: 7px; }
            .event-image-frame { aspect-ratio: 3 / 2; }
            .content-panel > .d-flex .panel-title { font-size: 16px; }
            .event-title { font-family: var(--nps-heading); font-size: 12px; }
            .event-description { font-size: 10.5px; line-height: 1.25; }
            .lower-panels { --bs-gutter-x: 8px; --bs-gutter-y: 0; }
            .lower-panels .panel-title.mb-3 { margin-bottom: 4px !important; }
            .process-icon { width: 28px; height: 28px; }
            .process-step { font-size: 11px; }
            .process-arrow { width: 12px; margin-right: 0; margin-left: 0; }
            .parent-photo { width: 50px; height: 50px; flex-basis: 50px; }
            .quote-mark { font-size: 24px; }
            .quote-text { margin: 0 0 4px; font-size: 11.5px; line-height: 1.3; }
            .quote-author { font-size: 11px; }
            .enquiry-column { align-self: start; }
            .enquiry-panel { min-height: 0; padding: 12px; border-radius: 12px; }
            .enquiry-heading { gap: 6px; }
            .enquiry-title { font-size: 17px; }
            .enquiry-intro { margin: 4px 0 8px; font-size: 11px; line-height: 1.35; }
            .enquiry-form { gap: 6px; }
            .enquiry-input { min-height: 30px; padding: 5px 8px 5px 28px; font-size: 11.5px; }
            .input-icon { top: 15px; left: 8px; width: 13px; height: 13px; }
            .submit-button { min-height: 32px; font-size: 11.5px; }
            .whatsapp-link { min-height: 30px; margin-top: 8px; font-size: 11px; }
            .footer-bg { padding: 20px 0 22px; }
            .footer-logo { width: 36px; height: 36px; }
            .footer-name { font-size: 13.5px; }
            .footer-subtitle { font-size: 10px; }
            .footer-details { gap: 8px 12px; }
            .footer-item { font-size: 11px; }
            .footer-bg .container-fluid { padding-right: 30px !important; padding-left: 30px !important; }
        }

        @media (max-width: 767.98px) {
            .page-shell {
                overflow-x: clip;
                width: 100%;
                max-width: 100%;
            }
            .hero-section {
                min-height: 440px;
                padding: 45px 16px 65px;
                background-position: 80% center;
                background-image: 
                    linear-gradient(180deg, rgba(11, 26, 54, 0.94) 0%, rgba(11, 26, 54, 0.88) 55%, rgba(11, 26, 54, 0.95) 100%),
                    url("{{ asset('images/home-hero-activities-style.jpg') }}");
            }
            .hero-headline {
                font-size: clamp(26px, 7vw, 36px);
                line-height: 1.15;
            }
            .hero-lead {
                font-size: 13.5px;
                line-height: 1.5;
                margin-bottom: 18px;
            }
            .quick-nav-pills {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .quick-pill-btn {
                padding: 9px 18px;
                font-size: 13px;
            }

            .value-ribbon {
                margin: -14px 14px 0;
                padding: 10px;
                border-radius: 12px;
                box-shadow: 0 4px 16px rgba(0, 33, 71, 0.08);
            }
            .value-ribbon .row {
                --bs-gutter-x: 8px;
                --bs-gutter-y: 8px;
            }
            .value-ribbon .col {
                flex: 0 0 50%;
                max-width: 50%;
            }
            .value-ribbon .col + .col .value-item {
                border-left: 0;
            }
            .value-item {
                min-height: 44px;
                font-size: 11px;
                gap: 8px;
                padding: 6px 8px;
                background: #f8fafc;
                border: 1px solid #edf2f7;
                border-radius: 8px;
            }
            .value-item .icon {
                width: 18px;
                height: 18px;
                flex-shrink: 0;
            }

            .section-pad {
                padding: 24px 16px 12px;
            }
            .about-copy {
                padding: 0 0 8px;
            }
            .section-heading {
                font-size: 22px;
            }
            .about-photo-frame {
                margin: 10px 0;
            }
            .about-photo {
                height: 200px;
                border-radius: 12px;
            }
            .about-description {
                font-size: 13px;
                line-height: 1.5;
            }
            .school-stats {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
                padding: 8px 0 0;
            }
            .stat-item {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 10px 12px;
                gap: 10px;
            }
            .stat-value {
                font-size: 18px;
            }
            .stat-label {
                font-size: 11.5px;
            }

            .cards-section {
                padding: 12px 16px;
            }
            .cards-section .row {
                --bs-gutter-y: 16px;
            }
            .feature-card {
                flex-direction: column;
                min-height: auto;
                padding: 16px;
                gap: 14px;
                border-radius: 16px;
            }
            .feature-photo {
                width: 100%;
                min-width: 100%;
                height: 140px;
                min-height: 140px;
                border-radius: 10px;
            }
            .feature-photo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .feature-title {
                font-size: 18px;
            }
            .feature-accent {
                width: 28px;
                height: 2.5px;
                margin: 4px 0 8px;
            }
            .feature-description {
                font-size: 12.5px;
                line-height: 1.45;
                margin-bottom: 12px;
            }
            .mini-grid {
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 6px;
            }
            .academic-grid .mini-item {
                min-height: 64px;
                font-size: 9.5px;
                padding: 6px 3px;
            }
            .academic-grid .mini-icon svg {
                width: 20px;
                height: 20px;
            }
            .activity-grid {
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 6px;
            }
            .activity-grid .mini-item {
                min-height: 52px;
                font-size: 9px;
                padding: 5px 2px;
            }
            .activity-grid .mini-icon svg {
                width: 17px;
                height: 17px;
            }

            .campus-section {
                padding: 12px 16px;
            }
            .nps-campus-showcase {
                padding: 16px 14px;
                border-radius: 18px;
            }
            .nps-campus-main-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .nps-campus-left-card {
                padding: 18px 14px;
                border-radius: 14px;
                text-align: center;
                align-items: center;
            }
            .nps-campus-heading {
                font-size: 24px;
            }
            .nps-campus-heading-underline {
                margin: 0 auto 10px;
            }
            .nps-campus-benefits-list {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
                gap: 8px;
                margin-bottom: 10px;
            }
            .nps-campus-benefit-row {
                justify-content: center;
                font-size: 12px;
            }
            .nps-campus-middle-card {
                padding: 6px;
                border-radius: 14px;
            }
            .nps-campus-map-photo {
                min-height: 220px;
                max-height: 320px;
                height: auto;
                object-fit: contain;
            }
            .nps-campus-right-card {
                border-radius: 14px;
                max-width: 100%;
                margin: 0;
            }
            .nps-facilities-list {
                max-height: none;
                overflow: visible;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 6px;
                padding: 10px;
            }
            .nps-facility-item {
                padding: 5px 7px;
                background: #f8fafc;
                border: 1px solid #f1f5f9;
                border-radius: 8px;
            }

            .bottom-section {
                padding: 16px 16px 24px;
            }
            .bottom-section > .row {
                display: flex;
                flex-direction: column;
                gap: 16px;
                margin: 0;
            }
            .bottom-section > .row > .col-lg-8,
            .bottom-section > .row > .col-lg-4 {
                width: 100%;
                max-width: 100%;
                padding: 0;
            }
            .left-column {
                gap: 14px;
            }
            .content-panel {
                padding: 16px;
                border-radius: 14px;
            }
            .panel-title {
                font-size: 17px;
            }
            .event-grid {
                grid-auto-columns: minmax(140px, 46%);
                gap: 10px;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
            }
            .event-grid > article {
                scroll-snap-align: start;
            }
            .lower-panels {
                --bs-gutter-y: 14px;
            }
            .process-row {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }
            .process-arrow {
                display: none;
            }
            .process-step {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 10px 8px;
                font-size: 11.5px;
            }
            .process-icon {
                width: 34px;
                height: 34px;
                margin-bottom: 6px;
            }
            .testimonial {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .quote-text {
                font-size: 12.5px;
                line-height: 1.45;
            }
            .parent-photo {
                width: 58px;
                height: 58px;
                flex: 0 0 58px;
            }

            .enquiry-panel {
                min-height: auto;
                padding: 20px 16px;
                border-radius: 16px;
            }
            .enquiry-title {
                font-size: 19px;
            }
            .enquiry-intro {
                font-size: 12px;
                margin: 4px 0 12px;
            }
            .enquiry-form {
                gap: 9px;
            }
            .enquiry-input {
                min-height: 44px;
                font-size: 16px !important;
                padding: 10px 12px 10px 38px;
                border-radius: 10px;
            }
            .input-icon {
                top: 22px;
                left: 12px;
                width: 16px;
                height: 16px;
            }
            .submit-button {
                min-height: 44px;
                font-size: 14px;
                border-radius: 10px;
            }
            .whatsapp-link {
                min-height: 42px;
                font-size: 13px;
                border-radius: 10px;
            }

            .video-dialog, .map-dialog {
                width: 95%;
                padding: 8px;
            }
            .video-close {
                top: 6px;
                right: 6px;
                width: 32px;
                height: 32px;
                z-index: 20;
            }
            .map-modal-close {
                top: 6px;
                right: 6px;
                width: 34px;
                height: 34px;
                font-size: 18px;
            }

            .footer-bg {
                padding: 22px 0 18px;
            }
            .footer-brand {
                justify-content: flex-start;
            }
            .footer-details {
                flex-direction: column;
                align-items: flex-start;
                gap: 9px;
            }
            .footer-item {
                font-size: 12px;
                word-break: break-word;
            }
        }

        @media (max-width: 575.98px) {
            .section-heading {
                font-size: 20px;
            }
            .about-photo {
                height: 180px;
            }
            .mini-grid,
            .activity-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 6px;
            }
            .academic-grid .mini-item {
                min-height: 60px;
                font-size: 10px;
                padding: 6px 4px;
            }
            .activity-grid .mini-item {
                min-height: 50px;
                font-size: 9.5px;
                padding: 5px 4px;
            }
            .nps-facilities-list {
                grid-template-columns: 1fr;
            }
            .event-grid {
                grid-auto-columns: minmax(130px, 60%);
            }
            .testimonial {
                flex-direction: column-reverse;
                text-align: center;
                gap: 10px;
            }
            .quote-mark {
                margin: 0 auto;
            }
            .parent-photo {
                margin: 0 auto;
            }
        }

        @media (max-width: 380px) {
            .hero-headline {
                font-size: 24px;
            }
            .value-ribbon .col {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .school-stats {
                grid-template-columns: 1fr;
            }
            .process-row {
                grid-template-columns: 1fr;
            }
            .mini-grid,
            .activity-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('website/header.css') }}">
</head>
<body>
    <div class="page-shell">
        @include('frontend.layout.header')

        <main>
            <section class="hero-section">
                <div class="container position-relative" style="z-index: 2;">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-xl-7">
                            <div class="hero-badge-pill">
                                <span>DISCOVER • LEARN • CREATE • LEAD</span>
                            </div>

                            <h1 class="hero-headline">
                                Admissions Open <span class="hero-gold-accent">for 2027 – 28</span>
                            </h1>

                            <div class="grade-pill-wrap">
                                <span class="grade-pill">
                                    <i data-lucide="graduation-cap" style="width:16px;height:16px;"></i> Nursery to Grade 9
                                </span>
                            </div>

                            <p class="hero-lead">
                                A Premier K-9 School for Holistic, Future-Ready Learning. Fostering academic excellence, character, and lifelong leadership in a state-of-the-art campus.
                            </p>

                            <div class="quick-nav-pills">
                                <a href="#admission-enquiry-box" class="quick-pill-btn quick-pill-gold">
                                    Enquire Now <i data-lucide="arrow-right" style="width:16px;height:16px;"></i>
                                </a>
                                <button type="button" class="quick-pill-btn quick-pill-video" id="openVideo">
                                    <span class="play-circle"><i data-lucide="play" style="width:11px;height:11px;"></i></span>
                                    Watch School Video
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="value-ribbon" aria-label="School values">
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-6 g-2 align-items-center">
                    <div class="col"><div class="value-item"><i data-lucide="graduation-cap" class="icon icon-lg"></i><span>Academic<br>Excellence</span></div></div>
                    <div class="col"><div class="value-item"><i data-lucide="sprout" class="icon icon-lg"></i><span>Holistic<br>Development</span></div></div>
                    <div class="col"><div class="value-item"><i data-lucide="users" class="icon icon-lg"></i><span>Experienced &<br>Caring Faculty</span></div></div>
                    <div class="col"><div class="value-item"><i data-lucide="school" class="icon icon-lg"></i><span>Safe &<br>Inclusive Campus</span></div></div>
                    <div class="col"><div class="value-item"><i data-lucide="shield-check" class="icon icon-lg"></i><span>Values &<br>Life Skills</span></div></div>
                    <div class="col"><div class="value-item"><i data-lucide="trophy" class="icon icon-lg"></i><span>Leadership &<br>Global Outlook</span></div></div>
                </div>
            </section>

            <section id="about-section" class="section-pad">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="about-copy">
                            <div class="section-eyebrow">About Us</div>
                            <h2 class="section-heading">NPS Kempegowda Layout</h2>
                            <div class="heading-rule"></div>
                            <p class="about-description">Part of the renowned National Public School network established in 1959 under the pioneering guidance of Founder Chairman Dr. K. P. Gopalkrishna and Senior Principal Dr. Santhamma Gopalkrishna. Established in collaboration with Chaitra Education Trust in Kempegowda Layout 7th Block, Bengaluru, NPS KGL delivers world-class education rooted in academic excellence, discipline, and ethical values. Within our child-centric environment, we empower students to discover their strengths, think independently, and grow into confident, compassionate global citizens.</p>
                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="about-photo-frame">
                            <img src="{{ asset('images/National Public School Campus Field.png') }}" alt="Campus Building" class="about-photo">
                        </div>
                    </div>
                    
                </div>
            </section>

            <section id="academic-cards" class="section-pad cards-section">
                <div class="row g-2">
                    <div class="col-md-6">
                        <article class="feature-card">
                            <div class="feature-photo"><img src="{{ asset('images/Student Exploring Science with a Microscope.png') }}" alt="Student with Microscope"></div>
                            <div class="feature-content">
                                <div class="feature-header">
                                    <h3 class="feature-title">Academic Excellence</h3>
                                    <div class="feature-accent"></div>
                                    <p class="feature-description">Rooted in the acclaimed NPS curriculum and aligned with CBSE, our pedagogy champions "learning by doing" over rote memorization—fostering conceptual depth, critical inquiry, and 21st-century competencies.</p>
                                </div>
                                <div class="mini-grid academic-grid">
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                                        </span>
                                        <span>Conceptual<br>Learning</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10 2v5.5L4.4 18.2A2 2 0 0 0 6.1 21h11.8a2 2 0 0 0 1.7-2.8L14 7.5V2"/><path d="M8.5 2h7"/><path d="M7 15h10"/></svg>
                                        </span>
                                        <span>STEM<br>Education</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M2 20h20"/></svg>
                                        </span>
                                        <span>Digital<br>Learning</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="14" width="3" height="7" rx="0.5"/><rect x="9.5" y="10" width="3" height="11" rx="0.5"/><rect x="15" y="6" width="3" height="15" rx="0.5"/><path d="M4 11l5.5-5.5 4 4 6.5-6.5"/><path d="M16 3h4v4"/></svg>
                                        </span>
                                        <span>Assessment<br>& Tracking</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                                        </span>
                                        <span>Values &<br>Citizenship</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6">
                        <article class="feature-card">
                            <div class="feature-photo"><img src="{{ asset('images/Focused Youth Basketball Dribble.png') }}" alt="Basketball Player"></div>
                            <div class="feature-content">
                                <div class="feature-header">
                                    <h3 class="feature-title">Extra-Curricular Activities</h3>
                                    <div class="feature-accent"></div>
                                    <p class="feature-description">A vibrant co-scholastic ecosystem spanning sports championships, performing arts, robotics, student-led clubs, and leadership initiatives that build character, creativity, and teamwork.</p>
                                </div>
                                <div class="mini-grid activity-grid">
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                                        </span>
                                        <span>Music</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="3" r="2"/><path d="M6.5 8c2-1.2 3.8-1.5 5.5-.5 1.5.8 2.5 1.8 4.5 1.8"/><path d="M12 6.5v6.5l-3.5 8"/><path d="M12 13l4.5-2.5 3 4.5"/></svg>
                                        </span>
                                        <span>Dance</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.9 0 1.6-.7 1.6-1.6 0-.4-.2-.8-.4-1.1-.3-.3-.4-.7-.4-1.1 0-.9.7-1.6 1.6-1.6H16c3.3 0 6-2.7 6-6 0-5.5-4.5-8.6-10-8.6z"/><circle cx="7.5" cy="10.5" r="1" fill="currentColor"/><circle cx="12" cy="6.5" r="1" fill="currentColor"/><circle cx="16.5" cy="10.5" r="1" fill="currentColor"/><circle cx="10.5" cy="14.5" r="1" fill="currentColor"/></svg>
                                        </span>
                                        <span>Visual Arts</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M2 9.5C2 5.5 5.5 3 9.5 3S17 5.5 17 9.5 13.5 16 9.5 16 2 13.5 2 9.5z"/><circle cx="6.5" cy="8.5" r=".75" fill="currentColor"/><circle cx="12.5" cy="8.5" r=".75" fill="currentColor"/><path d="M6.5 12c1 1.2 4 1.2 5 0"/><path d="M16 6.5c2 .7 4 2.5 4 5s-2 5-5 5.5"/><circle cx="18" cy="10" r=".75" fill="currentColor"/><path d="M16.5 13.5c.8-.5 1.8-.5 2 0"/></svg>
                                        </span>
                                        <span>Drama</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="4.5" r="2.2"/><path d="M9 8h6"/><path d="M10 8c-.8 3.5-1.8 5.5-2.5 8h9c-.7-2.5-1.7-4.5-2.5-8"/><path d="M7 18.5h10"/><path d="M5.5 21.5h13"/></svg>
                                        </span>
                                        <span>Chess</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="16.5" cy="4" r="2"/><path d="M6 21l3.5-6.5 3 2.5 4-5.5"/><path d="M12.5 11l2.5-4-4.5-2-3 4.5"/><path d="M5.5 13.5l3.5 2"/></svg>
                                        </span>
                                        <span>Sports</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon eco-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 4 13C4 7 11 3 11 3s7 4 7 10a7 7 0 0 1-7 7z" fill="#22c55e" fill-opacity="0.15"/><path d="M11 20v-9"/><path d="M11 14c2.5-1 4-3 5-5"/></svg>
                                        </span>
                                        <span>Eco-Clubs</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/><line x1="14" y1="4" x2="10" y2="20"/></svg>
                                        </span>
                                        <span>Coding Club</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="22"/><line x1="8" y1="22" x2="16" y2="22"/></svg>
                                        </span>
                                        <span>Public<br>Speaking</span>
                                    </div>
                                    <div class="mini-item">
                                        <span class="mini-icon">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="3"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/><circle cx="5" cy="8.5" r="2"/><path d="M2 19.5v-1a3 3 0 0 1 3-3h.5"/><circle cx="19" cy="8.5" r="2"/><path d="M22 19.5v-1a3 3 0 0 0-3-3h-.5"/></svg>
                                        </span>
                                        <span>Leadership<br>Programmes</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section id="campus-section" class="section-pad campus-section">
                <div class="nps-campus-showcase">
                    <!-- 3-Column Main Grid -->
                    <div class="nps-campus-main-grid">
                        <!-- Left Card: Deep Navy Branding & Benefits -->
                        <div class="nps-campus-left-card">
                            <div>
                                <!-- Classical School Crest Logo -->
                               
                                <div class="nps-campus-kicker">&mdash; OUR CAMPUS &mdash;</div>
                                <h2 class="nps-campus-heading">Campus <span>Layout</span></h2>
                                <div class="nps-campus-heading-underline"></div>
                                <p class="nps-campus-intro">A safe, green and well-planned campus designed to enable focused learning, active play and holistic development.</p>

                                <div class="nps-campus-benefits-list">
                                    <div class="nps-campus-benefit-row">
                                        <span class="nps-campus-benefit-circle">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 4 13C4 7 11 3 11 3s7 4 7 10a7 7 0 0 1-7 7z"/><path d="M11 20v-9"/></svg>
                                        </span>
                                        <span>Spacious &amp; Green Campus</span>
                                    </div>
                                    <div class="nps-campus-benefit-row">
                                        <span class="nps-campus-benefit-circle">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                        </span>
                                        <span>Safe &amp; Secure Environment</span>
                                    </div>
                                    <div class="nps-campus-benefit-row">
                                        <span class="nps-campus-benefit-circle">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        </span>
                                        <span>Child-Friendly Infrastructure</span>
                                    </div>
                                    <div class="nps-campus-benefit-row">
                                        <span class="nps-campus-benefit-circle">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="4" r="2"/><path d="m5 9 7 2 7-2"/><path d="m8 15 4 6 4-6"/><path d="M12 11v6"/></svg>
                                        </span>
                                        <span>Inclusive &amp; Accessible Spaces</span>
                                    </div>
                                </div>
                            </div>

                           
                        </div>

                        <!-- Middle Card: 3D Aerial Campus Map -->
                        <div class="nps-campus-middle-card">
                            <a href="{{ asset('images/NPS Kempegowda Layout Campus Map.png') }}" id="openCampusMap" class="nps-campus-map-anchor" title="Click to view enlarged 3D Campus Layout">
                                <img src="{{ asset('images/NPS Kempegowda Layout Campus Map.png') }}" alt="National Public School Kempegowda Layout - 3D Isometric Aerial Campus Map" class="nps-campus-map-photo">
                               
                            </a>
                        </div>

                        <!-- Right Card: Facilities Index (1 to 12) -->
                        <div class="nps-campus-right-card">
                            <div class="nps-facilities-header">
                                <svg class="nps-facilities-header-icon" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                <span>Facilities Index</span>
                            </div>

                            <div class="nps-facilities-list">
                                <!-- Pin 1 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-1">1</span>
                                    
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Main Entrance &amp; Security</div>
                                        <div class="nps-facility-sub">(North-East Gate)</div>
                                    </div>
                                </div>

                                <!-- Pin 2 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-2">2</span>
                                    
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Reception &amp; Administration</div>
                                        <div class="nps-facility-sub">(Enquiry, Admissions &amp; Front Office)</div>
                                    </div>
                                </div>

                                <!-- Pin 3 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-3">3</span>
                                   
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Administration Block</div>
                                        <div class="nps-facility-sub">(Principal, Admin &amp; Staff Offices)</div>
                                    </div>
                                </div>

                                <!-- Pin 4 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-4">4</span>
                                   
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Central Courtyard</div>
                                        <div class="nps-facility-sub">(Green Courtyard &amp; Activity Space)</div>
                                    </div>
                                </div>

                                <!-- Pin 5 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-5">5</span>
                                    
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Montessori &amp; Kindergarten Wing</div>
                                        <div class="nps-facility-sub">(Early Years)</div>
                                    </div>
                                </div>

                                <!-- Pin 6 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-6">6</span>
                                    
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Library &amp; Media Centre</div>
                                        <div class="nps-facility-sub">(Library, Reading &amp; Digital Resources)</div>
                                    </div>
                                </div>

                                <!-- Pin 7 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-7">7</span>
                                    
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Science, Computer &amp; Mathematics Labs</div>
                                        <div class="nps-facility-sub">(STEM Labs)</div>
                                    </div>
                                </div>

                                <!-- Pin 8 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-8">8</span>
                                   
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Sports Complex</div>
                                        <div class="nps-facility-sub">(Basketball / Tennis Courts)</div>
                                    </div>
                                </div>

                                <!-- Pin 9 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-9">9</span>
                                    
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Athletics Track (200 m)</div>
                                        <div class="nps-facility-sub">(All-weather Synthetic Track)</div>
                                    </div>
                                </div>

                                <!-- Pin 10 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-10">10</span>
                                  
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Sports Ground</div>
                                        <div class="nps-facility-sub">(Football / Cricket / Sports)</div>
                                    </div>
                                </div>

                                <!-- Pin 11 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-11">11</span>
                                   
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Parking Area</div>
                                        <div class="nps-facility-sub">(Visitor &amp; Staff Parking)</div>
                                    </div>
                                </div>

                                <!-- Pin 12 -->
                                <div class="nps-facility-item">
                                    <span class="nps-facility-badge badge-col-12">12</span>
                                   
                                    <div class="nps-facility-text">
                                        <div class="nps-facility-name">Health Centre &amp; Utilities</div>
                                        <div class="nps-facility-sub">(Infirmary, Resident Nurse &amp; Facility Support)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </section>

            <section id="events-section" class="section-pad bottom-section">
                <div class="row g-3 align-items-stretch">
                    <div class="col-lg-8">
                        <div class="left-column">
                            <section class="content-panel">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h3 class="panel-title">Events & Campus Life</h3>
                                    <div class="event-controls">
                                        <button type="button" class="event-control" data-scroll="-160" aria-label="Scroll events left"><i data-lucide="chevron-left" class="icon icon-sm"></i></button>
                                        <button type="button" class="event-control" data-scroll="160" aria-label="Scroll events right"><i data-lucide="chevron-right" class="icon icon-sm"></i></button>
                                    </div>
                                </div>
                                <div id="eventsScroll" class="event-grid">
                                    <article><div class="event-image-frame"><img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0113.jpg') }}" alt="Annual Day" class="event-image"></div><h4 class="event-title">Annual Day (AURA)</h4><p class="event-description">A grand celebration of performing arts, music, dance, and student talent.</p></article>
                                    <article><div class="event-image-frame"><img src="{{ asset('images/NPS PFWEB/DSC_9445.JPG') }}" alt="Sports Meet" class="event-image"></div><h4 class="event-title">Sports Meet (SPARDHA)</h4><p class="event-description">Building athletic agility, discipline, teamwork, and sportsmanship.</p></article>
                                    <article><div class="event-image-frame"><img src="{{ asset('images/NPS PFWEB/IMG_0447.jpg') }}" alt="Science Fair" class="event-image"></div><h4 class="event-title">Science Fair (ANVESHANA)</h4><p class="event-description">Showcasing student-led STEM experiments, prototypes, and scientific inquiry.</p></article>
                                    <article><div class="event-image-frame"><img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0013.jpg') }}" alt="Environment Week" class="event-image"></div><h4 class="event-title">Environment Week</h4><p class="event-description">Eco-initiatives, green campaigns, and sustainability for a cleaner tomorrow.</p></article>
                                    <article><div class="event-image-frame"><img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0125.jpg') }}" alt="Cultural Celebrations" class="event-image"></div><h4 class="event-title">National &amp; Cultural Celebrations</h4><p class="event-description">Celebrating unity, heritage, and values through Kannada Rajyotsava &amp; festive assemblies.</p></article>
                                </div>
                            </section>

                            <div class="row g-3 lower-panels">
                                <div class="col-md-6">
                                    <section class="content-panel h-100">
                                        <h3 class="panel-title mb-3">Admission Process</h3>
                                        <div class="process-row">
                                            <div class="process-step"><span class="process-icon"><i data-lucide="file-text" class="icon"></i></span>Register<br>Online/Offline</div>
                                            <i data-lucide="arrow-right" class="icon icon-sm process-arrow"></i>
                                            <div class="process-step"><span class="process-icon"><i data-lucide="file-check" class="icon"></i></span>Document<br>Submission</div>
                                            <i data-lucide="arrow-right" class="icon icon-sm process-arrow"></i>
                                            <div class="process-step"><span class="process-icon"><i data-lucide="calendar" class="icon"></i></span>School<br>Interaction</div>
                                            <i data-lucide="arrow-right" class="icon icon-sm process-arrow"></i>
                                            <div class="process-step"><span class="process-icon is-complete"><i data-lucide="check-circle" class="icon"></i></span>Admission<br>Confirmation</div>
                                        </div>
                                    </section>
                                </div>
                                <div class="col-md-6">
                                    <section class="content-panel h-100 d-flex flex-column justify-content-between">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <h3 class="panel-title">Hear from Our Parents</h3>
                                            <div class="event-controls">
                                                <button type="button" class="event-control" id="prevTestimonial" aria-label="Previous testimonial"><i data-lucide="chevron-left" class="icon icon-sm"></i></button>
                                                <button type="button" class="event-control" id="nextTestimonial" aria-label="Next testimonial"><i data-lucide="chevron-right" class="icon icon-sm"></i></button>
                                            </div>
                                        </div>
                                        <div class="testimonial-slider-container" id="testimonialSliderContainer" aria-label="Parent Testimonials Carousel">
                                            <div class="testimonial-track" id="testimonialTrack">
                                                <div class="testimonial-slide">
                                                    <div class="testimonial">
                                                        <div class="testimonial-copy">
                                                            <div class="quote-mark">“</div>
                                                            <p class="quote-text">Since joining NPS, Kempegowda Layout, Rishikesh has grown more confident, responsible, and expressive. We truly appreciate the school’s focus on leadership, values, and overall development.</p>
                                                            <div class="quote-author">— Parent, Grade 5</div>
                                                        </div>
                                                        <div class="parent-photo"><img src="{{ asset('images/parent-student-portrait.jpg') }}" alt="Parent and Student" onerror="this.src='{{ asset('images/parent-student-portrait.png') }}'"></div>
                                                    </div>
                                                </div>
                                                <div class="testimonial-slide">
                                                    <div class="testimonial">
                                                        <div class="testimonial-copy">
                                                            <div class="quote-mark">“</div>
                                                            <p class="quote-text">As parents of Parthiv, we are delighted with his experience at NPS, Kempegowda Layout. The caring teachers, personal attention, and positive environment have helped him grow in confidence and enthusiasm for learning.</p>
                                                            <div class="quote-author">— Mr. Shrikanth & Mrs. Anusha, Parents of Parthiv</div>
                                                        </div>
                                                        <div class="parent-photo"><img src="{{ asset('images/parent-student.png') }}" alt="Parent and Student" onerror="this.src='{{ asset('images/parent-student-portrait.jpg') }}'"></div>
                                                    </div>
                                                </div>
                                                <div class="testimonial-slide">
                                                    <div class="testimonial">
                                                        <div class="testimonial-copy">
                                                            <div class="quote-mark">“</div>
                                                            <p class="quote-text">We always wished our son Raghav to study at NPS, and that dream has come true at NPS Kempegowda Layout. We are extremely happy and grateful to see him grow and learn in such a wonderful environment.</p>
                                                            <div class="quote-author">— Mr. Praveen & Mrs. Anupama, Parents of Raghav</div>
                                                        </div>
                                                        <div class="parent-photo"><img src="{{ asset('images/parent-student-portrait.jpg') }}" alt="Parent and Student" onerror="this.src='{{ asset('images/parent-student-portrait.png') }}'"></div>
                                                    </div>
                                                </div>
                                                <div class="testimonial-slide">
                                                    <div class="testimonial">
                                                        <div class="testimonial-copy">
                                                            <div class="quote-mark">“</div>
                                                            <p class="quote-text">I wanted to sincerely thank all the teachers for their amazing impact on Aadhira. Her communication, logical thinking, and active participation in class have blossomed under their warm encouragement.</p>
                                                            <div class="quote-author">— Aadhira's Mother, Parent</div>
                                                        </div>
                                                        <div class="parent-photo"><img src="{{ asset('images/parent-student.png') }}" alt="Parent and Student" onerror="this.src='{{ asset('images/parent-student-portrait.jpg') }}'"></div>
                                                    </div>
                                                </div>
                                                <div class="testimonial-slide">
                                                    <div class="testimonial">
                                                        <div class="testimonial-copy">
                                                            <div class="quote-mark">“</div>
                                                            <p class="quote-text">Thank you for nurturing our child's love for learning. The dedication of teachers is commendable—they develop both strong academic foundations, social interaction, and joyful confidence.</p>
                                                            <div class="quote-author">— Parent of Dhrithi, Grade 3</div>
                                                        </div>
                                                        <div class="parent-photo"><img src="{{ asset('images/parent-student-portrait.jpg') }}" alt="Parent and Student" onerror="this.src='{{ asset('images/parent-student-portrait.png') }}'"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="testimonial-dots" id="testimonialDots"></div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 enquiry-column" id="admission-enquiry-box">
                        <section class="enquiry-panel">
                            <div>
                                <div class="enquiry-heading"><i data-lucide="graduation-cap" class="icon icon-lg"></i><h3 class="enquiry-title">Admission Enquiry</h3></div>
                                <p class="enquiry-intro">Take the first step towards an enriching learning journey at NPS Kempegowda Layout.</p>
                                <form id="enquiryForm" class="enquiry-form needs-validation" novalidate>
                                    @csrf
                                    <div class="input-wrap">
                                        <i data-lucide="user" class="input-icon" aria-hidden="true"></i>
                                        <input type="text" name="parent_name" required minlength="2" maxlength="60" pattern="[\p{L} ]{2,60}" autocomplete="name" placeholder="Parent's Name *" class="form-control enquiry-input" aria-label="Parent's Name" aria-describedby="nameFeedback">
                                        <div class="invalid-feedback" id="nameFeedback">Enter a name using letters and spaces only (2 to 60 characters).</div>
                                    </div>
                                    <div class="input-wrap">
                                        <i data-lucide="phone" class="input-icon" aria-hidden="true"></i>
                                        <input type="tel" name="mobile_number" required pattern="[6-9][0-9]{9}" maxlength="10" inputmode="numeric" autocomplete="tel" placeholder="Mobile Number *" class="form-control enquiry-input" aria-label="Mobile Number" aria-describedby="mobileFeedback">
                                        <div class="invalid-feedback" id="mobileFeedback">Enter 10 digits starting with 6, 7, 8, or 9.</div>
                                    </div>
                                    <div class="input-wrap">
                                        <i data-lucide="mail" class="input-icon" aria-hidden="true"></i>
                                        <input type="email" name="email" pattern="[^@]+@[^@]+\.[^@]{2,}" autocomplete="email" placeholder="Email (Optional)" class="form-control enquiry-input" aria-label="Email (Optional)" aria-describedby="emailFeedback">
                                        <div class="invalid-feedback" id="emailFeedback">Enter a valid email address, or leave this field empty.</div>
                                    </div>
                                    <div class="input-wrap select-wrap">
                                        <i data-lucide="book" class="input-icon" aria-hidden="true"></i>
                                        <select name="grade" required class="form-select enquiry-input enquiry-select" aria-label="Grade Applying For" aria-describedby="gradeFeedback">
                                            <option value="" disabled selected>Grade Applying For *</option>
                                            <option>Nursery</option><option>LKG</option><option>UKG</option>
                                            <option>Grade 1</option><option>Grade 2</option><option>Grade 3</option>
                                            <option>Grade 4</option><option>Grade 5</option><option>Grade 6</option>
                                            <option>Grade 7</option><option>Grade 8</option><option>Grade 9</option>
                                        </select>
                                        <div class="invalid-feedback" id="gradeFeedback">Choose the grade the student is applying for.</div>
                                    </div>
                                    <button type="submit" class="submit-button">Submit Enquiry <i data-lucide="arrow-right" class="icon icon-sm"></i></button>
                                </form>
                            </div>
                            <a href="https://wa.me/919964827788" target="_blank" rel="noopener noreferrer" class="whatsapp-link"><i data-lucide="message-circle" class="icon icon-sm"></i>Enquire on WhatsApp</a>
                        </section>
                    </div>
                </div>
            </section>
        </main>

        @include('frontend.layout.footer')
    </div>

    <div id="videoModal" class="video-modal" role="dialog" aria-modal="true" aria-label="School Video Tour">
        <div class="video-dialog">
            <button type="button" class="video-close" id="closeVideo" aria-label="Close video"><i data-lucide="x" class="icon"></i></button>
            <div class="video-frame"><iframe id="videoIframe" src="" title="School Video Tour" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
        </div>
    </div>

    <div id="campusMapModal" class="map-modal" role="dialog" aria-modal="true" aria-label="Campus Layout Map">
        <div class="map-dialog">
            <button type="button" class="map-modal-close" id="closeCampusMap" aria-label="Close campus map">&times;</button>
            <img src="{{ asset('images/nps-campus-layout-hd.jpg') }}" alt="National Public School Campus Layout and Facilities Map" class="map-dialog-img">
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js"></script>
    <script>
        lucide.createIcons();

        // Testimonials Auto-Scroller
        const testimonialTrack = document.getElementById('testimonialTrack');
        const testimonialSlides = document.querySelectorAll('.testimonial-slide');
        const prevTestimonialBtn = document.getElementById('prevTestimonial');
        const nextTestimonialBtn = document.getElementById('nextTestimonial');
        const testimonialDots = document.getElementById('testimonialDots');
        const testimonialContainer = document.getElementById('testimonialSliderContainer');

        if (testimonialTrack && testimonialSlides.length > 1) {
            let currentTestimonialIndex = 0;
            const totalTestimonials = testimonialSlides.length;
            const scrollDuration = 4500;
            let autoScrollInterval = null;

            if (testimonialDots) {
                testimonialDots.innerHTML = '';
                testimonialSlides.forEach((_, index) => {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = `testimonial-dot ${index === 0 ? 'is-active' : ''}`;
                    dot.setAttribute('aria-label', `Testimonial slide ${index + 1}`);
                    dot.addEventListener('click', () => {
                        goToTestimonial(index);
                        restartAutoScroll();
                    });
                    testimonialDots.appendChild(dot);
                });
            }

            const updateDots = () => {
                if (!testimonialDots) return;
                const dots = testimonialDots.querySelectorAll('.testimonial-dot');
                dots.forEach((dot, index) => {
                    dot.classList.toggle('is-active', index === currentTestimonialIndex);
                });
            };

            const goToTestimonial = (index) => {
                if (index < 0) {
                    currentTestimonialIndex = totalTestimonials - 1;
                } else if (index >= totalTestimonials) {
                    currentTestimonialIndex = 0;
                } else {
                    currentTestimonialIndex = index;
                }
                testimonialTrack.style.transform = `translateX(-${currentTestimonialIndex * 100}%)`;
                updateDots();
            };

            const nextTestimonial = () => goToTestimonial(currentTestimonialIndex + 1);
            const prevTestimonial = () => goToTestimonial(currentTestimonialIndex - 1);

            if (nextTestimonialBtn) {
                nextTestimonialBtn.addEventListener('click', () => {
                    nextTestimonial();
                    restartAutoScroll();
                });
            }

            if (prevTestimonialBtn) {
                prevTestimonialBtn.addEventListener('click', () => {
                    prevTestimonial();
                    restartAutoScroll();
                });
            }

            const startAutoScroll = () => {
                if (!autoScrollInterval) {
                    autoScrollInterval = setInterval(nextTestimonial, scrollDuration);
                }
            };

            const stopAutoScroll = () => {
                if (autoScrollInterval) {
                    clearInterval(autoScrollInterval);
                    autoScrollInterval = null;
                }
            };

            const restartAutoScroll = () => {
                stopAutoScroll();
                startAutoScroll();
            };

            if (testimonialContainer) {
                testimonialContainer.addEventListener('mouseenter', stopAutoScroll);
                testimonialContainer.addEventListener('mouseleave', startAutoScroll);

                let touchStartX = 0;
                let touchEndX = 0;

                testimonialContainer.addEventListener('touchstart', (e) => {
                    stopAutoScroll();
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                testimonialContainer.addEventListener('touchend', (e) => {
                    touchEndX = e.changedTouches[0].screenX;
                    const diff = touchStartX - touchEndX;
                    if (Math.abs(diff) > 40) {
                        if (diff > 0) {
                            nextTestimonial();
                        } else {
                            prevTestimonial();
                        }
                    }
                    startAutoScroll();
                }, { passive: true });
            }

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    stopAutoScroll();
                } else {
                    startAutoScroll();
                }
            });

            startAutoScroll();
        }

        const videoModal = document.getElementById('videoModal');
        const videoIframe = document.getElementById('videoIframe');

        document.querySelectorAll('[data-scroll]').forEach((button) => {
            button.addEventListener('click', () => {
                document.getElementById('eventsScroll').scrollBy({
                    left: Number(button.dataset.scroll),
                    behavior: 'smooth',
                });
            });
        });

        document.getElementById('openVideo').addEventListener('click', () => {
            videoIframe.src = 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?autoplay=1';
            videoModal.classList.add('is-open');
        });

        const closeVideo = () => {
            videoIframe.src = '';
            videoModal.classList.remove('is-open');
        };

        document.getElementById('closeVideo').addEventListener('click', closeVideo);
        videoModal.addEventListener('click', (event) => {
            if (event.target === videoModal) {
                closeVideo();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && videoModal.classList.contains('is-open')) {
                closeVideo();
            }
        });

        const campusMapModal = document.getElementById('campusMapModal');
        const openCampusMap = document.getElementById('openCampusMap');
        const closeCampusMap = document.getElementById('closeCampusMap');

        if (openCampusMap && campusMapModal) {
            openCampusMap.addEventListener('click', (event) => {
                event.preventDefault();
                campusMapModal.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            });
        }

        const closeCampusModal = () => {
            if (campusMapModal) {
                campusMapModal.classList.remove('is-open');
                document.body.style.overflow = '';
            }
        };

        if (closeCampusMap) {
            closeCampusMap.addEventListener('click', closeCampusModal);
        }
        if (campusMapModal) {
            campusMapModal.addEventListener('click', (event) => {
                if (event.target === campusMapModal) {
                    closeCampusModal();
                }
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && campusMapModal.classList.contains('is-open')) {
                    closeCampusModal();
                }
            });
        }

        const enquiryForm = document.getElementById('enquiryForm');
        const parentNameInput = enquiryForm.elements.namedItem('parent_name');
        const mobileInput = enquiryForm.elements.namedItem('mobile_number');

        parentNameInput.addEventListener('input', () => {
            const cursor = parentNameInput.selectionStart;
            const cleanName = parentNameInput.value.replace(/[^\p{L} ]/gu, '').slice(0, 60);
            if (parentNameInput.value !== cleanName) {
                parentNameInput.value = cleanName;
                parentNameInput.setSelectionRange(Math.min(cursor, cleanName.length), Math.min(cursor, cleanName.length));
            }
        });
        parentNameInput.addEventListener('blur', () => {
            parentNameInput.value = parentNameInput.value.trim().replace(/\s+/g, ' ');
        });
        mobileInput.addEventListener('input', () => {
            mobileInput.value = mobileInput.value.replace(/\D/g, '').slice(0, 10);
        });

        enquiryForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            enquiryForm.classList.add('was-validated');

            if (!enquiryForm.checkValidity()) {
                enquiryForm.querySelector(':invalid')?.focus();
                return;
            }

            const submitBtn = enquiryForm.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            if (submitBtn) {
                submitBtn.disabled = true;
            }

            try {
                const formData = new FormData(enquiryForm);
                const response = await fetch('{{ route("frontend.enquiry.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(data.message || 'Something went wrong. Please try again.');
                }

                if (window.Swal) {
                    await Swal.fire({
                        title: 'Enquiry Submitted!',
                        text: 'Thank you. Our admissions team will get in touch with you shortly.',
                        icon: 'success',
                        confirmButtonText: 'Done',
                        confirmButtonColor: '#002d62',
                        background: '#ffffff',
                        color: '#002147',
                    });
                } else {
                    window.alert('Thank you. Our admissions team will get in touch with you shortly.');
                }

                enquiryForm.reset();
                enquiryForm.classList.remove('was-validated');
            } catch (err) {
                if (window.Swal) {
                    await Swal.fire({
                        title: 'Submission Error',
                        text: err.message || 'Could not submit your enquiry. Please check your information and try again.',
                        icon: 'error',
                        confirmButtonColor: '#002d62',
                    });
                } else {
                    window.alert(err.message || 'Error submitting enquiry.');
                }
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnHtml;
                }
            }
        });
    </script>
</body>
</html>

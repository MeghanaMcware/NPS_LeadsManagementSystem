<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#002d62">
    <title>Life at NPS KGL | National Public School Kempegowda Layout Bengaluru</title>
    <meta name="description" content="Discover vibrant student life at National Public School, Kempegowda Layout 7th Block. Explore academics, sports, arts, STEM clubs, house traditions, and holistic campus development.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,600;1,700;1,800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.min.css">

    <style>
        :root {
            --nps-navy: #002d62;
            --nps-deep-navy: #002147;
            --nps-gold: #fbbf24;
            --nps-gold-dark: #d97706;
            --nps-gold-light: #fef3c7;
            --nps-red: #b91c1c;
            --nps-ink: #172554;
            --nps-muted: #526078;
            --nps-line: #dce5ef;
            --nps-soft-bg: #f8fafc;
            --nps-card-bg: #ffffff;
            --nps-heading: "Playfair Display", Georgia, serif;
            --nps-body: "Lato", Arial, sans-serif;
            --nps-hand: "Lato", Arial, sans-serif;
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
            font-size: 15px;
            line-height: 1.6;
            overflow-x: clip;
            width: 100%;
        }

        a { color: inherit; text-decoration: none; }

        .page-shell {
            min-height: 100vh;
            margin: 0 auto;
            overflow-x: clip;
            background: #fff;
            box-shadow: 0 0 30px rgba(0, 33, 71, 0.08);
        }

                /* SECTION HEADINGS & BADGES */
        .section-kicker {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 20px;
            background: rgba(0, 45, 98, 0.08);
            color: var(--nps-navy);
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .section-kicker.gold-theme {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .section-title {
            font-family: var(--nps-heading);
            font-size: clamp(28px, 3.5vw, 38px);
            font-weight: 800;
            color: var(--nps-deep-navy);
            line-height: 1.25;
            margin: 10px 0;
        }

        .section-subtitle {
            color: var(--nps-muted);
            font-size: clamp(14px, 1.2vw, 16.5px);
            max-width: 720px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .hand-accent {
            font-family: var(--nps-hand);
            font-size: 26px;
            color: #d97706;
            display: inline-block;
        }

        /* HERO SECTION */
        .life-hero {
            position: relative;
            padding: 50px 24px 60px;
            background: linear-gradient(135deg, #001a38 0%, #002d62 60%, #083b7e 100%);
            color: #fff;
            overflow: hidden;
            isolation: isolate;
        }

        .life-hero::before {
            position: absolute;
            content: "";
            inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(251, 191, 36, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 10% 80%, rgba(185, 28, 28, 0.15) 0%, transparent 40%);
            z-index: -1;
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
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            backdrop-filter: blur(6px);
            margin-bottom: 16px;
        }

        .hero-headline {
            font-family: "Playfair Display", Georgia, serif;
            font-size: clamp(34px, 4.2vw, 52px);
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            margin-bottom: 18px;
        }

        .hero-headline span {
            font-family: "Playfair Display", Georgia, serif;
            color: var(--nps-gold);
            font-style: italic;
        }

        .hero-lead {
            font-size: clamp(15px, 1.3vw, 17px);
            color: #dbeafe;
            max-width: 620px;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 14px;
            margin-bottom: 36px;
        }

        .btn-gold-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            background: var(--nps-gold);
            color: #002147;
            font-weight: 800;
            font-size: 14.5px;
            border: 0;
            box-shadow: 0 4px 14px rgba(251, 191, 36, 0.35);
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .btn-gold-action:hover {
            background: #f59e0b;
            color: #001736;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(251, 191, 36, 0.5);
        }

        .btn-outline-white {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 700;
            font-size: 14.5px;
            backdrop-filter: blur(4px);
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .btn-outline-white:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-color: #fff;
        }

        /* HERO MOSAIC */
        .hero-mosaic {
            position: relative;
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(12, 35px);
            gap: 12px;
        }

        .mosaic-item {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.15);
            transition: transform 0.3s ease;
        }

        .mosaic-item:hover {
            transform: translateY(-4px);
        }

        .mosaic-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .mosaic-1 { grid-column: 1 / 8; grid-row: 1 / 8; }
        .mosaic-2 { grid-column: 8 / 13; grid-row: 1 / 7; }
        .mosaic-3 { grid-column: 8 / 13; grid-row: 7 / 13; }
        .mosaic-4 { grid-column: 1 / 8; grid-row: 8 / 13; }

        .mosaic-tag {
            position: absolute;
            bottom: 8px;
            left: 8px;
            background: rgba(0, 33, 71, 0.85);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 12px;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* STATS STRIP */
        .stats-ribbon {
            margin-top: -30px;
            position: relative;
            z-index: 20;
            padding: 0 24px;
        }

        .stats-bar {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 35px rgba(0, 33, 71, 0.12);
            padding: 24px 30px;
            border: 1px solid #e2e8f0;
        }

        .stat-card {
            text-align: center;
            padding: 10px;
            position: relative;
        }

        .stat-card:not(:last-child)::after {
            content: "";
            position: absolute;
            right: 0;
            top: 20%;
            height: 60%;
            width: 1px;
            background: #e2e8f0;
        }

        .stat-num {
            font-family: var(--nps-heading);
            font-size: 32px;
            font-weight: 800;
            color: var(--nps-navy);
            line-height: 1.1;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--nps-muted);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        /* SECTION STYLING */
        .section-pad {
            padding: 70px 24px;
        }

        .bg-light-alt {
            background: #f8fafc;
        }

        /* A DAY IN THE LIFE TIMELINE */
        .timeline-container {
            position: relative;
            max-width: 900px;
            margin: 40px auto 0;
        }

        .timeline-container::before {
            content: "";
            position: absolute;
            left: 30px;
            top: 10px;
            bottom: 10px;
            width: 3px;
            background: linear-gradient(to bottom, var(--nps-navy), var(--nps-gold), var(--nps-red));
            border-radius: 3px;
        }

        .timeline-row {
            position: relative;
            padding-left: 76px;
            margin-bottom: 28px;
        }

        .timeline-badge {
            position: absolute;
            left: 12px;
            top: 4px;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid var(--nps-navy);
            box-shadow: 0 0 0 4px #e0e7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--nps-navy);
            z-index: 2;
        }

        .timeline-row:nth-child(2) .timeline-badge { border-color: var(--nps-gold-dark); box-shadow: 0 0 0 4px #fef3c7; color: var(--nps-gold-dark); }
        .timeline-row:nth-child(3) .timeline-badge { border-color: #0284c7; box-shadow: 0 0 0 4px #e0f2fe; color: #0284c7; }
        .timeline-row:nth-child(4) .timeline-badge { border-color: #16a34a; box-shadow: 0 0 0 4px #dcfce7; color: #16a34a; }
        .timeline-row:nth-child(5) .timeline-badge { border-color: #9333ea; box-shadow: 0 0 0 4px #f3e8ff; color: #9333ea; }
        .timeline-row:nth-child(6) .timeline-badge { border-color: var(--nps-red); box-shadow: 0 0 0 4px #fee2e2; color: var(--nps-red); }

        .timeline-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 4px 18px rgba(0, 33, 71, 0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.25s ease;
        }

        .timeline-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 24px rgba(0, 33, 71, 0.1);
            border-color: #cbd5e1;
        }

        .timeline-time {
            font-size: 12.5px;
            font-weight: 800;
            color: var(--nps-red);
            text-transform: uppercase;
            letter-spacing: .05em;
            display: inline-block;
            margin-bottom: 4px;
        }

        .timeline-title {
            font-family: var(--nps-heading);
            font-size: 19px;
            font-weight: 700;
            color: var(--nps-deep-navy);
            margin-bottom: 6px;
        }

        .timeline-desc {
            color: var(--nps-muted);
            font-size: 14.5px;
            margin: 0;
            line-height: 1.55;
        }

        /* PILLARS TABS & CARDS */
        .pillars-nav {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 36px 0 28px;
        }

        .pillar-tab-btn {
            padding: 10px 20px;
            border-radius: 30px;
            background: #fff;
            border: 1px solid #cbd5e1;
            color: var(--nps-ink);
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .pillar-tab-btn:hover {
            border-color: var(--nps-navy);
            color: var(--nps-navy);
            background: #f1f5f9;
        }

        .pillar-tab-btn.active {
            background: var(--nps-navy);
            color: #fff;
            border-color: var(--nps-navy);
            box-shadow: 0 4px 14px rgba(0, 45, 98, 0.25);
        }

        .pillar-content-pane {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .pillar-content-pane.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .feature-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 26px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--nps-navy);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(0, 33, 71, 0.08);
            border-color: #cbd5e1;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(0, 45, 98, 0.08);
            color: var(--nps-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .feature-icon-wrap.gold { background: #fef3c7; color: #b45309; }
        .feature-icon-wrap.green { background: #dcfce7; color: #15803d; }
        .feature-icon-wrap.red { background: #fee2e2; color: #b91c1c; }
        .feature-icon-wrap.purple { background: #f3e8ff; color: #7e22ce; }

        .feature-title {
            font-family: var(--nps-heading);
            font-size: 19px;
            font-weight: 700;
            color: var(--nps-deep-navy);
            margin-bottom: 8px;
        }

        .feature-text {
            color: var(--nps-muted);
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }

        /* HOUSE SYSTEM SECTION */
        .house-grid {
            margin-top: 36px;
        }

        .house-card {
            border-radius: 16px;
            padding: 26px 22px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .house-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.2);
        }

        .house-phoenix {
            background: linear-gradient(135deg, #991b1b 0%, #b91c1c 50%, #dc2626 100%);
        }

        .house-pegasus {
            background: linear-gradient(135deg, #075985 0%, #0284c7 50%, #0369a1 100%);
        }

        .house-orion {
            background: linear-gradient(135deg, #166534 0%, #15803d 50%, #16a34a 100%);
        }

        .house-hercules {
            background: linear-gradient(135deg, #b45309 0%, #d97706 50%, #f59e0b 100%);
        }

        .house-crest-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            backdrop-filter: blur(4px);
        }

        .house-name {
            font-family: var(--nps-heading);
            font-size: 22px;
            font-weight: 800;
            letter-spacing: .02em;
            margin-bottom: 4px;
        }

        .house-motto {
            font-style: italic;
            font-size: 13.5px;
            opacity: 0.9;
            margin-bottom: 12px;
            color: #fef08a;
        }

        .house-virtues {
            font-size: 13px;
            line-height: 1.5;
            opacity: 0.95;
            margin: 0;
        }

        /* PHOTO GALLERY WITH LIGHTBOX */
        .gallery-filter-wrap {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 30px 0 32px;
        }

        .gallery-filter-btn {
            padding: 8px 18px;
            border-radius: 20px;
            border: 1px solid #cbd5e1;
            background: #fff;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .gallery-filter-btn:hover {
            border-color: var(--nps-navy);
            color: var(--nps-navy);
        }

        .gallery-filter-btn.active {
            background: var(--nps-navy);
            color: #fff;
            border-color: var(--nps-navy);
        }

        @keyframes galleryFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .gallery-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(0, 33, 71, 0.08);
            border: 1px solid #e2e8f0;
            height: 240px;
            cursor: pointer;
            margin-bottom: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 26px rgba(0, 33, 71, 0.16);
        }

        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-card:hover .gallery-img {
            transform: scale(1.06);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 33, 71, 0.9) 0%, rgba(0, 33, 71, 0.2) 60%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 16px;
            color: #fff;
            opacity: 0.95;
            transition: opacity 0.3s ease;
        }

        .gallery-category-badge {
            align-self: flex-start;
            background: var(--nps-gold);
            color: #002147;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 6px;
        }

        .gallery-card-title {
            font-size: 15px;
            font-weight: 700;
            margin: 0;
            line-height: 1.3;
        }

        .gallery-card-desc {
            font-size: 12px;
            opacity: 0.85;
            margin-top: 3px;
        }

        /* ANNUAL TRADITIONS SHOWCASE */
        .tradition-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px rgba(0, 33, 71, 0.06);
            height: 100%;
            transition: all 0.3s ease;
        }

        .tradition-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 33, 71, 0.12);
        }

        .tradition-img-wrap {
            position: relative;
            height: 170px;
            overflow: hidden;
        }

        .tradition-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .tradition-body {
            padding: 20px;
        }

        .tradition-tag {
            color: var(--nps-gold-dark);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            display: block;
            margin-bottom: 4px;
        }

        .tradition-title {
            font-family: var(--nps-heading);
            font-size: 20px;
            font-weight: 700;
            color: var(--nps-deep-navy);
            margin-bottom: 8px;
        }

        .tradition-text {
            color: var(--nps-muted);
            font-size: 14px;
            line-height: 1.55;
            margin: 0;
        }

        /* TESTIMONIALS / VOICES */
        .voice-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 28px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 6px 20px rgba(0, 33, 71, 0.06);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .voice-quote-icon {
            font-family: "Lato", Arial, sans-serif;
            font-size: 44px;
            color: #cbd5e1;
            line-height: 1;
            margin-bottom: 8px;
        }

        .voice-text {
            color: #334155;
            font-size: 14.5px;
            line-height: 1.6;
            font-style: italic;
            margin-bottom: 20px;
        }

        .voice-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .voice-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #002d62;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .voice-name {
            font-weight: 800;
            color: var(--nps-deep-navy);
            font-size: 14px;
            line-height: 1.2;
        }

        .voice-role {
            font-size: 12px;
            color: var(--nps-muted);
            margin-top: 2px;
        }

        /* FOOTER */
        .footer-bg {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: 22px 0 18px;
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

        .footer-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
        }

        .footer-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: contain;
        }

        .footer-name {
            display: block;
            color: #fff;
            font-size: 14.5px;
            font-weight: 800;
            line-height: 1.2;
            white-space: nowrap;
        }

        .footer-subtitle {
            display: block;
            margin-top: 2px;
            color: var(--nps-gold);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .035em;
            line-height: 1.2;
            white-space: nowrap;
        }

        .footer-details {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-start;
            gap: 12px 18px;
        }

        .footer-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #e2e8f0;
            font-size: 12.5px;
            text-decoration: none;
        }

        .footer-item:hover {
            color: var(--nps-gold);
        }

        /* MODALS */
        .modal-custom {
            position: fixed !important;
            inset: 0 !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            z-index: 9999999 !important;
            background: rgba(0, 20, 48, 0.82);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-custom.is-open {
            display: flex;
        }

        .modal-custom-dialog {
            background: #fff;
            border-radius: 16px;
            max-width: 720px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalPop 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes modalPop {
            from { transform: scale(0.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-close-btn {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #f1f5f9;
            border: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #334155;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s ease;
        }

        .modal-close-btn:hover {
            background: #e2e8f0;
            color: #000;
        }

        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            background: #000;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* LIGHTBOX DIALOG */
        .lightbox-img-view {
            max-height: 75vh;
            width: 100%;
            object-fit: contain;
            background: #000;
            display: block;
        }

        .lightbox-caption {
            padding: 16px 20px;
            background: #fff;
        }

        /* FLOATING BACK TO TOP */
        .btn-floating-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--nps-navy);
            color: #fff;
            border: 2px solid var(--nps-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 6px 18px rgba(0, 33, 71, 0.3);
            cursor: pointer;
            z-index: 80;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .btn-floating-top.show {
            opacity: 1;
            visibility: visible;
        }

        .btn-floating-top:hover {
            background: var(--nps-deep-navy);
            transform: translateY(-3px);
        }

        /* RESPONSIVE BREAKPOINTS */
        @media (max-width: 991.98px) {
            .hero-mosaic {
                margin-top: 36px;
                grid-template-rows: repeat(12, 28px);
            }
            .stats-bar {
                padding: 18px 20px;
            }
            .stat-num {
                font-size: 26px;
            }
            .stat-label {
                font-size: 11px;
            }
        }

        @media (max-width: 767.98px) {
            .page-shell {
                overflow-x: clip;
            }

            .life-hero {
                padding: 30px 16px 45px;
            }
            .hero-headline {
                font-size: clamp(26px, 7vw, 36px);
                line-height: 1.2;
            }
            .hero-lead {
                font-size: 13.5px;
                line-height: 1.55;
            }
            .hero-actions {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin: 18px 0 14px;
            }
            .btn-gold-action {
                width: 100%;
                justify-content: center;
                padding: 11px 20px;
                font-size: 14px;
            }

            .hero-mosaic {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: auto;
                gap: 10px;
                margin-top: 24px;
            }
            .mosaic-1, .mosaic-2, .mosaic-3, .mosaic-4 {
                grid-column: span 1 !important;
                grid-row: auto !important;
                height: 145px;
            }
            .mosaic-tag {
                font-size: 10px;
                padding: 3px 8px;
                bottom: 6px;
                left: 6px;
                max-width: calc(100% - 12px);
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .stats-ribbon {
                margin-top: -18px;
                padding: 0 16px;
            }
            .stats-bar {
                padding: 14px;
                border-radius: 14px;
            }
            .stat-card:not(:last-child)::after {
                display: none;
            }
            .stat-card {
                padding: 8px 4px;
            }
            .stat-num {
                font-size: 24px;
            }
            .stat-label {
                font-size: 11px;
            }

            .section-pad {
                padding: 42px 16px;
            }
            .section-title {
                font-size: clamp(22px, 6vw, 30px);
                line-height: 1.25;
            }
            .section-subtitle {
                font-size: 13px;
                line-height: 1.5;
            }

            .timeline-container {
                margin-top: 28px;
            }
            .timeline-container::before {
                left: 16px;
            }
            .timeline-row {
                padding-left: 48px;
                margin-bottom: 22px;
            }
            .timeline-badge {
                left: 0;
                width: 32px;
                height: 32px;
            }
            .timeline-card {
                padding: 14px 16px;
                border-radius: 12px;
            }
            .timeline-title {
                font-size: 16px;
            }
            .timeline-desc {
                font-size: 13px;
                line-height: 1.5;
            }

            .pillars-nav {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                justify-content: center;
                margin: 22px 0 18px;
            }
            .pillar-tab-btn {
                padding: 8px 14px;
                font-size: 12.5px;
                gap: 6px;
            }
            .feature-card {
                padding: 18px;
                border-radius: 14px;
            }
            .feature-title {
                font-size: 17px;
            }
            .feature-text {
                font-size: 13px;
                line-height: 1.5;
            }

            .house-card {
                padding: 20px 16px;
                border-radius: 14px;
            }
            .house-name {
                font-size: 19px;
            }
            .house-motto {
                font-size: 12.5px;
            }
            .house-virtues {
                font-size: 12px;
            }

            .tradition-img-wrap {
                height: 160px;
            }
            .tradition-body {
                padding: 16px;
            }
            .tradition-title {
                font-size: 17px;
            }
            .tradition-text {
                font-size: 13px;
                line-height: 1.5;
            }

            .voice-card {
                padding: 18px 16px;
                border-radius: 14px;
            }
            .voice-text {
                font-size: 13px;
                line-height: 1.5;
            }

            .modal-custom {
                padding: 10px;
            }
            .modal-custom-dialog {
                max-width: 100%;
                border-radius: 12px;
            }
            .modal-close-btn {
                top: 8px;
                right: 8px;
                width: 32px;
                height: 32px;
            }

            .footer-bg {
                padding: 22px 0 18px;
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
            .mosaic-1, .mosaic-2, .mosaic-3, .mosaic-4 {
                height: 125px;
            }
            .stat-num {
                font-size: 20px;
            }
            .stat-label {
                font-size: 10.5px;
            }
            .timeline-container::before {
                left: 14px;
            }
            .timeline-row {
                padding-left: 42px;
            }
            .timeline-badge {
                width: 28px;
                height: 28px;
            }
            .timeline-badge svg {
                width: 14px !important;
                height: 14px !important;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('website/header.css') }}">
</head>
<body>
    <div class="page-shell">

        @include('frontend.layout.header')

        <main>
            <!-- ================= HERO SECTION ================= -->
            <section class="life-hero">
                <div class="container-fluid px-lg-5">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-6">
                            
                            <h1 class="hero-headline">
                                Life at <span>NPS Kempegowda Layout</span>
                            </h1>
                            <p class="hero-lead">
                                Guided by the founding vision of Chairman Dr. K. P. Gopalkrishna and Senior Principal Dr. Santhamma Gopalkrishna, life at NPS Kempegowda Layout is designed to bring out the best in children. Within our empowering, child-centric environment, academic rigour blends seamlessly with athletic agility, artistic expression, and enduring values to nurture versatile, future-ready global citizens.
                            </p>
                            <div class="hero-actions">
                                <a href="{{ url('/#admission-enquiry-box') }}" class="btn-gold-action">
                                    <i data-lucide="file-text" style="width:18px;height:18px;"></i>
                                    Admissions Enquiry 2027-28
                                </a>
                                
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning text-dark px-3 py-2 fw-bold" style="border-radius:20px; font-size:12px;">
                                        <i data-lucide="award" class="me-1" style="width:14px;height:14px;display:inline;"></i> CBSE Affiliation Ready
                                    </span>
                                </div>
                                <span class="text-white-50" style="font-size:13px;">Kempegowda Layout 7th Block, Bengaluru</span>
                            </div>
                        </div>

                        <!-- Hero Mosaic Grid -->
                        <div class="col-lg-6">
                            <div class="hero-mosaic">
                                <div class="mosaic-item mosaic-1">
                                    <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0125.jpg') }}" alt="NPS Students Joyful Community" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0125.webp') }}'">
                                    <span class="mosaic-tag"><i data-lucide="smile" style="width:12px;height:12px;display:inline;"></i> Joyful Community</span>
                                </div>
                                <div class="mosaic-item mosaic-2">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9401.JPG') }}" alt="Student playing basketball" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9401.webp') }}'">
                                    <span class="mosaic-tag"><i data-lucide="trophy" style="width:12px;height:12px;display:inline;"></i> Sports &amp; Agility</span>
                                </div>
                                <div class="mosaic-item mosaic-3">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9664.JPG') }}" alt="Science Laboratory Discovery" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9664.webp') }}'">
                                    <span class="mosaic-tag"><i data-lucide="flask-conical" style="width:12px;height:12px;display:inline;"></i> STEM Discovery</span>
                                </div>
                                <div class="mosaic-item mosaic-4">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9491.JPG') }}" alt="Football Turf Coaching" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9491.webp') }}'">
                                    <span class="mosaic-tag"><i data-lucide="shield-check" style="width:12px;height:12px;display:inline;"></i> Turf Athletics</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= STATS RIBBON ================= -->
            <section class="stats-ribbon">
                <div class="container-fluid px-lg-5">
                    <div class="stats-bar">
                        <div class="row g-2 align-items-center">
                            <div class="col-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-num">1 : 15</div>
                                    <div class="stat-label">Teacher-Student Ratio</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-num">25+</div>
                                    <div class="stat-label">Clubs & Activities</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-num">100%</div>
                                    <div class="stat-label">Holistic Participation</div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card">
                                    <div class="stat-num">4</div>
                                    <div class="stat-label">Vibrant Houses</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= A DAY IN THE LIFE ================= -->
            <section class="section-pad bg-light-alt" id="day-in-life">
                <div class="container">
                    <div class="text-center mb-4">
                        <span class="section-kicker"><i data-lucide="clock" style="width:14px;height:14px;"></i> Daily Routine</span>
                        <h2 class="section-title">A Day in the Life at NPS KGL</h2>
                        <p class="section-subtitle">
                            From mindful morning reflections to energetic afternoons on the sports courts, every hour is crafted to build curiosity, resilience, and camaraderie.
                        </p>
                    </div>

                    <div class="timeline-container">
                        <!-- Step 1 -->
                        <div class="timeline-row">
                            <div class="timeline-badge"><i data-lucide="sunrise" style="width:18px;height:18px;"></i></div>
                            <div class="timeline-card">
                                
                                <h3 class="timeline-title">Morning Assembly &amp; Mindful Reflection</h3>
                                <p class="timeline-desc">
                                    The school day begins with the solemn school anthem, student-led thought for the day, news analyses, and mindful reflections that instill moral values, civic pride, and positive focus across the school community.
                                </p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="timeline-row">
                            <div class="timeline-badge"><i data-lucide="brain" style="width:18px;height:18px;"></i></div>
                            <div class="timeline-card">
                                
                                <h3 class="timeline-title">Inquiry-Driven Scholastic Learning</h3>
                                <p class="timeline-desc">
                                    Interactive smart classrooms bring the CBSE curriculum alive. Guided by caring faculty, students engage in 'learning by doing'—collaborative discussions, problem-solving, and concept-based mastery over rote memorization.
                                </p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="timeline-row">
                            <div class="timeline-badge"><i data-lucide="flask-conical" style="width:18px;height:18px;"></i></div>
                            <div class="timeline-card">
                                
                                <h3 class="timeline-title">Hands-On STEM, Robotics &amp; Experimental Labs</h3>
                                <p class="timeline-desc">
                                    Students step into dedicated physics, chemistry, biology, mathematics, and IT &amp; robotics studios to conduct experiments, explore algorithms, calibrate microscopes, and test theories empirically.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="timeline-row">
                            <div class="timeline-badge"><i data-lucide="utensils" style="width:18px;height:18px;"></i></div>
                            <div class="timeline-card">
                               
                                <h3 class="timeline-title">Nutritious Dining &amp; Courtyard Camaraderie</h3>
                                <p class="timeline-desc">
                                    Wholesome, hygienic meals enjoyed in our spacious courtyard cafeteria. A joyful time for informal socialization, cross-grade friendships, and developing healthy social etiquette.
                                </p>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="timeline-row">
                            <div class="timeline-badge"><i data-lucide="palette" style="width:18px;height:18px;"></i></div>
                            <div class="timeline-card">
                              
                                <h3 class="timeline-title">Performing Arts, Music &amp; Creative Studios</h3>
                                <p class="timeline-desc">
                                    Creative expression flourishes through vocal and instrumental music, classical Bharatanatyam, contemporary dance, theatrical expression, and visual fine arts.
                                </p>
                            </div>
                        </div>

                        <!-- Step 6 -->
                        <div class="timeline-row">
                            <div class="timeline-badge"><i data-lucide="activity" style="width:18px;height:18px;"></i></div>
                            <div class="timeline-card">
                                
                                <h3 class="timeline-title">Athletic Agility, Sports &amp; Leadership Circles</h3>
                                <p class="timeline-desc">
                                    The day culminates on our sports arenas—basketball drills, football agility, cricket net practice, and track events—instilling sportsmanship, physical stamina, and house camaraderie.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= PILLARS OF STUDENT LIFE ================= -->
            <section class="section-pad" id="pillars-section">
                <div class="container">
                    <div class="text-center mb-4">
                        <span class="section-kicker gold-theme"><i data-lucide="gem" style="width:14px;height:14px;"></i> Core Foundations</span>
                        <h2 class="section-title">The Pillars of Campus Life</h2>
                        <p class="section-subtitle">
                            Every aspect of student life is thoughtfully orchestrated to foster academic prowess, physical stamina, creative boldness, and compassionate leadership.
                        </p>
                    </div>

                    <!-- Navigation Tabs -->
                    <div class="pillars-nav">
                        <button type="button" class="pillar-tab-btn active" data-tab="tab-stem">
                            <i data-lucide="cpu" style="width:16px;height:16px;"></i>Academics
                        </button>
                        <button type="button" class="pillar-tab-btn" data-tab="tab-sports">
                            <i data-lucide="trophy" style="width:16px;height:16px;"></i> Sports 
                        </button>
                        <button type="button" class="pillar-tab-btn" data-tab="tab-arts">
                            <i data-lucide="music" style="width:16px;height:16px;"></i> Arts 
                        </button>
                        <button type="button" class="pillar-tab-btn" data-tab="tab-clubs">
                            <i data-lucide="users" style="width:16px;height:16px;"></i>  Leadership
                        </button>
                        <button type="button" class="pillar-tab-btn" data-tab="tab-care">
                            <i data-lucide="heart-handshake" style="width:16px;height:16px;"></i> Wellness 
                        </button>
                    </div>

                    <!-- Tab 1: STEM & Academics -->
                    <div class="pillar-content-pane active" id="tab-stem">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap"><i data-lucide="microscope"></i></div>
                                    <h4 class="feature-title">Composite Science Labs</h4>
                                    <p class="feature-text">
                                        Fully-equipped physics, chemistry, and biology experimental stations adhering to world-class safety standards where students conduct hands-on empirical science.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap purple"><i data-lucide="bot"></i></div>
                                    <h4 class="feature-title">Robotics &amp; AI Studio</h4>
                                    <p class="feature-text">
                                        Cutting-edge computational thinking, Arduino and micro-controller programming, mechanical fabrication, and logic puzzle solving to build future-ready innovators.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap gold"><i data-lucide="book-open"></i></div>
                                    <h4 class="feature-title">Digital Knowledge Hub</h4>
                                    <p class="feature-text">
                                        A peaceful, light-filled library cataloging thousands of age-appropriate titles, encyclopedias, reference works, and digital e-learning subscriptions.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: Sports & Fitness -->
                    <div class="pillar-content-pane" id="tab-sports">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap red"><i data-lucide="dribbble"></i></div>
                                    <h4 class="feature-title">FIBA Basketball Court</h4>
                                    <p class="feature-text">
                                        Professional-grade, shock-absorbing synthetic basketball arena with floodlights, hosting daily dribbling drills, tactical coaching, and inter-school league clashes.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap green"><i data-lucide="target"></i></div>
                                    <h4 class="feature-title">Football Turf &amp; Track</h4>
                                    <p class="feature-text">
                                        Spacious, lush outdoor turf for football matches, sprint tracks, athletic field events, and morning physical conditioning under licensed coaches.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap gold"><i data-lucide="swords"></i></div>
                                    <h4 class="feature-title">Cricket Nets &amp; Indoor Games</h4>
                                    <p class="feature-text">
                                        Dedicated batting practice cages with bowling machines, indoor badminton courts, table tennis stations, and chess strategizing clubs.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 3: Arts & Expression -->
                    <div class="pillar-content-pane" id="tab-arts">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap purple"><i data-lucide="headphones"></i></div>
                                    <h4 class="feature-title">Acoustic Music Conservatory</h4>
                                    <p class="feature-text">
                                        Vocal and instrumental guidance spanning classical Carnatic and Hindustani music, western guitar, keyboard, violin, and percussion ensembles.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap"><i data-lucide="sparkles"></i></div>
                                    <h4 class="feature-title">Dance &amp; Rhythm Studio</h4>
                                    <p class="feature-text">
                                        Sprung wooden flooring with mirrored studios where students explore Bharatanatyam, Kathak, contemporary ballet, and rhythmic fusion choreography.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap gold"><i data-lucide="brush"></i></div>
                                    <h4 class="feature-title">Fine Arts &amp; Pottery Studio</h4>
                                    <p class="feature-text">
                                        From watercolor landscapes and acrylic canvas to clay pottery and recycled material installations, nurturing boundless aesthetic sensitivity.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 4: Clubs & Leadership -->
                    <div class="pillar-content-pane" id="tab-clubs">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap green"><i data-lucide="sprout"></i></div>
                                    <h4 class="feature-title">Eco-Warriors Green Guild</h4>
                                    <p class="feature-text">
                                        Leading campus composting, rainwater awareness, organic kitchen gardening, and zero-single-use-plastic drives across Kempegowda Layout.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap"><i data-lucide="message-square"></i></div>
                                    <h4 class="feature-title">Model UN &amp; Orators' Society</h4>
                                    <p class="feature-text">
                                        Honing articulation, global diplomacy, parliamentary debate protocols, and spontaneous public discourse through spirited inter-house tournaments.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap red"><i data-lucide="pen-tool"></i></div>
                                    <h4 class="feature-title">Editorial &amp; Literary Circle</h4>
                                    <p class="feature-text">
                                        Authoring the annual school magazine, reporting campus events, publishing student poetry, and hosting book review symposiums.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 5: Wellness & Care -->
                    <div class="pillar-content-pane" id="tab-care">
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap"><i data-lucide="smile"></i></div>
                                    <h4 class="feature-title">Pastoral Care &amp; Counselling</h4>
                                    <p class="feature-text">
                                        A supportive sanctuary with full-time child counselors providing emotional guidance, peer mediation, academic coaching, and mindfulness sessions.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap red"><i data-lucide="heart-pulse"></i></div>
                                    <h4 class="feature-title">NPS Health Centre &amp; Nurse</h4>
                                    <p class="feature-text">
                                        A dedicated campus health center staffed with a qualified resident nurse to manage emergencies, provide immediate first-aid, promote health education, and prioritize student wellness.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card">
                                    <div class="feature-icon-wrap gold"><i data-lucide="shield-check"></i></div>
                                    <h4 class="feature-title">Secure GPS Campus &amp; Fleet</h4>
                                    <p class="feature-text">
                                        360-degree CCTV surveillance, strict RFID access control, background-verified personnel, and GPS-tracked school buses with lady attendants.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= THE FOUR HOUSES ================= -->
            <section class="section-pad bg-light-alt" id="houses-section">
                <div class="container">
                    <div class="text-center mb-4">
                        <span class="section-kicker"><i data-lucide="shield" style="width:14px;height:14px;"></i> House System</span>
                        <h2 class="section-title">The Four Houses of NPS KGL</h2>
                        <p class="section-subtitle">
                            Instilling healthy competition, lifelong brotherhood, and team pride. Every student belongs to a house and contributes points toward the prestigious Annual Cock House Trophy.
                        </p>
                    </div>

                    <div class="row g-4 house-grid">
                        <!-- Phoenix -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="house-card house-phoenix">
                                <div class="house-crest-icon"><i data-lucide="flame" style="width:24px;height:24px;"></i></div>
                                <h3 class="house-name">Phoenix</h3>
                                <div class="house-motto">"Rise Above Every Adversity"</div>
                                <p class="house-virtues">
                                    Color: Ruby Red<br>
                                    Virtues: Courage, Unyielding Resilience, Fierce Passion &amp; Energy.
                                </p>
                            </div>
                        </div>

                        <!-- Pegasus -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="house-card house-pegasus">
                                <div class="house-crest-icon"><i data-lucide="feather" style="width:24px;height:24px;"></i></div>
                                <h3 class="house-name">Pegasus</h3>
                                <div class="house-motto">"Soar to Greater Heights"</div>
                                <p class="house-virtues">
                                    Color: Sapphire Blue<br>
                                    Virtues: Vision, Intellectual Curiosity, Freedom of Thought &amp; Mastery.
                                </p>
                            </div>
                        </div>

                        <!-- Orion -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="house-card house-orion">
                                <div class="house-crest-icon"><i data-lucide="compass" style="width:24px;height:24px;"></i></div>
                                <h3 class="house-name">Orion</h3>
                                <div class="house-motto">"Guide the Way Forward"</div>
                                <p class="house-virtues">
                                    Color: Emerald Green<br>
                                    Virtues: Integrity, Moral Stewardship, Environmental Compassion &amp; Grace.
                                </p>
                            </div>
                        </div>

                        <!-- Hercules -->
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="house-card house-hercules">
                                <div class="house-crest-icon"><i data-lucide="shield-alert" style="width:24px;height:24px;"></i></div>
                                <h3 class="house-name">Hercules</h3>
                                <div class="house-motto">"Strength Through Discipline"</div>
                                <p class="house-virtues">
                                    Color: Amber Gold<br>
                                    Virtues: Perseverance, Physical Stamina, Honor, Fair Play &amp; Loyalty.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

          

            <!-- ================= ANNUAL TRADITIONS ================= -->
            <section class="section-pad bg-light-alt" id="traditions-section">
                <div class="container">
                    <div class="text-center mb-4">
                        <span class="section-kicker"><i data-lucide="calendar" style="width:14px;height:14px;"></i> Milestones</span>
                        <h2 class="section-title">Signature Annual Traditions</h2>
                        <p class="section-subtitle">
                            Moments of shared triumph, collective pride, and cherished memories that weave the lifelong tapestry of every NPS alumnus.
                        </p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="tradition-card">
                                <div class="tradition-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0113.jpg') }}" alt="AURA Fest" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0113.webp') }}'">
                                </div>
                                <div class="tradition-body">
                                    <span class="tradition-tag">November</span>
                                    <h4 class="tradition-title">AURA – Annual Day</h4>
                                    <p class="tradition-text">
                                        Our marquee performing arts gala. A grand spectacle featuring 100% student participation in orchestra, classical dance, and drama.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="tradition-card">
                                <div class="tradition-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9491.JPG') }}" alt="SPARDHA Meet" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9491.webp') }}'">
                                </div>
                                <div class="tradition-body">
                                    <span class="tradition-tag">December</span>
                                    <h4 class="tradition-title">SPARDHA – Sports Day</h4>
                                    <p class="tradition-text">
                                        Synchronized march-past, torch lighting, nail-biting 100m dashes, obstacle challenges, and the coronation of the House Champion.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="tradition-card">
                                <div class="tradition-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG_0447.jpg') }}" alt="ANVESHANA Fair" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG_0447.webp') }}'">
                                </div>
                                <div class="tradition-body">
                                    <span class="tradition-tag">January</span>
                                    <h4 class="tradition-title">ANVESHANA – Tech Fest</h4>
                                    <p class="tradition-text">
                                        An interactive science and technology fair where student innovations are judged by distinguished scientists and engineers.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="tradition-card">
                                <div class="tradition-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0125.jpg') }}" alt="UTSAV Fest" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0125.webp') }}'">
                                </div>
                                <div class="tradition-body">
                                    <span class="tradition-tag">October</span>
                                    <h4 class="tradition-title">UTSAV – Heritage Week</h4>
                                    <p class="tradition-text">
                                        Celebrating linguistic richness, regional folklore, traditional arts, calligraphy, and historical heritage in vibrant festive attire.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= VOICES OF NPS KGL ================= -->
            <section class="section-pad" id="voices-section">
                <div class="container">
                    <div class="text-center mb-4">
                        <span class="section-kicker gold-theme"><i data-lucide="quote" style="width:14px;height:14px;"></i> Reflections</span>
                        <h2 class="section-title">Voices of Our Community</h2>
                        <p class="section-subtitle">
                            Hear firsthand from the students, parents, and educators who make our school a warm, inspiring home away from home.
                        </p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="voice-card">
                                <div class="voice-quote-icon">“</div>
                                <p class="voice-text">
                                    "Being the captain of Pegasus House has taught me empathy, crisis resolution, and leadership. At NPS KGL, our teachers don’t just teach subjects; they believe in our craziest ideas and push us to lead."
                                </p>
                                <div class="voice-author">
                                    <div class="voice-avatar">AK</div>
                                    <div>
                                        <div class="voice-name">Ananya K.</div>
                                        <div class="voice-role">Grade 8 Student &amp; House Captain</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="voice-card">
                                <div class="voice-quote-icon">“</div>
                                <p class="voice-text">
                                    "What stands out about NPS Kempegowda Layout is the balanced focus on academic depth and genuine human warmth. My son rushes to school every morning with a beaming smile, eager for his robotics club."
                                </p>
                                <div class="voice-author">
                                    <div class="voice-avatar" style="background:#b91c1c;">RS</div>
                                    <div>
                                        <div class="voice-name">Rajesh Sharma</div>
                                        <div class="voice-role">Parent of Grade 5 Learner</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="voice-card">
                                <div class="voice-quote-icon">“</div>
                                <p class="voice-text">
                                    "Our pedagogical approach is rooted in fostering fearless curiosity. Whether a child is solving an advanced algebra equation or choreographing a contemporary dance piece, we celebrate their unique spark."
                                </p>
                                <div class="voice-author">
                                    <div class="voice-avatar" style="background:#0284c7;">SM</div>
                                    <div>
                                        <div class="voice-name">Sowmya Murthy</div>
                                        <div class="voice-role">Lead Academic Coordinator</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        @include('frontend.layout.footer')

        <!-- Floating Back to Top Button -->
        <button type="button" class="btn-floating-top" id="backToTop" aria-label="Back to top">
            <i data-lucide="arrow-up" style="width:20px;height:20px;"></i>
        </button>

    </div>

    <!-- ================= VIDEO MODAL ================= -->
    <div id="videoModal" class="modal-custom" role="dialog" aria-modal="true" aria-label="School Video Tour">
        <div class="modal-custom-dialog">
            <button type="button" class="modal-close-btn" id="closeVideoBtn" aria-label="Close video">
                <i data-lucide="x" style="width:20px;height:20px;"></i>
            </button>
            <div class="video-wrapper">
                <iframe id="videoPlayerFrame" src="" title="School Video Tour" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- ================= LIGHTBOX MODAL ================= -->
    <div id="lightboxModal" class="modal-custom" role="dialog" aria-modal="true" aria-label="Photo Preview">
        <div class="modal-custom-dialog" style="max-width: 820px; background: #000;">
            <button type="button" class="modal-close-btn" id="closeLightboxBtn" aria-label="Close picture" style="background: rgba(255,255,255,0.8);">
                <i data-lucide="x" style="width:20px;height:20px;"></i>
            </button>
            <img src="" alt="" id="lightboxImg" class="lightbox-img-view">
            <div class="lightbox-caption">
                <h4 id="lightboxTitle" class="mb-1 text-navy fw-bold" style="color:var(--nps-deep-navy);"></h4>
                <p id="lightboxDesc" class="mb-0 text-muted small"></p>
            </div>
        </div>
    </div>

    <!-- ================= SCRIPTS ================= -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js"></script>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Back to Top button
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Pillar Tabs Switcher
        const pillarButtons = document.querySelectorAll('.pillar-tab-btn');
        const pillarPanes = document.querySelectorAll('.pillar-content-pane');

        pillarButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-tab');
                pillarButtons.forEach(b => b.classList.remove('active'));
                pillarPanes.forEach(p => p.classList.remove('active'));

                btn.classList.add('active');
                const targetPane = document.getElementById(targetId);
                if (targetPane) {
                    targetPane.classList.add('active');
                }
            });
        });

        // Gallery Filter Buttons
        const filterBtns = document.querySelectorAll('.gallery-filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');
                galleryItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = '';
                        item.classList.remove('d-none');
                        item.style.animation = 'galleryFadeIn 0.3s ease forwards';
                    } else {
                        item.style.display = 'none';
                        item.classList.add('d-none');
                    }
                });
            });
        });

        // Lightbox Functions (Globally Accessible)
        const lightboxModal = document.getElementById('lightboxModal');
        const lightboxImg = document.getElementById('lightboxImg');
        const lightboxTitle = document.getElementById('lightboxTitle');
        const lightboxDesc = document.getElementById('lightboxDesc');
        const closeLightboxBtn = document.getElementById('closeLightboxBtn');

        function openLightbox(imgSrc, title, desc) {
            if (!lightboxModal || !lightboxImg) return;
            lightboxImg.src = imgSrc;
            lightboxImg.alt = title || 'NPS KGL Campus Moment';
            if (lightboxTitle) lightboxTitle.textContent = title || '';
            if (lightboxDesc) lightboxDesc.textContent = desc || '';
            lightboxModal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }
        window.openLightbox = openLightbox;

        const closeLightbox = () => {
            if (!lightboxModal) return;
            lightboxModal.classList.remove('is-open');
            if (lightboxImg) lightboxImg.src = '';
            document.body.style.overflow = '';
        };
        window.closeLightbox = closeLightbox;

        if (closeLightboxBtn) {
            closeLightboxBtn.addEventListener('click', closeLightbox);
        }
        if (lightboxModal) {
            lightboxModal.addEventListener('click', (e) => {
                if (e.target === lightboxModal) closeLightbox();
            });
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && lightboxModal && lightboxModal.classList.contains('is-open')) {
                closeLightbox();
            }
        });

        // Video Modal
        const videoModal = document.getElementById('videoModal');
        const openVideoModalBtn = document.getElementById('openVideoModal');
        const closeVideoBtn = document.getElementById('closeVideoBtn');
        const videoPlayerFrame = document.getElementById('videoPlayerFrame');

        const openVideo = () => {
            // Sample school campus walkthrough video
            videoPlayerFrame.src = 'https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?autoplay=1';
            videoModal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        };

        const closeVideo = () => {
            videoPlayerFrame.src = '';
            videoModal.classList.remove('is-open');
            document.body.style.overflow = '';
        };

        if (openVideoModalBtn) openVideoModalBtn.addEventListener('click', openVideo);
        if (closeVideoBtn) closeVideoBtn.addEventListener('click', closeVideo);
        if (videoModal) {
            videoModal.addEventListener('click', (e) => {
                if (e.target === videoModal) closeVideo();
            });
        }

        // Escape key to close any modal
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (videoModal.classList.contains('is-open')) closeVideo();
                if (lightboxModal.classList.contains('is-open')) closeLightbox();
            }
        });
    </script>
</body>
</html>

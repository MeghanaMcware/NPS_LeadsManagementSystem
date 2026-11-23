<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#002d62">
    <title>Activities & Co-Curriculars | Sports, Cultural Arts, Labs & Clubs | NPS KGL</title>
    <meta name="description" content="Explore activities at National Public School Kempegowda Layout: Championship Sports, Cultural Performing Arts, Advanced STEM & Science Labs, Student Clubs & Leadership.">

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
            --nps-heading: "Playfair Display", Georgia, serif;
            --nps-body: "Lato", Arial, sans-serif;
            --nps-hand: "Lato", Arial, sans-serif;
            
            /* Category Accent Colors */
            --sports-color: #0284c7;
            --sports-bg: #e0f2fe;
            --cultural-color: #b91c1c;
            --cultural-bg: #fee2e2;
            --labs-color: #16a34a;
            --labs-bg: #dcfce7;
            --clubs-color: #9333ea;
            --clubs-bg: #f3e8ff;
        }

        * { box-sizing: border-box; }
        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        body {
            margin: 0;
            color: var(--nps-ink);
            background: #f6f8fb;
            font-family: var(--nps-body);
            font-size: 15px;
            line-height: 1.6;
            overflow-x: hidden;
            width: 100%;
        }

        a { color: inherit; text-decoration: none; }

        .page-shell {
            min-height: 100vh;
            margin: 0 auto;
            overflow-x: hidden;
            background: #fff;
            box-shadow: 0 0 30px rgba(0, 33, 71, 0.08);
        }

                /* SECTION STYLING */
        .section-pad {
            padding: 70px 24px;
        }

        .bg-light-alt {
            background: #f8fafc;
        }

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

        .section-title {
            font-family: var(--nps-heading);
            font-size: clamp(28px, 3.5vw, 40px);
            font-weight: 800;
            color: var(--nps-deep-navy);
            line-height: 1.25;
            margin: 10px 0;
        }

        .section-subtitle {
            color: var(--nps-muted);
            font-size: clamp(14px, 1.2vw, 16.5px);
            max-width: 760px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* HERO SECTION */
        .activities-hero {
            position: relative;
            padding: 70px 24px 85px;
            background-color: #0b1a36;
            background-image: 
                linear-gradient(90deg, #0b1a36 0%, rgba(11, 26, 54, 0.96) 42%, rgba(11, 26, 54, 0.72) 65%, rgba(11, 26, 54, 0.2) 85%, transparent 100%),
                url("{{ asset('images/activities-hero-dancers.png') }}");
            background-repeat: no-repeat;
            background-position: center right;
            background-size: cover;
            color: #fff;
            overflow: hidden;
            isolation: isolate;
        }

        .activities-hero::before {
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
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            backdrop-filter: blur(6px);
            margin-bottom: 16px;
        }

        .hero-headline {
            font-family: "Playfair Display", Georgia, serif;
            font-size: clamp(34px, 4.4vw, 54px);
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
            font-size: clamp(15px, 1.3vw, 17.5px);
            color: #dbeafe;
            max-width: 720px;
            line-height: 1.65;
            margin-bottom: 30px;
        }

        /* ================= OUR ACTIVITIES 8-CARD OVERVIEW SECTION ================= */
        .our-activities-section {
            background-color: #f8fafc;
            padding: 70px 0 80px;
            border-bottom: 1px solid #e2e8f0;
        }

        .our-activities-heading-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 12px;
            width: 100%;
        }

        .heading-gold-line {
            display: inline-block;
            width: clamp(40px, 10vw, 110px);
            height: 3.5px;
            background: #eab308;
            border-radius: 2px;
        }

        .our-activities-title {
            font-family: "Lato", Arial, sans-serif;
            font-size: clamp(28px, 3.2vw, 38px);
            font-weight: 800;
            color: #0b1a36;
            margin: 0;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .our-activities-subtitle {
            font-family: "Lato", Arial, sans-serif;
            font-size: clamp(14px, 1.2vw, 16px);
            color: #002d62;
            font-weight: 600;
            max-width: 680px;
            margin: 0 auto;
            line-height: 1.55;
            text-align: center;
        }

        /* TAB FILTER CONCEPT FOR OUR ACTIVITIES OVERVIEW */
        .our-activities-filter-wrap {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 28px auto 36px;
            max-width: 900px;
        }

        .our-activities-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 22px;
            border-radius: 25px;
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #475569;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: all 0.22s ease-in-out;
            user-select: none;
        }

        .our-activities-tab-btn:hover {
            border-color: #002d62;
            color: #002d62;
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 45, 98, 0.08);
        }

        .our-activities-tab-btn.active {
            background: #002147;
            color: #ffffff;
            border-color: #002147;
            box-shadow: 0 4px 14px rgba(0, 33, 71, 0.22);
        }

        .our-activities-tab-btn.active svg,
        .our-activities-tab-btn.active i {
            stroke: #f59e0b;
        }

        .our-activity-col {
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        /* CARD CONTAINER */
        .nps-activity-card {
            background: #ffffff;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: transform 0.28s ease, box-shadow 0.28s ease, border-color 0.28s ease;
        }

        .nps-activity-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(0, 33, 71, 0.12);
            border-color: #cbd5e1;
        }

        .activity-card-img-wrap {
            position: relative;
            width: 100%;
            height: 165px;
            overflow: visible;
            background: #0b1a36;
        }

        .activity-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-top-left-radius: 17px;
            border-top-right-radius: 17px;
            transition: transform 0.4s ease;
        }

        .nps-activity-card:hover .activity-card-img-wrap img {
            transform: scale(1.05);
        }

        /* CIRCULAR OVERLAPPING BADGE */
        .activity-icon-badge {
            position: absolute;
            left: 50%;
            bottom: -24px;
            transform: translateX(-50%);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #002d62;
            border: 3.5px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 33, 71, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            z-index: 5;
            transition: transform 0.25s ease, background 0.25s ease;
        }

        .activity-icon-badge svg {
            width: 22px;
            height: 22px;
        }

        .nps-activity-card:hover .activity-icon-badge {
            transform: translateX(-50%) scale(1.08);
            background: #0b1a36;
        }

        /* CARD BODY */
        .activity-card-body {
            padding: 34px 18px 22px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex-grow: 1;
        }

        .activity-card-title {
            font-family: "Lato", Arial, sans-serif;
            font-size: 16.5px;
            font-weight: 700;
            color: #002d62;
            margin: 0 0 8px 0;
            line-height: 1.3;
            min-height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .activity-card-desc {
            font-size: 13.5px;
            color: #475569;
            line-height: 1.45;
            margin: 0 0 16px 0;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .activity-card-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13.5px;
            font-weight: 700;
            color: #002d62;
            text-decoration: none;
            margin-top: auto;
            transition: gap 0.2s ease, color 0.2s ease;
        }

        .activity-card-link .arrow-icon {
            width: 15px;
            height: 15px;
            transition: transform 0.2s ease;
        }

        .activity-card-link:hover {
            color: #b45309;
        }

        .activity-card-link:hover .arrow-icon {
            transform: translateX(4px);
        }

        /* 8TH SPECIAL CARD: ACTIVITY PHOTO GALLERY */
        .nps-activity-gallery-card {
            background: linear-gradient(150deg, #edf4ff 0%, #e2edff 60%, #d8e6fe 100%);
            border-radius: 18px;
            border: 1px solid #bfdbfe;
            box-shadow: 0 4px 18px rgba(0, 45, 98, 0.08);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            min-height: 320px;
            padding: 30px 20px;
            text-align: center;
            transition: transform 0.28s ease, box-shadow 0.28s ease;
        }

        .nps-activity-gallery-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(0, 45, 98, 0.16);
        }

        .gallery-watermark {
            position: absolute;
            right: -15px;
            top: -15px;
            color: rgba(30, 64, 175, 0.07);
            pointer-events: none;
        }

        .gallery-watermark svg {
            width: 140px;
            height: 140px;
        }

        .gallery-card-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .gallery-star-badge {
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 10px rgba(245, 158, 11, 0.35));
            animation: starPulse 3s ease-in-out infinite;
        }

        @keyframes starPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }

        .gallery-card-title {
            font-family: "Lato", Arial, sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: #002d62;
            margin: 0 0 8px 0;
            line-height: 1.25;
        }

        .gallery-card-desc {
            font-size: 13.5px;
            color: #334155;
            line-height: 1.45;
            margin: 0 0 20px 0;
            max-width: 220px;
        }

        .btn-gallery-pill {
            background: #002d62;
            color: #ffffff;
            border-radius: 25px;
            padding: 10px 22px;
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(0, 45, 98, 0.25);
            transition: all 0.2s ease;
        }

        .btn-gallery-pill .arrow-icon {
            width: 15px;
            height: 15px;
            transition: transform 0.2s ease;
        }

        .btn-gallery-pill:hover {
            background: #0b1a36;
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(0, 45, 98, 0.35);
        }

        .btn-gallery-pill:hover .arrow-icon {
            transform: translateX(4px);
        }

        /* QUICK JUMP PILLS */
        .quick-nav-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }

        .quick-pill-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: #fff;
            font-size: 13.5px;
            font-weight: 700;
            backdrop-filter: blur(6px);
            transition: all 0.25s ease;
        }

        .quick-pill-btn:hover {
            background: var(--nps-gold);
            color: var(--nps-deep-navy);
            border-color: var(--nps-gold);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(251, 191, 36, 0.35);
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
            padding: 8px 10px;
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
            font-size: 12.5px;
            font-weight: 700;
            color: var(--nps-muted);
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        /* CATEGORY FEATURE CARD */
        .category-hero-card {
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(0, 33, 71, 0.08);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .category-hero-card:hover {
            box-shadow: 0 16px 36px rgba(0, 33, 71, 0.14);
            transform: translateY(-4px);
        }

        .category-hero-img-wrap {
            position: relative;
            height: 320px;
            overflow: hidden;
        }

        .category-hero-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .category-hero-card:hover .category-hero-img-wrap img {
            transform: scale(1.04);
        }

        .category-hero-badge {
            position: absolute;
            top: 18px;
            left: 18px;
            padding: 6px 16px;
            border-radius: 20px;
            color: #fff;
            font-weight: 800;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .05em;
            backdrop-filter: blur(6px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        }

        .badge-sports { background: linear-gradient(135deg, #0284c7, #0369a1); }
        .badge-cultural { background: linear-gradient(135deg, #b91c1c, #991b1b); }
        .badge-labs { background: linear-gradient(135deg, #16a34a, #15803d); }
        .badge-clubs { background: linear-gradient(135deg, #9333ea, #7e22ce); }

        .category-hero-body {
            padding: 30px;
        }

        .category-hero-title {
            font-family: var(--nps-heading);
            font-size: 26px;
            font-weight: 800;
            color: var(--nps-deep-navy);
            margin-bottom: 12px;
        }

        .category-hero-desc {
            color: var(--nps-muted);
            font-size: 15px;
            line-height: 1.65;
            margin-bottom: 24px;
        }

        /* GRID ITEM CARDS */
        .sub-activity-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 22px;
            height: 100%;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .sub-activity-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 24px rgba(0, 33, 71, 0.08);
            border-color: #cbd5e1;
        }

        .sub-activity-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .sub-title {
            font-family: var(--nps-heading);
            font-size: 18px;
            font-weight: 700;
            color: var(--nps-deep-navy);
            margin-bottom: 8px;
        }

        .sub-text {
            color: var(--nps-muted);
            font-size: 13.5px;
            line-height: 1.55;
            margin: 0;
        }

        /* LAB HIGHLIGHT CARDS */
        .lab-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 33, 71, 0.06);
            height: 100%;
            transition: all 0.3s ease;
        }

        .lab-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(0, 33, 71, 0.12);
        }

        .lab-img-header {
            position: relative;
            height: 160px;
            overflow: hidden;
        }

        .lab-img-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lab-card-body {
            padding: 22px;
        }

        .lab-tag {
            color: #16a34a;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            display: inline-block;
            margin-bottom: 4px;
        }

        .lab-title {
            font-family: var(--nps-heading);
            font-size: 19px;
            font-weight: 700;
            color: var(--nps-deep-navy);
            margin-bottom: 8px;
        }

        .lab-feature-list {
            list-style: none;
            padding: 0;
            margin: 12px 0 0;
        }

        .lab-feature-list li {
            position: relative;
            padding-left: 20px;
            font-size: 13px;
            color: #475569;
            margin-bottom: 6px;
        }

        .lab-feature-list li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #16a34a;
            font-weight: bold;
        }

        /* FILTERABLE GALLERY */
        .gallery-filter-wrap {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
            margin: 28px 0 32px;
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
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        
        /* ================= ENHANCED GALLERY SLIDER LIGHTBOX ================= */
        .gallery-modal-overlay {
            position: fixed !important;
            inset: 0 !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            background: rgba(8, 18, 38, 0.95) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 9999999 !important;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
            padding: 16px;
        }

        .gallery-modal-overlay.is-open {
            display: flex !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        .gallery-modal-container {
            position: relative;
            width: 100%;
            max-width: 1060px;
            max-height: 94vh;
            background: #0d1e3d;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.65);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform: scale(0.96);
            transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gallery-modal-overlay.is-open .gallery-modal-container {
            transform: scale(1);
        }

        /* MODAL HEADER */
        .gallery-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 22px;
            background: #09172f;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .modal-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .gallery-modal-category-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 4px 12px;
            border-radius: 20px;
            background: #f59e0b;
            color: #0b1a36;
        }

        .gallery-modal-counter {
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
        }

        .gallery-modal-close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .gallery-modal-close-btn:hover {
            background: #ef4444;
            color: #ffffff;
            transform: rotate(90deg);
        }

        /* MAIN STAGE WITH SLIDER */
        .gallery-modal-stage {
            position: relative;
            width: 100%;
            height: 50vh;
            min-height: 280px;
            max-height: 520px;
            background: #050d1a;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .gallery-main-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            transition: opacity 0.22s ease, transform 0.22s ease;
            user-select: none;
        }

        .gallery-main-image.fade-out {
            opacity: 0;
            transform: scale(0.98);
        }

        /* NAV BUTTONS (NEXT / PREV) */
        .gallery-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: rgba(11, 26, 54, 0.85);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s ease;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.5);
        }

        .gallery-nav-btn:hover {
            background: #f59e0b;
            color: #0b1a36;
            border-color: #f59e0b;
            transform: translateY(-50%) scale(1.1);
        }

        .gallery-nav-prev {
            left: 14px;
        }

        .gallery-nav-next {
            right: 14px;
        }

        /* CAPTION AREA */
        .gallery-modal-caption {
            padding: 14px 22px 10px;
            background: #0d1e3d;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .gallery-modal-title {
            font-family: "Lato", Arial, sans-serif;
            font-size: 17.5px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 4px 0;
        }

        .gallery-modal-desc {
            font-size: 13.5px;
            color: #cbd5e1;
            margin: 0;
            line-height: 1.45;
        }

        /* HORIZONTAL SCROLLABLE THUMBNAIL STRIP */
        .gallery-modal-thumbs-wrap {
            padding: 12px 20px 16px;
            background: #081429;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .gallery-thumbs-label {
            font-size: 11.5px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .gallery-thumbs-scroll {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 4px 2px 8px;
            scrollbar-width: thin;
            scrollbar-color: #f59e0b rgba(255, 255, 255, 0.1);
        }

        .gallery-thumbs-scroll::-webkit-scrollbar {
            height: 6px;
        }

        .gallery-thumbs-scroll::-webkit-scrollbar-thumb {
            background: #f59e0b;
            border-radius: 4px;
        }

        .gallery-thumb-item {
            flex: 0 0 88px;
            height: 58px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            opacity: 0.55;
            transition: all 0.2s ease;
            background: #000;
        }

        .gallery-thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .gallery-thumb-item:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .gallery-thumb-item.active {
            border-color: #f59e0b;
            opacity: 1;
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.6);
            transform: scale(1.05);
        }
        .gallery-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0, 33, 71, 0.08);
            border: 1px solid #e2e8f0;
            height: 290px;
            cursor: pointer;
            margin-bottom: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            user-select: none;
            -webkit-user-select: none;
        }

        .gallery-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 36px rgba(0, 33, 71, 0.22);
        }

        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .gallery-card:hover .gallery-img {
            transform: scale(1.06);
        }

        .gallery-count-pill {
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(0, 20, 50, 0.7);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            z-index: 3;
            pointer-events: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.35);
        }

        /* TEXT OVERLAY POSITIONED AT THE TOP OF THE IMAGE */
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(180deg, rgba(3, 18, 43, 0.94) 0%, rgba(3, 18, 43, 0.72) 48%, rgba(3, 18, 43, 0.2) 80%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 14px 16px 36px 16px;
            color: #ffffff !important;
            pointer-events: none;
            z-index: 2;
        }

        .gallery-category-badge {
            align-self: flex-start;
            background: #f59e0b;
            color: #002147 !important;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 3px 9px;
            border-radius: 4px;
            margin-bottom: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .badge-sports {
            background: #f59e0b !important;
            color: #0b1a36 !important;
        }
        .badge-cultural {
            background: #ef4444 !important;
            color: #ffffff !important;
        }
        .badge-labs {
            background: #10b981 !important;
            color: #ffffff !important;
        }
        .badge-clubs {
            background: #a855f7 !important;
            color: #ffffff !important;
        }

        .gallery-card-title {
            font-family: "Lato", Arial, sans-serif !important;
            font-size: 15.5px !important;
            font-weight: 700 !important;
            margin: 0 !important;
            line-height: 1.3 !important;
            color: #ffffff !important; /* PURE CRISP WHITE */
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.9);
        }

        .gallery-card-desc {
            font-family: "Lato", Arial, sans-serif !important;
            font-size: 12px !important;
            color: rgba(255, 255, 255, 0.92) !important; /* HIGH CONTRAST WHITE */
            line-height: 1.35 !important;
            margin-top: 4px !important;
            margin-bottom: 0 !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.9);
        }

        .gallery-card-action {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.94);
            color: #002147;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.28);
            z-index: 3;
            pointer-events: none;
            transition: all 0.25s ease;
        }

        .gallery-card:hover .gallery-card-action {
            background: #f59e0b;
            color: #002147;
            transform: scale(1.05);
        }

        /* SCHEDULE TABLE CARD */
        .schedule-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 33, 71, 0.06);
        }

        .schedule-item {
            padding: 14px 18px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* CTA BANNER */
        .cta-banner-section {
            background: linear-gradient(135deg, #001f44 0%, #002d62 100%);
            color: #fff;
            padding: 60px 24px;
            position: relative;
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

        /* MODAL */
        .modal-custom {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 20, 48, 0.8);
            backdrop-filter: blur(5px);
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
            max-width: 800px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .modal-close-btn {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.8);
            border: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            cursor: pointer;
            z-index: 10;
        }

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

        /* RESPONSIVE */
        @media (max-width: 991.98px) {
            .stat-num { font-size: 26px; }
            .category-hero-img-wrap { height: 240px; }
            .our-activities-filter-wrap { max-width: 100%; }
        }

        @media (max-width: 767.98px) {
            .page-shell {
                overflow-x: hidden;
            }
            
            .activities-hero { 
                padding: 32px 16px 45px; 
                background-position: right center;
                background-image: 
                    linear-gradient(90deg, #0b1a36 0%, rgba(11, 26, 54, 0.96) 60%, rgba(11, 26, 54, 0.85) 100%),
                    url("{{ asset('images/activities-hero-dancers.png') }}");
            }
            .hero-headline {
                font-size: clamp(26px, 7vw, 36px);
                line-height: 1.2;
            }
            .hero-lead {
                font-size: 13.5px;
                line-height: 1.55;
            }

            .quick-nav-pills {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 14px;
            }
            .quick-pill-btn {
                padding: 8px 14px;
                font-size: 12.5px;
                gap: 6px;
            }

            .our-activities-section {
                padding: 40px 16px 45px;
            }
            .our-activities-title {
                font-size: clamp(22px, 6vw, 28px);
            }
            .our-activities-subtitle {
                font-size: 13px;
                line-height: 1.5;
            }
            .our-activities-filter-wrap {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
                margin: 18px auto 26px;
            }
            .our-activities-tab-btn {
                padding: 7px 14px;
                font-size: 12.5px;
                gap: 6px;
            }

            .nps-activity-card {
                border-radius: 16px;
            }
            .activity-card-img-wrap {
                height: 165px;
            }
            .activity-icon-badge {
                width: 44px;
                height: 44px;
                bottom: -22px;
            }
            .activity-icon-badge svg {
                width: 19px;
                height: 19px;
            }
            .activity-card-body {
                padding: 28px 16px 18px;
            }
            .activity-card-title {
                font-size: 17px;
            }
            .activity-card-desc {
                font-size: 13px;
                line-height: 1.5;
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

            .category-hero-card {
                border-radius: 14px;
                margin-bottom: 22px;
            }
            .category-hero-img-wrap {
                height: 190px;
            }
            .category-hero-body {
                padding: 18px 16px;
            }
            .category-hero-title {
                font-size: 19px;
            }
            .category-hero-desc {
                font-size: 13px;
                line-height: 1.5;
            }

            .sub-activity-card {
                padding: 18px 16px;
                border-radius: 14px;
            }
            .sub-title {
                font-size: 17px;
            }
            .sub-text {
                font-size: 13px;
            }

            .lab-card {
                border-radius: 14px;
            }
            .lab-img-header {
                height: 150px;
            }
            .lab-card-body {
                padding: 16px;
            }
            .lab-title {
                font-size: 17px;
            }

            .gallery-modal-overlay {
                padding: 8px;
            }
            .gallery-modal-container {
                max-height: 96vh;
                border-radius: 14px;
            }
            .gallery-modal-header {
                padding: 10px 14px;
            }
            .gallery-modal-stage {
                height: 38vh;
            }
            .gallery-nav-btn {
                width: 36px;
                height: 36px;
            }
            .gallery-modal-caption {
                padding: 10px 14px;
            }
            .gallery-modal-title {
                font-size: 15.5px;
            }
            .gallery-modal-desc {
                font-size: 12.5px;
            }
            .gallery-modal-thumbs-wrap {
                padding: 8px 12px 10px;
            }
            .gallery-thumb {
                width: 58px;
                height: 44px;
                border-radius: 6px;
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
            .quick-pill-btn {
                width: 100%;
                justify-content: center;
            }
            .gallery-modal-stage {
                height: 32vh;
            }
            .category-hero-img-wrap {
                height: 175px;
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
            <section class="activities-hero">
                <div class="container position-relative" style="z-index: 2;">
                    <div class="row align-items-center">
                        <div class="col-lg-7 col-xl-7">
                           
                            <h1 class="hero-headline">
                                Activities at <span>NPS Kempegowda Layout</span>
                            </h1>
                            <p class="hero-lead">
                                Education at NPS KGL thrives in motion, melody, scientific inquiry, and purposeful leadership. Explore our sports academies, vibrant cultural arts, cutting-edge STEM laboratories, and student-driven societies.
                            </p>

                            <!-- Quick Navigation Pills -->
                            <div class="quick-nav-pills">
                                <a href="#sports-section" class="quick-pill-btn">
                                    <i data-lucide="trophy" style="width:16px;height:16px;"></i> Sports &amp; Athletics
                                </a>
                                <a href="#cultural-section" class="quick-pill-btn">
                                    <i data-lucide="music" style="width:16px;height:16px;"></i> Cultural &amp; Fine Arts
                                </a>
                                <a href="#labs-section" class="quick-pill-btn">
                                    <i data-lucide="microscope" style="width:16px;height:16px;"></i> Advanced Labs &amp; STEM
                                </a>
                                <a href="#clubs-section" class="quick-pill-btn">
                                    <i data-lucide="users" style="width:16px;height:16px;"></i> Clubs &amp; Leadership
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

          

            <!-- ================= OUR ACTIVITIES 8-CARD OVERVIEW SECTION ================= -->
            <section class="section-pad our-activities-section" id="our-activities-overview">
                <div class="container">
                    <!-- Section Header -->
                    <div class="text-center mb-5">
                        <div class="our-activities-heading-wrap">
                            <span class="heading-gold-line" aria-hidden="true"></span>
                            <h2 class="our-activities-title">Our Activities</h2>
                            <span class="heading-gold-line" aria-hidden="true"></span>
                        </div>
                        <p class="our-activities-subtitle">
                            A diverse range of activities to help every student discover their talents and build new skills.
                        </p>
                    </div>

                    <!-- Category Filter Tabs for Our Activities -->
                    <div class="our-activities-filter-wrap" role="tablist" aria-label="Activity Categories">
                        <button type="button" class="our-activities-tab-btn active" data-tab-category="all" onclick="filterOurActivities('all', this)">
                            <i data-lucide="layout-grid" style="width:15px;height:15px;"></i> All Activities
                        </button>
                        <button type="button" class="our-activities-tab-btn" data-tab-category="sports" onclick="filterOurActivities('sports', this)">
                            <i data-lucide="trophy" style="width:15px;height:15px;"></i> Sports &amp; Games
                        </button>
                        <button type="button" class="our-activities-tab-btn" data-tab-category="cultural" onclick="filterOurActivities('cultural', this)">
                            <i data-lucide="sparkles" style="width:15px;height:15px;"></i> Cultural &amp; Arts
                        </button>
                        <button type="button" class="our-activities-tab-btn" data-tab-category="science" onclick="filterOurActivities('science', this)">
                            <i data-lucide="atom" style="width:15px;height:15px;"></i> Science &amp; Labs
                        </button>
                        <button type="button" class="our-activities-tab-btn" data-tab-category="events" onclick="filterOurActivities('events', this)">
                            <i data-lucide="calendar" style="width:15px;height:15px;"></i> Events &amp; Trips
                        </button>
                    </div>

                    <!-- 8-Card Grid -->
                    <div class="row g-4 justify-content-center" id="ourActivitiesGrid">
                        <!-- 1. Co-curricular Activities -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="science">
                            <div class="nps-activity-card">
                                <div class="activity-card-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG_0447.jpg') }}" alt="Co-curricular Activities" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG_0447.webp') }}'">
                                    <div class="activity-icon-badge" aria-hidden="true">
                                        <i data-lucide="flask-conical"></i>
                                    </div>
                                </div>
                                <div class="activity-card-body">
                                    <h3 class="activity-card-title">Co-curricular Activities</h3>
                                    <p class="activity-card-desc">Enhance your learning beyond the classroom.</p>
                                    <a href="#labs-section" class="activity-card-link">
                                        Know More <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Cultural Activities -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="cultural">
                            <div class="nps-activity-card">
                                <div class="activity-card-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0113.jpg') }}" alt="Cultural Activities" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0113.webp') }}'">
                                    <div class="activity-icon-badge" aria-hidden="true">
                                        <i data-lucide="drama"></i>
                                    </div>
                                </div>
                                <div class="activity-card-body">
                                    <h3 class="activity-card-title">Cultural Activities</h3>
                                    <p class="activity-card-desc">Celebrate our traditions and showcase your talent.</p>
                                    <a href="#cultural-section" class="activity-card-link">
                                        Know More <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Sports and Games -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="sports">
                            <div class="nps-activity-card">
                                <div class="activity-card-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9401.JPG') }}" alt="Sports and Games" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9401.webp') }}'">
                                    <div class="activity-icon-badge" aria-hidden="true">
                                        <i data-lucide="dribbble"></i>
                                    </div>
                                </div>
                                <div class="activity-card-body">
                                    <h3 class="activity-card-title">Sports and Games</h3>
                                    <p class="activity-card-desc">Play, compete and stay fit.</p>
                                    <a href="#sports-section" class="activity-card-link">
                                        Know More <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Art, Music and Dance -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="cultural">
                            <div class="nps-activity-card">
                                <div class="activity-card-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0013.jpg') }}" alt="Art, Music and Dance" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0013.webp') }}'">
                                    <div class="activity-icon-badge" aria-hidden="true">
                                        <i data-lucide="palette"></i>
                                    </div>
                                </div>
                                <div class="activity-card-body">
                                    <h3 class="activity-card-title">Art, Music and Dance</h3>
                                    <p class="activity-card-desc">Unleash your creativity.</p>
                                    <a href="#cultural-section" class="activity-card-link">
                                        Know More <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Science and Innovation -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="science">
                            <div class="nps-activity-card">
                                <div class="activity-card-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9664.JPG') }}" alt="Science and Innovation" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9664.webp') }}'">
                                    <div class="activity-icon-badge" aria-hidden="true">
                                        <i data-lucide="atom"></i>
                                    </div>
                                </div>
                                <div class="activity-card-body">
                                    <h3 class="activity-card-title">Science and Innovation</h3>
                                    <p class="activity-card-desc">Innovate. Experiment. Grow.</p>
                                    <a href="#labs-section" class="activity-card-link">
                                        Know More <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Educational Trips and Excursions -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="events">
                            <div class="nps-activity-card">
                                <div class="activity-card-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9379.JPG') }}" alt="Educational Trips and Excursions" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9379.webp') }}'">
                                    <div class="activity-icon-badge" aria-hidden="true">
                                        <i data-lucide="bus"></i>
                                    </div>
                                </div>
                                <div class="activity-card-body">
                                    <h3 class="activity-card-title">Educational Trips and Excursions</h3>
                                    <p class="activity-card-desc">Explore, Learn and Discover.</p>
                                    <a href="#clubs-section" class="activity-card-link">
                                        Know More <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Events and Celebrations -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="events">
                            <div class="nps-activity-card">
                                <div class="activity-card-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0125.jpg') }}" alt="Events and Celebrations" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0125.webp') }}'">
                                    <div class="activity-icon-badge" aria-hidden="true">
                                        <i data-lucide="calendar-heart"></i>
                                    </div>
                                </div>
                                <div class="activity-card-body">
                                    <h3 class="activity-card-title">Events and Celebrations</h3>
                                    <p class="activity-card-desc">Be a part of our joyful celebrations.</p>
                                    <a href="#schedule-section" class="activity-card-link">
                                        Know More <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Activity Photo Gallery -->
                        <div class="col-12 col-sm-6 col-lg-3 our-activity-col" data-category="all">
                            <div class="nps-activity-gallery-card">
                                <div class="gallery-watermark" aria-hidden="true">
                                    <i data-lucide="camera"></i>
                                </div>
                                <div class="gallery-card-content">
                                    <div class="gallery-star-badge" aria-hidden="true">
                                        <svg width="56" height="56" viewBox="0 0 24 24" fill="#fbbf24" stroke="#f59e0b" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                        </svg>
                                    </div>
                                    <h3 class="gallery-card-title">Activity Photo Gallery</h3>
                                    <p class="gallery-card-desc">Relive the best moments at NPSKGL.</p>
                                    <a href="#gallery-section" class="btn-gallery-pill">
                                        View Gallery <i data-lucide="arrow-right" class="arrow-icon"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            

            <!-- ================= 1. SPORTS & ATHLETIC ACTIVITIES ================= -->
            <section class="section-pad" id="sports-section">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="section-kicker" style="background:var(--sports-bg); color:var(--sports-color);">
                            <i data-lucide="dribbble" style="width:14px;height:14px;"></i> Sports Excellence
                        </span>
                        <h2 class="section-title">Sports &amp; Physical Mastery</h2>
                        <p class="section-subtitle">
                            Instilling lifelong fitness, mental resilience, fair play, and championship teamwork through professional training arenas and certified coaches.
                        </p>
                    </div>

                    <!-- Category Featured Card -->
                    <div class="category-hero-card">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6">
                                <div class="category-hero-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9401.JPG') }}" alt="NPS KGL Basketball Championship" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9401.webp') }}'">
                                    <span class="category-hero-badge badge-sports">Arena Highlight</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="category-hero-body">
                                    <h3 class="category-hero-title">Championship Sports Infrastructure</h3>
                                    <p class="category-hero-desc">
                                        At NPS Kempegowda Layout, sports are an indispensable pillar of character building. Every student undergoes structured physical literacy, developing agility, spatial intelligence, and leadership from Kindergarten through Grade 9.
                                    </p>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-primary" style="width:16px;height:16px;"></i> FIBA Standard Basketball Court
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-primary" style="width:16px;height:16px;"></i> High-Density Football Turf
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-primary" style="width:16px;height:16px;"></i> Cricket Practice Nets &amp; Pitch
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-primary" style="width:16px;height:16px;"></i> Indoor Badminton &amp; Table Tennis
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </section>

            <!-- ================= 2. CULTURAL & PERFORMING ARTS ================= -->
            <section class="section-pad bg-light-alt" id="cultural-section">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="section-kicker" style="background:var(--cultural-bg); color:var(--cultural-color);">
                            <i data-lucide="palette" style="width:14px;height:14px;"></i> Creative Arts
                        </span>
                        <h2 class="section-title">Cultural &amp; Performing Arts</h2>
                        <p class="section-subtitle">
                            Giving wings to imagination, aesthetic sensitivity, theatrical boldness, and musical harmony through rich artistic disciplines.
                        </p>
                    </div>

                    <!-- Category Featured Card -->
                    <div class="category-hero-card">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6 order-lg-2">
                                <div class="category-hero-img-wrap">
                                    <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0113.jpg') }}" alt="NPS KGL Bharatanatyam Stage Performance" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0113.webp') }}'">
                                    <span class="category-hero-badge badge-cultural">Stage &amp; Symphony</span>
                                </div>
                            </div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="category-hero-body">
                                    <h3 class="category-hero-title">A Symphony of Stage &amp; Imagination</h3>
                                    <p class="category-hero-desc">
                                        Arts at NPS KGL are not mere hobbies—they are powerful mediums of self-discovery and confidence. With dedicated acoustic music rooms, a mirrored dance conservatory, and our open-air amphitheatre, students command the spotlight.
                                    </p>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-danger" style="width:16px;height:16px;"></i> Classical &amp; Western Music
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-danger" style="width:16px;height:16px;"></i> Theatrical &amp; Dramatic Arts
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-danger" style="width:16px;height:16px;"></i> Bharatanatyam &amp; Folk Dance
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center gap-2 text-navy fw-bold small">
                                                <i data-lucide="check" class="text-danger" style="width:16px;height:16px;"></i> Fine Arts, Pottery &amp; Sculpting
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </section>

            <!-- ================= 3. ADVANCED LABS & STEM INNOVATION ================= -->
            <section class="section-pad" id="labs-section">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="section-kicker" style="background:var(--labs-bg); color:var(--labs-color);">
                            <i data-lucide="flask-conical" style="width:14px;height:14px;"></i> Empirical Discovery
                        </span>
                        <h2 class="section-title">World-Class Laboratories &amp; STEM</h2>
                        <p class="section-subtitle">
                            Transforming theoretical principles into empirical insight through safe, fully-equipped experimental stations guided by expert science educators.
                        </p>
                    </div>

                    <!-- 5 Labs Showcase Grid -->
                    <div class="row g-4">
                        <!-- Lab 1: Biology & Life Sciences -->
                        <div class="col-md-6 col-lg-4">
                            <div class="lab-card">
                                <div class="lab-img-header">
                                    <img src="{{ asset('images/NPS PFWEB/IMG_0436.jpg') }}" alt="NPS KGL Biology &amp; Anatomy Lab" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG_0436.webp') }}'">
                                </div>
                                <div class="lab-card-body">
                                    <span class="lab-tag">Life Sciences</span>
                                    <h4 class="lab-title">Biology &amp; Anatomy Lab</h4>
                                    <p class="text-muted small">
                                        Equipped with binocular compound microscopes, human anatomical torsos, preserved botanical specimens, and microtomes.
                                    </p>
                                    <ul class="lab-feature-list">
                                        <li>High-resolution magnification optics</li>
                                        <li>Specimen slide preparation counters</li>
                                        <li>Cellular &amp; plant anatomy kits</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Lab 2: Robotics & AI Studio -->
                        <div class="col-md-6 col-lg-4">
                            <div class="lab-card">
                                <div class="lab-img-header">
                                    <img src="{{ asset('images/event-science-fair.jpg') }}" alt="Robotics Lab">
                                </div>
                                <div class="lab-card-body">
                                    <span class="lab-tag" style="color:#0284c7;">Future Tech</span>
                                    <h4 class="lab-title">Robotics, AI &amp; Coding Lab</h4>
                                    <p class="text-muted small">
                                        A high-tech innovation sandbox for robotics kits, microcontrollers, sensor integration, Python and Scratch coding blocks.
                                    </p>
                                    <ul class="lab-feature-list">
                                        <li>Arduino &amp; Raspberry Pi kits</li>
                                        <li>Robotic arm &amp; obstacle avoidance buggies</li>
                                        <li>Computational logic &amp; algorithms</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Lab 3: Physics Laboratory -->
                        <div class="col-md-6 col-lg-4">
                            <div class="lab-card">
                                <div class="lab-img-header">
                                    <img src="{{ asset('images/academic-microscope.png') }}" alt="Physics Lab" onerror="this.src='{{ asset('images/about-campus.jpg') }}'">
                                </div>
                                <div class="lab-card-body">
                                    <span class="lab-tag" style="color:#b45309;">Applied Sciences</span>
                                    <h4 class="lab-title">Physics &amp; Mechanics Lab</h4>
                                    <p class="text-muted small">
                                        Exploring optical prisms, lenses, resistance boards, electrical circuitry, sonometer waves, and gravitational acceleration.
                                    </p>
                                    <ul class="lab-feature-list">
                                        <li>Precision vernier calipers &amp; screw gauges</li>
                                        <li>Spectrometer &amp; ray-optics apparatus</li>
                                        <li>Circuit building &amp; Wheatstone bridges</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Lab 4: Chemistry Laboratory -->
                        <div class="col-md-6 col-lg-6">
                            <div class="lab-card">
                                <div class="lab-img-header" style="height:190px;">
                                    <img src="{{ asset('images/NPS PFWEB/IMG_0450.jpg') }}" alt="Chemistry &amp; Solutions Lab" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG_0450.webp') }}'" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="lab-card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="sub-activity-icon mb-0" style="background:#fee2e2; color:#b91c1c;">
                                            <i data-lucide="test-tube"></i>
                                        </div>
                                        <div>
                                            <span class="lab-tag">Chemical Sciences</span>
                                            <h4 class="lab-title mb-0">Chemistry &amp; Solutions Lab</h4>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        Designed with dedicated chemical exhaust fume hoods, anti-corrosive granite workbenches, eye-wash stations, and safe reagent storage. Students master acid-base titrations, salt analysis, crystallization, and chemical equilibrium.
                                    </p>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <span class="small text-navy fw-bold">✓ Analytical digital balances</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="small text-navy fw-bold">✓ Flame test &amp; gas collection hoods</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lab 5: Mathematics & Logic Hub -->
                        <div class="col-md-6 col-lg-6">
                            <div class="lab-card">
                                <div class="lab-img-header" style="height:190px;">
                                    <img src="{{ asset('images/NPS PFWEB/DSC_9555.JPG') }}" alt="Mathematics &amp; Cognitive Studio" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9555.webp') }}'" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="lab-card-body">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="sub-activity-icon mb-0" style="background:#f3e8ff; color:#7e22ce;">
                                            <i data-lucide="calculator"></i>
                                        </div>
                                        <div>
                                            <span class="lab-tag" style="color:#7e22ce;">Logical Reasoning</span>
                                            <h4 class="lab-title mb-0">Mathematics &amp; Abacus Studio</h4>
                                        </div>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        Demystifying abstract math through concrete manipulatives, 3D geometric nets, tangrams, algebra tiles, and Vedic math techniques. Students build mental calculation agility, spatial reasoning, and probability analysis.
                                    </p>
                                    <div class="row g-2">
                                        <div class="col-sm-6">
                                            <span class="small text-navy fw-bold">✓ 3D Geometric solid models</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <span class="small text-navy fw-bold">✓ Olympiad training materials</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= 4. CLUBS & OTHER ENRICHMENT ACTIVITIES ================= -->
            <section class="section-pad bg-light-alt" id="clubs-section">
                <div class="container">
                    <div class="text-center mb-5">
                        <span class="section-kicker" style="background:var(--clubs-bg); color:var(--clubs-color);">
                            <i data-lucide="users" style="width:14px;height:14px;"></i> Co-Curricular Guilds
                        </span>
                        <h2 class="section-title">Student Clubs, Societies &amp; Outreach</h2>
                        <p class="section-subtitle">
                            Student-led communities that ignite personal passions, environmental consciousness, civic leadership, and global awareness.
                        </p>
                    </div>

                    <div class="row g-4">
                        <!-- Club 1: Eco-Warriors -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sub-activity-card">
                                <div class="sub-activity-icon" style="background:#dcfce7; color:#15803d;">
                                    <i data-lucide="sprout"></i>
                                </div>
                                <h4 class="sub-title">Eco-Warriors Green Guild</h4>
                                <p class="sub-text">
                                    Spearheading rainwater harvesting awareness, on-campus composting, sapling plantations, waste segregation, and local bird-nesting drives in Kempegowda Layout.
                                </p>
                            </div>
                        </div>

                        <!-- Club 2: Model United Nations -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sub-activity-card">
                                <div class="sub-activity-icon" style="background:#e0f2fe; color:#0284c7;">
                                    <i data-lucide="globe"></i>
                                </div>
                                <h4 class="sub-title">Model UN &amp; Orators' Society</h4>
                                <p class="sub-text">
                                    Mastering parliamentary debates, UN geopolitical protocol, diplomacy simulations, resolution drafting, and competitive inter-school oratory.
                                </p>
                            </div>
                        </div>

                        <!-- Club 3: Literary Guild -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sub-activity-card">
                                <div class="sub-activity-icon" style="background:#fee2e2; color:#b91c1c;">
                                    <i data-lucide="book-open"></i>
                                </div>
                                <h4 class="sub-title">Literary &amp; Editorial Board</h4>
                                <p class="sub-text">
                                    Publishing the quarterly campus magazine, authoring student blogs, organizing poetry slams, spelling bees, and interviewing guest authors.
                                </p>
                            </div>
                        </div>

                        <!-- Club 4: Quiz & Heritage -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sub-activity-card">
                                <div class="sub-activity-icon" style="background:#fef3c7; color:#b45309;">
                                    <i data-lucide="award"></i>
                                </div>
                                <h4 class="sub-title">Heritage &amp; Quiz Guild</h4>
                                <p class="sub-text">
                                    Deep dives into Indian and world history, general knowledge buzzer bowls, scientific trivia tournaments, and heritage monument walkthroughs.
                                </p>
                            </div>
                        </div>

                        <!-- Club 5: Community Care (SEVA) -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sub-activity-card">
                                <div class="sub-activity-icon" style="background:#f3e8ff; color:#7e22ce;">
                                    <i data-lucide="heart-handshake"></i>
                                </div>
                                <h4 class="sub-title">SEVA Community Outreach</h4>
                                <p class="sub-text">
                                    Fostering social empathy through book donation drives, peer tutoring for underprivileged learners, and visits to nearby senior care communities.
                                </p>
                            </div>
                        </div>

                        <!-- Club 6: Astronomy & Space Club -->
                        <div class="col-md-6 col-lg-4">
                            <div class="sub-activity-card">
                                <div class="sub-activity-icon" style="background:#ccfbf1; color:#0f766e;">
                                    <i data-lucide="telescope"></i>
                                </div>
                                <h4 class="sub-title">Astronomy &amp; Space Club</h4>
                                <p class="sub-text">
                                    Night-sky star gazing nights with refracting telescopes, lunar phase tracking, constellation mapping, and model rocket telemetry launches.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ================= 5. INTERACTIVE ACTIVITIES GALLERY ================= -->
            <section class="section-pad" id="gallery-section">
                <div class="container">
                    <div class="text-center mb-3">
                        <span class="section-kicker"><i data-lucide="camera" style="width:14px;height:14px;"></i> In Action</span>
                        <h2 class="section-title">Activities Showcase Gallery</h2>
                        <p class="section-subtitle">
                            Take a visual journey through our sports clashes, lab explorations, stage performances, and club initiatives.
                        </p>
                    </div>

                    

                    <!-- Gallery Cards Grid (One distinct collection card per activity) -->
                    <div class="row g-4 justify-content-center" id="galleryGrid">
                        <!-- 1. Sports & Athletics Arena -->
                        <div class="col-12 col-sm-6 col-lg-3 gallery-item" data-category="sports">
                            <div class="gallery-card" 
                                 onclick="openCategoryAlbum('sports')" 
                                 data-category-target="sports"
                                 title="Sports and Athletics">
                                <img src="{{ asset('images/NPS PFWEB/DSC_9401.JPG') }}" alt="Sports and Games" class="gallery-img" onerror="this.src='{{ asset('images/NPS_PFWEB_web/DSC_9401.webp') }}'">
                                <div class="gallery-overlay">
                                    <span class="gallery-category-badge badge-sports">Sports &amp; Games</span>
                                    <h4 class="gallery-card-title">Sports &amp; Athletics</h4>
                                    <p class="gallery-card-desc">Basketball, football turf agility, carrom, chess &amp; yoga</p>
                                </div>
                                <span class="gallery-card-action"><i data-lucide="eye" style="width:13px;height:13px;"></i> View</span>
                            </div>
                        </div>

                        <!-- 2. Cultural & Performing Arts -->
                        <div class="col-12 col-sm-6 col-lg-3 gallery-item" data-category="cultural">
                            <div class="gallery-card" 
                                 onclick="openCategoryAlbum('cultural')" 
                                 data-category-target="cultural"
                                 title="Cultural and Performing Arts">
                                <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0113.jpg') }}" alt="Cultural Arts" class="gallery-img" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0113.webp') }}'">
                                <div class="gallery-overlay">
                                    <span class="gallery-category-badge badge-cultural">Cultural Arts</span>
                                    <h4 class="gallery-card-title">Cultural &amp; Fine Arts</h4>
                                    <p class="gallery-card-desc">Classical Bharatanatyam, theatre, mono-acting &amp; craft</p>
                                </div>
                                <span class="gallery-card-action"><i data-lucide="eye" style="width:13px;height:13px;"></i> View</span>
                            </div>
                        </div>

                        <!-- 3. Science & World-Class Labs -->
                        <div class="col-12 col-sm-6 col-lg-3 gallery-item" data-category="labs">
                            <div class="gallery-card" 
                                 onclick="openCategoryAlbum('labs')" 
                                 data-category-target="labs"
                                 title="Science and Labs">
                                <img src="{{ asset('images/NPS PFWEB/IMG_0450.jpg') }}" alt="Science and Labs" class="gallery-img" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG_0450.webp') }}'">
                                <div class="gallery-overlay">
                                    <span class="gallery-category-badge badge-labs">Science &amp; Labs</span>
                                    <h4 class="gallery-card-title">World-Class STEM Labs</h4>
                                    <p class="gallery-card-desc">Chemical titration, anatomy skeleton, microscopy &amp; math</p>
                                </div>
                                <span class="gallery-card-action"><i data-lucide="eye" style="width:13px;height:13px;"></i> View</span>
                            </div>
                        </div>

                        <!-- 4. Clubs & Student Leadership -->
                        <div class="col-12 col-sm-6 col-lg-3 gallery-item" data-category="clubs">
                            <div class="gallery-card" 
                                 onclick="openCategoryAlbum('clubs')" 
                                 data-category-target="clubs"
                                 title="Clubs and Green Initiatives">
                                <img src="{{ asset('images/NPS PFWEB/IMG-20261106-WA0114.jpg') }}" alt="Clubs and Green" class="gallery-img" onerror="this.src='{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0114.webp') }}'">
                                <div class="gallery-overlay">
                                    <span class="gallery-category-badge badge-clubs">Clubs &amp; Green</span>
                                    <h4 class="gallery-card-title">Clubs &amp; Green Initiatives</h4>
                                    <p class="gallery-card-desc">Podium elocution guild, house assemblies &amp; eco-projects</p>
                                </div>
                                <span class="gallery-card-action"><i data-lucide="eye" style="width:13px;height:13px;"></i> View</span>
                            </div>
                        </div>
                    </div>
                </div><!-- /.container -->
            </section>

            

        
    <!-- Floating Back to Top Button -->
    <button type="button" id="backToTop" class="btn-floating-top" aria-label="Back to top">
        <i data-lucide="chevron-up" style="width:20px;height:20px;"></i>
    </button>
</main>
        @include('frontend.layout.footer')
</div>

<!-- ================= ENHANCED GALLERY SLIDER LIGHTBOX MODAL (Direct child of body) ================= -->
<div id="galleryModalOverlay" class="gallery-modal-overlay" role="dialog" aria-modal="true" aria-label="Activities Photo Viewer">
    <div class="gallery-modal-container">
        <!-- Header -->
        <div class="gallery-modal-header">
            <div class="modal-header-left">
                <span id="galleryModalBadge" class="gallery-modal-category-badge">Sports</span>
                <span id="galleryModalCounter" class="gallery-modal-counter">Photo 1 of 21</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-secondary text-light px-3 py-1" style="font-size:11.5px; font-weight:600; border-radius: 20px;">All Activities</span>
                <button type="button" id="closeGalleryModalBtn" class="gallery-modal-close-btn" aria-label="Close Gallery">
                    <i data-lucide="x" style="width:20px;height:20px;"></i>
                </button>
            </div>
        </div>

        <!-- Main Stage Image + Prev/Next Buttons -->
        <div class="gallery-modal-stage">
            <button type="button" id="galleryPrevBtn" class="gallery-nav-btn gallery-nav-prev" aria-label="Previous Photo">
                <i data-lucide="chevron-left" style="width:26px;height:26px;"></i>
            </button>

            <img id="galleryMainImg" src="" alt="NPS KGL Activity" class="gallery-main-image">

            <button type="button" id="galleryNextBtn" class="gallery-nav-btn gallery-nav-next" aria-label="Next Photo">
                <i data-lucide="chevron-right" style="width:26px;height:26px;"></i>
            </button>
        </div>

        <!-- Caption -->
        <div class="gallery-modal-caption">
            <h4 id="galleryModalTitle" class="gallery-modal-title">Activity Title</h4>
            <p id="galleryModalDesc" class="gallery-modal-desc">Activity Description</p>
        </div>

        <!-- Horizontal Scrollable Thumbnails Strip -->
        <div class="gallery-modal-thumbs-wrap">
            <div class="gallery-thumbs-label">
                <span>All Activities Photos (<span id="thumbsCount">21</span>)</span>
                <span class="text-muted" style="font-size:11px;">← Scroll to browse all 21 photos →</span>
            </div>
            <div id="galleryThumbsScroll" class="gallery-thumbs-scroll">
                <!-- Thumbnails injected dynamically -->
            </div>
        </div>
    </div>
</div>

    <!-- ================= SCRIPTS ================= -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js"></script>

    <script>
        // Safe Lucide Icons initialization
        function initLucideIcons() {
            if (window.lucide && typeof lucide.createIcons === 'function') {
                try {
                    lucide.createIcons();
                } catch (e) {
                    console.warn('Lucide icons warning:', e);
                }
            }
        }
        initLucideIcons();

        // Back to Top button
        const backToTop = document.getElementById('backToTop');
        if (backToTop) {
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
        }

        // Gallery Filter Function (Tab Concept) - globally accessible
        function filterGallery(filter, clickedBtn) {
            const filterBtns = document.querySelectorAll('.gallery-filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');

            // Update active pill state
            filterBtns.forEach(btn => {
                const btnFilter = btn.getAttribute('data-filter');
                if (btn === clickedBtn || (!clickedBtn && btnFilter === filter)) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Filter matching gallery cards
            galleryItems.forEach(item => {
                const itemCat = item.getAttribute('data-category');
                if (filter === 'all' || itemCat === filter) {
                    item.style.display = '';
                    item.classList.remove('d-none');
                    item.style.animation = 'galleryFadeIn 0.3s ease forwards';
                } else {
                    item.style.display = 'none';
                    item.classList.add('d-none');
                }
            });
        }
        window.filterGallery = filterGallery;

        // Attach event listeners to filter buttons
        document.querySelectorAll('.gallery-filter-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const filter = this.getAttribute('data-filter');
                filterGallery(filter, this);
            });
        });

        // Tab Concept for Our Activities 8-Card Section
        function filterOurActivities(category, clickedBtn) {
            const tabBtns = document.querySelectorAll('.our-activities-tab-btn');
            const activityCols = document.querySelectorAll('.our-activity-col');

            // Update active state on tab buttons
            tabBtns.forEach(btn => {
                const btnCat = btn.getAttribute('data-tab-category');
                if (btn === clickedBtn || (!clickedBtn && btnCat === category)) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Filter cards with smooth animation
            activityCols.forEach(col => {
                const colCat = col.getAttribute('data-category');
                if (category === 'all' || colCat === category || (colCat && colCat.split(' ').includes(category))) {
                    col.style.display = '';
                    col.classList.remove('d-none');
                    col.style.animation = 'galleryFadeIn 0.3s ease forwards';
                } else {
                    col.style.display = 'none';
                    col.classList.add('d-none');
                }
            });

            if (window.lucide) {
                lucide.createIcons();
            }
        }
        window.filterOurActivities = filterOurActivities;

        // Attach event listeners to Our Activities tab buttons
        document.querySelectorAll('.our-activities-tab-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const category = this.getAttribute('data-tab-category');
                filterOurActivities(category, this);
            });
        });

        // Comprehensive Gallery Slider & Related Photos Scroll System
        const galleryData = [
            // SPORTS (7 photos)
            {
                id: 'sports-1',
                category: 'sports',
                categoryLabel: 'Sports & Athletics',
                badgeColor: '#0284c7',
                src: "{{ asset('images/NPS PFWEB/DSC_9401.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9401.webp') }}",
                title: 'Basketball Arena Training & Drills',
                desc: 'Championship footwork, dribble routines, and shooting practice on our synthetic court.'
            },
            {
                id: 'sports-2',
                category: 'sports',
                categoryLabel: 'Sports & Athletics',
                badgeColor: '#0284c7',
                src: "{{ asset('images/NPS PFWEB/DSC_9445.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9445.webp') }}",
                title: 'Synchronized Team Basketball Drills',
                desc: 'Precision ball-handling, team rhythm, and defensive stance training.'
            },
            {
                id: 'sports-3',
                category: 'sports',
                categoryLabel: 'Sports & Athletics',
                badgeColor: '#0284c7',
                src: "{{ asset('images/NPS PFWEB/DSC_9491.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9491.webp') }}",
                title: 'Football Field Agility Coaching',
                desc: 'Tactical passing, cone dribbling drills, and stamina conditioning on turf with certified coaches.'
            },
            {
                id: 'sports-4',
                category: 'sports',
                categoryLabel: 'Sports & Athletics',
                badgeColor: '#0284c7',
                src: "{{ asset('images/NPS PFWEB/DSC_9578.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9578.webp') }}",
                title: 'Indoor Sports & Carrom Arena',
                desc: 'Fine-tuned finger-strike precision, rebound angles, and concentration in the carrom arena.'
            },
            {
                id: 'sports-5',
                category: 'sports',
                categoryLabel: 'Sports & Athletics',
                badgeColor: '#0284c7',
                src: "{{ asset('images/NPS PFWEB/DSC_9598.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9598.webp') }}",
                title: 'Mind Sports & Grandmaster Chess Arena',
                desc: 'Strategic calculation, cognitive depth, and tactical gambits in indoor mind sports.'
            },
            {
                id: 'sports-6',
                category: 'sports',
                categoryLabel: 'Sports & Athletics',
                badgeColor: '#0284c7',
                src: "{{ asset('images/NPS PFWEB/DSC_9620.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9620.webp') }}",
                title: 'Yoga Asana & Flexibility Conditioning',
                desc: 'Advanced balance postures, breath control, and core agility conditioning on martial arts tatami mats.'
            },
            {
                id: 'sports-7',
                category: 'sports',
                categoryLabel: 'Sports & Athletics',
                badgeColor: '#0284c7',
                src: "{{ asset('images/NPS PFWEB/DSC_9379.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9379.webp') }}",
                title: 'Outdoor Athletic Grounds & Campus View',
                desc: 'Expansive sports infrastructure featuring outdoor courts and athletic playing fields.'
            },

            // CULTURAL (6 photos)
            {
                id: 'cultural-1',
                category: 'cultural',
                categoryLabel: 'Cultural & Fine Arts',
                badgeColor: '#dc2626',
                src: "{{ asset('images/NPS PFWEB/IMG-20261106-WA0113.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0113.webp') }}",
                title: 'Classical Bharatanatyam Stage Recital',
                desc: 'Stage performance celebrating Karnataka Rajyotsava in traditional Bharatanatyam attire.'
            },
            {
                id: 'cultural-2',
                category: 'cultural',
                categoryLabel: 'Cultural & Fine Arts',
                badgeColor: '#dc2626',
                src: "{{ asset('images/NPS PFWEB/IMG-20261106-WA0125.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0125.webp') }}",
                title: 'Historical Theatrical Drama & Costumes',
                desc: 'Students enacting dramatic historical chapters with vibrant stage craft and confidence.'
            },
            {
                id: 'cultural-3',
                category: 'cultural',
                categoryLabel: 'Cultural & Fine Arts',
                badgeColor: '#dc2626',
                src: "{{ asset('images/NPS PFWEB/IMG-20261106-WA0130.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0130.webp') }}",
                title: 'Kittur Rani Chennamma Solo Drama',
                desc: 'Inspiring solo monologue celebrating Indian warrior heritage and classical expression.'
            },
            {
                id: 'cultural-4',
                category: 'cultural',
                categoryLabel: 'Cultural & Fine Arts',
                badgeColor: '#dc2626',
                src: "{{ asset('images/NPS PFWEB/IMG-20261106-WA0013.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0013.webp') }}",
                title: 'Creative Origami & Lantern Craft Studio',
                desc: 'Hands-on artistic design, 3D paper geometry, and decorative craftwork.'
            },
            {
                id: 'cultural-5',
                category: 'cultural',
                categoryLabel: 'Cultural & Fine Arts',
                badgeColor: '#dc2626',
                src: "{{ asset('images/NPS PFWEB/IMG-20261106-WA0022.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0022.webp') }}",
                title: 'Festive Floral Toran & Traditional Arts',
                desc: 'Students weaving traditional flower garlands and torans during festive cultural celebrations.'
            },
            {
                id: 'cultural-6',
                category: 'cultural',
                categoryLabel: 'Cultural & Fine Arts',
                badgeColor: '#dc2626',
                src: "{{ asset('images/Bharatanatyam Dancers Under Theatrical Lights.png') }}",
                thumb: "{{ asset('images/Bharatanatyam Dancers Under Theatrical Lights.png') }}",
                title: 'Bharatanatyam Performing Artists',
                desc: 'Classical Indian dance troupe performing intricate footwork under stage lighting.'
            },

            // LABS (5 photos)
            {
                id: 'labs-1',
                category: 'labs',
                categoryLabel: 'World-Class STEM Labs',
                badgeColor: '#16a34a',
                src: "{{ asset('images/NPS PFWEB/IMG_0450.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG_0450.webp') }}",
                title: 'Hands-on Chemical Reaction Analysis',
                desc: 'Reagent titration, precipitate formation, and solution testing guided by science educators.'
            },
            {
                id: 'labs-2',
                category: 'labs',
                categoryLabel: 'World-Class STEM Labs',
                badgeColor: '#16a34a',
                src: "{{ asset('images/NPS PFWEB/IMG_0447.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG_0447.webp') }}",
                title: 'Collaborative Chemistry Experimentation',
                desc: 'Investigating chemical properties and solution densities in groups.'
            },
            {
                id: 'labs-3',
                category: 'labs',
                categoryLabel: 'World-Class STEM Labs',
                badgeColor: '#16a34a',
                src: "{{ asset('images/NPS PFWEB/IMG_0436.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG_0436.webp') }}",
                title: 'Human Anatomy & Skeletal Lab',
                desc: 'Investigating bone structure and organ systems using full-scale skeletal models.'
            },
            {
                id: 'labs-4',
                category: 'labs',
                categoryLabel: 'World-Class STEM Labs',
                badgeColor: '#16a34a',
                src: "{{ asset('images/NPS PFWEB/DSC_9664.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9664.webp') }}",
                title: 'Cellular Microscopy & Specimen Study',
                desc: 'Slide preparation, plant cells, and high-power binocular optics in the biology lab.'
            },
            {
                id: 'labs-5',
                category: 'labs',
                categoryLabel: 'World-Class STEM Labs',
                badgeColor: '#16a34a',
                src: "{{ asset('images/NPS PFWEB/DSC_9555.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9555.webp') }}",
                title: '3D Geometry & Cognitive Mathematics Lab',
                desc: 'Manipulating spatial models, geometric nets, polyhedrons, and mathematical proofs.'
            },

            // CLUBS (3 photos)
            {
                id: 'clubs-1',
                category: 'clubs',
                categoryLabel: 'Clubs & Student Leadership',
                badgeColor: '#9333ea',
                src: "{{ asset('images/NPS PFWEB/IMG-20261106-WA0114.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0114.webp') }}",
                title: 'Podium Oratory & Public Speaking',
                desc: 'Student emcees commanding the stage at the official NPS KGL podium.'
            },
            {
                id: 'clubs-2',
                category: 'clubs',
                categoryLabel: 'Clubs & Student Leadership',
                badgeColor: '#9333ea',
                src: "{{ asset('images/NPS PFWEB/DSC_9379.JPG') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/DSC_9379.webp') }}",
                title: 'Campus Leadership & House Assemblies',
                desc: 'Morning assemblies and leadership circles in the spacious school courtyard.'
            },
            {
                id: 'clubs-3',
                category: 'clubs',
                categoryLabel: 'Clubs & Student Leadership',
                badgeColor: '#9333ea',
                src: "{{ asset('images/NPS PFWEB/IMG-20261106-WA0125.jpg') }}",
                thumb: "{{ asset('images/NPS_PFWEB_web/IMG-20261106-WA0125.webp') }}",
                title: 'Heritage & Drama Guild Enactment',
                desc: 'Student drama troupe performing historical chapters for the school assembly.'
            }
        ];

        // State
        let activeList = [];
        let currentIndex = 0;
        let isShowingAll = false;
        let currentCategoryKey = 'all';

        // Open Category Album (Sports 1 time, Labs 1 time, Cultural 1 time, Clubs 1 time)
        function openCategoryAlbum(categoryKey) {
            const modal = document.getElementById('galleryModalOverlay');
            if (!modal) {
                console.error('[Lightbox] Modal overlay element (#galleryModalOverlay) not found');
                return;
            }

            currentCategoryKey = categoryKey;
            if (categoryKey && categoryKey !== 'all') {
                activeList = galleryData.filter(item => item.category === categoryKey);
                if (!activeList.length) activeList = [...galleryData];
            } else {
                activeList = [...galleryData];
            }

            currentIndex = 0;

            renderThumbs();
            updateModalView(false);

            // Display modal smoothly
            modal.style.display = 'flex';
            void modal.offsetWidth; // force browser layout reflow
            modal.classList.add('is-open');
            document.body.style.overflow = 'hidden';

            if (window.lucide && typeof lucide.createIcons === 'function') {
                try { lucide.createIcons(); } catch (e) {}
            }
        }
        window.openCategoryAlbum = openCategoryAlbum;

        // Open Lightbox Modal System
        function openLightbox(imgSrc, title, desc) {
            const modal = document.getElementById('galleryModalOverlay');
            if (!modal) return;

            // Find matching item in galleryData by file basename, full src, or title
            let foundIdx = -1;
            if (imgSrc) {
                const baseName = imgSrc.split('/').pop().split('?')[0].toLowerCase();
                foundIdx = galleryData.findIndex(item => {
                    const itemBase = item.src.split('/').pop().split('?')[0].toLowerCase();
                    const thumbBase = (item.thumb || '').split('/').pop().split('?')[0].toLowerCase();
                    return itemBase === baseName || thumbBase === baseName;
                });
            }
            if (foundIdx === -1 && title) {
                const cleanTitle = title.toLowerCase().trim();
                foundIdx = galleryData.findIndex(item => item.title.toLowerCase().includes(cleanTitle) || cleanTitle.includes(item.title.toLowerCase()));
            }
            if (foundIdx === -1) foundIdx = 0;

            const target = galleryData[foundIdx];
            currentCategoryKey = target ? target.category : 'all';
            activeList = galleryData.filter(item => item.category === currentCategoryKey);
            if (!activeList.length) activeList = [...galleryData];
            currentIndex = activeList.findIndex(item => item.src === target.src);
            if (currentIndex === -1) currentIndex = 0;

            renderThumbs();
            updateModalView(false);

            modal.style.display = 'flex';
            void modal.offsetWidth;
            modal.classList.add('is-open');
            document.body.style.overflow = 'hidden';

            if (window.lucide && typeof lucide.createIcons === 'function') {
                try { lucide.createIcons(); } catch (e) {}
            }
        }

        // Render thumbnails in bottom strip
        function renderThumbs() {
            const thumbsScroll = document.getElementById('galleryThumbsScroll');
            const thumbsCount = document.getElementById('thumbsCount');
            if (!thumbsScroll) return;

            thumbsScroll.innerHTML = '';
            if (thumbsCount) thumbsCount.textContent = activeList.length;

            activeList.forEach((item, idx) => {
                const thumbDiv = document.createElement('div');
                thumbDiv.className = 'gallery-thumb-item' + (idx === currentIndex ? ' active' : '');
                thumbDiv.setAttribute('data-index', idx);
                thumbDiv.setAttribute('title', item.title);

                const img = document.createElement('img');
                img.src = item.thumb || item.src;
                img.alt = item.title;
                img.loading = 'lazy';
                thumbDiv.appendChild(img);

                thumbDiv.addEventListener('click', (e) => {
                    e.stopPropagation();
                    goToSlide(idx);
                });

                thumbsScroll.appendChild(thumbDiv);
            });
        }

        // Update modal image, captions, counter, and scroll active thumb into view
        function updateModalView(animate = true) {
            if (!activeList.length) return;
            const item = activeList[currentIndex];
            if (!item) return;

            const mainImg = document.getElementById('galleryMainImg');
            const thumbsScroll = document.getElementById('galleryThumbsScroll');

            if (animate && mainImg) {
                mainImg.classList.add('fade-out');
                setTimeout(() => {
                    applyItemData(item);
                    mainImg.classList.remove('fade-out');
                }, 160);
            } else {
                applyItemData(item);
            }

            // Update active state in thumbnail strip
            if (thumbsScroll) {
                const thumbItems = thumbsScroll.querySelectorAll('.gallery-thumb-item');
                thumbItems.forEach((thumb, idx) => {
                    if (idx === currentIndex) {
                        thumb.classList.add('active');
                        try {
                            thumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                        } catch (e) {}
                    } else {
                        thumb.classList.remove('active');
                    }
                });
            }
        }

        function applyItemData(item) {
            const mainImg = document.getElementById('galleryMainImg');
            const modalTitle = document.getElementById('galleryModalTitle');
            const modalDesc = document.getElementById('galleryModalDesc');
            const modalBadge = document.getElementById('galleryModalBadge');
            const modalCounter = document.getElementById('galleryModalCounter');

            if (mainImg) {
                mainImg.src = item.src;
                mainImg.alt = item.title;
            }
            if (modalTitle) modalTitle.textContent = item.title;
            if (modalDesc) modalDesc.textContent = item.desc;
            if (modalBadge) {
                modalBadge.textContent = item.categoryLabel;
                modalBadge.style.background = item.badgeColor || '#f59e0b';
            }
            if (modalCounter) {
                modalCounter.textContent = 'Photo ' + (currentIndex + 1) + ' of ' + activeList.length;
            }
        }

        function goToSlide(newIdx) {
            if (newIdx < 0) {
                currentIndex = activeList.length - 1;
            } else if (newIdx >= activeList.length) {
                currentIndex = 0;
            } else {
                currentIndex = newIdx;
            }
            updateModalView(true);
        }

        function nextSlide() {
            goToSlide(currentIndex + 1);
        }

        function prevSlide() {
            goToSlide(currentIndex - 1);
        }

        function closeGalleryModal() {
            const modal = document.getElementById('galleryModalOverlay');
            if (!modal) return;
            modal.classList.remove('is-open');
            document.body.style.overflow = '';
            setTimeout(() => {
                if (!modal.classList.contains('is-open')) {
                    modal.style.display = 'none';
                    const mainImg = document.getElementById('galleryMainImg');
                    if (mainImg) mainImg.src = '';
                }
            }, 260);
        }

        // Attach event listeners to modal controls
        const nextBtn = document.getElementById('galleryNextBtn');
        const prevBtn = document.getElementById('galleryPrevBtn');
        const closeBtn = document.getElementById('closeGalleryModalBtn');
        const modalOverlay = document.getElementById('galleryModalOverlay');

        if (nextBtn) nextBtn.addEventListener('click', (e) => { e.stopPropagation(); nextSlide(); });
        if (prevBtn) prevBtn.addEventListener('click', (e) => { e.stopPropagation(); prevSlide(); });
        if (closeBtn) closeBtn.addEventListener('click', (e) => { e.stopPropagation(); closeGalleryModal(); });

        // Close on clicking backdrop
        if (modalOverlay) {
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) closeGalleryModal();
            });
        }

        // Attach direct click listeners to all gallery cards
        function initGalleryCards() {
            document.querySelectorAll('.gallery-card').forEach(card => {
                card.addEventListener('click', function(e) {
                    e.preventDefault();
                    const catTarget = this.getAttribute('data-category-target');
                    if (catTarget) {
                        openCategoryAlbum(catTarget);
                    } else {
                        const img = this.getAttribute('data-img') || this.querySelector('img')?.getAttribute('src');
                        const title = this.getAttribute('data-title') || this.querySelector('.gallery-card-title')?.textContent;
                        const desc = this.getAttribute('data-desc') || this.querySelector('.gallery-card-desc')?.textContent;
                        openLightbox(img, title, desc);
                    }
                });
            });
        }
        initGalleryCards();

        // Keyboard Navigation (Arrow Keys + Escape)
        document.addEventListener('keydown', (e) => {
            const modal = document.getElementById('galleryModalOverlay');
            if (!modal || !modal.classList.contains('is-open')) return;
            if (e.key === 'ArrowRight') {
                nextSlide();
            } else if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'Escape') {
                closeGalleryModal();
            }
        });

        // Touch Swipe Support for Mobile
        let touchStartX = 0;
        let touchEndX = 0;
        if (modalOverlay) {
            modalOverlay.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            modalOverlay.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, { passive: true });
        }

        function handleSwipe() {
            const diff = touchEndX - touchStartX;
            if (Math.abs(diff) > 45) {
                if (diff < 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
        }

        // Expose functions globally for inline HTML onclick handlers
        window.openLightbox = openLightbox;
        window.closeGalleryModal = closeGalleryModal;
        window.goToSlide = goToSlide;
        window.nextSlide = nextSlide;
        window.prevSlide = prevSlide;
</script>
</body>
</html>

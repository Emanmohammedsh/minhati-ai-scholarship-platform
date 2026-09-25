<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('common.student_dashboard') }} | Jisr AI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>
        :root {
            --primary: #0A2E6B;
            --primary-dark: #061F49;
            --secondary: #00C6FF;
            --accent: #87DFFF;
            --background: #EAF6FF;
            --surface: #FFFFFF;
            --surface-soft: #F7FCFF;
            --text: #4B5563;
            --heading: #071D45;
            --muted: #7B8794;
            --border: #DCEEF8;
            --success: #16A085;
            --warning: #E6A817;
            --danger: #D9534F;
            --shadow: 0 18px 55px rgba(10, 46, 107, .09);
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            font-family: {{ app()->getLocale() === 'ar' ? 'Arial, sans-serif' : '"Poppins", Arial, sans-serif' }};
            background:
                radial-gradient(circle at 92% 5%, rgba(0, 198, 255, .13), transparent 26%),
                radial-gradient(circle at 5% 65%, rgba(135, 223, 255, .18), transparent 25%),
                #F8FCFF;
        }

        button, a { font-family: inherit; }

        a { text-decoration: none; color: inherit; }

        .hidden { display: none !important; }

        /* ===== LOADING ===== */
        #loadingScreen {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 18px;
        }

        .loader {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(10, 46, 107, .10);
            border-top-color: var(--secondary);
            border-radius: 50%;
            animation: spin .8s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .loading-text { color: var(--muted); font-size: 14px; }

        /* ===== TOPBAR ===== */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 30;
            border-bottom: 1px solid rgba(10,46,107,.08);
            background: rgba(255,255,255,.90);
            backdrop-filter: blur(20px);
        }

        .topbar-inner {
            width: min(1180px, calc(100% - 32px));
            margin: auto;
            min-height: 78px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand { display: flex; align-items: center; gap: 12px; }

        .brand-logo { width: 50px; height: 50px; object-fit: contain; border-radius: 13px; }

        .brand-copy { line-height: 1.1; }

        .brand-name {
            display: block;
            font-family: "Poppins", sans-serif;
            color: var(--primary);
            font-size: 19px;
            font-weight: 700;
        }

        .brand-slogan {
            display: block;
            margin-top: 5px;
            color: #7B8794;
            font-family: "Poppins", sans-serif;
            font-size: 9px;
            letter-spacing: 1.25px;
        }

        .top-actions { display: flex; align-items: center; gap: 8px; }

        .nav-link, .logout-btn {
            border-radius: 10px;
            padding: 10px 13px;
            font-size: 12px;
            font-weight: 600;
            transition: .2s ease;
        }

        .nav-link { color: var(--primary); }

        .nav-link:hover { background: var(--background); }

        .language-switcher {
            display: flex;
            align-items: center;
            gap: 7px;
            direction: ltr;
            padding: 7px 10px;
            border-radius: 10px;
            background: var(--background);
            font-family: "Poppins", sans-serif;
            font-size: 11px;
            font-weight: 600;
        }

        .language-switcher a { color: #8293A0; }

        .language-switcher a.active { color: var(--primary); font-weight: 700; }

        .language-switcher span { color: #BCD2DF; }

        .logout-btn { border: none; color: white; background: var(--primary); cursor: pointer; }

        .logout-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(10,46,107,.18); }

        /* ===== MAIN ===== */
        main {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
            padding: 42px 0 70px;
        }

        /* ===== HERO ===== */
        .hero {
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            gap: 30px;
            align-items: center;
            margin-bottom: 28px;
            padding: 37px 40px;
            border-radius: 25px;
            color: white;
            background: linear-gradient(125deg, #061F49 0%, #0A2E6B 58%, #075A8D 100%);
            box-shadow: 0 25px 65px rgba(10,46,107,.20);
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            inset-inline-end: -100px;
            top: -170px;
            background: rgba(0,198,255,.17);
        }

        .hero-content { position: relative; z-index: 2; max-width: 690px; }

        .eyebrow {
            margin: 0 0 9px;
            text-transform: uppercase;
            letter-spacing: 1.6px;
            color: var(--accent);
            font-size: 11px;
            font-weight: 700;
        }

        .hero h1 {
            margin: 0;
            font-family: {{ app()->getLocale() === 'ar' ? 'Arial, sans-serif' : '"Poppins", Arial, sans-serif' }};
            font-size: clamp(29px, 4vw, 43px);
            line-height: 1.15;
            letter-spacing: -.8px;
        }

        .hero p { margin: 12px 0 0; color: #D8ECF8; line-height: 1.8; font-size: 14px; }

        .hero-actions {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            min-width: max-content;
        }

        .btn {
            border: 0;
            border-radius: 12px;
            padding: 12px 16px;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform .2s ease, opacity .2s ease, background .2s ease;
        }

        .btn:hover { transform: translateY(-1px); }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary), #008FE8);
            color: white;
            box-shadow: 0 10px 25px rgba(0,198,255,.20);
        }

        .btn-secondary {
            color: white;
            background: rgba(255,255,255,.09);
            border: 1px solid rgba(255,255,255,.20);
        }

        .btn:disabled { opacity: .55; cursor: wait; transform: none; }

        /* ===== CARDS ===== */
        .glass {
            background: rgba(255,255,255,.94);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat-card {
            border-radius: 17px;
            padding: 21px;
            min-height: 126px;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 100px;
            inset-inline-end: -35px;
            bottom: -50px;
            background: radial-gradient(circle, rgba(0,198,255,.14), transparent 70%);
        }

        .stat-label { color: var(--muted); font-size: 12px; font-weight: 600; margin-bottom: 17px; }

        .stat-value {
            color: var(--primary);
            font-family: "Poppins", sans-serif;
            font-size: 29px;
            font-weight: 700;
            line-height: 1;
        }

        .stat-note { color: var(--muted); font-size: 11px; margin-top: 10px; line-height: 1.5; }

        .dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0,1.45fr) minmax(280px,.75fr);
            gap: 18px;
            margin-bottom: 18px;
        }

        .section-card { border-radius: 19px; padding: 24px; }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .section-heading h2 { margin: 0; color: var(--heading); font-size: 18px; }

        .section-heading p { margin: 5px 0 0; color: var(--muted); font-size: 12px; }

        .section-tag {
            font-size: 10px;
            color: var(--primary);
            padding: 7px 10px;
            border-radius: 999px;
            background: rgba(0,198,255,.08);
            border: 1px solid rgba(0,198,255,.18);
            white-space: nowrap;
        }

        /* ===== BEST OPPORTUNITY ===== */
        .best-opportunity {
            border-radius: 16px;
            padding: 22px;
            background: linear-gradient(135deg, rgba(0,198,255,.09), rgba(10,46,107,.04));
            border: 1px solid #D4EFF9;
        }

        .opportunity-top { display: flex; justify-content: space-between; gap: 20px; }

        .opportunity-title { margin: 0 0 7px; color: var(--heading); font-size: 21px; }

        .provider { color: var(--muted); font-size: 13px; }

        .location { color: #607383; margin-top: 12px; font-size: 13px; }

        .match-score {
            width: 76px;
            height: 76px;
            flex: 0 0 76px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 6px solid rgba(0,198,255,.20);
            background: white;
            box-shadow: 0 8px 25px rgba(10,46,107,.08);
        }

        .match-score strong { font-family: "Poppins", sans-serif; font-size: 19px; color: var(--primary); }

        .match-score small { color: var(--muted); font-size: 9px; }

        .opportunity-description { color: #667784; line-height: 1.7; font-size: 13px; margin: 20px 0 0; }

        /* ===== JOURNEY ===== */
        .journey { display: flex; flex-direction: column; gap: 0; }

        .journey-item { display: grid; grid-template-columns: 30px 1fr; gap: 12px; min-height: 59px; }

        html[dir="rtl"] .journey-item { grid-template-columns: 30px 1fr; }

        .journey-marker { display: flex; flex-direction: column; align-items: center; }

        .journey-circle {
            width: 25px;
            height: 25px;
            flex: 0 0 25px;
            border-radius: 50%;
            border: 1px solid #CFE1EA;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: var(--primary);
            background: #F2FAFE;
        }

        .journey-item.done .journey-circle {
            background: rgba(22,160,133,.10);
            border-color: rgba(22,160,133,.35);
            color: var(--success);
        }

        .journey-line { width: 1px; flex: 1; background: #DDEBF2; }

        .journey-content strong { display: block; color: var(--heading); font-size: 13px; margin-top: 3px; }

        .journey-content small { display: block; color: var(--muted); margin-top: 4px; font-size: 11px; }

        /* ===== MATCHES ===== */
        .matches-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }

        .match-card {
            min-height: 190px;
            padding: 18px;
            border-radius: 15px;
            background: var(--surface-soft);
            border: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: .25s ease;
        }

        .match-card:hover { transform: translateY(-3px); box-shadow: 0 14px 35px rgba(10,46,107,.08); }

        .match-percent {
            width: fit-content;
            color: var(--primary);
            font-size: 11px;
            font-weight: 700;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(0,198,255,.09);
        }

        .match-card h3 { margin: 15px 0 7px; color: var(--heading); font-size: 15px; line-height: 1.4; }

        .match-card .provider { font-size: 11px; }

        .match-country { margin-top: auto; padding-top: 16px; color: #657885; font-size: 11px; }

        /* ===== APPLICATIONS ===== */
        .application-card {
            border-radius: 15px;
            border: 1px solid var(--border);
            padding: 18px;
            background: var(--surface-soft);
        }

        .application-card + .application-card { margin-top: 10px; }

        .application-top { display: flex; justify-content: space-between; gap: 18px; }

        .application-title { color: var(--heading); font-weight: 600; font-size: 15px; }

        .status-badge {
            flex: 0 0 auto;
            text-transform: capitalize;
            font-size: 10px;
            font-weight: 700;
            padding: 6px 9px;
            border-radius: 999px;
            background: rgba(0,198,255,.10);
            color: var(--primary);
            height: fit-content;
        }

        .application-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 14px;
            color: var(--muted);
            font-size: 11px;
        }

        /* ===== QUICK ACTIONS ===== */
        .quick-actions { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; }

        .quick-action {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 17px;
            background: var(--surface-soft);
            cursor: pointer;
            transition: .2s;
            text-align: start;
        }

        .quick-action:hover { background: var(--background); transform: translateY(-2px); }

        .quick-action strong { display: block; color: var(--heading); font-size: 13px; }

        .quick-action span { display: block; color: var(--muted); font-size: 11px; line-height: 1.5; margin-top: 5px; }

        /* ===== GAP ANALYSIS + APPLY ===== */
        .match-actions {
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .why-match-btn {
            display: block;
            width: 100%;
            border: 1px solid rgba(0,198,255,.22);
            background: rgba(0,198,255,.07);
            color: var(--primary);
            border-radius: 10px;
            padding: 9px 11px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s ease;
        }

        .why-match-btn:hover { background: rgba(0,198,255,.13); }

        .why-match-btn:disabled { opacity: .55; cursor: wait; }

        .apply-btn { margin-top: 8px; }

        .apply-btn:disabled {
            opacity: 1;
            cursor: default;
            color: var(--success);
            border-color: rgba(22,160,133,.30);
            background: rgba(22,160,133,.08);
        }

        .gap-panel {
            margin-top: 12px;
            padding: 13px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: white;
            font-size: 11px;
            line-height: 1.55;
        }

        .gap-summary { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 12px; }

        .gap-chip {
            padding: 5px 8px;
            border-radius: 999px;
            background: #F3F8FB;
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .gap-chip.good {
            color: var(--success);
            border-color: rgba(22,160,133,.20);
            background: rgba(22,160,133,.06);
        }

        .gap-chip.warning {
            color: #A87800;
            border-color: rgba(230,168,23,.25);
            background: rgba(230,168,23,.07);
        }

        .gap-block + .gap-block { margin-top: 12px; }

        .gap-block-title { color: var(--heading); font-weight: 700; margin-bottom: 7px; }

        .gap-item { color: #5F707D; padding: 7px 9px; border-radius: 9px; background: #F7FAFC; }

        .gap-item + .gap-item { margin-top: 6px; }

        .gap-item.matched { border-inline-start: 2px solid var(--success); }

        .gap-item.missing { border-inline-start: 2px solid var(--warning); }

        .gap-suggestion { display: block; color: var(--muted); margin-top: 4px; }

        .gap-course {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
            padding: 8px 9px;
            border-radius: 9px;
            background: rgba(22,160,133,.06);
            border: 1px solid rgba(22,160,133,.20);
            font-size: 11px;
        }

        .gap-course-link { color: var(--success); font-weight: 700; text-decoration: underline; }

        .gap-course-meta { color: var(--muted); }

        .gap-course {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;

            margin-top: 8px;
            padding: 8px 9px;

            border-radius: 9px;

            background: rgba(52,211,153,.08);
            border: 1px solid rgba(52,211,153,.25);

            font-size: 11px;
        }


        .gap-course-link {
            color: var(--success) !important;
            font-weight: 700;
            text-decoration: underline !important;
        }


        .gap-course-meta {
            color: var(--muted);
        }


        .gap-warning {
            margin-top: 7px;
            padding: 8px 9px;
            border-radius: 9px;
            color: #886300;
            background: rgba(249,199,79,.10);
            border: 1px solid rgba(249,199,79,.25);
        }

        /* ===== EMPTY ===== */
        .empty-state {
            padding: 28px 15px;
            text-align: center;
            color: var(--muted);
            border-radius: 14px;
            border: 1px dashed #CADDE7;
        }

        .empty-state strong { display: block; color: var(--heading); margin-bottom: 6px; }

        /* ===== TOAST ===== */
        .toast {
            position: fixed;
            inset-inline-end: 20px;
            bottom: 20px;
            z-index: 100;
            min-width: 250px;
            max-width: 360px;
            padding: 14px 16px;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            font-size: 13px;
            transition: .25s;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .stats-grid { grid-template-columns: repeat(2,1fr); }
            .dashboard-grid { grid-template-columns: 1fr; }
            .matches-grid { grid-template-columns: 1fr 1fr; }
            .hero { align-items: flex-start; flex-direction: column; }
            .hero-actions { min-width: 0; }
        }

        @media (max-width: 700px) {
            .brand-copy { display: none; }
            .nav-link { display: none; }
            .topbar-inner, main { width: min(100% - 22px, 1180px); }
            .topbar-inner { min-height: 68px; }
            main { padding-top: 27px; }
            .hero { padding: 27px 23px; border-radius: 20px; }
            .hero-actions { width: 100%; }
            .hero-actions .btn { flex: 1; }
            .stats-grid, .matches-grid, .quick-actions { grid-template-columns: 1fr; }
            .opportunity-top { flex-direction: column; }
            .match-score { width: 67px; height: 67px; flex-basis: 67px; }
            .section-card { padding: 18px; }
        }

        @media (max-width: 480px) {
            .language-switcher { padding: 6px 8px; }
            .logout-btn { padding: 9px 10px; font-size: 11px; }
            .brand-logo { width: 44px; height: 44px; }
        }
    
        /* CV Tailor */
        .tailor-btn { border-color:#00C6FF; color:#0A2E6B; background:#EAF6FF; }
        .tailor-btn:hover { background:#d9f2ff; }
        .tailor-modal { position:fixed; inset:0; z-index:1200; display:flex; align-items:center; justify-content:center; padding:20px; background:rgba(10,46,107,.38); }
        .tailor-modal.hidden { display:none; }
        .tailor-dialog { width:min(760px,100%); max-height:88vh; overflow:auto; background:#fff; border:1px solid rgba(10,46,107,.12); border-radius:22px; box-shadow:0 24px 70px rgba(10,46,107,.22); padding:24px; }
        .tailor-head { display:flex; justify-content:space-between; gap:16px; align-items:flex-start; margin-bottom:16px; }
        .tailor-head h2 { margin:0 0 6px; color:#0A2E6B; }
        .tailor-head p { margin:0; color:#4B5563; }
        .tailor-close { border:0; background:#EAF6FF; color:#0A2E6B; width:38px; height:38px; border-radius:50%; cursor:pointer; font-size:20px; }
        .tailor-status { padding:14px 16px; border-radius:14px; background:#EAF6FF; color:#0A2E6B; margin:12px 0; }
        .tailor-section { margin-top:18px; }
        .tailor-section h3 { color:#0A2E6B; margin:0 0 10px; }
        .tailor-option { display:flex; gap:12px; align-items:flex-start; padding:13px; margin:8px 0; border:1px solid rgba(10,46,107,.12); border-radius:14px; background:#fff; }
        .tailor-option input { margin-top:4px; accent-color:#0A2E6B; }
        .tailor-option strong { color:#0A2E6B; display:block; }
        .tailor-option small { color:#4B5563; display:block; margin-top:4px; line-height:1.5; }
        .tailor-warning { color:#9a6700 !important; }
        .tailor-actions { display:flex; justify-content:flex-end; gap:10px; margin-top:20px; flex-wrap:wrap; }
        .tailor-note { font-size:13px; color:#4B5563; margin-top:10px; }


        /* ===== COVER LETTERS ===== */
        .cover-letter-btn { border-color:rgba(10,46,107,.22); color:var(--primary); background:#fff; margin-top:8px; }
        .cover-letter-btn:hover { background:var(--background); }
        .cover-letter-card { margin-top:14px; padding:18px; border:1px solid var(--border); border-radius:15px; background:var(--surface-soft); }
        .cover-letter-card h3 { margin:0 0 5px; color:var(--heading); font-size:15px; }
        .cover-letter-meta { color:var(--muted); font-size:11px; margin-bottom:13px; }
        .cover-letter-content { white-space:pre-wrap; line-height:1.8; color:#445564; font-size:13px; padding:15px; border-radius:12px; background:#fff; border:1px solid var(--border); }
        .cover-letter-actions { display:flex; flex-wrap:wrap; gap:8px; margin-top:12px; }
        .cover-letter-actions .btn-secondary { color:var(--primary); background:var(--background); border:1px solid var(--border); }
        /* ===== NOTIFICATIONS ===== */
        .notification-card { margin-top:12px; padding:16px; border:1px solid var(--border); border-radius:15px; background:var(--surface-soft); }
        .notification-top { display:flex; align-items:flex-start; justify-content:space-between; gap:14px; }
        .notification-card h3 { margin:0 0 5px; color:var(--heading); font-size:14px; }
        .notification-meta { display:flex; flex-wrap:wrap; gap:8px 14px; margin-top:11px; color:var(--muted); font-size:11px; }
        .notification-status { flex:0 0 auto; text-transform:capitalize; font-size:10px; font-weight:700; padding:6px 9px; border-radius:999px; color:var(--primary); background:rgba(0,198,255,.10); }
        .notification-actions { display:flex; justify-content:flex-end; margin-top:12px; }
        .notification-actions .btn-secondary { color:var(--primary); background:var(--background); border:1px solid var(--border); }
    </style>
</head>


<body>

<div id="loadingScreen">
    <div class="loader"></div>
    <div class="loading-text">{{ __('common.preparing_dashboard') }}</div>
</div>


<div id="appShell" class="hidden">

    <!-- NAVBAR -->
    <header class="topbar">
        <div class="topbar-inner">

            <a href="{{ route('dashboard') }}" class="brand">
                <img src="/images/jisr-logo.jpeg" class="brand-logo" alt="Jisr AI">
                <div class="brand-copy">
                    <span class="brand-name">Jisr AI</span>
                    <span class="brand-slogan">BRIDGING TALENT TO OPPORTUNITY</span>
                </div>
            </a>

            <div class="top-actions">

                <a class="nav-link" href="{{ route('choose-path') }}">{{ __('common.switch_path') }}</a>

                <a class="nav-link" href="{{ route('profile') }}">{{ __('common.profile') }}</a>

                <a class="nav-link" href="{{ route('cv-upload') }}">{{ __('common.my_cv') }}</a>

                <div class="language-switcher">
                    <a href="{{ route('language.switch','ar') }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
                    <span>|</span>
                    <a href="{{ route('language.switch','en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                </div>

                <button id="logoutBtn" class="logout-btn" type="button">{{ __('common.logout') }}</button>

            </div>
        </div>
    </header>


    <main>

        <!-- HERO -->
        <section class="hero">

            <div class="hero-content">
                <p class="eyebrow">{{ __('common.student_dashboard') }}</p>
                <h1 id="welcomeHeading">{{ __('common.welcome') }}</h1>
                <p>{{ __('common.education_intro') }}</p>
            </div>

            <div class="hero-actions">
                <a href="{{ route('cv-upload') }}" class="btn btn-secondary">{{ __('common.upload_cv') }}</a>

                <button id="refreshRecommendationsBtn" type="button" class="btn btn-primary">
                    {{ __('common.refresh_matches') }}
                </button>
            </div>

        </section>


        <!-- STATS -->
        <section class="stats-grid">

            <div class="stat-card glass">
                <div class="stat-label">{{ __('common.ai_scholarship_matches') }}</div>
                <div class="stat-value" id="matchCount">—</div>
                <div class="stat-note">{{ __('common.matches_note') }}</div>
            </div>

            <div class="stat-card glass">
                <div class="stat-label">{{ __('common.my_applications') }}</div>
                <div class="stat-value" id="applicationCount">—</div>
                <div class="stat-note">{{ __('common.applications_note') }}</div>
            </div>

            <div class="stat-card glass">
                <div class="stat-label">{{ __('common.profile_completion') }}</div>
                <div class="stat-value" id="profileCompletion">—</div>
                <div class="stat-note">{{ __('common.profile_completion_note') }}</div>
            </div>

            <div class="stat-card glass">
                <div class="stat-label">{{ __('common.upcoming_deadline') }}</div>
                <div class="stat-value" id="deadlineValue">—</div>
                <div class="stat-note" id="deadlineNote">{{ __('common.deadline_note') }}</div>
            </div>

        </section>


        <!-- BEST + JOURNEY -->
        <section class="dashboard-grid">

            <div class="section-card glass">
                <div class="section-heading">
                    <div>
                        <h2>{{ __('common.best_opportunity') }}</h2>
                        <p>{{ __('common.best_opportunity_note') }}</p>
                    </div>
                    <span class="section-tag">{{ __('common.ai_match') }}</span>
                </div>

                <div id="bestOpportunity"></div>
            </div>


            <div class="section-card glass">
                <div class="section-heading">
                    <div>
                        <h2>{{ __('common.scholarship_journey') }}</h2>
                        <p>{{ __('common.application_progress') }}</p>
                    </div>
                </div>

                <div class="journey">

                    <div class="journey-item" id="journeyProfile">
                        <div class="journey-marker">
                            <div class="journey-circle">?</div>
                            <div class="journey-line"></div>
                        </div>
                        <div class="journey-content">
                            <strong>{{ __('common.build_profile') }}</strong>
                            <small>{{ __('common.build_profile_note') }}</small>
                        </div>
                    </div>

                    <div class="journey-item" id="journeyMatch">
                        <div class="journey-marker">
                            <div class="journey-circle">?</div>
                            <div class="journey-line"></div>
                        </div>
                        <div class="journey-content">
                            <strong>{{ __('common.discover_matches') }}</strong>
                            <small>{{ __('common.discover_matches_note') }}</small>
                        </div>
                    </div>

                    <div class="journey-item" id="journeyPrepare">
                        <div class="journey-marker">
                            <div class="journey-circle">3</div>
                            <div class="journey-line"></div>
                        </div>
                        <div class="journey-content">
                            <strong>{{ __('common.prepare_application') }}</strong>
                            <small>{{ __('common.prepare_application_note') }}</small>
                        </div>
                    </div>

                    <div class="journey-item" id="journeyApply">
                        <div class="journey-marker">
                            <div class="journey-circle">4</div>
                        </div>
                        <div class="journey-content">
                            <strong>{{ __('common.apply_track') }}</strong>
                            <small>{{ __('common.apply_track_note') }}</small>
                        </div>
                    </div>

                </div>
            </div>

        </section>


        <!-- TOP MATCHES -->
        <section class="section-card glass" style="margin-bottom:18px;">

            <div class="section-heading">
                <div>
                    <h2>{{ __('common.top_ai_matches') }}</h2>
                    <p>{{ __('common.top_matches_note') }}</p>
                </div>

                <span id="matchesGeneratedAt" class="section-tag">
                    {{ __('common.matching_engine') }}
                </span>
            </div>

            <div id="matchesGrid" class="matches-grid"></div>

        </section>


        <!-- APPLICATIONS + ACTIONS -->
        <section class="dashboard-grid">

            <div class="section-card glass">
                <div class="section-heading">
                    <div>
                        <h2>{{ __('common.my_applications') }}</h2>
                        <p>{{ __('common.applications_section_note') }}</p>
                    </div>
                </div>

                <div id="applicationsList"></div>
            </div>


            <div class="section-card glass">
                <div class="section-heading">
                    <div>
                        <h2>{{ __('common.quick_actions') }}</h2>
                        <p>{{ __('common.quick_actions_note') }}</p>
                    </div>
                </div>

                <div class="quick-actions">

                    <a href="{{ route('profile') }}" class="quick-action">
                        <strong>{{ __('common.update_profile') }}</strong>
                        <span>{{ __('common.update_profile_note') }}</span>
                    </a>

                    <a href="{{ route('cv-upload') }}" class="quick-action">
                        <strong>{{ __('common.manage_cv') }}</strong>
                        <span>{{ __('common.manage_cv_note') }}</span>
                    </a>

                    <button id="refreshRecommendationsQuick" type="button" class="quick-action">
                        <strong>{{ __('common.generate_matches') }}</strong>
                        <span>{{ __('common.generate_matches_note') }}</span>
                    </button>
                    <button type="button" class="quick-action" onclick="openCvVersions()">
                        <strong>{{ app()->getLocale() === 'ar' ? 'نسخ السيرة المخصصة' : 'Tailored CV Versions' }}</strong>
                        <span>{{ app()->getLocale() === 'ar' ? 'عرض النسخ المحفوظة لكل منحة' : 'View saved CV versions for scholarships' }}</span>
                    </button>
                    <button type="button" class="quick-action" onclick="openCoverLetters()">
                        <strong>{{ app()->getLocale() === 'ar' ? 'خطابات التقديم' : 'Cover Letters' }}</strong>
                        <span>{{ app()->getLocale() === 'ar' ? 'عرض خطابات التقديم المحفوظة' : 'View generated scholarship cover letters' }}</span>
                    </button>
                    <button type="button" class="quick-action" onclick="openNotifications()">
                        <strong>{{ app()->getLocale() === 'ar' ? 'الإشعارات والتذكيرات' : 'Notifications & Reminders' }}</strong>
                        <span>{{ app()->getLocale() === 'ar' ? 'عرض تذكيرات مواعيد المنح وحالتها' : 'View scholarship deadline reminders and their status' }}</span>
                    </button>
                </div>
            </div>

        </section>

    </main>

</div>



<div id="cvTailorModal" class="tailor-modal hidden" role="dialog" aria-modal="true" aria-labelledby="cvTailorTitle">
    <div class="tailor-dialog">
        <div class="tailor-head">
            <div>
                <h2 id="cvTailorTitle">{{ app()->getLocale() === 'ar' ? 'خصّص سيرتك لهذه المنحة' : 'Tailor CV for this Scholarship' }}</h2>
                <p id="cvTailorScholarship"></p>
            </div>
            <button type="button" class="tailor-close" onclick="closeCvTailor()" aria-label="Close">×</button>
        </div>
        <div id="cvTailorStatus" class="tailor-status">{{ app()->getLocale() === 'ar' ? 'جارٍ تجهيز الاقتراحات...' : 'Preparing suggestions...' }}</div>
        <div id="cvTailorSuggestions"></div>
        <div class="tailor-actions">
            <button type="button" class="btn btn-secondary" onclick="closeCvTailor()">{{ app()->getLocale() === 'ar' ? 'إلغاء' : 'Cancel' }}</button>
            <button type="button" id="saveTailoredCvBtn" class="btn btn-primary" onclick="saveTailoredCv()" disabled>{{ app()->getLocale() === 'ar' ? 'حفظ النسخة المخصّصة' : 'Save Tailored Version' }}</button>
        </div>
        <p class="tailor-note">{{ app()->getLocale() === 'ar' ? 'سيتم حفظ نسخة منفصلة. لن يتم تعديل السيرة الأصلية.' : 'A separate version will be saved. Your original CV will not be changed.' }}</p>
    </div>
</div>
<div id="cvVersionsModal" class="tailor-modal hidden" role="dialog" aria-modal="true">
    <div class="tailor-dialog">

        <div class="tailor-head">
            <div>
                <h2>
                    {{ app()->getLocale() === 'ar'
                        ? 'نسخ السيرة الذاتية المخصصة'
                        : 'Tailored CV Versions' }}
                </h2>

                <p>
                    {{ app()->getLocale() === 'ar'
                        ? 'النسخ التي حفظتها للمنح المختلفة'
                        : 'CV versions you saved for different scholarships' }}
                </p>
            </div>

            <button
                type="button"
                class="tailor-close"
                onclick="closeCvVersions()"
                aria-label="Close"
            >×</button>
        </div>

        <div id="cvVersionsStatus" class="tailor-status"></div>

        <div id="cvVersionsList"></div>

        <div class="tailor-actions">
            <button
                type="button"
                class="btn btn-secondary"
                onclick="closeCvVersions()"
            >
                {{ app()->getLocale() === 'ar' ? 'إغلاق' : 'Close' }}
            </button>
        </div>

    </div>
</div>

<div id="coverLettersModal" class="tailor-modal hidden" role="dialog" aria-modal="true">
    <div class="tailor-dialog">
        <div class="tailor-head">
            <div>
                <h2>{{ app()->getLocale() === 'ar' ? 'خطابات التقديم' : 'Cover Letters' }}</h2>
                <p>{{ app()->getLocale() === 'ar' ? 'خطابات مخصصة للمنح باستخدام بياناتك الموجودة فقط' : 'Scholarship letters generated using only your existing information' }}</p>
            </div>
            <button type="button" class="tailor-close" onclick="closeCoverLetters()" aria-label="Close">×</button>
        </div>
        <div id="coverLettersStatus" class="tailor-status"></div>
        <div id="coverLettersList"></div>
        <div class="tailor-actions">
            <button type="button" class="btn btn-secondary" onclick="closeCoverLetters()">{{ app()->getLocale() === 'ar' ? 'إغلاق' : 'Close' }}</button>
        </div>
    </div>
</div>

<div id="notificationsModal" class="tailor-modal hidden" role="dialog" aria-modal="true">
    <div class="tailor-dialog">
        <div class="tailor-head"><div>
            <h2>{{ app()->getLocale() === 'ar' ? 'الإشعارات والتذكيرات' : 'Notifications & Reminders' }}</h2>
            <p>{{ app()->getLocale() === 'ar' ? 'تذكيرات طلبات المنح والمواعيد المجدولة' : 'Scheduled scholarship application reminders' }}</p>
        </div><button type="button" class="tailor-close" onclick="closeNotifications()" aria-label="Close">×</button></div>
        <div id="notificationsStatus" class="tailor-status"></div>
        <div id="notificationsList"></div>
        <div class="tailor-actions"><button type="button" class="btn btn-secondary" onclick="closeNotifications()">{{ app()->getLocale() === 'ar' ? 'إغلاق' : 'Close' }}</button></div>
    </div>
</div>

<div id="toast" class="toast hidden"></div>


<script>

    const API_BASE_URL = @json(url('/api'));

    const LOGIN_URL = @json(route('login'));

    const CURRENT_LOCALE = @json(app()->getLocale());


    /*
    |--------------------------------------------------------------------------
    | Translated JS text
    |--------------------------------------------------------------------------
    */

    const TEXT = {

        welcomeBack: @json(__('common.welcome_back', ['name' => '__NAME__'])),

        noUpcomingDeadline: @json(__('common.no_upcoming_deadline')),

        today: @json(__('common.today')),

        oneDay: @json(__('common.one_day')),

        days: @json(__('common.days', ['count' => '__COUNT__'])),

        deadline: @json(__('common.deadline')),

        updated: @json(__('common.updated')),

        notSpecified: @json(__('common.not_specified')),

        scholarshipOpportunity: @json(__('common.scholarship_opportunity')),

        scholarship: @json(__('common.scholarship')),

        providerNotSpecified: @json(__('common.provider_not_specified')),

        international: @json(__('common.international')),

        internationalNotSpecified: @json(__('common.international_not_specified')),

        descriptionNotAvailable: @json(__('common.description_not_available')),

        noMatchesGenerated: @json(__('common.no_matches_generated')),

        noMatchesGeneratedNote: @json(__('common.no_matches_generated_note')),

        noAiMatches: @json(__('common.no_ai_matches')),

        noAiMatchesNote: @json(__('common.no_ai_matches_note')),

        matchingEngine: @json(__('common.matching_engine')),

        whyMatch: @json(__('common.why_match')),

        hideAnalysis: @json(__('common.hide_analysis')),

        analyzing: @json(__('common.analyzing')),

        matchedCriteria: @json(__('common.matched_criteria')),

        missingCriteria: @json(__('common.missing_criteria')),

        analysisNotes: @json(__('common.analysis_notes')),

        gaps: @json(__('common.gaps')),

        matched: @json(__('common.matched')),

        gapCount: @json(__('common.gap_count')),

        analysis: @json(__('common.analysis')),

        cvConnected: @json(__('common.cv_connected')),

        cvNotConnected: @json(__('common.cv_not_connected')),

        mandatory: @json(__('common.mandatory')),

        optional: @json(__('common.optional')),

        nextStep: @json(__('common.next_step')),

        noUnmetCriteria: @json(__('common.no_unmet_criteria')),

        noSavedApplications: @json(__('common.no_saved_applications')),

        noSavedApplicationsNote: @json(__('common.no_saved_applications_note')),

        dashboardLoadFailed: @json(__('common.dashboard_load_failed')),

        apply: @json(__('common.apply')),

        applied: @json(__('common.applied')),

        applyFailed: @json(__('common.apply_failed'))

    };


    let currentUser = null;

    let currentProfile = null;

    let recommendations = [];

    let applications = [];

    let cvs = [];

    let activeCv = null;

    let tailorContext = null;


    function getToken() {
        return localStorage.getItem('auth_token');
    }


    function goToLogin() {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('auth_user');
        window.location.href = LOGIN_URL;
    }


    function authHeaders() {
        return {
            'Authorization': `Bearer ${getToken()}`,
            'Accept': 'application/json'
        };
    }


    function normalizeCollection(payload) {

        if (Array.isArray(payload)) {
            return payload;
        }

        if (payload && Array.isArray(payload.data)) {
            return payload.data;
        }

        if (payload && Array.isArray(payload.value)) {
            return payload.value;
        }

        return [];
    }


    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }


    function showToast(message) {

        const toast = document.getElementById('toast');

        toast.textContent = message;

        toast.classList.remove('hidden');

        clearTimeout(window.jisrToastTimer);

        window.jisrToastTimer = setTimeout(() => {
            toast.classList.add('hidden');
        }, 3200);
    }


    function formatDate(dateValue) {

        if (!dateValue) {
            return TEXT.notSpecified;
        }

        const date = new Date(dateValue);

        if (Number.isNaN(date.getTime())) {
            return TEXT.notSpecified;
        }

        return new Intl.DateTimeFormat(
            CURRENT_LOCALE === 'ar' ? 'ar' : 'en',
            { month: 'short', day: 'numeric', year: 'numeric' }
        ).format(date);
    }


    function daysUntil(dateValue) {

        if (!dateValue) {
            return null;
        }

        const target = new Date(dateValue);
        const today = new Date();

        target.setHours(0, 0, 0, 0);
        today.setHours(0, 0, 0, 0);

        return Math.ceil(
            (target.getTime() - today.getTime()) / (1000 * 60 * 60 * 24)
        );
    }


    function calculateProfileCompletion(profile) {

        if (!profile) {
            return 0;
        }

        const fields = [
            profile.academic_background,
            profile.degree_level,
            profile.interests,
            profile.country
        ];

        const completed = fields.filter(value => {
            return (
                value !== null &&
                value !== undefined &&
                String(value).trim() !== ''
            );
        }).length;

        return Math.round((completed / fields.length) * 100);
    }


    function getUpcomingApplicationDeadline() {

        const upcoming = applications
            .filter(item => item.scholarship?.application_deadline)
            .map(item => ({
                item,
                days: daysUntil(item.scholarship.application_deadline)
            }))
            .filter(entry => entry.days !== null && entry.days >= 0)
            .sort((a, b) => a.days - b.days);

        return upcoming.length ? upcoming[0] : null;
    }


    function renderStats() {

        document.getElementById('matchCount').textContent =
            recommendations.length;

        document.getElementById('applicationCount').textContent =
            applications.length;

        document.getElementById('profileCompletion').textContent =
            `${calculateProfileCompletion(currentProfile)}%`;

        const nearestDeadline = getUpcomingApplicationDeadline();

        const deadlineValue = document.getElementById('deadlineValue');

        const deadlineNote = document.getElementById('deadlineNote');

        if (!nearestDeadline) {
            deadlineValue.textContent = '—';
            deadlineNote.textContent = TEXT.noUpcomingDeadline;
            return;
        }

        if (nearestDeadline.days === 0) {
            deadlineValue.textContent = TEXT.today;
        }
        else if (nearestDeadline.days === 1) {
            deadlineValue.textContent = TEXT.oneDay;
        }
        else {
            deadlineValue.textContent =
                TEXT.days.replace('__COUNT__', nearestDeadline.days);
        }

        deadlineNote.textContent =
            nearestDeadline.item.scholarship?.title ?? TEXT.deadline;
    }


    function renderBestOpportunity() {

        const container = document.getElementById('bestOpportunity');

        if (!recommendations.length) {

            container.innerHTML = `
                <div class="empty-state">
                    <strong>${escapeHtml(TEXT.noMatchesGenerated)}</strong>
                    ${escapeHtml(TEXT.noMatchesGeneratedNote)}
                </div>
            `;

            return;
        }

        const best = [...recommendations]
            .sort((a, b) => Number(b.match_score || 0) - Number(a.match_score || 0))[0];

        const scholarship = best.scholarship || {};

        container.innerHTML = `
            <div class="best-opportunity">

                <div class="opportunity-top">

                    <div>
                        <h3 class="opportunity-title">
                            ${escapeHtml(scholarship.title || TEXT.scholarshipOpportunity)}
                        </h3>

                        <div class="provider">
                            ${escapeHtml(scholarship.provider_name || TEXT.providerNotSpecified)}
                        </div>

                        <div class="location">
                            ${escapeHtml(scholarship.country || TEXT.internationalNotSpecified)}
                        </div>
                    </div>

                    <div class="match-score">
                        <strong>${Math.round(Number(best.match_score || 0))}%</strong>
                        <small>MATCH</small>
                    </div>

                </div>

                <p class="opportunity-description">
                    ${escapeHtml(scholarship.description || TEXT.descriptionNotAvailable)}
                </p>

            </div>
        `;
    }


    function renderMatches() {

        const grid = document.getElementById('matchesGrid');

        if (!recommendations.length) {

            grid.innerHTML = `
                <div class="empty-state" style="grid-column:1/-1;">
                    <strong>${escapeHtml(TEXT.noAiMatches)}</strong>
                    ${escapeHtml(TEXT.noAiMatchesNote)}
                </div>
            `;

            document.getElementById('matchesGeneratedAt').textContent =
                TEXT.matchingEngine;

            return;
        }

        const sorted = [...recommendations]
            .sort((a, b) => Number(b.match_score || 0) - Number(a.match_score || 0));

        const topMatches = sorted.slice(0, 6);

        grid.innerHTML = topMatches.map(item => {

            const scholarship = item.scholarship || {};

            const schId = Number(
                scholarship.scholarship_id ?? item.scholarship_id
            );

            const existingApp = applications.find(
                a => Number(a.scholarship_id) === schId
            );

            const alreadyApplied =
                existingApp && existingApp.status !== 'saved';

            return `
                <article class="match-card">

                    <span class="match-percent">
                        ${Math.round(Number(item.match_score || 0))}%
                        ${escapeHtml(TEXT.matched)}
                    </span>

                    <h3>${escapeHtml(scholarship.title || TEXT.scholarship)}</h3>

                    <div class="provider">
                        ${escapeHtml(scholarship.provider_name || TEXT.providerNotSpecified)}
                    </div>

                    <div class="match-country">
                        ${escapeHtml(scholarship.country || TEXT.international)}
                    </div>

                    <div class="match-actions">

                        <button
                            type="button"
                            class="why-match-btn"
                            data-recommendation-id="${item.recommendation_id}"
                            onclick="toggleGapAnalysis(this)"
                        >
                            ${escapeHtml(TEXT.whyMatch)}
                        </button>

                        <button
                            type="button"
                            class="why-match-btn apply-btn"
                            data-scholarship-id="${schId}"
                            onclick="applyToScholarship(this)"
                            ${alreadyApplied ? 'disabled' : ''}
                        >
                            ${alreadyApplied
                                ? '? ' + escapeHtml(TEXT.applied)
                                : escapeHtml(TEXT.apply)}
                        </button>

                        <button
                            type="button"
                            class="why-match-btn tailor-btn"
                            data-scholarship-id="${schId}"
                            data-scholarship-title="${escapeHtml(scholarship.title || TEXT.scholarship)}"
                            onclick="openCvTailor(this)"
                        >
                            ${CURRENT_LOCALE === 'ar' ? 'خصّص سيرتك' : 'Tailor CV'}
                        </button>
                        <button
                            type="button"
                            class="why-match-btn cover-letter-btn"
                            data-scholarship-id="${schId}"
                            onclick="generateCoverLetter(this)"
                        >
                            ${CURRENT_LOCALE === 'ar' ? 'إنشاء خطاب تقديم' : 'Generate Cover Letter'}
                        </button>

                        <div
                            id="gap-analysis-${item.recommendation_id}"
                            class="gap-panel hidden"
                        ></div>

                    </div>

                </article>
            `;

        }).join('');

        const generatedAt = recommendations[0]?.generated_at;

        if (generatedAt) {
            document.getElementById('matchesGeneratedAt').textContent =
                `${TEXT.updated}: ${formatDate(generatedAt)}`;
        }
    }


    async function applyToScholarship(btn) {

        const scholarshipId = Number(btn.dataset.scholarshipId);

        if (!scholarshipId) {
            return;
        }

        btn.disabled = true;

        try {

            const response = await fetch(
                `${API_BASE_URL}/saved-applications`,
                {
                    method: 'POST',
                    headers: {
                        ...authHeaders(),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        scholarship_id: scholarshipId,
                        status: 'submitted'
                    })
                }
            );

            if (response.status === 401) {
                goToLogin();
                return;
            }

            // 409 = already applied / saved with a later status, not a real error
            if (!response.ok && response.status !== 409) {
                throw new Error('Apply failed: ' + response.status);
            }

            const fresh = await requestJson(
                `${API_BASE_URL}/saved-applications`,
                { headers: authHeaders() }
            );

            applications = normalizeCollection(fresh);

            renderStats();
            renderMatches();
            renderApplications();
            renderJourney();

        } catch (error) {

            console.error(error);

            btn.disabled = false;

            showToast(TEXT.applyFailed);
        }
    }


    function renderGapAnalysis(data) {

        const summary = data?.summary || {};

        const matched = Array.isArray(data?.matched_criteria)
            ? data.matched_criteria
            : [];

        const mandatoryGaps = Array.isArray(data?.gaps?.mandatory)
            ? data.gaps.mandatory
            : [];

        const optionalGaps = Array.isArray(data?.gaps?.optional)
            ? data.gaps.optional
            : [];

        const warnings = Array.isArray(data?.warnings)
            ? data.warnings
            : [];

        const matchedHtml = matched.length
            ? `
                <div class="gap-block">

                    <div class="gap-block-title">
                        ? ${escapeHtml(TEXT.matchedCriteria)}
                    </div>

                    ${matched.map(item => `
                        <div class="gap-item matched">
                            ${escapeHtml(item.message || `${item.type}: ${item.required_value}`)}
                        </div>
                    `).join('')}

                </div>
            `
            : '';

        const allGaps = [
            ...mandatoryGaps.map(item => ({ ...item, gapLabel: TEXT.mandatory })),
            ...optionalGaps.map(item => ({ ...item, gapLabel: TEXT.optional }))
        ];

        const gapsHtml = allGaps.length
            ? `
                <div class="gap-block">

                    <div class="gap-block-title">
                        ! ${escapeHtml(TEXT.missingCriteria)}
                    </div>

                    ${allGaps.map(item => `

                        <div class="gap-item missing">

                            <strong>${escapeHtml(item.gapLabel)}:</strong>

                            ${escapeHtml(item.message || `${item.type}: ${item.required_value}`)}

                            ${item.suggestion ? `
                                <span class="gap-suggestion">
                                    ${escapeHtml(TEXT.nextStep)}:
                                    ${escapeHtml(item.suggestion)}
                                </span>
                            ` : ''}

                            ${item.course ? `
                                <div class="gap-course">
                                    ??
                                    <a
                                        href="${escapeHtml(item.course.url || '#')}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="gap-course-link"
                                    >
                                        ${escapeHtml(item.course.course_title || '')}
                                    </a>

                                    <span class="gap-course-meta">
                                        ${escapeHtml(item.course.platform || '')}
                                        ${item.course.estimated_duration ? ' · ' + escapeHtml(item.course.estimated_duration) : ''}
                                    </span>
                                </div>
                            ` : ''}

                        </div>

                    `).join('')}

                </div>
            `
            : `
                <div class="gap-block">

                    <div class="gap-block-title">
                        ${escapeHtml(TEXT.gaps)}
                    </div>

                    <div class="gap-item matched">
                        ${escapeHtml(TEXT.noUnmetCriteria)}
                    </div>

                </div>
            `;

        const warningsHtml = warnings.length
            ? `
                <div class="gap-block">

                    <div class="gap-block-title">
                        ${escapeHtml(TEXT.analysisNotes)}
                    </div>

                    ${warnings.map(warning => `
                        <div class="gap-warning">
                            ${escapeHtml(warning.message)}
                        </div>
                    `).join('')}

                </div>
            `
            : '';

        return `
            <div class="gap-summary">

                <span class="gap-chip good">
                    ${Number(summary.matched_criteria || 0)}
                    ${escapeHtml(TEXT.matched)}
                </span>

                <span class="gap-chip ${Number(summary.missing_criteria || 0) > 0 ? 'warning' : 'good'}">
                    ${Number(summary.missing_criteria || 0)}
                    ${escapeHtml(TEXT.gapCount)}
                </span>

                <span class="gap-chip">
                    ${escapeHtml(TEXT.analysis)}:
                    ${escapeHtml(summary.analysis_level || 'unknown')}
                </span>

                <span class="gap-chip ${summary.cv_connected ? 'good' : 'warning'}">
                    CV:
                    ${summary.cv_connected
                        ? escapeHtml(TEXT.cvConnected)
                        : escapeHtml(TEXT.cvNotConnected)}
                </span>

            </div>

            ${matchedHtml}

            ${gapsHtml}

            ${warningsHtml}
        `;
    }


    async function toggleGapAnalysis(button) {

        const recommendationId = button.dataset.recommendationId;

        const panel = document.getElementById(
            `gap-analysis-${recommendationId}`
        );

        if (!panel) {
            return;
        }

        if (panel.dataset.loaded === 'true') {

            panel.classList.toggle('hidden');

            button.textContent = panel.classList.contains('hidden')
                ? TEXT.whyMatch
                : TEXT.hideAnalysis;

            return;
        }

        button.disabled = true;

        button.textContent = TEXT.analyzing;

        try {

            const analysis = await requestJson(
                `${API_BASE_URL}/recommendations/${recommendationId}/gap-analysis`,
                { headers: authHeaders() }
            );

            panel.innerHTML = renderGapAnalysis(analysis);

            panel.dataset.loaded = 'true';

            panel.classList.remove('hidden');

            button.textContent = TEXT.hideAnalysis;

        }
        catch (error) {

            console.error('Gap analysis error:', error);

            showToast(error.message || 'Could not load match analysis.');

            button.textContent = TEXT.whyMatch;

        }
        finally {

            button.disabled = false;

        }
    }


    function renderApplications() {

        const container = document.getElementById('applicationsList');

        if (!applications.length) {

            container.innerHTML = `
                <div class="empty-state">
                    <strong>${escapeHtml(TEXT.noSavedApplications)}</strong>
                    ${escapeHtml(TEXT.noSavedApplicationsNote)}
                </div>
            `;

            return;
        }

        const ordered = [...applications].sort(
            (a, b) =>
                new Date(b.status_updated_at || b.saved_at) -
                new Date(a.status_updated_at || a.saved_at)
        );

        container.innerHTML = ordered.map(application => {

            const scholarship = application.scholarship || {};

            return `
                <article class="application-card">

                    <div class="application-top">

                        <div>

                            <div class="application-title">
                                ${escapeHtml(scholarship.title || TEXT.scholarshipOpportunity)}
                            </div>

                            <div class="provider" style="margin-top:5px;">
                                ${escapeHtml(scholarship.provider_name || TEXT.providerNotSpecified)}
                            </div>

                        </div>

                        <span class="status-badge">
                            ${escapeHtml(application.status || 'saved')}
                        </span>

                    </div>

                    <div class="application-meta">

                        <span>
                            ${escapeHtml(scholarship.country || TEXT.international)}
                        </span>

                        <span>
                            ${escapeHtml(TEXT.deadline)}:
                            ${escapeHtml(formatDate(scholarship.application_deadline))}
                        </span>

                        <span>
                            ${escapeHtml(TEXT.updated)}:
                            ${escapeHtml(formatDate(application.status_updated_at || application.saved_at))}
                        </span>

                    </div>

                </article>
            `;

        }).join('');
    }


    function renderJourney() {

        const profileComplete = calculateProfileCompletion(currentProfile) > 0;

        const hasMatches = recommendations.length > 0;

        const hasApplications = applications.length > 0;

        const hasSubmittedApplication = applications.some(application => {
            return String(application.status || '').toLowerCase() === 'submitted';
        });

        document.getElementById('journeyProfile')
            .classList.toggle('done', profileComplete);

        document.getElementById('journeyMatch')
            .classList.toggle('done', hasMatches);

        document.getElementById('journeyPrepare')
            .classList.toggle('done', hasApplications);

        document.getElementById('journeyApply')
            .classList.toggle('done', hasSubmittedApplication);
    }


    function renderDashboard() {

        renderStats();

        renderBestOpportunity();

        renderMatches();

        renderApplications();

        renderJourney();
    }


    async function requestJson(url, options = {}) {

        const response = await fetch(url, options);

        if (response.status === 401) {

            goToLogin();

            throw new Error('Unauthenticated');
        }

        if (!response.ok) {

            let message = `Request failed with status ${response.status}`;

            try {

                const body = await response.json();

                if (body?.message) {
                    message = body.message;
                }

            }
            catch (_) {}

            throw new Error(message);
        }

        return response.json();
    }


    function closeCvTailor() {
        document.getElementById('cvTailorModal').classList.add('hidden');
        tailorContext = null;
    }

    function suggestionText(item) {
        if (typeof item === 'string') return item;
        return item?.suggested ?? item?.suggestion ?? item?.value ?? item?.text ?? item?.original ?? '';
    }

    function suggestionReason(item) {
        if (!item || typeof item === 'string') return '';
        return item.reason ?? item.why ?? item.explanation ?? '';
    }

    function suggestionFlagged(item) {
        return Boolean(item && typeof item === 'object' && (item.flagged ?? item.warning ?? item.needs_review));
    }

    function getTailorSection(payload, section) {
        const value = payload?.[section] ?? payload?.suggestions?.[section] ?? payload?.tailored?.[section] ?? [];
        return Array.isArray(value) ? value : [];
    }

   function renderTailorSuggestions(payload) {
    const container = document.getElementById('cvTailorSuggestions');
    const status = document.getElementById('cvTailorStatus');
    const saveBtn = document.getElementById('saveTailoredCvBtn');

    // Gemini is temporarily unavailable.
    // Do not present unchanged CV data as AI tailoring.
    if (payload?.fallback === true) {
        container.innerHTML = '';

        status.textContent = CURRENT_LOCALE === 'ar'
            ? 'خدمة تخصيص السيرة بالذكاء الاصطناعي مشغولة مؤقتًا. لم يتم تغيير أي بيانات في سيرتك الذاتية. جرّبي مرة أخرى بعد قليل.'
            : 'AI CV tailoring is temporarily unavailable. No changes were made to your CV. Please try again shortly.';

        saveBtn.disabled = true;
        return;
    }

    const suggestions = Array.isArray(payload?.suggestions)
        ? payload.suggestions
        : [];

    const skillsSuggestion = suggestions.find(
        item => item?.section === 'skills'
    );

    const qualificationsSuggestion = suggestions.find(
        item => item?.section === 'qualifications'
    );

    const skills = Array.isArray(skillsSuggestion?.suggested)
        ? skillsSuggestion.suggested
        : [];

    const qualifications = Array.isArray(qualificationsSuggestion?.suggested)
        ? qualificationsSuggestion.suggested
        : [];

    const sectionHtml = (title, section, items, suggestion) => {
        if (!items.length) return '';

        const reason = suggestion?.reason ?? '';
        const flagged = Boolean(suggestion?.flagged);

        return `
            <div class="tailor-section">
                <h3>${escapeHtml(title)}</h3>

                ${reason
                    ? `<p class="tailor-reason">${escapeHtml(reason)}</p>`
                    : ''
                }

                ${items.map(item => `
                    <label class="tailor-option">
                        <input
                            type="checkbox"
                            class="tailor-choice"
                            data-section="${section}"
                            data-value="${escapeHtml(String(item))}"
                            ${flagged ? '' : 'checked'}
                        >

                        <span>
                            <strong>${escapeHtml(String(item))}</strong>

                            ${flagged
                                ? `<small class="tailor-warning">
                                    ${CURRENT_LOCALE === 'ar'
                                        ? 'يحتاج مراجعتك قبل الحفظ.'
                                        : 'Please review this suggestion before saving.'
                                    }
                                   </small>`
                                : ''
                            }
                        </span>
                    </label>
                `).join('')}
            </div>
        `;
    };

    container.innerHTML =
        sectionHtml(
            CURRENT_LOCALE === 'ar' ? 'المهارات' : 'Skills',
            'skills',
            skills,
            skillsSuggestion
        ) +
        sectionHtml(
            CURRENT_LOCALE === 'ar' ? 'المؤهلات' : 'Qualifications',
            'qualifications',
            qualifications,
            qualificationsSuggestion
        );

    if (!skills.length && !qualifications.length) {
        status.textContent = CURRENT_LOCALE === 'ar'
            ? 'لم يقترح الذكاء الاصطناعي تعديلات آمنة لهذه المنحة. بقيت سيرتك الأصلية دون تغيير.'
            : 'No safe CV changes were suggested for this scholarship. Your original CV remains unchanged.';

        saveBtn.disabled = true;
        return;
    }

    status.textContent = CURRENT_LOCALE === 'ar'
        ? 'راجعي الاقتراحات واختاري ما تريدين حفظه في النسخة المخصصة.'
        : 'Review the suggestions and select what you want to save in the tailored version.';

    saveBtn.disabled = false;
}
    async function openCvTailor(btn) {
        const scholarshipId = Number(btn.dataset.scholarshipId);
        const scholarshipTitle = btn.dataset.scholarshipTitle || '';
        const modal = document.getElementById('cvTailorModal');
        const status = document.getElementById('cvTailorStatus');
        const suggestions = document.getElementById('cvTailorSuggestions');
        const saveBtn = document.getElementById('saveTailoredCvBtn');

        modal.classList.remove('hidden');
        document.getElementById('cvTailorScholarship').textContent = scholarshipTitle;
        suggestions.innerHTML = '';
        saveBtn.disabled = true;

        if (!activeCv) {
            status.textContent = CURRENT_LOCALE === 'ar'
                ? 'لا توجد سيرة ذاتية نشطة. ارفعي سيرتك وراجعي البيانات ثم فعّليها أولًا.'
                : 'No active CV was found. Upload, review, and activate a CV first.';
            return;
        }

        status.textContent = CURRENT_LOCALE === 'ar' ? 'جارٍ تجهيز الاقتراحات...' : 'Preparing suggestions...';
        tailorContext = { cvId: Number(activeCv.cv_id), scholarshipId };

        try {
            const response = await fetch(`${API_BASE_URL}/cv/tailor`, {
                method: 'POST',
                headers: { ...authHeaders(), 'Content-Type': 'application/json' },
                body: JSON.stringify({ cv_id: tailorContext.cvId, scholarship_id: scholarshipId })
            });

            if (response.status === 401) { goToLogin(); return; }
            const body = await response.json().catch(() => ({}));

            if (!response.ok) {
                if (response.status === 503) {
                    status.textContent = CURRENT_LOCALE === 'ar'
                        ? 'خدمة الذكاء الاصطناعي مشغولة مؤقتًا. جرّبي مرة أخرى بعد قليل.'
                        : 'The AI service is temporarily busy. Please try again shortly.';
                    return;
                }
                throw new Error(body?.message || `Tailoring failed: ${response.status}`);
            }

            renderTailorSuggestions(body);
        } catch (error) {
            console.error(error);
            status.textContent = CURRENT_LOCALE === 'ar'
                ? 'تعذر تجهيز اقتراحات السيرة الآن.'
                : 'Could not prepare CV suggestions right now.';
        }
    }

    async function saveTailoredCv() {
        if (!tailorContext) return;

        const selected = [...document.querySelectorAll('.tailor-choice:checked')];
        const accepted = {};
        selected.forEach(input => {
            const section = input.dataset.section;
            accepted[section] ??= [];
            accepted[section].push(input.dataset.value);
        });

        if (!Object.keys(accepted).length) {
            showToast(CURRENT_LOCALE === 'ar' ? 'اختاري اقتراحًا واحدًا على الأقل.' : 'Select at least one suggestion.');
            return;
        }

        const saveBtn = document.getElementById('saveTailoredCvBtn');
        saveBtn.disabled = true;

        try {
            const response = await fetch(`${API_BASE_URL}/cv/tailor/save`, {
                method: 'POST',
                headers: { ...authHeaders(), 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    cv_id: tailorContext.cvId,
                    scholarship_id: tailorContext.scholarshipId,
                    accepted
                })
            });
            if (response.status === 401) { goToLogin(); return; }
            const body = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(body?.message || `Save failed: ${response.status}`);

            closeCvTailor();
            showToast(CURRENT_LOCALE === 'ar'
                ? 'تم حفظ نسخة مخصّصة منفصلة، والسيرة الأصلية لم تتغير.'
                : 'Tailored version saved separately. Your original CV was not changed.');
        } catch (error) {
            console.error(error);
            showToast(error.message || (CURRENT_LOCALE === 'ar' ? 'تعذر حفظ النسخة المخصّصة.' : 'Could not save the tailored version.'));
            saveBtn.disabled = false;
        }
    }

    async function loadDashboard() {

        const token = getToken();

        if (!token) {

            goToLogin();

            return;
        }

        try {

            currentUser = await requestJson(
                `${API_BASE_URL}/me`,
                { headers: authHeaders() }
            );

            localStorage.setItem('auth_user', JSON.stringify(currentUser));

            const displayName =
                currentUser.full_name ||
                currentUser.name ||
                'Student';

            document.getElementById('welcomeHeading').textContent =
                TEXT.welcomeBack.replace('__NAME__', displayName);

            const results = await Promise.allSettled([

                requestJson(`${API_BASE_URL}/profile`, { headers: authHeaders() }),

                requestJson(`${API_BASE_URL}/recommendations`, { headers: authHeaders() }),

                requestJson(`${API_BASE_URL}/saved-applications`, { headers: authHeaders() }),

                requestJson(`${API_BASE_URL}/cvs`, { headers: authHeaders() })

            ]);

            if (results[0].status === 'fulfilled') {
                currentProfile = results[0].value;
            }

            if (results[1].status === 'fulfilled') {
                recommendations = normalizeCollection(results[1].value);
            }

            if (results[2].status === 'fulfilled') {
                applications = normalizeCollection(results[2].value);
            }

            if (results[3].status === 'fulfilled') {
                cvs = normalizeCollection(results[3].value);
                activeCv = cvs.find(cv => cv.is_active === true || Number(cv.is_active) === 1) || null;
            }

            renderDashboard();

            document.getElementById('loadingScreen').classList.add('hidden');

            document.getElementById('appShell').classList.remove('hidden');

        }
        catch (error) {

            console.error('Dashboard loading error:', error);

            if (error.message !== 'Unauthenticated') {

                document.getElementById('loadingScreen').innerHTML = `
                    <div class="empty-state" style="max-width:420px;">
                        <strong>${escapeHtml(TEXT.dashboardLoadFailed)}</strong>
                        ${escapeHtml(error.message)}
                    </div>
                `;
            }
        }
    }


    async function refreshRecommendations() {

        const buttons = [
            document.getElementById('refreshRecommendationsBtn'),
            document.getElementById('refreshRecommendationsQuick')
        ];

        buttons.forEach(button => {
            if (button) {
                button.disabled = true;
            }
        });

        try {

            const result = await requestJson(
                `${API_BASE_URL}/recommendations/generate`,
                {
                    method: 'POST',
                    headers: authHeaders()
                }
            );

            recommendations = normalizeCollection(result.data ?? result);

            if (!recommendations.length) {

                const latest = await requestJson(
                    `${API_BASE_URL}/recommendations`,
                    { headers: authHeaders() }
                );

                recommendations = normalizeCollection(latest);
            }

            renderDashboard();

            showToast(
                CURRENT_LOCALE === 'ar'
                    ? `تم إنشاء ${recommendations.length} مطابقة منحة بنجاح.`
                    : `${recommendations.length} scholarship matches generated successfully.`
            );

        }
        catch (error) {

            console.error(error);

            showToast(
                error.message ||
                (
                    CURRENT_LOCALE === 'ar'
                        ? 'تعذر تحديث المطابقات الآن.'
                        : 'Could not refresh recommendations.'
                )
            );

        }
        finally {

            buttons.forEach(button => {
                if (button) {
                    button.disabled = false;
                }
            });

        }
    }


    async function logout() {

        const token = getToken();

        try {

            if (token) {

                await fetch(
                    `${API_BASE_URL}/logout`,
                    {
                        method: 'POST',
                        headers: authHeaders()
                    }
                );

            }

        }
        catch (_) {}

        goToLogin();
    }


    document.getElementById('logoutBtn')
        .addEventListener('click', logout);

    document.getElementById('refreshRecommendationsBtn')
        .addEventListener('click', refreshRecommendations);

    document.getElementById('refreshRecommendationsQuick')
        .addEventListener('click', refreshRecommendations);

    window.addEventListener('pageshow', () => {
        loadDashboard();
    });
async function openCvVersions() {
    const modal = document.getElementById('cvVersionsModal');
    const status = document.getElementById('cvVersionsStatus');
    const list = document.getElementById('cvVersionsList');

    modal.classList.remove('hidden');

    status.textContent = CURRENT_LOCALE === 'ar'
        ? 'جارٍ تحميل النسخ المحفوظة...'
        : 'Loading saved CV versions...';

    list.innerHTML = '';

    try {
        const versions = await requestJson(`${API_BASE_URL}/cv/versions`, {
            headers: authHeaders()
        });

        if (!Array.isArray(versions) || !versions.length) {
            status.textContent = CURRENT_LOCALE === 'ar'
                ? 'لا توجد نسخ مخصصة محفوظة حتى الآن.'
                : 'No tailored CV versions have been saved yet.';
            return;
        }

        status.textContent = CURRENT_LOCALE === 'ar'
            ? `${versions.length} نسخة محفوظة`
            : `${versions.length} saved version${versions.length === 1 ? '' : 's'}`;

        list.innerHTML = versions.map(version => {

            const scholarship = version.scholarship || {};
            const cv = version.cv || {};
            const content = version.content || {};

            const skills = Array.isArray(content.skills)
                ? content.skills
                : [];

            const qualifications = Array.isArray(content.qualifications)
                ? content.qualifications
                : [];

            const date = version.created_at
                ? new Date(version.created_at).toLocaleDateString(
                    CURRENT_LOCALE === 'ar' ? 'ar' : 'en'
                )
                : '';

            return `
                <div class="tailor-section" style="margin-bottom:16px">

                    <h3>
                        ${escapeHtml(
                            scholarship.title ||
                            (CURRENT_LOCALE === 'ar'
                                ? 'منحة'
                                : 'Scholarship')
                        )}
                    </h3>

                    <p style="margin:4px 0 12px">
                        ${escapeHtml(scholarship.provider_name || '')}
                    </p>

                    <small>
                        ${CURRENT_LOCALE === 'ar' ? 'السيرة الأصلية:' : 'Original CV:'}
                        ${escapeHtml(cv.original_filename || '')}
                        ${date ? ` • ${escapeHtml(date)}` : ''}
                    </small>

                    <div style="margin-top:14px">
                        <strong>
                            ${CURRENT_LOCALE === 'ar' ? 'المهارات' : 'Skills'}
                        </strong>

                        <p>
                            ${skills.length
                                ? skills.map(skill => escapeHtml(String(skill))).join(' • ')
                                : (CURRENT_LOCALE === 'ar'
                                    ? 'لا توجد مهارات محفوظة'
                                    : 'No saved skills')
                            }
                        </p>
                    </div>

                    <div style="margin-top:12px">
                        <strong>
                            ${CURRENT_LOCALE === 'ar'
                                ? 'المؤهلات'
                                : 'Qualifications'}
                        </strong>

                        <p>
                            ${qualifications.length
                                ? qualifications.map(item =>
                                    escapeHtml(String(item))
                                ).join('<br>')
                                : (CURRENT_LOCALE === 'ar'
                                    ? 'لا توجد مؤهلات محفوظة'
                                    : 'No saved qualifications')
                            }
                        </p>
                    </div>

                </div>
            `;
        }).join('');

    } catch (error) {
        console.error(error);

        status.textContent = CURRENT_LOCALE === 'ar'
            ? 'تعذر تحميل نسخ السيرة الذاتية.'
            : 'Could not load CV versions.';
    }
}


function closeCvVersions() {
    document
        .getElementById('cvVersionsModal')
        .classList
        .add('hidden');
}

async function openCoverLetters() {
    const modal=document.getElementById('coverLettersModal'), status=document.getElementById('coverLettersStatus'), list=document.getElementById('coverLettersList');
    modal.classList.remove('hidden');
    status.textContent=CURRENT_LOCALE==='ar'?'جارٍ تحميل خطابات التقديم...':'Loading cover letters...';
    list.innerHTML='';
    try {
        const letters=normalizeCollection(await requestJson(`${API_BASE_URL}/cover-letters`,{headers:authHeaders()}));
        renderCoverLetters(letters);
    } catch(e) {
        console.error(e);
        status.textContent=CURRENT_LOCALE==='ar'?'تعذر تحميل خطابات التقديم.':'Could not load cover letters.';
    }
}
function closeCoverLetters(){ document.getElementById('coverLettersModal').classList.add('hidden'); }

function renderCoverLetters(letters){
    const status=document.getElementById('coverLettersStatus'), list=document.getElementById('coverLettersList');
    if(!letters.length){
        status.textContent=CURRENT_LOCALE==='ar'?'لا توجد خطابات تقديم محفوظة حتى الآن.':'No cover letters have been generated yet.';
        list.innerHTML=''; return;
    }
    status.textContent=CURRENT_LOCALE==='ar'?`${letters.length} خطاب محفوظ`:`${letters.length} saved cover letter${letters.length===1?'':'s'}`;
    list.innerHTML=letters.map(letter=>{
        const scholarship=letter.scholarship||{}, content=letter.content||'', id=Number(letter.cover_letter_id);
        const completed=String(letter.generation_status||'').toLowerCase()==='completed';
        return `<article class="cover-letter-card">
            <h3>${escapeHtml(scholarship.title||TEXT.scholarship)}</h3>
            <div class="cover-letter-meta">${escapeHtml(scholarship.provider_name||TEXT.providerNotSpecified)} · ${escapeHtml(letter.generation_status||'pending')}${letter.completed_at?' · '+escapeHtml(formatDate(letter.completed_at)):''}</div>
            ${completed&&content?`<div class="cover-letter-content">${escapeHtml(content)}</div>`:`<div class="tailor-status">${CURRENT_LOCALE==='ar'?'لم يكتمل إنشاء هذا الخطاب.':'This cover letter was not completed.'}</div>`}
            <div class="cover-letter-actions">
                ${completed&&content?`<button type="button" class="btn btn-secondary copy-cover-btn" data-letter-id="${id}">${CURRENT_LOCALE==='ar'?'نسخ النص':'Copy'}</button>`:''}
                <button type="button" class="btn btn-secondary" onclick="deleteCoverLetter(${id})">${CURRENT_LOCALE==='ar'?'حذف':'Delete'}</button>
            </div>
        </article>`;
    }).join('');
    document.querySelectorAll('.copy-cover-btn').forEach(btn=>{
        btn.addEventListener('click',()=>{
            const item=letters.find(x=>Number(x.cover_letter_id)===Number(btn.dataset.letterId));
            copyCoverLetter(item?.content||'');
        });
    });
}

async function generateCoverLetter(btn){
    const scholarshipId=Number(btn.dataset.scholarshipId); if(!scholarshipId)return;
    const original=btn.textContent; btn.disabled=true;
    btn.textContent=CURRENT_LOCALE==='ar'?'جارٍ إنشاء الخطاب...':'Generating...';
    try{
        const r=await fetch(`${API_BASE_URL}/cover-letters`,{method:'POST',headers:{...authHeaders(),'Content-Type':'application/json'},body:JSON.stringify({scholarship_id:scholarshipId})});
        if(r.status===401){goToLogin();return;}
        const body=await r.json().catch(()=>({}));
        if(!r.ok){
            if([502,503,504].includes(r.status)) throw new Error(CURRENT_LOCALE==='ar'?'خدمة الذكاء الاصطناعي مشغولة مؤقتًا. جرّبي مرة أخرى بعد قليل.':'The AI service is temporarily busy. Please try again shortly.');
            throw new Error(body?.message||`Generation failed: ${r.status}`);
        }
        showToast(CURRENT_LOCALE==='ar'?'تم إنشاء خطاب التقديم وحفظه بنجاح.':'Cover letter generated and saved successfully.');
        await openCoverLetters();
    }catch(e){ console.error(e); showToast(e.message||(CURRENT_LOCALE==='ar'?'تعذر إنشاء خطاب التقديم الآن.':'Could not generate the cover letter right now.')); }
    finally{btn.disabled=false;btn.textContent=original;}
}
async function deleteCoverLetter(id){
    try{
        const r=await fetch(`${API_BASE_URL}/cover-letters/${id}`,{method:'DELETE',headers:authHeaders()});
        if(r.status===401){goToLogin();return;}
        const body=await r.json().catch(()=>({}));
        if(!r.ok)throw new Error(body?.message||`Delete failed: ${r.status}`);
        showToast(CURRENT_LOCALE==='ar'?'تم حذف خطاب التقديم.':'Cover letter deleted.');
        await openCoverLetters();
    }catch(e){console.error(e);showToast(e.message||(CURRENT_LOCALE==='ar'?'تعذر حذف الخطاب.':'Could not delete the cover letter.'));}
}
async function copyCoverLetter(content){
    try{await navigator.clipboard.writeText(content);showToast(CURRENT_LOCALE==='ar'?'تم نسخ الخطاب.':'Cover letter copied.');}
    catch(_){showToast(CURRENT_LOCALE==='ar'?'تعذر نسخ النص تلقائيًا.':'Could not copy automatically.');}
}


function notificationTypeLabel(value) {
    const raw=String(value||'').trim();
    if(!raw) return CURRENT_LOCALE==='ar'?'تذكير':'Reminder';
    return raw.replace(/[_-]+/g,' ').replace(/\b\w/g,c=>c.toUpperCase());
}
async function openNotifications(){
    const modal=document.getElementById('notificationsModal'),status=document.getElementById('notificationsStatus'),list=document.getElementById('notificationsList');
    modal.classList.remove('hidden');
    status.textContent=CURRENT_LOCALE==='ar'?'جارٍ تحميل الإشعارات...':'Loading notifications...';
    list.innerHTML='';
    try{
        const items=normalizeCollection(await requestJson(`${API_BASE_URL}/notifications`,{headers:authHeaders()}));
        renderNotifications(items);
    }catch(e){console.error(e);status.textContent=CURRENT_LOCALE==='ar'?'تعذر تحميل الإشعارات.':'Could not load notifications.';}
}
function closeNotifications(){document.getElementById('notificationsModal').classList.add('hidden');}
function renderNotifications(items){
    const status=document.getElementById('notificationsStatus'),list=document.getElementById('notificationsList');
    if(!items.length){status.textContent=CURRENT_LOCALE==='ar'?'لا توجد إشعارات أو تذكيرات حتى الآن.':'No notifications or reminders yet.';list.innerHTML='';return;}
    status.textContent=CURRENT_LOCALE==='ar'?`${items.length} إشعار`:`${items.length} notification${items.length===1?'':'s'}`;
    list.innerHTML=items.map(item=>{
        const app=item.saved_application||item.savedApplication||{},sch=app.scholarship||{},id=Number(item.notification_id);
        const title=sch.title||(CURRENT_LOCALE==='ar'?'تذكير بمنحة':'Scholarship reminder');
        const provider=sch.provider_name||'';
        const days=item.reminder_window_days;
        const reminder=(days!==null&&days!==undefined)?(CURRENT_LOCALE==='ar'?`${days} يوم قبل الموعد`:`${days} day${Number(days)===1?'':'s'} before deadline`):'';
        const scheduled=item.scheduled_for?formatDate(item.scheduled_for):TEXT.notSpecified;
        const sent=item.sent_at?formatDate(item.sent_at):'';
        return `<article class="notification-card"><div class="notification-top"><div><h3>${escapeHtml(title)}</h3>${provider?`<div class="provider">${escapeHtml(provider)}</div>`:''}</div><span class="notification-status">${escapeHtml(item.status||'pending')}</span></div>
        <div class="notification-meta"><span>${escapeHtml(notificationTypeLabel(item.notification_type))}</span>${reminder?`<span>${escapeHtml(reminder)}</span>`:''}<span>${CURRENT_LOCALE==='ar'?'مجدول:':'Scheduled:'} ${escapeHtml(scheduled)}</span><span>${CURRENT_LOCALE==='ar'?'القناة:':'Channel:'} ${escapeHtml(item.channel||TEXT.notSpecified)}</span>${sent?`<span>${CURRENT_LOCALE==='ar'?'أُرسل:':'Sent:'} ${escapeHtml(sent)}</span>`:''}</div>
        <div class="notification-actions"><button type="button" class="btn btn-secondary" onclick="deleteNotification(${id})">${CURRENT_LOCALE==='ar'?'حذف':'Delete'}</button></div></article>`;
    }).join('');
}
async function deleteNotification(id){
    if(!id)return;
    try{
        const r=await fetch(`${API_BASE_URL}/notifications/${id}`,{method:'DELETE',headers:authHeaders()});
        if(r.status===401){goToLogin();return;}
        const body=await r.json().catch(()=>({}));
        if(!r.ok)throw new Error(body?.message||`Delete failed: ${r.status}`);
        showToast(CURRENT_LOCALE==='ar'?'تم حذف الإشعار.':'Notification deleted.');
        await openNotifications();
    }catch(e){console.error(e);showToast(e.message||(CURRENT_LOCALE==='ar'?'تعذر حذف الإشعار.':'Could not delete the notification.'));}
}
</script>

</body>
</html> 


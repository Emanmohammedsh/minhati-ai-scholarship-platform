<!DOCTYPE html>
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ __('common.student_dashboard') }} | Jisr AI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>

        :root {
            --primary: #0A2E6B;
            --primary-dark: #071F49;
            --secondary: #00AEEF;
            --accent: #87DFFF;

            --background: rgba(15,23,42,.05);
            --surface: #FFFFFF;
            --surface-soft: #F3F6FB;

            --text: rgba(15,23,42,.75);
            --heading: #0F172A;
            --muted: rgba(15,23,42,.55);

            --border: rgba(15,23,42,.10);

            --success: #16A672;
            --warning: #B7791F;
            --danger: #E4574C;

            --shadow:
                0 18px 40px rgba(15,23,42,.08);

            --page-bg: #F4F7FB;
            --page-glow-1: rgba(14,124,144,.06);
            --page-glow-2: rgba(79,140,255,.07);

            --loader-ring: rgba(15,23,42,.10);
            --location-text: rgba(15,23,42,.45);
            --journey-circle-border: rgba(15,23,42,.15);
            --journey-circle-bg: rgba(15,23,42,.03);
            --journey-line: rgba(15,23,42,.12);
            --match-score-border: rgba(14,124,144,.18);
            --match-score-bg: rgba(14,124,144,.05);
            --match-score-shadow: rgba(15,23,42,.08);
            --gap-chip-bg: rgba(15,23,42,.05);
            --gap-item-bg: rgba(15,23,42,.035);
            --empty-border: rgba(15,23,42,.18);
        }


        body.theme-dark {
            --primary: #38DFEA;
            --primary-dark: #1B4965;
            --secondary: #4F8CFF;
            --accent: #7DD3FC;

            --background: rgba(255,255,255,.06);
            --surface: rgba(13,20,38,.68);
            --surface-soft: rgba(255,255,255,.03);

            --text: rgba(255,255,255,.78);
            --heading: #FFFFFF;
            --muted: rgba(255,255,255,.55);

            --border: rgba(255,255,255,.14);

            --success: #34D399;
            --warning: #FBBF24;
            --danger: #F87171;

            --shadow:
                0 24px 60px rgba(0,0,0,.45);

            --page-bg: #0B1220;
            --page-glow-1: rgba(56,223,234,.13);
            --page-glow-2: rgba(79,140,255,.16);

            --loader-ring: rgba(255,255,255,.10);
            --location-text: rgba(255,255,255,.45);
            --journey-circle-border: rgba(255,255,255,.18);
            --journey-circle-bg: rgba(255,255,255,.04);
            --journey-line: rgba(255,255,255,.14);
            --match-score-border: rgba(56,223,234,.22);
            --match-score-bg: rgba(255,255,255,.06);
            --match-score-shadow: rgba(0,0,0,.35);
            --gap-chip-bg: rgba(255,255,255,.06);
            --gap-item-bg: rgba(255,255,255,.04);
            --empty-border: rgba(255,255,255,.18);
        }


        body.theme-dark .glass {
            background: var(--surface);

            backdrop-filter:
                blur(18px);

            -webkit-backdrop-filter:
                blur(18px);
        }


        * {
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            margin: 0;

            min-height: 100vh;

            color: var(--text);

            font-family:
                {{ app()->getLocale() === 'ar'
                    ? "'Cairo', Arial, sans-serif"
                    : "'Poppins', 'Inter', Arial, sans-serif"
                }};

            background:
                radial-gradient(
                    circle at 92% 5%,
                    var(--page-glow-1),
                    transparent 26%
                ),
                radial-gradient(
                    circle at 5% 65%,
                    var(--page-glow-2),
                    transparent 25%
                ),
                var(--page-bg);

            transition:
                background-color .25s ease,
                color .25s ease;
        }


        button,
        a {
            font-family: inherit;
        }


        a {
            text-decoration: none;
            color: inherit;
        }


        .hidden {
            display: none !important;
        }


        /* =====================================
           LOADING
        ===================================== */

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

            border:
                4px solid var(--loader-ring);

            border-top-color:
                var(--secondary);

            border-radius: 50%;

            animation:
                spin .8s linear infinite;
        }


        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }


        .loading-text {
            color: var(--muted);
            font-size: 14px;
        }


        /* =====================================
           TOPBAR
        ===================================== */

        .topbar {
            position: sticky;

            top: 0;

            z-index: 30;

            border-bottom:
                1px solid rgba(255,255,255,.10);

            background:
                rgba(11,18,32,.75);

            backdrop-filter:
                blur(20px);

            -webkit-backdrop-filter:
                blur(20px);
        }


        .topbar-inner {
            width:
                min(1180px, calc(100% - 32px));

            margin: auto;

            min-height: 78px;

            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }


        .brand {
            display: flex;
            align-items: center;

            gap: 12px;
        }


        .brand-logo {
            width: 50px;
            height: 50px;

            object-fit: contain;

            border-radius: 13px;
        }


        .brand-copy {
            line-height: 1.1;
        }


        .brand-name {
            display: block;

            font-family:
                "Poppins",
                sans-serif;

            color: #FFFFFF;

            font-size: 19px;
            font-weight: 700;
        }


        .brand-slogan {
            display: block;

            margin-top: 5px;

            color: rgba(255,255,255,.55);

            font-family:
                "Poppins",
                sans-serif;

            font-size: 9px;

            letter-spacing: 1.25px;
        }


        .top-actions {
            display: flex;

            align-items: center;

            gap: 8px;
        }


        .nav-link,
        .logout-btn {
            border-radius: 10px;

            padding: 10px 13px;

            font-size: 12px;

            font-weight: 600;

            transition: .2s ease;
        }


        .nav-link {
            color: rgba(255,255,255,.85);
        }


        .nav-link:hover {
            background: rgba(255,255,255,.10);
            color: #FFFFFF;
        }


        .language-switcher {
            display: flex;

            align-items: center;

            gap: 7px;

            direction: ltr;

            padding: 7px 10px;

            border-radius: 10px;

            background: rgba(255,255,255,.08);

            font-family:
                "Poppins",
                sans-serif;

            font-size: 11px;

            font-weight: 600;
        }


        .language-switcher a {
            color: rgba(255,255,255,.55);
        }


        .language-switcher a.active {
            color: var(--accent);

            font-weight: 700;
        }


        .language-switcher span {
            color: rgba(255,255,255,.22);
        }


        .logout-btn {
            border: 1px solid rgba(255,255,255,.20);

            color: rgba(255,255,255,.90);

            background: rgba(255,255,255,.06);

            cursor: pointer;
        }


        .logout-btn:hover {
            transform: translateY(-1px);

            background: rgba(255,255,255,.14);

            color: #FFFFFF;
        }


        .theme-toggle-btn {
            width: 36px;
            height: 36px;

            flex: 0 0 36px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 10px;

            border: 1px solid rgba(255,255,255,.20);

            background: rgba(255,255,255,.06);

            color: rgba(255,255,255,.90);

            font-size: 15px;

            cursor: pointer;

            transition: .2s ease;
        }


        .theme-toggle-btn:hover {
            background: rgba(255,255,255,.14);

            transform: translateY(-1px);
        }


        /* =====================================
           MAIN
        ===================================== */

        main {
            width:
                min(1180px, calc(100% - 32px));

            margin:
                0 auto;

            padding:
                22px 0 36px;
        }


        /* =====================================
           HERO
        ===================================== */

        .hero {
            position: relative;

            overflow: hidden;

            display: flex;

            justify-content: space-between;

            gap: 30px;

            align-items: center;

            margin-bottom: 16px;

            padding: 22px 30px;

            border-radius: 20px;

            color: white;

            background:
                linear-gradient(
                    125deg,
                    #0B1220 0%,
                    #123057 58%,
                    #175A8A 100%
                );

            border:
                1px solid var(--border);

            box-shadow:
                0 25px 65px rgba(0,0,0,.45);
        }


        .hero::after {
            content: "";

            position: absolute;

            width: 300px;
            height: 300px;

            border-radius: 50%;

            inset-inline-end: -100px;

            top: -170px;

            background:
                rgba(56,223,234,.16);
        }


        .hero-content {
            position: relative;

            z-index: 2;

            max-width: 690px;
        }


        .eyebrow {
            margin:
                0 0 9px;

            text-transform: uppercase;

            letter-spacing: 1.6px;

            color: var(--accent);

            font-size: 11px;

            font-weight: 700;
        }


        .hero h1 {
            margin: 0;

            font-family:
                {{ app()->getLocale() === 'ar'
                    ? "'Cairo', Arial, sans-serif"
                    : "'Poppins', Arial, sans-serif"
                }};

            font-size:
                clamp(22px, 3vw, 32px);

            line-height: 1.15;

            letter-spacing: -.8px;
        }


        .hero p {
            margin:
                8px 0 0;

            color: #D8ECF8;

            line-height: 1.6;

            font-size: 13px;
        }


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

            transition:
                transform .2s ease,
                opacity .2s ease,
                background .2s ease;
        }


        .btn:hover {
            transform:
                translateY(-1px);
        }


        .btn-primary {
            background:
                linear-gradient(
                    135deg,
                    var(--secondary),
                    #38DFEA
                );

            color: #06131F;

            box-shadow:
                0 10px 25px rgba(56,223,234,.22);
        }


        .btn-secondary {
            color: white;

            background:
                rgba(255,255,255,.09);

            border:
                1px solid rgba(255,255,255,.20);
        }


        .btn:disabled {
            opacity: .55;

            cursor: wait;

            transform: none;
        }


        /* =====================================
           CARDS
        ===================================== */

        .glass {
            background: #FFFFFF;

            border:
                1px solid var(--border);

            box-shadow: var(--shadow);
        }


        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4,1fr);

            gap: 12px;

            margin-bottom: 14px;
        }


        .stat-card {
            border-radius: 14px;

            padding: 14px 16px;

            min-height: 88px;

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

            background:
                radial-gradient(
                    circle,
                    rgba(56,223,234,.16),
                    transparent 70%
                );
        }


        .stat-label {
            color: var(--muted);

            font-size: 11px;

            font-weight: 600;

            margin-bottom: 8px;
        }


        .stat-value {
            color: var(--primary);

            font-family:
                "Poppins",
                sans-serif;

            font-size: 23px;

            font-weight: 700;

            line-height: 1;
        }


        .stat-note {
            color: var(--muted);

            font-size: 10px;

            margin-top: 6px;

            line-height: 1.4;
        }


        .dashboard-grid {
            display: grid;

            grid-template-columns:
                minmax(0,1.45fr)
                minmax(280px,.75fr);

            gap: 14px;

            margin-bottom: 14px;
        }


        .section-card {
            border-radius: 16px;

            padding: 16px 18px;
        }


        .section-heading {
            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;

            margin-bottom: 14px;
        }


        .section-heading h2 {
            margin: 0;

            color: var(--heading);

            font-size: 18px;
        }


        .section-heading p {
            margin:
                5px 0 0;

            color: var(--muted);

            font-size: 12px;
        }


        .section-tag {
            font-size: 10px;

            color: var(--primary);

            padding: 7px 10px;

            border-radius: 999px;

            background:
                rgba(56,223,234,.08);

            border:
                1px solid rgba(56,223,234,.20);

            white-space: nowrap;
        }


        /* =====================================
           BEST OPPORTUNITY
        ===================================== */

        .best-opportunity {
            border-radius: 14px;

            padding: 16px;

            background:
                linear-gradient(
                    135deg,
                    rgba(56,223,234,.09),
                    rgba(79,140,255,.05)
                );

            border:
                1px solid var(--border);
        }


        .opportunity-top {
            display: flex;

            justify-content: space-between;

            gap: 20px;
        }


        .opportunity-title {
            margin:
                0 0 7px;

            color: var(--heading);

            font-size: 21px;
        }


        .provider {
            color: var(--muted);

            font-size: 13px;
        }


        .location {
            color: var(--location-text);

            margin-top: 12px;

            font-size: 13px;
        }


        .match-score {
            width: 76px;
            height: 76px;

            flex:
                0 0 76px;

            border-radius: 50%;

            display: flex;

            align-items: center;
            justify-content: center;

            flex-direction: column;

            border:
                6px solid var(--match-score-border);

            background: var(--match-score-bg);

            box-shadow:
                0 8px 20px var(--match-score-shadow);
        }


        .match-score strong {
            font-family:
                "Poppins",
                sans-serif;

            font-size: 19px;

            color: var(--primary);
        }


        .match-score small {
            color: var(--muted);

            font-size: 9px;
        }


        .opportunity-description {
            color: var(--muted);

            line-height: 1.6;

            font-size: 12px;

            margin:
                12px 0 0;
        }


        /* =====================================
           JOURNEY
        ===================================== */

        .journey {
            display: flex;

            flex-direction: column;

            gap: 0;
        }


        .journey-item {
            display: grid;

            grid-template-columns:
                30px 1fr;

            gap: 12px;

            min-height: 44px;
        }


        html[dir="rtl"] .journey-item {
            grid-template-columns:
                30px 1fr;
        }


        .journey-marker {
            display: flex;

            flex-direction: column;

            align-items: center;
        }


        .journey-circle {
            width: 25px;
            height: 25px;

            flex:
                0 0 25px;

            border-radius: 50%;

            border:
                1px solid var(--journey-circle-border);

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 11px;

            color: var(--primary);

            background: var(--journey-circle-bg);
        }


        .journey-item.done .journey-circle {
            background:
                rgba(52,211,153,.12);

            border-color:
                rgba(52,211,153,.40);

            color: var(--success);
        }


        .journey-line {
            width: 1px;

            flex: 1;

            background: var(--journey-line);
        }


        .journey-content strong {
            display: block;

            color: var(--heading);

            font-size: 13px;

            margin-top: 3px;
        }


        .journey-content small {
            display: block;

            color: var(--muted);

            margin-top: 4px;

            font-size: 11px;
        }


        /* =====================================
           MATCHES
        ===================================== */

        .matches-grid {
            display: grid;

            grid-template-columns:
                repeat(3,1fr);

            gap: 14px;
        }


        .match-card {
            min-height: 150px;

            padding: 14px;

            border-radius: 13px;

            background: var(--surface-soft);

            border:
                1px solid var(--border);

            display: flex;

            flex-direction: column;

            transition: .25s ease;
        }


        .match-card:hover {
            transform:
                translateY(-3px);

            box-shadow:
                0 14px 35px rgba(0,0,0,.35);

            border-color:
                rgba(56,223,234,.30);
        }


        .match-percent {
            width: fit-content;

            color: var(--primary);

            font-size: 11px;

            font-weight: 700;

            padding: 6px 9px;

            border-radius: 999px;

            background:
                rgba(56,223,234,.10);
        }


        .match-card h3 {
            margin:
                15px 0 7px;

            color: var(--heading);

            font-size: 15px;

            line-height: 1.4;
        }


        .match-card .provider {
            font-size: 11px;
        }


        .match-country {
            margin-top: auto;

            padding-top: 16px;

            color: var(--muted);

            font-size: 11px;
        }


        /* =====================================
           APPLICATIONS
        ===================================== */

        .application-card {
            border-radius: 15px;

            border:
                1px solid var(--border);

            padding: 18px;

            background:
                var(--surface-soft);
        }


        .application-card +
        .application-card {
            margin-top: 10px;
        }


        .application-top {
            display: flex;

            justify-content: space-between;

            gap: 18px;
        }


        .application-title {
            color: var(--heading);

            font-weight: 600;

            font-size: 15px;
        }


        .notification-unread {
            border-inline-start: 3px solid #2563eb;
            background: rgba(37, 99, 235, 0.05);
        }
        .unread-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2563eb;
            margin-inline-end: 4px;
        }
        .status-badge {
            flex: 0 0 auto;

            text-transform: capitalize;

            font-size: 10px;

            font-weight: 700;

            padding: 6px 9px;

            border-radius: 999px;

            background:
                rgba(56,223,234,.12);

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


        /* =====================================
           QUICK ACTIONS
        ===================================== */

        .quick-actions {
            display: grid;

            grid-template-columns:
                repeat(3,1fr);

            gap: 12px;
        }


        .quick-action,
        a.quick-action {
            display: block;

            color: var(--heading) !important;

            text-decoration: none !important;

            border:
                1px solid var(--border);

            border-radius: 14px;

            padding: 17px;

            background: var(--surface-soft);

            cursor: pointer;

            transition: .2s;

            text-align: start;
        }


        .quick-action:hover,
        a.quick-action:hover {
            background: var(--background);

            border-color:
                rgba(56,223,234,.30);

            transform:
                translateY(-2px);

            text-decoration: none !important;
        }


        .quick-action strong {
            display: block;

            color: var(--heading) !important;

            text-decoration: none !important;

            font-size: 13px;

            font-weight: 600;
        }


        .quick-action span {
            display: block;

            color: var(--muted) !important;

            text-decoration: none !important;

            font-size: 11px;

            line-height: 1.5;

            margin-top: 5px;
        }


        /* =====================================
           GAP ANALYSIS
        ===================================== */

        .match-actions {
            margin-top: 14px;

            padding-top: 14px;

            border-top:
                1px solid var(--border);
        }


        .why-match-btn {
            width: 100%;

            border:
                1px solid rgba(56,223,234,.25);

            background:
                rgba(56,223,234,.08);

            color: var(--primary);

            border-radius: 10px;

            padding: 9px 11px;

            font-size: 11px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;
        }


        .why-match-btn:hover {
            background:
                rgba(56,223,234,.15);
        }


        .why-match-btn:disabled {
            opacity: .55;

            cursor: wait;
        }


        .apply-btn {
            margin-top: 8px;
        }


        .apply-btn:disabled {
            opacity: 1;

            cursor: default;

            color: var(--success);

            border-color:
                rgba(52,211,153,.30);

            background:
                rgba(52,211,153,.08);
        }


        .gap-panel {
            margin-top: 12px;

            padding: 13px;

            border-radius: 12px;

            border:
                1px solid var(--border);

            background: var(--surface-soft);

            font-size: 11px;

            line-height: 1.55;
        }


        .gap-summary {
            display: flex;

            flex-wrap: wrap;

            gap: 7px;

            margin-bottom: 12px;
        }


        .gap-chip {
            padding: 5px 8px;

            border-radius: 999px;

            background: var(--gap-chip-bg);

            color: var(--muted);

            border:
                1px solid var(--border);
        }


        .gap-chip.good {
            color: var(--success);

            border-color:
                rgba(52,211,153,.25);

            background:
                rgba(52,211,153,.08);
        }


        .gap-chip.warning {
            color: var(--warning);

            border-color:
                rgba(251,191,36,.28);

            background:
                rgba(251,191,36,.08);
        }


        .gap-block +
        .gap-block {
            margin-top: 12px;
        }


        .gap-block-title {
            color: var(--heading);

            font-weight: 700;

            margin-bottom: 7px;
        }


        .gap-item {
            color: var(--muted);

            padding: 7px 9px;

            border-radius: 9px;

            background: var(--gap-item-bg);
        }


        .gap-item +
        .gap-item {
            margin-top: 6px;
        }


        .gap-item.matched {
            border-inline-start:
                2px solid var(--success);
        }


        .gap-item.missing {
            border-inline-start:
                2px solid var(--warning);
        }

        .gap-suggestion {
            display: block;

            color: var(--muted);

            margin-top: 4px;
        }


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

            color: var(--warning);

            background:
                rgba(251,191,36,.10);

            border:
                1px solid rgba(251,191,36,.28);
        }


        /* =====================================
           EMPTY
        ===================================== */

        .empty-state {
            padding:
                28px 15px;

            text-align: center;

            color: var(--muted);

            border-radius: 14px;

            border:
                1px dashed var(--empty-border);
        }


        .empty-state strong {
            display: block;

            color: var(--heading);

            margin-bottom: 6px;
        }


        /* =====================================
           TOAST
        ===================================== */

        .toast {
            position: fixed;

            inset-inline-end: 20px;

            bottom: 20px;

            z-index: 100;

            min-width: 250px;

            max-width: 360px;

            padding: 14px 16px;

            background: rgba(15,23,42,.96);

            border:
                1px solid rgba(255,255,255,.12);

            color: #FFFFFF;

            border-radius: 12px;

            box-shadow: var(--shadow);

            font-size: 13px;

            transition: .25s;
        }


        /* =====================================
           RESPONSIVE
        ===================================== */

        @media(max-width: 900px) {

            .stats-grid {
                grid-template-columns:
                    repeat(2,1fr);
            }


            .dashboard-grid {
                grid-template-columns: 1fr;
            }


            .matches-grid {
                grid-template-columns:
                    1fr 1fr;
            }


            .hero {
                align-items: flex-start;

                flex-direction: column;
            }


            .hero-actions {
                min-width: 0;
            }

        }


        @media(max-width: 700px) {

            .brand-copy {
                display: none;
            }


            .nav-link {
                display: none;
            }


            .topbar-inner,
            main {
                width:
                    min(100% - 22px,1180px);
            }


            .topbar-inner {
                min-height: 68px;
            }


            main {
                padding-top: 27px;
            }


            .hero {
                padding: 27px 23px;

                border-radius: 20px;
            }


            .hero-actions {
                width: 100%;
            }


            .hero-actions .btn {
                flex: 1;
            }


            .stats-grid,
            .matches-grid,
            .quick-actions {
                grid-template-columns: 1fr;
            }


            .opportunity-top {
                flex-direction: column;
            }


            .match-score {
                width: 67px;
                height: 67px;

                flex-basis: 67px;
            }


            .section-card {
                padding: 18px;
            }

        }


        @media(max-width: 480px) {

            .language-switcher {
                padding: 6px 8px;
            }


            .logout-btn {
                padding: 9px 10px;

                font-size: 11px;
            }


            .brand-logo {
                width: 44px;
                height: 44px;
            }

        }


        /* =====================================
           JISR UI POLISH — aligned with Welcome
        ===================================== */
        .brand-logo-shell {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }
        .brand-logo { width: 118px; height: 46px; object-fit: contain; border-radius: 0; }
        .brand-logo-dark { display: none; width: 130px; height: 50px; }
        body.theme-dark .brand-logo-light { display: none; }
        body.theme-dark .brand-logo-dark { display: block; }
        body:not(.theme-dark) .brand-logo-light { display: block; }
        body:not(.theme-dark) .brand-logo-dark { display: none; }

        .topbar {
            background: rgba(255,255,255,.94);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 8px 28px rgba(10,46,107,.05);
        }
        body.theme-dark .topbar { background: rgba(6,20,38,.92); }
        .brand-name { color: var(--primary); }
        body.theme-dark .brand-name { color: #fff; }
        .brand-slogan { color: var(--muted); }
        .nav-link { color: var(--heading); }
        .nav-link:hover { background: rgba(0,174,239,.08); color: var(--primary); }
        body.theme-dark .nav-link { color: rgba(255,255,255,.86); }
        .language-switcher { background: var(--surface-soft); border: 1px solid var(--border); }
        .language-switcher a { color: var(--muted); }
        .language-switcher a.active { color: var(--secondary); }
        .language-switcher span { color: var(--border); }
        .logout-btn, .theme-toggle-btn {
            color: var(--heading); background: var(--surface-soft); border-color: var(--border);
        }
        body.theme-dark .logout-btn, body.theme-dark .theme-toggle-btn { color: #fff; }
        .logout-btn:hover, .theme-toggle-btn:hover { background: rgba(0,174,239,.10); }

        .hero {
            background: linear-gradient(120deg,#0A2E6B 0%,#0B4E8A 62%,#00AEEF 145%);
            box-shadow: 0 18px 50px rgba(10,46,107,.18);
            border-radius: 24px;
        }
        .hero::after { background: rgba(135,223,255,.20); }
        .btn-primary { background: linear-gradient(135deg,#00AEEF,#87DFFF); color:#06203a; }
        .glass { border-radius: 18px; box-shadow: 0 10px 32px rgba(10,46,107,.07); }
        .stat-card { min-height: 104px; padding: 18px; }
        .stat-value { color: var(--primary); font-size: 26px; }
        body.theme-dark .stat-value { color: #38DFEA; }
        .section-card { padding: 20px 22px; }
        .best-opportunity { border-radius: 16px; background: linear-gradient(135deg,rgba(0,174,239,.08),rgba(10,46,107,.035)); }
        .match-card { min-height: 178px; border-radius: 16px; padding: 17px; }
        .match-card:hover { box-shadow: 0 14px 32px rgba(10,46,107,.12); }
        .quick-action, a.quick-action { border-radius: 16px; }
        .section-tag, .match-percent { color: var(--primary); background: rgba(0,174,239,.08); border-color: rgba(0,174,239,.18); }
        body.theme-dark .section-tag, body.theme-dark .match-percent { color:#38DFEA; }
        .why-match-btn { color: var(--primary); border-color: rgba(0,174,239,.22); background: rgba(0,174,239,.07); }
        body.theme-dark .why-match-btn { color:#38DFEA; }

        @media(max-width:700px){
            .brand-logo { width: 102px; height: 40px; }
            .brand-logo-dark { width: 112px; height: 43px; }
        }

    
/* ===== JISR DASHBOARD UX/UI V2 ===== */
body{background:#F6F9FD}
body.theme-dark{background:#08111F}
.topbar-inner{min-height:72px}
.brand-logo-shell{background:transparent!important;padding:0!important;border:0!important;border-radius:0!important}
.brand-logo{width:118px;height:44px;object-fit:contain;border-radius:0}
.brand-logo-dark{display:none;width:132px;height:50px}
body.theme-dark .brand-logo-light{display:none!important}
body.theme-dark .brand-logo-dark{display:block!important}
body:not(.theme-dark) .brand-logo-light{display:block!important}
body:not(.theme-dark) .brand-logo-dark{display:none!important}
.brand-copy{display:none}
.top-actions{gap:5px}
.nav-link{padding:9px 11px;font-size:12px;border-radius:10px}
main{width:min(1160px,calc(100% - 34px));padding:26px 0 46px}
.hero{min-height:154px;padding:28px 32px;margin-bottom:14px;border-radius:24px;background:radial-gradient(circle at 9% 115%,rgba(135,223,255,.28),transparent 32%),linear-gradient(120deg,#0A2E6B 0%,#07528E 62%,#008FC8 120%);box-shadow:0 18px 42px rgba(10,46,107,.16);border:0}
body.theme-dark .hero{background:radial-gradient(circle at 9% 115%,rgba(56,223,234,.18),transparent 32%),linear-gradient(120deg,#0B2347 0%,#0A3D69 62%,#075F7E 120%)}
.hero::after{width:260px;height:260px;top:-145px;inset-inline-end:-65px;background:rgba(135,223,255,.13)}
.hero-content{max-width:650px}.eyebrow{margin-bottom:7px;color:#AEEBFF;letter-spacing:.5px;font-size:10px}
.hero h1{font-size:clamp(24px,3vw,34px);letter-spacing:-.55px}.hero p{max-width:610px;margin-top:9px;font-size:12px;color:rgba(255,255,255,.78)}
.hero-actions{gap:8px}.btn{min-height:42px;padding:11px 16px;border-radius:11px}
.stats-grid{grid-template-columns:repeat(4,1fr);gap:1px;margin:0 0 16px;overflow:hidden;border:1px solid var(--border);border-radius:18px;background:var(--border);box-shadow:none}
.stat-card{min-height:82px;padding:15px 18px;border:0!important;border-radius:0!important;box-shadow:none!important;background:var(--surface)!important}
.stat-card::after{display:none}.stat-label{margin-bottom:6px;font-size:10px}.stat-value{font-size:22px}.stat-note{margin-top:5px;font-size:9px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.dashboard-grid{grid-template-columns:minmax(0,1.65fr) minmax(260px,.65fr);gap:14px;margin-bottom:16px}
.section-card{padding:22px;border-radius:18px!important}.glass{box-shadow:0 10px 30px rgba(10,46,107,.065);border:1px solid var(--border)}
body.theme-dark .glass{background:rgba(13,24,43,.82);box-shadow:0 12px 34px rgba(0,0,0,.20)}
.section-heading{margin-bottom:16px}.section-heading h2{font-size:17px;letter-spacing:-.2px}.section-heading p{margin-top:4px;font-size:11px}.section-tag{padding:6px 9px;font-size:9px}
.best-opportunity{min-height:172px;padding:20px;border-radius:17px;display:flex;flex-direction:column;justify-content:center;background:linear-gradient(135deg,rgba(0,174,239,.075),rgba(10,46,107,.025))}
body.theme-dark .best-opportunity{background:linear-gradient(135deg,rgba(56,223,234,.07),rgba(79,140,255,.035))}
.opportunity-title{font-size:19px;margin-bottom:5px}.location{margin-top:8px}.opportunity-description{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-top:10px}
.match-score{width:70px;height:70px;flex-basis:70px;border-width:5px}
.journey-item{min-height:40px;grid-template-columns:27px 1fr;gap:10px}html[dir="rtl"] .journey-item{grid-template-columns:27px 1fr}
.journey-circle{width:23px;height:23px;flex-basis:23px}.journey-content strong{font-size:12px}.journey-content small{font-size:9px;margin-top:2px}
.matches-grid{grid-template-columns:repeat(3,1fr);gap:12px}.match-card{min-height:214px;padding:17px;border-radius:14px;background:var(--surface-soft);box-shadow:none}
.match-card:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(10,46,107,.09)}
.match-percent{font-size:10px;padding:5px 8px}.match-card h3{margin:13px 0 6px;font-size:14px}.match-country{padding-top:12px}.match-actions{padding-top:11px;margin-top:11px}.why-match-btn{padding:9px 10px;border-radius:9px}
.application-card{padding:15px 16px;border-radius:13px}.application-title{font-size:13px}.application-meta{margin-top:10px;gap:10px 14px;font-size:10px}
#applicationsList + .section-card{margin-top:16px;padding:16px!important;box-shadow:none;background:var(--surface-soft)}
#notificationsList{max-height:260px;overflow:auto}#notificationsList .application-card{padding:12px;background:var(--surface)}
#notificationsList .quick-action{display:inline-flex;width:auto;padding:7px 10px;border-radius:8px;font-size:10px}
.dashboard-grid > .section-card:last-child .quick-actions{grid-template-columns:1fr;gap:8px}
.dashboard-grid > .section-card:last-child .quick-action{padding:13px 14px;border-radius:12px}.quick-action strong{font-size:12px}.quick-action span{font-size:10px}
.gap-panel{max-height:340px;overflow:auto}
@media(max-width:900px){.dashboard-grid{grid-template-columns:1fr}.matches-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:700px){main{width:min(100% - 22px,1160px);padding-top:18px}.topbar-inner{width:min(100% - 22px,1160px)}.brand-logo{width:100px;height:39px}.brand-logo-dark{width:112px;height:43px}.hero{min-height:auto;padding:23px 20px;gap:18px}.hero h1{font-size:24px}.stats-grid{grid-template-columns:repeat(2,1fr)}.stat-card{min-height:76px}.matches-grid{grid-template-columns:1fr}.match-card{min-height:190px}.section-card{padding:17px}}
@media(max-width:480px){.stats-grid{grid-template-columns:1fr 1fr}.stat-note{display:none}.top-actions{gap:3px}.language-switcher{display:none}.brand-logo{width:92px;height:36px}.brand-logo-dark{width:103px;height:40px}}


/* ===== Gap Analysis as modal — never expands scholarship cards ===== */
.match-card{align-self:start;height:100%}
.match-actions{margin-top:auto}
.gap-panel:not(.hidden){
    position:fixed!important;
    z-index:10050;
    inset:auto 50% 50% auto;
    transform:translate(50%,50%);
    width:min(620px,calc(100vw - 32px));
    max-height:min(76vh,680px);
    overflow:auto;
    padding:22px;
    margin:0!important;
    border:1px solid var(--border-strong);
    border-radius:20px;
    background:var(--surface)!important;
    box-shadow:0 28px 90px rgba(2,15,35,.28);
}
body.theme-dark .gap-panel:not(.hidden){
    background:#0D182B!important;
    box-shadow:0 28px 90px rgba(0,0,0,.55);
}
.gap-panel:not(.hidden)::before{
    content:"تحليل المطابقة";
    display:block;
    font-size:18px;
    font-weight:800;
    color:var(--text);
    margin-bottom:16px;
    padding-bottom:12px;
    border-bottom:1px solid var(--border);
}
html[lang="en"] .gap-panel:not(.hidden)::before{content:"Match Analysis"}
.matches-heading-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.show-all-matches-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:34px;
    padding:7px 12px;
    border:1px solid rgba(0,174,239,.28);
    border-radius:10px;
    background:rgba(0,174,239,.08);
    color:var(--primary);
    font:inherit;
    font-size:10px;
    font-weight:800;
    cursor:pointer;
}
body.theme-dark .show-all-matches-btn{color:var(--cyan);border-color:rgba(56,223,234,.25);background:rgba(56,223,234,.07)}
.show-all-matches-btn:hover{transform:translateY(-1px);background:rgba(0,174,239,.13)}
@media(max-width:700px){
    .gap-panel:not(.hidden){width:calc(100vw - 22px);padding:17px;max-height:82vh}
    .matches-heading-actions{width:100%;justify-content:space-between}
}


/* Gap modal close controls */
.gap-panel:not(.hidden){padding-top:58px!important}
.gap-modal-close{
    position:absolute;
    top:14px;
    inset-inline-end:16px;
    width:34px;
    height:34px;
    border:1px solid var(--border);
    border-radius:10px;
    background:var(--surface-soft);
    color:var(--text);
    font-size:20px;
    line-height:1;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:2;
}
.gap-modal-close:hover{background:var(--surface-muted)}
.gap-panel:not(.hidden)::before{
    position:absolute;
    top:18px;
    inset-inline-start:22px;
    margin:0!important;
    padding:0!important;
    border:0!important;
}


/* V5: reliable modal close button + synchronized trigger */
.gap-panel:not(.hidden){position:fixed!important}
.gap-modal-close{
    display:flex!important;
    visibility:visible!important;
    opacity:1!important;
    position:absolute!important;
    top:12px!important;
    inset-inline-end:14px!important;
    z-index:99999!important;
    width:38px!important;
    height:38px!important;
    align-items:center!important;
    justify-content:center!important;
    padding:0!important;
    border:1px solid var(--border-strong)!important;
    border-radius:11px!important;
    background:var(--surface)!important;
    color:var(--text)!important;
    font-size:26px!important;
    font-weight:400!important;
    cursor:pointer!important;
    box-shadow:0 4px 12px rgba(10,46,107,.08)!important;
}
.gap-modal-close:hover{background:var(--surface-muted)!important;color:var(--primary)!important}


/* =========================================================
   JISR DASHBOARD V6 — same product language as landing page
   ========================================================= */
:root{
    --landing-navy:#061B2B;
    --landing-panel:#0B2A43;
    --landing-panel-2:#0D3452;
    --landing-line:#164B6D;
    --landing-cyan:#08AFFF;
    --landing-cyan-soft:#87DFFF;
}
body{background:#F4F8FC!important}
body.theme-dark{background:#061B2B!important}

/* Header: same hierarchy as landing page */
.topbar{
    position:sticky;top:0;z-index:1000;
    border-bottom:1px solid #E2EAF3!important;
    background:rgba(255,255,255,.94)!important;
    backdrop-filter:blur(16px);
}
body.theme-dark .topbar{
    background:rgba(6,27,43,.96)!important;
    border-bottom-color:#123A55!important;
}
.landing-header{
    width:min(1180px,calc(100% - 36px))!important;
    min-height:72px!important;
    display:grid!important;
    grid-template-columns:180px 1fr 260px!important;
    align-items:center!important;
    gap:18px!important;
}
.brand{justify-self:start!important}
html[dir="rtl"] .brand{justify-self:end!important}
.brand-logo{width:118px!important;height:45px!important;object-fit:contain!important}
.brand-logo-dark{width:132px!important;height:50px!important}
.dashboard-nav{
    display:flex;align-items:center;justify-content:center;gap:8px;
}
.dashboard-nav .nav-link{
    color:#536274!important;
    font-size:12px!important;font-weight:700!important;
    padding:9px 12px!important;border-radius:9px!important;
    border:0!important;background:transparent!important;
}
.dashboard-nav .nav-link:hover,.dashboard-nav .nav-link.active{
    color:#087DB8!important;background:rgba(8,175,255,.08)!important;
}
body.theme-dark .dashboard-nav .nav-link{color:#9DB2C5!important}
body.theme-dark .dashboard-nav .nav-link:hover,
body.theme-dark .dashboard-nav .nav-link.active{
    color:#29C4FF!important;background:rgba(8,175,255,.08)!important;
}
.top-actions{justify-self:end!important;display:flex!important;align-items:center!important;gap:7px!important}
html[dir="rtl"] .top-actions{justify-self:start!important}
.language-switcher{
    height:36px!important;padding:0 9px!important;border-radius:10px!important;
    background:#F5F8FC!important;border:1px solid #DCE6F0!important;
}
body.theme-dark .language-switcher{background:#0A2940!important;border-color:#164B6D!important}
.language-switcher a{font-size:10px!important;font-weight:800!important}
.language-switcher a.active{color:#079EDF!important}
.theme-toggle-btn,.logout-btn{
    min-height:36px!important;border-radius:10px!important;
    border:1px solid #DCE6F0!important;background:#F8FAFD!important;
    box-shadow:none!important;
}
.theme-toggle-btn{width:38px!important;padding:0!important;font-size:17px!important}
.logout-btn{padding:8px 13px!important;font-size:11px!important;font-weight:800!important}
body.theme-dark .theme-toggle-btn,body.theme-dark .logout-btn{
    background:#0A2940!important;border-color:#164B6D!important;color:#fff!important;
}

/* Page width and spacing */
main{width:min(1180px,calc(100% - 36px))!important;padding:30px 0 55px!important}

/* Hero mirrors landing CTA panels */
.hero{
    min-height:180px!important;padding:34px 38px!important;margin-bottom:18px!important;
    border:1px solid rgba(13,91,139,.18)!important;border-radius:24px!important;
    background:
      radial-gradient(circle at 9% 120%,rgba(135,223,255,.30),transparent 34%),
      linear-gradient(120deg,#0A2E6B 0%,#07518E 58%,#079ED2 120%)!important;
    box-shadow:0 18px 45px rgba(10,46,107,.13)!important;
}
body.theme-dark .hero{
    border-color:#164B6D!important;
    background:
      radial-gradient(circle at 10% 120%,rgba(8,175,255,.16),transparent 34%),
      linear-gradient(120deg,#08233A,#0A3655 65%,#07597A)!important;
    box-shadow:none!important;
}
.hero h1{font-size:clamp(28px,3.2vw,40px)!important;font-weight:900!important}
.hero p{font-size:13px!important;max-width:650px!important;line-height:1.9!important}
.hero .btn{min-height:44px!important;border-radius:10px!important;font-weight:800!important}
.hero .btn-primary{background:#08AFFF!important;border-color:#08AFFF!important;color:#fff!important}
.hero .btn-secondary{background:rgba(255,255,255,.08)!important;border-color:rgba(255,255,255,.22)!important;color:#fff!important}

/* Compact KPI row like landing-page benefit strip */
.stats-grid{
    border:1px solid #DFE8F1!important;border-radius:16px!important;
    background:#fff!important;gap:0!important;overflow:hidden!important;
    margin-bottom:18px!important;box-shadow:0 8px 25px rgba(10,46,107,.04)!important;
}
body.theme-dark .stats-grid{background:#0A2940!important;border-color:#164B6D!important;box-shadow:none!important}
.stat-card{
    min-height:88px!important;padding:17px 20px!important;
    border-inline-end:1px solid #E6EDF4!important;background:transparent!important;
}
.stat-card:last-child{border-inline-end:0!important}
body.theme-dark .stat-card{border-color:#164B6D!important}
.stat-label{font-size:10px!important}.stat-value{font-size:24px!important;font-weight:900!important}
.stat-note{font-size:9px!important;color:#8493A5!important}

/* Sections: landing cards, fewer shadows, stronger hierarchy */
.dashboard-grid{gap:16px!important;margin-bottom:18px!important}
.section-card{
    border-radius:20px!important;border:1px solid #DFE8F1!important;
    background:#fff!important;padding:24px!important;
    box-shadow:0 8px 28px rgba(10,46,107,.045)!important;
}
body.theme-dark .section-card{
    background:#09243A!important;border-color:#164B6D!important;box-shadow:none!important;
}
.section-heading{margin-bottom:18px!important}
.section-heading h2{font-size:20px!important;font-weight:900!important}
.section-heading p{font-size:11px!important;line-height:1.7!important}
body.theme-dark .section-heading h2{color:#fff!important}
body.theme-dark .section-heading p{color:#8FA9BD!important}
.section-tag,.show-all-matches-btn{
    border-radius:999px!important;background:rgba(8,175,255,.08)!important;
    border:1px solid rgba(8,175,255,.24)!important;color:#087DB8!important;
}
body.theme-dark .section-tag,body.theme-dark .show-all-matches-btn{color:#29C4FF!important}

/* Best match = featured landing-style opportunity */
.best-opportunity{
    min-height:185px!important;border-radius:16px!important;
    border:1px solid #DCE8F2!important;
    background:linear-gradient(135deg,#F5FBFF,#EEF7FD)!important;
}
body.theme-dark .best-opportunity{
    background:linear-gradient(135deg,#0B304C,#0A2940)!important;border-color:#185276!important;
}
.opportunity-title{font-size:21px!important;font-weight:900!important}
body.theme-dark .opportunity-title{color:#fff!important}
.match-score{border-color:#08AFFF!important;background:rgba(8,175,255,.07)!important}
.match-score strong{color:#087DB8!important}
body.theme-dark .match-score strong{color:#38DFEA!important}

/* Journey: clean numbered flow, same concept as landing "How it works" */
.journey{padding-top:2px!important}
.journey-item{min-height:45px!important}
.journey-circle{background:#EAF8FF!important;border-color:#A9E5FF!important;color:#087DB8!important}
body.theme-dark .journey-circle{background:#0B3653!important;border-color:#17618A!important;color:#38DFEA!important}
.journey-line{background:#DCEAF3!important}
body.theme-dark .journey-line{background:#164B6D!important}

/* Scholarship cards */
.matches-grid{grid-template-columns:repeat(3,minmax(0,1fr))!important;gap:14px!important}
.match-card{
    min-height:250px!important;padding:20px!important;border-radius:16px!important;
    border:1px solid #DCE6F0!important;background:#F8FBFE!important;
    box-shadow:none!important;display:flex!important;flex-direction:column!important;
}
body.theme-dark .match-card{background:#0B2A43!important;border-color:#164B6D!important}
.match-card:hover{transform:translateY(-3px)!important;border-color:#83D9FA!important;box-shadow:0 14px 34px rgba(10,46,107,.08)!important}
body.theme-dark .match-card:hover{box-shadow:none!important;border-color:#2181AF!important}
.match-card h3{font-size:15px!important;font-weight:850!important}
body.theme-dark .match-card h3{color:#fff!important}
.match-actions{margin-top:auto!important;display:grid!important;gap:8px!important}
.why-match-btn{
    min-height:40px!important;border-radius:10px!important;
    border:1px solid rgba(8,175,255,.28)!important;
    background:rgba(8,175,255,.07)!important;color:#087DB8!important;font-weight:800!important;
}
body.theme-dark .why-match-btn{color:#38DFEA!important;background:rgba(56,223,234,.05)!important;border-color:#185C7E!important}
.apply-btn:not(:disabled){background:#08AFFF!important;color:#fff!important;border-color:#08AFFF!important}
.apply-btn:disabled{background:rgba(27,185,126,.08)!important;color:#18A56F!important;border-color:rgba(27,185,126,.28)!important}

/* Applications / notifications: calm and compact */
.application-card{border-radius:13px!important;background:#F8FBFE!important;border:1px solid #E0E8F0!important}
body.theme-dark .application-card{background:#0B2A43!important;border-color:#164B6D!important}
.application-title{font-weight:850!important}
body.theme-dark .application-title{color:#fff!important}
#notificationsList{max-height:230px!important}

/* Quick actions are redundant: same destinations already exist in header/hero */
.dashboard-grid > .section-card:last-child{align-self:start!important}
.quick-actions{grid-template-columns:1fr!important}
.quick-action{min-height:auto!important;padding:14px!important;border-radius:12px!important}

/* Real modal */
.gap-panel:not(.hidden){
    position:fixed!important;z-index:10050!important;left:50%!important;top:50%!important;
    right:auto!important;bottom:auto!important;transform:translate(-50%,-50%)!important;
    width:min(650px,calc(100vw - 32px))!important;max-height:78vh!important;overflow:auto!important;
    padding:62px 24px 24px!important;margin:0!important;border-radius:20px!important;
    background:#fff!important;border:1px solid #DCE6F0!important;
    box-shadow:0 30px 100px rgba(2,15,35,.30)!important;
}
body.theme-dark .gap-panel:not(.hidden){background:#09243A!important;border-color:#1B5C7E!important}
.gap-panel:not(.hidden)::before{
    content:"تحليل المطابقة"!important;position:absolute!important;top:20px!important;
    inset-inline-start:24px!important;font-size:19px!important;font-weight:900!important;color:var(--text)!important;
}
html[lang="en"] .gap-panel:not(.hidden)::before{content:"Match Analysis"!important}
.gap-modal-close{
    display:flex!important;position:absolute!important;top:14px!important;inset-inline-end:16px!important;
    z-index:99999!important;width:38px!important;height:38px!important;border-radius:10px!important;
    align-items:center!important;justify-content:center!important;border:1px solid #DCE6F0!important;
    background:#F5F8FC!important;color:#17263A!important;font-size:25px!important;cursor:pointer!important;
}
body.theme-dark .gap-modal-close{background:#0B2A43!important;border-color:#164B6D!important;color:#fff!important}

/* Mobile */
@media(max-width:900px){
    .landing-header{grid-template-columns:auto 1fr auto!important}
    .dashboard-nav{display:none!important}
    .matches-grid{grid-template-columns:repeat(2,minmax(0,1fr))!important}
}
@media(max-width:700px){
    .landing-header,main{width:min(100% - 22px,1180px)!important}
    .landing-header{grid-template-columns:1fr auto!important}
    .brand-logo{width:100px!important}.brand-logo-dark{width:112px!important}
    .logout-btn{display:none!important}
    .hero{padding:25px 21px!important}
    .stats-grid{grid-template-columns:repeat(2,1fr)!important}
    .matches-grid{grid-template-columns:1fr!important}
    .section-card{padding:18px!important}
}
@media(max-width:480px){
    .language-switcher{display:flex!important}
    .hero h1{font-size:27px!important}
}


/* =========================================================
   V7 UX polish — landing-page consistency + modal geometry fix
   ========================================================= */

/* Header controls now use the same compact visual language as landing */
.landing-language{
    display:inline-flex!important;
    align-items:center!important;
    height:36px!important;
    padding:3px!important;
    gap:2px!important;
    border:1px solid #DCE6F0!important;
    border-radius:10px!important;
    background:#F6F9FC!important;
}
.landing-language a{
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    min-width:34px!important;
    height:28px!important;
    padding:0 8px!important;
    border-radius:7px!important;
    color:#738396!important;
    font-size:10px!important;
    font-weight:850!important;
    text-decoration:none!important;
}
.landing-language a.active{
    background:#E5F6FE!important;
    color:#078AC6!important;
}
body.theme-dark .landing-language{
    background:#08243A!important;
    border-color:#164B6D!important;
}
body.theme-dark .landing-language a{color:#8FA9BD!important}
body.theme-dark .landing-language a.active{
    background:#0D3A57!important;
    color:#38DFEA!important;
}
.theme-toggle-btn{
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
    width:38px!important;
    height:36px!important;
    padding:0!important;
    font-size:0!important;
}
.theme-toggle-btn::before{
    content:"☀"!important;
    font-size:17px!important;
    line-height:1!important;
}
body:not(.theme-dark) .theme-toggle-btn::before{content:"☾"!important}

/* Better header balance: brand / navigation / utilities */
.landing-header{
    grid-template-columns:150px minmax(390px,1fr) auto!important;
}
.dashboard-nav{gap:4px!important}
.dashboard-nav .nav-link{
    min-height:36px!important;
    display:flex!important;
    align-items:center!important;
    justify-content:center!important;
}
.top-actions{white-space:nowrap!important}

/* Modal geometry: force actual viewport centering in both RTL and LTR.
   Reset every inset property left by earlier versions. */
.gap-panel:not(.hidden){
    inset:50% auto auto 50%!important;
    inset-inline:auto!important;
    inset-block:auto!important;
    left:50%!important;
    right:auto!important;
    top:50%!important;
    bottom:auto!important;
    transform:translate(-50%,-50%)!important;
    margin:0!important;
    width:min(640px,calc(100vw - 40px))!important;
    max-width:calc(100vw - 40px)!important;
    max-height:min(76vh,680px)!important;
    overflow:auto!important;
    overscroll-behavior:contain!important;
}

/* Keep dashboard cards from feeling like a spreadsheet */
.matches-grid{align-items:stretch!important}
.match-card{height:auto!important;min-height:238px!important}
.match-card .match-provider{line-height:1.5!important}
.match-country{margin-top:auto!important}
.match-actions{margin-top:14px!important}
.matches-heading-actions{gap:10px!important}

/* More breathing room and stronger grouping */
#matchesSection{padding-top:26px!important;padding-bottom:26px!important}
.dashboard-grid > .section-card{min-width:0!important}
.application-card{transition:border-color .18s ease,transform .18s ease!important}
.application-card:hover{border-color:#B7DDED!important}

/* On smaller screens, simplify instead of squeezing everything */
@media(max-width:980px){
    .landing-header{grid-template-columns:auto 1fr auto!important}
    .dashboard-nav .nav-link:nth-last-child(-n+2){display:none!important}
}
@media(max-width:760px){
    .landing-header{display:flex!important;justify-content:space-between!important}
    .dashboard-nav{display:none!important}
    .landing-language a{min-width:30px!important;padding:0 6px!important}
    .gap-panel:not(.hidden){
        width:calc(100vw - 24px)!important;
        max-width:calc(100vw - 24px)!important;
        max-height:82vh!important;
    }
}


/* =========================================================
   JISR V8 — Unified product design system
   ========================================================= */
:root{
 --j-navy:#071D2D;--j-navy2:#0A2A43;--j-blue:#0A2E6B;--j-cyan:#09AEF0;
 --j-cyan2:#67D8FF;--j-bg:#F5F9FD;--j-card:#FFFFFF;--j-text:#122033;
 --j-muted:#75869A;--j-line:#DDE7F0;--j-soft:#EFF7FC;
}
body{background:var(--j-bg)!important;color:var(--j-text)!important}
body.theme-dark{--j-bg:#061B2B;--j-card:#0A2940;--j-text:#F5FAFF;--j-muted:#91A9BB;--j-line:#164B6D;--j-soft:#0B304A;background:var(--j-bg)!important}
body.modal-open{overflow:hidden!important}

/* Shared header */
.jisr-site-header{position:sticky;top:0;z-index:3000;background:rgba(255,255,255,.95);border-bottom:1px solid var(--j-line);backdrop-filter:blur(16px)}
body.theme-dark .jisr-site-header{background:rgba(6,27,43,.96)}
.jisr-header-inner{width:min(1180px,calc(100% - 36px));min-height:72px;margin:auto;display:grid;grid-template-columns:170px 1fr auto;align-items:center;gap:22px}
.jisr-brand{display:flex;align-items:center}.jisr-logo{width:116px;height:45px;object-fit:contain}.jisr-logo-dark{display:none;width:130px;height:50px}
body.theme-dark .jisr-logo-light{display:none}body.theme-dark .jisr-logo-dark{display:block}
.jisr-nav{display:flex;align-items:center;justify-content:center;gap:4px}
.jisr-nav a{padding:9px 13px;border-radius:9px;text-decoration:none;color:#65778A;font-size:12px;font-weight:800}
.jisr-nav a:hover,.jisr-nav a.active{background:rgba(9,174,240,.08);color:#078BC4}
body.theme-dark .jisr-nav a{color:#9DB2C4}body.theme-dark .jisr-nav a:hover,body.theme-dark .jisr-nav a.active{color:#39D8FF;background:rgba(9,174,240,.09)}
.jisr-header-actions{display:flex;align-items:center;gap:7px}
.jisr-lang{display:flex;align-items:center;padding:3px;border:1px solid var(--j-line);border-radius:10px;background:var(--j-soft)}
.jisr-lang a{min-width:34px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:7px;text-decoration:none;color:var(--j-muted);font-size:10px;font-weight:900}
.jisr-lang a.active{background:var(--j-card);color:#078BC4;box-shadow:0 2px 8px rgba(10,46,107,.07)}
body.theme-dark .jisr-lang a.active{color:#39D8FF}
.jisr-theme-btn,.jisr-logout-btn{height:36px;border:1px solid var(--j-line);border-radius:10px;background:var(--j-card);color:var(--j-text);font:inherit;font-weight:800;cursor:pointer}
.jisr-theme-btn{width:38px;font-size:17px}.jisr-logout-btn{padding:0 13px;font-size:11px}

/* Main hierarchy */
main{width:min(1180px,calc(100% - 36px))!important;padding:30px 0 48px!important}
.hero{min-height:190px!important;padding:36px 38px!important;border-radius:26px!important;border:1px solid rgba(65,183,229,.18)!important;background:radial-gradient(circle at 10% 120%,rgba(103,216,255,.30),transparent 34%),linear-gradient(120deg,#0A2E6B,#07528E 58%,#079ACD)!important;box-shadow:0 20px 55px rgba(10,46,107,.14)!important}
body.theme-dark .hero{background:radial-gradient(circle at 10% 120%,rgba(9,174,240,.17),transparent 34%),linear-gradient(120deg,#08243A,#0A3655 65%,#075A79)!important;box-shadow:none!important}
.hero h1{font-size:clamp(30px,3.4vw,42px)!important;font-weight:950!important}.hero p{font-size:13px!important;line-height:1.9!important}
.hero .btn{border-radius:11px!important;min-height:44px!important;font-weight:850!important}.hero .btn-primary{background:#13B8F3!important;border-color:#13B8F3!important;color:white!important}

/* KPI as a single elegant strip */
.stats-grid{margin:18px 0!important;gap:0!important;border:1px solid var(--j-line)!important;border-radius:18px!important;background:var(--j-card)!important;overflow:hidden!important;box-shadow:0 10px 30px rgba(10,46,107,.04)!important}
.stat-card{background:transparent!important;border:0!important;border-inline-end:1px solid var(--j-line)!important;border-radius:0!important;box-shadow:none!important;min-height:88px!important;padding:17px 20px!important}
.stat-card:last-child{border-inline-end:0!important}.stat-value{font-size:25px!important;font-weight:950!important}.stat-label{font-size:10px!important}.stat-note{font-size:9px!important}

/* Feature cards */
.section-card{background:var(--j-card)!important;border:1px solid var(--j-line)!important;border-radius:22px!important;padding:25px!important;box-shadow:0 10px 32px rgba(10,46,107,.045)!important}
body.theme-dark .section-card{box-shadow:none!important}
.section-heading h2{font-size:20px!important;font-weight:950!important;color:var(--j-text)!important}.section-heading p{color:var(--j-muted)!important}
.best-opportunity{min-height:190px!important;border:1px solid var(--j-line)!important;border-radius:18px!important;background:linear-gradient(135deg,var(--j-soft),var(--j-card))!important}
.opportunity-title{font-size:21px!important;font-weight:950!important;color:var(--j-text)!important}
.match-score{border-color:#13B8F3!important;background:rgba(19,184,243,.07)!important}

/* Scholarship collection */
.matches-grid{grid-template-columns:repeat(3,minmax(0,1fr))!important;gap:14px!important;align-items:stretch!important}
.match-card{min-height:244px!important;height:auto!important;display:flex!important;flex-direction:column!important;padding:20px!important;border-radius:17px!important;background:var(--j-soft)!important;border:1px solid var(--j-line)!important;box-shadow:none!important}
.match-card:hover{transform:translateY(-4px)!important;border-color:#8BDFFF!important;box-shadow:0 16px 38px rgba(10,46,107,.08)!important}
body.theme-dark .match-card:hover{box-shadow:none!important}
.match-card h3{font-size:15px!important;font-weight:900!important;color:var(--j-text)!important}.match-provider,.match-country{color:var(--j-muted)!important}
.match-actions{margin-top:auto!important;padding-top:14px!important;display:grid!important;gap:8px!important}
.why-match-btn{min-height:40px!important;border-radius:10px!important;border:1px solid rgba(9,174,240,.28)!important;background:rgba(9,174,240,.07)!important;color:#078BC4!important;font-weight:850!important}
body.theme-dark .why-match-btn{color:#39D8FF!important}.apply-btn:not(:disabled){background:#13B8F3!important;color:white!important}.apply-btn:disabled{color:#16A66E!important;background:rgba(22,166,110,.08)!important}

/* Global match modal — one modal, always dead center */
.jisr-modal{position:fixed!important;inset:0!important;z-index:99999!important;display:grid!important;place-items:center!important;padding:20px!important}
.jisr-modal.hidden{display:none!important}
.jisr-modal-backdrop{position:absolute!important;inset:0!important;background:rgba(2,14,24,.62)!important;backdrop-filter:blur(7px)!important}
.jisr-modal-dialog{position:relative!important;z-index:2!important;width:min(660px,calc(100vw - 40px))!important;max-height:min(78vh,720px)!important;overflow:hidden!important;margin:0!important;transform:none!important;border-radius:24px!important;background:var(--j-card)!important;border:1px solid var(--j-line)!important;box-shadow:0 32px 110px rgba(0,0,0,.32)!important}
.jisr-modal-head{display:flex!important;align-items:flex-start!important;justify-content:space-between!important;gap:20px!important;padding:23px 24px 18px!important;border-bottom:1px solid var(--j-line)!important}
.jisr-modal-kicker{display:block;color:#079FD9;font-size:9px;font-weight:900;letter-spacing:.5px;margin-bottom:5px}.jisr-modal-head h2{margin:0!important;color:var(--j-text)!important;font-size:21px!important;font-weight:950!important}
.jisr-modal-close{flex:0 0 40px;width:40px;height:40px;border:1px solid var(--j-line);border-radius:11px;background:var(--j-soft);color:var(--j-text);font-size:25px;cursor:pointer}
.jisr-modal-content{padding:22px 24px 26px!important;max-height:calc(78vh - 90px)!important;overflow:auto!important;color:var(--j-text)!important}
/* Old per-card panels can never display */
.gap-panel{display:none!important}

/* Footer */
.jisr-site-footer{border-top:1px solid var(--j-line);background:var(--j-card);margin-top:20px}.jisr-footer-inner{width:min(1180px,calc(100% - 36px));min-height:100px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:20px}.jisr-footer-logo{width:105px;height:42px;object-fit:contain}.jisr-footer-logo-dark{display:none;width:116px}body.theme-dark .jisr-footer-logo-light{display:none}body.theme-dark .jisr-footer-logo-dark{display:block}.jisr-site-footer p{font-size:10px;color:var(--j-muted)}

/* responsive */
@media(max-width:900px){.jisr-header-inner{grid-template-columns:auto 1fr auto}.jisr-nav a:nth-last-child(-n+2){display:none}.matches-grid{grid-template-columns:repeat(2,1fr)!important}}
@media(max-width:700px){.jisr-header-inner,main,.jisr-footer-inner{width:min(100% - 22px,1180px)!important}.jisr-nav{display:none}.jisr-header-inner{display:flex;justify-content:space-between}.jisr-logo{width:98px}.jisr-logo-dark{width:108px}.jisr-logout-btn{display:none}.stats-grid{grid-template-columns:repeat(2,1fr)!important}.matches-grid{grid-template-columns:1fr!important}.section-card{padding:18px!important}.hero{padding:25px 21px!important}.jisr-modal{padding:12px!important}.jisr-modal-dialog{width:100%!important;max-height:84vh!important}.jisr-footer-inner{min-height:90px}}

</style>

</head>


<body>

<script>
    (function () {
        try {
            var savedTheme =
                localStorage.getItem('jisr-theme') || localStorage.getItem('jisr_theme');

            if (savedTheme === 'dark') {
                document.body.classList.add('theme-dark');
            }
        }
        catch (e) {}
    })();
</script>


<div id="loadingScreen">

    <div class="loader"></div>

    <div class="loading-text">
        {{ __('common.preparing_dashboard') }}
    </div>

</div>


<div
    id="appShell"
    class="hidden"
>


    <!-- =====================================
         NAVBAR
    ===================================== -->

    @include('components.jisr-header')



    <main>


        <!-- =====================================
             HERO
        ===================================== -->

        <section class="hero">


            <div class="hero-content">

                <p class="eyebrow">
                    {{ __('common.student_dashboard') }}
                </p>


                <h1 id="welcomeHeading">
                    {{ __('common.welcome') }}
                </h1>


                <p>
                    {{ __('common.education_intro') }}
                </p>

            </div>



            <div class="hero-actions">


                <a
                    href="{{ route('cv-upload') }}"
                    class="btn btn-secondary"
                >
                    {{ __('common.upload_cv') }}
                </a>


                <button
                    id="refreshRecommendationsBtn"
                    type="button"
                    class="btn btn-primary"
                >
                    {{ __('common.refresh_matches') }}
                </button>


            </div>


        </section>



        <!-- =====================================
             STATS
        ===================================== -->

        <section class="stats-grid">


            <div class="stat-card glass">

                <div class="stat-label">
                    {{ __('common.ai_scholarship_matches') }}
                </div>

                <div
                    class="stat-value"
                    id="matchCount"
                >
                    —
                </div>

                <div class="stat-note">
                    {{ __('common.matches_note') }}
                </div>

            </div>



            <div class="stat-card glass">

                <div class="stat-label">
                    {{ __('common.my_applications') }}
                </div>

                <div
                    class="stat-value"
                    id="applicationCount"
                >
                    —
                </div>

                <div class="stat-note">
                    {{ __('common.applications_note') }}
                </div>

            </div>



            <div class="stat-card glass">

                <div class="stat-label">
                    {{ __('common.profile_completion') }}
                </div>

                <div
                    class="stat-value"
                    id="profileCompletion"
                >
                    —
                </div>

                <div class="stat-note">
                    {{ __('common.profile_completion_note') }}
                </div>

            </div>



            <div class="stat-card glass">

                <div class="stat-label">
                    {{ __('common.upcoming_deadline') }}
                </div>

                <div
                    class="stat-value"
                    id="deadlineValue"
                >
                    —
                </div>

                <div
                    class="stat-note"
                    id="deadlineNote"
                >
                    {{ __('common.deadline_note') }}
                </div>

            </div>


        </section>



        <!-- =====================================
             BEST + JOURNEY
        ===================================== -->

        <section class="dashboard-grid">


            <div class="section-card glass">


                <div class="section-heading">

                    <div>

                        <h2>
                            {{ __('common.best_opportunity') }}
                        </h2>

                        <p>
                            {{ __('common.best_opportunity_note') }}
                        </p>

                    </div>


                    <span class="section-tag">
                        {{ __('common.ai_match') }}
                    </span>

                </div>


                <div id="bestOpportunity"></div>


            </div>



            <div class="section-card glass">


                <div class="section-heading">

                    <div>

                        <h2>
                            {{ __('common.scholarship_journey') }}
                        </h2>

                        <p>
                            {{ __('common.application_progress') }}
                        </p>

                    </div>

                </div>



                <div class="journey">


                    <div
                        class="journey-item"
                        id="journeyProfile"
                    >

                        <div class="journey-marker">

                            <div class="journey-circle">
                                ✓
                            </div>

                            <div class="journey-line"></div>

                        </div>

                        <div class="journey-content">

                            <strong>
                                {{ __('common.build_profile') }}
                            </strong>

                            <small>
                                {{ __('common.build_profile_note') }}
                            </small>

                        </div>

                    </div>



                    <div
                        class="journey-item"
                        id="journeyMatch"
                    >

                        <div class="journey-marker">

                            <div class="journey-circle">
                                ✓
                            </div>

                            <div class="journey-line"></div>

                        </div>

                        <div class="journey-content">

                            <strong>
                                {{ __('common.discover_matches') }}
                            </strong>

                            <small>
                                {{ __('common.discover_matches_note') }}
                            </small>

                        </div>

                    </div>



                    <div
                        class="journey-item"
                        id="journeyPrepare"
                    >

                        <div class="journey-marker">

                            <div class="journey-circle">
                                3
                            </div>

                            <div class="journey-line"></div>

                        </div>

                        <div class="journey-content">

                            <strong>
                                {{ __('common.prepare_application') }}
                            </strong>

                            <small>
                                {{ __('common.prepare_application_note') }}
                            </small>

                        </div>

                    </div>



                    <div
                        class="journey-item"
                        id="journeyApply"
                    >

                        <div class="journey-marker">

                            <div class="journey-circle">
                                4
                            </div>

                        </div>

                        <div class="journey-content">

                            <strong>
                                {{ __('common.apply_track') }}
                            </strong>

                            <small>
                                {{ __('common.apply_track_note') }}
                            </small>

                        </div>

                    </div>


                </div>


            </div>


        </section>



        <!-- =====================================
             TOP MATCHES
        ===================================== -->

        <section
            class="section-card glass"
            style="margin-bottom:18px;"
        >


            <div class="section-heading">


                <div>

                    <h2>
                        {{ __('common.top_ai_matches') }}
                    </h2>

                    <p>
                        {{ __('common.top_matches_note') }}
                    </p>

                </div>


                <div class="matches-heading-actions">
                    <button
                        type="button"
                        id="toggleAllMatchesBtn"
                        class="show-all-matches-btn"
                        onclick="toggleAllMatches()"
                    >
                        عرض جميع المنح
                    </button>

                    <span
                        id="matchesGeneratedAt"
                        class="section-tag"
                    >
                        {{ __('common.matching_engine') }}
                    </span>
                </div>


            </div>


            <div
                id="matchesGrid"
                class="matches-grid"
            ></div>


        </section>



        <!-- =====================================
             APPLICATIONS + ACTIONS
        ===================================== -->

        <section class="dashboard-grid">


            <div class="section-card glass">


                <div class="section-heading">

                    <div>

                        <h2>
                            {{ __('common.my_applications') }}
                        </h2>

                        <p>
                            {{ __('common.applications_section_note') }}
                        </p>

                    </div>

                </div>


                <div id="applicationsList"></div>

            <div class="section-card glass">
                <div class="section-heading">
                    <div>
                        <h2>{{ __('common.notifications_title') }}
                            <span id="notificationsUnreadBadge" class="status-badge" style="display:none; margin-inline-start:8px;"></span>
                        </h2>
                        <p>{{ __('common.notifications_description') }}</p>
                    </div>
                    <button type="button" id="markAllNotificationsReadBtn" class="btn-secondary" style="display:none;">{{ __('common.notifications_mark_all_read') }}</button>
                </div>
                <div id="notificationsList"></div>
            </div>


            </div>



            <div class="section-card glass">


                <div class="section-heading">

                    <div>

                        <h2>
                            {{ __('common.quick_actions') }}
                        </h2>

                        <p>
                            {{ __('common.quick_actions_note') }}
                        </p>

                    </div>

                </div>



                <div class="quick-actions">


                    <a
                        href="{{ route('profile') }}"
                        class="quick-action"
                    >

                        <strong>
                            {{ __('common.update_profile') }}
                        </strong>

                        <span>
                            {{ __('common.update_profile_note') }}
                        </span>

                    </a>



                    <a
                        href="{{ route('cv-upload') }}"
                        class="quick-action"
                    >

                        <strong>
                            {{ __('common.manage_cv') }}
                        </strong>

                        <span>
                            {{ __('common.manage_cv_note') }}
                        </span>

                    </a>



                    <button
                        id="refreshRecommendationsQuick"
                        type="button"
                        class="quick-action"
                    >

                        <strong>
                            {{ __('common.generate_matches') }}
                        </strong>

                        <span>
                            {{ __('common.generate_matches_note') }}
                        </span>

                    </button>


                </div>


            </div>


        </section>


    </main>


</div>



<div
    id="toast"
    class="toast hidden"
></div>



<script>

    const API_BASE_URL =
        @json(url('/api'));

    const LOGIN_URL =
        @json(route('login'));

    const CURRENT_LOCALE =
        @json(app()->getLocale());


    /*
    |--------------------------------------------------------------------------
    | Translated JS text
    |--------------------------------------------------------------------------
    */

    const app_locale = "{{ app()->getLocale() }}";

    const TEXT = {

        welcomeBack:
            @json(__('common.welcome_back', ['name' => '__NAME__'])),

        noUpcomingDeadline:
            @json(__('common.no_upcoming_deadline')),

        today:
            @json(__('common.today')),

        oneDay:
            @json(__('common.one_day')),

        days:
            @json(__('common.days', ['count' => '__COUNT__'])),

        deadline:
            @json(__('common.deadline')),

        updated:
            @json(__('common.updated')),

        notSpecified:
            @json(__('common.not_specified')),

        scholarshipOpportunity:
            @json(__('common.scholarship_opportunity')),

        scholarship:
            @json(__('common.scholarship')),

        providerNotSpecified:
            @json(__('common.provider_not_specified')),

        international:
            @json(__('common.international')),

        internationalNotSpecified:
            @json(__('common.international_not_specified')),

        descriptionNotAvailable:
            @json(__('common.description_not_available')),

        noMatchesGenerated:
            @json(__('common.no_matches_generated')),

        notificationsEmpty:
            @json(__('common.notifications_empty')),

        notificationsMarkRead:
            @json(__('common.notifications_mark_read')),

        notificationsDelete:
            @json(__('common.notifications_delete')),

        notificationsDeleteConfirm:
            @json(__('common.notifications_delete_confirm')),

        notificationsDeadline:
            @json(__('common.notifications_deadline')),

        noMatchesGeneratedNote:
            @json(__('common.no_matches_generated_note')),

        noAiMatches:
            @json(__('common.no_ai_matches')),

        noAiMatchesNote:
            @json(__('common.no_ai_matches_note')),

        matchingEngine:
            @json(__('common.matching_engine')),

        whyMatch:
            @json(__('common.why_match')),

        hideAnalysis:
            @json(__('common.hide_analysis')),

        analyzing:
            @json(__('common.analyzing')),

        matchedCriteria:
            @json(__('common.matched_criteria')),

        missingCriteria:
            @json(__('common.missing_criteria')),

        analysisNotes:
            @json(__('common.analysis_notes')),

        gaps:
            @json(__('common.gaps')),

        matched:
            @json(__('common.matched')),

        gapCount:
            @json(__('common.gap_count')),

        analysis:
            @json(__('common.analysis')),

        cvConnected:
            @json(__('common.cv_connected')),

        cvNotConnected:
            @json(__('common.cv_not_connected')),

        mandatory:
            @json(__('common.mandatory')),

        optional:
            @json(__('common.optional')),

        nextStep:
            @json(__('common.next_step')),

        noUnmetCriteria:
            @json(__('common.no_unmet_criteria')),

        noSavedApplications:
            @json(__('common.no_saved_applications')),

        noSavedApplicationsNote:
            @json(__('common.no_saved_applications_note')),

        dashboardLoadFailed:
            @json(__('common.dashboard_load_failed')),

        apply:
            @json(__('common.apply')),

        applied:
            @json(__('common.applied')),

        applyFailed:
            @json(__('common.apply_failed'))

    };


    let currentUser = null;

    let currentProfile = null;

    let recommendations = [];

    let applications = [];

    let notifications = [];


    function getToken() {

        return localStorage.getItem(
            'auth_token'
        );

    }


    function goToLogin() {

        localStorage.removeItem(
            'auth_token'
        );

        localStorage.removeItem(
            'auth_user'
        );

        window.location.href =
            LOGIN_URL;

    }


    function authHeaders() {

        return {

            'Authorization':
                `Bearer ${getToken()}`,

            'Accept':
                'application/json'

        };

    }


    function normalizeCollection(payload) {

        if (Array.isArray(payload)) {
            return payload;
        }

        if (
            payload &&
            Array.isArray(payload.data)
        ) {
            return payload.data;
        }

        if (
            payload &&
            Array.isArray(payload.value)
        ) {
            return payload.value;
        }

        return [];

    }


    function escapeHtml(value) {

        const div =
            document.createElement('div');

        div.textContent =
            value ?? '';

        return div.innerHTML;

    }


    function showToast(message) {

        const toast =
            document.getElementById('toast');

        toast.textContent =
            message;

        toast.classList.remove(
            'hidden'
        );

        clearTimeout(
            window.jisrToastTimer
        );

        window.jisrToastTimer =
            setTimeout(() => {

                toast.classList.add(
                    'hidden'
                );

            }, 3200);

    }


    function formatDate(dateValue) {

        if (!dateValue) {
            return TEXT.notSpecified;
        }

        const date =
            new Date(dateValue);

        if (
            Number.isNaN(
                date.getTime()
            )
        ) {
            return TEXT.notSpecified;
        }

        return new Intl.DateTimeFormat(
            CURRENT_LOCALE === 'ar'
                ? 'ar'
                : 'en',
            {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            }
        ).format(date);

    }


    function daysUntil(dateValue) {

        if (!dateValue) {
            return null;
        }

        const target =
            new Date(dateValue);

        const today =
            new Date();

        target.setHours(
            0,0,0,0
        );

        today.setHours(
            0,0,0,0
        );

        return Math.ceil(

            (
                target.getTime() -
                today.getTime()
            ) /

            (
                1000 *
                60 *
                60 *
                24
            )

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


        const completed =
            fields.filter(value => {

                return (
                    value !== null &&
                    value !== undefined &&
                    String(value).trim() !== ''
                );

            }).length;


        return Math.round(
            (completed / fields.length) * 100
        );

    }


    function getUpcomingApplicationDeadline() {

        const upcoming =
            applications

                .filter(
                    item =>
                        item.scholarship
                            ?.application_deadline
                )

                .map(item => ({

                    item,

                    days:
                        daysUntil(
                            item.scholarship
                                .application_deadline
                        )

                }))

                .filter(
                    entry =>
                        entry.days !== null &&
                        entry.days >= 0
                )

                .sort(
                    (a,b) =>
                        a.days - b.days
                );


        return upcoming.length
            ? upcoming[0]
            : null;

    }


    function renderStats() {

        document
            .getElementById(
                'matchCount'
            )
            .textContent =
                recommendations.length;


        document
            .getElementById(
                'applicationCount'
            )
            .textContent =
                applications.length;


        document
            .getElementById(
                'profileCompletion'
            )
            .textContent =
                `${calculateProfileCompletion(currentProfile)}%`;


        const nearestDeadline =
            getUpcomingApplicationDeadline();


        const deadlineValue =
            document.getElementById(
                'deadlineValue'
            );


        const deadlineNote =
            document.getElementById(
                'deadlineNote'
            );


        if (!nearestDeadline) {

            deadlineValue.textContent =
                '—';

            deadlineNote.textContent =
                TEXT.noUpcomingDeadline;

            return;

        }


        if (
            nearestDeadline.days === 0
        ) {

            deadlineValue.textContent =
                TEXT.today;

        }

        else if (
            nearestDeadline.days === 1
        ) {

            deadlineValue.textContent =
                TEXT.oneDay;

        }

        else {

            deadlineValue.textContent =
                TEXT.days.replace(
                    '__COUNT__',
                    nearestDeadline.days
                );

        }


        deadlineNote.textContent =

            nearestDeadline
                .item
                .scholarship
                ?.title

            ?? TEXT.deadline;

    }


    function renderBestOpportunity() {

        const container =
            document.getElementById(
                'bestOpportunity'
            );


        if (!recommendations.length) {

            container.innerHTML = `

                <div class="empty-state">

                    <strong>
                        ${escapeHtml(
                            TEXT.noMatchesGenerated
                        )}
                    </strong>

                    ${escapeHtml(
                        TEXT.noMatchesGeneratedNote
                    )}

                </div>

            `;

            return;

        }


        const best =
            [...recommendations]
                .sort(
                    (a,b) =>
                        Number(
                            b.match_score || 0
                        ) -
                        Number(
                            a.match_score || 0
                        )
                )[0];


        const scholarship =
            best.scholarship || {};


        container.innerHTML = `

            <div class="best-opportunity">

                <div class="opportunity-top">

                    <div>

                        <h3 class="opportunity-title">

                            ${escapeHtml(

                                scholarship.title ||

                                TEXT.scholarshipOpportunity

                            )}

                        </h3>


                        <div class="provider">

                            ${escapeHtml(

                                scholarship.provider_name ||

                                TEXT.providerNotSpecified

                            )}

                        </div>


                        <div class="location">

                            ${escapeHtml(

                                scholarship.country ||

                                TEXT.internationalNotSpecified

                            )}

                        </div>

                    </div>


                    <div class="match-score">

                        <strong>

                            ${Math.round(
                                Number(
                                    best.match_score || 0
                                )
                            )}%

                        </strong>

                        <small>
                            MATCH
                        </small>

                    </div>

                </div>


                <p class="opportunity-description">

                    ${escapeHtml(

                        scholarship.description ||

                        TEXT.descriptionNotAvailable

                    )}

                </p>

            </div>

        `;

    }


    let showAllMatches = false;

    function toggleAllMatches() {
        showAllMatches = !showAllMatches;
        renderMatches();
    }

    function closeGapPanel(panel) {
        if (!panel) return;
        panel.classList.add('hidden');

        const card = panel.closest('.match-card');
        const button = card ? card.querySelector('.why-match-btn') : null;
        if (button) {
            const isArabic = document.documentElement.lang === 'ar';
            button.textContent = isArabic ? 'لماذا هذه المطابقة؟' : 'Why this match?';
            button.setAttribute('aria-expanded', 'false');
        }
    }

    function closeAllGapPanels() {
        document.querySelectorAll('.gap-panel:not(.hidden)').forEach(closeGapPanel);
    }

    function ensureGapCloseButtons() {
        document.querySelectorAll('.gap-panel').forEach(panel => {
            if (!panel.querySelector('.gap-modal-close')) {
                const closeBtn = document.createElement('button');
                closeBtn.type = 'button';
                closeBtn.className = 'gap-modal-close';
                closeBtn.setAttribute('aria-label', 'Close');
                closeBtn.innerHTML = '&times;';
                closeBtn.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    closeGapPanel(panel);
                });
                panel.prepend(closeBtn);
            }
        });
    }

    function renderMatches() {

        const grid =
            document.getElementById(
                'matchesGrid'
            );


        if (!recommendations.length) {

            grid.innerHTML = `

                <div
                    class="empty-state"
                    style="grid-column:1/-1;"
                >

                    <strong>
                        ${escapeHtml(
                            TEXT.noAiMatches
                        )}
                    </strong>

                    ${escapeHtml(
                        TEXT.noAiMatchesNote
                    )}

                </div>

            `;


            document
                .getElementById(
                    'matchesGeneratedAt'
                )
                .textContent =
                    TEXT.matchingEngine;


            return;

        }


        const sorted =
            [...recommendations]
                .sort(
                    (a,b) =>
                        Number(
                            b.match_score || 0
                        ) -
                        Number(
                            a.match_score || 0
                        )
                );


        const topMatches =
            showAllMatches ? sorted : sorted.slice(0,3);

        const toggleBtn = document.getElementById('toggleAllMatchesBtn');
        if (toggleBtn) {
            const isArabic = document.documentElement.lang === 'ar';
            toggleBtn.textContent = showAllMatches
                ? (isArabic ? 'عرض أقل' : 'Show less')
                : (isArabic ? `عرض جميع المنح (${sorted.length})` : `View all scholarships (${sorted.length})`);
            toggleBtn.style.display = sorted.length > 3 ? 'inline-flex' : 'none';
        }


        grid.innerHTML =
            topMatches
                .map(item => {

                    const scholarship =
                        item.scholarship || {};


                    const schId =
                        Number(
                            scholarship.scholarship_id ??
                            item.scholarship_id
                        );


                    const existingApp =
                        applications.find(
                            a =>
                                Number(a.scholarship_id) ===
                                schId
                        );


                    const alreadyApplied =
                        existingApp &&
                        existingApp.status !== 'saved';


                    return `

                        <article class="match-card">

                            <span class="match-percent">

                                ${Math.round(
                                    Number(
                                        item.match_score || 0
                                    )
                                )}%
                                ${escapeHtml(TEXT.matched)}

                            </span>


                            <h3>

                                ${escapeHtml(

                                    scholarship.title ||

                                    TEXT.scholarship

                                )}

                            </h3>


                            <div class="provider">

                                ${escapeHtml(

                                    scholarship.provider_name ||

                                    TEXT.providerNotSpecified

                                )}

                            </div>


                            <div class="match-country">

                                ${escapeHtml(

                                    scholarship.country ||

                                    TEXT.international

                                )}

                            </div>


                            <div class="match-actions">

                                <button
                                    type="button"
                                    class="why-match-btn"
                                    data-recommendation-id="${item.recommendation_id}"
                                    onclick="toggleGapAnalysis(this)"
                                >

                                    ${escapeHtml(
                                        TEXT.whyMatch
                                    )}

                                </button>


                                <button
                                    type="button"
                                    class="why-match-btn apply-btn"
                                    data-scholarship-id="${schId}"
                                    onclick="applyToScholarship(this)"
                                    ${alreadyApplied ? 'disabled' : ''}
                                >

                                    ${
                                        alreadyApplied
                                            ? '✓ ' + escapeHtml(TEXT.applied)
                                            : escapeHtml(TEXT.apply)
                                    }

                                </button>


                                <div
                                    id="gap-analysis-${item.recommendation_id}"
                                    class="gap-panel hidden"
                                ></div>

                            </div>

                        </article>

                    `;

                })
                .join('');


        const generatedAt =
            recommendations[0]
                ?.generated_at;


        if (generatedAt) {

            document
                .getElementById(
                    'matchesGeneratedAt'
                )
                .textContent =
                    `${TEXT.updated}: ${formatDate(generatedAt)}`;

        }

    }


    async function applyToScholarship(btn) {

        const scholarshipId =
            Number(btn.dataset.scholarshipId);


        if (!scholarshipId) {
            return;
        }


        btn.disabled = true;


        try {

            const response =
                await fetch(

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

                throw new Error(
                    'Apply failed: ' + response.status
                );

            }


            const fresh =
                await requestJson(

                    `${API_BASE_URL}/saved-applications`,

                    {
                        headers: authHeaders()
                    }

                );


            applications =
                normalizeCollection(fresh);


            renderStats();

            renderMatches();

            renderApplications();

            renderJourney();

        }

        catch (error) {

            console.error(error);

            btn.disabled = false;

            showToast(TEXT.applyFailed);

        }

    }


    function renderGapAnalysis(data) {

        const summary =
            data?.summary || {};


        const matched =
            Array.isArray(
                data?.matched_criteria
            )
                ? data.matched_criteria
                : [];


        const mandatoryGaps =
            Array.isArray(
                data?.gaps?.mandatory
            )
                ? data.gaps.mandatory
                : [];


        const optionalGaps =
            Array.isArray(
                data?.gaps?.optional
            )
                ? data.gaps.optional
                : [];


        const warnings =
            Array.isArray(
                data?.warnings
            )
                ? data.warnings
                : [];


        const matchedHtml =
            matched.length

                ? `

                    <div class="gap-block">

                        <div class="gap-block-title">

                            ✓
                            ${escapeHtml(
                                TEXT.matchedCriteria
                            )}

                        </div>


                        ${matched.map(item => `

                            <div class="gap-item matched">

                                ${escapeHtml(

                                    item.message ||

                                    `${item.type}: ${item.required_value}`

                                )}

                            </div>

                        `).join('')}

                    </div>

                `

                : '';


        const allGaps = [

            ...mandatoryGaps.map(
                item => ({

                    ...item,

                    gapLabel:
                        TEXT.mandatory

                })
            ),

            ...optionalGaps.map(
                item => ({

                    ...item,

                    gapLabel:
                        TEXT.optional

                })
            )

        ];


        const gapsHtml =
            allGaps.length

                ? `

                    <div class="gap-block">

                        <div class="gap-block-title">

                            !
                            ${escapeHtml(
                                TEXT.missingCriteria
                            )}

                        </div>


                        ${allGaps.map(item => `

                            <div class="gap-item missing">

                                <strong>

                                    ${escapeHtml(
                                        item.gapLabel
                                    )}:

                                </strong>


                                ${escapeHtml(

                                    item.message ||

                                    `${item.type}: ${item.required_value}`

                                )}

                                ${
                                    item.suggestion

                                        ? `

                                            <span class="gap-suggestion">

                                                ${escapeHtml(
                                                    TEXT.nextStep
                                                )}:

                                                ${escapeHtml(
                                                    item.suggestion
                                                )}

                                            </span>

                                        `

                                        : ''
                                }

                                ${
                                    item.course

                                        ? `

                                            <div class="gap-course">

                                                🎓

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

                                        `

                                        : ''
                                }

                            </div>

                        `).join('')}

                    </div>

                `

                : `

                    <div class="gap-block">

                        <div class="gap-block-title">

                            ${escapeHtml(
                                TEXT.gaps
                            )}

                        </div>


                        <div class="gap-item matched">

                            ${escapeHtml(
                                TEXT.noUnmetCriteria
                            )}

                        </div>

                    </div>

                `;


        const warningsHtml =
            warnings.length

                ? `

                    <div class="gap-block">

                        <div class="gap-block-title">

                            ${escapeHtml(
                                TEXT.analysisNotes
                            )}

                        </div>


                        ${warnings.map(warning => `

                            <div class="gap-warning">

                                ${escapeHtml(
                                    warning.message
                                )}

                            </div>

                        `).join('')}

                    </div>

                `

                : '';


        return `

            <div class="gap-summary">

                <span class="gap-chip good">

                    ${Number(
                        summary.matched_criteria || 0
                    )}

                    ${escapeHtml(
                        TEXT.matched
                    )}

                </span>


                <span
                    class="gap-chip ${
                        Number(
                            summary.missing_criteria || 0
                        ) > 0
                            ? 'warning'
                            : 'good'
                    }"
                >

                    ${Number(
                        summary.missing_criteria || 0
                    )}

                    ${escapeHtml(
                        TEXT.gapCount
                    )}

                </span>


                <span class="gap-chip">

                    ${escapeHtml(
                        TEXT.analysis
                    )}:

                    ${escapeHtml(
                        summary.analysis_level ||
                        'unknown'
                    )}

                </span>


                <span
                    class="gap-chip ${
                        summary.cv_connected
                            ? 'good'
                            : 'warning'
                    }"
                >

                    CV:

                    ${
                        summary.cv_connected
                            ? escapeHtml(
                                TEXT.cvConnected
                            )
                            : escapeHtml(
                                TEXT.cvNotConnected
                            )
                    }

                </span>

            </div>


            ${matchedHtml}

            ${gapsHtml}

            ${warningsHtml}

        `;

    }


    function openMatchModal(html) {
        const modal = document.getElementById('matchModal');
        const content = document.getElementById('matchModalContent');
        if (!modal || !content) return;
        content.innerHTML = html;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden','false');
        document.body.classList.add('modal-open');
    }

    function closeMatchModal() {
        const modal = document.getElementById('matchModal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden','true');
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.why-match-btn').forEach(btn => {
            if (!btn.classList.contains('apply-btn')) {
                btn.textContent = TEXT.whyMatch;
                btn.disabled = false;
            }
        });
    }

    async function toggleGapAnalysis(button) {
        const recommendationId = button.dataset.recommendationId;
        if (!recommendationId) return;

        button.disabled = true;
        button.textContent = TEXT.analyzing;

        try {
            const analysis = await requestJson(
                `${API_BASE_URL}/recommendations/${recommendationId}/gap-analysis`,
                { headers: authHeaders() }
            );
            openMatchModal(renderGapAnalysis(analysis));
            button.textContent = TEXT.whyMatch;
        } catch (error) {
            console.error('Gap analysis error:', error);
            showToast(error.message || 'Could not load match analysis.');
            button.textContent = TEXT.whyMatch;
        } finally {
            button.disabled = false;
        }
    }


    async function loadNotifications() {
        try {
            const data = await requestJson('/api/notifications', { headers: authHeaders() });
            notifications = normalizeCollection(data);
            renderNotifications();
        } catch (e) {
            console.error('Failed to load notifications', e);
        }
    }

    function renderNotificationsMeta() {
        const unreadCount = notifications.filter(n => !n.read_at).length;

        const badge = document.getElementById('notificationsUnreadBadge');
        if (badge) {
            if (unreadCount > 0) {
                badge.textContent = String(unreadCount);
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }

        const markAllBtn = document.getElementById('markAllNotificationsReadBtn');
        if (markAllBtn) {
            markAllBtn.style.display = unreadCount > 0 ? 'inline-block' : 'none';
        }
    }

    async function markNotificationAsRead(notificationId) {
        try {
            await requestJson(`/api/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: authHeaders()
            });

            const target = notifications.find(n => String(n.notification_id) === String(notificationId));
            if (target) {
                target.read_at = new Date().toISOString();
            }

            renderNotificationsMeta();
        } catch (e) {
            console.error('Failed to mark notification as read', e);
        }
    }

    async function markAllNotificationsAsRead() {
        try {
            await requestJson('/api/notifications/read-all', {
                method: 'POST',
                headers: authHeaders()
            });

            notifications.forEach(n => { n.read_at = n.read_at || new Date().toISOString(); });
            renderNotifications();
        } catch (e) {
            console.error('Failed to mark all notifications as read', e);
        }
    }

    function renderNotifications() {
        const container = document.getElementById('notificationsList');
        if (!container) { return; }

        renderNotificationsMeta();

        if (!notifications.length) {
            container.innerHTML = `
                <div class="empty-state">
                    <strong>${escapeHtml(TEXT.notificationsEmpty)}</strong>
                </div>
            `;
            return;
        }

        container.innerHTML = notifications.map(notification => {
            const scholarship = (notification.saved_application && notification.saved_application.scholarship) || {};
            const isUnread = !notification.read_at;
            return `
                <article class="application-card${isUnread ? ' notification-unread' : ''}" data-notification-id="${notification.notification_id}">
                    <div class="application-top">
                        <div>
                            <div class="application-title">
                                ${isUnread ? '<span class="unread-dot" aria-hidden="true"></span> ' : ''}${escapeHtml(scholarship.title || scholarship.provider_name || 'Scholarship Opportunity')}
                            </div>
                            <div class="provider" style="margin-top:5px;">
                                ${escapeHtml((notification.notification_type || '').replace('_', ' '))}
                                &middot;
                                ${escapeHtml(notification.channel || '')}
                            </div>
                        </div>
                        <span class="status-badge">${escapeHtml(notification.status || '')}</span>
                    </div>
                    <div class="application-meta">
                        <span>${escapeHtml(TEXT.notificationsDeadline)}: ${escapeHtml(formatDate(notification.scheduled_for))}</span>
                    </div>
                    <div class="application-actions" style="margin-top:10px;">
                        ${isUnread ? `<button type="button" class="quick-action" onclick="markNotificationAsRead(${notification.notification_id})">${escapeHtml(TEXT.notificationsMarkRead)}</button>` : ''}
                        <button type="button" class="quick-action" onclick="deleteNotification(${notification.notification_id})">
                            ${escapeHtml(TEXT.notificationsDelete)}
                        </button>
                    </div>
                </article>
            `;
        }).join('');
    }

    async function deleteNotification(id) {
        if (!confirm(TEXT.notificationsDeleteConfirm)) { return; }
        try {
            await requestJson(`/api/notifications/${id}`, { method: 'DELETE', headers: authHeaders() });
            notifications = notifications.filter(n => n.notification_id !== id);
            renderNotifications();
        } catch (e) {
            console.error('Failed to delete notification', e);
        }
    }

    function renderApplications() {

        const container =
            document.getElementById(
                'applicationsList'
            );


        if (!applications.length) {

            container.innerHTML = `

                <div class="empty-state">

                    <strong>

                        ${escapeHtml(
                            TEXT.noSavedApplications
                        )}

                    </strong>

                    ${escapeHtml(
                        TEXT.noSavedApplicationsNote
                    )}

                </div>

            `;

            return;

        }


        const ordered =
            [...applications]
                .sort(
                    (a,b) =>

                        new Date(
                            b.status_updated_at ||
                            b.saved_at
                        )

                        -

                        new Date(
                            a.status_updated_at ||
                            a.saved_at
                        )
                );


        container.innerHTML =
            ordered.map(application => {

                const scholarship =
                    application.scholarship ||
                    {};


                return `

                    <article class="application-card">

                        <div class="application-top">

                            <div>

                                <div class="application-title">

                                    ${escapeHtml(

                                        scholarship.title ||

                                        TEXT.scholarshipOpportunity

                                    )}

                                </div>


                                <div
                                    class="provider"
                                    style="margin-top:5px;"
                                >

                                    ${escapeHtml(

                                        scholarship.provider_name ||

                                        TEXT.providerNotSpecified

                                    )}

                                </div>

                            </div>


                            <span class="status-badge">

                                ${escapeHtml(
                                    application.status ||
                                    'saved'
                                )}

                            </span>

                        </div>


                        <div class="application-meta">

                            <span>

                                ${escapeHtml(

                                    scholarship.country ||

                                    TEXT.international

                                )}

                            </span>


                            <span>

                                ${escapeHtml(
                                    TEXT.deadline
                                )}:

                                ${escapeHtml(

                                    formatDate(
                                        scholarship
                                            .application_deadline
                                    )

                                )}

                            </span>


                            <span>

                                ${escapeHtml(
                                    TEXT.updated
                                )}:

                                ${escapeHtml(

                                    formatDate(
                                        application
                                            .status_updated_at
                                    )

                                )}

                            </span>

                        </div>

                    </article>

                `;

            }).join('');

    }


    function renderJourney() {

        const profileComplete =
            calculateProfileCompletion(
                currentProfile
            ) > 0;


        const hasMatches =
            recommendations.length > 0;


        const hasApplications =
            applications.length > 0;


        const hasSubmittedApplication =
            applications.some(
                application => {

                    return String(
                        application.status || ''
                    ).toLowerCase()
                        === 'submitted';

                }
            );


        document
            .getElementById(
                'journeyProfile'
            )
            .classList.toggle(
                'done',
                profileComplete
            );


        document
            .getElementById(
                'journeyMatch'
            )
            .classList.toggle(
                'done',
                hasMatches
            );


        document
            .getElementById(
                'journeyPrepare'
            )
            .classList.toggle(
                'done',
                hasApplications
            );


        document
            .getElementById(
                'journeyApply'
            )
            .classList.toggle(
                'done',
                hasSubmittedApplication
            );

    }


    function renderDashboard() {

        renderStats();

        renderBestOpportunity();

        renderMatches();

        renderApplications();

        loadNotifications();

        renderJourney();

    }


    async function requestJson(
        url,
        options = {}
    ) {

        const response =
            await fetch(
                url,
                options
            );


        if (
            response.status === 401
        ) {

            goToLogin();

            throw new Error(
                'Unauthenticated'
            );

        }


        if (!response.ok) {

            let message =
                `Request failed with status ${response.status}`;


            try {

                const body =
                    await response.json();


                if (body?.message) {

                    message =
                        body.message;

                }

            }

            catch (_) {}


            throw new Error(
                message
            );

        }


        return response.json();

    }


    async function loadDashboard() {

        const token =
            getToken();


        if (!token) {

            goToLogin();

            return;

        }


        try {

            currentUser =
                await requestJson(

                    `${API_BASE_URL}/me`,

                    {
                        headers:
                            authHeaders()
                    }

                );


            localStorage.setItem(

                'auth_user',

                JSON.stringify(
                    currentUser
                )

            );


            const displayName =

                currentUser.full_name ||

                currentUser.name ||

                'Student';


            document
                .getElementById(
                    'welcomeHeading'
                )
                .textContent =

                    TEXT.welcomeBack.replace(
                        '__NAME__',
                        displayName
                    );


            const results =
                await Promise.allSettled([

                    requestJson(
                        `${API_BASE_URL}/profile`,
                        {
                            headers:
                                authHeaders()
                        }
                    ),

                    requestJson(
                        `${API_BASE_URL}/recommendations`,
                        {
                            headers:
                                authHeaders()
                        }
                    ),

                    requestJson(
                        `${API_BASE_URL}/saved-applications`,
                        {
                            headers:
                                authHeaders()
                        }
                    )

                ]);


            if (
                results[0].status ===
                'fulfilled'
            ) {

                currentProfile =
                    results[0].value;

            }


            if (
                results[1].status ===
                'fulfilled'
            ) {

                recommendations =
                    normalizeCollection(
                        results[1].value
                    );

            }


            if (
                results[2].status ===
                'fulfilled'
            ) {

                applications =
                    normalizeCollection(
                        results[2].value
                    );

            }


            renderDashboard();


            document
                .getElementById(
                    'loadingScreen'
                )
                .classList.add(
                    'hidden'
                );


            document
                .getElementById(
                    'appShell'
                )
                .classList.remove(
                    'hidden'
                );

        }

        catch (error) {

            console.error(
                'Dashboard loading error:',
                error
            );


            if (
                error.message !==
                'Unauthenticated'
            ) {

                document
                    .getElementById(
                        'loadingScreen'
                    )
                    .innerHTML = `

                        <div
                            class="empty-state"
                            style="max-width:420px;"
                        >

                            <strong>

                                ${escapeHtml(
                                    TEXT.dashboardLoadFailed
                                )}

                            </strong>

                            ${escapeHtml(
                                error.message
                            )}

                        </div>

                    `;

            }

        }

    }


    async function refreshRecommendations() {

        const buttons = [

            document.getElementById(
                'refreshRecommendationsBtn'
            ),

            document.getElementById(
                'refreshRecommendationsQuick'
            )

        ];


        buttons.forEach(
            button => {

                if (button) {
                    button.disabled =
                        true;
                }

            }
        );


        try {

            const result =
                await requestJson(

                    `${API_BASE_URL}/recommendations/generate`,

                    {
                        method:
                            'POST',

                        headers:
                            authHeaders()
                    }

                );


            recommendations =
                normalizeCollection(

                    result.data ??
                    result

                );


            if (!recommendations.length) {

                const latest =
                    await requestJson(

                        `${API_BASE_URL}/recommendations`,

                        {
                            headers:
                                authHeaders()
                        }

                    );


                recommendations =
                    normalizeCollection(
                        latest
                    );

            }


            renderDashboard();


            showToast(

                CURRENT_LOCALE === 'ar'

                    ? `تم إنشاء ${recommendations.length} مطابقة للمنح بنجاح.`

                    : `${recommendations.length} scholarship matches generated successfully.`

            );

        }

        catch (error) {

            console.error(
                error
            );


            showToast(

                error.message ||

                (
                    CURRENT_LOCALE === 'ar'

                        ? 'تعذر تحديث مطابقات المنح.'

                        : 'Could not refresh recommendations.'
                )

            );

        }

        finally {

            buttons.forEach(
                button => {

                    if (button) {
                        button.disabled =
                            false;
                    }

                }
            );

        }

    }


    // Shared header owns logout and theme handlers.

    const markAllNotifBtn = document.getElementById('markAllNotificationsReadBtn');
    if (markAllNotifBtn) {
        markAllNotifBtn.addEventListener('click', markAllNotificationsAsRead);
    }

    document
        .getElementById(
            'refreshRecommendationsBtn'
        )
        .addEventListener(
            'click',
            refreshRecommendations
        );


    document
        .getElementById(
            'refreshRecommendationsQuick'
        )
        .addEventListener(
            'click',
            refreshRecommendations
        );


    window.addEventListener(
        'pageshow',
        () => {
            loadDashboard();
        }
    );


    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeMatchModal();
    });

</script>


</body>
</html> 


    @include('components.jisr-footer')

    <div id="matchModal" class="jisr-modal hidden" aria-hidden="true">
        <div class="jisr-modal-backdrop" onclick="closeMatchModal()"></div>
        <section class="jisr-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="matchModalTitle">
            <div class="jisr-modal-head">
                <div>
                    <span class="jisr-modal-kicker">{{ app()->getLocale()==='ar' ? 'Jisr Match Intelligence' : 'Jisr Match Intelligence' }}</span>
                    <h2 id="matchModalTitle">{{ app()->getLocale()==='ar' ? 'لماذا تناسبك هذه الفرصة؟' : 'Why does this opportunity fit you?' }}</h2>
                </div>
                <button type="button" class="jisr-modal-close" onclick="closeMatchModal()" aria-label="Close">×</button>
            </div>
            <div id="matchModalContent" class="jisr-modal-content"></div>
        </section>
    </div>



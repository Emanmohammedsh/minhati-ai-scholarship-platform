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

    <title>
        {{ __('common.career_path') }} | Jisr AI
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <style>

        :root {

            --primary: #0A2E6B;
            --primary-dark: #061F49;

            --secondary: #00C6FF;
            --accent: #87DFFF;

            --background: #EAF6FF;
            --surface: #FFFFFF;

            --text: #4B5563;
            --heading: #071D45;

            --border: #DCEEF8;

            --success: #16A085;

            --shadow:
                0 18px 60px rgba(10,46,107,.10);

        }


        * {

            box-sizing: border-box;

            margin: 0;
            padding: 0;

        }


        body {

            font-family:
                {{ app()->getLocale() === 'ar'
                    ? 'Arial, sans-serif'
                    : '"Poppins", Arial, sans-serif'
                }};

            background:

                radial-gradient(
                    circle at 90% 5%,
                    rgba(0,198,255,.15),
                    transparent 28%
                ),

                radial-gradient(
                    circle at 5% 60%,
                    rgba(135,223,255,.20),
                    transparent 25%
                ),

                #f8fcff;

            color: var(--text);

            min-height: 100vh;

        }


        a {

            text-decoration: none;

        }


        /* ======================================
           NAVBAR
        ====================================== */

        .navbar {

            min-height: 84px;

            display: flex;

            align-items: center;
            justify-content: space-between;

            padding:
                14px clamp(24px,5vw,72px);

            background:
                rgba(255,255,255,.88);

            backdrop-filter:
                blur(18px);

            border-bottom:
                1px solid rgba(10,46,107,.08);

            position: sticky;

            top: 0;

            z-index: 100;

        }


        .brand {

            display: flex;

            align-items: center;

            gap: 14px;

        }


        .brand img {

            width: 55px;
            height: 55px;

            object-fit: contain;

            border-radius: 14px;

        }


        .brand-text {

            line-height: 1.05;

        }


        .brand-text strong {

            display: block;

            color: var(--primary);

            font-family:
                "Poppins",
                sans-serif;

            font-size: 19px;

        }


        .brand-text span {

            font-family:
                "Poppins",
                sans-serif;

            font-size: 11px;

            letter-spacing: 1.7px;

            color: #7B8794;

        }


        .nav-links {

            display: flex;

            align-items: center;

            gap: 8px;

        }


        .nav-item {

            color: var(--primary);

            padding: 10px 14px;

            border-radius: 10px;

            font-size: 13px;

            font-weight: 500;

            transition: .2s ease;

        }


        .nav-item:hover {

            background:
                var(--background);

        }


        /* ======================================
           LANGUAGE
        ====================================== */

        .language-switcher {

            display: flex;

            align-items: center;

            gap: 7px;

            direction: ltr;

            background:
                var(--background);

            padding: 7px 11px;

            border-radius: 10px;

            font-family:
                "Poppins",
                sans-serif;

            font-size: 12px;

            font-weight: 600;

        }


        .language-switcher a {

            color: #7B8794;

            transition: .2s;

        }


        .language-switcher a.active {

            color:
                var(--primary);

            font-weight: 700;

        }


        .language-switcher a:hover {

            color:
                var(--secondary);

        }


        .language-switcher span {

            color:
                #BCD2DF;

        }


        .logout-btn {

            border: none;

            background:
                var(--primary);

            color: white;

            padding: 11px 17px;

            border-radius: 11px;

            font-family: inherit;

            font-weight: 600;

            cursor: pointer;

            transition: .2s;

        }


        .logout-btn:hover {

            transform:
                translateY(-1px);

            box-shadow:
                0 8px 20px rgba(10,46,107,.20);

        }


        /* ======================================
           CONTAINER
        ====================================== */

        .container {

            width:
                min(1180px,calc(100% - 40px));

            margin:
                0 auto;

            padding:
                46px 0 70px;

        }


        /* ======================================
           HERO
        ====================================== */

        .hero {

            position: relative;

            overflow: hidden;

            border-radius: 30px;

            padding: 55px;

            min-height: 340px;

            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 45px;

            color: white;

            background:

                linear-gradient(
                    125deg,
                    #061F49 0%,
                    #0A2E6B 55%,
                    #064D82 100%
                );

            box-shadow:
                0 30px 80px rgba(10,46,107,.25);

        }


        .hero::before {

            content: "";

            position: absolute;

            width: 420px;
            height: 420px;

            border-radius: 50%;

            inset-inline-end: -110px;

            top: -190px;

            background:

                linear-gradient(
                    135deg,
                    rgba(0,198,255,.34),
                    rgba(135,223,255,.05)
                );

        }


        .hero::after {

            content: "";

            position: absolute;

            width: 330px;
            height: 330px;

            border-radius: 50%;

            inset-inline-end: 80px;

            bottom: -250px;

            border:
                40px solid rgba(0,198,255,.10);

        }


        .hero-content {

            position: relative;

            z-index: 3;

            max-width: 660px;

        }


        .eyebrow {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 8px 14px;

            background:
                rgba(255,255,255,.10);

            border:
                1px solid rgba(255,255,255,.14);

            border-radius: 999px;

            font-size: 12px;

            font-weight: 600;

            margin-bottom: 21px;

        }


        .eyebrow-dot {

            width: 8px;
            height: 8px;

            flex: 0 0 8px;

            border-radius: 50%;

            background:
                var(--secondary);

            box-shadow:
                0 0 16px var(--secondary);

        }


        .hero h1 {

            font-size:
                clamp(36px,5vw,58px);

            line-height: 1.15;

            margin-bottom: 18px;

        }


        .hero h1 span {

            color:
                var(--secondary);

        }


        .hero p {

            color:
                #D8ECF8;

            line-height: 1.9;

            font-size: 15px;

            max-width: 610px;

        }


        .hero-buttons {

            display: flex;

            gap: 12px;

            margin-top: 28px;

            flex-wrap: wrap;

        }


        .primary-btn,
        .secondary-btn {

            padding: 13px 20px;

            border-radius: 12px;

            font-size: 13px;

            font-weight: 600;

            transition: .25s;

        }


        .primary-btn {

            background:

                linear-gradient(
                    135deg,
                    var(--secondary),
                    #008FE8
                );

            color: white;

            box-shadow:
                0 12px 25px rgba(0,198,255,.22);

        }


        .primary-btn:hover {

            transform:
                translateY(-2px);

        }


        .secondary-btn {

            border:
                1px solid rgba(255,255,255,.22);

            color: white;

            background:
                rgba(255,255,255,.08);

        }


        .hero-visual {

            position: relative;

            z-index: 5;

            min-width: 270px;

            height: 230px;

            display: flex;

            align-items: center;
            justify-content: center;

        }


        .hero-logo-card {

            width: 205px;
            height: 205px;

            border-radius: 34px;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                rgba(255,255,255,.97);

            box-shadow:
                0 25px 50px rgba(0,0,0,.18);

            transform:
                rotate(3deg);

        }


        .hero-logo-card img {

            width: 155px;
            height: 155px;

            object-fit: contain;

            transform:
                rotate(-3deg);

        }


        /* ======================================
           STATS
        ====================================== */

        .stats {

            display: grid;

            grid-template-columns:
                repeat(4,1fr);

            gap: 16px;

            margin:
                28px 0 45px;

        }


        .stat {

            background:
                rgba(255,255,255,.92);

            border:
                1px solid var(--border);

            border-radius: 18px;

            padding: 21px;

            box-shadow:
                0 8px 30px rgba(10,46,107,.05);

        }


        .stat-label {

            font-size: 12px;

            color: #84919B;

            margin-bottom: 7px;

        }


        .stat-value {

            color:
                var(--primary);

            font-size: 24px;

            font-weight: 700;

        }


        .stat-value small {

            font-size: 12px;

            font-weight: 500;

            color: #7A8A95;

        }


        /* ======================================
           SECTION
        ====================================== */

        .section-heading {

            display: flex;

            justify-content: space-between;

            align-items: flex-end;

            gap: 30px;

            margin-bottom: 22px;

        }


        .section-heading small {

            display: block;

            color:
                var(--secondary);

            font-weight: 600;

            margin-bottom: 6px;

            letter-spacing: .5px;

        }


        .section-heading h2 {

            color:
                var(--heading);

            font-size: 27px;

        }


        .section-heading p {

            max-width: 520px;

            font-size: 13px;

            line-height: 1.7;

            color: #7A8792;

        }


        /* ======================================
           JOURNEY
        ====================================== */

        .journey-grid {

            display: grid;

            grid-template-columns:
                repeat(4,1fr);

            gap: 18px;

        }


        .journey-card {

            position: relative;

            overflow: hidden;

            background: white;

            border:
                1px solid var(--border);

            border-radius: 21px;

            padding: 25px;

            min-height: 215px;

            transition: .3s ease;

            box-shadow:
                0 10px 35px rgba(10,46,107,.05);

        }


        .journey-card::before {

            content: "";

            position: absolute;

            inset-inline-start: 0;

            top: 0;

            width: 100%;

            height: 3px;

            background:

                linear-gradient(
                    90deg,
                    var(--primary),
                    var(--secondary)
                );

            transform:
                scaleX(0);

            transition: .3s;

        }


        .journey-card:hover {

            transform:
                translateY(-7px);

            box-shadow:
                0 20px 50px rgba(10,46,107,.11);

        }


        .journey-card:hover::before {

            transform:
                scaleX(1);

        }


        .icon-box {

            width: 48px;
            height: 48px;

            border-radius: 14px;

            display: flex;

            align-items: center;
            justify-content: center;

            background:

                linear-gradient(
                    135deg,
                    var(--background),
                    #D5F3FF
                );

            margin-bottom: 18px;

            color:
                var(--primary);

        }


        .icon-box svg {

            width: 24px;
            height: 24px;

            stroke:
                currentColor;

            fill: none;

            stroke-width: 2;

        }


        .journey-card h3 {

            color:
                var(--heading);

            font-size: 16px;

            margin-bottom: 9px;

        }


        .journey-card p {

            font-size: 12.5px;

            line-height: 1.75;

            color: #74828C;

        }


        /* ======================================
           DEVELOPMENT
        ====================================== */

        .coming-card {

            margin-top: 42px;

            border-radius: 24px;

            padding: 34px;

            display: grid;

            grid-template-columns:
                1.3fr .7fr;

            gap: 35px;

            align-items: center;

            border:
                1px solid #CCEFFF;

            background:

                linear-gradient(
                    120deg,
                    #EFFAFF,
                    #FFFFFF
                );

            position: relative;

            overflow: hidden;

        }


        .coming-card::after {

            content: "";

            position: absolute;

            inset-inline-end: -80px;

            top: -120px;

            width: 280px;
            height: 280px;

            background:
                rgba(0,198,255,.08);

            border-radius: 50%;

        }


        .coming-card h3 {

            color:
                var(--heading);

            margin-bottom: 10px;

            font-size: 22px;

        }


        .coming-card p {

            font-size: 13px;

            line-height: 1.8;

        }


        .development-status {

            position: relative;

            z-index: 2;

            padding: 22px;

            background:
                rgba(255,255,255,.75);

            border:
                1px solid var(--border);

            border-radius: 18px;

            text-align: center;

        }


        .development-status small {

            display: block;

            color: #7B8794;

            margin-bottom: 8px;

        }


        .development-status strong {

            display: block;

            color:
                var(--primary);

            font-size: 18px;

        }


        .status-dot {

            width: 9px;
            height: 9px;

            display: inline-block;

            border-radius: 50%;

            background:
                var(--secondary);

            margin-inline-end: 7px;

            box-shadow:
                0 0 12px rgba(0,198,255,.55);

        }


        /* ======================================
           BRAND MESSAGE
        ====================================== */

        .brand-message {

            margin-top: 45px;

            padding: 40px;

            text-align: center;

            border-radius: 25px;

            color: white;

            background:

                linear-gradient(
                    135deg,
                    #071F4E,
                    #0A2E6B
                );

            position: relative;

            overflow: hidden;

        }


        .brand-message h3 {

            position: relative;

            font-size: 26px;

            margin-bottom: 8px;

        }


        .brand-message span {

            position: relative;

            color:
                var(--accent);

            font-family:
                "Poppins",
                sans-serif;

            font-size: 13px;

            letter-spacing: 3px;

        }



        /* ======================================
           LIVE JOB MATCHES
        ====================================== */

        .matches-section {
            margin: 45px 0;
        }

        .matches-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .refresh-btn {
            border: none;
            background: var(--primary);
            color: white;
            padding: 12px 17px;
            border-radius: 11px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .refresh-btn:disabled {
            opacity: .65;
            cursor: wait;
        }

        .dashboard-message {
            display: none;
            margin-bottom: 16px;
            padding: 13px 16px;
            border-radius: 13px;
            font-size: 13px;
        }

        .dashboard-message.success {
            display: block;
            color: #08735E;
            background: #ECFBF6;
            border: 1px solid #BCEBDE;
        }

        .dashboard-message.error {
            display: block;
            color: #9E3030;
            background: #FFF3F3;
            border: 1px solid #F2CACA;
        }

        .job-matches-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .job-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 25px;
            box-shadow: 0 10px 35px rgba(10,46,107,.06);
        }

        .job-card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .job-card h3 {
            color: var(--heading);
            font-size: 18px;
            margin-bottom: 7px;
        }

        .company-name {
            color: #667784;
            font-size: 13px;
            font-weight: 600;
        }

        .match-badge {
            flex: 0 0 auto;
            min-width: 86px;
            text-align: center;
            padding: 10px 12px;
            border-radius: 14px;
            color: var(--primary);
            background: linear-gradient(135deg,#E8F9FF,#D9F4FF);
            border: 1px solid #C6EDFB;
            font-weight: 700;
            font-size: 18px;
        }

        .match-badge small {
            display: block;
            margin-top: 2px;
            color: #73828D;
            font-size: 9px;
        }

        .job-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 18px 0;
        }

        .meta-pill {
            padding: 7px 10px;
            border-radius: 999px;
            background: #F3F9FC;
            border: 1px solid var(--border);
            color: #657681;
            font-size: 11px;
        }

        .job-description {
            color: #75848E;
            font-size: 12.5px;
            line-height: 1.75;
            margin-bottom: 18px;
        }

        .why-btn {
            border: none;
            background: var(--primary);
            color: white;
            padding: 10px 15px;
            border-radius: 10px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
        }


        .job-actions { display:flex; flex-wrap:wrap; gap:9px; margin-top:4px; align-items:center; }
        .save-job-btn,.apply-job-btn,.remove-job-btn,.status-select {
            border-radius:10px; font-family:inherit; font-size:12px; font-weight:600;
        }
        .save-job-btn,.apply-job-btn,.remove-job-btn { padding:10px 15px; cursor:pointer; }
        .save-job-btn { border:1px solid #BCEBDE; color:#08735E; background:#ECFBF6; }
        .apply-job-btn { border:none; color:white; background:var(--success); }
        .remove-job-btn { border:1px solid #F2CACA; color:#9E3030; background:#FFF3F3; }
        .status-select { padding:9px 11px; color:var(--primary); background:#F6FBFE; border:1px solid var(--border); }
        .application-state {
            padding:7px 10px; border-radius:999px; font-size:11px; font-weight:600;
            color:#08735E; background:#ECFBF6; border:1px solid #BCEBDE;
        }

        .analysis-panel {
            display: none;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
        }

        .analysis-panel.open {
            display: block;
        }

        .analysis-summary {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 9px;
            margin-bottom: 16px;
        }

        .analysis-stat {
            padding: 11px;
            border-radius: 12px;
            text-align: center;
            background: #F6FBFE;
            border: 1px solid var(--border);
        }

        .analysis-stat strong {
            display: block;
            color: var(--primary);
            font-size: 18px;
        }

        .analysis-stat span {
            display: block;
            margin-top: 3px;
            font-size: 9.5px;
            color: #7A8993;
        }

        .requirement-block {
            margin-top: 14px;
        }

        .requirement-block h4 {
            color: var(--heading);
            font-size: 13px;
            margin-bottom: 9px;
        }

        .requirement-list {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .requirement-pill {
            padding: 7px 10px;
            border-radius: 9px;
            font-size: 11px;
            border: 1px solid;
        }

        .requirement-pill.matched {
            color: #08735E;
            background: #ECFBF6;
            border-color: #BCEBDE;
        }

        .requirement-pill.gap {
            color: #9E5C10;
            background: #FFF8E9;
            border-color: #F2DCAC;
        }

        .empty-state,
        .loading-state {
            grid-column: 1 / -1;
            padding: 35px 24px;
            border-radius: 20px;
            background: white;
            border: 1px dashed #BBDDEB;
            text-align: center;
        }

        .empty-state h3 {
            color: var(--heading);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 13px;
            line-height: 1.7;
        }

        @media(max-width: 1000px) {
            .job-matches-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 520px) {
            .job-card-top {
                flex-direction: column;
            }

            .analysis-summary {
                grid-template-columns: 1fr;
            }
        }

        /* ======================================
           RTL / LTR
        ====================================== */

        html[dir="rtl"] .hero,
        html[dir="rtl"] .journey-card,
        html[dir="rtl"] .stat,
        html[dir="rtl"] .coming-card {

            text-align: right;

        }


        html[dir="ltr"] .hero,
        html[dir="ltr"] .journey-card,
        html[dir="ltr"] .stat,
        html[dir="ltr"] .coming-card {

            text-align: left;

        }


        /* ======================================
           RESPONSIVE
        ====================================== */

        @media(max-width: 1000px) {

            .journey-grid {

                grid-template-columns:
                    repeat(2,1fr);

            }


            .stats {

                grid-template-columns:
                    repeat(2,1fr);

            }


            .hero {

                padding: 38px;

            }


            .hero-visual {

                display: none;

            }

        }


        @media(max-width: 780px) {

            .navbar {

                padding:
                    12px 18px;

            }


            .brand-text {

                display: none;

            }


            .nav-item {

                display: none;

            }


            .container {

                width:
                    calc(100% - 28px);

                padding-top: 24px;

            }


            .hero {

                border-radius: 22px;

                padding:
                    30px 25px;

                min-height: auto;

            }


            .hero h1 {

                font-size: 34px;

            }


            .journey-grid,
            .stats,
            .coming-card {

                grid-template-columns: 1fr;

            }


            .section-heading {

                flex-direction: column;

                align-items: flex-start;

                gap: 10px;

            }

        }


        @media(max-width: 520px) {

            .language-switcher {

                padding: 6px 8px;

            }


            .logout-btn {

                padding: 9px 10px;

                font-size: 11px;

            }


            .brand img {

                width: 46px;
                height: 46px;

            }

        }

    </style>

</head>


<body>


<!-- ======================================
     NAVBAR
====================================== -->

<header class="navbar">


    <div class="brand">

        <img
            src="/images/jisr-logo.jpeg"
            alt="Jisr AI Logo"
        >


        <div class="brand-text">

            <strong>
                Jisr AI
            </strong>

            <span>
                BRIDGING TALENT TO OPPORTUNITY
            </span>

        </div>

    </div>



    <nav class="nav-links">


        <a
            href="/choose-path"
            class="nav-item"
        >
            {{ __('common.switch_path') }}
        </a>


        <a
            href="/profile"
            class="nav-item"
        >
            {{ __('common.profile') }}
        </a>


        <a
            href="/cv-upload"
            class="nav-item"
        >
            {{ __('common.my_cv') }}
        </a>



        <div class="language-switcher">

            <a
                href="{{ route('language.switch','ar') }}"
                class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}"
            >
                AR
            </a>

            <span>|</span>

            <a
                href="{{ route('language.switch','en') }}"
                class="{{ app()->getLocale() === 'en' ? 'active' : '' }}"
            >
                EN
            </a>

        </div>



        <button
            class="logout-btn"
            onclick="logout()"
        >
            {{ __('common.logout') }}
        </button>


    </nav>

</header>



<main class="container">


    <!-- ======================================
         HERO
    ====================================== -->

    <section class="hero">


        <div class="hero-content">


            <div class="eyebrow">

                <span class="eyebrow-dot"></span>

                {{ __('common.career_badge') }}

            </div>



            <h1>

                {{ __('common.career_hero_title') }}

            </h1>



            <p>

                {{ __('common.career_hero_description') }}

            </p>



            <div class="hero-buttons">


                <a
                    href="/profile"
                    class="primary-btn"
                >
                    {{ __('common.complete_profile') }}
                </a>


                <a
                    href="/cv-upload"
                    class="secondary-btn"
                >
                    {{ __('common.review_cv') }}
                </a>


            </div>

        </div>



        <div class="hero-visual">

            <div class="hero-logo-card">

                <img
                    src="/images/jisr-logo.jpeg"
                    alt="Jisr AI"
                >

            </div>

        </div>


    </section>



    <!-- ======================================
         STATS
    ====================================== -->

    <section class="stats">


        <div class="stat">

            <div class="stat-label">
                {{ __('common.job_matches') }}
            </div>

            <div class="stat-value" id="jobMatchesCount">
                —
            </div>

        </div>



        <div class="stat">

            <div class="stat-label">
                {{ __('common.applications') }}
            </div>

            <div class="stat-value" id="applicationsCount">
                —
            </div>

        </div>



        <div class="stat">

            <div class="stat-label">
                {{ __('common.cv_status') }}
            </div>

            <div class="stat-value" id="cvStatus">

                —

                <small>
                    {{ __('common.profile_label') }}
                </small>

            </div>

        </div>



        <div class="stat">

            <div class="stat-label">
                {{ __('common.career_path_status') }}
            </div>

            <div class="stat-value">

                {{ __('common.building') }}

                <small>
                    {{ __('common.phase') }}
                </small>

            </div>

        </div>


    </section>




    <!-- ======================================
         LIVE JOB MATCHES
    ====================================== -->

    <section class="matches-section">

        <div class="section-heading">

            <div>
                <small>
                    {{ __('common.job_matching_engine') }}
                </small>

                <h2>
                    {{ __('common.top_job_matches') }}
                </h2>
            </div>

            <div class="matches-actions">
                <button
                    type="button"
                    class="refresh-btn"
                    id="refreshJobMatchesBtn"
                    onclick="refreshJobMatches()"
                >
                    {{ __('common.refresh_job_matches') }}
                </button>
            </div>

        </div>

        <p style="font-size:13px;line-height:1.7;color:#7A8792;margin-top:-10px;margin-bottom:20px;">
            {{ __('common.top_job_matches_note') }}
        </p>

        <div
            id="dashboardMessage"
            class="dashboard-message"
        ></div>

        <div
            id="jobMatchesContainer"
            class="job-matches-grid"
        >
            <div class="loading-state">
                {{ __('common.loading_match_analysis') }}
            </div>
        </div>

    </section>

    <!-- ======================================
         CAREER JOURNEY
    ====================================== -->

    <div class="section-heading">


        <div>

            <small>
                {{ __('common.your_journey') }}
            </small>

            <h2>
                {{ __('common.journey_title') }}
            </h2>

        </div>


        <p>
            {{ __('common.journey_description') }}
        </p>


    </div>



    <section class="journey-grid">


        <!-- DISCOVER -->

        <article class="journey-card">

            <div class="icon-box">

                <svg viewBox="0 0 24 24">

                    <circle
                        cx="11"
                        cy="11"
                        r="7"
                    />

                    <path
                        d="M20 20l-3.5-3.5"
                    />

                </svg>

            </div>


            <h3>
                {{ __('common.discover_jobs') }}
            </h3>


            <p>
                {{ __('common.discover_jobs_description') }}
            </p>

        </article>



        <!-- MATCH -->

        <article class="journey-card">

            <div class="icon-box">

                <svg viewBox="0 0 24 24">

                    <path
                        d="M12 3v18M3 12h18"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="8"
                    />

                </svg>

            </div>


            <h3>
                {{ __('common.job_matching') }}
            </h3>


            <p>
                {{ __('common.job_matching_description') }}
            </p>

        </article>



        <!-- GAP -->

        <article class="journey-card">

            <div class="icon-box">

                <svg viewBox="0 0 24 24">

                    <path d="M4 19V9" />
                    <path d="M10 19V5" />
                    <path d="M16 19v-7" />
                    <path d="M22 19V3" />

                </svg>

            </div>


            <h3>
                {{ __('common.skill_gap') }}
            </h3>


            <p>
                {{ __('common.skill_gap_description') }}
            </p>

        </article>



        <!-- TRACK -->

        <article class="journey-card">

            <div class="icon-box">

                <svg viewBox="0 0 24 24">

                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="15"
                        rx="2"
                    />

                    <path
                        d="M8 3v4M16 3v4M3 10h18"
                    />

                </svg>

            </div>


            <h3>
                {{ __('common.track_applications') }}
            </h3>


            <p>
                {{ __('common.track_applications_description') }}
            </p>

        </article>


    </section>



    <!-- ======================================
         DEVELOPMENT
    ====================================== -->

    <section class="coming-card">


        <div>

            <h3>
                {{ __('common.career_development_title') }}
            </h3>


            <p>
                {{ __('common.career_development_description') }}
            </p>

        </div>



        <div class="development-status">

            <small>
                {{ __('common.career_module') }}
            </small>


            <strong>

                <span class="status-dot"></span>

                {{ __('common.in_development') }}

            </strong>

        </div>


    </section>



    <!-- ======================================
         BRAND MESSAGE
    ====================================== -->

    <section class="brand-message">


        <h3>
            {{ __('common.more_opportunities') }}
        </h3>


        <span>
            JISR AI · A BRIGHTER TOMORROW
        </span>


    </section>


</main>



<script>

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    const token =
        localStorage.getItem(
            'auth_token'
        );


    if (!token) {

        window.location.href =
            '/login';

    }




    /*
    |--------------------------------------------------------------------------
    | Career Matching API
    |--------------------------------------------------------------------------
    */

    const translations = {
        matchScore: @json(__('common.match_score')),
        location: @json(__('common.location')),
        employmentType: @json(__('common.employment_type')),
        workMode: @json(__('common.work_mode')),
        deadline: @json(__('common.deadline')),
        notSpecified: @json(__('common.not_specified')),
        matchedRequirements: @json(__('common.matched_requirements')),
        missingRequirements: @json(__('common.missing_requirements')),
        totalRequirements: @json(__('common.total_requirements')),
        gaps: @json(__('common.gaps')),
        mandatory: @json(__('common.mandatory')),
        optional: @json(__('common.optional')),
        viewAnalysis: @json(__('common.view_match_analysis')),
        hideAnalysis: @json(__('common.hide_match_analysis')),
        loadingAnalysis: @json(__('common.loading_match_analysis')),
        noSkillGaps: @json(__('common.no_skill_gaps')),
        noJobMatches: @json(__('common.no_job_matches')),
        noJobMatchesNote: @json(__('common.no_job_matches_note')),
        connected: @json(__('common.connected')),
        cvNotConnected: @json(__('common.cv_not_connected')),
        generating: @json(__('common.generating_job_matches')),
        updated: @json(__('common.job_matches_updated')),
        updateFailed: @json(__('common.job_matches_failed')),
        loadFailed: @json(__('common.job_dashboard_load_failed')),
        saveJob: document.documentElement.lang === 'ar' ? 'حفظ الوظيفة' : 'Save Job',
        saved: document.documentElement.lang === 'ar' ? 'محفوظة' : 'Saved',
        markApplied: document.documentElement.lang === 'ar' ? 'تم التقديم' : 'Mark as Applied',
        applied: document.documentElement.lang === 'ar' ? 'تم التقديم' : 'Applied',
        interview: document.documentElement.lang === 'ar' ? 'مقابلة' : 'Interview',
        accepted: document.documentElement.lang === 'ar' ? 'مقبول' : 'Accepted',
        rejected: document.documentElement.lang === 'ar' ? 'مرفوض' : 'Rejected',
        remove: document.documentElement.lang === 'ar' ? 'إزالة' : 'Remove',
        applicationSaved: document.documentElement.lang === 'ar' ? 'تم حفظ الوظيفة' : 'Job saved successfully',
        applicationUpdated: document.documentElement.lang === 'ar' ? 'تم تحديث حالة الطلب' : 'Application status updated',
        applicationRemoved: document.documentElement.lang === 'ar' ? 'تمت إزالة الوظيفة من طلباتك' : 'Job removed',
        applicationFailed: document.documentElement.lang === 'ar' ? 'تعذر تحديث طلب الوظيفة' : 'Job application could not be updated'
    };

    let jobApplicationsByJobId = new Map();


    function escapeHtml(value) {

        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');

    }


    function displayValue(value) {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {
            return escapeHtml(
                translations.notSpecified
            );
        }

        return escapeHtml(value);

    }


    function formatDeadline(value) {

        if (!value) {
            return escapeHtml(
                translations.notSpecified
            );
        }

        const date =
            new Date(value);

        if (
            Number.isNaN(
                date.getTime()
            )
        ) {
            return escapeHtml(value);
        }

        return new Intl.DateTimeFormat(
            document.documentElement.lang === 'ar'
                ? 'ar'
                : 'en',
            {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }
        ).format(date);

    }


    function showMessage(
        message,
        type
    ) {

        const box =
            document.getElementById(
                'dashboardMessage'
            );

        box.textContent =
            message;

        box.className =
            `dashboard-message ${type}`;

        window.setTimeout(
            () => {

                box.className =
                    'dashboard-message';

                box.textContent =
                    '';

            },
            4500
        );

    }


    async function apiRequest(
        url,
        options = {}
    ) {

        const response =
            await fetch(
                url,
                {
                    ...options,

                    headers: {

                        'Authorization':
                            `Bearer ${token}`,

                        'Accept':
                            'application/json',

                        ...(options.headers || {})

                    }

                }
            );


        if (
            response.status === 401
        ) {

            localStorage.removeItem(
                'auth_token'
            );

            localStorage.removeItem(
                'auth_user'
            );

            window.location.href =
                '/login';

            throw new Error(
                'Unauthenticated'
            );

        }


        let data = null;


        try {

            data =
                await response.json();

        }

        catch (error) {

            data = null;

        }


        if (!response.ok) {

            throw new Error(
                data?.message ||
                `Request failed with status ${response.status}`
            );

        }


        return data;

    }



    async function loadJobApplications() {
        try {
            const data = await apiRequest('/api/job-applications');
            const applications = Array.isArray(data.applications) ? data.applications : [];
            jobApplicationsByJobId = new Map(applications.map(a => [Number(a.job_id), a]));
            document.getElementById('applicationsCount').textContent = data.count ?? applications.length;
        } catch (error) {
            console.error(error);
            document.getElementById('applicationsCount').textContent = '—';
        }
    }

    function applicationStatusLabel(status) {
        return translations[status] || status || translations.saved;
    }

    function renderApplicationControls(jobId) {
        const application = jobApplicationsByJobId.get(Number(jobId));
        if (!application) {
            return `<button type="button" class="save-job-btn" onclick="saveJob(${Number(jobId)})">${escapeHtml(translations.saveJob)}</button>`;
        }

        const id = Number(application.job_application_id);
        const status = String(application.status || 'saved');

        return `
            <span class="application-state">${escapeHtml(applicationStatusLabel(status))}</span>
            ${status === 'saved'
                ? `<button type="button" class="apply-job-btn" onclick="updateApplicationStatus(${id}, 'applied')">${escapeHtml(translations.markApplied)}</button>`
                : `<select class="status-select" onchange="updateApplicationStatus(${id}, this.value)">
                    ${['applied','interview','accepted','rejected'].map(option =>
                        `<option value="${option}" ${status === option ? 'selected' : ''}>${escapeHtml(applicationStatusLabel(option))}</option>`
                    ).join('')}
                   </select>`
            }
            <button type="button" class="remove-job-btn" onclick="removeJobApplication(${id})">${escapeHtml(translations.remove)}</button>
        `;
    }

    async function saveJob(jobId) {
        try {
            await apiRequest('/api/job-applications', {
                method: 'POST',
                headers: {'Content-Type':'application/json'},
                body: JSON.stringify({job_id:Number(jobId)})
            });
            await refreshApplicationUi();
            showMessage(translations.applicationSaved, 'success');
        } catch (error) {
            console.error(error);
            showMessage(translations.applicationFailed, 'error');
        }
    }

    async function updateApplicationStatus(applicationId, status) {
        try {
            await apiRequest(`/api/job-applications/${Number(applicationId)}/status`, {
                method:'PATCH',
                headers:{'Content-Type':'application/json'},
                body:JSON.stringify({status})
            });
            await refreshApplicationUi();
            showMessage(translations.applicationUpdated, 'success');
        } catch (error) {
            console.error(error);
            showMessage(translations.applicationFailed, 'error');
            await refreshApplicationUi();
        }
    }

    async function removeJobApplication(applicationId) {
        try {
            await apiRequest(`/api/job-applications/${Number(applicationId)}`, {method:'DELETE'});
            await refreshApplicationUi();
            showMessage(translations.applicationRemoved, 'success');
        } catch (error) {
            console.error(error);
            showMessage(translations.applicationFailed, 'error');
        }
    }

    async function refreshApplicationUi() {
        await loadJobApplications();
        document.querySelectorAll('[data-job-application-actions]').forEach(container => {
            const jobId = Number(container.dataset.jobApplicationActions);
            container.innerHTML = renderApplicationControls(jobId);
        });
    }


    async function loadJobMatches() {

        const container =
            document.getElementById(
                'jobMatchesContainer'
            );


        try {

            const data =
                await apiRequest(
                    '/api/job-recommendations'
                );


            const recommendations =
                Array.isArray(
                    data.recommendations
                )
                    ? data.recommendations
                    : [];


            document.getElementById(
                'jobMatchesCount'
            ).textContent =
                data.count ??
                recommendations.length;


            updateCvStatus(
                recommendations
            );


            renderJobMatches(
                recommendations
            );

        }

        catch (error) {

            console.error(error);


            document.getElementById(
                'jobMatchesCount'
            ).textContent =
                '—';


            container.innerHTML = `
                <div class="empty-state">
                    <h3>
                        ${escapeHtml(
                            translations.loadFailed
                        )}
                    </h3>
                </div>
            `;


            showMessage(
                translations.loadFailed,
                'error'
            );

        }

    }


    function updateCvStatus(
        recommendations
    ) {

        const cvStatus =
            document.getElementById(
                'cvStatus'
            );


        const connected =
            recommendations.some(
                recommendation =>
                    recommendation.cv_id !== null &&
                    recommendation.cv_id !== undefined
            );


        cvStatus.innerHTML = `
            ${
                escapeHtml(
                    connected
                        ? translations.connected
                        : translations.cvNotConnected
                )
            }

            <small>
                {{ __('common.profile_label') }}
            </small>
        `;

    }


    function renderJobMatches(
        recommendations
    ) {

        const container =
            document.getElementById(
                'jobMatchesContainer'
            );


        if (
            !recommendations.length
        ) {

            container.innerHTML = `
                <div class="empty-state">

                    <h3>
                        ${escapeHtml(
                            translations.noJobMatches
                        )}
                    </h3>

                    <p>
                        ${escapeHtml(
                            translations.noJobMatchesNote
                        )}
                    </p>

                </div>
            `;

            return;

        }


        container.innerHTML =
            recommendations
                .map(
                    recommendation => {

                        const job =
                            recommendation.job || {};

                        const recommendationId =
                            Number(
                                recommendation.job_recommendation_id
                            );

                        const jobId =
                            Number(
                                job.job_id
                            );

                        const score =
                            Number(
                                recommendation.match_score || 0
                            );


                        const location =
                            [
                                job.city,
                                job.country
                            ]
                                .filter(Boolean)
                                .join(', ');


                        return `
                            <article class="job-card">

                                <div class="job-card-top">

                                    <div>

                                        <h3>
                                            ${displayValue(
                                                job.title
                                            )}
                                        </h3>

                                        <div class="company-name">
                                            ${displayValue(
                                                job.company_name
                                            )}
                                        </div>

                                    </div>


                                    <div class="match-badge">

                                        ${score.toFixed(0)}%

                                        <small>
                                            ${escapeHtml(
                                                translations.matchScore
                                            )}
                                        </small>

                                    </div>

                                </div>


                                <div class="job-meta">

                                    <span class="meta-pill">
                                        ${escapeHtml(
                                            translations.location
                                        )}:
                                        ${displayValue(location)}
                                    </span>

                                    <span class="meta-pill">
                                        ${escapeHtml(
                                            translations.employmentType
                                        )}:
                                        ${displayValue(
                                            job.employment_type
                                        )}
                                    </span>

                                    <span class="meta-pill">
                                        ${escapeHtml(
                                            translations.workMode
                                        )}:
                                        ${displayValue(
                                            job.work_mode
                                        )}
                                    </span>

                                    <span class="meta-pill">
                                        ${escapeHtml(
                                            translations.deadline
                                        )}:
                                        ${formatDeadline(
                                            job.application_deadline
                                        )}
                                    </span>

                                </div>


                                ${
                                    job.description
                                        ? `
                                            <p class="job-description">
                                                ${escapeHtml(
                                                    job.description
                                                )}
                                            </p>
                                        `
                                        : ''
                                }


                                <button
                                    type="button"
                                    class="why-btn"
                                    id="analysisButton-${recommendationId}"
                                    onclick="toggleGapAnalysis(${recommendationId})"
                                >
                                    ${escapeHtml(
                                        translations.viewAnalysis
                                    )}
                                </button>

                                <div
                                    class="job-actions"
                                    data-job-application-actions="${jobId}"
                                >
                                    ${renderApplicationControls(jobId)}
                                </div>


                                <div
                                    class="analysis-panel"
                                    id="analysis-${recommendationId}"
                                ></div>

                            </article>
                        `;

                    }
                )
                .join('');

    }


    async function toggleGapAnalysis(
        recommendationId
    ) {

        const panel =
            document.getElementById(
                `analysis-${recommendationId}`
            );

        const button =
            document.getElementById(
                `analysisButton-${recommendationId}`
            );


        if (
            !panel ||
            !button
        ) {
            return;
        }


        if (
            panel.classList.contains(
                'open'
            )
        ) {

            panel.classList.remove(
                'open'
            );

            button.textContent =
                translations.viewAnalysis;

            return;

        }


        if (
            panel.dataset.loaded ===
            'true'
        ) {

            panel.classList.add(
                'open'
            );

            button.textContent =
                translations.hideAnalysis;

            return;

        }


        panel.classList.add(
            'open'
        );


        panel.innerHTML = `
            <div class="loading-state">
                ${escapeHtml(
                    translations.loadingAnalysis
                )}
            </div>
        `;


        button.disabled =
            true;


        try {

            const data =
                await apiRequest(
                    `/api/job-recommendations/${recommendationId}/gap-analysis`
                );


            renderGapAnalysis(
                panel,
                data
            );


            panel.dataset.loaded =
                'true';


            button.textContent =
                translations.hideAnalysis;

        }

        catch (error) {

            console.error(error);


            panel.innerHTML = `
                <div class="empty-state">

                    <h3>
                        ${escapeHtml(
                            translations.loadFailed
                        )}
                    </h3>

                </div>
            `;

        }

        finally {

            button.disabled =
                false;

        }

    }


    function renderGapAnalysis(
        panel,
        data
    ) {

        const summary =
            data.summary || {};


        const matched =
            Array.isArray(
                data.matched_requirements
            )
                ? data.matched_requirements
                : [];


        const gaps =
            Array.isArray(
                data.gaps
            )
                ? data.gaps
                : [];


        panel.innerHTML = `

            <div class="analysis-summary">

                <div class="analysis-stat">

                    <strong>
                        ${Number(
                            summary.total_requirements || 0
                        )}
                    </strong>

                    <span>
                        ${escapeHtml(
                            translations.totalRequirements
                        )}
                    </span>

                </div>


                <div class="analysis-stat">

                    <strong>
                        ${Number(
                            summary.matched_requirements || 0
                        )}
                    </strong>

                    <span>
                        ${escapeHtml(
                            translations.matchedRequirements
                        )}
                    </span>

                </div>


                <div class="analysis-stat">

                    <strong>
                        ${Number(
                            summary.gaps || 0
                        )}
                    </strong>

                    <span>
                        ${escapeHtml(
                            translations.gaps
                        )}
                    </span>

                </div>

            </div>


            <div class="requirement-block">

                <h4>
                    ${escapeHtml(
                        translations.matchedRequirements
                    )}
                </h4>

                <div class="requirement-list">

                    ${
                        matched.length
                            ? matched
                                .map(
                                    item =>
                                        requirementPill(
                                            item,
                                            'matched'
                                        )
                                )
                                .join('')
                            : '<span class="meta-pill">—</span>'
                    }

                </div>

            </div>


            <div class="requirement-block">

                <h4>
                    ${escapeHtml(
                        translations.missingRequirements
                    )}
                </h4>

                <div class="requirement-list">

                    ${
                        gaps.length
                            ? gaps
                                .map(
                                    item =>
                                        requirementPill(
                                            item,
                                            'gap'
                                        )
                                )
                                .join('')
                            : `
                                <span class="meta-pill">
                                    ${escapeHtml(
                                        translations.noSkillGaps
                                    )}
                                </span>
                            `
                    }

                </div>

            </div>
        `;

    }


    function requirementPill(
        item,
        state
    ) {

        const requirementType =
            item.type
                ? String(
                    item.type
                ).replaceAll(
                    '_',
                    ' '
                )
                : '';


        const requirementStatus =
            item.mandatory
                ? translations.mandatory
                : translations.optional;


        return `
            <span class="requirement-pill ${state}">

                ${escapeHtml(
                    item.value
                )}

                ${
                    requirementType
                        ? ` · ${escapeHtml(
                            requirementType
                        )}`
                        : ''
                }

                · ${escapeHtml(
                    requirementStatus
                )}

            </span>
        `;

    }


    async function refreshJobMatches() {

        const button =
            document.getElementById(
                'refreshJobMatchesBtn'
            );


        button.disabled =
            true;

        button.textContent =
            translations.generating;


        try {

            const data =
                await apiRequest(
                    '/api/job-recommendations/generate',
                    {
                        method: 'POST'
                    }
                );


            const recommendations =
                Array.isArray(
                    data.recommendations
                )
                    ? data.recommendations
                    : [];


            document.getElementById(
                'jobMatchesCount'
            ).textContent =
                data.count ??
                recommendations.length;


            updateCvStatus(
                recommendations
            );


            renderJobMatches(
                recommendations
            );


            showMessage(
                translations.updated,
                'success'
            );

        }

        catch (error) {

            console.error(error);


            showMessage(
                translations.updateFailed,
                'error'
            );

        }

        finally {

            button.disabled =
                false;

            button.textContent =
                @json(
                    __('common.refresh_job_matches')
                );

        }

    }


    async function initializeCareerDashboard() {
        await loadJobApplications();
        await loadJobMatches();
    }

    initializeCareerDashboard();


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    async function logout() {

        try {

            await fetch(
                '/api/logout',
                {

                    method:
                        'POST',

                    headers: {

                        'Authorization':
                            `Bearer ${token}`,

                        'Accept':
                            'application/json'

                    }

                }
            );

        }

        catch (error) {

            console.error(
                error
            );

        }


        localStorage.removeItem(
            'auth_token'
        );

        localStorage.removeItem(
            'auth_user'
        );


        window.location.href =
            '/login';

    }

</script>


</body>

</html>

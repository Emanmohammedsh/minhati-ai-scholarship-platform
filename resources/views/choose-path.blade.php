<!DOCTYPE html>
<html
    lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}"
>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jisr AI | {{ __('common.choose_path_title') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --navy: #0A2E6B;
            --navy-dark: #061E48;
            --cyan: #00C6FF;
            --light-cyan: #87DFFF;
            --background: #F7FCFF;
            --light-blue: #EAF6FF;
            --white: #FFFFFF;
            --heading: #071D45;
            --text: #4B5563;
            --muted: #7B8794;
            --border: #DCEEF8;
            --shadow: 0 20px 60px rgba(10,46,107,.10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;

            font-family:
                {{ app()->getLocale() === 'ar' ? 'Arial, sans-serif' : '"Poppins", Arial, sans-serif' }};
            color: var(--text);

            background:
                radial-gradient(
                    circle at 92% 8%,
                    rgba(0,198,255,.14),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 5% 92%,
                    rgba(135,223,255,.20),
                    transparent 30%
                ),
                var(--background);
        }

        a {
            text-decoration: none;
        }

        /* ==========================
           TOP BAR
        ========================== */

        .topbar {
            width: 100%;
            padding: 18px clamp(22px, 5vw, 72px);

            display: flex;
            justify-content: space-between;
            align-items: center;

            background: rgba(255,255,255,.88);
            backdrop-filter: blur(15px);

            border-bottom: 1px solid rgba(10,46,107,.08);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .brand img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            border-radius: 13px;
        }

        .brand-info {
            line-height: 1.25;
        }

        .brand-info strong {
            display: block;

            font-family: "Poppins", sans-serif;
            font-size: 18px;

            color: var(--navy);
        }

        .brand-info span {
            font-family: "Poppins", sans-serif;
            font-size: 11px;
            color: var(--muted);
        }

        /* ==========================
           TOP ACTIONS
        ========================== */

        .top-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .language-switcher {
            display: flex;
            align-items: center;
            gap: 7px;

            direction: ltr;

            background: var(--light-blue);
            padding: 7px 12px;

            border: 1px solid rgba(10,46,107,.06);
            border-radius: 10px;

            font-family: "Poppins", sans-serif;
            font-size: 12px;
            font-weight: 600;
        }

        .language-switcher a {
            color: var(--muted);
            transition: .2s;
        }

        .language-switcher a:hover {
            color: var(--cyan);
        }

        .language-switcher a.active {
            color: var(--navy);
            font-weight: 700;
        }

        .language-switcher span {
            color: #BCD2DF;
        }

        .logout-btn {
            border: 0;
            background: transparent;

            font-family: inherit;
            font-size: 13px;

            color: var(--muted);

            cursor: pointer;

            padding: 10px 15px;
            border-radius: 10px;

            transition: .2s;
        }

        .logout-btn:hover {
            background: var(--light-blue);
            color: var(--navy);
        }

        /* ==========================
           PAGE
        ========================== */

        .page {
            width: min(1180px, calc(100% - 40px));
            margin: 0 auto;
            padding: 55px 0 65px;
        }

        /* ==========================
           HERO
        ========================== */

        .intro {
            text-align: center;
            max-width: 760px;
            margin: 0 auto 42px;
        }

        .intro-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            direction: ltr;

            background: var(--light-blue);
            color: var(--navy);

            padding: 8px 15px;
            border-radius: 999px;

            font-family: "Poppins", sans-serif;
            font-size: 12px;
            font-weight: 700;

            margin-bottom: 18px;
        }

        .intro-badge .dot {
            width: 8px;
            height: 8px;

            border-radius: 50%;

            background: var(--cyan);
            box-shadow: 0 0 14px rgba(0,198,255,.7);
        }

        .intro h1 {
            color: var(--heading);

            font-size: clamp(32px, 5vw, 48px);

            margin-bottom: 13px;
            line-height: 1.3;
        }

        .intro p {
            color: var(--muted);

            font-size: 15px;
            line-height: 1.9;
        }

        .user-welcome {
            margin-top: 14px;

            font-size: 13px;
            color: var(--navy);
        }

        /* ==========================
           PATH GRID
        ========================== */

        .paths {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .path-card {
            position: relative;
            overflow: hidden;

            min-height: 500px;

            background: rgba(255,255,255,.96);

            border: 1px solid var(--border);
            border-radius: 28px;

            padding: 35px;

            box-shadow: var(--shadow);

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border .3s ease;
        }

        .path-card:hover {
            transform: translateY(-8px);

            box-shadow:
                0 30px 75px rgba(10,46,107,.16);

            border-color:
                rgba(0,198,255,.40);
        }

        .path-card::after {
            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            border-radius: 50%;

            inset-inline-start: -110px;
            bottom: -130px;

            background:
                rgba(0,198,255,.06);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            margin-bottom: 26px;
        }

        .path-number {
            color: #A8B6C2;

            font-family: "Poppins", sans-serif;
            font-size: 13px;
            font-weight: 600;
        }

        .icon-box {
            width: 67px;
            height: 67px;

            border-radius: 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            background:
                linear-gradient(
                    135deg,
                    var(--light-blue),
                    #D5F4FF
                );

            color: var(--navy);
        }

        .icon-box svg {
            width: 31px;
            height: 31px;

            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
        }

        .path-label {
            display: inline-block;

            direction: ltr;

            margin-bottom: 10px;

            color: var(--cyan);

            font-family: "Poppins", sans-serif;
            font-size: 12px;
            font-weight: 700;

            letter-spacing: .5px;
        }

        .path-card h2 {
            color: var(--heading);

            font-size: 27px;

            margin-bottom: 5px;
        }

        .path-card h3 {
            color: var(--navy);

            font-size: 15px;

            margin-bottom: 17px;
        }

        .description {
            color: var(--muted);

            font-size: 13.5px;
            line-height: 1.9;

            min-height: 80px;

            margin-bottom: 23px;
        }

        /* ==========================
           FEATURES
        ========================== */

        .features {
            display: grid;
            gap: 12px;

            margin-bottom: 30px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 11px;

            font-size: 13px;
            color: #53616D;
        }

        .check {
            flex: 0 0 25px;

            width: 25px;
            height: 25px;

            border-radius: 8px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: var(--light-blue);
            color: var(--navy);

            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: bold;
        }

        /* ==========================
           BUTTONS
        ========================== */

        .path-btn {
            position: relative;
            z-index: 2;

            width: 100%;
            min-height: 54px;

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;

            border-radius: 14px;

            font-size: 14px;
            font-weight: 700;

            transition: .25s;

            background:
                linear-gradient(
                    135deg,
                    var(--navy),
                    #0B5495
                );

            color: white;

            box-shadow:
                0 12px 28px rgba(10,46,107,.16);
        }

        .career .path-btn {
            background:
                linear-gradient(
                    135deg,
                    #009BD8,
                    var(--cyan)
                );

            box-shadow:
                0 12px 28px rgba(0,198,255,.20);
        }

        .path-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 17px 35px rgba(10,46,107,.23);
        }

        .arrow {
            direction: ltr;
            display: inline-block;
        }

        /* ==========================
           BOTTOM MESSAGE
        ========================== */

        .bottom-message {
            margin-top: 35px;

            background:
                linear-gradient(
                    120deg,
                    var(--navy-dark),
                    var(--navy)
                );

            color: white;

            border-radius: 22px;

            padding: 25px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;
        }

        .bottom-message strong {
            display: block;

            font-size: 17px;

            margin-bottom: 5px;
        }

        .bottom-message p {
            color: #C9E4F5;

            font-size: 12px;
            line-height: 1.7;
        }

        .bottom-tag {
            direction: ltr;

            font-family: "Poppins", sans-serif;

            color: var(--light-cyan);

            white-space: nowrap;

            font-size: 12px;
            letter-spacing: 1px;
        }

        /* ==========================
           ENGLISH
        ========================== */

        html[dir="ltr"] .feature {
            text-align: left;
        }

        html[dir="ltr"] .path-card {
            text-align: left;
        }

        html[dir="rtl"] .path-card {
            text-align: right;
        }

        /* ==========================
           RESPONSIVE
        ========================== */

        @media(max-width: 800px) {

            .paths {
                grid-template-columns: 1fr;
            }

            .path-card {
                min-height: auto;
            }

            .description {
                min-height: auto;
            }

            .bottom-message {
                flex-direction: column;
                text-align: center;
            }
        }

        @media(max-width: 550px) {

            .topbar {
                padding: 14px 18px;
            }

            .brand-info span {
                display: none;
            }

            .top-actions {
                gap: 5px;
            }

            .language-switcher {
                padding: 6px 9px;
            }

            .logout-btn {
                padding: 8px;
                font-size: 11px;
            }

            .page {
                width: calc(100% - 26px);
                padding-top: 35px;
            }

            .path-card {
                padding: 27px 23px;
                border-radius: 22px;
            }
        }

    </style>
</head>


<body>


<header class="topbar">

    <!-- BRAND -->

    <div class="brand">

        <img
            src="/images/jisr-logo.jpeg"
            alt="Jisr AI Logo"
        >

        <div class="brand-info">

            <strong>
                Jisr AI
            </strong>

            <span>
                FROM EDUCATION TO EMPLOYMENT
            </span>

        </div>

    </div>


    <!-- ACTIONS -->

    <div class="top-actions">

        <div class="language-switcher">

            <a
                href="{{ route('language.switch', 'ar') }}"
                class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}"
            >
                AR
            </a>

            <span>|</span>

            <a
                href="{{ route('language.switch', 'en') }}"
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

    </div>

</header>



<main class="page">


    <!-- ==========================
         INTRO
    ========================== -->

    <section class="intro">

        <div class="intro-badge">

            <span class="dot"></span>

            Jisr AI · Your Opportunity Journey

        </div>


        <h1>
            {{ __('common.choose_path_heading') }}
        </h1>


        <p>
            {{ __('common.choose_path_description') }}
        </p>


        <div
            class="user-welcome"
            id="userWelcome"
        >
            {{ __('common.welcome') }}
        </div>

    </section>



    <!-- ==========================
         PATHS
    ========================== -->

    <section class="paths">


        <!-- ==========================
             EDUCATION PATH
        ========================== -->

        <article class="path-card education">


            <div class="card-top">

                <div class="icon-box">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="M3 9l9-5 9 5-9 5-9-5z"
                        />

                        <path
                            d="M7 12v5c3 2 7 2 10 0v-5"
                        />

                    </svg>

                </div>


                <div class="path-number">
                    01
                </div>

            </div>


            <span class="path-label">
                EDUCATION PATH
            </span>


            <h2>
                {{ __('common.education_path') }}
            </h2>


            <h3>
                {{ __('common.education_heading') }}
            </h3>


            <p class="description">
                {{ __('common.education_description') }}
            </p>


            <div class="features">

                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.scholarship_matching') }}

                </div>


                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.match_explanation') }}

                </div>


                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.gap_analysis') }}

                </div>


                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.application_tracking') }}

                </div>

            </div>


            <a
                href="/dashboard"
                class="path-btn"
            >

                {{ __('common.start_education') }}

                <span class="arrow">
                    →
                </span>

            </a>

        </article>



        <!-- ==========================
             CAREER PATH
        ========================== -->

        <article class="path-card career">


            <div class="card-top">

                <div class="icon-box">

                    <svg viewBox="0 0 24 24">

                        <rect
                            x="3"
                            y="7"
                            width="18"
                            height="13"
                            rx="2"
                        />

                        <path
                            d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                        />

                        <path
                            d="M3 12h18"
                        />

                    </svg>

                </div>


                <div class="path-number">
                    02
                </div>

            </div>


            <span class="path-label">
                CAREER PATH
            </span>


            <h2>
                {{ __('common.career_path') }}
            </h2>


            <h3>
                {{ __('common.career_heading') }}
            </h3>


            <p class="description">
                {{ __('common.career_description') }}
            </p>


            <div class="features">

                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.job_matching_profile') }}

                </div>


                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.ai_job_matching') }}

                </div>


                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.skill_gap_analysis') }}

                </div>


                <div class="feature">

                    <span class="check">
                        ✓
                    </span>

                    {{ __('common.job_application_tracking') }}

                </div>

            </div>


            <a
                href="/jobs/dashboard"
                class="path-btn"
            >

                {{ __('common.start_career') }}

                <span class="arrow">
                    →
                </span>

            </a>

        </article>


    </section>



    <!-- ==========================
         BOTTOM MESSAGE
    ========================== -->

    <section class="bottom-message">

        <div>

            <strong>
                {{ __('common.one_bridge_more_opportunities') }}
            </strong>

            <p>
                {{ __('common.brand_message') }}
            </p>

        </div>


        <div class="bottom-tag">
            JISR AI · A BRIGHTER TOMORROW
        </div>

    </section>


</main>



<script>

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    const token =
        localStorage.getItem('auth_token');


    if (!token) {

        window.location.href = '/login';

    }


    /*
    |--------------------------------------------------------------------------
    | User Information
    |--------------------------------------------------------------------------
    */

    const storedUser =
        localStorage.getItem('auth_user');


    if (storedUser) {

        try {

            const user =
                JSON.parse(storedUser);


            if (
                user &&
                user.full_name
            ) {

                const welcomeTemplate =
                    @json(__('common.welcome_user', [
                        'name' => '__USER_NAME__'
                    ]));


                document.getElementById(
                    'userWelcome'
                ).textContent =
                    welcomeTemplate.replace(
                        '__USER_NAME__',
                        user.full_name
                    );

            }

        } catch (error) {

            console.error(
                'Could not read user information.',
                error
            );

        }

    }


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
                    method: 'POST',

                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                }
            );

        } catch (error) {

            console.error(error);

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

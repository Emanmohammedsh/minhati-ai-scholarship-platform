<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jisr AI | {{ __('common.choose_path_title') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Tajawal:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --navy: #0A2E6B;
            --blue: #0877F9;
            --cyan: #00C6FF;

            --bg: #F7FBFF;
            --surface: #FFFFFF;
            --soft: #EAF6FF;

            --text: #102A43;
            --muted: #64748B;
            --border: #DCEAF5;

            --shadow:
                0 18px 50px
                rgba(15, 61, 96, .08);
        }

        body {
            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 50% -10%,
                    rgba(0, 198, 255, .10),
                    transparent 30%
                ),
                var(--bg);

            color: var(--text);

            font-family:
                'Poppins',
                sans-serif;

            transition:
                background .2s,
                color .2s;
        }

        html[dir="rtl"] body {
            font-family:
                'Tajawal',
                sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            font: inherit;
        }


        /* =========================
           DARK MODE
        ========================= */

        body.theme-dark {
            --bg: #071A2D;
            --surface: #0C233B;
            --soft: #102D49;

            --text: #F4FAFF;
            --muted: #A8BED0;
            --border: #183B58;

            --shadow:
                0 18px 50px
                rgba(0, 0, 0, .18);

            background:
                radial-gradient(
                    circle at 50% -10%,
                    rgba(0, 198, 255, .10),
                    transparent 30%
                ),
                var(--bg);
        }


        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            height: 78px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding:
                0
                clamp(24px, 6vw, 86px);

            background:
                rgba(255, 255, 255, .88);

            border-bottom:
                1px solid
                rgba(220, 234, 245, .8);

            backdrop-filter: blur(15px);

            position: relative;
            z-index: 20;
        }

        .theme-dark .navbar {
            background:
                rgba(7, 26, 45, .90);

            border-color:
                var(--border);
        }

        .brand {
            display: flex;
            align-items: center;
        }


        /* =========================
           LOGO
        ========================= */

        .logo-box {
            display: flex;
            align-items: center;

            padding: 4px 8px;

            border-radius: 12px;

            background: transparent;
        }

        .logo {
            width: 116px;
            height: 46px;

            object-fit: contain;
        }

        .logo-dark {
            display: none;
        }

        .theme-dark .logo-light {
            display: none;
        }

        .theme-dark .logo-dark {
            display: block;
        }


        /* =========================
           TOP ACTIONS
        ========================= */

        .actions {
            display: flex;
            align-items: center;

            gap: 10px;
        }

        .languages {
            display: flex;
            align-items: center;

            gap: 5px;

            padding: 6px;

            background: var(--soft);

            border-radius: 10px;
        }

        .languages a {
            min-width: 34px;

            padding:
                5px
                7px;

            border-radius: 7px;

            text-align: center;

            color: var(--muted);

            font-size: .68rem;
            font-weight: 800;
        }

        .languages a.active {
            background: var(--surface);

            color: var(--blue);

            box-shadow:
                0 3px 10px
                rgba(10, 46, 107, .06);
        }

        .icon-btn {
            width: 38px;
            height: 38px;

            display: flex;
            align-items: center;
            justify-content: center;

            border:
                1px solid
                var(--border);

            border-radius: 10px;

            background: var(--surface);

            cursor: pointer;

            color: var(--navy);

            font-size: 16px;
        }

        .theme-dark .icon-btn {
            color: white;
        }

        .logout-btn {
            height: 38px;

            padding:
                0
                14px;

            border:
                1px solid
                var(--border);

            border-radius: 10px;

            background: var(--surface);

            color: var(--muted);

            cursor: pointer;

            font-size: .72rem;
            font-weight: 700;

            transition: .18s;
        }

        .logout-btn:hover {
            border-color: #FCA5A5;
            color: #DC2626;
        }


        /* =========================
           PAGE
        ========================= */

        .page {
            width:
                min(
                    1080px,
                    calc(100% - 40px)
                );

            margin:
                0
                auto;

            padding:
                65px
                0
                60px;
        }


        /* =========================
           INTRO
        ========================= */

        .intro {
            max-width: 700px;

            margin:
                0
                auto
                40px;

            text-align: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 15px;

            padding:
                7px
                12px;

            border:
                1px solid
                #CBE9FA;

            border-radius: 999px;

            background: var(--soft);

            color: var(--blue);

            font-size: .7rem;
            font-weight: 800;
        }

        .badge-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: var(--cyan);
        }

        .intro h1 {
            margin-bottom: 12px;

            color: var(--navy);

            font-size:
                clamp(
                    2.2rem,
                    5vw,
                    3.7rem
                );

            font-weight: 800;
            line-height: 1.08;

            letter-spacing: -.045em;
        }

        html[dir="rtl"] .intro h1 {
            letter-spacing: 0;
        }

        .theme-dark .intro h1 {
            color: #FFFFFF;
        }

        .intro-description {
            max-width: 610px;

            margin:
                0
                auto;

            color: var(--muted);

            font-size: .9rem;
            line-height: 1.8;
        }

        .user-welcome {
            margin-top: 12px;

            color: var(--blue);

            font-size: .78rem;
            font-weight: 700;
        }


        /* =========================
           PATHS
        ========================= */

        .paths {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 22px;
        }

        .path-card {
            position: relative;

            min-height: 430px;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            padding: 30px;

            border:
                1px solid
                var(--border);

            border-radius: 24px;

            background:
                var(--surface);

            box-shadow:
                var(--shadow);

            transition:
                transform .2s ease,
                border-color .2s ease,
                box-shadow .2s ease;
        }

        .path-card:hover {
            transform:
                translateY(-5px);

            border-color:
                rgba(8, 119, 249, .32);

            box-shadow:
                0 22px 55px
                rgba(15, 61, 96, .12);
        }

        .path-card::before {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            right: -75px;
            top: -75px;

            border-radius: 50%;

            background:
                rgba(0, 198, 255, .07);
        }

        html[dir="rtl"]
        .path-card::before {
            right: auto;
            left: -75px;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 24px;
        }

        .icon-box {
            width: 58px;
            height: 58px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 17px;

            background:
                linear-gradient(
                    145deg,
                    #EAF6FF,
                    #F5FCFF
                );

            color: var(--blue);
        }

        .theme-dark .icon-box {
            background: var(--soft);
        }

        .icon-box svg {
            width: 28px;
            height: 28px;

            fill: none;

            stroke: currentColor;
            stroke-width: 1.8;
        }

        .path-number {
            color: #C3D2DF;

            font-size: .72rem;
            font-weight: 800;
        }

        .path-type {
            display: inline-block;

            margin-bottom: 7px;

            color: var(--blue);

            font-size: .68rem;
            font-weight: 800;

            letter-spacing: .08em;
        }

        .path-card h2 {
            margin-bottom: 8px;

            color: var(--navy);

            font-size: 1.65rem;
            font-weight: 800;
        }

        .theme-dark
        .path-card h2 {
            color: white;
        }

        .description {
            min-height: 66px;

            margin-bottom: 22px;

            color: var(--muted);

            font-size: .82rem;
            line-height: 1.75;
        }


        /* =========================
           FEATURES
        ========================= */

        .features {
            display: grid;

            gap: 11px;

            margin-bottom: 27px;
        }

        .feature {
            display: flex;
            align-items: center;

            gap: 10px;

            color: var(--muted);

            font-size: .78rem;
            font-weight: 500;
        }

        .check {
            width: 22px;
            height: 22px;

            flex:
                0
                0
                22px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 7px;

            background: #E9FBF3;

            color: #159669;

            font-size: .67rem;
            font-weight: 900;
        }

        .theme-dark .check {
            background:
                rgba(21, 150, 105, .15);
        }


        /* =========================
           BUTTONS
        ========================= */

        .path-button {
            width: 100%;
            height: 50px;

            margin-top: auto;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 9px;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--blue),
                    var(--cyan)
                );

            color: #FFFFFF;

            font-size: .8rem;
            font-weight: 800;

            box-shadow:
                0 9px 22px
                rgba(8, 119, 249, .16);

            transition:
                transform .18s,
                box-shadow .18s;
        }

        .path-button:hover {
            transform:
                translateY(-1px);

            box-shadow:
                0 12px 28px
                rgba(8, 119, 249, .22);
        }

        .career .path-button {
            background:
                linear-gradient(
                    135deg,
                    #0A2E6B,
                    #0877F9
                );
        }


        /* =========================
           BOTTOM NOTE
        ========================= */

        .bottom-note {
            margin-top: 22px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            color: var(--muted);

            font-size: .74rem;

            text-align: center;
        }

        .bottom-note svg {
            width: 15px;
            height: 15px;

            color: var(--blue);
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media(max-width: 800px) {

            .navbar {
                padding:
                    0
                    20px;
            }

            .page {
                padding-top: 45px;
            }

            .paths {
                grid-template-columns:
                    1fr;
            }

            .path-card {
                min-height: auto;
            }
        }

        @media(max-width: 540px) {

            .navbar {
                height: 70px;
            }

            .logo {
                width: 96px;
                height: 40px;
            }

            .logout-btn {
                width: 38px;

                padding: 0;

                font-size: 0;
            }

            .logout-btn::after {
                content: "↪";

                font-size: 16px;
            }

            .languages {
                gap: 2px;

                padding: 4px;
            }

            .languages a {
                min-width: 29px;

                font-size: .62rem;
            }

            .page {
                width:
                    calc(100% - 28px);

                padding:
                    35px
                    0
                    45px;
            }

            .intro {
                margin-bottom: 28px;
            }

            .intro h1 {
                font-size: 2.1rem;
            }

            .intro-description {
                font-size: .82rem;
            }

            .path-card {
                padding: 23px;

                border-radius: 20px;
            }

            .description {
                min-height: auto;
            }
        }
    </style>
</head>


<body>

<header class="navbar">

    <a href="{{ url('/') }}"
       class="brand">

        <span class="logo-box">

            {{-- LIGHT MODE LOGO --}}
            <img
                src="{{ asset('images/brand/jisr-logo-official.png') }}"
                alt="Jisr AI | جسر"
                class="logo logo-light"
            >

            {{-- DARK MODE LOGO --}}
            <img
                src="{{ asset('images/brand/jisr-logo-dark.png') }}"
                alt="Jisr AI | جسر"
                class="logo logo-dark"
            >

        </span>

    </a>


    <div class="actions">

        {{-- LANGUAGE --}}
        <div class="languages">

            <a
                href="{{ route('language.switch', 'ar') }}"
                class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}"
            >
                AR
            </a>

            <a
                href="{{ route('language.switch', 'en') }}"
                class="{{ app()->getLocale() === 'en' ? 'active' : '' }}"
            >
                EN
            </a>

        </div>


        {{-- DARK / LIGHT --}}
        <button
            id="themeToggleBtn"
            class="icon-btn"
            type="button"
            title="Dark / Light"
        >
            🌙
        </button>


        {{-- LOGOUT --}}
        <button
            type="button"
            class="logout-btn"
            onclick="logout()"
        >
            {{ __('common.logout') }}
        </button>

    </div>

</header>


<main class="page">


    {{-- INTRO --}}
    <section class="intro">

        <div class="badge">

            <span class="badge-dot"></span>

            Jisr AI ·

            {{ app()->getLocale() === 'ar'
                ? 'رحلتك تبدأ هنا'
                : 'Your journey starts here'
            }}

        </div>


        <h1>
            {{ __('common.choose_path_heading') }}
        </h1>


        <p class="intro-description">
            {{ __('common.choose_path_description') }}
        </p>


        <div
            class="user-welcome"
            id="userWelcome"
        >
            {{ __('common.welcome') }}
        </div>

    </section>



    {{-- PATHS --}}
    <section class="paths">


        {{-- EDUCATION PATH --}}
        <article class="path-card education">

            <div class="card-header">

                <div class="icon-box">

                    <svg viewBox="0 0 24 24">

                        <path
                            d="
                                M3 9
                                l9-5
                                9 5
                                -9 5
                                -9-5z
                            "
                        />

                        <path
                            d="
                                M7 12
                                v5
                                c3 2 7 2 10 0
                                v-5
                            "
                        />

                    </svg>

                </div>


                <span class="path-number">
                    01
                </span>

            </div>


            <span class="path-type">
                EDUCATION PATH
            </span>


            <h2>
                {{ __('common.education_path') }}
            </h2>


            <p class="description">
                {{ __('common.education_description') }}
            </p>


            <div class="features">

                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.scholarship_matching') }}

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.match_explanation') }}

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.gap_analysis') }}

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.application_tracking') }}

                </div>

            </div>


            <a
                href="/dashboard"
                class="path-button"
            >

                {{ __('common.start_education') }}

                <span>
                    {{ app()->getLocale() === 'ar'
                        ? '←'
                        : '→'
                    }}
                </span>

            </a>

        </article>



        {{-- CAREER PATH --}}
        <article class="path-card career">

            <div class="card-header">

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
                            d="
                                M8 7
                                V5
                                a2 2 0 0 1 2-2
                                h4
                                a2 2 0 0 1 2 2
                                v2
                            "
                        />

                        <path d="M3 12h18"/>

                    </svg>

                </div>


                <span class="path-number">
                    02
                </span>

            </div>


            <span class="path-type">
                CAREER PATH
            </span>


            <h2>
                {{ __('common.career_path') }}
            </h2>


            <p class="description">
                {{ __('common.career_description') }}
            </p>


            <div class="features">

                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.job_matching_profile') }}

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.ai_job_matching') }}

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.skill_gap_analysis') }}

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    {{ __('common.job_application_tracking') }}

                </div>

            </div>


            <a
                href="/jobs/dashboard"
                class="path-button"
            >

                {{ __('common.start_career') }}

                <span>
                    {{ app()->getLocale() === 'ar'
                        ? '←'
                        : '→'
                    }}
                </span>

            </a>

        </article>

    </section>



    {{-- BOTTOM NOTE --}}
    <div class="bottom-note">

        <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                d="
                    M12 22
                    s8-4 8-10
                    V5
                    l-8-3
                    -8 3
                    v7
                    c0 6 8 10 8 10z
                "
            />

            <path d="M9 12l2 2 4-4"/>
        </svg>


        <span>
            {{ app()->getLocale() === 'ar'
                ? 'يمكنك التنقل بين مساري التعليم والعمل في أي وقت.'
                : 'You can move between education and career paths at any time.'
            }}
        </span>

    </div>

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

        window.location.replace(
            '/login'
        );

    }



    /*
    |--------------------------------------------------------------------------
    | User Information
    |--------------------------------------------------------------------------
    */

    const storedUser =
        localStorage.getItem(
            'auth_user'
        );


    if (storedUser) {

        try {

            const user =
                JSON.parse(
                    storedUser
                );


            if (
                user &&
                user.full_name
            ) {

                const welcomeTemplate =
                    @json(
                        __('common.welcome_user', [
                            'name' => '__USER_NAME__'
                        ])
                    );


                document
                    .getElementById(
                        'userWelcome'
                    )
                    .textContent =

                    welcomeTemplate.replace(
                        '__USER_NAME__',
                        user.full_name
                    );

            }

        }

        catch (error) {

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

                    method:
                        'POST',

                    headers: {

                        'Accept':
                            'application/json',

                        'Authorization':
                            `Bearer ${token}`

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



    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    */

    const savedTheme =
        localStorage.getItem(
            'jisr_theme'
        );


    if (
        savedTheme === 'dark'
    ) {

        document.body.classList.add(
            'theme-dark'
        );

    }


    function applyTheme(theme) {

        document.body.classList.toggle(
            'theme-dark',
            theme === 'dark'
        );


        localStorage.setItem(
            'jisr_theme',
            theme
        );


        const button =
            document.getElementById(
                'themeToggleBtn'
            );


        if (button) {

            button.textContent =
                theme === 'dark'
                    ? '☀️'
                    : '🌙';

        }

    }


    document.addEventListener(
        'DOMContentLoaded',
        function () {

            const button =
                document.getElementById(
                    'themeToggleBtn'
                );


            if (!button) {
                return;
            }


            button.textContent =
                document.body.classList.contains(
                    'theme-dark'
                )
                    ? '☀️'
                    : '🌙';


            button.addEventListener(
                'click',
                function () {

                    const dark =
                        document.body
                            .classList
                            .contains(
                                'theme-dark'
                            );


                    applyTheme(
                        dark
                            ? 'light'
                            : 'dark'
                    );

                }
            );

        }
    );

</script>

</body>
</html>

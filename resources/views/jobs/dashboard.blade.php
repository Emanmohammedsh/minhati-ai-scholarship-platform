<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Career Path | Jisr AI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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
                0 18px 60px rgba(10, 46, 107, 0.10);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family:
                'Poppins',
                Arial,
                sans-serif;

            background:
                radial-gradient(
                    circle at 90% 5%,
                    rgba(0, 198, 255, .15),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 5% 60%,
                    rgba(135, 223, 255, .20),
                    transparent 25%
                ),
                #f8fcff;

            color: var(--text);

            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }


        /* ============================
           NAVBAR
        ============================ */

        .navbar {
            height: 84px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding:
                0 clamp(24px, 5vw, 72px);

            background:
                rgba(255, 255, 255, .88);

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

            color:
                var(--primary);

            font-size: 19px;
        }

        .brand-text span {
            font-size: 11px;

            letter-spacing: 1.7px;

            color:
                #7B8794;
        }


        .nav-links {
            display: flex;
            align-items: center;

            gap: 8px;
        }

        .nav-item {
            color:
                var(--primary);

            padding:
                10px 14px;

            border-radius:
                10px;

            font-size:
                13px;

            font-weight:
                500;

            transition:
                .2s ease;
        }

        .nav-item:hover {
            background:
                var(--background);
        }


        .logout-btn {
            margin-left: 6px;

            border:
                none;

            background:
                var(--primary);

            color:
                white;

            padding:
                11px 17px;

            border-radius:
                11px;

            font-family:
                inherit;

            font-weight:
                600;

            cursor:
                pointer;

            transition:
                .2s;
        }

        .logout-btn:hover {
            transform:
                translateY(-1px);

            box-shadow:
                0 8px 20px rgba(10,46,107,.20);
        }


        /* ============================
           CONTAINER
        ============================ */

        .container {
            width:
                min(1180px, calc(100% - 40px));

            margin:
                0 auto;

            padding:
                46px 0 70px;
        }


        /* ============================
           HERO
        ============================ */

        .hero {
            position:
                relative;

            overflow:
                hidden;

            border-radius:
                30px;

            padding:
                55px;

            min-height:
                340px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            gap:
                45px;

            color:
                white;

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
            content:
                "";

            position:
                absolute;

            width:
                420px;

            height:
                420px;

            border-radius:
                50%;

            right:
                -110px;

            top:
                -190px;

            background:
                linear-gradient(
                    135deg,
                    rgba(0,198,255,.34),
                    rgba(135,223,255,.05)
                );
        }

        .hero::after {
            content:
                "";

            position:
                absolute;

            width:
                330px;

            height:
                330px;

            border-radius:
                50%;

            right:
                80px;

            bottom:
                -250px;

            border:
                40px solid
                rgba(0,198,255,.10);
        }


        .hero-content {
            position:
                relative;

            z-index:
                3;

            max-width:
                660px;
        }


        .eyebrow {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                8px;

            padding:
                8px 14px;

            background:
                rgba(255,255,255,.10);

            border:
                1px solid rgba(255,255,255,.14);

            border-radius:
                999px;

            font-size:
                12px;

            font-weight:
                600;

            margin-bottom:
                21px;
        }


        .eyebrow-dot {
            width:
                8px;

            height:
                8px;

            border-radius:
                50%;

            background:
                var(--secondary);

            box-shadow:
                0 0 16px var(--secondary);
        }


        .hero h1 {
            font-size:
                clamp(36px, 5vw, 58px);

            line-height:
                1.08;

            margin-bottom:
                18px;

            letter-spacing:
                -1.7px;
        }


        .hero h1 span {
            color:
                var(--secondary);
        }


        .hero p {
            color:
                #D8ECF8;

            line-height:
                1.9;

            font-size:
                15px;

            max-width:
                610px;
        }


        .hero-buttons {
            display:
                flex;

            gap:
                12px;

            margin-top:
                28px;

            flex-wrap:
                wrap;
        }


        .primary-btn,
        .secondary-btn {
            padding:
                13px 20px;

            border-radius:
                12px;

            font-size:
                13px;

            font-weight:
                600;

            transition:
                .25s;

            cursor:
                pointer;
        }


        .primary-btn {
            background:
                linear-gradient(
                    135deg,
                    var(--secondary),
                    #008FE8
                );

            color:
                white;

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

            color:
                white;

            background:
                rgba(255,255,255,.08);
        }


        .hero-visual {
            position:
                relative;

            z-index:
                5;

            min-width:
                270px;

            height:
                230px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;
        }


        .hero-logo-card {
            width:
                205px;

            height:
                205px;

            border-radius:
                34px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                rgba(255,255,255,.97);

            box-shadow:
                0 25px 50px rgba(0,0,0,.18);

            transform:
                rotate(3deg);
        }


        .hero-logo-card img {
            width:
                155px;

            height:
                155px;

            object-fit:
                contain;

            transform:
                rotate(-3deg);
        }


        /* ============================
           STATS
        ============================ */

        .stats {
            display:
                grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap:
                16px;

            margin:
                28px 0 45px;
        }


        .stat {
            background:
                rgba(255,255,255,.92);

            border:
                1px solid var(--border);

            border-radius:
                18px;

            padding:
                21px;

            box-shadow:
                0 8px 30px rgba(10,46,107,.05);
        }


        .stat-label {
            font-size:
                12px;

            color:
                #84919B;

            margin-bottom:
                7px;
        }


        .stat-value {
            color:
                var(--primary);

            font-size:
                24px;

            font-weight:
                700;
        }


        .stat-value small {
            font-size:
                12px;

            font-weight:
                500;

            color:
                #7A8A95;
        }


        /* ============================
           SECTION
        ============================ */

        .section-heading {
            display:
                flex;

            justify-content:
                space-between;

            align-items:
                flex-end;

            margin-bottom:
                22px;
        }


        .section-heading small {
            display:
                block;

            color:
                var(--secondary);

            font-weight:
                600;

            margin-bottom:
                6px;

            letter-spacing:
                .5px;
        }


        .section-heading h2 {
            color:
                var(--heading);

            font-size:
                27px;
        }


        .section-heading p {
            max-width:
                520px;

            font-size:
                13px;

            line-height:
                1.7;

            color:
                #7A8792;
        }


        /* ============================
           JOURNEY CARDS
        ============================ */

        .journey-grid {
            display:
                grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap:
                18px;
        }


        .journey-card {
            position:
                relative;

            overflow:
                hidden;

            background:
                white;

            border:
                1px solid var(--border);

            border-radius:
                21px;

            padding:
                25px;

            min-height:
                215px;

            transition:
                .3s ease;

            box-shadow:
                0 10px 35px rgba(10,46,107,.05);
        }


        .journey-card::before {
            content:
                "";

            position:
                absolute;

            left:
                0;

            top:
                0;

            width:
                100%;

            height:
                3px;

            background:
                linear-gradient(
                    90deg,
                    var(--primary),
                    var(--secondary)
                );

            transform:
                scaleX(0);

            transform-origin:
                left;

            transition:
                .3s;
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
            width:
                48px;

            height:
                48px;

            border-radius:
                14px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                linear-gradient(
                    135deg,
                    var(--background),
                    #D5F3FF
                );

            margin-bottom:
                18px;

            color:
                var(--primary);
        }


        .icon-box svg {
            width:
                24px;

            height:
                24px;

            stroke:
                currentColor;

            fill:
                none;

            stroke-width:
                2;
        }


        .journey-card h3 {
            color:
                var(--heading);

            font-size:
                16px;

            margin-bottom:
                9px;
        }


        .journey-card p {
            font-size:
                12.5px;

            line-height:
                1.75;

            color:
                #74828C;
        }


        /* ============================
           UPCOMING SECTION
        ============================ */

        .coming-card {
            margin-top:
                42px;

            border-radius:
                24px;

            padding:
                34px;

            display:
                grid;

            grid-template-columns:
                1.3fr .7fr;

            gap:
                35px;

            align-items:
                center;

            border:
                1px solid #CCEFFF;

            background:
                linear-gradient(
                    120deg,
                    #EFFAFF,
                    #FFFFFF
                );

            position:
                relative;

            overflow:
                hidden;
        }


        .coming-card::after {
            content:
                "";

            position:
                absolute;

            right:
                -80px;

            top:
                -120px;

            width:
                280px;

            height:
                280px;

            background:
                rgba(0,198,255,.08);

            border-radius:
                50%;
        }


        .coming-card h3 {
            color:
                var(--heading);

            margin-bottom:
                10px;

            font-size:
                22px;
        }


        .coming-card p {
            font-size:
                13px;

            line-height:
                1.8;
        }


        .progress-wrapper {
            position:
                relative;

            z-index:
                2;
        }


        .progress-top {
            display:
                flex;

            justify-content:
                space-between;

            margin-bottom:
                9px;

            color:
                var(--primary);

            font-size:
                12px;

            font-weight:
                600;
        }


        .progress {
            height:
                10px;

            border-radius:
                99px;

            overflow:
                hidden;

            background:
                #DCEFF7;
        }


        .progress-bar {
            width:
                28%;

            height:
                100%;

            background:
                linear-gradient(
                    90deg,
                    var(--primary),
                    var(--secondary)
                );

            border-radius:
                99px;
        }


        /* ============================
           QUOTE / BRAND
        ============================ */

        .brand-message {
            margin-top:
                45px;

            padding:
                40px;

            text-align:
                center;

            border-radius:
                25px;

            color:
                white;

            background:
                linear-gradient(
                    135deg,
                    #071F4E,
                    #0A2E6B
                );

            position:
                relative;

            overflow:
                hidden;
        }


        .brand-message::before {
            content:
                "";

            width:
                250px;

            height:
                250px;

            position:
                absolute;

            top:
                -170px;

            left:
                50%;

            transform:
                translateX(-50%);

            background:
                var(--secondary);

            opacity:
                .15;

            filter:
                blur(55px);

            border-radius:
                50%;
        }


        .brand-message h3 {
            position:
                relative;

            font-size:
                26px;

            margin-bottom:
                8px;
        }


        .brand-message span {
            position:
                relative;

            color:
                var(--accent);

            font-size:
                13px;

            letter-spacing:
                3px;
        }


        /* ============================
           RESPONSIVE
        ============================ */

        @media(max-width: 950px) {

            .journey-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .stats {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .hero {
                padding:
                    38px;
            }

            .hero-visual {
                display:
                    none;
            }

        }


        @media(max-width: 720px) {

            .navbar {
                padding:
                    0 18px;
            }

            .brand-text {
                display:
                    none;
            }

            .nav-item {
                display:
                    none;
            }

            .container {
                width:
                    calc(100% - 28px);

                padding-top:
                    24px;
            }

            .hero {
                border-radius:
                    22px;

                padding:
                    30px 25px;

                min-height:
                    auto;
            }

            .hero h1 {
                font-size:
                    34px;
            }

            .journey-grid,
            .stats,
            .coming-card {
                grid-template-columns:
                    1fr;
            }

            .section-heading {
                flex-direction:
                    column;

                align-items:
                    flex-start;

                gap:
                    10px;
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
            Switch Path
        </a>

        <a
            href="/profile"
            class="nav-item"
        >
            Profile
        </a>

        <a
            href="/cv-upload"
            class="nav-item"
        >
            My CV
        </a>

        <button
            class="logout-btn"
            onclick="logout()"
        >
            Logout
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

                Jisr AI Career Path

            </div>


            <h1>

                Turn your skills into
                <span>opportunities.</span>

            </h1>


            <p>

                Jisr AI helps graduates and job seekers
                discover career opportunities aligned
                with their skills, qualifications,
                education and experience.

                Soon, your profile and CV will be
                intelligently matched with job requirements
                to help you understand where you fit
                — and what you can improve.

            </p>


            <div class="hero-buttons">

                <a
                    href="/profile"
                    class="primary-btn"
                >
                    Complete My Profile →
                </a>

                <a
                    href="/cv-upload"
                    class="secondary-btn"
                >
                    Review My CV
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
         SUMMARY STATS
    ====================================== -->

    <section class="stats">

        <div class="stat">

            <div class="stat-label">
                Job Matches
            </div>

            <div class="stat-value">
                —
            </div>

        </div>


        <div class="stat">

            <div class="stat-label">
                Applications
            </div>

            <div class="stat-value">
                —
            </div>

        </div>


        <div class="stat">

            <div class="stat-label">
                CV Status
            </div>

            <div class="stat-value">

                Connected

                <small>
                    profile
                </small>

            </div>

        </div>


        <div class="stat">

            <div class="stat-label">
                Career Path
            </div>

            <div class="stat-value">

                Building

                <small>
                    phase
                </small>

            </div>

        </div>

    </section>



    <!-- ======================================
         CAREER JOURNEY
    ====================================== -->

    <div class="section-heading">

        <div>

            <small>
                YOUR JOURNEY
            </small>

            <h2>
                From potential to opportunity
            </h2>

        </div>

        <p>

            One guided path to discover opportunities,
            understand your readiness and manage your
            career applications.

        </p>

    </div>



    <section class="journey-grid">


        <!-- Discover -->

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
                Discover Jobs
            </h3>

            <p>

                Explore opportunities relevant to
                your education, skills, interests
                and professional direction.

            </p>

        </article>



        <!-- Match -->

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
                AI Job Matching
            </h3>

            <p>

                Compare your profile and CV
                with structured job requirements
                to find relevant opportunities.

            </p>

        </article>



        <!-- Gap -->

        <article class="journey-card">

            <div class="icon-box">

                <svg viewBox="0 0 24 24">

                    <path
                        d="M4 19V9"
                    />

                    <path
                        d="M10 19V5"
                    />

                    <path
                        d="M16 19v-7"
                    />

                    <path
                        d="M22 19V3"
                    />

                </svg>

            </div>

            <h3>
                Skill Gap Analysis
            </h3>

            <p>

                Understand which job requirements
                you already meet and identify
                skills that may need improvement.

            </p>

        </article>



        <!-- Track -->

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
                Track Applications
            </h3>

            <p>

                Save opportunities and monitor
                your application journey from
                preparation to submission.

            </p>

        </article>


    </section>



    <!-- ======================================
         DEVELOPMENT
    ====================================== -->

    <section class="coming-card">

        <div>

            <h3>
                Career Path is being built 🚀
            </h3>

            <p>

                We are expanding Jisr AI from
                scholarship matching into a complete
                education-to-employment platform.

                Your existing profile and CV will
                become the foundation for job matching,
                skill-gap analysis and career readiness.

            </p>

        </div>


        <div class="progress-wrapper">

            <div class="progress-top">

                <span>
                    Career Module
                </span>

                <span>
                    In Development
                </span>

            </div>


            <div class="progress">

                <div class="progress-bar"></div>

            </div>

        </div>

    </section>



    <!-- ======================================
         BRAND MESSAGE
    ====================================== -->

    <section class="brand-message">

        <h3>
            More Opportunities Ahead.
        </h3>

        <span>
            JISR AI · A BRIGHTER TOMORROW
        </span>

    </section>


</main>



<script>

    const token =
        localStorage.getItem(
            'auth_token'
        );


    if (!token) {

        window.location.href =
            '/login';

    }


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

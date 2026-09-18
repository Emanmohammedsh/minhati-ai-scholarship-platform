<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Jisr AI | اختر مسارك</title>

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

            --shadow:
                0 20px 60px rgba(10,46,107,.10);
        }


        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            min-height: 100vh;

            font-family:
                "Cairo",
                Arial,
                sans-serif;

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

            padding:
                18px clamp(22px, 5vw, 72px);

            display: flex;
            justify-content: space-between;
            align-items: center;

            background:
                rgba(255,255,255,.88);

            backdrop-filter:
                blur(15px);

            border-bottom:
                1px solid rgba(10,46,107,.08);
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

            font-family:
                "Poppins",
                sans-serif;

            font-size: 18px;

            color:
                var(--navy);
        }


        .brand-info span {
            font-size: 11px;

            color:
                var(--muted);
        }


        .logout-btn {
            border: 0;

            background:
                transparent;

            font-family:
                inherit;

            font-size:
                13px;

            color:
                var(--muted);

            cursor:
                pointer;

            padding:
                10px 15px;

            border-radius:
                10px;

            transition:
                .2s;
        }


        .logout-btn:hover {
            background:
                var(--light-blue);

            color:
                var(--navy);
        }


        /* ==========================
           PAGE
        ========================== */

        .page {
            width:
                min(1180px, calc(100% - 40px));

            margin:
                0 auto;

            padding:
                55px 0 65px;
        }


        /* ==========================
           HERO
        ========================== */

        .intro {
            text-align: center;

            max-width:
                760px;

            margin:
                0 auto 42px;
        }


        .intro-badge {
            display:
                inline-flex;

            align-items:
                center;

            gap:
                8px;

            background:
                var(--light-blue);

            color:
                var(--navy);

            padding:
                8px 15px;

            border-radius:
                999px;

            font-size:
                12px;

            font-weight:
                700;

            margin-bottom:
                18px;
        }


        .intro-badge span {
            width:
                8px;

            height:
                8px;

            border-radius:
                50%;

            background:
                var(--cyan);

            box-shadow:
                0 0 14px rgba(0,198,255,.7);
        }


        .intro h1 {
            color:
                var(--heading);

            font-size:
                clamp(32px, 5vw, 48px);

            margin-bottom:
                13px;

            line-height:
                1.3;
        }


        .intro h1 b {
            color:
                var(--cyan);
        }


        .intro p {
            color:
                var(--muted);

            font-size:
                15px;

            line-height:
                1.9;
        }


        .user-welcome {
            margin-top:
                14px;

            font-size:
                13px;

            color:
                var(--navy);
        }


        /* ==========================
           PATH GRID
        ========================== */

        .paths {
            display:
                grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap:
                25px;
        }


        .path-card {
            position:
                relative;

            overflow:
                hidden;

            min-height:
                500px;

            background:
                rgba(255,255,255,.96);

            border:
                1px solid var(--border);

            border-radius:
                28px;

            padding:
                35px;

            box-shadow:
                var(--shadow);

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border .3s ease;
        }


        .path-card:hover {
            transform:
                translateY(-8px);

            box-shadow:
                0 30px 75px rgba(10,46,107,.16);

            border-color:
                rgba(0,198,255,.40);
        }


        .path-card::after {
            content:
                "";

            position:
                absolute;

            width:
                230px;

            height:
                230px;

            border-radius:
                50%;

            left:
                -110px;

            bottom:
                -130px;

            background:
                rgba(0,198,255,.06);
        }


        .card-top {
            display: flex;

            justify-content:
                space-between;

            align-items:
                flex-start;

            margin-bottom:
                26px;
        }


        .path-number {
            color:
                #A8B6C2;

            font-family:
                "Poppins",
                sans-serif;

            font-size:
                13px;

            font-weight:
                600;
        }


        .icon-box {
            width:
                67px;

            height:
                67px;

            border-radius:
                20px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                linear-gradient(
                    135deg,
                    var(--light-blue),
                    #D5F4FF
                );

            color:
                var(--navy);
        }


        .icon-box svg {
            width:
                31px;

            height:
                31px;

            stroke:
                currentColor;

            fill:
                none;

            stroke-width:
                1.8;
        }


        .path-label {
            display:
                inline-block;

            margin-bottom:
                10px;

            color:
                var(--cyan);

            font-size:
                12px;

            font-family:
                "Poppins",
                sans-serif;

            font-weight:
                700;

            letter-spacing:
                .5px;
        }


        .path-card h2 {
            color:
                var(--heading);

            font-size:
                27px;

            margin-bottom:
                5px;
        }


        .path-card h3 {
            color:
                var(--navy);

            font-size:
                15px;

            margin-bottom:
                17px;
        }


        .description {
            color:
                var(--muted);

            font-size:
                13.5px;

            line-height:
                1.9;

            min-height:
                80px;

            margin-bottom:
                23px;
        }


        /* ==========================
           FEATURES
        ========================== */

        .features {
            display:
                grid;

            gap:
                12px;

            margin-bottom:
                30px;
        }


        .feature {
            display:
                flex;

            align-items:
                center;

            gap:
                11px;

            font-size:
                13px;

            color:
                #53616D;
        }


        .check {
            min-width:
                25px;

            width:
                25px;

            height:
                25px;

            border-radius:
                8px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                var(--light-blue);

            color:
                var(--navy);

            font-size:
                12px;

            font-weight:
                bold;
        }


        /* ==========================
           BUTTON
        ========================== */

        .path-btn {
            position:
                relative;

            z-index:
                2;

            width:
                100%;

            min-height:
                54px;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            gap:
                10px;

            border-radius:
                14px;

            font-size:
                14px;

            font-weight:
                700;

            transition:
                .25s;

            background:
                linear-gradient(
                    135deg,
                    var(--navy),
                    #0B5495
                );

            color:
                white;

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
            transform:
                translateY(-2px);

            box-shadow:
                0 17px 35px rgba(10,46,107,.23);
        }


        /* ==========================
           BOTTOM MESSAGE
        ========================== */

        .bottom-message {
            margin-top:
                35px;

            background:
                linear-gradient(
                    120deg,
                    var(--navy-dark),
                    var(--navy)
                );

            color:
                white;

            border-radius:
                22px;

            padding:
                25px 30px;

            display:
                flex;

            justify-content:
                space-between;

            align-items:
                center;

            gap:
                20px;
        }


        .bottom-message strong {
            display:
                block;

            font-size:
                17px;

            margin-bottom:
                5px;
        }


        .bottom-message p {
            color:
                #C9E4F5;

            font-size:
                12px;

            line-height:
                1.7;
        }


        .bottom-tag {
            direction:
                ltr;

            font-family:
                "Poppins",
                sans-serif;

            color:
                var(--light-cyan);

            white-space:
                nowrap;

            font-size:
                12px;

            letter-spacing:
                1px;
        }


        /* ==========================
           RESPONSIVE
        ========================== */

        @media(max-width: 800px) {

            .paths {
                grid-template-columns:
                    1fr;
            }


            .path-card {
                min-height:
                    auto;
            }


            .description {
                min-height:
                    auto;
            }


            .bottom-message {
                flex-direction:
                    column;

                text-align:
                    center;
            }

        }


        @media(max-width: 550px) {

            .topbar {
                padding:
                    14px 18px;
            }


            .brand-info span {
                display:
                    none;
            }


            .page {
                width:
                    calc(100% - 26px);

                padding-top:
                    35px;
            }


            .path-card {
                padding:
                    27px 23px;

                border-radius:
                    22px;
            }

        }

    </style>

</head>


<body>


<header class="topbar">

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


    <button
        class="logout-btn"
        onclick="logout()"
    >
        تسجيل الخروج
    </button>

</header>



<main class="page">


    <!-- INTRO -->

    <section class="intro">

        <div class="intro-badge">

            <span></span>

            Jisr AI · Your Opportunity Journey

        </div>


        <h1>

            أي طريق تريد أن تبدأ منه
            <b>اليوم؟</b>

        </h1>


        <p>

            جسر يربط ملفك ومهاراتك ومؤهلاتك بالفرص المناسبة لك.
            اختر مسارك الآن، ويمكنك الانتقال بين التعليم والعمل
            في أي وقت.

        </p>


        <div
            class="user-welcome"
            id="userWelcome"
        >
            مرحباً بك في Jisr AI
        </div>

    </section>



    <!-- PATHS -->

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
                مسار التعليم
            </h2>


            <h3>
                اكتشف المنح المناسبة لملفك
            </h3>


            <p class="description">

                استخدم ملفك الأكاديمي وسيرتك الذاتية
                للوصول إلى منح دراسية تتناسب مع تخصصك،
                مستواك، مؤهلاتك واهتماماتك.

            </p>


            <div class="features">

                <div class="feature">

                    <span class="check">✓</span>

                    مطابقة ذكية مع المنح الدراسية

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    Match Score وتفسير أسباب المطابقة

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    Gap Analysis للمتطلبات الناقصة

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    تجهيز ومتابعة طلبات التقديم

                </div>

            </div>


            <a
                href="/dashboard"
                class="path-btn"
            >

                ابدأ مسار التعليم

                <span>
                    ←
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
                مسار العمل
            </h2>


            <h3>
                حوّل مهاراتك إلى فرص مهنية
            </h3>


            <p class="description">

                اكتشف الوظائف التي تتوافق مع مهاراتك
                وتعليمك ومؤهلاتك، واعرف نقاط قوتك
                والمهارات التي تحتاج إلى تطويرها.

            </p>


            <div class="features">

                <div class="feature">

                    <span class="check">✓</span>

                    مطابقة الوظائف مع الملف والسيرة الذاتية

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    AI Job Matching

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    Skill Gap Analysis

                </div>


                <div class="feature">

                    <span class="check">✓</span>

                    حفظ ومتابعة طلبات العمل

                </div>

            </div>


            <a
                href="/jobs/dashboard"
                class="path-btn"
            >

                ابدأ المسار المهني

                <span>
                    ←
                </span>

            </a>

        </article>


    </section>



    <!-- BOTTOM -->

    <section class="bottom-message">

        <div>

            <strong>
                جسر واحد. فرص أكثر.
            </strong>

            <p>
                من التعليم إلى سوق العمل، نساعد الشباب على
                الوصول إلى الفرص التي تناسب إمكاناتهم.
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
        localStorage.getItem(
            'auth_token'
        );


    if (!token) {

        window.location.href =
            '/login';

    }



    /*
    |--------------------------------------------------------------------------
    | Show User Name
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

                document.getElementById(
                    'userWelcome'
                ).textContent =
                    `مرحباً ${user.full_name}، اختر المسار الذي يناسب هدفك`;

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

</script>


</body>

</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Jisr AI | {{ app()->getLocale() === 'ar' ? 'تسجيل الدخول' : 'Login' }}
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --navy: #0A2E6B;
            --blue: #0877F9;
            --cyan: #00C6FF;
            --soft: #EAF6FF;
            --bg: #F7FBFF;
            --surface: #FFFFFF;
            --text: #102A43;
            --muted: #64748B;
            --border: #DCEAF5;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: 'Poppins', sans-serif;
        }

        html[dir="rtl"] body {
            font-family: 'Tajawal', sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input {
            font: inherit;
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns:
                minmax(420px, 0.92fr)
                minmax(520px, 1.08fr);

            background: var(--surface);
        }

        /* =========================
           LEFT / FORM
        ========================= */

        .form-side {
            min-height: 100vh;
            display: flex;
            flex-direction: column;

            padding:
                32px
                clamp(38px, 5vw, 76px);
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .logo-box {
            display: inline-flex;
            align-items: center;

            padding: 4px 7px;

            border-radius: 12px;

            background: #FFFFFF;
        }

        .logo {
            width: 118px;
            height: 46px;

            object-fit: contain;
        }

        .back-home {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            color: var(--muted);

            font-size: 0.78rem;
            font-weight: 700;

            transition: 0.18s ease;
        }

        .back-home:hover {
            color: var(--blue);
        }

        html[dir="rtl"] .back-arrow {
            transform: rotate(180deg);
        }

        .form-shell {
            width: 100%;
            max-width: 455px;

            margin: auto;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            padding: 7px 11px;

            margin-bottom: 15px;

            border: 1px solid #CBE9FA;
            border-radius: 999px;

            background: var(--soft);

            color: var(--blue);

            font-size: 0.72rem;
            font-weight: 800;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: var(--cyan);
        }

        h1 {
            max-width: 520px;

            margin-bottom: 10px;

            color: var(--navy);

            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 800;
            line-height: 1.08;

            letter-spacing: -0.045em;
        }

        html[dir="rtl"] h1 {
            letter-spacing: 0;
            line-height: 1.18;
        }

        .subtitle {
            margin-bottom: 27px;

            color: var(--muted);

            font-size: 0.88rem;
            line-height: 1.75;
        }

        /* =========================
           ALERTS
        ========================= */

        .alert {
            display: none;

            margin-bottom: 15px;
            padding: 11px 13px;

            border-radius: 11px;

            font-size: 0.78rem;
            line-height: 1.5;
        }

        .alert-error {
            display: block;

            border: 1px solid #FECACA;

            background: #FEF2F2;
            color: #B91C1C;
        }

        .alert-success {
            display: block;

            border: 1px solid #BBF7D0;

            background: #F0FDF4;
            color: #166534;
        }

        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            color: #334155;

            font-size: 0.76rem;
            font-weight: 700;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;

            left: 14px;
            top: 50%;

            transform: translateY(-50%);

            color: #94A3B8;

            pointer-events: none;
        }

        html[dir="rtl"] .input-icon {
            left: auto;
            right: 14px;
        }

        .input-wrap input {
            width: 100%;
            height: 49px;

            padding:
                0
                44px;

            border: 1px solid var(--border);
            border-radius: 12px;

            outline: none;

            background: #FFFFFF;
            color: var(--text);

            font-size: 0.84rem;

            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .input-wrap input::placeholder {
            color: #A8B5C3;
        }

        .input-wrap input:focus {
            border-color: var(--blue);

            box-shadow:
                0 0 0 3px
                rgba(8, 119, 249, 0.09);
        }

        .toggle-eye {
            position: absolute;

            right: 12px;
            top: 50%;

            transform: translateY(-50%);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 5px;

            border: 0;

            background: transparent;
            color: #94A3B8;

            cursor: pointer;
        }

        html[dir="rtl"] .toggle-eye {
            right: auto;
            left: 12px;
        }

        .forgot-row {
            display: flex;
            justify-content: flex-end;

            margin:
                -3px
                0
                16px;
        }

        .forgot {
            color: var(--blue);

            font-size: 0.73rem;
            font-weight: 700;
        }

        .forgot:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            height: 49px;

            border: 0;
            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--blue),
                    var(--cyan)
                );

            color: #FFFFFF;

            font-size: 0.85rem;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 10px 25px
                rgba(8, 119, 249, 0.18);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .login-btn:hover {
            transform: translateY(-1px);

            box-shadow:
                0 13px 30px
                rgba(8, 119, 249, 0.23);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* =========================
           GOOGLE
        ========================= */

        .divider {
            display: flex;
            align-items: center;

            gap: 12px;

            margin: 19px 0;

            color: #94A3B8;

            font-size: 0.7rem;
        }

        .divider::before,
        .divider::after {
            content: "";

            flex: 1;

            height: 1px;

            background: var(--border);
        }

        .google-btn {
            width: 100%;
            height: 47px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 10px;

            border: 1px solid var(--border);
            border-radius: 12px;

            background: #FFFFFF;

            color: #334155;

            font-size: 0.8rem;
            font-weight: 700;

            transition:
                background 0.18s ease,
                border-color 0.18s ease;
        }

        .google-btn:hover {
            border-color: #BCD9ED;
            background: #F8FCFF;
        }

        .form-footer {
            margin-top: 20px;

            text-align: center;

            color: var(--muted);

            font-size: 0.78rem;
        }

        .form-footer a {
            color: var(--blue);

            font-weight: 800;
        }

        /* =========================
           VISUAL SIDE
        ========================= */

        .visual-side {
            position: relative;

            min-height: calc(100vh - 36px);

            margin:
                18px
                18px
                18px
                0;

            overflow: hidden;

            border-radius: 28px;

            background: var(--navy);
        }

        html[dir="rtl"] .visual-side {
            margin:
                18px
                0
                18px
                18px;
        }

        .visual-image {
            position: absolute;

            inset: 0;

            width: 100%;
            height: 100%;

            object-fit: cover;
            object-position: center;
        }

        .visual-overlay {
            position: absolute;

            inset: 0;

            background:
                linear-gradient(
                    180deg,
                    rgba(10, 46, 107, 0.02) 20%,
                    rgba(10, 46, 107, 0.14) 55%,
                    rgba(4, 24, 39, 0.78) 100%
                );
        }

        .visual-copy {
            position: absolute;
            z-index: 2;

            left: 42px;
            right: 42px;
            bottom: 40px;

            color: #FFFFFF;
        }

        .visual-pill {
            display: inline-flex;
            align-items: center;

            margin-bottom: 13px;
            padding: 7px 11px;

            border:
                1px solid
                rgba(255, 255, 255, 0.35);

            border-radius: 999px;

            background:
                rgba(255, 255, 255, 0.12);

            backdrop-filter: blur(8px);

            font-size: 0.7rem;
            font-weight: 700;
        }

        .visual-copy h2 {
            max-width: 580px;

            margin-bottom: 10px;

            font-size: clamp(2rem, 3.3vw, 3.3rem);
            line-height: 1.08;
        }

        .visual-copy p {
            max-width: 520px;

            color:
                rgba(255, 255, 255, 0.87);

            font-size: 0.84rem;
            line-height: 1.75;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 950px) {
            .auth-page {
                grid-template-columns: 1fr;
            }

            .visual-side {
                display: none;
            }

            .form-side {
                padding: 25px;
            }

            .form-shell {
                max-width: 480px;
            }

            .topbar {
                margin-bottom: 35px;
            }
        }

        @media (max-width: 520px) {
            .form-side {
                padding: 20px;
            }

            .logo {
                width: 100px;
                height: 40px;
            }

            .back-home {
                font-size: 0.7rem;
            }

            .form-shell {
                margin:
                    28px
                    auto
                    auto;
            }

            h1 {
                font-size: 2.05rem;
            }

            .subtitle {
                font-size: 0.82rem;
            }
        }
    </style>
</head>

<body>

@php($ar = app()->getLocale() === 'ar')

<div class="auth-page">

    {{-- FORM SIDE --}}
    <section class="form-side">

        <div class="topbar">

            <a
                href="{{ url('/') }}"
                class="logo-box"
                aria-label="Jisr AI"
            >
                <img
                    src="{{ asset('images/brand/jisr-logo-official.png') }}"
                    alt="Jisr AI | جسر"
                    class="logo"
                >
            </a>

            <a
                href="{{ url('/') }}"
                class="back-home"
            >
                <span class="back-arrow">←</span>

                <span>
                    {{ $ar ? 'العودة للرئيسية' : 'Back to home' }}
                </span>
            </a>

        </div>


        <div class="form-shell">

            <span class="eyebrow">
                <span class="eyebrow-dot"></span>

                {{ $ar ? 'مرحباً بعودتك' : 'Welcome Back' }}
            </span>

            <h1>
                {{ $ar
                    ? 'أكمل رحلتك مع جسر.'
                    : 'Continue Your Journey.'
                }}
            </h1>

            <p class="subtitle">
                {{ $ar
                    ? 'سجّل دخولك للوصول إلى فرصك وتوصياتك ومتابعة طلباتك من مكان واحد.'
                    : 'Sign in to access your opportunities, recommendations, and applications in one place.'
                }}
            </p>


            <div
                id="globalAlert"
                class="alert"
            ></div>


            <form id="loginForm">

                {{-- EMAIL --}}
                <div class="form-group">

                    <label for="email">
                        {{ $ar
                            ? 'البريد الإلكتروني'
                            : 'Email'
                        }}
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="input-icon"
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <rect
                                x="3"
                                y="5"
                                width="18"
                                height="14"
                                rx="2"
                            />

                            <path d="M4 6l8 7 8-7"/>
                        </svg>

                        <input
                            type="text"
                            id="email"
                            name="email"
                            placeholder="you@example.com"
                            autocomplete="email"
                            required
                        >

                    </div>

                </div>


                {{-- PASSWORD --}}
                <div class="form-group">

                    <label for="password">
                        {{ $ar
                            ? 'كلمة المرور'
                            : 'Password'
                        }}
                    </label>

                    <div class="input-wrap">

                        <svg
                            class="input-icon"
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <rect
                                x="5"
                                y="11"
                                width="14"
                                height="9"
                                rx="2"
                            />

                            <path
                                d="
                                    M8 11V7
                                    a4 4 0 0 1 8 0
                                    v4
                                "
                            />
                        </svg>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-eye"
                            id="toggleEye"
                            aria-label="Show password"
                        >
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    d="
                                        M1 12
                                        s4-7 11-7
                                        11 7 11 7
                                        -4 7-11 7
                                        -11-7-11-7z
                                    "
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                />
                            </svg>
                        </button>

                    </div>

                </div>


                <div class="forgot-row">
                    <a
                        href="#"
                        class="forgot"
                    >
                        {{ $ar
                            ? 'نسيت كلمة المرور؟'
                            : 'Forgot password?'
                        }}
                    </a>
                </div>


                <button
                    type="submit"
                    class="login-btn"
                    id="loginBtn"
                >
                    {{ $ar
                        ? 'تسجيل الدخول'
                        : 'Sign In'
                    }}
                </button>

            </form>


            <div class="divider">
                {{ $ar ? 'أو' : 'or' }}
            </div>


            {{-- GOOGLE LOGIN --}}
            <a
                href="{{ url('/api/auth/google/redirect') }}"
                class="google-btn"
            >

                <svg
                    width="18"
                    height="18"
                    viewBox="0 0 48 48"
                >
                    <path
                        fill="#EA4335"
                        d="
                            M24 9.5
                            c3.54 0 6.71 1.22 9.21 3.6
                            l6.85-6.85
                            C35.9 2.38 30.47 0 24 0
                            14.62 0 6.51 5.38 2.56 13.22
                            l7.98 6.19
                            C12.43 13.72 17.74 9.5 24 9.5z
                        "
                    />

                    <path
                        fill="#4285F4"
                        d="
                            M46.98 24.55
                            c0-1.57-.15-3.09-.38-4.55
                            H24v9.02h12.94
                            c-.58 2.96-2.26 5.48-4.78 7.18
                            l7.73 6
                            c4.51-4.18 7.09-10.36 7.09-17.65z
                        "
                    />

                    <path
                        fill="#FBBC05"
                        d="
                            M10.53 28.59
                            c-.48-1.45-.76-2.99-.76-4.59
                            s.27-3.14.76-4.59
                            L2.56 13.22
                            C.92 16.46 0 20.12 0 24
                            s.92 7.54 2.56 10.78
                            l7.97-6.19z
                        "
                    />

                    <path
                        fill="#34A853"
                        d="
                            M24 48
                            c6.48 0 11.93-2.13 15.89-5.81
                            l-7.73-6
                            c-2.15 1.45-4.92 2.3-8.16 2.3
                            -6.26 0-11.57-4.22-13.47-9.91
                            l-7.98 6.19
                            C6.51 42.62 14.62 48 24 48z
                        "
                    />
                </svg>

                <span>
                    {{ $ar
                        ? 'المتابعة باستخدام Google'
                        : 'Continue with Google'
                    }}
                </span>

            </a>


            <div class="form-footer">

                {{ $ar
                    ? 'ليس لديك حساب؟'
                    : "Don't have an account?"
                }}

                <a href="{{ route('register') }}">
                    {{ $ar
                        ? 'أنشئ حساباً'
                        : 'Create account'
                    }}
                </a>

            </div>

        </div>

    </section>


    {{-- VISUAL SIDE --}}
    <aside class="visual-side">

        <img
            src="{{ asset('images/opportunities/jisr-scholarships.png') }}"
            alt=""
            class="visual-image"
        >

        <div class="visual-overlay"></div>

        <div class="visual-copy">

            <span class="visual-pill">
                Jisr AI
            </span>

            <h2>
                {{ $ar
                    ? 'طموحك يستحق فرصة مناسبة.'
                    : 'Your Ambitions Deserve the Right Opportunity.'
                }}
            </h2>

            <p>
                {{ $ar
                    ? 'من المنح إلى الوظائف، يساعدك جسر على فهم أين تناسبك الفرصة وما هي خطوتك التالية.'
                    : 'From scholarships to jobs, Jisr helps you understand where you fit and what to do next.'
                }}
            </p>

        </div>

    </aside>

</div>


<script>
    const API_BASE_URL = "/api";
    const DASHBOARD_URL = "{{ route('choose-path') }}";
    const IS_ARABIC = {{ $ar ? 'true' : 'false' }};


    function showAlert(message, type) {

        const alertBox =
            document.getElementById('globalAlert');

        alertBox.textContent = message;

        alertBox.className =
            'alert ' +
            (
                type === 'success'
                    ? 'alert-success'
                    : 'alert-error'
            );

        alertBox.style.display = 'block';
    }


    /*
    |--------------------------------------------------------------------------
    | Google OAuth return
    |--------------------------------------------------------------------------
    */

    (function checkGoogleLoginToken() {

        const params =
            new URLSearchParams(
                window.location.search
            );

        const googleToken =
            params.get('token');


        if (!googleToken) {
            return;
        }


        fetch(
            `${API_BASE_URL}/me`,
            {
                headers: {
                    'Authorization':
                        `Bearer ${googleToken}`,

                    'Accept':
                        'application/json'
                }
            }
        )

        .then(response => {

            if (!response.ok) {
                throw new Error(
                    'Unable to load user.'
                );
            }

            return response.json();
        })

        .then(user => {

            localStorage.setItem(
                'auth_token',
                googleToken
            );

            localStorage.setItem(
                'auth_user',
                JSON.stringify(user)
            );

            window.location.href =
                DASHBOARD_URL;
        })

        .catch(() => {

            showAlert(
                IS_ARABIC
                    ? 'فشل تسجيل الدخول عبر Google. حاول مرة أخرى.'
                    : 'Google sign-in failed. Please try again.',
                'error'
            );
        });

    })();


    /*
    |--------------------------------------------------------------------------
    | Password visibility
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('toggleEye')
        .addEventListener(
            'click',
            function () {

                const password =
                    document.getElementById(
                        'password'
                    );

                password.type =
                    password.type === 'password'
                        ? 'text'
                        : 'password';
            }
        );


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('loginForm')
        .addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                const loginBtn =
                    document.getElementById(
                        'loginBtn'
                    );

                const alertBox =
                    document.getElementById(
                        'globalAlert'
                    );


                alertBox.style.display =
                    'none';


                loginBtn.disabled =
                    true;

                loginBtn.textContent =
                    IS_ARABIC
                        ? 'جارٍ تسجيل الدخول...'
                        : 'Signing in...';


                const payload = {

                    email:
                        document
                            .getElementById(
                                'email'
                            )
                            .value,

                    password:
                        document
                            .getElementById(
                                'password'
                            )
                            .value
                };


                try {

                    const response =
                        await fetch(
                            `${API_BASE_URL}/login`,
                            {
                                method:
                                    'POST',

                                headers: {
                                    'Content-Type':
                                        'application/json',

                                    'Accept':
                                        'application/json'
                                },

                                body:
                                    JSON.stringify(
                                        payload
                                    )
                            }
                        );


                    const data =
                        await response.json();


                    if (response.ok) {

                        /*
                         * AuthController returns
                         * access_token.
                         */

                        if (data.access_token) {

                            localStorage.setItem(
                                'auth_token',
                                data.access_token
                            );

                            localStorage.setItem(
                                'auth_user',
                                JSON.stringify(
                                    data.user
                                )
                            );
                        }


                        showAlert(
                            IS_ARABIC
                                ? 'تم تسجيل الدخول بنجاح.'
                                : 'Signed in successfully!',
                            'success'
                        );


                        setTimeout(
                            function () {

                                window.location.href =
                                    DASHBOARD_URL;

                            },
                            600
                        );

                    }

                    else if (
                        response.status === 422 &&
                        data.errors
                    ) {

                        const firstErrorKey =
                            Object.keys(
                                data.errors
                            )[0];


                        showAlert(
                            data.errors[
                                firstErrorKey
                            ][0],
                            'error'
                        );

                    }

                    else {

                        showAlert(
                            data.message ||
                            (
                                IS_ARABIC
                                    ? 'البريد الإلكتروني أو كلمة المرور غير صحيحة.'
                                    : 'Invalid email or password.'
                            ),
                            'error'
                        );
                    }

                }

                catch (error) {

                    showAlert(
                        IS_ARABIC
                            ? 'تعذر الاتصال بالخادم. تأكد من تشغيل Laravel.'
                            : 'Could not connect to the server. Make sure your Laravel backend is running.',
                        'error'
                    );

                }

                finally {

                    loginBtn.disabled =
                        false;

                    loginBtn.textContent =
                        IS_ARABIC
                            ? 'تسجيل الدخول'
                            : 'Sign In';
                }
            }
        );
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Jisr AI | {{ app()->getLocale() === 'ar' ? 'إنشاء حساب' : 'Create Account' }}
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
           FORM SIDE
        ========================= */

        .form-side {
            min-height: 100vh;

            display: flex;
            flex-direction: column;

            padding:
                28px
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

            margin-bottom: 12px;

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
            margin-bottom: 8px;

            color: var(--navy);

            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 800;
            line-height: 1.1;

            letter-spacing: -0.04em;
        }

        html[dir="rtl"] h1 {
            letter-spacing: 0;
            line-height: 1.2;
        }

        .subtitle {
            margin-bottom: 19px;

            color: var(--muted);

            font-size: 0.84rem;
            line-height: 1.7;
        }

        /* =========================
           ALERT
        ========================= */

        .alert {
            display: none;

            margin-bottom: 13px;
            padding: 10px 12px;

            border-radius: 11px;

            font-size: 0.76rem;
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
            margin-bottom: 12px;
        }

        label {
            display: block;

            margin-bottom: 6px;

            color: #334155;

            font-size: 0.74rem;
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
            height: 46px;

            padding:
                0
                44px;

            border: 1px solid var(--border);
            border-radius: 12px;

            outline: none;

            background: #FFFFFF;
            color: var(--text);

            font-size: 0.82rem;

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

        .input-wrap input.invalid {
            border-color: #EF4444;

            box-shadow:
                0 0 0 3px
                rgba(239, 68, 68, 0.06);
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

        .field-error {
            display: none;

            margin-top: 5px;

            color: #DC2626;

            font-size: 0.69rem;
            line-height: 1.4;
        }

        .field-error.show {
            display: block;
        }

        .signup-btn {
            width: 100%;
            height: 48px;

            margin-top: 3px;

            border: 0;
            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    var(--blue),
                    var(--cyan)
                );

            color: #FFFFFF;

            font-size: 0.84rem;
            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 10px 25px
                rgba(8, 119, 249, 0.18);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .signup-btn:hover {
            transform: translateY(-1px);

            box-shadow:
                0 13px 30px
                rgba(8, 119, 249, 0.23);
        }

        .signup-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .form-footer {
            margin-top: 18px;

            text-align: center;

            color: var(--muted);

            font-size: 0.77rem;
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
                    rgba(10, 46, 107, 0.15) 55%,
                    rgba(4, 24, 39, 0.8) 100%
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

            font-size:
                clamp(
                    2rem,
                    3.3vw,
                    3.3rem
                );

            line-height: 1.08;
        }

        .visual-copy p {
            max-width: 520px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    0.87
                );

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
                margin-bottom: 25px;
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
                    20px
                    auto
                    auto;
            }

            h1 {
                font-size: 2rem;
            }

            .subtitle {
                font-size: 0.8rem;
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
                    {{ $ar
                        ? 'العودة للرئيسية'
                        : 'Back to home'
                    }}
                </span>
            </a>

        </div>


        <div class="form-shell">

            <span class="eyebrow">

                <span class="eyebrow-dot"></span>

                {{ $ar
                    ? 'ابدأ مع جسر'
                    : 'Start with Jisr'
                }}

            </span>


            <h1>
                {{ $ar
                    ? 'أنشئ حسابك.'
                    : 'Create Your Account.'
                }}
            </h1>


            <p class="subtitle">
                {{ $ar
                    ? 'ملف واحد يساعدك على اكتشاف فرص التعليم والعمل المناسبة لك.'
                    : 'One profile to discover education and career opportunities that fit you.'
                }}
            </p>


            <div
                id="globalAlert"
                class="alert"
            ></div>


            <form
                id="registerForm"
                novalidate
            >

                {{-- FULL NAME --}}
                <div class="form-group">

                    <label for="full_name">
                        {{ $ar
                            ? 'الاسم الكامل'
                            : 'Full Name'
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
                            <circle
                                cx="12"
                                cy="8"
                                r="4"
                            />

                            <path
                                d="
                                    M4 21
                                    c0-4 3.6-6 8-6
                                    s8 2 8 6
                                "
                            />
                        </svg>

                        <input
                            type="text"
                            id="full_name"
                            name="full_name"
                            placeholder="{{ $ar ? 'اسمك الكامل' : 'Your full name' }}"
                            autocomplete="name"
                            required
                        >

                    </div>

                    <div
                        class="field-error"
                        id="err_full_name"
                    ></div>

                </div>


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
                            type="email"
                            id="email"
                            name="email"
                            placeholder="you@example.com"
                            autocomplete="email"
                            required
                        >

                    </div>

                    <div
                        class="field-error"
                        id="err_email"
                    ></div>

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
                            placeholder="{{ $ar ? '8 أحرف على الأقل' : 'At least 8 characters' }}"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-eye"
                            data-target="password"
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

                    <div
                        class="field-error"
                        id="err_password"
                    ></div>

                </div>


                {{-- CONFIRM PASSWORD --}}
                <div class="form-group">

                    <label for="password_confirmation">
                        {{ $ar
                            ? 'تأكيد كلمة المرور'
                            : 'Confirm Password'
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
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="{{ $ar ? 'أعد إدخال كلمة المرور' : 'Re-enter password' }}"
                            autocomplete="new-password"
                            required
                        >

                        <button
                            type="button"
                            class="toggle-eye"
                            data-target="password_confirmation"
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

                    <div
                        class="field-error"
                        id="err_password_confirmation"
                    ></div>

                </div>


                <button
                    type="submit"
                    class="signup-btn"
                    id="signupBtn"
                >
                    {{ $ar
                        ? 'إنشاء الحساب'
                        : 'Create Account'
                    }}
                </button>

            </form>


            <div class="form-footer">

                {{ $ar
                    ? 'لديك حساب بالفعل؟'
                    : 'Already have an account?'
                }}

                <a href="{{ route('login') }}">
                    {{ $ar
                        ? 'تسجيل الدخول'
                        : 'Log In'
                    }}
                </a>

            </div>

        </div>

    </section>


    {{-- VISUAL SIDE --}}
    <aside class="visual-side">

        <img
            src="{{ asset('images/opportunities/jisr-jobs.png') }}"
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
                    ? 'ملف واحد. فرص أكثر وضوحاً.'
                    : 'One Profile. A Clearer Path Forward.'
                }}
            </h2>

            <p>
                {{ $ar
                    ? 'أنشئ ملفك، ارفع سيرتك، ودع جسر يساعدك على اكتشاف المنح والوظائف الأقرب لمهاراتك وطموحك.'
                    : 'Create your profile, upload your CV, and let Jisr connect you with scholarships and jobs aligned with your goals.'
                }}
            </p>

        </div>

    </aside>

</div>


<script>
    const API_BASE_URL = "{{ url('/api') }}";
    const LOGIN_URL = "{{ route('login') }}";
    const IS_ARABIC = {{ $ar ? 'true' : 'false' }};


    /*
    |--------------------------------------------------------------------------
    | Password visibility
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.toggle-eye')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const input =
                        document.getElementById(
                            button.dataset.target
                        );

                    input.type =
                        input.type === 'password'
                            ? 'text'
                            : 'password';
                }
            );

        });


    /*
    |--------------------------------------------------------------------------
    | Validation helpers
    |--------------------------------------------------------------------------
    */

    function clearFieldErrors() {

        document
            .querySelectorAll(
                '.field-error'
            )
            .forEach(
                function (element) {

                    element.textContent =
                        '';

                    element.classList.remove(
                        'show'
                    );
                }
            );


        document
            .querySelectorAll(
                '.input-wrap input'
            )
            .forEach(
                function (element) {

                    element.classList.remove(
                        'invalid'
                    );
                }
            );
    }


    function showFieldError(
        field,
        message
    ) {

        const errorElement =
            document.getElementById(
                'err_' + field
            );

        const inputElement =
            document.getElementById(
                field
            );


        if (errorElement) {

            errorElement.textContent =
                message;

            errorElement.classList.add(
                'show'
            );
        }


        if (inputElement) {

            inputElement.classList.add(
                'invalid'
            );
        }
    }


    function showAlert(
        message,
        type
    ) {

        const alertBox =
            document.getElementById(
                'globalAlert'
            );

        alertBox.textContent =
            message;

        alertBox.className =
            'alert ' +
            (
                type === 'success'
                    ? 'alert-success'
                    : 'alert-error'
            );

        alertBox.style.display =
            'block';
    }


    function validateClientSide(
        values
    ) {

        const errors = {};


        if (
            !values.full_name.trim()
        ) {

            errors.full_name =
                IS_ARABIC
                    ? 'الاسم الكامل مطلوب.'
                    : 'Full name is required.';
        }


        if (
            !/^\S+@\S+\.\S+$/.test(
                values.email
            )
        ) {

            errors.email =
                IS_ARABIC
                    ? 'أدخل بريداً إلكترونياً صحيحاً.'
                    : 'Enter a valid email address.';
        }


        if (
            values.password.length < 8
        ) {

            errors.password =
                IS_ARABIC
                    ? 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.'
                    : 'Password must be at least 8 characters long.';
        }


        if (
            values.password !==
            values.password_confirmation
        ) {

            errors.password_confirmation =
                IS_ARABIC
                    ? 'تأكيد كلمة المرور غير متطابق.'
                    : 'Password confirmation does not match.';
        }


        return errors;
    }


    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */

    document
        .getElementById(
            'registerForm'
        )
        .addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();


                const signupBtn =
                    document.getElementById(
                        'signupBtn'
                    );

                const alertBox =
                    document.getElementById(
                        'globalAlert'
                    );


                alertBox.style.display =
                    'none';

                clearFieldErrors();


                const values = {

                    full_name:
                        document
                            .getElementById(
                                'full_name'
                            )
                            .value,

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
                            .value,

                    password_confirmation:
                        document
                            .getElementById(
                                'password_confirmation'
                            )
                            .value
                };


                /*
                 * Client-side validation
                 */

                const clientErrors =
                    validateClientSide(
                        values
                    );


                if (
                    Object.keys(
                        clientErrors
                    ).length > 0
                ) {

                    Object
                        .entries(
                            clientErrors
                        )
                        .forEach(
                            function (
                                [field, message]
                            ) {

                                showFieldError(
                                    field,
                                    message
                                );
                            }
                        );


                    return;
                }


                signupBtn.disabled =
                    true;

                signupBtn.textContent =
                    IS_ARABIC
                        ? 'جارٍ إنشاء الحساب...'
                        : 'Creating account...';


                try {

                    const response =
                        await fetch(
                            `${API_BASE_URL}/register`,
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
                                        values
                                    )
                            }
                        );


                    const data =
                        await response.json();


                    /*
                     * Successful registration
                     */

                    if (response.ok) {

                        showAlert(
                            IS_ARABIC
                                ? 'تم إنشاء الحساب بنجاح. سيتم تحويلك لتسجيل الدخول.'
                                : 'Account created successfully. Redirecting to login...',
                            'success'
                        );


                        setTimeout(
                            function () {

                                window.location.href =
                                    LOGIN_URL;

                            },
                            900
                        );

                    }


                    /*
                     * Laravel validation errors
                     */

                    else if (
                        response.status === 422 &&
                        data.errors
                    ) {

                        Object
                            .entries(
                                data.errors
                            )
                            .forEach(
                                function (
                                    [field, messages]
                                ) {

                                    showFieldError(
                                        field,
                                        messages[0]
                                    );
                                }
                            );

                    }


                    /*
                     * Other backend error
                     */

                    else {

                        showAlert(
                            data.message ||
                            (
                                IS_ARABIC
                                    ? 'فشل إنشاء الحساب. حاول مرة أخرى.'
                                    : 'Registration failed. Please try again.'
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

                    signupBtn.disabled =
                        false;

                    signupBtn.textContent =
                        IS_ARABIC
                            ? 'إنشاء الحساب'
                            : 'Create Account';
                }
            }
        );
</script>

</body>
</html>

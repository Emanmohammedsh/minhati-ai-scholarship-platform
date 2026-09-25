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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@400;500;600&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

    <style>
        /* أشياء خاصة بهاي الصفحة فقط، وكلها من متغيرات الـ theme */

        .brand img{
            width:44px;height:44px;
            object-fit:contain;
            border-radius:var(--radius);
        }
        .brand-info strong{display:block;font-size:var(--fs-lg);line-height:1.2}
        .brand-info span{
            display:block;
            font-family:var(--font);
            font-size:11px;
            font-weight:400;
            color:var(--text-faint);
            direction:ltr;
        }

        .top-actions{display:flex;align-items:center;gap:var(--sp-3)}

        .language-switcher{
            display:flex;align-items:center;gap:var(--sp-2);
            direction:ltr;
            background:var(--surface-2);
            border:1px solid var(--border);
            border-radius:var(--radius);
            padding:.4rem .8rem;
            font-size:var(--fs-xs);
            font-weight:600;
        }
        .language-switcher a{color:var(--text-faint);text-decoration:none;transition:color var(--ease)}
        .language-switcher a:hover{color:var(--accent)}
        .language-switcher a.active{color:var(--text)}
        .language-switcher span{color:var(--surface-3)}

        .logout-btn{padding:.5rem 1rem;font-size:var(--fs-sm)}

        .page{
            width:min(1120px,calc(100% - 40px));
            margin:0 auto;
            padding:var(--sp-8) 0 4rem;
        }

        .intro{text-align:center;max-width:720px;margin:0 auto 2.5rem}
        .intro-badge{
            display:inline-flex;align-items:center;gap:var(--sp-2);
            direction:ltr;
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:var(--radius-pill);
            padding:.4rem .9rem;
            font-size:var(--fs-xs);
            font-weight:600;
            margin-bottom:var(--sp-4);
        }
        .intro-badge .dot{
            width:8px;height:8px;border-radius:50%;
            background:var(--accent);
            box-shadow:0 0 12px var(--accent);
        }
        .intro h1{margin-bottom:var(--sp-3)}
        .intro p{color:var(--text-muted);font-size:var(--fs-base);line-height:1.8}
        .user-welcome{margin-top:var(--sp-3);color:var(--link);font-size:var(--fs-sm);font-weight:600}

        .paths{display:grid;grid-template-columns:repeat(2,1fr);gap:var(--sp-6)}

        .path-card{
            display:flex;flex-direction:column;
            margin-bottom:0;
            text-align:start;
            transition:transform .25s ease,border-color .25s ease;
        }
        .path-card:hover{transform:translateY(-6px);border-color:rgba(56,223,234,.5)}

        .card-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:var(--sp-6)}
        .icon-box{
            width:60px;height:60px;
            border-radius:var(--radius-lg);
            display:flex;align-items:center;justify-content:center;
            background:var(--surface-3);
            color:var(--accent);
        }
        .icon-box svg{width:28px;height:28px;stroke:currentColor;fill:none;stroke-width:1.8}
        .path-number{color:var(--text-faint);font-family:var(--font-head);font-size:var(--fs-sm);font-weight:600}

        .path-label{
            display:inline-block;direction:ltr;
            color:var(--accent);
            font-size:var(--fs-xs);font-weight:700;
            letter-spacing:.5px;
            margin-bottom:var(--sp-2);
        }
        .career .path-label{color:var(--primary)}

        .path-card h2{margin-bottom:var(--sp-1)}
        .path-card h3{color:var(--link);margin-bottom:var(--sp-3)}
        .description{color:var(--text-muted);font-size:var(--fs-sm);line-height:1.8;margin-bottom:var(--sp-6)}

        .features{display:grid;gap:var(--sp-3);margin-bottom:var(--sp-8)}
        .feature{display:flex;align-items:center;gap:var(--sp-3);font-size:var(--fs-sm);color:var(--text-muted)}
        .check{
            flex:0 0 24px;width:24px;height:24px;
            border-radius:var(--radius-sm);
            display:flex;align-items:center;justify-content:center;
            background:var(--ok-bg);color:var(--ok);
            font-family:Arial,sans-serif;font-size:var(--fs-xs);font-weight:700;
        }

        .path-card .btn-primary{margin-top:auto;min-height:52px}
        .arrow{display:inline-block}

        .bottom-message{
            margin-top:var(--sp-8);
            display:flex;justify-content:space-between;align-items:center;gap:var(--sp-6);
            padding:var(--sp-6) var(--sp-8);
        }
        .bottom-message strong{display:block;font-size:var(--fs-lg);margin-bottom:var(--sp-1)}
        .bottom-message p{color:var(--text-muted);font-size:var(--fs-sm);line-height:1.7}
        .bottom-tag{
            direction:ltr;white-space:nowrap;
            color:var(--accent);
            font-size:var(--fs-xs);letter-spacing:1px;
        }

        @media (max-width:800px){
            .paths{grid-template-columns:1fr}
            .bottom-message{flex-direction:column;text-align:center}
        }
        @media (max-width:550px){
            .brand-info span{display:none}
            .top-actions{gap:var(--sp-2)}
            .logout-btn{padding:.4rem .7rem;font-size:var(--fs-xs)}
            .page{width:calc(100% - 26px);padding-top:var(--sp-6)}
        }
    </style>
</head>

<body>

<header class="topbar">
  <button id="themeToggleBtn" class="theme-toggle-btn" type="button" title="Dark / Light">🌙</button>

    <a href="/choose-path" class="brand">
        <img src="/images/jisr-logo.jpeg" alt="Jisr AI Logo">
        <div class="brand-info">
            <strong>Jisr AI</strong>
            <span>FROM EDUCATION TO EMPLOYMENT</span>
        </div>
    </a>

    <div class="top-actions">
        <div class="language-switcher">
            <a href="{{ route('language.switch', 'ar') }}" class="{{ app()->getLocale() === 'ar' ? 'active' : '' }}">AR</a>
            <span>|</span>
            <a href="{{ route('language.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>

        <button type="button" class="btn-secondary logout-btn" onclick="logout()">
            {{ __('common.logout') }}
        </button>
    </div>

</header>

<main class="page">

    <!-- INTRO -->
    <section class="intro">
        <div class="intro-badge">
            <span class="dot"></span>
            Jisr AI · Your Opportunity Journey
        </div>

        <h1>{{ __('common.choose_path_heading') }}</h1>
        <p>{{ __('common.choose_path_description') }}</p>

        <div class="user-welcome" id="userWelcome">
            {{ __('common.welcome') }}
        </div>
    </section>

    <!-- PATHS -->
    <section class="paths">

        <!-- EDUCATION PATH -->
        <article class="card path-card education">

            <div class="card-top">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 9l9-5 9 5-9 5-9-5z"/>
                        <path d="M7 12v5c3 2 7 2 10 0v-5"/>
                    </svg>
                </div>
                <div class="path-number">01</div>
            </div>

            <span class="path-label">EDUCATION PATH</span>

            <h2>{{ __('common.education_path') }}</h2>
            <h3>{{ __('common.education_heading') }}</h3>
            <p class="description">{{ __('common.education_description') }}</p>

            <div class="features">
                <div class="feature"><span class="check">✓</span>{{ __('common.scholarship_matching') }}</div>
                <div class="feature"><span class="check">✓</span>{{ __('common.match_explanation') }}</div>
                <div class="feature"><span class="check">✓</span>{{ __('common.gap_analysis') }}</div>
                <div class="feature"><span class="check">✓</span>{{ __('common.application_tracking') }}</div>
            </div>

            <a href="/dashboard" class="btn-primary btn-block">
                {{ __('common.start_education') }}
                <span class="arrow">{{ app()->getLocale() === 'ar' ? '←' : '→' }}</span>
            </a>

        </article>

        <!-- CAREER PATH -->
        <article class="card path-card career">

            <div class="card-top">
                <div class="icon-box">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="7" width="18" height="13" rx="2"/>
                        <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        <path d="M3 12h18"/>
                    </svg>
                </div>
                <div class="path-number">02</div>
            </div>

            <span class="path-label">CAREER PATH</span>

            <h2>{{ __('common.career_path') }}</h2>
            <h3>{{ __('common.career_heading') }}</h3>
            <p class="description">{{ __('common.career_description') }}</p>

            <div class="features">
                <div class="feature"><span class="check">✓</span>{{ __('common.job_matching_profile') }}</div>
                <div class="feature"><span class="check">✓</span>{{ __('common.ai_job_matching') }}</div>
                <div class="feature"><span class="check">✓</span>{{ __('common.skill_gap_analysis') }}</div>
                <div class="feature"><span class="check">✓</span>{{ __('common.job_application_tracking') }}</div>
            </div>

            <a href="/jobs/dashboard" class="btn-primary btn-block">
                {{ __('common.start_career') }}
                <span class="arrow">{{ app()->getLocale() === 'ar' ? '←' : '→' }}</span>
            </a>

        </article>

    </section>

    <!-- BOTTOM MESSAGE -->
    <section class="card bottom-message">
        <div>
            <strong>{{ __('common.one_bridge_more_opportunities') }}</strong>
            <p>{{ __('common.brand_message') }}</p>
        </div>
        <div class="bottom-tag">JISR AI · A BRIGHTER TOMORROW</div>
    </section>

</main>

<script>
    /* Authentication */
    const token = localStorage.getItem('auth_token');

    if (!token) {
        window.location.replace('/login');
    }

    /* User Information */
    const storedUser = localStorage.getItem('auth_user');

    if (storedUser) {
        try {
            const user = JSON.parse(storedUser);

            if (user && user.full_name) {
                const welcomeTemplate = @json(__('common.welcome_user', [
                    'name' => '__USER_NAME__'
                ]));

                document.getElementById('userWelcome').textContent =
                    welcomeTemplate.replace('__USER_NAME__', user.full_name);
            }
        } catch (error) {
            console.error('Could not read user information.', error);
        }
    }

    /* Logout */
    async function logout() {
        try {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });
        } catch (error) {
            console.error(error);
        }

        localStorage.removeItem('auth_token');
        localStorage.removeItem('auth_user');

        window.location.href = '/login';
    }
</script>

<script>
  if (localStorage.getItem('jisr_theme') === 'dark') {
    document.body.classList.add('theme-dark');
  }
  function applyTheme(theme) {
    document.body.classList.toggle('theme-dark', theme === 'dark');
    localStorage.setItem('jisr_theme', theme);
    const toggleBtn = document.getElementById('themeToggleBtn');
    if (toggleBtn) toggleBtn.textContent = theme === 'dark' ? '☀️' : '🌙';
  }
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('themeToggleBtn');
    if (btn) {
      btn.textContent = document.body.classList.contains('theme-dark') ? '☀️' : '🌙';
      btn.addEventListener('click', () => {
        const isDark = document.body.classList.contains('theme-dark');
        applyTheme(isDark ? 'light' : 'dark');
      });
    }
  });
</script>
</body>
</html>
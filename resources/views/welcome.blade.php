<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0A2E6B">
    <title>Jisr AI | جسر</title>

    <script>
        (() => {
            const saved = localStorage.getItem('jisr-theme');
            const theme = saved || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.dataset.theme = theme;
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --navy:#0A2E6B; --blue:#0877F9; --cyan:#00C6FF; --accent:#87DFFF;
            --bg:#F7FBFF; --surface:#FFFFFF; --soft:#EAF6FF; --text:#102A43;
            --muted:#64748B; --border:#DCEAF5; --shadow:0 18px 50px rgba(10,46,107,.09);
            --radius:24px;
        }
        html[data-theme="dark"]{
            --bg:#041827; --surface:#08253C; --soft:#0B3553; --text:#F6FBFF;
            --muted:#A9BDCF; --border:#194761; --shadow:0 20px 55px rgba(0,0,0,.28);
        }
        *{box-sizing:border-box}
        html{scroll-behavior:smooth;overflow-x:hidden}
        body{margin:0;background:var(--bg);color:var(--text);font-family:'Poppins',sans-serif;overflow-x:hidden}
        html[dir="rtl"] body{font-family:'Tajawal',sans-serif}
        img{max-width:100%;display:block}
        a{text-decoration:none;color:inherit}
        button,a{font:inherit}
        .container{width:min(1160px,calc(100% - 40px));margin-inline:auto}
        .eyebrow{display:inline-flex;align-items:center;gap:8px;padding:7px 12px;border:1px solid color-mix(in srgb,var(--cyan) 38%,var(--border));border-radius:999px;background:color-mix(in srgb,var(--soft) 80%,transparent);color:var(--navy);font-size:.76rem;font-weight:800}
        html[data-theme="dark"] .eyebrow{color:#C9F4FF}
        .btn{min-height:46px;padding:0 20px;border-radius:13px;display:inline-flex;align-items:center;justify-content:center;gap:8px;border:1px solid transparent;font-weight:700;font-size:.88rem;transition:.18s ease;cursor:pointer}
        .btn:hover{transform:translateY(-2px)}
        .btn-primary{background:linear-gradient(135deg,var(--blue),var(--cyan));color:#fff;box-shadow:0 10px 25px rgba(8,119,249,.22)}
        .btn-ghost{background:var(--surface);border-color:var(--border);color:var(--text)}
        .arrow{font-size:1.05em}
        html[dir="rtl"] .arrow{transform:rotate(180deg)}

        /* Navigation */
        .nav-wrap{position:sticky;top:0;z-index:100;background:color-mix(in srgb,var(--bg) 88%,transparent);backdrop-filter:blur(18px);border-bottom:1px solid color-mix(in srgb,var(--border) 72%,transparent)}
        .nav{height:74px;display:flex;align-items:center;gap:24px}
       .logo-shell {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: transparent;
    border-radius: 0;
    padding: 0;
    flex: 0 0 auto;
}

.brand-logo {
    width: 120px;
    height: 46px;
    object-fit: contain;
}

.logo-dark {
    display: none;
}

html[data-theme="light"] .logo-light {
    display: block;
}

html[data-theme="light"] .logo-dark {
    display: none;
}

html[data-theme="dark"] .logo-light {
    display: none;
}

html[data-theme="dark"] .logo-dark {
    display: block;
}
        .logo{width:112px;height:44px;object-fit:contain}
.brand-logo {
    width: 120px;
    height: 46px;
    object-fit: contain;
}

.logo-dark {
    display: none;
}

/* نخلي محتوى اللوجو الداكن أكبر بصريًا */
html[data-theme="dark"] .logo-dark {
    display: block;
    width: 132px;
    height: 50px;
}

html[data-theme="dark"] .logo-light {
    display: none;
}

html[data-theme="light"] .logo-light {
    display: block;
}

html[data-theme="light"] .logo-dark {
    display: none;
}

/* Light Mode */
html[data-theme="light"] .logo-light {
    display: block;
}

html[data-theme="light"] .logo-dark {
    display: none;
}

/* Dark Mode */
html[data-theme="dark"] .logo-light {
    display: none;
}

html[data-theme="dark"] .logo-dark {
    display: block;
}
        .nav-links{display:flex;align-items:center;gap:26px;margin-inline:auto}
        .nav-links a{font-size:.83rem;font-weight:600;color:var(--muted);transition:.15s}
        .nav-links a:hover,.nav-links a.active{color:var(--blue)}
        .nav-actions{display:flex;align-items:center;gap:8px}
        .lang{font-size:.8rem;font-weight:800;color:var(--text);padding:8px}
        .icon-btn{width:42px;height:42px;border-radius:12px;border:1px solid var(--border);background:var(--surface);color:var(--text);display:grid;place-items:center;cursor:pointer}
        .menu-btn{display:none}

        /* Hero */
        .hero{padding:30px 0 34px}
        .hero-card{position:relative;min-height:545px;border:1px solid var(--border);border-radius:30px;overflow:hidden;background:var(--surface);box-shadow:var(--shadow)}
        .hero-image{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center}
        .hero-image.dark{display:none}
        html[data-theme="dark"] .hero-image.light{display:none}
        html[data-theme="dark"] .hero-image.dark{display:block}
        .hero-overlay{position:absolute;inset:0;background:linear-gradient(90deg,var(--surface) 4%,color-mix(in srgb,var(--surface) 96%,transparent) 40%,color-mix(in srgb,var(--surface) 58%,transparent) 60%,transparent 82%)}
        html[dir="rtl"] .hero-overlay{background:linear-gradient(-90deg,var(--surface) 4%,color-mix(in srgb,var(--surface) 96%,transparent) 40%,color-mix(in srgb,var(--surface) 58%,transparent) 60%,transparent 82%)}
        .hero-copy{position:relative;z-index:2;width:57%;padding:66px 58px 150px}
        .hero h1{font-size:clamp(2.8rem,5.3vw,5.2rem);line-height:.98;letter-spacing:-.055em;margin:18px 0 18px;max-width:650px}
        html[dir="rtl"] .hero h1{letter-spacing:0;line-height:1.08}
        .hero h1 span{color:var(--blue)}
        .hero p{max-width:575px;margin:0 0 26px;color:var(--muted);font-size:1rem;line-height:1.8}
        .hero-actions{display:flex;gap:11px;flex-wrap:wrap}
        .hero-proof{position:absolute;z-index:3;inset-inline:24px;bottom:22px;display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
        .proof{display:flex;align-items:center;gap:11px;padding:13px 14px;border:1px solid var(--border);border-radius:16px;background:color-mix(in srgb,var(--surface) 93%,transparent);backdrop-filter:blur(12px)}
        .proof-icon{width:39px;height:39px;flex:0 0 39px;border-radius:12px;background:var(--soft);display:grid;place-items:center;color:var(--blue);font-weight:800}
        .proof strong{display:block;font-size:.8rem}.proof small{display:block;color:var(--muted);font-size:.68rem;margin-top:2px}

        /* Sections */
        section.block{padding:42px 0}
        .section-head{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:22px}
        .section-head h2{font-size:clamp(1.7rem,3vw,2.35rem);line-height:1.2;margin:8px 0 5px;letter-spacing:-.03em}
        html[dir="rtl"] .section-head h2{letter-spacing:0}
        .section-head p{margin:0;color:var(--muted);line-height:1.65}

        /* Paths */
        .paths{display:grid;grid-template-columns:1fr 1fr;gap:18px}
        .path{position:relative;min-height:330px;border:1px solid var(--border);border-radius:26px;overflow:hidden;background:var(--surface);box-shadow:var(--shadow)}
        .path-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
        .path:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,var(--surface) 10%,color-mix(in srgb,var(--surface) 94%,transparent) 48%,color-mix(in srgb,var(--surface) 30%,transparent) 78%,transparent)}
        html[dir="rtl"] .path:after{background:linear-gradient(-90deg,var(--surface) 10%,color-mix(in srgb,var(--surface) 94%,transparent) 48%,color-mix(in srgb,var(--surface) 30%,transparent) 78%,transparent)}
        .path-copy{position:relative;z-index:2;width:61%;padding:30px}
        .path-icon{width:48px;height:48px;object-fit:contain;margin-bottom:15px}
        .path h3{font-size:1.3rem;margin:0 0 8px}.path p{font-size:.85rem;color:var(--muted);line-height:1.65;margin:0 0 18px}

        /* How it works */
        .journey{position:relative;overflow:hidden;border:1px solid var(--border);border-radius:26px;background:var(--surface);box-shadow:var(--shadow);padding:32px}
        .journey-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.1}
        .journey-bg.dark{display:none}html[data-theme="dark"] .journey-bg.light{display:none}html[data-theme="dark"] .journey-bg.dark{display:block}
        .steps{position:relative;display:grid;grid-template-columns:repeat(5,1fr);gap:0}
        .step{position:relative;text-align:center;padding:10px 13px}
        .step:not(:last-child):after{content:"";position:absolute;top:31px;inset-inline-end:-22%;width:44%;height:1px;background:linear-gradient(90deg,var(--border),var(--cyan))}
        html[dir="rtl"] .step:not(:last-child):after{background:linear-gradient(-90deg,var(--border),var(--cyan))}
        .step-num{width:46px;height:46px;margin:0 auto 13px;border-radius:14px;display:grid;place-items:center;background:linear-gradient(145deg,var(--soft),color-mix(in srgb,var(--cyan) 20%,var(--surface)));border:1px solid var(--border);color:var(--blue);font-weight:800}
        .step strong{display:block;font-size:.82rem}.step span{display:block;color:var(--muted);font-size:.7rem;line-height:1.5;margin-top:4px}

        /* Why */
        .why-layout{display:grid;grid-template-columns:.9fr 1.1fr;gap:18px}
        .why-main{border:1px solid var(--border);border-radius:26px;background:linear-gradient(145deg,var(--surface),var(--soft));padding:32px}
        .why-main h2{font-size:2rem;margin:12px 0 10px}.why-main p{color:var(--muted);line-height:1.75;margin:0 0 20px}
        .features{display:grid;grid-template-columns:1fr 1fr;gap:12px}
        .feature{border:1px solid var(--border);border-radius:20px;background:var(--surface);padding:20px;min-height:145px}
        .feature-icon{width:42px;height:42px;border-radius:13px;background:var(--soft);display:grid;place-items:center;color:var(--blue);font-weight:800;margin-bottom:13px}
        .feature strong{font-size:.86rem}.feature p{margin:5px 0 0;color:var(--muted);font-size:.74rem;line-height:1.55}

        /* CTA */
        .cta{position:relative;min-height:245px;border:1px solid var(--border);border-radius:28px;overflow:hidden;background:var(--surface);box-shadow:var(--shadow);display:flex;align-items:center;padding:38px}
        .cta-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}.cta-bg.dark{display:none}html[data-theme="dark"] .cta-bg.light{display:none}html[data-theme="dark"] .cta-bg.dark{display:block}
        .cta:after{content:"";position:absolute;inset:0;background:linear-gradient(90deg,var(--surface) 5%,color-mix(in srgb,var(--surface) 93%,transparent) 48%,transparent 82%)}
        html[dir="rtl"] .cta:after{background:linear-gradient(-90deg,var(--surface) 5%,color-mix(in srgb,var(--surface) 93%,transparent) 48%,transparent 82%)}
        .cta-copy{position:relative;z-index:2;max-width:540px}.cta h2{font-size:2rem;margin:0 0 8px}.cta p{color:var(--muted);line-height:1.7;margin:0 0 18px}

        footer{padding:25px 0 34px}.footer{border-top:1px solid var(--border);padding-top:22px;display:flex;align-items:center;justify-content:space-between;gap:20px;color:var(--muted);font-size:.75rem}
        .footer .logo{width:98px;height:38px}

        @media(max-width:920px){
            .nav-links{display:none}.menu-btn{display:grid}.login-link{display:none}
            .nav-links.open{display:flex;position:absolute;top:68px;inset-inline:20px;flex-direction:column;align-items:stretch;background:var(--surface);border:1px solid var(--border);border-radius:18px;padding:14px;box-shadow:var(--shadow)}
            .nav-links.open a{padding:10px}
            .hero-copy{width:70%}.paths{grid-template-columns:1fr}.steps{grid-template-columns:repeat(3,1fr);gap:10px}.step:after{display:none}.why-layout{grid-template-columns:1fr}
        }
        @media(max-width:680px){
            .container{width:min(100% - 24px,1160px)}.nav{height:66px;gap:7px}.logo{width:92px;height:38px}.nav-actions .btn{display:none}.lang{padding:6px}
            .hero{padding:14px 0 24px}.hero-card{min-height:720px;border-radius:22px}.hero-image{height:44%;top:auto;object-position:center}
            .hero-overlay{background:linear-gradient(180deg,var(--surface) 0%,var(--surface) 48%,color-mix(in srgb,var(--surface) 92%,transparent) 61%,transparent 78%)!important}
            .hero-copy{width:100%;padding:30px 20px 0}.hero h1{font-size:2.55rem}.hero p{font-size:.9rem;line-height:1.7}.hero-actions .btn{flex:1}
            .hero-proof{inset-inline:10px;bottom:10px;grid-template-columns:1fr}.proof{padding:9px 11px}.proof small{display:none}
            section.block{padding:30px 0}.section-head{display:block}.section-head h2{font-size:1.65rem}
            .path{min-height:300px;border-radius:22px}.path-copy{width:72%;padding:22px}.path h3{font-size:1.15rem}
            .journey{padding:20px 10px}.steps{grid-template-columns:1fr 1fr}.step:last-child{grid-column:1/-1}.features{grid-template-columns:1fr}.feature{min-height:auto}
            .why-main{padding:24px}.cta{min-height:285px;padding:26px 20px}.cta-copy{max-width:78%}.cta h2{font-size:1.65rem}.footer{flex-direction:column;align-items:flex-start}
        }
    </style>
</head>
<body>
@php($ar = app()->getLocale() === 'ar')

<header class="nav-wrap">
    <div class="container nav">
        <a class="logo-shell" href="{{ url('/') }}" aria-label="Jisr AI home">
            <img
    src="{{ asset('images/brand/jisr-logo-official.png') }}"
    alt="Jisr AI | جسر"
    class="brand-logo logo-light"
>

<img
    src="{{ asset('images/brand/jisr-logo-dark.png') }}"
    alt="Jisr AI | جسر"
    class="brand-logo logo-dark"
>
        </a>

        <nav class="nav-links" id="mainNav" aria-label="{{ $ar ? 'التنقل الرئيسي' : 'Main navigation' }}">
            <a class="active" href="#home">{{ $ar ? 'الرئيسية' : 'Home' }}</a>
            <a href="#paths">{{ $ar ? 'الفرص' : 'Opportunities' }}</a>
            <a href="#how">{{ $ar ? 'كيف يعمل' : 'How It Works' }}</a>
            <a href="#why">{{ $ar ? 'عن جسر' : 'About' }}</a>
        </nav>

        <div class="nav-actions">
            <a class="lang" href="{{ route('language.switch', $ar ? 'en' : 'ar') }}">{{ $ar ? 'EN' : 'عربي' }}</a>
            <button class="icon-btn" id="themeToggle" type="button" aria-label="{{ $ar ? 'تغيير المظهر' : 'Toggle theme' }}"><span id="themeIcon">☾</span></button>
            <a class="btn btn-ghost login-link" href="{{ route('login') }}">{{ $ar ? 'دخول' : 'Login' }}</a>
            <a class="btn btn-primary" href="{{ route('register') }}">{{ $ar ? 'ابدأ الآن' : 'Get Started' }} <span class="arrow">→</span></a>
            <button class="icon-btn menu-btn" id="mobileToggle" type="button" aria-label="{{ $ar ? 'القائمة' : 'Menu' }}">☰</button>
        </div>
    </div>
</header>

<main id="home">
    <section class="hero">
        <div class="container hero-card">
            <img class="hero-image light" src="{{ asset('images/hero/jisr-hero-light.png') }}" alt="" fetchpriority="high">
            <img class="hero-image dark" src="{{ asset('images/hero/jisr-hero-dark.png') }}" alt="" fetchpriority="high">
            <div class="hero-overlay"></div>

            <div class="hero-copy">
                <span class="eyebrow">✦ {{ $ar ? 'من التعليم إلى العمل، في مكان واحد' : 'From Education to Career, in One Place' }}</span>
                <h1>{!! $ar ? 'جسر إلى <span>مستقبلك</span>' : 'A Bridge to <span>Your Future</span>' !!}</h1>
                <p>{{ $ar ? 'اكتشف المنح والوظائف المناسبة لملفك، افهم سبب المطابقة، واعرف خطوتك التالية بوضوح.' : 'Discover scholarships and jobs that fit your profile, understand why they match, and know your next step.' }}</p>
                <div class="hero-actions">
                    <a class="btn btn-primary" href="{{ route('register') }}">{{ $ar ? 'ابدأ رحلتك' : 'Start Your Journey' }} <span class="arrow">→</span></a>
                    <a class="btn btn-ghost" href="#paths">{{ $ar ? 'استكشف الفرص' : 'Explore Opportunities' }}</a>
                </div>
            </div>

            <div class="hero-proof">
                <div class="proof"><div class="proof-icon">⌁</div><div><strong>{{ $ar ? 'مطابقة حسب ملفك' : 'Profile-Based Matching' }}</strong><small>{{ $ar ? 'فرص أقرب لمؤهلاتك' : 'Relevant to your qualifications' }}</small></div></div>
                <div class="proof"><div class="proof-icon">◇</div><div><strong>{{ $ar ? 'نتائج مفهومة' : 'Explainable Results' }}</strong><small>{{ $ar ? 'اعرف أسباب المطابقة والفجوات' : 'Understand matches and gaps' }}</small></div></div>
                <div class="proof"><div class="proof-icon">✓</div><div><strong>{{ $ar ? 'منصة واحدة' : 'One Journey' }}</strong><small>{{ $ar ? 'اكتشف، جهّز، وتابع' : 'Discover, prepare, and track' }}</small></div></div>
            </div>
        </div>
    </section>

    <section class="block" id="paths">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="eyebrow">{{ $ar ? 'اختر هدفك' : 'Choose Your Path' }}</span>
                    <h2>{{ $ar ? 'مساران. تجربة واحدة بسيطة.' : 'Two Paths. One Simple Experience.' }}</h2>
                    <p>{{ $ar ? 'ابدأ من هدفك الحالي، وجسر يساعدك على الوصول للفرص الأنسب.' : 'Start with your current goal and let Jisr guide you to relevant opportunities.' }}</p>
                </div>
            </div>

            <div class="paths">
                <article class="path">
                    <img class="path-bg" src="{{ asset('images/opportunities/jisr-scholarships.png') }}" alt="" loading="lazy">
                    <div class="path-copy">
                        <img class="path-icon" src="{{ asset('images/illustrations/jisr-icon-scholarships.png') }}" alt="">
                        <h3>{{ $ar ? 'مسار التعليم' : 'Education Path' }}</h3>
                        <p>{{ $ar ? 'اكتشف المنح التي تتوافق مع ملفك الأكاديمي ومؤهلاتك، وافهم متطلبات كل فرصة.' : 'Discover scholarships aligned with your academic profile and understand each opportunity.' }}</p>
                        <a class="btn btn-primary" href="{{ route('dashboard') }}">{{ $ar ? 'استكشف المنح' : 'Explore Scholarships' }} <span class="arrow">→</span></a>
                    </div>
                </article>

                <article class="path">
                    <img class="path-bg" src="{{ asset('images/opportunities/jisr-jobs.png') }}" alt="" loading="lazy">
                    <div class="path-copy">
                        <img class="path-icon" src="{{ asset('images/illustrations/jisr-icon-jobs.png') }}" alt="">
                        <h3>{{ $ar ? 'المسار المهني' : 'Career Path' }}</h3>
                        <p>{{ $ar ? 'اكتشف الوظائف المناسبة لمهاراتك وخبراتك، واعرف الفجوات التي يمكنك تطويرها.' : 'Find jobs aligned with your skills and experience, and identify gaps you can improve.' }}</p>
                        <a class="btn btn-ghost" href="{{ route('jobs.dashboard') }}">{{ $ar ? 'استكشف الوظائف' : 'Explore Jobs' }} <span class="arrow">→</span></a>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="block" id="how">
        <div class="container">
            <div class="section-head">
                <div>
                    <span class="eyebrow">{{ $ar ? 'رحلة واضحة' : 'A Clear Journey' }}</span>
                    <h2>{{ $ar ? 'كيف يعمل Jisr AI؟' : 'How Jisr AI Works' }}</h2>
                    <p>{{ $ar ? 'خمس خطوات واضحة من ملفك إلى فرصة يمكنك التقدم لها.' : 'Five clear steps from your profile to an opportunity you can act on.' }}</p>
                </div>
            </div>

            <div class="journey">
                <img class="journey-bg light" src="{{ asset('images/backgrounds/jisr-how-it-works-light.png') }}" alt="" loading="lazy">
                <img class="journey-bg dark" src="{{ asset('images/backgrounds/jisr-how-it-works-dark.png') }}" alt="" loading="lazy">
                <div class="steps">
                    @foreach(($ar ? [
                        ['أنشئ ملفك','أضف معلوماتك الأساسية.'],
                        ['ارفع سيرتك','استخرج مهاراتك وخبراتك.'],
                        ['اكتشف الفرص','شاهد المطابقات المناسبة.'],
                        ['افهم النتيجة','راجع أسباب المطابقة والفجوات.'],
                        ['جهّز وتابع','حضّر طلبك وتابع تقدمه.']
                    ] : [
                        ['Create Profile','Add your essential information.'],
                        ['Upload CV','Extract your skills and experience.'],
                        ['Discover','See relevant matches.'],
                        ['Understand','Review match reasons and gaps.'],
                        ['Prepare & Track','Get ready and follow progress.']
                    ]) as $i => $step)
                        <div class="step">
                            <div class="step-num">{{ $i + 1 }}</div>
                            <strong>{{ $step[0] }}</strong>
                            <span>{{ $step[1] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="block" id="why">
        <div class="container why-layout">
            <div class="why-main">
                <span class="eyebrow">Jisr AI</span>
                <h2>{{ $ar ? 'مش قائمة فرص. رحلة أوضح.' : 'More Than a List of Opportunities.' }}</h2>
                <p>{{ $ar ? 'بدل التنقل بين الفرص بدون معرفة ما يناسبك، يجمع جسر ملفك وسيرتك مع المطابقة والتحليل وأدوات التجهيز والمتابعة في تجربة واحدة.' : 'Instead of browsing opportunities without knowing what fits, Jisr connects your profile and CV with matching, analysis, preparation, and tracking tools.' }}</p>
                <a class="btn btn-ghost" href="{{ route('choose-path') }}">{{ $ar ? 'اختر مسارك' : 'Choose Your Path' }} <span class="arrow">→</span></a>
            </div>

            <div class="features">
                @foreach(($ar ? [
                    ['⌁','مطابقة مخصصة','تعتمد على بيانات ملفك وسيرتك الذاتية.'],
                    ['◇','تفسير واضح','اعرف لماذا تناسبك الفرصة وما الذي ينقصك.'],
                    ['✦','دعم ذكي','تحليل السيرة ودعم تجهيز محتوى التقديم.'],
                    ['✓','متابعة منظمة','احفظ الفرص وتابع حالة طلباتك.']
                ] : [
                    ['⌁','Personalized Matching','Based on your profile and CV data.'],
                    ['◇','Clear Explanations','See why an opportunity fits and what is missing.'],
                    ['✦','Smart Support','CV analysis and application preparation support.'],
                    ['✓','Organized Tracking','Save opportunities and follow applications.']
                ]) as $feature)
                    <div class="feature">
                        <div class="feature-icon">{{ $feature[0] }}</div>
                        <strong>{{ $feature[1] }}</strong>
                        <p>{{ $feature[2] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="block">
        <div class="container cta">
            <img class="cta-bg light" src="{{ asset('images/backgrounds/jisr-cta-bridge-light.png') }}" alt="" loading="lazy">
            <img class="cta-bg dark" src="{{ asset('images/backgrounds/jisr-cta-bridge-dark.png') }}" alt="" loading="lazy">
            <div class="cta-copy">
                <h2>{{ $ar ? 'خطوتك القادمة تبدأ من هنا.' : 'Your Next Step Starts Here.' }}</h2>
                <p>{{ $ar ? 'أنشئ ملفك مرة واحدة، ثم اكتشف فرص التعليم والعمل المناسبة لك من مكان واحد.' : 'Create your profile once, then discover education and career opportunities from one place.' }}</p>
                <a class="btn btn-primary" href="{{ route('register') }}">{{ $ar ? 'ابدأ الآن' : 'Get Started' }} <span class="arrow">→</span></a>
            </div>
        </div>
    </section>
</main>

<footer>
    <div class="container footer">
        <span class="logo-shell">

    <img
        src="{{ asset('images/brand/jisr-logo-official.png') }}"
        alt="Jisr AI | جسر"
        class="brand-logo logo-light"
    >

    <img
        src="{{ asset('images/brand/jisr-logo-dark.png') }}"
        alt="Jisr AI | جسر"
        class="brand-logo logo-dark"
    >

</span>
        <span>© {{ date('Y') }} Jisr AI — Bridging Talent to Opportunity.</span>
    </div>
</footer>

<script>
    const root = document.documentElement;
    const themeBtn = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const mobileBtn = document.getElementById('mobileToggle');
    const mainNav = document.getElementById('mainNav');

    function paintTheme() {
        themeIcon.textContent = root.dataset.theme === 'dark' ? '☀' : '☾';
    }

    paintTheme();

    themeBtn?.addEventListener('click', () => {
        root.dataset.theme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        localStorage.setItem('jisr-theme', root.dataset.theme);
        paintTheme();
    });

    mobileBtn?.addEventListener('click', () => mainNav?.classList.toggle('open'));
    mainNav?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => mainNav.classList.remove('open')));
</script>
</body>
</html>

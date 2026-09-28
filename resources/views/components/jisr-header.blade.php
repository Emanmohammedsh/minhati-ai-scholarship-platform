<style>
.jisr-site-header{position:sticky;top:0;z-index:9000;width:100%;background:rgba(255,255,255,.94);border-bottom:1px solid rgba(10,46,107,.09);backdrop-filter:blur(18px)}
.jisr-header-inner{width:min(1240px,calc(100% - 40px));min-height:76px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:22px}
.jisr-brand{display:flex;align-items:center;flex:0 0 auto;line-height:0}
.jisr-site-header .jisr-logo{display:block!important;width:132px!important;height:52px!important;max-width:132px!important;max-height:52px!important;object-fit:contain!important}
.jisr-site-header .jisr-logo-dark{display:none!important}
.jisr-nav{display:flex;align-items:center;justify-content:center;gap:5px;flex:1}
.jisr-nav a{color:#173B70;text-decoration:none;padding:9px 12px;border-radius:10px;font:600 13px/1.2 Poppins,Arial,sans-serif;white-space:nowrap}
.jisr-nav a:hover,.jisr-nav a.active{background:#EAF6FF;color:#0878C9}
.jisr-header-actions{display:flex;align-items:center;gap:8px;flex:0 0 auto}
.jisr-lang{display:flex;gap:3px;padding:4px;background:#F3F9FC;border:1px solid #DCEEF8;border-radius:10px}
.jisr-lang a{padding:5px 7px;border-radius:7px;color:#728292;text-decoration:none;font:700 11px/1 Poppins,Arial,sans-serif}
.jisr-lang a.active{background:#fff;color:#0A2E6B}
.jisr-theme-btn,.jisr-logout-btn{min-height:38px;border-radius:10px;font-family:inherit;font-weight:700;cursor:pointer}
.jisr-theme-btn{width:40px;border:1px solid #DCEEF8;background:#F6FBFE;color:#0A2E6B}
.jisr-logout-btn{border:0;background:#0A2E6B;color:#fff;padding:0 14px}
html[data-theme="dark"] .jisr-site-header{background:rgba(7,22,45,.95)}
html[data-theme="dark"] .jisr-site-header .jisr-logo-light{display:none!important}
html[data-theme="dark"] .jisr-site-header .jisr-logo-dark{display:block!important}
html[data-theme="dark"] .jisr-nav a{color:#DCEBFA}
@media(max-width:900px){.jisr-header-inner{width:calc(100% - 24px)}.jisr-nav{display:none}.jisr-site-header .jisr-logo{width:108px!important;height:46px!important;max-width:108px!important}}
@media(max-width:560px){.jisr-lang{display:none}.jisr-site-header .jisr-logo{width:94px!important;height:42px!important;max-width:94px!important}}
</style>
<header class="jisr-site-header"><div class="jisr-header-inner">
<a href="{{ route('dashboard') }}" class="jisr-brand" aria-label="Jisr AI"><img src="{{ asset('images/brand/jisr-logo-official.png') }}" class="jisr-logo jisr-logo-light" alt="Jisr AI"><img src="{{ asset('images/brand/jisr-logo-dark.png') }}" class="jisr-logo jisr-logo-dark" alt="Jisr AI"></a>
<nav class="jisr-nav" aria-label="Main navigation"><a href="{{ route('dashboard') }}" class="active">{{ app()->getLocale()==='ar' ? 'الرئيسية' : 'Home' }}</a><a href="{{ route('choose-path') }}">{{ __('common.switch_path') }}</a><a href="{{ route('profile') }}">{{ __('common.profile') }}</a><a href="{{ route('cv-upload') }}">{{ __('common.my_cv') }}</a></nav>
<div class="jisr-header-actions"><div class="jisr-lang"><a href="{{ route('language.switch','ar') }}" class="{{ app()->getLocale()==='ar' ? 'active' : '' }}">AR</a><a href="{{ route('language.switch','en') }}" class="{{ app()->getLocale()==='en' ? 'active' : '' }}">EN</a></div><button id="themeToggleBtn" class="jisr-theme-btn" type="button"><span>☾</span></button><button id="logoutBtn" class="jisr-logout-btn" type="button">{{ __('common.logout') }}</button></div>
</div></header>
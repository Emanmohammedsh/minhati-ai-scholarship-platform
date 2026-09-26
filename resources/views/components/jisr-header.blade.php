<header class="jisr-site-header">
    <div class="jisr-header-inner">
        <a href="{{ route('dashboard') }}" class="jisr-brand" aria-label="Jisr AI">
            <img src="{{ asset('images/brand/jisr-logo-official.png') }}"
                 class="jisr-logo jisr-logo-light" alt="Jisr AI">
            <img src="{{ asset('images/brand/jisr-logo-dark.png') }}"
                 class="jisr-logo jisr-logo-dark" alt="Jisr AI">
        </a>

        <nav class="jisr-nav" aria-label="Main navigation">
            <a href="{{ route('dashboard') }}" class="active">{{ app()->getLocale()==='ar' ? 'الرئيسية' : 'Home' }}</a>
            <a href="{{ route('choose-path') }}">{{ __('common.switch_path') }}</a>
            <a href="{{ route('profile') }}">{{ __('common.profile') }}</a>
            <a href="{{ route('cv-upload') }}">{{ __('common.my_cv') }}</a>
        </nav>

        <div class="jisr-header-actions">
            <div class="jisr-lang" aria-label="Language">
                <a href="{{ route('language.switch','ar') }}" class="{{ app()->getLocale()==='ar' ? 'active' : '' }}">AR</a>
                <a href="{{ route('language.switch','en') }}" class="{{ app()->getLocale()==='en' ? 'active' : '' }}">EN</a>
            </div>
            <button id="themeToggleBtn" class="jisr-theme-btn" type="button" aria-label="Toggle theme"><span>☾</span></button>
            <button id="logoutBtn" class="jisr-logout-btn" type="button">{{ __('common.logout') }}</button>
        </div>
    </div>
</header>
{{-- Šis izkārtojuma skats veido "legal" kopējo lapas struktūru. --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'FitLife Legal')</title>
    <link rel="icon" href="{{ asset('favicon.PNG') }}" type="image/png">
    <style>html,body{overscroll-behavior:auto}</style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/legal.css') }}">
</head>
<body class="legal-page @yield('body-class')">
    <nav class="legal-nav" id="legalNav">
        <div class="legal-container legal-nav-shell">
            <a href="{{ route('welcome') }}" class="legal-brand" aria-label="FitLife home">
                <img src="{{ asset('storage/logo/fitlife-logo.png') }}" alt="FitLife" class="legal-brand-img">
            </a>

            <ul class="legal-nav-links" id="navLinks">
                <li><a href="{{ route('welcome') }}">{{ __('nav.home') }}</a></li>
                <li><a href="{{ route('welcome') }}#features">{{ __('nav.features') }}</a></li>
                <li><a href="{{ route('welcome') }}#system">{{ __('nav.system') }}</a></li>
                <li><a href="{{ route('welcome') }}#community">{{ __('nav.community') }}</a></li>
                <li><a href="{{ route('privacy-policy') }}" class="{{ request()->routeIs('privacy-policy') ? 'is-active' : '' }}">{{ __('nav.privacy') }}</a></li>
                <li><a href="{{ route('terms-of-service') }}" class="{{ request()->routeIs('terms-of-service') ? 'is-active' : '' }}">{{ __('nav.terms') }}</a></li>
            </ul>

            <div class="legal-nav-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="legal-nav-button legal-nav-button--primary">{{ __('nav.dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="legal-nav-button legal-nav-button--ghost">{{ __('auth.log_in') }}</a>
                    <a href="{{ route('register') }}" class="legal-nav-button legal-nav-button--primary">{{ __('auth.register_cta') }}</a>
                @endauth
            </div>

            <button class="legal-mobile-menu" id="mobileMenu" type="button" aria-label="Toggle navigation" aria-controls="navLinks" aria-expanded="false">
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <header class="legal-hero">
        <div class="legal-container legal-hero-grid">
            <div class="legal-hero-copy">
                <span class="legal-kicker">@yield('kicker', __('legal.kicker'))</span>
                <h1 class="legal-title">@yield('hero-title')</h1>
                <p class="legal-subtitle">@yield('hero-subtitle')</p>

                <div class="legal-meta">
                    <span>{{ __('legal.last_updated') }}: @yield('updated-date')</span>
                    <span>@yield('meta-note', __('legal.meta_default'))</span>
                </div>
            </div>

            <aside class="legal-panel">
                <span class="legal-panel-title">@yield('panel-title', __('legal.panel.title'))</span>
                <div class="legal-panel-list">
                    @yield('hero-panel')
                </div>
            </aside>
        </div>
    </header>

    <main class="legal-main">
        <div class="legal-container legal-layout">
            <aside class="legal-sidebar">
                <div class="legal-sidebar-card">
                    <span class="legal-sidebar-title">{{ __('legal.toc_title') }}</span>
                    <nav class="legal-toc" aria-label="Table of contents">
                        @yield('toc')
                    </nav>
                </div>

                <div class="legal-sidebar-card">
                    <span class="legal-sidebar-title">{{ __('legal.need_help') }}</span>
                    <p class="legal-sidebar-text">{{ __('legal.need_help_text') }}</p>
                    <a href="mailto:support@fitlife.com" class="legal-support-link">support@fitlife.com</a>
                </div>
            </aside>

            <article class="legal-article">
                @yield('content')
            </article>
        </div>
    </main>

    @include('partials.site-footer')

    <script src="{{ asset('js/legal.js') }}"></script>
</body>
</html>
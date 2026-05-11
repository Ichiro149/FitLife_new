{{-- Šis daļējais skats attēlo "site footer" koplietojamu saskarnes daļu. --}}

@php($footerWithMobileNav = $withMobileNav ?? false)

<footer class="site-footer{{ $footerWithMobileNav ? ' site-footer--with-mobile-nav' : '' }}">
    <div class="site-footer__container">
        <div class="site-footer__main">
            <div class="site-footer__brand">
                <a href="{{ route('welcome') }}" class="site-footer__logo" aria-label="FitLife home">
                    <img src="{{ asset('storage/logo/fitlife-logo.png') }}" alt="FitLife" class="site-footer__logo-img">
                </a>

                <p class="site-footer__copy">
                    {{ __('site.footer_copy') }}
                </p>
            </div>

            <nav class="site-footer__nav" aria-label="Footer navigation">
                <section class="site-footer__group">
                    <span class="site-footer__title">{{ __('site.navigate') }}</span>
                    <div class="site-footer__links">
                        <a href="{{ route('welcome') }}#features">{{ __('nav.features') }}</a>
                        <a href="{{ route('welcome') }}#system">{{ __('nav.system') }}</a>
                        <a href="{{ route('welcome') }}#community">{{ __('nav.community') }}</a>
                    </div>
                </section>

                <section class="site-footer__group">
                    <span class="site-footer__title">{{ __('site.account') }}</span>
                    <div class="site-footer__links">
                        @auth
                            <a href="{{ route('dashboard') }}">{{ __('nav.dashboard') }}</a>
                            <a href="{{ route('posts.index') }}">{{ __('nav.posts') }}</a>
                        @else
                            <a href="{{ route('login') }}">{{ __('auth.log_in') }}</a>
                            <a href="{{ route('register') }}">{{ __('auth.register_cta') }}</a>
                        @endauth
                    </div>
                </section>

                <section class="site-footer__group">
                    <span class="site-footer__title">{{ __('site.legal') }}</span>
                    <div class="site-footer__links">
                        <a href="{{ route('privacy-policy') }}">{{ __('auth.privacy') }}</a>
                        <a href="{{ route('terms-of-service') }}">{{ __('auth.terms') }}</a>
                    </div>
                </section>
            </nav>
        </div>

        <div class="site-footer__bottom">
            <span>{{ __('site.copyright', ['year' => now()->year]) }}</span>
            <div class="site-footer__bottom-links">
                <a href="mailto:support@fitlife.com">support@fitlife.com</a>
                <a href="{{ route('privacy-policy') }}">Privacy</a>
                <a href="{{ route('terms-of-service') }}">Terms</a>
            </div>
        </div>
    </div>
</footer>
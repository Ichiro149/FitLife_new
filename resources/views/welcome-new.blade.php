<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes">
    <title>{{ __('welcome.page_title') }}</title>
    <link rel="icon" href="{{ asset('favicon.PNG') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* ============================================
         * FITLIFE LANDING - e-Shop Design System
         * ============================================ */
        
        :root {
            /* Backgrounds */
            --bg-primary: #030305;
            --bg-secondary: #0a0a0c;
            --bg-tertiary: #0d0d10;
            --surface: #111114;
            --surface-hover: #18181b;
            --surface-active: #1f1f23;

            /* Borders */
            --border: rgba(255, 255, 255, 0.06);
            --border-hover: rgba(255, 255, 255, 0.10);
            --border-accent: rgba(34, 197, 94, 0.30);

            /* Text */
            --text-primary: #f4f4f5;
            --text-secondary: #a1a1aa;
            --text-muted: #71717a;

            /* Accent (Fitness Green) */
            --accent: #22c55e;
            --accent-hover: #4ade80;
            --accent-glow: rgba(34, 197, 94, 0.15);
            --accent-soft: rgba(34, 197, 94, 0.08);

            /* Gradients */
            --gradient-accent: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            --gradient-card: linear-gradient(165deg, rgba(255, 255, 255, 0.03) 0%, transparent 50%);

            /* Shadows */
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 8px 32px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 16px 48px rgba(0, 0, 0, 0.5);
            --shadow-accent: 0 8px 24px rgba(34, 197, 94, 0.25);
            --shadow-glow: 0 0 60px rgba(34, 197, 94, 0.3);

            /* Border Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-full: 9999px;

            /* Transitions */
            --transition-fast: 0.15s ease;
            --transition-base: 0.2s ease;
            --transition-smooth: 0.3s cubic-bezier(0.4, 0, 0.2, 1);

            /* Font */
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Reset */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
        }

        body {
            font-family: var(--font-sans);
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--surface);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--surface-active);
            border-radius: var(--radius-full);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* ============================================
         * HEADER / NAVIGATION
         * ============================================ */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(17, 17, 20, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 2rem;
        }

        .header-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: var(--gradient-accent);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-accent);
            transition: transform var(--transition-fast);
        }

        .logo-icon:hover {
            transform: scale(1.05);
        }

        .logo-icon img {
            width: 28px;
            height: 28px;
            object-fit: contain;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 700;
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link {
            padding: 10px 18px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: var(--radius-sm);
            transition: all var(--transition-fast);
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--surface-hover);
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: var(--radius-md);
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all var(--transition-smooth);
        }

        .btn-ghost {
            background: transparent;
            color: var(--text-secondary);
        }

        .btn-ghost:hover {
            background: var(--surface-hover);
            color: var(--text-primary);
        }

        .btn-primary {
            background: var(--gradient-accent);
            color: #000;
            box-shadow: var(--shadow-accent);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(34, 197, 94, 0.4);
        }

        .menu-toggle {
            display: none;
            width: 44px;
            height: 44px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-primary);
            font-size: 20px;
        }

        /* ============================================
         * HERO SECTION
         * ============================================ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 2rem 80px;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse at 30% 20%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                radial-gradient(ellipse at 70% 80%, rgba(34, 197, 94, 0.05) 0%, transparent 40%);
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(34, 197, 94, 0.1) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 800px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--accent-soft);
            border: 1px solid var(--border-accent);
            border-radius: var(--radius-full);
            font-size: 13px;
            font-weight: 500;
            color: var(--accent);
            margin-bottom: 24px;
        }

        .hero-badge i {
            font-size: 14px;
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            background: linear-gradient(135deg, var(--text-primary) 0%, var(--text-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-title .accent {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        .hero-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-lg {
            padding: 14px 32px;
            font-size: 16px;
        }

        .btn-secondary {
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--surface-hover);
            border-color: var(--border-hover);
        }

        .hero-stats {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 48px;
            margin-top: 64px;
            padding-top: 48px;
            border-top: 1px solid var(--border);
        }

        .hero-stat {
            text-align: center;
        }

        .hero-stat-value {
            font-size: 2rem;
            font-weight: 700;
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-stat-label {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* ============================================
         * FEATURES SECTION
         * ============================================ */
        .section {
            padding: 100px 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 64px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            background: var(--accent-soft);
            border: 1px solid var(--border-accent);
            border-radius: var(--radius-full);
            font-size: 12px;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .section-subtitle {
            font-size: 1.0625rem;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 24px;
        }

        .feature-card {
            background: var(--gradient-card), var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            transition: all var(--transition-smooth);
        }

        .feature-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .feature-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .feature-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform var(--transition-smooth);
        }

        .feature-card:hover .feature-image img {
            transform: scale(1.05);
        }

        .feature-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, var(--surface) 0%, transparent 50%);
        }

        .feature-content {
            padding: 24px;
            margin-top: -24px;
            position: relative;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-accent);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            box-shadow: var(--shadow-accent);
        }

        .feature-icon i {
            font-size: 20px;
            color: #000;
        }

        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .feature-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* ============================================
         * TESTIMONIALS SECTION
         * ============================================ */
        .testimonials-section {
            background: var(--bg-secondary);
            padding: 100px 2rem;
        }

        .testimonials-inner {
            max-width: 1400px;
            margin: 0 auto;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        .testimonial-card {
            background: var(--gradient-card), var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            padding: 32px;
            transition: all var(--transition-smooth);
        }

        .testimonial-card:hover {
            border-color: var(--border-hover);
            box-shadow: var(--shadow-md);
        }

        .testimonial-quote {
            font-size: 32px;
            color: var(--accent);
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .testimonial-text {
            font-size: 15px;
            color: var(--text-secondary);
            line-height: 1.7;
            font-style: italic;
            margin-bottom: 24px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .testimonial-avatar {
            width: 48px;
            height: 48px;
            background: var(--gradient-accent);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #000;
        }

        .testimonial-info {
            flex: 1;
        }

        .testimonial-name {
            font-weight: 600;
            font-size: 15px;
        }

        .testimonial-role {
            font-size: 13px;
            color: var(--text-muted);
        }

        .testimonial-stars {
            color: var(--accent);
            font-size: 12px;
        }

        /* ============================================
         * ABOUT / CTA SECTION
         * ============================================ */
        .cta-section {
            padding: 100px 2rem;
        }

        .cta-card {
            max-width: 900px;
            margin: 0 auto;
            background: var(--gradient-card), var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-2xl);
            padding: 64px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-card::before {
            content: '';
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(34, 197, 94, 0.1) 0%, transparent 70%);
            filter: blur(40px);
            pointer-events: none;
        }

        .cta-title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            margin-bottom: 16px;
            position: relative;
        }

        .cta-text {
            font-size: 1rem;
            color: var(--text-secondary);
            max-width: 500px;
            margin: 0 auto 32px;
            line-height: 1.7;
            position: relative;
        }

        .cta-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            flex-wrap: wrap;
            position: relative;
        }

        /* ============================================
         * FOOTER
         * ============================================ */
        .footer {
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 48px 2rem;
        }

        .footer-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 24px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-logo {
            width: 36px;
            height: 36px;
            background: var(--gradient-accent);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-logo img {
            width: 22px;
            height: 22px;
        }

        .footer-name {
            font-weight: 600;
            font-size: 18px;
        }

        .footer-links {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .footer-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            transition: color var(--transition-fast);
        }

        .footer-link:hover {
            color: var(--accent);
        }

        .footer-copy {
            color: var(--text-muted);
            font-size: 13px;
        }

        /* ============================================
         * LIGHTBOX
         * ============================================ */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(8px);
            z-index: 200;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .lightbox[aria-hidden="false"] {
            display: flex;
        }

        .lightbox-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }

        .lightbox-img {
            max-width: 100%;
            max-height: 85vh;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }

        .lightbox-close {
            position: absolute;
            top: -48px;
            right: 0;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .lightbox-close:hover {
            background: var(--accent);
            color: #000;
            border-color: var(--accent);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-full);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
            cursor: pointer;
            transition: all var(--transition-fast);
        }

        .lightbox-nav:hover {
            background: var(--accent);
            color: #000;
            border-color: var(--accent);
        }

        .lightbox-prev { left: -64px; }
        .lightbox-next { right: -64px; }

        /* ============================================
         * RESPONSIVE
         * ============================================ */
        @media (max-width: 1024px) {
            .nav {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .hero-stats {
                gap: 32px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 0 1rem;
            }

            .header-inner {
                height: 64px;
            }

            .auth-buttons .btn span {
                display: none;
            }

            .hero {
                padding: 100px 1.5rem 60px;
            }

            .hero-stats {
                flex-direction: column;
                gap: 24px;
            }

            .section {
                padding: 60px 1.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .testimonials-section {
                padding: 60px 1.5rem;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .cta-card {
                padding: 40px 24px;
            }

            .footer-inner {
                flex-direction: column;
                text-align: center;
            }

            .lightbox-prev { left: 8px; }
            .lightbox-next { right: 8px; }
        }

        @media (max-width: 480px) {
            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .hero-buttons .btn {
                width: 100%;
            }

            .cta-buttons {
                flex-direction: column;
                width: 100%;
            }

            .cta-buttons .btn {
                width: 100%;
            }

            .footer-links {
                flex-direction: column;
                gap: 12px;
            }
        }

        /* Mobile menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 16px;
            z-index: 99;
        }

        .mobile-menu.active {
            display: block;
        }

        .mobile-menu .nav-link {
            display: block;
            padding: 12px 16px;
            margin-bottom: 4px;
        }

        .mobile-menu .auth-buttons {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            flex-direction: column;
        }

        .mobile-menu .btn {
            width: 100%;
            justify-content: center;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-inner">
            <a href="/" class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('favicon.PNG') }}" alt="FitLife">
                </div>
                <span class="logo-text">FitLife</span>
            </a>

            <nav class="nav">
                <a href="#features" class="nav-link">{{ __('welcome.nav_features') }}</a>
                <a href="#testimonials" class="nav-link">{{ __('welcome.nav_testimonials') }}</a>
                <a href="#about" class="nav-link">{{ __('welcome.nav_about') }}</a>
            </nav>

            <div class="auth-buttons">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-rocket"></i>
                            <span>{{ __('welcome.dashboard') }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>{{ __('welcome.log_in') }}</span>
                        </a>
                        @if(Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i>
                                <span>{{ __('welcome.sign_up') }}</span>
                            </a>
                        @endif
                    @endauth
                @endif
            </div>

            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#features" class="nav-link">{{ __('welcome.nav_features') }}</a>
        <a href="#testimonials" class="nav-link">{{ __('welcome.nav_testimonials') }}</a>
        <a href="#about" class="nav-link">{{ __('welcome.nav_about') }}</a>
        <div class="auth-buttons">
            @if(Route::has('login'))
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-rocket"></i> {{ __('welcome.dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost">
                        <i class="fas fa-sign-in-alt"></i> {{ __('welcome.log_in') }}
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> {{ __('welcome.sign_up') }}
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <div class="hero-badge animate-fade-in-up">
                    <i class="fas fa-bolt"></i>
                    {{ __('welcome.hero_badge') ?? 'Transform Your Life Today' }}
                </div>
                
                <h1 class="hero-title animate-fade-in-up animate-delay-1">
                    {{ __('welcome.hero_title') }}
                </h1>
                
                <p class="hero-subtitle animate-fade-in-up animate-delay-2">
                    {{ __('welcome.hero_subtitle') }}
                </p>

                <div class="hero-buttons animate-fade-in-up animate-delay-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-rocket"></i> {{ __('welcome.get_started') ?? 'Get Started Free' }}
                        </a>
                        <a href="#features" class="btn btn-secondary btn-lg">
                            <i class="fas fa-play"></i> {{ __('welcome.learn_more') ?? 'Learn More' }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-rocket"></i> {{ __('welcome.go_to_dashboard') ?? 'Go to Dashboard' }}
                        </a>
                    @endguest
                </div>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-value">10K+</div>
                        <div class="hero-stat-label">{{ __('welcome.stat_users') ?? 'Active Users' }}</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">50K+</div>
                        <div class="hero-stat-label">{{ __('welcome.stat_workouts') ?? 'Workouts Logged' }}</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-value">98%</div>
                        <div class="hero-stat-label">{{ __('welcome.stat_satisfaction') ?? 'Satisfaction Rate' }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="section" id="features">
            <div class="section-header">
                <span class="section-label">
                    <i class="fas fa-star"></i> {{ __('welcome.features_label') ?? 'Features' }}
                </span>
                <h2 class="section-title">{{ __('welcome.features_title') }}</h2>
                <p class="section-subtitle">{{ __('welcome.features_subtitle') }}</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-image">
                        <img src="{{ asset('storage/WelcomePhoto/training.jpg') }}" alt="{{ __('welcome.feature_workouts_alt') }}" data-lightbox>
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h3 class="feature-title">{{ __('welcome.feature_workouts_title') }}</h3>
                        <p class="feature-desc">{{ __('welcome.feature_workouts_desc') }}</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-image">
                        <img src="{{ asset('storage/WelcomePhoto/nutrition.jpg') }}" alt="{{ __('welcome.feature_nutrition_alt') }}" data-lightbox>
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <h3 class="feature-title">{{ __('welcome.feature_nutrition_title') }}</h3>
                        <p class="feature-desc">{{ __('welcome.feature_nutrition_desc') }}</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-image">
                        <img src="{{ asset('storage/WelcomePhoto/sleep.jpg') }}" alt="{{ __('welcome.feature_sleep_alt') }}" data-lightbox>
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-moon"></i>
                        </div>
                        <h3 class="feature-title">{{ __('welcome.feature_sleep_title') }}</h3>
                        <p class="feature-desc">{{ __('welcome.feature_sleep_desc') }}</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-image">
                        <img src="{{ asset('storage/WelcomePhoto/community.jpg') }}" alt="{{ __('welcome.feature_community_alt') }}" data-lightbox>
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="feature-title">{{ __('welcome.feature_community_title') }}</h3>
                        <p class="feature-desc">{{ __('welcome.feature_community_desc') }}</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-image">
                        <img src="{{ asset('storage/WelcomePhoto/progress.jpg') }}" alt="{{ __('welcome.feature_progress_alt') }}" data-lightbox>
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">{{ __('welcome.feature_progress_title') }}</h3>
                        <p class="feature-desc">{{ __('welcome.feature_progress_desc') }}</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-image">
                        <img src="{{ asset('storage/WelcomePhoto/goalsetting.jpg') }}" alt="{{ __('welcome.feature_goals_alt') }}" data-lightbox>
                    </div>
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="feature-title">{{ __('welcome.feature_goals_title') }}</h3>
                        <p class="feature-desc">{{ __('welcome.feature_goals_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section" id="testimonials">
            <div class="testimonials-inner">
                <div class="section-header">
                    <span class="section-label">
                        <i class="fas fa-heart"></i> {{ __('welcome.testimonials_label') ?? 'Testimonials' }}
                    </span>
                    <h2 class="section-title">{{ __('welcome.testimonials_title') }}</h2>
                    <p class="section-subtitle">{{ __('welcome.testimonials_subtitle') }}</p>
                </div>

                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">{{ __('welcome.testimonial_1_text') }}</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">JD</div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">{{ __('welcome.testimonial_1_author') }}</div>
                                <div class="testimonial-role">{{ __('welcome.testimonial_1_role') ?? 'Fitness Enthusiast' }}</div>
                            </div>
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">{{ __('welcome.testimonial_2_text') }}</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">SM</div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">{{ __('welcome.testimonial_2_author') }}</div>
                                <div class="testimonial-role">{{ __('welcome.testimonial_2_role') ?? 'Marathon Runner' }}</div>
                            </div>
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-quote">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <p class="testimonial-text">{{ __('welcome.testimonial_3_text') }}</p>
                        <div class="testimonial-author">
                            <div class="testimonial-avatar">EK</div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">{{ __('welcome.testimonial_3_author') }}</div>
                                <div class="testimonial-role">{{ __('welcome.testimonial_3_role') ?? 'Personal Trainer' }}</div>
                            </div>
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section" id="about">
            <div class="cta-card">
                <h2 class="cta-title">{{ __('welcome.about_title') }}</h2>
                <p class="cta-text">{{ __('welcome.about_text') }}</p>
                <div class="cta-buttons">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-rocket"></i> {{ __('welcome.cta_start') ?? 'Start Your Journey' }}
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-rocket"></i> {{ __('welcome.go_to_dashboard') ?? 'Go to Dashboard' }}
                        </a>
                    @endguest
                    <a href="mailto:support@fitlife.com" class="btn btn-secondary btn-lg">
                        <i class="fas fa-envelope"></i> {{ __('welcome.cta_contact') ?? 'Contact Us' }}
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="{{ asset('favicon.PNG') }}" alt="FitLife">
                </div>
                <span class="footer-name">FitLife</span>
            </div>

            <div class="footer-links">
                <a href="{{ route('privacy-policy') }}" class="footer-link">{{ __('welcome.footer_privacy') }}</a>
                <a href="{{ route('terms-of-service') }}" class="footer-link">{{ __('welcome.footer_terms') }}</a>
                <a href="mailto:support@fitlife.com" class="footer-link">{{ __('welcome.footer_contact') }}</a>
            </div>

            <div class="footer-copy">
                {{ __('welcome.footer_copyright', ['year' => date('Y')]) }}
            </div>
        </div>
    </footer>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" aria-hidden="true">
        <div class="lightbox-content">
            <img class="lightbox-img" id="lightboxImg" src="" alt="">
            <button class="lightbox-close" id="lightboxClose">
                <i class="fas fa-times"></i>
            </button>
            <button class="lightbox-nav lightbox-prev" id="lightboxPrev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="lightbox-nav lightbox-next" id="lightboxNext">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile menu
            const menuToggle = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');

            menuToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
                const icon = menuToggle.querySelector('i');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            });

            // Close mobile menu on link click
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    menuToggle.querySelector('i').classList.add('fa-bars');
                    menuToggle.querySelector('i').classList.remove('fa-times');
                });
            });

            // Lightbox
            const images = document.querySelectorAll('[data-lightbox]');
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightboxImg');
            const lightboxClose = document.getElementById('lightboxClose');
            const lightboxPrev = document.getElementById('lightboxPrev');
            const lightboxNext = document.getElementById('lightboxNext');
            let currentIndex = 0;

            images.forEach((img, index) => {
                img.style.cursor = 'pointer';
                img.addEventListener('click', () => {
                    currentIndex = index;
                    lightboxImg.src = img.src;
                    lightboxImg.alt = img.alt;
                    lightbox.setAttribute('aria-hidden', 'false');
                });
            });

            const closeLightbox = () => {
                lightbox.setAttribute('aria-hidden', 'true');
            };

            lightboxClose.addEventListener('click', closeLightbox);
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightbox();
            });

            lightboxPrev.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                lightboxImg.src = images[currentIndex].src;
                lightboxImg.alt = images[currentIndex].alt;
            });

            lightboxNext.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % images.length;
                lightboxImg.src = images[currentIndex].src;
                lightboxImg.alt = images[currentIndex].alt;
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (lightbox.getAttribute('aria-hidden') === 'false') {
                    if (e.key === 'Escape') closeLightbox();
                    if (e.key === 'ArrowLeft') lightboxPrev.click();
                    if (e.key === 'ArrowRight') lightboxNext.click();
                }
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });
        });
    </script>
</body>
</html>

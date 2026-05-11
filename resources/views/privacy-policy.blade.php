{{-- Šis skats attēlo "privacy policy" lapu vai saskarnes sadaļu. --}}

@extends('layouts.legal')

@section('title', __('legal.privacy.seo_title'))
@section('hero-title', __('legal.privacy.hero_title'))
@section('hero-subtitle', __('legal.privacy.hero_subtitle'))
@section('updated-date', __('legal.privacy.updated_date'))
@section('meta-note', __('legal.privacy.meta_note'))
@section('panel-title', __('legal.panel.title'))

@section('hero-panel')
    <article class="legal-panel-item">
        <strong>{{ __('legal.panel.items.0.title') }}</strong>
        <p>{{ __('legal.panel.items.0.body') }}</p>
    </article>
    <article class="legal-panel-item">
        <strong>{{ __('legal.panel.items.1.title') }}</strong>
        <p>{{ __('legal.panel.items.1.body') }}</p>
    </article>
    <article class="legal-panel-item">
        <strong>{{ __('legal.panel.items.2.title') }}</strong>
        <p>{{ __('legal.panel.items.2.body') }}</p>
    </article>
@endsection

@section('toc')
    <a href="#introduction">01 Introduction</a>
    <a href="#information-we-collect">02 Information We Collect</a>
    <a href="#how-we-use-information">03 How We Use Information</a>
    <a href="#sharing-information">04 Sharing Information</a>
    <a href="#data-security">05 Data Security</a>
    <a href="#your-choices">06 Your Choices</a>
    <a href="#cookies-and-tracking">07 Cookies and Tracking</a>
    <a href="#third-party-links">08 Third-Party Links</a>
    <a href="#children-privacy">09 Children's Privacy</a>
    <a href="#changes-to-policy">10 Changes to This Policy</a>
    <a href="#contact-us">11 Contact Us</a>
@endsection

@section('content')
    <section class="legal-section" id="introduction">
        <div class="legal-section-number">01</div>
        <div class="legal-section-body">
            <h2>Introduction</h2>
            <p>At FitLife, we are committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our website and services.</p>
        </div>
    </section>

    <section class="legal-section" id="information-we-collect">
        <div class="legal-section-number">02</div>
        <div class="legal-section-body">
            <h2>Information We Collect</h2>
            <p>We may collect the following types of information:</p>
            <ul>
                <li><strong>Personal Information:</strong> Name, email address, age, gender, and other information you provide when registering or updating your profile.</li>
                <li><strong>Health Data:</strong> Information about your workouts, nutrition, sleep, and other fitness-related data you input.</li>
                <li><strong>Usage Data:</strong> Information about how you interact with our website, such as IP address, browser type, and pages visited.</li>
                <li><strong>Device Data:</strong> Information about the devices you use to access our services, including device type and operating system.</li>
            </ul>
        </div>
    </section>

    <section class="legal-section" id="how-we-use-information">
        <div class="legal-section-number">03</div>
        <div class="legal-section-body">
            <h2>How We Use Information</h2>
            <p>We use your information to:</p>
            <ul>
                <li>Provide and improve our services, such as personalized workout and nutrition plans.</li>
                <li>Communicate with you, including sending updates and notifications.</li>
                <li>Analyze usage patterns to enhance user experience.</li>
                <li>Ensure the security of our platform.</li>
            </ul>
        </div>
    </section>

    <section class="legal-section" id="sharing-information">
        <div class="legal-section-number">04</div>
        <div class="legal-section-body">
            <h2>Sharing Information</h2>
            <p>We do not sell your personal information. We may share your information with:</p>
            <ul>
                <li><strong>Service Providers:</strong> Third-party vendors who assist with hosting, analytics, or payment processing.</li>
                <li><strong>Legal Authorities:</strong> When required by law or to protect our rights.</li>
                <li><strong>Community Features:</strong> Information you choose to share publicly, such as posts or comments.</li>
            </ul>
        </div>
    </section>

    <section class="legal-section" id="data-security">
        <div class="legal-section-number">05</div>
        <div class="legal-section-body">
            <h2>Data Security</h2>
            <p>We implement industry-standard security measures to protect your data, including encryption and secure servers. However, no method of transmission over the internet is 100% secure.</p>
        </div>
    </section>

    <section class="legal-section" id="your-choices">
        <div class="legal-section-number">06</div>
        <div class="legal-section-body">
            <h2>Your Choices</h2>
            <p>You can:</p>
            <ul>
                <li>Access, update, or delete your personal information via your account settings.</li>
                <li>Opt out of promotional communications.</li>
                <li>Disable cookies through your browser settings, though this may affect functionality.</li>
            </ul>
        </div>
    </section>

    <section class="legal-section" id="cookies-and-tracking">
        <div class="legal-section-number">07</div>
        <div class="legal-section-body">
            <h2>Cookies and Tracking</h2>
            <p>We use cookies to enhance your experience, such as remembering your preferences. You can manage cookie settings in your browser.</p>
        </div>
    </section>

    <section class="legal-section" id="third-party-links">
        <div class="legal-section-number">08</div>
        <div class="legal-section-body">
            <h2>Third-Party Links</h2>
            <p>Our website may contain links to third-party sites. We are not responsible for their privacy practices.</p>
        </div>
    </section>

    <section class="legal-section" id="children-privacy">
        <div class="legal-section-number">09</div>
        <div class="legal-section-body">
            <h2>Children's Privacy</h2>
            <p>Our services are not intended for individuals under 13. We do not knowingly collect data from children.</p>
        </div>
    </section>

    <section class="legal-section" id="changes-to-policy">
        <div class="legal-section-number">10</div>
        <div class="legal-section-body">
            <h2>Changes to This Policy</h2>
            <p>We may update this Privacy Policy from time to time. We will notify you of significant changes via email or a notice on our website.</p>
        </div>
    </section>

    <section class="legal-section" id="contact-us">
        <div class="legal-section-number">11</div>
        <div class="legal-section-body">
            <h2>Contact Us</h2>
            <p>If you have questions about this Privacy Policy, please contact us at <a href="mailto:support@fitlife.com">support@fitlife.com</a>.</p>
        </div>
    </section>
@endsection

{{-- Šis skats attēlo "terms of service" lapu vai saskarnes sadaļu. --}}

@extends('layouts.legal')

@section('title', __('legal.terms.seo_title'))
@section('hero-title', __('legal.terms.hero_title'))
@section('hero-subtitle', __('legal.terms.hero_subtitle'))
@section('updated-date', __('legal.terms.updated_date'))
@section('meta-note', __('legal.terms.meta_note'))
@section('panel-title', __('legal.panel.title'))

@section('hero-panel')
    <article class="legal-panel-item">
        <strong>{{ __('legal.panel.items.0.title') }}</strong>
        <p>{{ __('legal.terms.panel_item_who_body', ['default' => 'Users must meet the age requirement, provide accurate account details, and use the service lawfully.']) }}</p>
    </article>
    <article class="legal-panel-item">
        <strong>{{ __('legal.panel.items.1.title') }}</strong>
        <p>{{ __('legal.terms.panel_item_prohibited_body', ['default' => 'Abuse, unlawful behavior, unauthorized access attempts, and automated scraping are not allowed.']) }}</p>
    </article>
    <article class="legal-panel-item">
        <strong>{{ __('legal.panel.items.2.title') }}</strong>
        <p>{{ __('legal.terms.panel_item_consequences_body', ['default' => 'We may suspend or terminate accounts that violate these terms or put other users and the platform at risk.']) }}</p>
    </article>
@endsection

@section('toc')
    <a href="#acceptance-of-terms">01 Acceptance of Terms</a>
    <a href="#use-of-services">02 Use of Services</a>
    <a href="#account-responsibilities">03 Account Responsibilities</a>
    <a href="#user-content">04 User Content</a>
    <a href="#prohibited-conduct">05 Prohibited Conduct</a>
    <a href="#intellectual-property">06 Intellectual Property</a>
    <a href="#termination">07 Termination</a>
    <a href="#disclaimer-of-warranties">08 Disclaimer of Warranties</a>
    <a href="#limitation-of-liability">09 Limitation of Liability</a>
    <a href="#governing-law">10 Governing Law</a>
    <a href="#changes-to-terms">11 Changes to Terms</a>
    <a href="#contact-us">12 Contact Us</a>
@endsection

@section('content')
    <section class="legal-section" id="acceptance-of-terms">
        <div class="legal-section-number">01</div>
        <div class="legal-section-body">
            <h2>Acceptance of Terms</h2>
            <p>By accessing or using FitLife, you agree to be bound by these Terms of Service. If you do not agree, please do not use our services.</p>
        </div>
    </section>

    <section class="legal-section" id="use-of-services">
        <div class="legal-section-number">02</div>
        <div class="legal-section-body">
            <h2>Use of Services</h2>
            <p>You agree to use FitLife only for lawful purposes and in accordance with these Terms. You must:</p>
            <ul>
                <li>Be at least 13 years old to use our services.</li>
                <li>Provide accurate and complete information when creating an account.</li>
                <li>Not use our services to engage in illegal activities or violate the rights of others.</li>
            </ul>
        </div>
    </section>

    <section class="legal-section" id="account-responsibilities">
        <div class="legal-section-number">03</div>
        <div class="legal-section-body">
            <h2>Account Responsibilities</h2>
            <p>You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.</p>
        </div>
    </section>

    <section class="legal-section" id="user-content">
        <div class="legal-section-number">04</div>
        <div class="legal-section-body">
            <h2>User Content</h2>
            <p>You retain ownership of content you submit, such as posts, comments, or progress photos. By submitting content, you grant FitLife a non-exclusive, royalty-free license to use, display, and distribute it in connection with our services.</p>
        </div>
    </section>

    <section class="legal-section" id="prohibited-conduct">
        <div class="legal-section-number">05</div>
        <div class="legal-section-body">
            <h2>Prohibited Conduct</h2>
            <p>You agree not to:</p>
            <ul>
                <li>Post harmful, offensive, or unlawful content.</li>
                <li>Attempt to gain unauthorized access to our systems.</li>
                <li>Use automated scripts to scrape or collect data.</li>
            </ul>
        </div>
    </section>

    <section class="legal-section" id="intellectual-property">
        <div class="legal-section-number">06</div>
        <div class="legal-section-body">
            <h2>Intellectual Property</h2>
            <p>All content and materials on FitLife, including logos, designs, and software, are owned by FitLife or its licensors and protected by intellectual property laws.</p>
        </div>
    </section>

    <section class="legal-section" id="termination">
        <div class="legal-section-number">07</div>
        <div class="legal-section-body">
            <h2>Termination</h2>
            <p>We may suspend or terminate your account if you violate these Terms or engage in conduct that harms FitLife or its users.</p>
        </div>
    </section>

    <section class="legal-section" id="disclaimer-of-warranties">
        <div class="legal-section-number">08</div>
        <div class="legal-section-body">
            <h2>Disclaimer of Warranties</h2>
            <p>FitLife is provided "as is" without warranties of any kind. We do not guarantee that our services will be uninterrupted or error-free.</p>
        </div>
    </section>

    <section class="legal-section" id="limitation-of-liability">
        <div class="legal-section-number">09</div>
        <div class="legal-section-body">
            <h2>Limitation of Liability</h2>
            <p>FitLife is not liable for any indirect, incidental, or consequential damages arising from your use of our services.</p>
        </div>
    </section>

    <section class="legal-section" id="governing-law">
        <div class="legal-section-number">10</div>
        <div class="legal-section-body">
            <h2>Governing Law</h2>
            <p>These Terms are governed by applicable laws. Any disputes will be resolved in the appropriate jurisdiction.</p>
        </div>
    </section>

    <section class="legal-section" id="changes-to-terms">
        <div class="legal-section-number">11</div>
        <div class="legal-section-body">
            <h2>Changes to Terms</h2>
            <p>We may update these Terms from time to time. We will notify you of significant changes via email or a notice on our website.</p>
        </div>
    </section>

    <section class="legal-section" id="contact-us">
        <div class="legal-section-number">12</div>
        <div class="legal-section-body">
            <h2>Contact Us</h2>
            <p>If you have questions about these Terms, please contact us at <a href="mailto:support@fitlife.com">support@fitlife.com</a>.</p>
        </div>
    </section>
@endsection

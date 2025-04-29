@extends('user.layout')

@section('meta')
    <meta name="keywords"
        content="terms of service, healthifyme terms, diet platform rules, nutrition website terms, user agreement, healthifyme policies">
    <meta name="description"
        content="HealthifyMe's Terms of Service outline the rules and guidelines for using our diet and nutrition platform. Learn about user responsibilities, intellectual property, and more.">
@endsection

@section('title')
    Terms of Service | HealthifyMe
@endsection

@section('style')
    <style>
        .terms-page {
            line-height: 1.8;
        }

        .terms-content h2 {
            color: #2c3e50;
            padding-bottom: 8px;
            border-bottom: 2px solid #f0f0f0;
        }

        .terms-content .fa-ul {
            margin-left: 2em;
        }

        .terms-content .alert-warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
        }

        .contact-section {
            background-color: #f8f9fa;
            border-left: 4px solid rgb(67 150 15);
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 2rem;
            }
        }
    </style>
@endsection

@section('body')
    <div class="container py-5 terms-page">
        <div class="card shadow border-0">
            <div class="card-body p-4 p-md-5">
                <header class="text-center mb-5">
                    <h1 class="display-5 mb-3">Terms of Service</h1>
                    <p class="text-muted">Last Updated: April 28, 2025</p>
                </header>

                <article class="terms-content">
                    <section class="mb-5">
                        <p class="lead">Welcome to HealthifyMe! These Terms of Service ("Terms") govern your use of our
                            website and services. By accessing or using our platform, you agree to comply with these Terms.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">1</span> Acceptance of Terms</h2>
                        <p>By accessing or using HealthifyMe, you acknowledge that you have read, understood, and agree to
                            be bound by these Terms and our <a href="{{ route('PrivacyPolicy') }}">Privacy Policy</a>. If you
                            do not agree, please refrain from using our services.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">2</span> Account Registration</h2>
                        <p>To access certain features, you may need to create an account. You agree to:</p>
                        <ul class="fa-ul">
                            <li><span class="fa-li"><i class="fas fa-check-circle text-primary"></i></span> Provide
                                accurate and complete information</li>
                            <li><span class="fa-li"><i class="fas fa-check-circle text-primary"></i></span> Maintain the
                                confidentiality of your credentials</li>
                            <li><span class="fa-li"><i class="fas fa-check-circle text-primary"></i></span> Be responsible
                                for all activities under your account</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">3</span> Acceptable Use</h2>
                        <p>You agree not to:</p>
                        <ul class="fa-ul">
                            <li><span class="fa-li"><i class="fas fa-times-circle text-danger"></i></span> Use the service
                                for any illegal purpose</li>
                            <li><span class="fa-li"><i class="fas fa-times-circle text-danger"></i></span> Violate any
                                applicable laws or regulations</li>
                            <li><span class="fa-li"><i class="fas fa-times-circle text-danger"></i></span> Attempt to gain
                                unauthorized access to our systems</li>
                            <li><span class="fa-li"><i class="fas fa-times-circle text-danger"></i></span> Post harmful or
                                offensive content</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">4</span> Health Disclaimer</h2>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> The content provided on HealthifyMe is for
                            informational purposes only and is not intended as medical advice. Always consult with a
                            qualified healthcare professional before making any dietary changes or starting an exercise
                            program.
                        </div>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">5</span> Intellectual Property</h2>
                        <p>All content, features, and functionality on HealthifyMe are the exclusive property of HealthifyMe
                            and are protected by international copyright, trademark, and other intellectual property laws.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">6</span> Termination</h2>
                        <p>We reserve the right to suspend or terminate your access to our services at our sole discretion,
                            without notice, for conduct that we believe violates these Terms or is harmful to other users.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">7</span> Changes to Terms</h2>
                        <p>We may modify these Terms at any time. We will notify users of significant changes through our
                            website or via email. Your continued use of our services after such changes constitutes
                            acceptance of the new Terms.</p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h4 mb-3"><span class="badge bg-success me-2">8</span> Governing Law</h2>
                        <p>These Terms shall be governed by and construed in accordance with the laws of [cairo/egypt], without regard to its conflict of law provisions.</p>
                    </section>

                    <section class="contact-section p-4 bg-light rounded">
                        <h2 class="h4 mb-3"><i class="fas fa-question-circle me-2 text-success"></i> Contact Us</h2>
                        <p>If you have any questions about these Terms, please contact us:</p>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-envelope me-3 text-success"></i>
                            <a href="mailto:healthifyme@healthifyme.top">healthifyme@healthifyme.top</a>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-globe me-3 text-success"></i>
                            <a href="{{ route('contact.create') }}">Contact Form</a>
                        </div>
                    </section>
                </article>
            </div>
        </div>
    </div>
@endsection


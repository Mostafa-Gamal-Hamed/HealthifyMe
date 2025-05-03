@extends('user.layout')

@section('meta')
    <meta name="title" content="About HealthifyMe | Learn More About HealthifyMe">
    <meta name="description"
        content="Discover HealthifyMe's journey in making health & nutrition accessible to all. Learn about our mission, vision, and the team behind your wellness transformation.">
    <meta name="keywords"
        content="healthifyme about, our story, health platform, nutrition experts, wellness company, healthy lifestyle mission">

    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="About HealthifyMe | Learn More About HealthifyMe">
    <meta property="og:description" content="Discover HealthifyMe's journey in making health & nutrition accessible to all.">
    <meta property="og:image" content="{{ asset('images/modern_logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('title')
    About HealthifyMe | Learn More About HealthifyMe
@endsection

@section('style')
    <style>
        .about-section {
            padding: 5rem 0;
        }

        .about-hero {
            min-height: 80vh;
        }

        .about-image img {
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .about-image img:hover {
            transform: scale(1.02);
        }

        @media (max-width: 992px) {

            .about-hero,
            .mission-vision {
                flex-direction: column;
            }

            .border-end {
                border-right: none !important;
                border-bottom: 1px solid #dee2e6;
                padding-bottom: 3rem;
                margin-bottom: 3rem;
            }
        }
    </style>
@endsection

@section('body')
    {{-- About --}}
    <div id="about" class="about-section bg-light">
        <div class="container">
            <section class="about-hero row align-items-center g-0">
                <div class="col-lg-6 pe-lg-5">
                    <div class="about-content py-5">
                        <h1 class="display-4 fw-bold mb-4">About HealthifyMe</h1>
                        <p class="lead">
                            We believe that the path to a healthy body and balanced life should be accessible and effective.
                            That’s why we’ve developed a smart platform that helps you achieve your health goals through
                            personalized diet plans, accurate calorie counting, and a comprehensive food database.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="{{ asset('images/modern_logo.png') }}" alt="HealthifyMe Logo" class="img-fluid"
                            loading="lazy">
                    </div>
                </div>
            </section>

            <section class="mission-vision row align-items-center g-0 my-5">
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="{{ asset('images/our-mission.png') }}" alt="HealthifyMe Logo" class="img-fluid"
                            loading="lazy">
                    </div>
                </div>
                <div class="col-lg-6 pe-lg-5">
                    <div class="about-content py-5">
                        <h1 class="display-4 fw-bold mb-4">Our mission</h1>
                        <h4>"Guiding Your Journey to Wellness – One Smart Bite at a Time."</h4>
                        <p>
                            At HealthifyMe, we turn nutritional science into simple, actionable wisdom. We don’t just count
                            calories—we decode them. Through AI-powered insights and human expertise, we transform
                            overwhelming food choices into confident decisions, because everyone deserves a health journey
                            that feels effortless, empowering, and uniquely theirs.
                        </p>
                        <h1 class="display-4 fw-bold mb-4">Our vision</h1>
                        <h4>Redefining Nutrition for 8 Billion Unique Stories.</h4>
                        <p>
                            We see a world where cutting-edge technology meets personalized care—where your dietary plan
                            adapts as dynamically as your life does. From glucose monitoring to AI meal planning, we’re
                            building the future of nutrition: precise, inclusive, and always one step ahead.
                        </p>
                        <h1 class="display-4 fw-bold mb-4">Our values</h1>
                        <p>
                            ✓ Science, Simplified - ✓ Tech with Heart - ✓ Health as Habit - ✓ Your Goals, Our Obsession.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- Team --}}
    <section class="team-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Meet Our Expert Team</h2>
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3 text-center mb-3">
                    <div class="team-card">
                        <img src="{{ asset('images/mostafa.jpg') }}" alt="Nutrition Expert" style="max-width: 30%;" class="rounded-circle">
                        <h3>Eng. Mostafa Joseph</h3>
                        <p>General Manager</p>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="team-card">
                        <img src="{{ asset('images/dr_1.jpg') }}" alt="Nutrition Expert" style="max-width: 30%;" class="rounded-circle">
                        <h3>Dr. Mariam</h3>
                        <p>Head of Nutrition</p>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="team-card">
                        <img src="{{ asset('images/dr_2.jpg') }}" alt="Nutrition Expert" style="max-width: 30%;" class="rounded-circle">
                        <h3>Dr. Adam</h3>
                        <p>Nutritionist</p>
                    </div>
                </div>
                <div class="col-md-3 text-center mb-3">
                    <div class="team-card">
                        <img src="{{ asset('images/dr_3.jpg') }}" alt="Nutrition Expert" style="max-width: 30%;" class="rounded-circle">
                        <h3>Dr. Haya</h3>
                        <p>Nutritionist</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@extends('user.layout')

@section('meta')
    <meta name="keywords" content="about HealthifyMe, our story, health platform, diet and nutrition team, wellness company, healthy lifestyle, fitness mission">
    <meta name="description" content="HealthifyMe is a health-focused platform offering personalized diet plans, healthy recipes, and smart tools to help you live better. Learn more about our mission and team.">
@endsection

@section('title')
    About us | Learn More About HealthifyMe
@endsection

@section('body')
    {{-- About --}}
    <div id="about" class="about">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 position-relative border-end">
                    <div class="about-box">
                        <h2 class="mb-3">About us</h2>
                        <h1 class="fw-bold">
                            In HealthifyMe We believe that the path to a healthy body and a balanced life should be easy and effective.
                            That’s why we’ve developed a smart platform that helps you achieve your health goals through
                            personalized diet plans, accurate calorie counting, and a comprehensive food database.
                        </h1>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 padding_rl">
                    <div class="about-box_img">
                        <figure><img src="{{ asset('images/modern_logo.png') }}" alt="#" /></figure>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 padding_rl border-end">
                    <div class="about-box_img">
                        <figure><img src="{{ asset('images/our-mission.png') }}" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 position-relative">
                    <div class="about-box">
                        <h1>
                            <strong>Our mission:</strong> Empowering you to make the right nutritional decisions in a simple and easy way.
                        </h1>
                        <hr>
                        <h1>
                            <strong>Our vision:</strong> Using the latest technologies to provide smart nutritional solutions that suit all
                            individuals.
                        </h1>
                        <hr>
                        <h1>
                            <strong>Our values:</strong> Quality - Innovation - Health - Ease of use.
                        </h1>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

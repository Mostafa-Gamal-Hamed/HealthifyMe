@extends('user.layout')

@section('title')
    About us
@endsection

@section('body')
    {{-- About --}}
    <div id="about" class="about">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 position-relative border-end">
                    <div class="about-box">
                        <h2>About us</h2>
                        <p>
                            In HealthifyMe We believe that the path to a healthy body and a balanced life should be easy and effective.
                            That’s why we’ve developed a smart platform that helps you achieve your health goals through
                            personalized diet plans, accurate calorie counting, and a comprehensive food database.
                        </p>
                        <h4>
                            <strong>Our mission:</strong> Empowering you to make the right nutritional decisions in a simple and easy way.
                        </h4>
                        <h4>
                            <strong>Our vision:</strong> Using the latest technologies to provide smart nutritional solutions that suit all
                            individuals.
                        </h4>
                        <h4>
                            <strong>Our values:</strong> Quality - Innovation - Health - Ease of use.
                        </h4>
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
                        <figure><img src="{{ asset('images/logo.png') }}" alt="#" /></figure>
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

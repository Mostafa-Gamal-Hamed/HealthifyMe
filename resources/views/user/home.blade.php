@extends('user.layout')

@section('meta')
    <meta name="keywords"
        content="healthifyme, healthy living, weight loss, calorie calculator, calorie tracker, meal planner, healthy eating, nutrition, diet plans, low-calorie meals, wellness, fitness, balanced diet, healthy lifestyle">
    <meta name="description"
        content="Welcome to HealthifyMe — your personalized platform for diet plans, Discover delicious and nutritious healthy recipes, personalized diet plans, and smart calorie tracking tools to help you lose weight, eat better, and live healthier. Start your wellness journey with HealthifyMe today!">
@endsection

@section('title')
    HealthifyMe
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.green.min.css') }}">
    <style>
        #veg {
            transition: 1s ease-in-out !important;
        }

        #veg:hover {
            transform: rotateY(180deg) !important;
        }

        .owl-carousel {
            color: black;
            border-radius: 5%;
        }

        .owl-carousel p {
            font-weight: bold;
        }

        .carousel-testimonial figure img{
            width: 130px !important;
            height: 110px !important;
        }
    </style>
@endsection

@section('body')
    {{-- Loader --}}
    {{-- <div class="loader_bg">
        <div class="loader">
            <div class="spinner-border text-success fs-3" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div> --}}

    {{-- Message --}}
    @include('message')

    {{-- Header --}}
    <section class="slider_section">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container-fluid padding_dd">
                        <div class="carousel-caption">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="text-bg">
                                        <span>Welcome To</span>
                                        <h1>HealthifyMe</h1>
                                        <p>
                                            If you want to lose weight, gain muscle mass or maintain your weight, if you
                                            want a balanced diet that suits you
                                            <strong>HealthifyMe</strong> is your smart guide to a healthy and ideal body!
                                            Just enter your weight, height and some simple details, and we will prepare a
                                            customized diet for you that is automatically renewed every two weeks!
                                        <h3 class="badge bg-success fs-5" id="offerText">Free Diets</h3>
                                        </p>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('contact.create') }}">Contact Us</a>
                                            <a href="{{ route('food.foods') }}">Food</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                    <div class="">
                                        <figure><img src="images/img2.png" id="veg"></figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Offer --}}
    <div id="about" class="about">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 position-relative">
                    <div class="about-box">
                        <h2>What we offer you</h2>
                        <p>
                            Get the perfect diet for your healthy life
                            To lose weight or gain muscle mass or looking for a balanced and suitable diet for you
                            All you have to do is enter your weight, height and some simple details, and we will prepare a
                            customized diet for you that is automatically renewed every two weeks to reach your goal
                            Accurate calculation of the calories you need daily.
                            Various diets that suit your goals (weight loss - muscle mass gain - healthy balance).
                            A huge database of foods to know the calories and nutrients for each meal.
                            A smart control panel to track your progress and modify your plan easily.
                        </p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 padding_rl">
                    <div class="about-box_img">
                        <figure><img src="images/about.jpg" alt="#" /></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Latest news --}}
    <div class="container-fluid mt-5" id="latestNews">
        <div class="titlepage">
            <h2> <strong class="llow">Latest</strong>News </h2>
        </div>
        <div class="owl-carousel carousel-latestNews text-center owl-theme owl-loaded">
            <div class="owl-stage-outer">
                <div class="owl-stage">
                    @if ($blogs->isNotEmpty())
                        @foreach ($blogs as $blog)
                            <div class="owl-item">
                                <div class="card shadow shadow-lg">
                                    <img src="{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}"
                                        class="card-img-top" alt="Blog">
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><strong>{{ $blog->title }}</strong></h5>
                                        <p class="text-end text-muted p-0">{{ $blog->created_at->diffForHumans() }}</p>
                                        <p class="card-text mb-2">{!! Str::limit($blog->desc, 100) !!}</p>
                                        <a href="{{ route('blog.show', $blog->id) }}"
                                            class="btn btn-outline-success px-5">Read</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Food --}}
    <div id="vegetable" class="vegetable">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2> <strong class="llow">Interesting</strong> Information </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 ">
                    <div class="vegetable_shop">
                        <h3>Broccoli contains more protein than steak.</h3>
                        <p>
                            Gram for gram, broccoli packs more protein than most meats. Of course, you’d need to eat a lot
                            more broccoli to match a steak in terms of sheer protein volume, but it’s a testament to its
                            nutritional density. Broccoli is also loaded with vitamins K and C, which help in maintaining
                            healthy bones and boosting the immune system.
                        </p>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12  position-relative">
                    <div class="vegetable_img">
                        <figure><img src="{{ asset('images/v1.jpg') }}" alt="#" /></figure>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12  position-relative">
                    <div class="vegetable_img margin_top">
                        <figure><img src="{{ asset('images/home_food.png') }}" alt="#" /></figure>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Testimonial --}}
    <div class="mt-5 mb-5 p-4">
        <div class="titlepage">
            <h2> <strong class="llow">Testi</strong>monial </h2>
        </div>

        <div class="owl-carousel carousel-testimonial py-5 owl-theme owl-loaded bg-success">
            <div class="owl-stage-outer">
                <div class="owl-stage text-light">
                    <div class="owl-item">
                        <figure class="d-flex justify-content-center">
                            <img src="{{asset('images/testimonial/1.jpg')}}" class="rounded-circle" alt="testimonial">
                        </figure>
                        <div class="text-center">
                            <p class="fs-5 fst-italic">"I never thought losing weight could be this easy! Thanks to
                                HealthifyMe, I finally found a meal plan that fits my busy lifestyle."</p>
                            <h5 class="mt-3">— Sarah M., 29 years old</h5>
                        </div>
                    </div>

                    <div class="owl-item">
                        <figure class="d-flex justify-content-center">
                            <img src="{{asset('images/testimonial/3.jpg')}}" class="rounded-circle" alt="testimonial">
                        </figure>
                        <div class="text-center">
                            <p class="fs-5 fst-italic">"The calorie tracker and personalized diet plans helped me lose
                                12 kg in just 4 months! I feel healthier, stronger, and more confident than ever."</p>
                            <h5 class="mt-3">— Ahmed K., 34 years old</h5>
                        </div>
                    </div>

                    <div class="owl-item">
                        <figure class="d-flex justify-content-center">
                            <img src="{{asset('images/testimonial/2.jpg')}}" class="rounded-circle" alt="testimonial">
                        </figure>
                        <div class="text-center">
                            <p class="fs-5 fst-italic">"The platform is super easy to use, and the advice feels
                                personal, not generic. Highly recommend HealthifyMe to anyone serious about their
                                health!"</p>
                            <h5 class="mt-3">— Laura T., 25 years old</h5>
                        </div>
                    </div>

                    <div class="owl-item">
                        <figure class="d-flex justify-content-center">
                            <img src="{{asset('images/testimonial/4.png')}}" class="rounded-circle" alt="testimonial">
                        </figure>
                        <div class="text-center">
                            <p class="fs-5 fst-italic">"I love how the app suggests workouts tailored to my diet. It
                                feels like having a personal trainer and nutritionist in my pocket!"</p>
                            <h5 class="mt-3">— Omar S., 40 years old</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Loader
            setTimeout(function() {
                $('.loader_bg').fadeOut(500);
            }, 1000);

            // Offer
            setInterval(function() {
                $('#offerText').fadeTo(500, 1, function() {
                    setTimeout(function() {
                        $('#offerText').fadeTo(500, 0);
                    }, 500);
                });
            }, 1000);

            // Owl latestNews
            $('.carousel-latestNews').owlCarousel({
                loop: true,
                center: true,
                margin: 10,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    500: {
                        items: 2,
                        nav: false
                    },
                    900: {
                        items: 3,
                        nav: false
                    }
                }
            })

            // Owl testimonial
            $('.carousel-testimonial').owlCarousel({
                loop: true,
                margin: 5,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    480: {
                        items: 1,
                        nav: false
                    },
                    768: {
                        items: 1,
                        nav: false
                    }
                }
            })
        });
    </script>
@endsection

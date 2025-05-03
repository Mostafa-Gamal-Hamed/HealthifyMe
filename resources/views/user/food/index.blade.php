@extends('user.layout')

@section('meta')
    <meta name="title" content="Fresh Vegetables | HealthifyMe - Premium Quality Produce">
    <meta name="description" content="Discover the freshest, organically grown vegetables at HealthifyMe. We deliver premium quality produce straight from farm to your table.">
    <meta name="keywords" content="fresh vegetables, organic produce, healthy vegetables, farm to table, HealthifyMe veggies">

    <!-- Open Graph Tags -->
    <meta property="og:title" content="Fresh Vegetables | HealthifyMe - Premium Quality Produce">
    <meta property="og:description" content="Discover the freshest, organically grown vegetables at HealthifyMe.">
    <meta property="og:image" content="{{ asset('images/vegetables-social.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('title')
    Fresh Vegetables | HealthifyMe
@endsection

@section('style')
    <style>
        .vegetable-section {
            padding: 5rem 0;
            background-color: #f9fbf8;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2a5a3c;
        }

        .highlight {
            color: #4a9c6d;
        }

        .vegetable-content {
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
        }

        .vegetable-content h3 {
            color: #2a5a3c;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .vegetable-content p {
            color: #555;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .vegetable-img-container {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .vegetable-img-container:hover {
            transform: translateY(-5px);
        }

        .vegetable-img-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .img-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #4a9c6d;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .margin-top {
            margin-top: 2rem;
        }

        @media (max-width: 992px) {
            .vegetable-content {
                margin-bottom: 2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }
        }
    </style>
@endsection

@section('body')
    <section class="vegetable-section">
        <div class="container">
            <div class="section-title">
                <h2>Food <span class="highlight">Categories</span></h2>
                <p class="lead">All this for you, for healthy life</p>
            </div>

            <div class="row align-items-center">
                @foreach ($categories as $category)
                <div class="col-lg-4 mb-4">
                    <div class="vegetable-img-container">
                        <a href="{{ route('food.type', $category->name) }}">
                            <div class="card position-relative text-center">
                                <div>
                                    <img src="{{$category->image ? asset("storage/$category->image") : asset("images/foods/1-vegetable.jpg") }}" alt="image"
                                    class="img-fluid">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title fw-bold">{{ $category->name }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Animation for vegetable images
            $('.vegetable-img-container').each(function(index) {
                $(this).css('opacity', 0);
                setTimeout(() => {
                    $(this).animate({opacity: 1}, 800);
                }, index * 300);
            });

            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $($(this).attr('href')).offset().top - 100
                }, 800);
            });
        });
    </script>
@endsection

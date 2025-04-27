@extends('user.layout')

@section('meta')
    <meta name="keywords"
        content="{{ $diet->name }}, diet plan, {{ $diet->name }} benefits, HealthifyMe, personalized nutrition, {{ implode(', ', explode(' ', $diet->name)) }}">
    <meta name="description"
        content="Discover the {{ $diet->name }} diet plan. {{ Str::limit(strip_tags($diet->description), 150) }} Tailored for your health goals at HealthifyMe.">
@endsection

@section('name')
    {{ $diet->name }} | HealthifyMe
@endsection

@section('body')
    <div class="container mb-5">
        <div class="namepage mt-2">
            <div class="p-2 border m-auto" style="max-width: 90%;height: 90%;">
                <img src="{{ $diet->image ? asset("storage/$diet->image") : asset('images/diets/Diet.jpg') }}"
                    alt="{{ $diet->name }}">
            </div>
            <h2 class="text-center mt-3">{{ $diet->name }}</h2>
        </div>

        {{-- Description --}}
        <div class="p-3 shadow bg-light shadow-lg">
            <h3 class="text-center"><strong>Description</strong></h3>
            <h4>{!! $diet->description !!}</h4>
            <h4><strong>Calories:</strong> {{ $diet->calories }}</h4>
            <hr>
            <h3 class="text-center"><strong>Workouts</strong></h3>
            <h4>{{ $diet->workouts }}</h4>
            <div class="d-flex justify-content-end">
                <p class="text-muted">{{ $diet->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
@endsection

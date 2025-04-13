@extends('user.layout')

@section('meta')
    <meta name="keywords"
        content="category, category recipes, healthy recipes, nutritious meals, clean eating, snacks, healthy snacks, delicious meals, low-calorie recipes, meal prep, diet food, weight loss meals, healthy meal ideas">
    <meta name="description"
        content="category, Discover a variety of easy and nutritious healthy recipes, including snacks, meals, and diet-friendly options to support your wellness and weight loss goals.">
@endsection

@section('title')
    {{ $category->name }} Recipes | HealthifyMe
@endsection

@section('body')
    <div class="titlepage mt-5">
        <h2>{{ $category->name }} Recipes</h2>

        {{-- Search --}}
        @include("user.recipe.search")
    </div>

    <div class="container mb-5">
        <div class="row align-items-center gap-3 justify-content-around" id="blogsContainer">
            @foreach ($recipes as $recipe)
                <div class="card col" style="min-width: 20rem;">
                    <img src="{{ $recipe->images ? asset("storage/{$recipe->images[0]}") : asset('images/recipes/recipe.png') }}"
                        class="card-img-top" style="width:100%; height:200px; object-fit: cover;" alt="Recipe">
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2 align-self-start">{{ $recipe->category->name }}</span>
                        <h3>
                            <a href="{{ route('healthy-recipe.show', $recipe->id) }}"
                                class="text-decoration-underline">{{ $recipe->title }}</a>
                        </h3>
                        <p class="text-start text-muted p-0">By {{ $recipe->user->firstName }} {{ $recipe->user->lastName }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

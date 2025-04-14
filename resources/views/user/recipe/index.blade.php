@extends('user.layout')

@section('meta')
    <meta name="keywords" content="healthy recipes, nutritious meals, clean eating, snacks, healthy snacks, delicious meals, low-calorie recipes, meal prep, diet food, weight loss meals, healthy meal ideas">
    <meta name="description" content="Discover a variety of easy and nutritious healthy recipes, including snacks, meals, and diet-friendly options to support your wellness and weight loss goals.">
@endsection

@section('title')
    Healthy Recipes | HealthifyMe
@endsection

@section('body')
    <div class="titlepage mt-5">
        <h2>Healthy Recipes</h2>
        {{-- Search --}}
        @include("user.recipe.search")
    </div>

    <div class="container mb-5">
        <div class="row align-items-center gap-3 justify-content-around" id="blogsContainer">
            @foreach ($recipes as $recipe)
                <div class="card col-3" style="width: 18rem;">
                    <img src="{{ $recipe->images ? asset("storage/{$recipe->images[0]}") : asset('images/recipes/recipe.png') }}"
                        class="card-img-top" style="width:100%; height:200px; object-fit: cover;" alt="Recipe">
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2 align-self-start">{{ $recipe->category->name }}</span>
                        <h3>
                            <a href="{{ route('healthy-recipe.show', $recipe->id) }}" class="text-decoration-underline">{{ $recipe->title }}</a>
                        </h3>
                        <p class="text-start text-muted p-0">By {{ $recipe->user->firstName }} {{ $recipe->user->lastName }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($recipes->isNotEmpty() && empty(trim($search ?? '')))
            <div id="showMoreBlogs"></div>
            <div class="w-100 mt-3 text-center">
                <button type="button" class="btn btn-primary px-5" id="moreRecipes">More</button>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const limit = 9;
            let offset  = {{ count($recipes) }};

            const $moreButton  = $('#moreRecipes');
            const $container   = $('#blogsContainer');
            const baseUrl      = "{{ route('healthy-recipe.recipes') }}";
            const defaultImage = "{{ asset('images/recipes/recipe.png') }}";
            const storagePath  = "{{ asset('storage') }}/";
            const showRoute    = "{{ url('healthy-recipe') }}";

            $moreButton.on('click', function() {
                $(this).prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                    );

                $.ajax({
                    url: baseUrl,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        offset: offset
                    },
                    success: function(response) {
                        if (response.recipes.length > 0) {
                            const recipesHtml = response.recipes.map(recipe => {
                                const firstImage = recipe.images && recipe.images[0] ?
                                    storagePath + recipe.images[0] :
                                    defaultImage;

                                return `
                                    <div class="card col-3" style="width: 18rem;">
                                        <img src="${firstImage}" class="card-img-top"
                                        style="width:100%; height:200px; object-fit: cover;" alt="${recipe.title}">
                                        <div class="card-body d-flex flex-column">
                                            <span class="badge bg-secondary mb-2 align-self-start">
                                                ${recipe.category?.name || 'Uncategorized'}
                                            </span>
                                            <h5 class="card-title">
                                                <a href="${showRoute}/${recipe.id}" class="text-decoration-underline">
                                                    ${recipe.title}
                                                </a>
                                            </h5>
                                            <p class="card-text text-muted mt-auto">
                                                By ${recipe.user?.firstName || ''} ${recipe.user?.lastName || ''}
                                            </p>
                                        </div>
                                    </div>`;
                            }).join('');

                            $container.append(recipesHtml);
                            offset += response.recipes.length;

                            if (!response.hasMore) {
                                $moreButton.remove();
                            }
                        } else {
                            $moreButton.remove();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading recipes:', xhr.responseText);
                        $moreButton.html('Error - Click to try again');
                    },
                    complete: function() {
                        $moreButton.prop('disabled', false).text('Load More Recipes');
                    }
                });
            });
        });
    </script>
@endsection

@extends('user.layout')

@section('meta')
    <meta name="keywords"
        content="diet plans, HealthifyMe, weight loss, healthy eating, keto diet, intermittent fasting, vegan diet, balanced meals, low-carb diet, meal planning, personalized diet, fitness nutrition, best diet programs, healthy lifestyle">
    <meta name="descriptionription"
        content="Explore a variety of diet plans for weight loss, muscle gain, and healthy living. Find the best keto, intermittent fasting, vegan, and balanced meal plans tailored to your goals at HealthifyMe.">
@endsection

@section('title')
    Diets | HealthifyMe
@endsection

@section('body')
    <div class="titlepage mt-5">
        <h2>Diets</h2>
    </div>

    <div class="container mb-5">
        @if ($diets->isEmpty())
            <h2 class="text-center text-danger fw-bold">Empty</h2>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4" id="dietsContainer">
                @foreach ($diets as $diet)
                    <div class="col">
                        <div class="card h-100 diet-card">
                            <div class="card-img-container">
                                <img src="{{ $diet->image ? asset("storage/{$diet->image}") : asset('images/modern_logo.png') }}"
                                    class="card-img-top img-fluid" alt="{{ $diet->name }}" loading="lazy">
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center">
                                    <strong>{{ Str::title($diet->name) }}</strong>
                                </h5>

                                <small class="text-muted text-end mb-2">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $diet->created_at->diffForHumans() }}
                                </small>

                                <div class="card-text mb-3 flex-grow-1">
                                    {!! Str::limit(strip_tags($diet->description), 100) !!}
                                </div>

                                <div class="text-center mt-auto">
                                    <a href="{{ route('diet.show', $diet->id) }}"
                                        class="btn btn-outline-success px-4 stretched-link">
                                        <i class="fas fa-book-open me-2"></i>Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (count($diets) > 9)
                <div id="showMoreDiets"></div>
                <div class="w-100 mt-3 text-center">
                    <button type="button" class="btn btn-primary px-5" id="moreDiets">More</button>
                </div>
            @endif
        @endif
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const limit = 9;
            let offset = {{ count($diets) }};

            const $moreButton = $('#moreDiets');
            const $container = $('#dietsContainer');
            const baseUrl = "{{ route('diet.diets') }}";
            const defaultImage = "{{ asset('images/modern_logo.png') }}";
            const imagesPath = "{{ asset('images') }}/";
            const showRoute = "{{ url('diet') }}";

            $moreButton.on('click', function() {
                const $button = $(this);
                $button.prop('disabled', true)
                    .html(
                        '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Loading...'
                    );

                $.ajax({
                    url: baseUrl,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        offset: offset,
                        limit: limit
                    },
                    success: function(response) {
                        if (response.diets && response.diets.length > 0) {
                            const dietsHtml = response.diets.map(diet => {
                                const imageSrc = diet.image ? imagesPath + diet.image :
                                    defaultImage;
                                const description = diet.description ? diet.description
                                    .substring(0, 100) + (
                                        diet.description.length > 100 ? '...' : '') :
                                    '';
                                const date = diet.created_at ? new Date(diet.created_at)
                                    .toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'short',
                                        day: 'numeric'
                                    }) : '';

                                return `
                                    <div class="col">
                                        <div class="card h-100 diet-card">
                                            <div class="card-img-container">
                                                <img src="${imageSrc}"
                                                    class="card-img-top img-fluid" alt="${diet.name}" loading="lazy">
                                            </div>

                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title text-center">
                                                    <strong>${diet.title}</strong>
                                                </h5>

                                                <small class="text-muted text-end mb-2">
                                                    <i class="far fa-clock me-1"></i>
                                                    ${date}
                                                </small>

                                                <div class="card-text mb-3 flex-grow-1">
                                                    ${description}
                                                </div>

                                                <div class="text-center mt-auto">
                                                    <a href="${showRoute}/${diet.id}"
                                                        class="btn btn-outline-success px-4 stretched-link">
                                                        <i class="fas fa-book-open me-2"></i>Read More
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            }).join('');

                            $container.append(dietsHtml);
                            offset += response.diets.length;

                            if (!response.hasMore) {
                                $button.remove();
                            }
                        } else {
                            $button.remove();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading diets:', xhr.responseText);
                        $button.html('Error - Click to try again');
                    },
                    complete: function() {
                        $button.prop('disabled', false).text('Load More diets');
                    }
                });
            });
        });
    </script>
@endsection

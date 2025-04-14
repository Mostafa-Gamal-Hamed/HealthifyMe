@extends('user.layout')

@section('meta')
    <meta name="keywords" content="{{ $recipe->title }}, healthy recipes, nutritious meals, clean eating, snacks, healthy snacks, delicious meals, low-calorie recipes, meal prep, diet food, weight loss meals, healthy meal ideas">
    <meta name="description" content="{{ $recipe->title }}, Discover a variety of easy and nutritious healthy recipes, including snacks, meals, and diet-friendly options to support your wellness and weight loss goals.">
@endsection

@section('title')
    {{ $recipe->title }}
@endsection

@section('body')
    <div class="container mb-5">
        <div class="titlepage mt-2">
            <h2 class="text-center mt-3">{{ $recipe->title }}</h2>
            <div class="row g-2 mt-3">
                <picture class="col">
                    @if ($recipe->images)
                        @foreach (json_decode($recipe->images) as $image)
                            <img src="{{ asset("storage/$image") }}" class="img-fluid rounded mb-2"
                                data-featherlight="<img src='{{ asset("storage/$image") }}' class='img-fluid' alt='Recipe' style='max-width:400px;'>"
                                style="max-height:300px; cursor:zoom-in;" alt="Recipe">
                        @endforeach
                    @else
                        <img src="{{ asset('images/recipes/recipe.png') }}"
                            class="img-fluid rounded" style="max-height:300px;" alt="Recipe">
                    @endif
                </picture>
            </div>
            <hr>
            <video class="col" style="max-height:400px;" controls>
                <source
                    src="{{ $recipe->video ? asset("storage/$recipe->video") : asset('images/recipes/video.png') }}"
                    type="video/mp4">
            </video>
        </div>

        {{-- Description --}}
        <div class="p-3 shadow bg-light shadow-lg">
            <h4>{!! $recipe->description !!}</h4>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#like").on('click', function(e) {
                e.preventDefault();

                const button = $(this);
                const id     = button.data('id');
                const user   = button.data('user');
                const url    = "{{ url('blog/like', '') }}/" + id;
                const data   = {
                    _token: '{{ csrf_token() }}',
                    user: user
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.location) {
                            window.location.href = "{{ route('login') }}";
                        }
                        $('#likes-count-' + id).text(response.likes_count);
                        $('#disLike-count-' + id).text(response.disLikes_count);
                    },
                    error: function(xhr, status, error) {
                        console.error(`Error occurred: ${error}`);
                    }
                });
            });

            $("#disLike").on('click', function(e) {
                e.preventDefault();

                const button = $(this);
                const id     = button.data('id');
                const user   = button.data('user');
                const url    = "{{ url('blog/disLike') }}/" + id;
                const data   = {
                    _token: '{{ csrf_token() }}',
                    user: user
                };

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.location) {
                            window.location.href = "{{ route('login') }}";
                        }
                        $('#likes-count-' + id).text(response.likes_count);
                        $('#disLike-count-' + id).text(response.disLikes_count);
                    },
                    error: function(xhr, status, error) {
                        console.error(`Error occurred: ${error}`);
                    }
                });
            });
        });
    </script>
@endsection

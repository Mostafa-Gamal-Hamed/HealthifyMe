@extends('user.layout')

@section('meta')
<meta name="keywords" content="{{ $blog->title }} blog, nutrition tips, {{ $blog->title }}, healthy lifestyle, weight loss advice, wellness articles, fitness blog">
<meta name="description" content="{{ $blog->title }} ,Read expert articles, tips, and insights on healthy living, nutrition, weight loss, and fitness. Stay informed and inspired on your health journey.">
@endsection

@section('title')
    {{ $blog->title }} | HealthifyMe
@endsection

@section('body')
    <div class="container mb-5">
        <div class="titlepage mt-2">
            <div class="p-2 m-auto" style="max-width: 90%;height: 90%;">
                <img src="{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}"
                class="w-50 rounded" alt="{{ $blog->title }}">
            </div>
            <h2 class="text-center mt-3">{{ $blog->title }}</h2>
        </div>

        {{-- Description --}}
        <div class="p-3 shadow bg-light shadow-lg">
            <h4>{!! $blog->desc !!}</h4>
            <div class="d-flex justify-content-between">
                <p class="text-muted">By: {{ $blog->user->firstName }} {{ $blog->user->lastName }}</p>
                <p class="text-muted">{{ $blog->created_at->diffForHumans() }}</p>
            </div>
            <div class="d-flex justify-content-end align-items-center gap-3 mt-3">
                <button type="button" class="btn btn-outline-primary border px-5" id="like"
                    data-id="{{ $blog->id }}" data-user="{{ Auth::id() ?? 0 }}">
                    <i class="fa-solid fa-thumbs-up"></i> <span
                        id="likes-count-{{ $blog->id }}">{{ $blog->likes_count }}</span>
                </button>

                <button type="button" class="btn btn-outline-danger border px-5" id="disLike"
                    data-id="{{ $blog->id }}" data-user="{{ Auth::id() ?? 0 }}">
                    <i class="fa-solid fa-thumbs-down"></i> <span
                        id="disLike-count-{{ $blog->id }}">{{ $blog->disLikes_count }}</span>
                </button>
            </div>
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
                const url    = "{{ url('blog/like') }}/" + id;
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

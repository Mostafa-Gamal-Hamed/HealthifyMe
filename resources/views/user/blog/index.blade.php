@extends('user.layout')

@section('meta')
    <meta name="keywords"
        content="health blog, nutrition tips, healthy lifestyle, weight loss advice, wellness articles, fitness blog">
    <meta name="description"
        content="Read expert articles, tips, and insights on healthy living, nutrition, weight loss, and fitness. Stay informed and inspired on your health journey.">
@endsection

@section('title')
    Blogs | HealthifyMe
@endsection

@section('body')
    <div class="titlepage mt-5">
        <h2>Blogs</h2>
    </div>

    <div class="container mb-5">
        @if ($blogs->isEmpty())
            <h2 class="text-center text-danger fw-bold">Empty</h2>
        @else
            <div class="row align-items-center gap-3 justify-content-around" id="blogsContainer">
                @foreach ($blogs as $blog)
                    <div class="card col-3" style="width: 18rem;">
                        <img src="{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}"
                            class="card-img-top" alt="Blog">
                        <div class="card-body">
                            <h5 class="card-title text-center"><strong>{{ $blog->title }}</strong></h5>
                            <p class="text-end text-muted p-0">{{ $blog->created_at->diffForHumans() }}</p>
                            <p class="card-text mb-2">{!! Str::limit($blog->desc, 100) !!}</p>
                            <a href="{{ route('blog.show', $blog->id) }}" class="btn btn-outline-success px-5">Read</a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (count($blogs) > 9)
                <div id="showMoreBlogs"></div>
                <div class="w-100 mt-3 text-center">
                    <button type="button" class="btn btn-primary px-5" id="moreBlogs">More</button>
                </div>
            @endif
        @endif
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const limit = 9;
            let offset  = {{ count($blogs) }};

            const $moreButton  = $('#moreBlogs');
            const $container   = $('#blogsContainer');
            const baseUrl      = "{{ route('blog.blogs') }}";
            const defaultImage = "{{ asset('images/modern_logo.png') }}";
            const imagesPath   = "{{ asset('images') }}/";
            const showRoute    = "{{ url('blog') }}";

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
                        if (response.blogs && response.blogs.length > 0) {
                            const blogsHtml = response.blogs.map(blog => {
                                const imageSrc = blog.image ? imagesPath + blog.image :
                                    defaultImage;
                                const desc = blog.desc ? blog.desc.substring(0, 100) + (
                                    blog.desc.length > 100 ? '...' : '') : '';
                                const date = blog.created_at ? new Date(blog.created_at)
                                    .toLocaleDateString('en-US', {
                                        year: 'numeric',
                                        month: 'short',
                                        day: 'numeric'
                                    }) : '';

                                return `
                                    <div class="card col-3" style="width: 18rem;">
                                        <img src="${imageSrc}" class="card-img-top" alt="${blog.title}"
                                            style="height: 200px; object-fit: cover;">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-center"><strong>${blog.title}</strong></h5>
                                            <small class="text-muted text-end mb-2">${date}</small>
                                            <div class="card-text mb-3 flex-grow-1">${desc}</div>
                                            <a href="${showRoute}/${blog.id}"
                                            class="btn btn-outline-success align-self-center px-4">
                                                Read More
                                            </a>
                                        </div>
                                    </div>`;
                            }).join('');

                            $container.append(blogsHtml);
                            offset += response.blogs.length;

                            if (!response.hasMore) {
                                $button.remove();
                            }
                        } else {
                            $button.remove();
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading blogs:', xhr.responseText);
                        $button.html('Error - Click to try again');
                    },
                    complete: function() {
                        $button.prop('disabled', false).text('Load More Blogs');
                    }
                });
            });
        });
    </script>
@endsection

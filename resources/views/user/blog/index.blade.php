@extends('user.layout')

@section('title')
    Blogs
@endsection

@section('body')
    <div class="titlepage mt-5">
        <h2>Blogs</h2>
    </div>

    <div class="container mb-5">
        <div class="row align-items-center gap-3 justify-content-around" id="blogsContainer">
            @foreach ($blogs as $blog)
                <div class="card col-3" style="width: 18rem;">
                    <img src="{{ $blog->image ? asset("images/$blog->image") : asset('images/modern_logo.png') }}"
                        class="card-img-top" alt="Blog">
                    <div class="card-body">
                        <h5 class="card-title text-center"><strong>{{ $blog->title }}</strong></h5>
                        <p class="text-end text-muted p-0">{{ $blog->created_at }}</p>
                        <p class="card-text mb-2">{!! Str::limit($blog->desc, 100) !!}</p>
                        <a href="{{ route('blog.show', $blog->id) }}" class="btn btn-outline-success px-5">Read</a>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($blogs->isNotEmpty())
            <div id="showMoreBlogs"></div>
            <div class="w-100 mt-3 text-center">
                <button type="button" class="btn btn-primary px-5" id="moreBlogs">More</button>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var offset = {{ count($blogs) }};
            var limit = 9;

            $('#moreBlogs').click(function() {
                $.ajax({
                    url: "{{ route('blog.blogs') }}",
                    type: 'GET',
                    data: {
                        offset: offset,
                        limit: limit
                    },
                    success: function(response) {
                        if (response.blogs.length > 0) {
                            var blogsHtml = '';
                            $.each(response.blogs, function(index, blog) {
                                blogsHtml += `
                                <div class="card col-3" style="width: 18rem;">
                                    <img src="${blog.image ? '{{ asset('images') }}/' + blog.image : '{{ asset('images/home_food.png') }}'}"
                                        class="card-img-top" alt="Blog">
                                    <div class="card-body">
                                        <h5 class="card-title text-center"><strong>${blog.title}</strong></h5>
                                        <p class="text-end text-muted p-0">${blog.created_at}</p>
                                        <p class="card-text mb-2">${blog.desc.substring(0, 100)}...</p>
                                        <a href="{{ route('blog.show', '') }}/${blog.id}" class="btn btn-outline-success px-5">Read</a>
                                    </div>
                                </div>
                            `;
                            });

                            $('#blogsContainer').append(blogsHtml);
                            offset += limit;

                            if (!response.hasMore) {
                                $('#moreBlogs').hide();
                            }
                        } else {
                            $('#moreBlogs').hide();
                        }
                    }
                });
            });
        });
    </script>
@endsection

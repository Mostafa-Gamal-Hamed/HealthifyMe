@extends('admin.layout')

@section('title')
    Blogs
@endsection

@section('body')
    <div class="p-3">
        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($blogs->isEmpty())
                <h3 class="mb-5 text-center text-danger">No blogs found.</h3>
            @else
                <div class="row justify-content-between align-items-center mb-4">
                    <h6 class="col">Blogs</h6>
                    <form class="col" role="search">
                        <input class="form-control me-2" type="text" id="search" placeholder="Search slug"
                            aria-label="Search">
                    </form>
                </div>
                <div class="table-responsive">
                    {{ $blogs->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Title</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image</th>
                                <th scope="col">Created at</th>
                                <th scope="col" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>{{ $blog->id }}</td>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ $blog->slug }}</td>
                                    <td>
                                        <span data-featherlight="<p>{{ $blog->desc }}</p>" style="cursor: pointer;">
                                            {!! Str::limit($blog->desc, 40, '...') !!}
                                        </span>
                                    </td>
                                    <td>
                                        <img src="{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}"
                                            data-featherlight="<img src='{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}' width='300px' alt='Blog'>"
                                            style="cursor: pointer;" class="img-fluid rounded-circle" width="80px"
                                            alt="Blog">
                                    </td>
                                    <td>{{ $blog->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.blog.show', $blog->id) }}" class="btn btn-md btn-info"
                                            title="Show">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-md btn-success"
                                            title="Edit">
                                            <i class="fa-solid fa-edit"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.blog.delete', $blog->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-md"
                                                onclick="return confirm('Are you sure?');" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#search").on("input", function() {
                var value = $(this).val().toLowerCase();
                $('#showTable').find('thead').hide();
                $('#showTable').find('tbody').hide();

                if (value === ' ') {
                    $('#showTable').find('thead').show();
                    $('#showTable').find('tbody').show();
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ url('blogSearch') }}/" + value,
                    success: function(response) {
                        if (response.blog && response.blog.length != 0) {
                            var blog = response.blog;

                            var body = $('#showTable').find('tbody');
                            body.empty();

                            var created_at = new Date(blog.created_at);
                            var createdAt = created_at.toLocaleDateString('en-GB');

                            var data = `data-featherlight='<p>${blog.desc}</p>'`;
                            var description = `
                                <span ${data} style="cursor: pointer;">
                                    ${blog.desc.length > 50 ? blog.desc.substring(0, 50) + '....' : blog.desc}
                                </span>
                            `;

                            var image = `
                                <img src="${blog.image ? '{{ asset('storage') }}/' + blog.image : '{{ asset('images/modern_logo.png') }}'}"
                                    data-featherlight="<img src='${blog.image ? '{{ asset('storage') }}/' + blog.image : '{{ asset('images/modern_logo.png') }}'}' width='300px' alt='Blog'>"
                                    style="cursor: pointer;" class="img-fluid rounded-circle" width="80px" alt="Blog">
                            `;

                            var show   = `{{ url('showBlog') }}/${blog.id}`;
                            var edit   = `{{ url('editBlog') }}/${blog.id}`;
                            var remove = `{{ url('deleteBlog') }}/${blog.id}`;

                            body.append(`
                                <tr>
                                    <td scope="row">${blog.id}</td>
                                    <td>${blog.title}</td>
                                    <td>${blog.slug}</td>
                                    <td>${description}</td>
                                    <td>${image}</td>
                                    <td>${createdAt}</td>
                                    <td>
                                        <a href="${show}" class="btn btn-md btn-info">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="${edit}" class="btn btn-md btn-success"
                                            title="Edit">
                                            <i class="fa-solid fa-edit"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="${remove}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-md"
                                                onclick="return confirm('Are you sure?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            `);

                        } else {
                            $('#showTable tbody').html(
                                `<tr><td colspan="8" class='text-danger fw-bold'>No results found.</td></tr>`
                            );
                        }

                        $('#showTable').find('thead').show();
                        $('#showTable').find('tbody').show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection

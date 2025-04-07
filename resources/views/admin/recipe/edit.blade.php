@extends('admin.layout')

@section('title')
    {{ $recipe->title }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $recipe->title }}</h2>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.recipe.update', $recipe->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ $recipe->title }}" placeholder="Write Title">
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Write description" id="description" style="height: 100px">{{ $recipe->description }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Calories --}}
                        <div class="mb-3">
                            <label for="calories">Calories</label>
                            <input type="number" name="calories"
                                class="form-control @error('calories') is-invalid @enderror" value="{{ $recipe->calories }}"
                                id="calories" placeholder="Write calories">
                            @error('calories')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Old video --}}
                        <div class="mb-3">
                            <label for="oldImages">Old Video:</label><br>
                            <video style="max-height:150px; max-width: 150px;" controls>
                                <source
                                    src="{{ $recipe->video ? asset("storage/$recipe->video") : asset('images/recipes/video.png') }}"
                                    type="video/mp4">
                            </video>
                        </div>

                        {{-- Video --}}
                        <div class="mb-3">
                            <label for="video">Video (MP4 only)</label>
                            <input type="file" name="video" class="form-control @error('video') is-invalid @enderror"
                                value="{{ old('video') }}" id="video" accept=".mp4">
                            @error('video')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- oldImages --}}
                        <div class="mb-3">
                            <label for="oldImages">Old Images:</label>
                            <picture>
                                @if ($recipe->images)
                                    @foreach (json_decode($recipe->images) as $image)
                                        <img data-featherlight="<img src='{{ asset("storage/$image") }}' style='max-width: 300px;' alt='oldImage'>"
                                            src="{{ asset("storage/$image") }}" style="cursor: pointer;" width="100px"
                                            alt="oldImage">
                                    @endforeach
                                @else
                                    <p>No images available.</p>
                                @endif
                            </picture>
                        </div>

                        {{-- Images --}}
                        <div class="mb-3">
                            <label for="images">New Images (JPG, JPEG, PNG, GIF)</label>
                            <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror"
                                id="images" multiple accept=".jpg, .jpeg, .png, .gif">
                            @error('images')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md px-5 btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js"
        integrity="sha512-bib7srucEhHYYWglYvGY+EQb0JAAW0qSOXpkPTMgCgW8eLtswHA/K4TKyD4+FiXcRHcy8z7boYxk0HTACCTFMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        tinymce.init({
            selector: '#description',
            plugins: 'autoresize link image lists table code fullscreen',
            toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | forecolor backcolor removeformat | table media | lineheight outdent indent | charmap emoticons | code fullscreen preview | pagebreak anchor codesample | ltr rtl",
            height: 200,
            menubar: false,
            toolbar_sticky: true,
            branding: false,
            content_style: 'body { font-family:Arial, sans-serif; font-size:14px; }',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            },
        });
    </script>
@endsection

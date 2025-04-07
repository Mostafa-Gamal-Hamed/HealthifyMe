@extends('admin.layout')

@section('title')
    Add Recipe
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">Add New Recipe</h2>

        {{-- Success Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.recipe.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        {{-- Recipe Title --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title') }}" placeholder="Recipe Title" required>
                            <label for="title">Recipe Title</label>
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Recipe Description" id="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Calories --}}
                        <div class="form-floating mb-3">
                            <input type="number" name="calories"
                                class="form-control @error('calories') is-invalid @enderror" value="{{ old('calories') }}"
                                id="calories" placeholder="Calories" required>
                            <label for="calories">Calories</label>
                            @error('calories')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
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

                        {{-- Images --}}
                        <div class="mb-3">
                            <label for="images">Images (JPG, JPEG, PNG, GIF)</label>
                            <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror"
                                value="{{ old('images') }}" id="images" multiple accept=".jpg, .jpeg, .png, .gif">
                            @error('images')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="btn btn-md px-5 btn-success">Create Recipe</button>
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

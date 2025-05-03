@extends('admin.layout')

@section('title', 'Create New Blog')

@section('style')
    <style>
        .blog-form-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-floating label {
            transition: all 0.2s ease;
        }

        .image-preview {
            max-width: 300px;
            max-height: 200px;
            margin-top: 15px;
            display: none;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }

        .editor-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center text-primary fw-bold mb-4">Create New Blog</h2>

                @include('admin.success')

                <div class="blog-form-container p-4 mb-5">
                    <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data" id="blogForm">
                        @csrf

                        {{-- Title --}}
                        <div class="form-floating mb-4">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title') }}" placeholder="Blog post title" required>
                            <label for="title">Post Title</label>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="form-floating mb-4">
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                id="slug" value="{{ old('slug') }}" placeholder="post-slug" required>
                            <label for="slug">URL Slug</label>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Will be auto-generated if left empty</small>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <div class="editor-header">
                                <h5 class="mb-0">Post Content</h5>
                            </div>
                            <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" id="desc"
                                placeholder="Write your content here...">{{ old('desc') }}</textarea>
                            @error('desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-4">
                            <label for="image" class="form-label">Featured Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image" accept="image/*" onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="imagePreview" class="image-preview" alt="Image preview">
                            <small class="text-muted d-block">Recommended size: 1200x630 pixels</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2 px-4">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-plus-circle me-2"></i>Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- TinyMCE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js"
        integrity="sha512-bib7srucEhHYYWglYvGY+EQb0JAAW0qSOXpkPTMgCgW8eLtswHA/K4TKyD4+FiXcRHcy8z7boYxk0HTACCTFMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#desc',
            plugins: 'autoresize link image lists table code fullscreen media preview',
            toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
                'alignleft aligncenter alignright alignjustify | bullist numlist | ' +
                'link image media | forecolor backcolor | code preview',
            height: 400,
            menubar: false,
            branding: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            images_upload_url: '{{ url('admin.blog.store') }}',
            automatic_uploads: true,
            file_picker_types: 'image media',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });

        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const slugInput = document.getElementById('slug');
            if (!slugInput.value) {
                slugInput.value = this.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '') // Remove special chars
                    .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
                    .replace(/^-+|-+$/g, ''); // Trim hyphens from start/end
            }
        });

        // Image preview functionality
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        // Form validation
        document.getElementById('blogForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const content = tinymce.get('desc').getContent().trim();

            if (!title) {
                e.preventDefault();
                alert('Please enter a title for your blog post');
                document.getElementById('title').focus();
            }

            if (!content) {
                e.preventDefault();
                alert('Please write some content for your blog post');
                tinymce.get('desc').focus();
            }
        });
    </script>
@endsection

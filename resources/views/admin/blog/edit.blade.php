@extends('admin.layout')

@section('title', 'Edit: ' . $blog->title)

@section('style')
    <style>
        .blog-edit-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .image-preview-container {
            position: relative;
            display: inline-block;
            margin-top: 15px;
        }

        .current-image {
            max-width: 300px;
            max-height: 200px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .current-image:hover {
            transform: scale(1.03);
        }

        .remove-image-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
        }

        .editor-header {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">Editing: <span class="text-primary">{{ $blog->title }}</span></h2>
                    <a href="{{ route('admin.blog.show', $blog->id) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye me-1"></i> View Post
                    </a>
                </div>

                @include('admin.success')

                <div class="blog-edit-container p-4 mb-5">
                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="post" enctype="multipart/form-data"
                        id="blogEditForm">
                        @csrf
                        @method('PUT')

                        {{-- Title --}}
                        <div class="mb-4">
                            <label for="title" class="form-label">Post Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ old('title', $blog->title) }}" placeholder="Enter post title"
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="mb-4">
                            <label for="slug" class="form-label">URL Slug</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                id="slug" value="{{ old('slug', $blog->slug) }}" placeholder="post-url-slug">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty to auto-generate from title</small>
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <div class="editor-header">
                                <label class="form-label">Post Content</label>
                            </div>
                            <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" id="desc">{{ old('desc', $blog->desc) }}</textarea>
                            @error('desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Current Image --}}
                        <div class="mb-4">
                            <label class="form-label">Current Featured Image</label>
                            @if ($blog->image)
                                <div class="image-preview-container">
                                    <img src="{{ asset("storage/$blog->image") }}" class="current-image"
                                        alt="Current blog image"
                                        onclick="window.open('{{ asset("storage/$blog->image") }}', '_blank')">
                                    <button type="button" class="remove-image-btn"
                                        onclick="document.getElementById('remove_image').value = '1'; this.parentNode.querySelector('img').style.opacity = '0.5';">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_image" id="remove_image" value="0">
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-circle me-2"></i> No featured image currently set
                                </div>
                            @endif
                        </div>

                        {{-- New Image --}}
                        <div class="mb-4">
                            <label for="image" class="form-label">Upload New Featured Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image" accept="image/*" onchange="previewNewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block">Recommended size: 1200x630 pixels (will replace current
                                image)</small>
                            <img id="newImagePreview" class="current-image mt-3" style="display: none;">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2 px-4">
                                <i class="fas fa-undo me-2"></i> Reset Changes
                            </button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i> Update Post
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
            images_upload_url: '{{ url('updateBlog') }}',
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

        // New image preview functionality
        function previewNewImage(input) {
            const preview = document.getElementById('newImagePreview');
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
        document.getElementById('blogEditForm').addEventListener('submit', function(e) {
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

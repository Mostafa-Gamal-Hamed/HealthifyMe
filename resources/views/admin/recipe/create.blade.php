@extends('admin.layout')

@section('title', 'Add New Recipe')

@section('style')
    <style>
        .recipe-form-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .file-upload-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }

        .file-upload-label {
            display: block;
            padding: 0.75rem;
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            border-color: #adb5bd;
            background: #e9ecef;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-item {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }

        .preview-item img,
        .preview-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-preview {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
@endsection

@section('body')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="text-center text-success fw-bold mb-4">{{ __('Add New Recipe') }}</h2>

            @include('admin.success')

            <div class="recipe-form-container p-4 mb-5">
                <form action="{{ route('admin.recipe.store') }}" method="POST" enctype="multipart/form-data" id="recipeForm">
                    @csrf

                    {{-- Basic Information Section --}}
                    <div class="form-section">
                        <h4 class="section-title"><i class="fas fa-info-circle me-2"></i>Basic Information
                        </h4>

                        <div class="row g-3">
                            {{-- Recipe Title --}}
                            <div class="col-md-12 mb-2">
                                <div class="form-floating">
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        value="{{ old('title') }}" placeholder="{{ __('Recipe Title') }}" required>
                                    <label for="title">{{ __('Recipe Title') }}</label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12 mb-2">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nutrition Information --}}
                            <div class="row col-md-12 mb-2">
                                {{-- Calories --}}
                                <div class="form-floating col-md-6 mb-2">
                                    <input type="number" name="calories"
                                        class="form-control @error('calories') is-invalid @enderror"
                                        value="{{ old('calories') }}" id="calories" placeholder="{{ __('Calories') }}"
                                        required>
                                    <label for="calories">{{ __('Calories') }}</label>
                                    @error('calories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Protein --}}
                                <div class="form-floating col-md-6 mb-2">
                                    <input type="number" name="protein"
                                        class="form-control @error('protein') is-invalid @enderror"
                                        value="{{ old('protein') }}" id="protein" placeholder="Protein" step="0.01"
                                        required>
                                    <label for="protein">Protein</label>
                                    @error('protein')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Carbohydrates --}}
                                <div class="form-floating col-md-6 mb-2">
                                    <input type="number" name="carbs"
                                        class="form-control @error('carbs') is-invalid @enderror"
                                        value="{{ old('carbs') }}" id="carbs" placeholder="Carbohydrates"
                                        step="0.01" required>
                                    <label for="carbs">Carbohydrates</label>
                                    @error('carbs')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Fats --}}
                                <div class="form-floating col-md-6 mb-2">
                                    <input type="number" name="fats"
                                        class="form-control @error('fats') is-invalid @enderror"
                                        value="{{ old('fats') }}" id="fats" placeholder="Fats" step="0.01"
                                        required>
                                    <label for="fats">Fats</label>
                                    @error('fats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-12 mb-2">
                                <div class="form-floating">
                                    <select name="recipe_category_id"
                                        class="form-select @error('recipe_category_id') is-invalid @enderror" id="recipe_category_id"
                                        required>
                                        <option value="" disabled selected>Select category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('recipe_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="recipe_category_id">Category</label>
                                    @error('recipe_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Media Section --}}
                    <div class="form-section">
                        <h4 class="section-title"><i class="fas fa-images me-2"></i>{{ __('Media') }}</h4>

                        {{-- Video Upload --}}
                        <div class="mb-4">
                            <label class="form-label">{{ __('Recipe Video') }}</label>
                            <div class="file-upload-wrapper">
                                <label class="file-upload-label" for="video">
                                    <i class="fas fa-video me-2"></i>
                                    {{ __('Click to upload video (MP4 only)') }}
                                    <br>
                                    <small class="text-muted">{{ __('Max size: 50MB') }}</small>
                                </label>
                                <input type="file" name="video"
                                    class="file-upload-input @error('video') is-invalid @enderror" id="video"
                                    accept=".mp4">
                                @error('video')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="preview-container" id="video-preview-container"></div>
                        </div>

                        {{-- Images Upload --}}
                        <div class="mb-4">
                            <label class="form-label">{{ __('Recipe Images') }}</label>
                            <div class="file-upload-wrapper">
                                <label class="file-upload-label" for="images">
                                    <i class="fas fa-images me-2"></i>
                                    {{ __('Click to upload images (JPG, PNG, GIF)') }}
                                    <br>
                                    <small class="text-muted">{{ __('Max 5 images, 2MB each') }}</small>
                                </label>
                                <input type="file" name="images[]"
                                    class="file-upload-input @error('images') is-invalid @enderror" id="images"
                                    multiple accept=".jpg, .jpeg, .png, .gif">
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="preview-container" id="image-preview-container"></div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="reset" class="btn btn-outline-secondary me-md-2 px-4">
                            <i class="fas fa-undo me-2"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-plus-circle me-2"></i> Create Recipe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js"
        integrity="sha512-bib7srucEhHYYWglYvGY+EQb0JAAW0qSOXpkPTMgCgW8eLtswHA/K4TKyD4+FiXcRHcy8z7boYxk0HTACCTFMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#description',
            plugins: 'autoresize link image lists table code fullscreen preview',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | forecolor backcolor removeformat | table link image media | lineheight outdent indent | code fullscreen preview',
            height: 300,
            menubar: false,
            branding: false,
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            images_upload_url: '{{ url('admin.upload.image') }}',
            automatic_uploads: true,
            file_picker_types: 'image',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });

        // File upload preview
        document.getElementById('video').addEventListener('change', function(e) {
            const container = document.getElementById('video-preview-container');
            container.innerHTML = '';

            if (this.files && this.files[0]) {
                const file = this.files[0];
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';

                const video = document.createElement('video');
                video.controls = true;
                video.src = URL.createObjectURL(file);

                const removeBtn = document.createElement('button');
                removeBtn.className = 'remove-preview';
                removeBtn.innerHTML = '×';
                removeBtn.onclick = function() {
                    container.removeChild(previewItem);
                    document.getElementById('video').value = '';
                };

                previewItem.appendChild(video);
                previewItem.appendChild(removeBtn);
                container.appendChild(previewItem);
            }
        });

        document.getElementById('images').addEventListener('change', function(e) {
            const container = document.getElementById('image-preview-container');
            container.innerHTML = '';

            if (this.files) {
                Array.from(this.files).forEach(file => {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';

                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-preview';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = function() {
                        container.removeChild(previewItem);
                        // Create new file list without the removed file
                        const dataTransfer = new DataTransfer();
                        Array.from(document.getElementById('images').files)
                            .filter(f => f !== file)
                            .forEach(f => dataTransfer.items.add(f));
                        document.getElementById('images').files = dataTransfer.files;
                    };

                    previewItem.appendChild(img);
                    previewItem.appendChild(removeBtn);
                    container.appendChild(previewItem);
                });
            }
        });

        // Form validation
        document.getElementById('recipeForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const calories = document.getElementById('calories').value.trim();

            if (!title) {
                e.preventDefault();
                alert('{{ __('Please enter a recipe title') }}');
                document.getElementById('title').focus();
                return;
            }

            if (!calories) {
                e.preventDefault();
                alert('{{ __('Please specify the calorie count') }}');
                document.getElementById('calories').focus();
                return;
            }
        });
    </script>
@endsection

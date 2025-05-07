@extends('admin.layout')

@section('title', "Edit: $recipe->title")

@section('style')
    <style>
        .recipe-edit-container {
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

        .media-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1rem;
        }

        .preview-item {
            position: relative;
            width: 150px;
            height: 150px;
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
    </style>
@endsection

@section('body')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 text-success fw-bold mb-0">Edit {{ $recipe->title }}</h2>
                <a href="{{ route('admin.recipe.show', $recipe->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Recipe
                </a>
            </div>

            {{-- Message --}}
            @include('admin.success')

            <div class="recipe-edit-container p-4 mb-5">
                <form action="{{ route('admin.recipe.update', $recipe->id) }}" method="POST" enctype="multipart/form-data"
                    id="recipeEditForm">
                    @csrf
                    @method('PUT')

                    {{-- Basic Information Section --}}
                    <div class="form-section">
                        <h4 class="section-title"><i class="fas fa-info-circle me-2"></i>Basic Information</h4>

                        <div class="row g-3">
                            {{-- Recipe Title --}}
                            <div class="col-md-12 mb-2">
                                <div class="form-floating">
                                    <input type="text" name="title"
                                        class="form-control @error('title') is-invalid @enderror" id="title"
                                        value="{{ old('title', $recipe->title) }}" placeholder="Recipe Title" required>
                                    <label for="title">Recipe Title</label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12 mb-2">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" required>{{ old('description', $recipe->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nutrition Information --}}
                            <div class="row col-md-12 mb-2">
                                {{-- Calories --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="calories"
                                            class="form-control @error('calories') is-invalid @enderror"
                                            value="{{ old('calories', $recipe->calories) }}" id="calories"
                                            placeholder="Calories" required>
                                        <label for="calories">Calories</label>
                                        @error('calories')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Protein --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="protein"
                                            class="form-control @error('protein') is-invalid @enderror"
                                            value="{{ old('protein', $recipe->protein) }}" id="protein"
                                            placeholder="Protein" step="0.01" required>
                                        <label for="protein">Protein</label>
                                        @error('protein')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Carbohydrates --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="carbs"
                                            class="form-control @error('carbs') is-invalid @enderror"
                                            value="{{ old('carbs', $recipe->carbs) }}" id="carbs"
                                            placeholder="Carbohydrates" step="0.01" required>
                                        <label for="carbs">Carbohydrates</label>
                                        @error('carbs')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Fats --}}
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" name="fats"
                                            class="form-control @error('fats') is-invalid @enderror"
                                            value="{{ old('fats', $recipe->fats) }}" id="fats" placeholder="Fats"
                                            step="0.01" required>
                                        <label for="fats">Fats</label>
                                        @error('fats')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Category --}}
                            <div class="col-md-12 mb-2">
                                <div class="form-floating">
                                    <select name="recipe_category_id"
                                        class="form-select @error('recipe_category_id') is-invalid @enderror"
                                        id="recipe_category_id" required>
                                        <option value="{{ old('calories', $recipe->recipe_category_id) }}" disabled selected>{{ old('calories', $recipe->category->name) }}</option>
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
                        <h4 class="section-title"><i class="fas fa-images me-2"></i>Media</h4>

                        {{-- Current Video --}}
                        <div class="mb-4">
                            <label class="form-label">Current Video</label>
                            @if ($recipe->video)
                                <div class="preview-item">
                                    <video controls>
                                        <source src="{{ asset('storage/' . $recipe->video) }}" type="video/mp4">
                                    </video>
                                </div>
                            @else
                                <div class="alert alert-warning">No video uploaded</div>
                            @endif
                        </div>

                        {{-- New Video Upload --}}
                        <div class="mb-4">
                            <label class="form-label">Replace Video (MP4 only)</label>
                            <div class="file-upload-wrapper">
                                <label class="file-upload-label" for="video">
                                    <i class="fas fa-video me-2"></i>
                                    Click to upload new video
                                    <br>
                                    <small class="text-muted">Max size: 50MB</small>
                                </label>
                                <input type="file" name="video"
                                    class="file-upload-input @error('video') is-invalid @enderror" id="video"
                                    accept=".mp4">
                                @error('video')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="media-preview" id="video-preview-container"></div>
                            <small class="text-muted d-block">Leave empty to keep current video</small>
                        </div>

                        {{-- Current Images --}}
                        <div class="mb-4">
                            <label class="form-label">Current Images</label>
                            @if ($recipe->images && count(json_decode($recipe->images)))
                                <div class="media-preview">
                                    @foreach (json_decode($recipe->images) as $image)
                                        <div class="preview-item">
                                            <img src="{{ asset('storage/' . $image) }}"
                                                alt="Current Image {{ $loop->iteration }}">
                                            <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">No images uploaded</div>
                            @endif
                        </div>

                        {{-- New Images Upload --}}
                        <div class="mb-4">
                            <label class="form-label">Add More Images (JPG, PNG, GIF)</label>
                            <div class="file-upload-wrapper">
                                <label class="file-upload-label" for="images">
                                    <i class="fas fa-images me-2"></i>
                                    Click to upload new images
                                    <br>
                                    <small class="text-muted">Max 5 images, 2MB each</small>
                                </label>
                                <input type="file" name="images[]"
                                    class="file-upload-input @error('images') is-invalid @enderror" id="images"
                                    multiple accept=".jpg, .jpeg, .png, .gif">
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="media-preview" id="image-preview-container"></div>
                            <small class="text-muted d-block">Leave empty to keep current images</small>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="reset" class="btn btn-outline-secondary me-md-2 px-4">
                            <i class="fas fa-undo me-2"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fas fa-save me-2"></i> Update Recipe
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

        // File upload preview for video
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

        // File upload preview for images
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
        document.getElementById('recipeEditForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const calories = document.getElementById('calories').value.trim();

            if (!title) {
                e.preventDefault();
                alert('Please enter a recipe title');
                document.getElementById('title').focus();
                return;
            }

            if (!calories) {
                e.preventDefault();
                alert('Please specify the calorie count');
                document.getElementById('calories').focus();
                return;
            }
        });
    </script>
@endsection

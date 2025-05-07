@extends('admin.layout')

@section('title', "Edit: $diet->name")

@section('style')
    <style>
        .diet-edit-container {
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

        .nutrition-input {
            position: relative;
        }

        .input-unit {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .media-preview {
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

        .preview-item img {
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
                <h2 class="h3 text-success fw-bold mb-0">Edit {{ $diet->name }}</h2>
                <a href="{{ route('admin.specialDiet.specialDiets') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Diet
                </a>
            </div>

            {{-- Message --}}
            @include('admin.success')

            <div class="diet-edit-container p-4 mb-5">
                <form action="{{ route('admin.specialDiet.update', $diet->id) }}" method="POST"
                    enctype="multipart/form-data" id="dietEditForm">
                    @csrf
                    @method('PUT')

                    {{-- Basic Information Section --}}
                    <div class="form-section">
                        <h4 class="section-title"><i class="fas fa-info-circle me-2"></i>Basic Information</h4>

                        <div class="row g-3">
                            {{-- Diet Name --}}
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name', $diet->name) }}" placeholder="Diet Name" required>
                                    <label for="name">Diet Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- User Info --}}
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-user me-2"></i>
                                    This diet belongs to:
                                    <strong>{{ $diet->user->firstName }} {{ $diet->user->lastName }}</strong>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Diet Description" id="description" style="height: 120px">{{ old('description', $diet->description) }}</textarea>
                                    <label for="description">Diet Description</label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Nutrition Information Section --}}
                    <div class="form-section">
                        <h4 class="section-title"><i class="fas fa-utensils me-2"></i>Nutrition Information</h4>

                        <div class="row g-3">
                            @foreach ([['name' => 'calories', 'label' => 'Calories', 'value' => $diet->calories, 'unit' => 'kcal'], ['name' => 'protein', 'label' => 'Protein', 'value' => $diet->protein, 'unit' => 'g'], ['name' => 'carbs', 'label' => 'Carbohydrates', 'value' => $diet->carbs, 'unit' => 'g'], ['name' => 'fats', 'label' => 'Fats', 'value' => $diet->fats, 'unit' => 'g']] as $field)
                                <div class="col-md-6">
                                    <div class="form-floating nutrition-input">
                                        <input type="number" name="{{ $field['name'] }}"
                                            class="form-control @error($field['name']) is-invalid @enderror"
                                            value="{{ old($field['name'], $field['value']) }}"
                                            id="{{ $field['name'] }}" placeholder="{{ $field['label'] }}">
                                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        <span class="input-unit">{{ $field['unit'] }}</span>
                                        @error($field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Workouts Section --}}
                    <div class="form-section">
                        <h4 class="section-title"><i class="fas fa-dumbbell me-2"></i>Recommended Workouts</h4>

                        <div class="form-floating">
                            <textarea name="workouts" class="form-control @error('workouts') is-invalid @enderror"
                                placeholder="Recommended Workouts" id="workouts" style="height: 120px">{{ old('workouts', $diet->workouts) }}</textarea>
                            <label for="workouts">Recommended Workouts (one per line)</label>
                            @error('workouts')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Media Section --}}
                    <div class="form-section">
                        <h4 class="section-title"><i class="fas fa-images me-2"></i>Diet Images</h4>

                        {{-- Current Images --}}
                        <div class="mb-4">
                            <label class="form-label">Current Images</label>
                            @if ($diet->images && count(json_decode($diet->images)))
                                <div class="media-preview">
                                    @foreach (json_decode($diet->images) as $image)
                                        <div class="preview-item">
                                            <img src="{{ asset('storage/' . $image) }}"
                                                alt="Diet Image {{ $loop->iteration }}">
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
                            <label class="form-label">Add More Images</label>
                            <div class="file-upload-wrapper">
                                <label class="file-upload-label" for="images">
                                    <i class="fas fa-images me-2"></i>
                                    Click to upload new images
                                    <br>
                                    <small class="text-muted">Max 5 images (JPG, PNG, GIF), 2MB each</small>
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
                            <i class="fas fa-save me-2"></i> Update Diet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
        document.getElementById('dietEditForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const calories = document.getElementById('calories').value.trim();

            if (!name) {
                e.preventDefault();
                alert('Please enter a diet name');
                document.getElementById('name').focus();
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

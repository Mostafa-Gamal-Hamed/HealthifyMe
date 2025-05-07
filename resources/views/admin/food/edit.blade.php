@extends('admin.layout')

@section('title', "Edit: $food->name")

@section('style')
    <style>
        .food-edit-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-floating label {
            transition: all 0.2s ease;
        }

        .image-preview-container {
            margin-top: 15px;
        }

        .current-image {
            max-width: 265px;
            max-height: 200px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .current-image:hover {
            transform: scale(1.03);
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
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center text-success fw-bold mb-4">Edit {{ $food->name }}</h2>

                @include('admin.success')

                <div class="food-edit-container p-4 mb-5">
                    <form action="{{ route('admin.food.update', $food->id) }}" method="POST" enctype="multipart/form-data"
                        id="foodEditForm">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- Food Name --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name', $food->name) }}" placeholder="Food name" required>
                                    <label for="name">Food Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nutrition Information --}}
                            @foreach ([['name' => 'calories', 'label' => 'Calories', 'value' => $food->calories, 'unit' => 'kcal', 'required' => true], ['name' => 'protein', 'label' => 'Protein', 'value' => $food->protein, 'unit' => 'g', 'required' => true], ['name' => 'carbs', 'label' => 'Carbs', 'value' => $food->carbs, 'unit' => 'g', 'required' => true], ['name' => 'fats', 'label' => 'Fats', 'value' => $food->fats, 'unit' => 'g', 'required' => true], ['name' => 'fiber', 'label' => 'Fiber', 'value' => $food->fiber, 'unit' => 'g', 'required' => false], ['name' => 'vitamins', 'label' => 'Vitamins', 'value' => $food->vitamins, 'unit' => '', 'required' => false]] as $field)
                                <div class="col-md-6">
                                    <div class="form-floating @if ($field['unit']) nutrition-input @endif">
                                        <input type="{{ $field['name'] === 'vitamins' ? 'text' : 'number' }}"
                                            name="{{ $field['name'] }}"
                                            class="form-control @error($field['name']) is-invalid @enderror"
                                            value="{{ old($field['name'], $field['value']) }}" id="{{ $field['name'] }}"
                                            placeholder="{{ $field['label'] }}" step="0.01"
                                            @if ($field['required']) required @endif>
                                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                        @if ($field['unit'])
                                            <span class="input-unit">{{ $field['unit'] }}</span>
                                        @endif
                                        @error($field['name'])
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach

                            {{-- Category --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                        required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $food->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="category_id">Category</label>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Current Image --}}
                            <div class="col-md-6">
                                <label class="form-label">Current Image</label>
                                <div class="image-preview-container">
                                    @if ($food->image)
                                        <img src="{{ asset('storage/' . $food->image) }}" class="current-image"
                                            id="currentImage" alt="Current food image"
                                            onclick="window.open('{{ asset('storage/' . $food->image) }}', '_blank')">
                                    @else
                                        <div class="alert alert-warning">No image available</div>
                                    @endif
                                </div>
                            </div>

                            {{-- New Image --}}
                            <div class="col-md-6">
                                <label for="image" class="form-label">New Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror" id="image"
                                    accept="image/*" onchange="previewNewImage(this)">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block">Leave empty to keep current image</small>
                                <img id="newImagePreview" class="image-preview mt-2" style="display: none;"
                                    alt="New image preview">
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('admin.food.foods') }}" class="btn btn-outline-secondary me-md-2 px-4">
                                <i class="fas fa-arrow-left me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i> Update Food
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Preview new image before upload
        function previewNewImage(input) {
            const preview = document.getElementById('newImagePreview');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    preview.style.width = '265px';
                }

                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        }

        // Form validation
        document.getElementById('foodEditForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const calories = document.getElementById('calories').value.trim();
            const category = document.getElementById('category_id').value;

            if (!name) {
                e.preventDefault();
                alert('Please enter a name for the food');
                document.getElementById('name').focus();
                return;
            }

            if (!calories) {
                e.preventDefault();
                alert('Please specify the calorie count');
                document.getElementById('calories').focus();
                return;
            }

            if (!category) {
                e.preventDefault();
                alert('Please select a category');
                document.getElementById('category_id').focus();
                return;
            }
        });
    </script>
@endsection

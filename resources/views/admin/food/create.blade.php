@extends('admin.layout')

@section('title', 'Create New Food')

@section('style')
    <style>
        .food-form-container {
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
                <h2 class="text-center text-success fw-bold mb-4">Add New Food</h2>

                @include('admin.success')

                <div class="food-form-container p-4 mb-5">
                    <form action="{{ route('admin.food.store') }}" method="POST" enctype="multipart/form-data" id="foodForm">
                        @csrf

                        {{-- Food Name --}}
                        <div class="form-floating mb-4">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" placeholder="Food name" required>
                            <label for="name">Food Name</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nutrition Information --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating nutrition-input">
                                    <input type="number" name="calories"
                                        class="form-control @error('calories') is-invalid @enderror"
                                        value="{{ old('calories') }}" id="calories" placeholder="Calories" required>
                                    <label for="calories">Calories</label>
                                    <span class="input-unit">kcal</span>
                                    @error('calories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating nutrition-input">
                                    <input type="number" name="protein"
                                        class="form-control @error('protein') is-invalid @enderror"
                                        value="{{ old('protein') }}" id="protein" placeholder="Protein" step="0.01" required>
                                    <label for="protein">Protein</label>
                                    <span class="input-unit">g</span>
                                    @error('protein')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating nutrition-input">
                                    <input type="number" name="carbs"
                                        class="form-control @error('carbs') is-invalid @enderror"
                                        value="{{ old('carbs') }}" id="carbs" placeholder="Carbohydrates" step="0.01" required>
                                    <label for="carbs">Carbohydrates</label>
                                    <span class="input-unit">g</span>
                                    @error('carbs')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating nutrition-input">
                                    <input type="number" name="fats"
                                        class="form-control @error('fats') is-invalid @enderror"
                                        value="{{ old('fats') }}" id="fats" placeholder="Fats" step="0.01" required>
                                    <label for="fats">Fats</label>
                                    <span class="input-unit">g</span>
                                    @error('fats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating nutrition-input">
                                    <input type="number" name="fiber"
                                        class="form-control @error('fiber') is-invalid @enderror"
                                        value="{{ old('fiber') }}" id="fiber" placeholder="Fiber" step="0.01">
                                    <label for="fiber">Fiber</label>
                                    <span class="input-unit">g</span>
                                    @error('fiber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="vitamins"
                                        class="form-control @error('vitamins') is-invalid @enderror"
                                        value="{{ old('vitamins') }}" id="vitamins" placeholder="Vitamins">
                                    <label for="vitamins">Vitamins</label>
                                    @error('vitamins')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="mb-4">
                            <div class="form-floating">
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id" required>
                                    <option value="" disabled selected>Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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

                        {{-- Image Upload --}}
                        <div class="mb-4">
                            <label for="image" class="form-label">Food Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image" accept="image/*" onchange="previewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <img id="imagePreview" class="image-preview" alt="Food image preview">
                            <small class="text-muted d-block">Recommended size: 800x600 pixels (will be resized automatically)</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2 px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-plus-circle me-2"></i> Create Food
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
        document.getElementById('foodForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const calories = document.getElementById('calories').value.trim();
            const category = document.getElementById('category_id').value;
            const image = document.getElementById('image').files[0];

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

            if (!image) {
                if (!confirm('Are you sure you want to create this food without an image?')) {
                    e.preventDefault();
                }
            }
        });
    </script>
@endsection
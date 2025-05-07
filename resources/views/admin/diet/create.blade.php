@extends('admin.layout')

@section('title', 'Create New Diet Plan')

@section('style')
    <style>
        .diet-form-container {
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
                <h2 class="text-center text-primary fw-bold mb-4">Create New Diet Plan</h2>

                @include('admin.success')

                <div class="diet-form-container p-4 mb-5">
                    <form action="{{ route('admin.diet.store') }}" method="post" enctype="multipart/form-data" id="dietForm">
                        @csrf

                        {{-- Diet Name --}}
                        <div class="form-floating mb-4">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" placeholder="Diet plan name" required>
                            <label for="name">Diet Plan Name</label>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Diet description" id="description" style="height: 120px">{{ old('description') }}</textarea>
                                <label for="description">Detailed Description</label>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Describe the diet's purpose and benefits</small>
                        </div>

                        {{-- Nutrition Information --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="form-floating nutrition-input">
                                    <input type="number" name="calories"
                                        class="form-control @error('calories') is-invalid @enderror"
                                        value="{{ old('calories') }}" id="calories" placeholder="Calories" step="0.01" required>
                                    <label for="calories">Calories</label>
                                    <span class="input-unit">kcal</span>
                                    @error('calories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" name="protein"
                                        class="form-control @error('protein') is-invalid @enderror"
                                        value="{{ old('protein') }}" id="protein" placeholder="Protein" step="0.01">
                                    <label for="protein">Protein</label>
                                    <span class="input-unit">g</span>
                                    @error('protein')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" name="carbs"
                                        class="form-control @error('carbs') is-invalid @enderror"
                                        value="{{ old('carbs') }}" id="carbs" placeholder="Carbohydrates" step="0.01">
                                    <label for="carbs">Carbohydrates</label>
                                    <span class="input-unit">g</span>
                                    @error('carbs')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" name="fat"
                                        class="form-control @error('fat') is-invalid @enderror" value="{{ old('fat') }}"
                                        id="fat" placeholder="Fat" step="0.01">
                                    <label for="fat">Fat</label>
                                    <span class="input-unit">g</span>
                                    @error('fat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Workouts --}}
                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea name="workouts" class="form-control @error('workouts') is-invalid @enderror"
                                    placeholder="Recommended workouts" id="workouts" style="height: 120px">{{ old('workouts') }}</textarea>
                                <label for="workouts">Recommended Workouts</label>
                                @error('workouts')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">List complementary exercises (one per line)</small>
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
                            <small class="text-muted d-block">Recommended size: 800x600 pixels (will be resized
                                automatically)</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2 px-4">
                                <i class="fas fa-undo me-2"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-plus-circle me-2"></i> Create Diet Plan
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
        document.getElementById('dietForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value.trim();
            const calories = document.getElementById('calories').value.trim();
            const image = document.getElementById('image').files[0];

            if (!name) {
                e.preventDefault();
                alert('Please enter a name for the diet plan');
                document.getElementById('name').focus();
            }

            if (!calories) {
                e.preventDefault();
                alert('Please specify the calorie count');
                document.getElementById('calories').focus();
            }

            if (!image) {
                if (!confirm('Are you sure you want to create this diet without an image?')) {
                    e.preventDefault();
                }
            }
        });
    </script>
@endsection

@extends('admin.layout')

@section('title', "Edit: $diet->name ")

@section('style')
    <style>
        .diet-form-container {
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
            cursor: zoom-in;
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

        .editor-toolbar {
            border-radius: 5px 5px 0 0 !important;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">Edit Diet Plan</h1>
                </div>

                @include('admin.success')

                <div class="diet-form-container p-4 mb-5">
                    <form action="{{ route('admin.diet.update', $diet->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            {{-- Left Column --}}
                            <div class="col-md-6">
                                {{-- Name --}}
                                <div class="form-floating mb-4">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name', $diet->name) }}" placeholder="Diet name" required>
                                    <label for="name">Diet Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Calories --}}
                                <div class="form-floating mb-4">
                                    <input type="number" name="calories"
                                        class="form-control @error('calories') is-invalid @enderror"
                                        value="{{ old('calories', $diet->calories) }}" id="calories" placeholder="Calories"
                                        step="0.01" required>
                                    <label for="calories">Daily Calories (kcal)</label>
                                    @error('calories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Protein --}}
                                <div class="form-floating mb-4">
                                    <input type="number" name="protein"
                                        class="form-control @error('protein') is-invalid @enderror"
                                        value="{{ old('protein', $diet->protein) }}" id="protein" placeholder="Protein"
                                        step="0.01" required>
                                    <label for="protein">Daily protein</label>
                                    @error('protein')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Carbohydrates --}}
                                <div class="form-floating mb-4">
                                    <input type="number" name="carbs"
                                        class="form-control @error('carbs') is-invalid @enderror"
                                        value="{{ old('carbs', $diet->carbs) }}" id="carbs" placeholder="Carbohydrates"
                                        step="0.01" required>
                                    <label for="carbs">Daily Carbohydrates</label>
                                    @error('protein')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Fat --}}
                                <div class="form-floating mb-4">
                                    <input type="number" name="fat"
                                        class="form-control @error('fat') is-invalid @enderror"
                                        value="{{ old('fat', $diet->fats) }}" id="fat" placeholder="Fat"
                                        step="0.01" required>
                                    <label for="fat">Daily fat</label>
                                    @error('fat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Current Image --}}
                                <div class="mb-4">
                                    <label class="form-label">Current Image</label>
                                    @if ($diet->image)
                                        <div class="image-preview-container">
                                            <img src="{{ asset("storage/$diet->image") }}" class="current-image"
                                                alt="Current diet image" data-bs-toggle="modal" data-bs-target="#imageModal"
                                                data-image="{{ asset("storage/$diet->image") }}">
                                            <button type="button" class="remove-image-btn"
                                                onclick="document.getElementById('remove_image').value = '1'">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="remove_image" id="remove_image" value="0">
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            No image currently set
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="col-md-6">
                                {{-- Description --}}
                                <div class="mb-4">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        placeholder="Diet description" rows="10">{{ old('description', $diet->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Workouts --}}
                                <div class="mb-4">
                                    <label class="form-label">Workout Plan</label>
                                    <textarea name="workouts" class="form-control @error('workouts') is-invalid @enderror" id="workouts"
                                        placeholder="Recommended workouts" rows="10">{{ old('workouts', $diet->workouts) }}</textarea>
                                    @error('workouts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- New Image Upload --}}
                        <div class="mb-4">
                            <label for="image" class="form-label">Update Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image" accept="image/*" onchange="previewNewImage(this)">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave empty to keep current image</small>
                            <img id="newImagePreview" class="current-image mt-2" style="display: none;">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="reset" class="btn btn-outline-danger px-4">
                                <i class="fas fa-undo me-2"></i> Reset Changes
                            </button>
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save me-2"></i> Update Diet
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center p-0">
                    <img id="modalImage" src="" class="img-fluid" alt="Diet Image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image modal
            const imageModal = document.getElementById('imageModal');
            if (imageModal) {
                imageModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const imageUrl = button.getAttribute('data-image');
                    const modalImage = document.getElementById('modalImage');
                    modalImage.src = imageUrl;
                });
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

        // Initialize editors
        @if (config('app.wysiwyg'))
            tinymce.init({
                selector: '#description',
                plugins: 'autoresize link lists table code',
                toolbar: 'undo redo | bold italic | bullist numlist | link table code',
                menubar: false,
                branding: false,
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });

            tinymce.init({
                selector: '#workouts',
                plugins: 'autoresize link lists table code',
                toolbar: 'undo redo | bold italic | bullist numlist | link table code',
                menubar: false,
                branding: false,
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
        @endif
    </script>
@endsection

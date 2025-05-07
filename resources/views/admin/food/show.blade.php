@extends('admin.layout')

@section('title', $food->name)

@section('style')
    <style>
        .food-detail-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .food-detail-card:hover {
            transform: translateY(-5px);
        }

        .nutrition-badge {
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .food-image {
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .food-image:hover {
            transform: scale(1.03);
        }

        .nutrition-label {
            font-weight: 600;
            color: #495057;
        }

        .nutrition-value {
            font-weight: 700;
            color: #212529;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-success fw-bold mb-0">{{ $food->name }} Details</h2>
                    <a href="{{ route('admin.food.foods') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Foods
                    </a>
                </div>

                <div class="food-detail-card p-4 mb-5">
                    <div class="row g-4">
                        {{-- Food Image --}}
                        <div class="col-md-5 text-center">
                            <img src="{{ $food->image ? asset('storage/' . $food->image) : asset('images/modern_logo.png') }}"
                                class="food-image img-fluid w-100" alt="{{ $food->name }}" data-bs-toggle="modal"
                                data-bs-target="#imageModal">
                        </div>

                        {{-- Food Details --}}
                        <div class="col-md-7">
                            <h4 class="text-center text-muted mb-4">Nutritional Values per 100g</h4>

                            <div class="row mb-4">
                                <div class="col-md-6 mb-3">
                                    <span class="badge bg-success nutrition-badge w-100">
                                        <i class="fas fa-fire me-2"></i> Calories: {{ $food->calories }} kcal
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="badge bg-primary nutrition-badge w-100">
                                        <i class="fas fa-dumbbell me-2"></i> Protein: {{ $food->protein }}g
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="badge bg-warning text-dark nutrition-badge w-100">
                                        <i class="fas fa-bread-slice me-2"></i> Carbs: {{ $food->carbs }}g
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="badge bg-danger nutrition-badge w-100">
                                        <i class="fas fa-oil-can me-2"></i> Fats: {{ $food->fats }}g
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="badge bg-info nutrition-badge w-100">
                                        <i class="fas fa-leaf me-2"></i> Fiber: {{ $food->fiber }}g
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="badge bg-purple nutrition-badge w-100">
                                        <i class="fas fa-pills me-2"></i> Vitamins: {{ $food->vitamins }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="nutrition-label me-2">Category:</span>
                                    <a href="{{ route('admin.category.categories', $food->category_id) }}"
                                        class="nutrition-value text-decoration-none">
                                        {{ $food->category->name }}
                                    </a>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="nutrition-label">Created:</span>
                                        <span class="nutrition-value">{{ $food->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="nutrition-label">Updated:</span>
                                        <span class="nutrition-value">{{ $food->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.food.edit', $food->id) }}" class="btn btn-success"
                                    title="Edit Food">
                                    <i class="fas fa-edit me-2"></i> Edit
                                </a>

                                <form action="{{ route('admin.food.secondDelete', $food->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete Food"
                                        onclick="return confirm('Are you sure you want to delete this food item?')">
                                        <i class="fas fa-trash-alt me-2"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img src="{{ $food->image ? asset('storage/' . $food->image) : asset('images/modern_logo.png') }}"
                        class="img-fluid" alt="{{ $food->name }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

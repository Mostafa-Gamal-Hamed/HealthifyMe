@extends('admin.layout')

@section('title', 'Categories')

@section('style')
    <style>
        .category-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .toggle-form-btn {
            transition: all 0.3s ease;
        }

        .category-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            cursor: zoom-in;
            transition: transform 0.3s ease;
        }

        .category-image:hover {
            transform: scale(1.1);
        }

        .action-btn {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        {{-- Add Category Section --}}
        <div class="category-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold text-primary">Food Categories management</h4>
                <button type="button" class="btn btn-warning toggle-form-btn" id="toggleFormBtn">
                    <i class="fas fa-plus me-2"></i> Add New Category
                </button>
            </div>

            <div class="collapse" id="categoryForm">
                <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label for="image" class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i> Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Categories List --}}
        <div class="category-card p-4">
            @include('admin.success')

            @if ($categories->isEmpty())
                <div class="text-center py-5">
                    <img src="{{ asset('images/empty.svg') }}" alt="No categories" width="200" class="mb-4">
                    <h4 class="text-muted">No categories found</h4>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th colspan="3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td class="fw-semibold">{{ $category->name }}</td>
                                    <td>
                                        <img src="{{ $category->image ? asset("storage/$category->image") : asset('images/foods/1-vegetable.jpg') }}"
                                            class="category-image rounded" alt="{{ $category->name }}"
                                            data-featherlight="{{ $category->image ? asset("storage/$category->image") : asset('images/foods/1-vegetable.jpg') }}">
                                    </td>
                                    <td>{{ $category->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.category.show', $category->id) }}"
                                            class="btn btn-info btn-sm" title="View">
                                            <i class="fas fa-info"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.category.edit', $category->id) }}"
                                            class="btn btn-success btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <form action="{{ route('admin.category.delete', $category->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of
                            {{ $categories->total() }} entries
                        </div>
                        {{ $categories->appends(request()->input())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle form visibility
            const toggleBtn = document.getElementById('toggleFormBtn');
            const categoryForm = document.getElementById('categoryForm');

            if (toggleBtn && categoryForm) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isCollapsed = categoryForm.classList.contains('show');

                    // Toggle collapse state
                    new bootstrap.Collapse(categoryForm, {
                        toggle: true
                    });

                    // Update button text
                    this.innerHTML = isCollapsed ?
                        '<i class="fas fa-plus me-2"></i> Add New Category' :
                        '<i class="fas fa-times me-2"></i> Cancel';
                });
            }

            // Initialize Featherlight
            if (typeof featherlight !== 'undefined') {
                featherlight();
            }
        });
    </script>
@endsection

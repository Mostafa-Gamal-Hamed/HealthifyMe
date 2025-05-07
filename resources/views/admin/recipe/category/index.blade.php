@extends('admin.layout')

@section('title', "Categories")

@section('body')
    <div class="p-3">
        {{-- Message --}}
        @include('admin.success')

        {{-- Add Category Section --}}
        <div class="category-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 fw-bold text-primary">Recipe Categories management</h4>
                <button type="button" class="btn btn-warning toggle-form-btn" id="toggleFormBtn">
                    <i class="fas fa-plus me-2"></i> Add New Category
                </button>
            </div>

            <div class="collapse" id="categoryForm">
                <form action="{{ route('admin.recipeCategory.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3 align-items-end justify-content-end">
                        <div class="col-md-5">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ old('name') }}" required>
                            @error('name')
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

        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($categories->isEmpty())
                <h3 class="mb-5 text-center text-danger">No category found.</h3>
            @else
                <div class="table-responsive">
                    {{ $categories->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                <th scope="col" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.recipeCategory.show', $category->id) }}"
                                            class="btn btn-sm btn-info" title="Show">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.recipeCategory.edit', $category->id) }}"
                                            class="btn btn-sm btn-success" title="Edit">
                                            <i class="fa-solid fa-edit"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.recipeCategory.delete', $category->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?');" title="Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        });
    </script>
@endsection

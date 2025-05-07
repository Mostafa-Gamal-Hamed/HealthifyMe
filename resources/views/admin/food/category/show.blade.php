@extends('admin.layout')

@section('title', $category->name)

@section('body')
<div class="container-fluid mb-5">
    <h2 class="text-center text-success fw-bold my-4">{{ $category->name }}</h2>

    <div class="card shadow-lg border-0 bg-white">
        <div class="card-body px-5 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Category Foods</h4>
                <span class="text-muted">Total: {{ $category->foods->count() }}</span>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
                @forelse ($category->foods as $food)
                    <div class="col">
                        <div class="border rounded p-3 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h6 class="fw-semibold mb-2">{{ $loop->iteration }}.
                                    <a href="{{ route('admin.food.show', $food->id) }}" class="text-decoration-none">
                                        {{ $food->name }}
                                    </a>
                                </h6>
                                <p class="mb-0 text-muted">Date: {{ $food->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        No foods found in this category.
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <small class="text-muted">Created at: {{ $category->created_at->format('d/m/Y') }}</small>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-success btn-sm" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.category.secondDelete', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

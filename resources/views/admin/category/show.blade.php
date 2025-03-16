@extends('admin.layout')

@section('title')
    {{ $category->name }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $category->name }}</h2>

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold">Category foods:</h4>
                    <h5 class="text-muted">Total: {{ count($category->foods) }}</h5>
                </div>
                <div class="row gap-2 justify-content-around mb-3">
                    @foreach ($category->foods as $food)
                        <div class="col-3">
                            {{ $loop->iteration }}- <a href="{{ route('admin.food.show', $food->id ) }}" style="margin-right: 5px;">{{ $food->name }}</a>
                            <span>Date: {{ $food->created_at->format('d/m/Y') }}</span>
                        </div>
                    @endforeach
                </div>
                <p class="text-end text-muted">Created at: {{ $category->created_at->format('d/m/Y') }}</p>
                <hr>
                <div class="d-flex">
                    <div class="col">
                        <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-md btn-success w-75"
                            title="Edit">
                            <i class="fa-solid fa-edit"></i></i>
                        </a>
                    </div>
                    <form action="{{ route('admin.category.secondDelete', $category->id) }}" method="POST" class="col">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-md w-75"
                            onclick="return confirm('Are you sure?');" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

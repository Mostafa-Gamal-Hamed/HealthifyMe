@extends('admin.layout')

@section('title')
    {{ $food->title }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $food->name }}</h2>

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <p class="text-center text-success fw-bold">Items per 100g</p>
            <div class="row justify-content-center">
                <div class="col border-end border-2 text-center">
                    <img src="{{ $food->image ? asset("storage/$food->image") : asset('images/modern_logo.png') }}"
                        style="cursor: pointer;" class="img-fluid rounded" alt="Blog">
                </div>
                <div class="col">
                    <h4 class="fw-bold">Calories: {{ $food->calories }}</h4>
                    <h4 class="fw-bold">Protein: {{ $food->protein }}</h4>
                    <h4 class="fw-bold">Carbs: {{ $food->carbs }}</h4>
                    <h4 class="fw-bold">Fats: {{ $food->fats }}</h4>
                    <h4 class="fw-bold">Vitamins: {{ $food->vitamins }}</h4>
                    <h4 class="fw-bold">Fiber: {{ $food->fiber }}</h4>
                    <p class="fw-bold d-flex gap-2">Category:
                        <a href="{{ route('admin.category.categories') }}">
                            {{ $food->category->name }}
                        </a>
                    </p>
                    <div class="row gap-2 justify-content-between">
                        <p class="col text-start fw-bold">Created at: {{ $food->created_at->format("d/m/Y") }}</p>
                        <p class="col text-end fw-bold">Updated at: {{ $food->updated_at->format("d/m/Y") }}</p>
                    </div>
                    <hr>
                    <div class="d-flex">
                        <div class="col">
                            <a href="{{ route('admin.food.edit', $food->id) }}" class="btn btn-md btn-success w-75" title="Edit">
                                <i class="fa-solid fa-edit"></i></i>
                            </a>
                        </div>
                        <form action="{{ route('admin.food.secondDelete', $food->id) }}" method="POST" class="col">
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
    </div>
@endsection

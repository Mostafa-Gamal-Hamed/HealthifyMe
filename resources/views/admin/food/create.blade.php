@extends('admin.layout')

@section('title')
    Add Food
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">Add new food</h2>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.food.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row gap-2 justify-content-between">
                            {{-- Name --}}
                            <div class="form-floating col-5 mb-3">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') }}" placeholder="Name">
                                <label for="name">Name</label>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Calories --}}
                            <div class="form-floating col-5 mb-3">
                                <input type="text" name="calories"
                                    class="form-control @error('calories') is-invalid @enderror" id="calories"
                                    value="{{ old('calories') }}" placeholder="Calories">
                                <label for="calories">Calories</label>
                                @error('calories')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Protein --}}
                            <div class="form-floating col-5 mb-3">
                                <input type="text" name="protein"
                                    class="form-control @error('protein') is-invalid @enderror" id="protein"
                                    value="{{ old('protein') }}" placeholder="Protein">
                                <label for="protein">Protein</label>
                                @error('protein')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Carbs --}}
                            <div class="form-floating col-5 mb-3">
                                <input type="text" name="carbs"
                                    class="form-control @error('carbs') is-invalid @enderror" id="carbs"
                                    value="{{ old('carbs') }}" placeholder="Carbs">
                                <label for="carbs">Carbs</label>
                                @error('carbs')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fats --}}
                            <div class="form-floating col-5 mb-3">
                                <input type="text" name="fats"
                                    class="form-control @error('fats') is-invalid @enderror" id="fats"
                                    value="{{ old('fats') }}" placeholder="Fats">
                                <label for="fats">Fats</label>
                                @error('fats')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Vitamins --}}
                            <div class="form-floating col-5 mb-3">
                                <input type="text" name="vitamins"
                                    class="form-control @error('vitamins') is-invalid @enderror" id="vitamins"
                                    value="{{ old('vitamins') }}" placeholder="Vitamins">
                                <label for="vitamins">Vitamins</label>
                                @error('vitamins')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fiber --}}
                            <div class="form-floating col-5 mb-3">
                                <input type="text" name="fiber"
                                    class="form-control @error('fiber') is-invalid @enderror" id="fiber"
                                    value="{{ old('fiber') }}" placeholder="fiber">
                                <label for="fiber">Fiber</label>
                                @error('fiber')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="form-floating col-5 mb-3">
                                <select class="form-select" name="category_id" id="category" aria-label="Floating label select example">
                                    <option selected>Seledt category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <label for="category">Category</label>
                                @error('category_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Image --}}
                            <div class="col-5 mb-3">
                                <label for="image">Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}"
                                    id="image" multiple accept=".jpg, .jpeg, .png, .gif">
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-md px-5 btn-success">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

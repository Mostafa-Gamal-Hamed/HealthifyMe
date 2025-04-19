@extends('admin.layout')

@section('title')
    {{ $food->name }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $food->name }}</h2>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.food.update', $food->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row gap-2 justify-content-between align-items-center">
                            {{-- Name --}}
                            <div class="col-5 mb-3">
                                <label for="name">Name:</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ $food->name }}" placeholder="Write name">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Calories --}}
                            <div class="col-5 mb-3">
                                <label for="calories">Calories:</label>
                                <input type="number" name="calories"
                                    class="form-control @error('calories') is-invalid @enderror" id="calories"
                                    value="{{ $food->calories }}" placeholder="Write calories" step="0.01">
                                @error('calories')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Protein --}}
                            <div class="col-5 mb-3">
                                <label for="protein">Protein:</label>
                                <input type="number" name="protein"
                                    class="form-control @error('protein') is-invalid @enderror" id="protein"
                                    value="{{ $food->protein }}" placeholder="Write protein" step="0.01">
                                @error('protein')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Carbs --}}
                            <div class="col-5 mb-3">
                                <label for="carbs">Carbs:</label>
                                <input type="number" name="carbs"
                                    class="form-control @error('carbs') is-invalid @enderror" id="carbs"
                                    value="{{ $food->carbs }}" placeholder="Write carbs" step="0.01">
                                @error('carbs')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fats --}}
                            <div class="col-5 mb-3">
                                <label for="fats">Fats:</label>
                                <input type="number" name="fats"
                                    class="form-control @error('fats') is-invalid @enderror" id="fats"
                                    value="{{ $food->fats }}" placeholder="Write fats" step="0.01">
                                @error('fats')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fiber --}}
                            <div class="col-5 mb-3">
                                <label for="fiber">Fiber:</label>
                                <input type="number" name="fiber"
                                    class="form-control @error('fiber') is-invalid @enderror" id="fiber"
                                    value="{{ $food->fiber }}" placeholder="Write fiber" step="0.01">
                                @error('fiber')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Vitamins --}}
                            <div class="col-5 mb-3">
                                <label for="vitamins">Vitamins:</label>
                                <input type="text" name="vitamins"
                                    class="form-control @error('vitamins') is-invalid @enderror" id="vitamins"
                                    value="{{ $food->vitamins }}" placeholder="Write slug" step="0.01">
                                @error('vitamins')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Category --}}
                            <div class="input-group col-5 mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Category</label>
                                <select name="category_id" class="form-select" id="inputGroupSelect01">
                                    <option value="{{ $food->category->id }}" hidden>{{ $food->category->name }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- oldImages --}}
                            <div class="col-5 mb-3">
                                <label for="oldImages">Old Images:</label>
                                <picture>
                                    @if ($food->image)
                                        <img data-featherlight="<img src='{{ asset("storage/$food->image") }}' style='max-width: 300px;' alt='oldImage'>"
                                            src="{{ asset("storage/$food->image") }}" style="cursor: pointer;"
                                            width="100px" alt="oldImage">
                                    @else
                                        <p class="text-danger fw-bold">No image available.</p>
                                    @endif
                                </picture>
                            </div>

                            {{-- Image --}}
                            <div class="col-5 mb-3">
                                <label for="image">Image:</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror" id="image" multiple
                                    accept=".jpg, .jpeg, .png, .gif">
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-md px-5 btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

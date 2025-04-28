@extends('admin.layout')

@section('title')
    Add Diet
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">Add new diet</h2>

        {{-- Message --}}
        @include("admin.success")

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.diet.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- Name --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name') }}" placeholder="Diet name:">
                            <label for="name">Diet name</label>
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-floating mb-3">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Diet description:"
                                id="description" style="height: 100px">{{ old('description') }}</textarea>
                            <label for="description">Diet description</label>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Calories --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="calories" class="form-control @error('calories') is-invalid @enderror"
                                value="{{ old('calories') }}" id="calories" placeholder="Calories:">
                            <label for="calories">Calories</label>
                            @error('calories')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Workouts --}}
                        <div class="form-floating mb-3">
                            <textarea name="workouts" class="form-control @error('workouts') is-invalid @enderror" placeholder="Workouts" id="workouts"
                                style="height: 100px">{{ old('workouts') }}</textarea>
                            <label for="workouts">Workouts</label>
                            @error('workouts')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="images">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                value="{{ old('images') }}" id="image" multiple accept=".jpg, .jpeg, .png, .gif">
                            @error('images')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md px-5 btn-success">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

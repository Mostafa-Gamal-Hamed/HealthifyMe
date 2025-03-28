@extends('admin.layout')

@section('title')
    {{ $diet->name }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $diet->name }}</h2>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.diet.update', $diet->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Name --}}
                        <div class="mb-3">
                            <label for="name">Diet name:</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="name" value="{{ $diet->name }}" placeholder="Write name">
                            @error('name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Diet description --}}
                        <div class="mb-3">
                            <label for="description">Diet description:</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Write description" id="description" style="height: 100px">{{ $diet->description }}</textarea>
                            @error('description')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Calories --}}
                        <div class="mb-3">
                            <label for="calories">Calories:</label>
                            <input type="number" name="calories"
                                class="form-control @error('calories') is-invalid @enderror" value="{{ $diet->calories }}"
                                id="calories" placeholder="Write calories">
                            @error('calories')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Workouts --}}
                        <div class="mb-3">
                            <label for="workouts">Workouts:</label>
                            <textarea name="workouts" class="form-control @error('workouts') is-invalid @enderror" placeholder="Write Workouts"
                                id="workouts" style="height: 100px">{{ $diet->workouts }}</textarea>
                            @error('workouts')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- oldImages --}}
                        <div class="mb-3">
                            <label for="oldImages">Old Images:</label>
                            <picture>
                                @if ($diet->images)
                                    @foreach (json_decode($diet->images) as $image)
                                        <img data-featherlight="<img src='{{ asset("storage/$image") }}' style='max-width: 300px;' alt='oldImage'>"
                                            src="{{ asset("storage/$image") }}" style="cursor: pointer;" width="100px"
                                            alt="oldImage">
                                    @endforeach
                                @else
                                    <p>No images available.</p>
                                @endif
                            </picture>
                        </div>

                        {{-- Images --}}
                        <div class="mb-3">
                            <label for="images">New Images:</label>
                            <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror"
                                id="images" multiple accept=".jpg, .jpeg, .png, .gif">
                            @error('images')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md px-5 btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

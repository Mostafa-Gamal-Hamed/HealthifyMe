@extends('admin.layout')

@section('title')
    {{ $blog->title }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $blog->title }}</h2>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        {{-- Title --}}
                        <div class="mb-3">
                            <label for="title">Title:</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                id="title" value="{{ $blog->title }}" placeholder="Write title">
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Slug --}}
                        <div class="mb-3">
                            <label for="slug">Slug:</label>
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                id="slug" value="{{ $blog->slug }}" placeholder="Write slug">
                            @error('slug')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label for="description">Description:</label>
                            <textarea name="desc" class="form-control @error('desc') is-invalid @enderror"
                                placeholder="Write description" id="desc" style="height: 100px">{{ $blog->desc }}</textarea>
                            @error('desc')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- oldImages --}}
                        <div class="mb-3">
                            <label for="oldImages">Old Images:</label>
                            <picture>
                                @if ($blog->image)
                                    <img data-featherlight="<img src='{{ asset("storage/$blog->image") }}' style='max-width: 300px;' alt='oldImage'>"
                                        src="{{ asset("storage/$blog->image") }}" style="cursor: pointer;" width="100px"
                                        alt="oldImage">
                                @else
                                    <p class="text-danger fw-bold">No image available.</p>
                                @endif
                            </picture>
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image">Image:</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                id="image" multiple accept=".jpg, .jpeg, .png, .gif">
                            @error('image')
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

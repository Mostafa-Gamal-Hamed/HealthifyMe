@extends('admin.layout')

@section('title')
    Add Blog
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">Add new blog</h2>

        {{-- Message --}}
        @include("admin.success")

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        {{-- Title --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
                                value="{{ old('title') }}" placeholder="Title">
                            <label for="title">Title</label>
                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                value="{{ old('slug') }}" placeholder="Slug">
                            <label for="slug">Slug</label>
                            @error('slug')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="form-floating mb-3">
                            <textarea name="desc" class="form-control @error('desc') is-invalid @enderror" placeholder="Description"
                                id="desc" style="height: 100px">{{ old('desc') }}</textarea>
                            <label for="desc">Description</label>
                            @error('desc')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                value="{{ old('image') }}" id="image" multiple accept=".jpg, .jpeg, .png, .gif">
                            @error('image')
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

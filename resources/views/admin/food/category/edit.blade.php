@extends('admin.layout')

@section('title', $category->name)

@section('body')
<div class="container-fluid mb-5">
    <h2 class="text-center text-success fw-bold my-4">{{ $category->name }}</h2>

    <div class="card shadow-lg border-0 bg-white">
        <div class="card-body px-5 py-4">
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Category Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $category->name) }}" placeholder="Enter category name">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Image --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Current Image</label><br>
                    <img src="{{ asset("storage/$category->image") }}" class="mb-3 rounded border" width="120px" alt="Category Image">
                    <input type="file" name="image" id="image"
                        class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

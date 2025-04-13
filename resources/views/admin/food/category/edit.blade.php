@extends('admin.layout')

@section('title')
    {{ $category->name }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $category->name }}</h2>

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <form action="{{ route('admin.category.update', $category->id) }}" method="post" class="text-center">
                @csrf
                @method('PUT')
                {{-- Name --}}
                <div class="mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="name" value="{{ $category->name }}" placeholder="Category name">
                    @error('name')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-md px-5 btn-success">Update</button>
            </form>
        </div>
    </div>
@endsection

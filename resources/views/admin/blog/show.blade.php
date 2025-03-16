@extends('admin.layout')

@section('title')
    {{ $blog->title }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $blog->title }}</h2>

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center align-items-center">
                <div class="col border-end border-2 text-center">
                    <img src="{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}"
                        style="cursor: pointer;" class="img-fluid rounded" alt="Blog">
                </div>
                <div class="col">
                    <h4 class="fw-bold">Slug: {{ $blog->slug }}</h4>
                    <h4 class="fw-bold">Author: {{ $blog->user->firstName }}</h4>
                    <div>
                        <h5 class="fw-bold">Description:</h5>
                        <p>{{ $blog->desc }}</p>
                    </div>
                    <h5 class="fw-bold">Liked: <span class="text-primary">{{ count($likes) }}</span></h5>
                    <h5 class="fw-bold">DisLiked: <span class="text-danger">{{ count($disLikes) }}</span></h5>
                    <p class="text-end fw-bold">Created at: {{ $blog->created_at->format("d/m/Y") }}</p>
                    <hr>
                    <div class="d-flex">
                        <div class="col">
                            <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-md btn-success w-75" title="Edit">
                                <i class="fa-solid fa-edit"></i></i>
                            </a>
                        </div>
                        <form action="{{ route('admin.blog.secondDelete', $blog->id) }}" method="POST" class="col">
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

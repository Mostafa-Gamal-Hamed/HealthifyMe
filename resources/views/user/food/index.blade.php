@extends('user.layout')

@section('title')
    Categories
@endsection

@section('body')
    <div class="titlepage mt-5">
        <h2>Categories</h2>
    </div>

    <div class="container mb-5">
        @if ($categories->isEmpty())
            <h2 class="text-center text-danger fw-bold">Empty</h2>
        @else
            <div class="row shadow bg-light">
                @foreach ($categories as $category)
                    <div class="col-sm-4 mb-4">
                        <a href="{{ route('food.type', $category->name) }}">
                            <div class="card position-relative text-center">
                                <div>
                                    <img src="{{ asset("images/logo.png") }}" alt="image"
                                    class="img-fluid object-cover object-center w-50 h-50">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title fw-bold">{{ $category->name }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@extends('admin.layout')

@section('title')
    {{ $dietRequest->user->firstName }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $dietRequest->user->firstName }} {{ $dietRequest->user->lastName }}</h2>

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            sss
        </div>
    </div>
@endsection

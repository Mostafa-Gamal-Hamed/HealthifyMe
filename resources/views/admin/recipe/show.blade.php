@extends('admin.layout')

@section('title')
    {{ $recipe->title }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $recipe->title }}</h2>

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            {{-- Image & videos --}}
            <div class="row gap-2">
                <picture class="col">
                    @if ($recipe->images)
                        @foreach (json_decode($recipe->images) as $image)
                            <img src="{{ asset("storage/$image") }}" class="img-fluid rounded mb-2"
                                style="max-height:500px;" alt="Recipe">
                        @endforeach
                    @else
                        <img src="{{ asset('images/recipes/recipe.png') }}"
                            class="img-fluid rounded" style="max-height:500px;" alt="Recipe">
                    @endif
                </picture>
                <video class="col" style="max-height:500px;" controls>
                    <source
                        src="{{ $recipe->video ? asset("storage/$recipe->video") : asset('images/recipes/video.png') }}"
                        type="video/mp4">
                </video>
            </div>
            <hr>

            {{-- Details --}}
            <div class="mt-3">
                <div>
                    <h5 class="fw-bold">Description:</h5>
                    <p>{!! $recipe->description !!}</p>
                </div>
                <h5 class="fw-bold">calories: <span>{{ $recipe->calories }}.</span></h5>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted">By: <a href="{{ route('admin.user.show',$recipe->user->id) }}">
                        {{ $recipe->user->firstName }} {{ $recipe->user->lastName }}
                    </a></span>
                    <span class="text-muted">Created at: {{ $recipe->created_at->format('d/m/Y') }}</span>
                </div>
                <hr>
                <div class="d-flex">
                    <div class="col">
                        <a href="{{ route('admin.recipe.edit', $recipe->id) }}" class="btn btn-md btn-success w-75" title="Edit">
                            <i class='fa-solid fa-edit'></i>
                        </a>
                    </div>
                    <form action="{{ route('admin.recipe.secondDelete', $recipe->id) }}" method="POST" class="col">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-md w-75" onclick="return confirm('Are you sure?');"
                            title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

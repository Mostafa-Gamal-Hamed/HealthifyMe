@extends('admin.layout')

@section('title')
    {{ $category->name }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $category->name }}</h2>

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold">Recipes:</h4>
                    <h5 class="text-muted">Total: {{ $recipes ?? 0 }}</h5>
                </div>

                {{-- Recipes --}}
                <table class="table text-center shadow shadow-lg bg-light" id="showTable">
                    <thead>
                        <tr>
                            <th scope="col">Id.</th>
                            <th scope="col">Name</th>
                            <th scope="col">Calories</th>
                            <th scope="col">Created at</th>
                            <th scope="col" colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category->recipes as $recipe)
                            <tr>
                                <td>{{ $recipe->id }}</td>
                                <td>{{ $recipe->title }}</td>
                                <td>{{ $recipe->calories }}</td>
                                <td>{{ $recipe->created_at->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.recipe.show', $recipe->id) }}" class="btn btn-md btn-info" title="Details">
                                        <i class='fa-solid fa-info'></i>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.recipe.delete', $recipe->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-md"
                                            onclick="return confirm('Are you sure?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="text-end text-muted">Created at: {{ $recipe->created_at->format('d/m/Y') }}</p>
                <hr>

                {{-- Action --}}
                <div class="d-flex">
                    <div class="col">
                        <a href="{{ route('admin.recipeCategory.edit', $category->id) }}"
                            class="btn btn-md btn-success w-75" title="Edit">
                            <i class="fa-solid fa-edit"></i></i>
                        </a>
                    </div>
                    <form action="{{ route('admin.recipeCategory.secondDelete', $category->id) }}" method="POST" class="col">
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
@endsection

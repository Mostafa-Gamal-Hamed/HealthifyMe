@extends('admin.layout')

@section('title', 'Recipes')

@section('body')
    <div class="p-3">
        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light rounded h-100 mb-5">
            @if ($recipes->isEmpty())
                <h3 class="mb-5 text-center text-danger">No recipes found.</h3>
            @else
                {{-- search --}}
                <form class="d-flex justify-content-between mb-3 p-2" role="search">
                    <h4 class="col fw-bold text-primary">recipes management</h4>
                    <input class="form-control w-50" type="text" id="search" placeholder="Search by title"
                        aria-label="Search">
                </form>

                {{-- table --}}
                <div class="table-responsive">
                    {{ $recipes->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Calories</th>
                                <th>Created at</th>
                                <th colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recipes as $recipe)
                                <tr>
                                    <td scope="row">{{ $recipe->id }}</td>
                                    <td>{{ $recipe->title }}</td>
                                    <td>
                                        <span class="text" data-featherlight="<p>{{ $recipe->description }}</p>"
                                            style="cursor: pointer;">
                                            {!! Str::limit($recipe->description, 250, '....') !!}
                                        </span>
                                    </td>
                                    <td>{{ $recipe->calories }}</td>
                                    <td>{{ $recipe->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.recipe.show', $recipe->id) }}" class="btn btn-sm btn-info" title="Details">
                                            <i class='fa-solid fa-info'></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.recipe.edit', $recipe->id) }}"
                                            class="btn btn-sm btn-success" title="Edit">
                                            <i class="fa-solid fa-edit"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.recipe.delete', $recipe->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $recipes->firstItem() }} to {{ $recipes->lastItem() }} of
                            {{ $recipes->total() }} entries
                        </div>
                        {{ $recipes->appends(request()->input())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    @if ($recipes->isNotEmpty())
        <script>
            $(document).ready(function() {
                $("#search").on("input", function() {
                    var value = $(this).val().toLowerCase();
                    $('#showTable').find('thead').hide();
                    $('#showTable').find('tbody').hide();

                    if (value === ' ') {
                        $('#showTable').find('thead').show();
                        $('#showTable').find('tbody').show();
                    }

                    $.ajax({
                        type: "GET",
                        url: "{{ url('recipeSearch') }}/" + value,
                        success: function(response) {
                            console.log(response.recipes);
                            var resultHtml = '';

                            if (response.recipes && response.recipes.length > 0) {
                                var body = $('#showTable').find('tbody');
                                body.empty();

                                response.recipes.forEach(function(recipe) {
                                    var created_at = new Date(recipe.created_at);
                                    var createdAt = created_at.toLocaleDateString('en-GB');

                                    var data = `data-featherlight='<p>${recipe.description}</p>'`;
                                    var description = `
                                        <span class="text" ${data} style="cursor: pointer;">
                                            ${recipe.description.length > 50 ? recipe.description.substring(0, 50) + '....' : recipe.description}
                                        </span>
                                    `;

                                    var status = recipe.status || " ";

                                    var show =
                                        `{{ url('showRecipe', '') }}/${recipe.id}`;
                                    var remove =
                                        `{{ url('deleteRecipe', '') }}/${recipe.id}`;

                                    body.append(`
                                        <tr>
                                            <td scope="row">${recipe.id}</td>
                                            <td>${recipe.title}</td>
                                            <td>${description}</td>
                                            <td>${recipe.calories}</td>
                                            <td>${status}</td>
                                            <td>${createdAt}</td>
                                            <td>
                                                <x-EditShow url="${show}" class="info"
                                                    title="Details" text="<i class='fa-solid fa-info'></i>"></x-EditShow>
                                            </td>
                                            <td>
                                                <form action="${remove}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-md"
                                                        onclick="return confirm('Are you sure?');">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    `);
                                });

                            } else {
                                $('#showTable tbody').html(
                                    `<tr><td colspan="8" class='text-danger fw-bold'>No results found.</td></tr>`
                                );
                            }

                            $('#showTable').find('thead').show();
                            $('#showTable').find('tbody').show();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
            });
        </script>
    @endif
@endsection

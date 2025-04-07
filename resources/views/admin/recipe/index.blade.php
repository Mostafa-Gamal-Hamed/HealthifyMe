@extends('admin.layout')

@section('title')
    Recipes
@endsection

@section('body')
    <div class="p-3">
        <h2 class="text-center mb-3 text-success fw-bold">All recipes</h2>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light rounded h-100 mb-5">
            @if ($recipes->isEmpty())
                <h3 class="mb-5 text-center text-danger">No recipes found.</h3>
            @else
                {{-- search --}}
                <form class="d-flex justify-content-end mb-3 p-2" role="search">
                    <input class="form-control w-50" type="text" id="search" placeholder="Search by title"
                        aria-label="Search">
                </form>

                {{-- table --}}
                <div class="table-responsive">
                    {{ $recipes->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Calories</th>
                                <th scope="col">Status</th>
                                <th scope="col">Created</th>
                                <th scope="col" colspan="2">Action</th>
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
                                    <td>{{ $recipe->status }}</td>
                                    <td>{{ $recipe->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <x-EditShow url="{{ route('admin.recipe.show', $recipe->id) }}" class="info"
                                            title="Details" text="<i class='fa-solid fa-info'></i>"></x-EditShow>
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
                        url: "{{ route('admin.recipe.search', '') }}/" + value,
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
                                        `{{ route('admin.recipe.show', '') }}/${recipe.id}`;
                                    var remove =
                                        `{{ route('admin.recipe.delete', '') }}/${recipe.id}`;

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

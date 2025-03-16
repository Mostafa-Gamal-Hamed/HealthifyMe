@extends('admin.layout')

@section('title')
    Diets
@endsection

@section('body')
    <div class="p-3">
        <h2 class="text-center mb-3 text-success fw-bold">All Diets</h2>
        <div class="shadow shadow-lg bg-light rounded h-100 mb-5">
            @if ($diets->isEmpty())
                <h3 class="mb-5 text-center text-danger">No diets found.</h3>
            @else
                {{-- search --}}
                <form class="d-flex justify-content-end mb-3 p-2" role="search">
                    <input class="form-control w-50" type="text" id="search" placeholder="Search by name or calories"
                        aria-label="Search">
                </form>

                {{-- table --}}
                <div class="table-responsive">
                    {{ $diets->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Calories</th>
                                <th scope="col">Updated</th>
                                <th scope="col" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($diets as $diet)
                                <tr>
                                    <td scope="row">{{ $diet->id }}</td>
                                    <td>{{ $diet->name }}</td>
                                    <td>
                                        <span data-featherlight="<p>{{ $diet->description }}</p>" style="cursor: pointer;">
                                            {{ Str::limit($diet->description, 50, '....') }}
                                        </span>
                                    </td>
                                    <td>{{ $diet->calories }}</td>
                                    <td>{{ $diet->updated_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.diet.edit', $diet->id) }}" class="btn btn-md btn-success">
                                            <i class="fa-solid fa-edit"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.diet.delete', $diet->id) }}" method="POST">
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
    @if ($diets->isNotEmpty())
        <script>
            $(document).ready(function() {
                $("#search").on("input", function() {
                    var value = $(this).val().toLowerCase();
                    $('#showTable').find('thead').hide();
                    $('#showTable').find('tbody').hide();

                    if (value === '') {
                        $('#showTable').find('thead').show();
                        $('#showTable').find('tbody').show();
                        return;
                    }

                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.diet.search', '') }}/" + value,
                        success: function(response) {
                            var resultHtml = '';

                            if (response.diets && response.diets.length > 0) {
                                var body = $('#showTable').find('tbody');
                                body.empty();

                                response.diets.forEach(function(diet) {
                                    var updated_at = new Date(diet.updated_at);
                                    var updatedAt  = updated_at.toLocaleDateString('en-GB');

                                    var description = `
                                        <span data-featherlight="<p>${diet.description}</p>" style="cursor: pointer;">
                                            {{ Str::limit($diet->description, 50, '....') }}
                                        </span>
                                    `;

                                    body.append(`
                                        <tr>
                                            <td scope="row">${diet.id}</td>
                                            <td>${diet.name}</td>
                                            <td>${description}</td>
                                            <td>${diet.calories}</td>
                                            <td>${updatedAt}</td>
                                            <td>
                                                <a href="{{ route('admin.diet.edit', $diet->id) }}" class="btn btn-md btn-success">
                                                    <i class="fa-solid fa-edit"></i></i>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.diet.delete', $diet->id) }}" method="POST">
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

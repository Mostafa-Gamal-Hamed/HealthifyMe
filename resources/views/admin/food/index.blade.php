@extends('admin.layout')

@section('title')
    Foods
@endsection

@section('body')
    <div class="p-3">
        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($foods->isEmpty())
                <h3 class="mb-5 text-center text-danger">No foods found.</h3>
            @else
                <div class="row justify-content-between align-items-center mb-4">
                    <h6 class="col">Foods</h6>
                    <form class="col" role="search">
                        <input class="form-control me-2" type="text" id="search" placeholder="Search by name"
                            aria-label="Search">
                    </form>
                </div>
                <div class="table-responsive">
                    {{ $foods->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">name</th>
                                <th scope="col">category</th>
                                <th scope="col">Image</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($foods as $food)
                                <tr>
                                    <td>{{ $food->id }}</td>
                                    <td>{{ $food->name }}</td>
                                    <td>{{ $food->category->name }}</td>
                                    <td>
                                        <img src="{{ asset("storage/$food->image") }}"
                                            data-featherlight="<img src='{{ asset("storage/$food->image") }}' width='300px' alt='food'>"
                                            style="cursor: pointer;" class="img-fluid rounded-circle" width="80px"
                                            alt="Food">
                                    </td>
                                    <td>{{ $food->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $food->updated_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.food.show', $food->id) }}" class="btn btn-md btn-info"
                                            title="Show">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.food.edit', $food->id) }}" class="btn btn-md btn-success"
                                            title="Edit">
                                            <i class="fa-solid fa-edit"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.food.delete', $food->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-md"
                                                onclick="return confirm('Are you sure?');" title="Delete">
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
    <script>
        $(document).ready(function() {
            $("#search").on("input", function() {
                var value = $(this).val().toLowerCase();
                $('#showTable').find('thead').hide();
                $('#showTable').find('tbody').hide();

                if (value === ' ') {
                    $('#showTable').find('thead').show();
                    $('#showTable').find('tbody').show();
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.food.search', '') }}/" + value,
                    success: function(response) {
                        if (response.food && response.food.length != 0) {
                            var food = response.food;

                            var body = $('#showTable').find('tbody');
                            body.empty();

                            var created_at = new Date(food.created_at);
                            var createdAt = created_at.toLocaleDateString('en-GB');

                            var updated_at = new Date(food.updated_at);
                            var updatedAt = updated_at.toLocaleDateString('en-GB');

                            var image = `
                                <img src="{{ asset('storage') }}/${food.image}"
                                    data-featherlight="<img src='{{ asset('storage') }}/${food.image}' width='300px' alt='food'>"
                                    style="cursor: pointer;" class="img-fluid rounded-circle" width="80px"
                                    alt="Food">
                            `;

                            var show   = `{{ route('admin.food.show', '') }}/${food.id}`;
                            var edit   = `{{ route('admin.food.edit', '') }}/${food.id}`;
                            var remove = `{{ route('admin.food.delete', '') }}/${food.id}`;

                            body.append(`
                                    <tr>
                                        <td scope="row">${food.id}</td>
                                        <td>${food.name}</td>
                                        <td>${food.category.name}</td>
                                        <td>${image}</td>
                                        <td>${createdAt}</td>
                                        <td>${updatedAt}</td>
                                        <td>
                                            <a href="${show}" class="btn btn-md btn-info">
                                                <i class="fa-solid fa-info"></i></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="${edit}" class="btn btn-md btn-success">
                                                <i class="fa-solid fa-edit"></i></i>
                                            </a>
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
@endsection

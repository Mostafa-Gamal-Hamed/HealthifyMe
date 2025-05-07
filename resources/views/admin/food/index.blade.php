@extends('admin.layout')

@section('title', 'Foods')

@section('body')
    <div class="p-3">
        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light rounded p-4">
            @if ($foods->isEmpty())
                <h3 class="text-center text-danger">No foods found.</h3>
            @else
                <div class="row justify-content-between align-items-center mb-4">
                    <h4 class="col-auto fw-bold text-primary">Foods management</h4>
                    <div class="col-auto">
                        <input class="form-control" type="text" id="search" placeholder="Search by name"
                            aria-label="Search">
                    </div>
                </div>

                <div class="table-responsive">
                    {{ $foods->appends(request()->input())->links() }}

                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th colspan="3">Action</th>
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
                                            data-featherlight="<img src='{{ asset("storage/$food->image") }}' width='300px'>"
                                            class="img-fluid rounded-circle" width="80" style="cursor: pointer;"
                                            alt="Food">
                                    </td>
                                    <td>{{ $food->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $food->updated_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.food.show', $food->id) }}" class="btn btn-info btn-sm"
                                            title="Show">
                                            <i class="fa-solid fa-info"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.food.edit', $food->id) }}" class="btn btn-success btn-sm"
                                            title="Edit">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.food.delete', $food->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
                            Showing {{ $foods->firstItem() }} to {{ $foods->lastItem() }} of
                            {{ $foods->total() }} entries
                        </div>
                        {{ $foods->appends(request()->input())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#search").on("input", function() {
                let value = $(this).val().toLowerCase();
                if (!value) {
                    location.reload();
                    return;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ url('foodSearch') }}/" + value,
                    success: function(response) {
                        const tbody = $('#showTable').find('tbody');
                        tbody.empty();

                        if (response.food) {
                            const food = response.food;
                            const createdAt = new Date(food.created_at).toLocaleDateString(
                                'en-GB');
                            const updatedAt = new Date(food.updated_at).toLocaleDateString(
                                'en-GB');

                            tbody.append(`
                            <tr>
                                <td>${food.id}</td>
                                <td>${food.name}</td>
                                <td>${food.category.name}</td>
                                <td>
                                    <img src="{{ asset('storage') }}/${food.image}"
                                            data-featherlight="<img src='{{ asset('storage') }}/${food.image}' width='300px'>"
                                            class="img-fluid rounded-circle" width="80" style="cursor: pointer;" alt="Food">
                                </td>
                                <td>${createdAt}</td>
                                <td>${updatedAt}</td>
                                <td>
                                    <a href="{{ url('showFood') }}/${food.id}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-info"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ url('editFood') }}/${food.id}" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ url('deleteFood') }}/${food.id}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                        } else {
                            tbody.append(
                                `<tr><td colspan="9" class="text-danger fw-bold">No results found.</td></tr>`
                                );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection

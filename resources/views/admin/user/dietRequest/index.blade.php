@extends('admin.layout')

@section('title')
    Diet Requests
@endsection

@section('body')
    <div class="p-3">
        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($dietRequests->isEmpty())
                <h3 class="mb-5 text-center text-danger">No Requests found.</h3>
            @else
                <div class="row justify-content-between align-items-center mb-4">
                    <h6 class="col">Requests</h6>
                    <form class="col" role="search">
                        <input class="form-control me-2" type="text" id="search" placeholder="Search Request"
                            aria-label="Search">
                    </form>
                </div>
                <div class="table-responsive">
                    {{ $dietRequests->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th>ID.</th>
                                <th>Request</th>
                                <th>User name</th>
                                <th>Approved</th>
                                <th>Date</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dietRequests as $request)
                                <tr>
                                    <td scope="row">{{ $request->id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $request->ask === 'ask' ? 'primary' : 'warning text-dark' }}">
                                            {{ $request->ask }}
                                        </span>
                                    </td>
                                    <td>{{ $request->user->firstName }}</td>
                                    <td>{{ $request->accept == 0 ? 'no' : 'yes' }}</td>
                                    <td>{{ $request->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.user.show', $request->user->id) }}" class="btn btn-md btn-success">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.dietRequests.delete', $request->id) }}" method="POST">
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
                    url: "{{ route('admin.dietRequests.search', '') }}/" + value,
                    success: function(response) {
                        var resultHtml = '';

                        if (response.requests && response.requests.length > 0) {
                            var body = $('#showTable').find('tbody');
                            body.empty();

                            response.requests.forEach(function(request) {
                                var created_at = new Date(request.created_at);
                                var createdAt = created_at.toLocaleDateString('en-GB');

                                var askClass = request.ask === 'ask' ? 'primary' : 'warning text-dark';
                                var askLabel = `<span class="badge bg-${askClass}">${request.ask}</span>`;

                                var approved = request.accept == 0 ? 'no' : 'yes';

                                var show   = `{{ route('admin.user.show', '') }}/${request.id}`;
                                var remove = `{{ route('admin.dietRequests.delete', '') }}/${request.id}`;

                                body.append(`
                                    <tr>
                                        <td scope="row">${request.id}</td>
                                        <td>${askLabel}</td>
                                        <td>${request.user.firstName}</td>
                                        <td>${approved}</td>
                                        <td>${createdAt}</td>
                                        <td>
                                            <a href="${show}" class="btn btn-md btn-success">
                                                <i class="fa-solid fa-info"></i></i>
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
@endsection

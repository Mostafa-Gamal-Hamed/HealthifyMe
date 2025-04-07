@extends('admin.layout')

@section('title')
    Users
@endsection

@section('body')
    <div class="p-3">
        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($users->isEmpty())
                <h3 class="mb-5 text-center text-danger">No users found.</h3>
            @else
                <div class="row justify-content-between align-items-center mb-4">
                    <h6 class="col">Users</h6>
                    <form class="col" role="search">
                        <input class="form-control me-2" type="text" id="search" placeholder="Search by email or name"
                            aria-label="Search">
                    </form>
                </div>
                <div class="table-responsive">
                    {{ $users->appends(request()->input())->links() }}
                    <table class="table text-center" id="showTable">
                        <thead>
                            <tr>
                                <th scope="col">ID.</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Joined at</th>
                                <th scope="col">email verified</th>
                                <th scope="col" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td scope="row">{{ $user->id }}</td>
                                    <td>{{ $user->firstName }}</td>
                                    <td>{{ $user->lastName }}</td>
                                    <td>{{ $user->email }}</td>
                                    @if ($user->status == 'active')
                                        <td>
                                            <a href="{{ route('admin.user.status', ['type' => 'inactive', 'id' => $user->id]) }}"
                                                class="nav-item badge bg-success"
                                                onclick="return confirm('Change to inactive?');">
                                                {{ $user->status }}
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{ route('admin.user.status', ['type' => 'active', 'id' => $user->id]) }}"
                                                class="nav-item badge bg-danger"
                                                onclick="return confirm('Change to active?');">
                                                {{ $user->status }}
                                            </a>
                                        </td>
                                    @endif
                                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d-m-Y') : 'Not verified' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-md btn-success">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.user.delete', $user->id) }}" method="POST">
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
                    url: "{{ route('admin.user.search', '') }}/" + value,
                    success: function(response) {
                        var resultHtml = '';

                        if (response.users && response.users.length > 0) {
                            var body = $('#showTable').find('tbody');
                            body.empty();

                            response.users.forEach(function(user) {
                                var created_at = new Date(user.created_at);
                                var createdAt = created_at.toLocaleDateString('en-GB');

                                var emailVerified = new Date(user.email_verified_at);
                                var verified = emailVerified.toLocaleDateString(
                                'en-GB');

                                if (user.status === 'active') {
                                    var status = `<a href="{{ route('admin.user.status', ['type' => 'inactive', 'id' => '__userId__']) }}"
                                        class='badge bg-success' onclick="return confirm('Change to inactive?');">
                                        ${user.status}
                                    </a>`;
                                    status = status.replace('__userId__', user.id);
                                } else {
                                    var status = `<a href="{{ route('admin.user.status', ['type' => 'active', 'id' => '__userId__']) }}"
                                        class='badge bg-danger' onclick="return confirm('Change to active?');">
                                        ${user.status}
                                    </a>`;
                                    status = status.replace('__userId__', user.id);
                                }

                                var show   = `{{ route('admin.user.show', '') }}/${user.id}`;
                                var remove = `{{ route('admin.user.delete', '') }}/${user.id}`;

                                body.append(`
                                    <tr>
                                        <td scope="row">${user.id}</td>
                                        <td>${user.firstName}</td>
                                        <td>${user.lastName}</td>
                                        <td>${user.email}</td>
                                        <td>${status}</td>
                                        <td>${createdAt}</td>
                                        <td>${verified || 'Not Verified'}</td>
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

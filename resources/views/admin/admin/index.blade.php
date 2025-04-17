@extends('admin.layout')

@section('title')
    Admins
@endsection

@section('body')
    <div class="p-3">
        {{-- Message --}}
        @include('admin.success')
        
        <div class="shadow shadow-lg bg-light rounded h-100 p-4">
            @if ($admins->isEmpty())
                <h3 class="mb-5 text-center text-danger">No admins found.</h3>
            @else
                <div class="row justify-content-between align-items-center mb-4">
                    <h6 class="col">Admins</h6>
                    <form class="col" role="search">
                        <input class="form-control me-2" type="text" id="search" placeholder="Search by email or name"
                            aria-label="Search">
                    </form>
                </div>
                <div class="table-responsive">
                    {{ $admins->appends(request()->input())->links() }}
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
                            @foreach ($admins as $admin)
                                <tr>
                                    <td scope="row">{{ $admin->id }}</td>
                                    <td>{{ $admin->firstName }}</td>
                                    <td>{{ $admin->lastName }}</td>
                                    <td>{{ $admin->email }}</td>
                                    @if ($admin->status == 'active')
                                        <td>
                                            <a href="{{ route('admin.admin.status', ['type' => 'inactive', 'id' => $admin->id]) }}"
                                                class="nav-item badge bg-success"
                                                onclick="return confirm('Change to inactive?');">
                                                {{ $admin->status }}
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            <a href="{{ route('admin.admin.status', ['type' => 'active', 'id' => $admin->id]) }}"
                                                class="nav-item badge bg-danger"
                                                onclick="return confirm('Change to active?');">
                                                {{ $admin->status }}
                                            </a>
                                        </td>
                                    @endif
                                    <td>{{ $admin->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $admin->email_verified_at ? $admin->email_verified_at->format('d-m-Y') : 'Not verified' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.admin.show', $admin->id) }}" class="btn btn-md btn-success">
                                            <i class="fa-solid fa-info"></i></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.admin.delete', $admin->id) }}" method="POST">
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
                    url: "{{ url('adminSearch') }}/" + value,
                    success: function(response) {
                        var resultHtml = '';

                        if (response.admins && response.admins.length > 0) {
                            var body = $('#showTable').find('tbody');
                            body.empty();

                            response.admins.forEach(function(admin) {
                                var created_at = new Date(admin.created_at);
                                var createdAt = created_at.toLocaleDateString('en-GB');

                                var emailVerified = new Date(admin.email_verified_at);
                                var verified = emailVerified.toLocaleDateString(
                                'en-GB');

                                if (admin.status === 'active') {
                                    var status = `<a href="{{ url('status', ['type' => 'inactive', 'id' => '__adminId__']) }}"
                                        class='badge bg-success' onclick="return confirm('Change to inactive?');">
                                        ${admin.status}
                                    </a>`;
                                    status = status.replace('__adminId__', admin.id);
                                } else {
                                    var status = `<a href="{{ url('status', ['type' => 'active', 'id' => '__adminId__']) }}"
                                        class='badge bg-danger' onclick="return confirm('Change to active?');">
                                        ${admin.status}
                                    </a>`;
                                    status = status.replace('__adminId__', admin.id);
                                }

                                var show   = `{{ url('admin', '') }}/${admin.id}`;
                                var remove = `{{ url('deleteAdmin', '') }}/${admin.id}`;

                                body.append(`
                                    <tr>
                                        <td scope="row">${admin.id}</td>
                                        <td>${admin.firstName}</td>
                                        <td>${admin.lastName}</td>
                                        <td>${admin.email}</td>
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

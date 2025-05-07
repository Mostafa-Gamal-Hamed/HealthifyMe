@extends('admin.layout')

@section('title', 'User Management')

@section('style')
    <style>
        .user-management-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .user-table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .user-table thead th {
            background: #f8f9fa;
            border: none;
            padding: 12px 15px;
            font-weight: 600;
        }

        .user-table tbody tr {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .user-table tbody tr:hover {
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .search-input-container {
            position: relative;
            max-width: 300px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid p-4">
        <div class="user-management-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-user me-2"></i> User Management
                </h5>
                <div class="search-input-container">
                    <input type="text" id="search" class="form-control ps-35" placeholder="Search users..."
                        aria-label="Search">
                </div>
            </div>

            @if ($users->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>No users found in the system
                </div>
            @else
                <div class="table-responsive">
                    <table class="user-table table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col">User</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Verified</th>
                                <th scope="col">Joined</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="userTableBody">
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                {{ strtoupper(substr($user->firstName, 0, 1)) }}{{ strtoupper(substr($user->lastName, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $user->firstName }} {{ $user->lastName }}</div>
                                                <small class="text-muted">ID: {{ $user->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <button
                                            onclick="confirmStatusChange({{ $user->id }}, '{{ $user->status === 'active' ? 'inactive' : 'active' }}')"
                                            class="status-badge border-0 text-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                            <i class="fas fa-circle me-1 small"></i>
                                            {{ ucfirst($user->status) }}
                                        </button>
                                    </td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="text-success"><i class="fas fa-check-circle"></i> Verified</span>
                                        @else
                                            <span class="text-danger"><i class="fas fa-times-circle"></i> Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.user.show', $user->id) }}"
                                                class="btn btn-sm btn-info" data-bs-toggle="tooltip"
                                                title="View Details">
                                                <i class="fas fa-info"></i>
                                            </a>

                                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    data-bs-toggle="tooltip" title="Delete User"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of
                            {{ $users->total() }} entries
                        </div>
                        {{ $users->appends(request()->input())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let searchTimeout;

            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch($(this).val());
                }, 300);
            });

            function performSearch(value) {
                const tbody = $('#userTableBody');
                tbody.html(
                    '<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></td></tr>'
                    );

                $.ajax({
                    url: "{{ url('admin.users.search') }}",
                    method: 'GET',
                    data: {
                        query: value
                    },
                    success: function(response) {
                        tbody.html(response.html);
                    },
                    error: function(xhr) {
                        tbody.html(
                            `<tr><td colspan="6" class="text-center text-danger">Error loading results</td></tr>`
                            );
                    }
                });
            }
        });

        function confirmStatusChange(userId, newStatus) {
            Swal.fire({
                title: 'Confirm Status Change',
                text: `Are you sure you want to set this user to ${newStatus}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{{url('status/${newStatus}/${userId}')}}`;
                }
            });
        }
    </script>
@endsection

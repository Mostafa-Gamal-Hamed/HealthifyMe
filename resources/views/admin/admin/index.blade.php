@extends('admin.layout')

@section('title', 'Admin Management')

@section('style')
    <style>
        .admin-management-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .admin-table {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .admin-table thead th {
            background: #f8f9fa;
            border: none;
            padding: 12px 15px;
            font-weight: 600;
            color: #495057;
        }

        .admin-table tbody tr {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .admin-table tbody tr:hover {
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .role-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .search-input-container {
            position: relative;
            max-width: 350px;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .{
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .empty-state {
            padding: 3rem;
            text-align: center;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .empty-state-icon {
            font-size: 3rem;
            color: #adb5bd;
            margin-bottom: 1rem;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid p-4">
        <div class="admin-management-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-user-shield me-2"></i>Admin Management
                </h5>
                <div class="search-input-container">
                    <input type="text" id="search" class="form-control ps-35"
                        placeholder="Search by name or email..." aria-label="Search">
                </div>
            </div>

            @if ($admins->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-user-slash"></i>
                    </div>
                    <h5 class="text-muted">No Admins Found</h5>
                    <p class="text-muted">There are currently no admin accounts in the system.</p>
                    <a href="{{ route('admin.admin.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>Add New Admin
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="admin-table table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Role</th>
                                <th scope="col">Email</th>
                                <th scope="col">Status</th>
                                <th scope="col">Joined</th>
                                <th scope="col">Verified</th>
                                <th scope="col" colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody">
                            @foreach ($admins as $admin)
                                <tr>
                                    <td class="fw-bold">#{{ $admin->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                {{ $admin->firstName }} {{ $admin->lastName }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="role-badge bg-{{ $admin->role === 'superAdmin' ? 'danger' : 'info' }}">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        <button
                                            onclick="confirmStatusChange({{ $admin->id }}, '{{ $admin->status === 'active' ? 'inactive' : 'active' }}')"
                                            class="status-badge border-0 text-{{ $admin->status === 'active' ? 'success' : 'danger' }}">
                                            <i class="fas fa-circle me-1 small"></i>
                                            {{ ucfirst($admin->status) }}
                                        </button>
                                    </td>
                                    <td>{{ $admin->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($admin->email_verified_at)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Verified
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-exclamation-circle me-1"></i>Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.admin.show', $admin->id) }}"
                                            class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View Details">
                                            <i class="fas fa-info"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.admin.delete', $admin->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                data-bs-toggle="tooltip" title="Delete Admin"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="pagination-info">
                            Showing {{ $admins->firstItem() }} to {{ $admins->lastItem() }} of {{ $admins->total() }}
                            entries
                        </div>
                        {{ $admins->appends(request()->input())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Search functionality with debounce
            let searchTimeout;
            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch($(this).val());
                }, 300);
            });

            function performSearch(query) {
                const tbody = $('#adminTableBody');
                tbody.html(
                    '<tr><td colspan="9" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></td></tr>'
                    );

                $.ajax({
                    url: "{{ url('adminSearch') }}/" + query,
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        if (response.admins && response.admins.length > 0) {
                            let html = '';
                            response.admins.forEach(admin => {
                                html += `
                            <tr>
                                <td class="fw-bold">#${admin.id}</td>
                                <td>${admin.firstName} ${admin.lastName}</td>
                                <td>
                                    <span class="role-badge bg-${admin.role === 'superAdmin' ? 'danger' : 'info'}">
                                        ${admin.role.charAt(0).toUpperCase() + admin.role.slice(1)}
                                    </span>
                                </td>
                                <td>${admin.email}</td>
                                <td>
                                    <button onclick="confirmStatusChange(${admin.id}, '${admin.status === 'active' ? 'inactive' : 'active'}')"
                                            class="status-badge border-0 text-${admin.status === 'active' ? 'success' : 'danger'}">
                                        <i class="fas fa-circle me-1 small"></i>
                                        ${admin.status.charAt(0).toUpperCase() + admin.status.slice(1)}
                                    </button>
                                </td>
                                <td>${new Date(admin.created_at).toLocaleDateString('en-US', { day: 'numeric', month: 'numeric', year: 'numeric' })}</td>
                                <td>
                                    ${admin.email_verified_at ?
                                        '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Verified</span>' :
                                        '<span class="badge bg-warning text-dark"><i class="fas fa-exclamation-circle me-1"></i>Pending</span>'}
                                </td>
                                <td>
                                    <a href="/admin/admins/${admin.id}"
                                        class="btn btn-sm btn-info"
                                        data-bs-toggle="tooltip"
                                        title="View Details">
                                        <i class="fas fa-info"></i>
                                    </a>
                                </td>
                                <td>
                                    <form action="/admin/admins/${admin.id}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                data-bs-toggle="tooltip"
                                                title="Delete Admin"
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>`;
                            });
                            tbody.html(html);
                            $('[data-bs-toggle="tooltip"]').tooltip();
                        } else {
                            tbody.html(
                                '<tr><td colspan="9" class="text-center py-4 text-muted">No matching admins found</td></tr>'
                                );
                        }
                    },
                    error: function(xhr) {
                        tbody.html(
                            '<tr><td colspan="9" class="text-center py-4 text-danger">Error loading results</td></tr>'
                            );
                    }
                });
            }
        });

        function confirmStatusChange(adminId, newStatus) {
            Swal.fire({
                title: 'Confirm Status Change',
                text: `Are you sure you want to set this admin to ${newStatus}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, set to ${newStatus}`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const url = `{{ url('statusAdmin.admin.status/${newStatus}/${adminId}') }}`;
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection

@extends('admin.layout')

@section('title', $admin->firstName . ' ' . $admin->lastName)

@section('style')
    <style>
        .profile-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .info-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .section-title {
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                {{-- Profile Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">{{ $admin->firstName }} {{ $admin->lastName }}</h2>
                    @if ($admin->status === 'active')
                        <a href="{{ route('admin.admin.status', ['type' => 'inactive', 'id' => $admin->id]) }}"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to deactivate this account?');">
                            <i class="fas fa-user-slash me-1"></i> Deactivate Account
                        </a>
                    @else
                        <a href="{{ route('admin.admin.status', ['type' => 'active', 'id' => $admin->id]) }}"
                            class="btn btn-sm btn-success"
                            onclick="return confirm('Are you sure you want to activate this account?');">
                            <i class="fas fa-user me-1"></i> Activate Account
                        </a>
                    @endif
                </div>

                {{-- Main Profile Card --}}
                <div class="profile-container p-4 mb-4">
                    {{-- Account Information --}}
                    <div class="info-card">
                        <h3 class="section-title text-primary">
                            <i class="fas fa-user-circle me-2"></i>Account Information
                        </h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Email:</span>
                                    <span>{{ $admin->email }}</span>
                                    @if ($admin->email_verified_at)
                                        <span class="badge bg-success ms-2">Verified</span>
                                    @else
                                        <span class="badge bg-warning text-dark ms-2">Unverified</span>
                                    @endif
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">Role:</span>
                                    <span class="text-capitalize">{{ $admin->role }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">Status:</span>
                                    <span class="status-badge bg-{{ $admin->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($admin->status) }}
                                    </span>
                                </div>

                                <div class="detail-item">
                                    <span class="detail-label">Member Since:</span>
                                    <span>{{ $admin->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Diet Information --}}
                    @if ($dietInfo)
                        <div class="info-card">
                            <h3 class="section-title text-info">
                                <i class="fas fa-utensils me-2"></i>Diet Information
                            </h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Age:</span>
                                        <span>{{ $dietInfo->age }} years</span>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Gender:</span>
                                        <span class="text-capitalize">{{ $dietInfo->gender }}</span>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Weight:</span>
                                        <span>{{ $dietInfo->weight }} kg</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">Height:</span>
                                        <span>{{ $dietInfo->height }} cm</span>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Activity Level:</span>
                                        <span class="text-capitalize">{{ $dietInfo->activity_level }}</span>
                                    </div>

                                    <div class="detail-item">
                                        <span class="detail-label">Workout Hours/Week:</span>
                                        <span>{{ $dietInfo->workout_hours_per_week }} hours</span>
                                    </div>
                                </div>
                            </div>

                            <div class="detail-item mt-3">
                                <span class="detail-label">Last Updated:</span>
                                <span>{{ $dietInfo->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @else
                        <div class="info-card text-center py-4">
                            <h4 class="text-muted">
                                <i class="fas fa-info-circle me-2"></i>No diet information available
                            </h4>
                        </div>
                    @endif
                </div>

                {{-- Danger Zone --}}
                <div class="profile-container p-4 border border-danger">
                    <h3 class="section-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                    </h3>

                    <div class="alert alert-danger">
                        <strong>Warning:</strong> Deleting this account is permanent and cannot be undone.
                        All associated data will be removed.
                    </div>

                    <form action="{{ route('admin.admin.delete', $admin->id) }}" method="post" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                            <i class="fas fa-trash-alt me-2"></i>Permanently Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>
@endsection

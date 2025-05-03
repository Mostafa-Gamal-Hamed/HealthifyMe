@extends('admin.layout')

@section('title', 'Dashboard')

@section('style')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
        }

        #businessChart {
            height: 350px !important;
        }

        .message-row.unread {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .loading-spinner {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection

@section('body')
    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="loading-spinner">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Dashboard Overview</h2>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-outline-primary" id="refreshBtn">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="dashboard-card p-4 text-center bg-white">
                    <div class="card-icon text-danger">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="mb-2">Users</h5>
                    <h3 class="stat-number text-danger">{{ $users ?? 0 }}</h3>
                    <small class="text-muted">Total registered</small>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="dashboard-card p-4 text-center bg-white">
                    <div class="card-icon text-primary">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <h5 class="mb-2">Diets</h5>
                    <h3 class="stat-number text-primary">{{ $diets ?? 0 }}</h3>
                    <small class="text-muted">Total diet plans</small>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="dashboard-card p-4 text-center bg-white">
                    <div class="card-icon text-purple">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="mb-2">Special Diets</h5>
                    <h3 class="stat-number text-purple">{{ $special ?? 0 }}</h3>
                    <small class="text-muted">Custom plans</small>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="dashboard-card p-4 text-center bg-white">
                    <div class="card-icon text-info">
                        <i class="fas fa-blog"></i>
                    </div>
                    <h5 class="mb-2">Blog Posts</h5>
                    <h3 class="stat-number text-info">{{ $blogs ?? 0 }}</h3>
                    <small class="text-muted">Published articles</small>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="dashboard-card p-4 text-center bg-white">
                    <div class="card-icon text-danger">
                        <i class="fas fa-hand-paper"></i>
                    </div>
                    <h5 class="mb-2">Diet Requests</h5>
                    <h3 class="stat-number text-danger">{{ $askDiet ?? 0 }}</h3>
                    <small class="text-muted">New requests</small>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 col-sm-6">
                <div class="dashboard-card p-4 text-center bg-white">
                    <div class="card-icon text-success">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <h5 class="mb-2">Change Requests</h5>
                    <h3 class="stat-number text-success">{{ $changeDiet ?? 0 }}</h3>
                    <small class="text-muted">Modification requests</small>
                </div>
            </div>
        </div>

        <!-- Charts and Stats -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="dashboard-card p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Performance Overview</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                id="chartRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Last 6 Months
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="chartRangeDropdown">
                                <li><a class="dropdown-item" href="#" data-range="6">Last 6 Months</a></li>
                                <li><a class="dropdown-item" href="#" data-range="12">Last 12 Months</a></li>
                                <li><a class="dropdown-item" href="#" data-range="24">Last 2 Years</a></li>
                            </ul>
                        </div>
                    </div>
                    <canvas id="businessChart"></canvas>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="dashboard-card p-4 mb-4 bg-white">
                    <h5 class="mb-3">Diet Plan Requests</h5>
                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-danger bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-hand-paper text-danger"></i>
                        </div>
                        <div>
                            <h3 class="stat-number text-danger mb-0">14,000</h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> 42% higher than last month
                            </small>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 8px;">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 42%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="dashboard-card p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Contact Messages</h5>
                <a href="{{ route('admin.contact.contacts') }}" class="btn btn-sm btn-outline-primary">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            @if ($messages->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Name</th>
                                <th width="20%">Email</th>
                                <th width="20%">Subject</th>
                                <th width="15%">Status</th>
                                <th width="15%">Date</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr class="{{ $message->status == 'unread' ? 'message-row unread' : '' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($message->name, 20) }}</td>
                                    <td>{{ Str::limit($message->email, 25) }}</td>
                                    <td>{{ Str::limit($message->subject, 30) }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill py-2 px-3 bg-{{ $message->status == 'unread' ? 'warning text-dark' : 'secondary' }}">
                                            {{ $message->status == 'unread' ? 'Unread' : 'Read' }}
                                        </span>
                                    </td>
                                    <td>{{ $message->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.contact.show', $message->id) }}"
                                            class="btn btn-sm btn-primary" title="View Message">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h5 class="text-muted">No messages found</h5>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/js/chart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide loading spinner
            document.getElementById('loadingSpinner').style.display = 'none';

            // Refresh button functionality
            document.getElementById('refreshBtn').addEventListener('click', function() {
                window.location.reload();
            });

            // Initialize Chart
            var ctx = document.getElementById('businessChart').getContext('2d');
            var businessChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                            label: 'Revenue',
                            data: [65, 59, 80, 81, 56, 55],
                            backgroundColor: 'rgba(54, 162, 235, 0.7)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Costs',
                            data: [28, 48, 40, 19, 86, 27],
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Profit',
                            data: [37, 11, 40, 62, -30, 28],
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                }
            });

            // Chart range dropdown
            document.querySelectorAll('[data-range]').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const range = this.getAttribute('data-range');
                    document.getElementById('chartRangeDropdown').textContent = this.textContent;

                    // Here you would typically make an AJAX call to get new data
                    // For demonstration, we'll just update the labels
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                    ];

                    businessChart.data.labels = months.slice(0, parseInt(range));
                    businessChart.update();
                });
            });
        });
    </script>
@endsection

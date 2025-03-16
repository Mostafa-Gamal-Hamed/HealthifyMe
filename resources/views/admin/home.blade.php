@extends('admin.layout')

@section('title')
    Dashboard
@endsection

@section('style')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('jquery')
    <script src="{{ asset('admin/js/chart.js') }}"></script>
@endsection

@section('body')
    <!-- Spinner Start -->
    {{-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}
    <!-- Spinner End -->
    <div class="mt-4">
        <h2 class="mb-4 fw-bold">Dashboard</h2>
        {{-- Counts --}}
        <div class="row">
            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <h5>Users</h5>
                    <h3 class="text-danger">{{ $users ? count($users) : 'Empty' }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <h5>Diets</h5>
                    <h3 class="text-primary">{{ $diets ? count($diets) : 'Empty' }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <h5>Special diets</h5>
                    <h3 class="text-purple">{{ $special ? count($special) : 'Empty' }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 text-center">
                    <h5>Blogs</h5>
                    <h3 class="text-success">{{ $blogs ? count($blogs) : 'Empty' }}</h3>
                </div>
            </div>
        </div>

        {{-- Rating --}}
        <div class="row mt-4">
            <div class="col-md-8">
                <div class="card p-3">
                    <h5>Business Overview</h5>
                    <canvas id="businessChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 mb-3">
                    <h5>Overall Performance</h5>
                    <h3 class="text-danger">14,000</h3>
                    <p>42% higher than last month</p>
                </div>
                <div class="card p-3">
                    <h5>Active Installations</h5>
                    <h3 class="text-success">34,000</h3>
                    <p>19% less than last month</p>
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="card p-3 mt-4">
            <div class="d-flex justify-content-between">
                <h5>Contact messages</h5>
                <a href="{{ route('admin.contact.contacts') }}">See all</a>
            </div>
            @if ($messages->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Received</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $message->name }}</td>
                                    <td>{{ $message->email }}</td>
                                    <td>{{ $message->subject }}</td>
                                    @if ($message->status == 'unread')
                                        <td><span class="badge bg-warning text-dark">{{ $message->status }}</span></td>
                                    @else
                                        <td><span class="badge bg-secondary">{{ $message->status }}</span></td>
                                    @endif
                                    <td>{{ $message->created_at }}</td>
                                    <td>
                                        <a href="{{ url('admin.message.show', $message->id) }}"
                                            class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
            <div class="text-center">
                <h5 class="text-danger">No messages found.</h5>
            </div>
            @endif

        </div>
    </div>
@endsection

@section('script')
    <script>
        var ctx = document.getElementById('businessChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Return',
                    data: [65, 59, 80, 81, 56, 55],
                    backgroundColor: 'red'
                }, {
                    label: 'Revenue',
                    data: [28, 48, 40, 19, 86, 27],
                    backgroundColor: 'blue'
                }, {
                    label: 'Cost',
                    data: [18, 28, 30, 50, 76, 47],
                    backgroundColor: 'purple'
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
@endsection

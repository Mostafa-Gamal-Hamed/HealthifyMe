@extends('admin.layout')

@section('title')
    {{ $admin->firstName }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center mt-5">{{ $admin->firstName . ' ' . $admin->lastName }}</h2>

        {{-- User details & diets --}}
        <div class="shadow shadow-lg bg-light text-dark p-3 mb-3">
            {{-- Inactive account --}}
            @if ($admin->status === 'active')
                <div class="text-end">
                    <a href="{{ route('admin.admin.status', ['type' => 'inactive', 'id' => $admin->id]) }}"
                        class="btn btn-sm btn-danger" onclick="return confirm('Change to inactive?');">
                        Inactive Account
                    </a>
                </div>
            @endif

            {{-- Information --}}
            <h3 class="text-center text-primary fw-bold">Information</h3>
            <div class="row align-items-center gap-2">
                <h4 class="col">Email: {{ $admin->email }}</h4>
                <h4 class="col">Email verified:
                    {{ $admin->email_verified_at ? $admin->email_verified_at : 'Not verified yet' }}</h4>
            </div>
            <div class="row align-items-center gap-2">
                <h4 class="col">Role: {{ $admin->role }}</h4>
                <h4 class="col">Status:
                    <span class="text-{{ $admin->status == 'active' ? 'success' : 'danger' }} fw-bold"> {{ $admin->status }}</span>
                </h4>
            </div>
            <h4 class="col">Created at: {{ $admin->created_at->format('d/m/Y') }}</h4>
            <hr>

            {{-- Details --}}
            <h3 class="text-center text-info fw-bold">Diet details</h3>
            <div class="row justify-content-center">
                <div class="col">
                    <h5>Age: {{ $dietInfo ? $dietInfo->age : 0 }} years</h5>
                    <h5 class="border border-2">Gender: {{ $dietInfo ? $dietInfo->gender : 0 }}
                    </h5>
                    <h5>Weight: {{ $dietInfo ? $dietInfo->weight : 0 }} kg</h5>
                    <h5 class="border border-2">Height: {{ $dietInfo ? $dietInfo->height : 0 }} cm
                </div>
                <div class="col">
                    </h5>
                    <h5>Activity level: {{ $dietInfo ? $dietInfo->activity_level : 0 }}</h5>
                    <h5 class="border border-2">Workout hours per week:
                        {{ $dietInfo ? $dietInfo->workout_hours_per_week : 0 }} hour
                    </h5>
                    <h5>Created At: {{ $dietInfo ? $dietInfo->created_at : 0 }}</h5>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <form action="{{ route('admin.admin.delete', $admin->id) }}" method="post">
                @csrf
                @method("DELETE")
                <button type="submit" class="btn btn-danger btn-md">Delete Account</button>
            </form>
        </div>
    @endsection

    @section('script')
        <script>
            $(document).ready(function() {

            });
        </script>
    @endsection

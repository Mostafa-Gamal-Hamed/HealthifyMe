<x-app-layout>
    @section('meta')
    <meta name="keywords" content="health dashboard, user health profile, personal data, progress tracking, custom diet">
    <meta name="description" content="Track your progress, update personal data, and access customized diet recommendations all in one place.">
    @endsection

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Message --}}
    @include('message')

    {{-- User diets --}}
    @if ($info != null)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border border-success">
                    {{-- Ask or change diet --}}
                    <div class="d-flex justify-content-between w-100 mb-3">
                        <p>Name : {{ ucfirst($user->firstName) }} {{ ucfirst($user->lastName) }}</p>

                        <p>
                            Account : <span
                                class="{{ $user->status == 'active' ? 'text-success fw-bold' : 'text-danger fw-bold' }}">
                                {{ $user->status == 'active' ? 'Activated' : 'Inactive' }}
                            </span>
                        </p>

                        @if (!$dietInfo)
                            <p class="text-info">Please update your data.</p>
                        @elseif ($user->status === 'inactive')
                            <form action="{{ route('ask-for-diet.store') }}" method="post" class="text-end">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success px-4">Activation request</button>
                            </form>
                        @elseif ($user->diets->isNotEmpty() || $user->specialDiet)
                            <form action="{{ route('change-diet.store') }}" method="post" class="text-end">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info px-3">Change diet plane</button>
                            </form>
                        @else
                            <p class="text-muted">Wait for your diet to be created.</p>
                        @endif
                    </div>

                    {{-- Calories --}}
                    <div class="calories mb-4">
                        <p class="text-muted text-center">Calculating calories based on activity level</p>
                        <div class="row align-items-center justify-content-between gap-2 equationByActivity">
                            <h5 class="col-md-4" style="width: 48%;">Total daily calories (TDEE): <span class="fw-bold">{{ $tdee }}</span> Calories</h5>
                            <h5 class="col-md-4 text-end" style="width: 48%;">To lose 0.5 kg per week: <span class="fw-bold">{{ $lose_05kg }}</span> Calories per day</h5>
                            <h5 class="col-md-4" style="width: 48%;">To lose 1 kg per week: <span class="fw-bold">{{ $lose_1kg }}</span> Calories per day</h5>
                            <h5 class="col-md-4 text-end" style="width: 48%;">To lose 1.5 kg per week: <span class="fw-bold">{{ $lose_1_5kg }}</span> Calories per day</h5>
                        </div>
                    </div>

                    {{-- User diet --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="owl-carousel owl-theme owl-loaded">
                                <div class="owl-stage-outer">
                                    <div class="owl-stage">
                                        @foreach ($diets as $diet)
                                            <div class="owl-item">
                                                <div class="mb-3">
                                                    <h2 class="card-title text-center fw-bold">Diet Plan
                                                        {{ $loop->iteration }}
                                                    </h2>
                                                    <div>
                                                        <p class="card-text">Your diet plan is:
                                                            {{ $diet->name ?? 'Not created yet' }}
                                                        </p>
                                                        <br>
                                                        <p class="card-text">Your diet plan is:
                                                            {{ $diet->description ?? 'Not created yet' }}
                                                        </p>
                                                    </div>
                                                    <h2 class="text-center fw-bold mt-3">Exercises</h2>
                                                    <div class="row justify-content-between align-items-center gap-2">
                                                        @foreach (json_decode($diet->images) as $image)
                                                            <div class="col-md-3">
                                                                <img src="{{ asset('storage/' . $image ?? 'diets/Diet.jpg') }}"
                                                                    data-featherlight="<img src='{{ asset('storage/' . $image ?? 'diets/Diet.jpg') }}' style='max-width:500px;' class='img-fluid'>"
                                                                    class="img-fluid" alt="Diet plan image"
                                                                    style="cursor: pointer;">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <p class="text-end text-muted">{{ $diet->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        @endforeach
                                        @foreach ($specialDiet as $diet)
                                            <div class="owl-item">
                                                <div class="mb-3">
                                                    <h2 class="card-title text-center fw-bold">Diet Plan
                                                        {{ $loop->iteration }}
                                                    </h2>
                                                    <div>
                                                        <p class="card-text">Your diet plan is:
                                                            {{ $diet->name ?? 'Not created yet' }}
                                                        </p>
                                                        <br>
                                                        <p class="card-text">Your diet plan is:
                                                            {{ $diet->description ?? 'Not created yet' }}
                                                        </p>
                                                    </div>
                                                    <h2 class="text-center fw-bold mt-3">Exercises</h2>
                                                    <div class="row justify-content-between align-items-center gap-2">
                                                        @foreach (json_decode($diet->images) as $image)
                                                            <div class="col-md-3">
                                                                <img src="{{ asset('storage/' . $image ?? 'diets/Diet.jpg') }}"
                                                                    data-featherlight="<img src='{{ asset('storage/' . $image ?? 'diets/Diet.jpg') }}' style='max-width:500px;' class='img-fluid'>"
                                                                    class="img-fluid" alt="Diet plan image"
                                                                    style="cursor: pointer;">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <p class="text-end text-muted">{{ $diet->created_at->diffForHumans() }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{-- User last data --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border border-info">
                <h1 class="text-center fw-bold fs-4 mb-4">Your last data</h1>

                <div class="row justify-content-between w-100 gap-2 mb-4">
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Gender : <span class="fw-bold">{{ $dietInfo ? $dietInfo->gender : '0' }}</span>
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Age : <span class="fw-bold">{{ $dietInfo ? $dietInfo->age : '0' }}</span> years
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Weight : <span class="fw-bold">{{ $dietInfo ? $dietInfo->weight : '0' }}</span> Kg
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Height : <span class="fw-bold">{{ $dietInfo ? $dietInfo->height : '0' }}</span> cm
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Activity level : <span class="fw-bold">{{ $dietInfo ? ucfirst($dietInfo->activity_level) : '0' }}</span>
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%">
                        Workout hours per week : <span
                            class="fw-bold">{{ $dietInfo ? $dietInfo->workout_hours_per_week : '0' }}</span> hour
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Body fat : <span class="fw-bold">{{ $dietInfo ? $dietInfo->bodyFat : '0' }}</span> %
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Body water : <span class="fw-bold">{{ $dietInfo ? $dietInfo->bodyWater : '0' }}</span> %
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Diseases : <span class="fw-bold">{{ $dietInfo ? $dietInfo->diseases : '' }}</span>.
                    </div>
                    <div class="col-2 rounded form-control" style="width: 48%;">
                        Treatment : <span class="fw-bold">{{ $dietInfo ? $dietInfo->treatment : '' }}</span>.
                    </div>
                </div>


                <div class="text-center">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4">Update data</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 1,
                        nav: false
                    },
                    1000: {
                        items: 1,
                        nav: false,
                        loop: true
                    }
                }
            });
        });
    </script>
</x-app-layout>

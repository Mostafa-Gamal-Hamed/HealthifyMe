@extends('admin.layout')

@section('title')
    {{ $user->firstName }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center mt-5">{{ $user->firstName . ' ' . $user->lastName }}</h2>

        {{-- User details & diets --}}
        <div class="shadow shadow-lg bg-light text-dark p-3">
            {{-- Inactive account --}}
            @if ($user->status === "active")
                <div class="text-end">
                    <a href="{{ route('admin.user.status', ['type' => 'inactive', 'id' => $user->id]) }}"
                        class="btn btn-sm btn-danger" onclick="return confirm('Change to inactive?');">
                        Inactive Account
                    </a>
                </div>
            @endif

            {{-- Details --}}
            <h3 class="text-center text-info fw-bold">Details</h3>
            <div class="row justify-content-center">
                <div class="col">
                    <h5 class="border border-2">Email: {{ $user->email }}</h5>
                    <h5>Age: {{ $dietInfo ? $dietInfo->age : 0 }} years</h5>
                    <h5 class="border border-2">Gender: {{ $dietInfo ? $dietInfo->gender : 0 }}
                    </h5>
                    <h5>Weight: {{ $dietInfo ? $dietInfo->weight : 0 }} kg</h5>
                </div>
                <div class="col">
                    <h5 class="border border-2">Height: {{ $dietInfo ? $dietInfo->height : 0 }} cm
                    </h5>
                    <h5>Activity level: {{ $dietInfo ? $dietInfo->activity_level : 0 }}</h5>
                    <h5 class="border border-2">Workout hours per week:
                        {{ $dietInfo ? $dietInfo->workout_hours_per_week : 0 }} hour
                    </h5>
                    <h5>Created At: {{ $dietInfo ? $dietInfo->created_at : 0 }}</h5>
                </div>
            </div>
            <hr>

            {{-- Calorie counting --}}
            <h3 class="text-center fw-bold">Calories counting</h3>
            <div>
                <p class="text-muted text-center">BMR equation</p>
                <div id="equation">
                    @if ($bmr)
                        <h5 id="bmr">
                            BMR = (10 * {{ $dietInfo->weight }}) + (6.25 * {{ $dietInfo->height }}) - (5 *
                            {{ $dietInfo->age }}) + 5 =
                            {{ $bmr }} calories
                        </h5>
                    @else
                        <p class="text-muted">Some data is not completed.</p>
                    @endif
                </div>
                <p class="text-muted text-center">Calculating calories based on activity level</p>
                <div id="equationByActivity">
                    <h5>Total daily calories (TDEE): {{ $tdee }} Calories</h5>
                </div>
                <div>
                    <h5>To lose 0.5 kg per week: {{ $lose_05kg }} Calories per day</h5>
                    <h5>To lose 1 kg per week: {{ $lose_1kg }} Calories per day</h5>
                    <h5>To lose 1.5 kg per week: {{ $lose_1_5kg }} Calories per day</h5>
                </div>
            </div>
            <hr>

            {{-- Special diet --}}
            <h3 class="text-center fw-bold mt-3">Special Diet</h3>
            @if (!$user->specialDiet)
                <p class="text-danger">No special diet yet.</p>
            @else
                <div class="owl-carousel p-3 d-block rounded text-light" style="background-color: #0a58ca;">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            <div class="owl-item">
                                <h5>Name</h5>
                                <p>{{ $user->specialDiet->name }}</p>
                                <h5>Description</h5>
                                <p class="p-2">{{ $user->specialDiet->description }}</p>
                                <h5>Calories</h5>
                                <p>{{ $user->specialDiet->calories }}</p>
                                <h5>Workouts</h5>
                                <p class="p-2">{{ $user->specialDiet->workouts }}</p>
                                <h5>Created_at</h5>
                                <p>{{ $user->specialDiet->created_at->format('d-m-y') }}</p>
                                <form action="{{ route('admin.specialDiet.delete', $user->specialDiet->id) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-warning">Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <hr>

            {{-- Diet --}}
            <h3 class="text-center fw-bold mt-3">Diet</h3>
            @if ($user->diets->isEmpty())
                <p class="text-danger">No diet yet.</p>
            @else
                <h5>Diets:{{ count($user->diets) }}</h5>
                <div class="owl-carousel p-3 d-block rounded text-light" style="background-color: #197c87;">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            @foreach ($user->diets as $diet)
                                <div class="owl-item">
                                    <p>{{ $loop->iteration }}</p>
                                    <h5>Name</h5>
                                    <p>{{ $diet->name }}</p>
                                    <h5>Description</h5>
                                    <p class="p-2">{{ $diet->description }}</p>
                                    <h5>Calories</h5>
                                    <p>{{ $diet->calories }}</p>
                                    <h5>Workouts</h5>
                                    <p class="p-2">{{ $diet->workouts }}</p>
                                    <h5>Created_at</h5>
                                    <p>{{ $diet->created_at->format('d-m-Y') }}</p>
                                    <form action="{{ route('admin.user.deleteDiet', $diet->id) }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-sm btn-warning">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <hr>

        {{-- create diet --}}
        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="d-flex flex-column justify-content-center">
                @if ($user->status === 'active')
                    {{-- Diet --}}
                    <div class="col">
                        <h3 class="text-center text-success fw-bold mb-3">Choose diet</h3>
                        <form action="{{ route('admin.user.diet', $user->id) }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="selectDiet" class="form-label">Diets</label>
                                <select class="form-select form-select-md @error('diet_id') is-invalid @enderror"
                                    name="diet_id" id="selectDiet">
                                    <option hidden>Select Diet</option>
                                    @foreach ($diets as $diet)
                                        <option value="{{ $diet->id }}">{{ $diet->name }}</option>
                                    @endforeach
                                </select>
                                @error('diet_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary px-4">Create</button>
                        </form>
                    </div>
                    <hr>

                    {{-- Special diet --}}
                    <div class="col">
                        <h3 class="text-center text-success fw-bold mb-3">Create special diet</h3>
                        <form action="{{ route('admin.specialDiet.store', "$user->id") }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- Name --}}
                            <div class="form-floating mb-3">
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') }}" placeholder="Diet name:">
                                <label for="name">Diet name</label>
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="form-floating mb-3">
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Diet description:" id="description" style="height: 100px">{{ old('description') }}</textarea>
                                <label for="description">Diet description</label>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Calories --}}
                            <div class="form-floating mb-3">
                                <input type="number" name="calories"
                                    class="form-control @error('calories') is-invalid @enderror"
                                    value="{{ old('calories') }}" id="calories" placeholder="Calories:">
                                <label for="calories">Calories</label>
                                @error('calories')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Workouts --}}
                            <div class="form-floating mb-3">
                                <textarea name="workouts" class="form-control @error('workouts') is-invalid @enderror" placeholder="Workouts"
                                    id="workouts" style="height: 100px">{{ old('workouts') }}</textarea>
                                <label for="workouts">Workouts</label>
                                @error('workouts')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Images --}}
                            <div class="mb-3">
                                <label for="images">Images</label>
                                <input type="file" name="images[]"
                                    class="form-control @error('images') is-invalid @enderror"
                                    value="{{ old('images') }}" id="images" multiple
                                    accept=".jpg, .jpeg, .png, .gif">
                                @error('images')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md px-4 btn-primary">Create</button>
                        </form>
                    </div>
                @else
                    <div class="text-center">
                        <h5 class="text-danger fw-bold mb-3">The account has not been activated yet.</h5>
                        <a href="{{ route('admin.user.status', ['type' => 'active', 'id' => $user->id]) }}"
                            class="btn btn-success" onclick="return confirm('Change to active?');">
                            Active Account
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Owl latestNews
            $('.owl-carousel').owlCarousel({
                items: 1,
                loop: true,
                center: true,
                margin: 10,
                dots: true,
                responsiveClass: true,
                autoHeight: true
            })
        });
    </script>
@endsection

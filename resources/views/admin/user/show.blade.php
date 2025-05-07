@extends('admin.layout')

@section('title', $user->firstName . ' ' . $user->lastName)

@section('style')
    <style>
        .profile-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .profile-header {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px 12px 0 0;
        }

        .profile-section {
            padding: 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .profile-section-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .detail-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #212529;
        }

        .nutrition-equation {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            font-family: 'Courier New', monospace;
        }

        .diet-card {
            background: #0a58ca;
            color: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-floating label {
            transition: all 0.2s ease;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="profile-container mb-5">
            {{-- Profile Header --}}
            <div class="profile-header text-center">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">{{ $user->firstName }} {{ $user->lastName }}</h2>
                    @if ($user->status === 'active')
                        <button onclick="confirmStatusChange({{ $user->id }} , 'inactive')" class="btn btn-sm btn-danger">
                            <i class="fas fa-user-slash me-1"></i> Deactivate Account
                        </button>
                    @else
                        <button onclick="confirmStatusChange({{ $user->id }} , 'active')" class="btn btn-sm btn-success">
                            <i class="fas fa-user-check me-1"></i> Activate Account
                        </button>
                    @endif
                </div>
                <span class="status-badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                    {{ ucfirst($user->status) }} Account
                </span>
            </div>

            {{-- User Details Section --}}
            <div class="profile-section">
                <h4 class="profile-section-title">
                    <i class="fas fa-user-circle me-2"></i>Personal Details
                </h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="detail-label">Email</div>
                            <div class="detail-value">{{ $user->email }}</div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Age</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->age : 'N/A' }} years</div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Gender</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->gender : 'N/A' }}</div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Weight</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->weight : 'N/A' }} kg</div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Body Fat</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->bodyFat : 'N/A' }}%</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="detail-card">
                            <div class="detail-label">Height</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->height : 'N/A' }} cm</div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Activity Level</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->activity_level : 'N/A' }}</div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Workout Hours/Week</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->workout_hours_per_week : 'N/A' }} hours
                            </div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Target</div>
                            <div class="detail-value">{{ $dietInfo ? $dietInfo->target : 'N/A' }}</div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-label">Last Updated</div>
                            <div class="detail-value">
                                {{ $dietInfo ? $dietInfo->updated_at->format('h:i A d/m/Y') : 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                @if ($dietInfo && $dietInfo->diseases)
                    <div class="detail-card">
                        <div class="detail-label">Health Notes</div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-label">Diseases/Conditions</div>
                                <div class="detail-value">{{ $dietInfo->diseases }}</div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-label">Current Treatment</div>
                                <div class="detail-value">{{ $dietInfo->treatment }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Calorie Calculation Section --}}
            @if ($bmr)
                <div class="profile-section">
                    <h4 class="profile-section-title">
                        <i class="fas fa-calculator me-2"></i>Calorie Calculations
                    </h4>

                    <div class="mb-4">
                        <h5 class="text-center text-muted mb-3">BMR Equation (Harris-Benedict)</h5>
                        <div class="nutrition-equation mb-3">
                            BMR = (10 × {{ $dietInfo->weight }}) + (6.25 × {{ $dietInfo->height }}) - (5 ×
                            {{ $dietInfo->age }}) + 5 = {{ $bmr }} kcal/day
                        </div>

                        <h5 class="text-center text-muted mb-3">Total Daily Energy Expenditure (TDEE)</h5>
                        <div class="alert alert-primary">
                            <i class="fas fa-fire me-2"></i> Maintenance Calories: <strong>{{ $tdee }}
                                kcal/day</strong>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="detail-card">
                                    <div class="detail-label">Lose 0.5kg/week</div>
                                    <div class="detail-value">{{ $lose_05kg }} kcal/day</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-card">
                                    <div class="detail-label">Lose 1kg/week</div>
                                    <div class="detail-value">{{ $lose_1kg }} kcal/day</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-card">
                                    <div class="detail-label">Lose 1.5kg/week</div>
                                    <div class="detail-value">{{ $lose_1_5kg }} kcal/day</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Current Diet Plan --}}
            <div class="profile-section">
                <h4 class="profile-section-title">
                    <i class="fas fa-utensils me-2"></i>Current Diet Plan
                </h4>

                @if (!$user->specialDiet)
                    <p class="text-danger">No diets yet.</p>
                @else
                    <div class="owl-carousel p-3 d-block rounded text-light bg-dark">
                        <div class="owl-stage-outer">
                            <div class="owl-stage">
                                @foreach ($specialDiets as $diet)
                                    <div class="owl-item">
                                        <div class="row justify-content-between gap-2 mb-2">
                                            <div class="col">
                                                <h5>Name</h5>
                                                <p>{{ $diet->name }}</p>
                                            </div>
                                            <div class="col text-end">
                                                <p>Created_at: {{ $diet->created_at->format('d-m-Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <h5>Description</h5>
                                            <p class="p-2">{{ $diet->description }}</p>
                                        </div>
                                        <div class="mb-2">
                                            <h5>Calories</h5>
                                            <p>{{ $diet->calories }}</p>
                                        </div>
                                        <div class="mb-2">
                                            <h5>Workouts</h5>
                                            <p class="p-2">{{ $diet->workouts }}</p>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center gap-3">
                                            @foreach (json_decode($diet->images) as $image)
                                                <img src="{{ asset("storage/$image") }}" class="img-fluid rounded-top" style="max-width: 100px; cursor: pointer;" alt="Workouts image"
                                                data-featherlight="<img src='{{ asset("storage/$image") }}' style='width: 400px;'>">
                                            @endforeach
                                        </div>

                                        <form action="{{ route('admin.specialDiet.delete', $diet->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-warning">Remove</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Create New Diet Plan --}}
            @if ($user->status === 'active')
                <div class="profile-section">
                    <h4 class="profile-section-title">
                        <i class="fas fa-plus-circle me-2"></i>Create New Diet Plan
                    </h4>

                    <form action="{{ route('admin.specialDiet.store', $user->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3">
                            {{-- Name --}}
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        value="{{ old('name') }}" placeholder="Diet name" required>
                                    <label for="name">Diet Plan Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Calories --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="calories"
                                        class="form-control @error('calories') is-invalid @enderror"
                                        value="{{ old('calories') }}" id="calories" placeholder="Calories" required>
                                    <label for="calories">Target Calories</label>
                                    @error('calories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Protein --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="protein"
                                        class="form-control @error('protein') is-invalid @enderror"
                                        value="{{ old('protein') }}" id="protein" placeholder="Protein"
                                        step="0.01" required>
                                    <label for="protein">Target Protein</label>
                                    @error('protein')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Carbohydrates --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="carbs"
                                        class="form-control @error('carbs') is-invalid @enderror"
                                        value="{{ old('carbs') }}" id="carbs" placeholder="Carbohydrates"
                                        step="0.01" required>
                                    <label for="carbs">Target Carbohydrates</label>
                                    @error('carbs')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fats --}}
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" name="fats"
                                        class="form-control @error('fats') is-invalid @enderror"
                                        value="{{ old('fats') }}" id="fats" placeholder="Fats" step="0.01"
                                        required>
                                    <label for="fats">Target Fats</label>
                                    @error('fats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Diet description" id="description" style="height: 100px" required>{{ old('description') }}</textarea>
                                    <label for="description">Diet Description</label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Workouts --}}
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <textarea name="workouts" class="form-control @error('workouts') is-invalid @enderror"
                                        placeholder="Recommended workouts" id="workouts" style="height: 100px">{{ old('workouts') }}</textarea>
                                    <label for="workouts">Recommended Workouts</label>
                                    @error('workouts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Workouts images --}}
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Workouts Images (Optional)</label>
                                    <input type="file" name="images[]"
                                        class="form-control @error('images') is-invalid @enderror" id="images" multiple
                                        accept=".jpg,.jpeg,.png,.gif">
                                    <small class="text-muted">You can upload multiple images (JPG, JPEG, PNG, GIF)</small>
                                    @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-2"></i> Create Diet Plan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
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

        function confirmStatusChange(userId, newStatus) {
            Swal.fire({
                title: 'Confirm Account Status Change',
                text: `Are you sure you want to set this account to ${newStatus}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, set to ${newStatus}!`
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{{ url('status/${newStatus}/${userId}') }}`;
                }
            });
        }
    </script>
@endsection

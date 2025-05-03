@extends('admin.layout')

@section('title', 'Add New Admin')

@section('style')
    <style>
        .admin-form-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .form-floating label {
            transition: all 0.2s ease;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 5;
        }

        .role-select {
            height: 58px;
            /* Match form-floating height */
        }

        .password-strength {
            height: 4px;
            margin-top: 5px;
            border-radius: 2px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center text-primary fw-bold mb-4">Add New Administrator</h2>

                @include('admin.success')

                <div class="admin-form-container p-4 mb-5">
                    <form action="{{ route('admin.admin.store') }}" method="post" id="adminForm">
                        @csrf

                        <div class="row g-3">
                            {{-- First Name --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="firstName"
                                        class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                                        value="{{ old('firstName') }}" placeholder="First name" required>
                                    <label for="firstName">First Name</label>
                                    @error('firstName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Last Name --}}
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="lastName"
                                        class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                                        value="{{ old('lastName') }}" placeholder="Last name" required>
                                    <label for="lastName">Last Name</label>
                                    @error('lastName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                        value="{{ old('email') }}" placeholder="Email address" required>
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="col-12">
                                <div class="form-floating">
                                    <select class="form-select @error('role') is-invalid @enderror role-select"
                                        name="role" id="role" required>
                                        <option value="" disabled selected>Select a role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="superAdmin" {{ old('role') == 'superAdmin' ? 'selected' : '' }}>Super
                                            Admin</option>
                                    </select>
                                    <label for="role">Administrator Role</label>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="col-md-6 position-relative">
                                <div class="form-floating">
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Password" required minlength="8" data-strength-meter>
                                    <label for="password">Password</label>
                                    <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                                    <div class="password-strength" id="passwordStrength"></div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Minimum 8 characters</small>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 position-relative">
                                <div class="form-floating">
                                    <input type="password" name="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" placeholder="Confirm Password" required>
                                    <label for="password_confirmation">Confirm Password</label>
                                    <i class="fas fa-eye password-toggle" id="toggleConfirmPassword"></i>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="reset" class="btn btn-outline-secondary me-md-2 px-4">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-user-plus me-2"></i>Create Admin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.querySelector('#togglePassword');
            const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
            const password = document.querySelector('#password');
            const passwordConfirmation = document.querySelector('#password_confirmation');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function() {
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    this.classList.toggle('fa-eye-slash');
                });
            }

            if (toggleConfirmPassword && passwordConfirmation) {
                toggleConfirmPassword.addEventListener('click', function() {
                    const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' :
                        'password';
                    passwordConfirmation.setAttribute('type', type);
                    this.classList.toggle('fa-eye-slash');
                });
            }

            // Password strength meter
            const passwordStrength = document.getElementById('passwordStrength');
            if (password && passwordStrength) {
                password.addEventListener('input', function() {
                    const strength = calculatePasswordStrength(this.value);
                    passwordStrength.style.width = `${strength.percentage}%`;
                    passwordStrength.style.backgroundColor = strength.color;
                });
            }

            function calculatePasswordStrength(password) {
                let strength = 0;

                // Length check
                if (password.length >= 8) strength += 25;
                if (password.length >= 12) strength += 15;

                // Character diversity
                if (/[A-Z]/.test(password)) strength += 15;
                if (/[a-z]/.test(password)) strength += 15;
                if (/[0-9]/.test(password)) strength += 15;
                if (/[^A-Za-z0-9]/.test(password)) strength += 15;

                // Cap at 100
                strength = Math.min(strength, 100);

                // Determine color
                let color;
                if (strength < 40) color = '#dc3545'; // Weak (red)
                else if (strength < 70) color = '#ffc107'; // Medium (yellow)
                else color = '#28a745'; // Strong (green)

                return {
                    percentage: strength,
                    color
                };
            }

            // Form validation
            const form = document.getElementById('adminForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (password.value !== passwordConfirmation.value) {
                        e.preventDefault();
                        alert('Passwords do not match!');
                        passwordConfirmation.focus();
                    }
                });
            }
        });
    </script>
@endsection

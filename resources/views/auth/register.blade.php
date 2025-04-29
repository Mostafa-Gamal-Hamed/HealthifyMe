@extends('user.layout')

@section('meta')
    <meta name="title" content="Register | HealthifyMe - Start Your Health Journey">
    <meta name="description"
        content="Create your HealthifyMe account to access personalized diet plans, calorie tracking, and health recommendations tailored to your goals.">
    <meta name="keywords" content="healthifyme register, create account, diet plan signup, nutrition tracker, health account">
@endsection

@section('title')
    Register | HealthifyMe - Start Your Health Journey
@endsection


@section('style')
    <style>
        .register-page {
            background-color: #f8f9fa;
        }

        .min-vh-100 {
            min-height: 100vh;
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
        }

        .toggle-password {
            border-radius: 0 8px 8px 0 !important;
        }

        .password-strength .progress {
            border-radius: 4px;
        }

        .password-strength .progress-bar {
            transition: width 0.3s ease;
        }

        @media (max-width: 576px) {
            .card {
                margin: 0 15px;
            }
        }
    </style>
@endsection

@section('body')
    <div class="register-page">
        <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
            <div class="card shadow-lg p-3 p-md-4" style="width: 100%; max-width: 500px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="HealthifyMe Logo" class="mb-3" width="120">
                        <p class="text-muted">Join HealthifyMe and start your journey to a healthier life!</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                        @csrf

                        <!-- Name Row -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input id="firstName" type="text"
                                    class="form-control @error('firstName') is-invalid @enderror" name="firstName"
                                    value="{{ old('firstName') }}" required autofocus>
                                @error('firstName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input id="lastName" type="text"
                                    class="form-control @error('lastName') is-invalid @enderror" name="lastName"
                                    value="{{ old('lastName') }}" required>
                                @error('lastName')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    minlength="8">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Minimum 8 characters</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="password-strength-text"></small>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3 position-relative">
                            <label for="password-confirm" class="form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-match mt-2"></div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="form-check mb-4">
                            <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                name="terms" id="terms" {{ old('terms') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="{{ route('TermsOfService') }}" target="_blank"
                                    class="text-primary">Terms of Service</a>
                                and <a href="{{ route('PrivacyPolicy') }}" target="_blank" class="text-primary">Privacy
                                    Policy</a>.
                            </label>
                            @error('terms')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg py-2">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                Create Account
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-1">Already have an account? <a href="{{ route('login') }}"
                                    class="text-primary fw-semibold">Log in</a></p>
                            <p class="text-muted small mt-3">By registering, you agree to our terms and conditions</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            // Password toggle functionality
            $('.toggle-password').on('click', function() {
                const input = $(this).parent().find('input');
                const icon = $(this).find('i');
                const type = input.attr('type') === 'password' ? 'text' : 'password';

                input.attr('type', type);
                icon.toggleClass('fa-eye fa-eye-slash');
            });

            // Password strength indicator
            const passwordInput = $('#password');
            const progressBar = $('.password-strength .progress-bar');
            const strengthText = $('.password-strength-text');

            passwordInput.on('input', function() {
                const password = $(this).val();
                let strength = 0;

                // Length check
                if (password.length >= 8) strength += 1;
                if (password.length >= 12) strength += 1;

                // Character type checks
                if (/[A-Z]/.test(password)) strength += 1;
                if (/[0-9]/.test(password)) strength += 1;
                if (/[^A-Za-z0-9]/.test(password)) strength += 1;

                // Update progress bar
                const width = (strength / 5) * 100;
                progressBar.css('width', width + '%');

                // Update text and color
                if (password.length === 0) {
                    strengthText.text('');
                    progressBar.attr('class', 'progress-bar');
                } else if (strength <= 2) {
                    strengthText.text('Weak');
                    progressBar.attr('class', 'progress-bar bg-danger');
                } else if (strength <= 3) {
                    strengthText.text('Moderate');
                    progressBar.attr('class', 'progress-bar bg-warning');
                } else {
                    strengthText.text('Strong');
                    progressBar.attr('class', 'progress-bar bg-success');
                }
            });

            // Password match checker
            const confirmInput = $('#password-confirm');
            const matchIndicator = $('.password-match');

            confirmInput.on('input', function() {
                if ($(this).val() !== passwordInput.val() && passwordInput.val().length > 0) {
                    matchIndicator.html('<small class="text-danger">Passwords do not match</small>');
                } else if (passwordInput.val().length > 0) {
                    matchIndicator.html('<small class="text-success">Passwords match</small>');
                } else {
                    matchIndicator.html('');
                }
            });

            // Form submission loading state
            const form = $('#registerForm');
            form.on('submit', function() {
                const submitButton = $(this).find('button[type="submit"]');
                const spinner = submitButton.find('.spinner-border');

                submitButton.prop('disabled', true);
                spinner.removeClass('d-none');
                submitButton.html(spinner.prop('outerHTML') + ' Creating Account...');
            });
        });
    </script>
@endsection

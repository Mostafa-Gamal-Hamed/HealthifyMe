@extends('user.layout')

@section('meta')
    <meta name="title" content="Reset Password | HealthifyMe - Set New Password">
    <meta name="description"
        content="Set a new password for your HealthifyMe account. Enter your email and new password to regain access to your health dashboard.">
    <meta name="keywords" content="healthifyme reset password, new password, password recovery, account recovery">
@endsection

@section('title')
    Reset Password | HealthifyMe - Set New Password
@endsection

@section('style')
    <style>
        .reset-password-page {
            background-color: #f8f9fa;
            background-image: url("{{ asset('images/auth-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
        }

        .min-vh-100 {
            min-height: 100vh;
        }

        .card {
            border-radius: 12px;
            border: none;
            background-color: rgba(255, 255, 255, 0.95);
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
        }

        .form-control[readonly] {
            background-color: #f8f9fa;
        }

        .password-strength .progress {
            border-radius: 4px;
        }

        .password-strength .progress-bar {
            transition: width 0.3s ease;
        }

        .toggle-password {
            border-radius: 0 8px 8px 0 !important;
        }

        @media (max-width: 576px) {
            .card {
                margin: 0 15px;
            }
        }
    </style>
@endsection

@section('body')
    <div class="reset-password-page bg-light">
        <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
            <div class="card shadow-lg p-3 p-md-4" style="width: 100%; max-width: 500px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="HealthifyMe Logo" class="mb-3" width="120">
                        <h2 class="fw-bold text-success">Create New Password</h2>
                        <p class="text-muted">Choose a strong password to secure your account</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control" name="email"
                                value="{{ old('email', $request->email) }}" required autocomplete="email" readonly>
                        </div>

                        <!-- New Password -->
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password" minlength="8">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Minimum 8 characters with at least one number and one
                                letter</small>
                            <div class="password-strength mt-2">
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small class="password-strength-text"></small>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4 position-relative">
                            <label for="password-confirm" class="form-label">Confirm Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-match mt-2"></div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg py-2">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                Reset Password
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="mb-0">Remember your password? <a href="{{ route('login') }}"
                                    class="text-primary fw-semibold">Log In</a></p>
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
            $('#password').on('input', function() {
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
                $('.password-strength .progress-bar').css('width', width + '%');

                // Update text and color
                if (password.length === 0) {
                    $('.password-strength-text').text('');
                    $('.password-strength .progress-bar').attr('class', 'progress-bar');
                } else if (strength <= 2) {
                    $('.password-strength-text').text('Weak');
                    $('.password-strength .progress-bar').attr('class', 'progress-bar bg-danger');
                } else if (strength <= 3) {
                    $('.password-strength-text').text('Moderate');
                    $('.password-strength .progress-bar').attr('class', 'progress-bar bg-warning');
                } else {
                    $('.password-strength-text').text('Strong');
                    $('.password-strength .progress-bar').attr('class', 'progress-bar bg-success');
                }
            });

            // Password match checker
            $('#password-confirm').on('input', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();

                if (confirmPassword !== password && password.length > 0) {
                    $('.password-match').html('<small class="text-danger">Passwords do not match</small>');
                } else if (password.length > 0) {
                    $('.password-match').html('<small class="text-success">Passwords match</small>');
                } else {
                    $('.password-match').html('');
                }
            });

            // Form submission loading state
            $('#resetPasswordForm').on('submit', function() {
                const submitButton = $(this).find('button[type="submit"]');
                const spinner = submitButton.find('.spinner-border');

                submitButton.prop('disabled', true);
                spinner.removeClass('d-none');
                submitButton.html(spinner.prop('outerHTML') + ' Resetting...');
            });
        });
    </script>
@endsection

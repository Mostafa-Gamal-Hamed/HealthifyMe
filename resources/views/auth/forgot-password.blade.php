@extends('user.layout')

@section('meta')
    <meta name="title" content="Forgot Password | HealthifyMe - Recover Your Account">
    <meta name="description"
        content="Reset your HealthifyMe account password. Enter your email to receive password reset instructions.">
    <meta name="keywords" content="healthifyme forgot password, password reset, recover account, healthifyme login help">
@endsection

@section('title')
    Forgot Password | HealthifyMe - Recover Your Account
@endsection

@section('style')
    <style>
        .forgot-password-page {
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

        @media (max-width: 576px) {
            .card {
                margin: 0 15px;
            }
        }
    </style>
@endsection

@section('body')
    <div class="forgot-password-page bg-light">
        <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
            <div class="card shadow-lg p-3 p-md-4" style="width: 100%; max-width: 500px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="HealthifyMe Logo" class="mb-3" width="120">
                        <h2 class="fw-bold text-success">Reset Your Password</h2>
                        <p class="text-muted">Enter your email to receive reset instructions</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg py-2">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                Send Reset Link
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
            // Form submission loading state
            $('#forgotPasswordForm').on('submit', function() {
                const submitButton = $(this).find('button[type="submit"]');
                const spinner = submitButton.find('.spinner-border');

                submitButton.prop('disabled', true);
                spinner.removeClass('d-none');
                submitButton.html(spinner.prop('outerHTML') + ' Sending...');
            });

            // Email validation on blur
            $('#email').on('blur', function() {
                const email = $(this).val();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email && !emailRegex.test(email)) {
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').text('Please enter a valid email address');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection

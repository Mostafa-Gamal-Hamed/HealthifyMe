@extends('user.layout')

@section('meta')
    <meta name="title" content="Login | HealthifyMe - Access Your Health Dashboard">
    <meta name="description"
        content="Sign in to your HealthifyMe account to access personalized diet plans, nutrition tracking, and health recommendations.">
    <meta name="keywords" content="healthifyme login, sign in, diet account, nutrition tracker login, health dashboard">
@endsection

@section('title')
    Login | HealthifyMe - Access Your Health Dashboard
@endsection


@section('style')
    <style>
        .login-page {
            background-color: #f8f9fa;
            background-image: url("{{ asset('images/login-bg.jpg') }}");
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

        .btn-primary {
            background-color: #4e73df;
            border: none;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #3a5ec0;
        }

        .toggle-password {
            border-radius: 0 8px 8px 0 !important;
        }

        .divider {
            position: relative;
        }

        .divider:before,
        .divider:after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider:before {
            margin-right: .5rem;
        }

        .divider:after {
            margin-left: .5rem;
        }

        @media (max-width: 576px) {
            .card {
                margin: 0 15px;
            }
        }
    </style>
@endsection

@section('body')
    <div class="login-page bg-light">
        <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
            <div class="card shadow-lg p-3 p-md-4" style="width: 100%; max-width: 500px;">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="HealthifyMe Logo" class="mb-3" width="120">
                        <p class="text-muted">Log in to continue your health journey</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                                    autocomplete="current-password">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                            <div>
                                <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">Forgot
                                    Password?</a>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-success btn-lg py-2">
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                                Log In
                            </button>
                        </div>

                        <!-- Social Login -->
                        {{-- <div class="text-center mb-4">
                            <div class="divider d-flex align-items-center justify-content-center mb-3">
                                <span class="text-muted px-2">Or continue with</span>
                            </div>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ url('login.google') }}" class="btn btn-outline-danger">
                                    <i class="fab fa-google me-2"></i> Google
                                </a>
                                <a href="{{ url('login.facebook') }}" class="btn btn-outline-primary">
                                    <i class="fab fa-facebook-f me-2"></i> Facebook
                                </a>
                            </div>
                        </div> --}}

                        <div class="text-center">
                            <p class="mb-0">Don't have an account? <a href="{{ url('register') }}"
                                    class="text-primary fw-semibold">Register Now</a></p>
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

            // Form submission loading state
            $('#loginForm').on('submit', function() {
                const submitButton = $(this).find('button[type="submit"]');
                const spinner = submitButton.find('.spinner-border');

                submitButton.prop('disabled', true);
                spinner.removeClass('d-none');
                submitButton.html(spinner.get(0).outerHTML + ' Log In...');
            });
        });
    </script>
@endsection

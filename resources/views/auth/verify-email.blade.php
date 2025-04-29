@extends('user.layout')

@section('meta')
    <meta name="title" content="Verify Email | HealthifyMe - Confirm Your Account">
    <meta name="description"
        content="Verify your email address to complete your HealthifyMe account registration and access all features.">
    <meta name="keywords" content="healthifyme email verification, confirm email, account activation, verify account">
@endsection

@section('title')
    Verify Email | HealthifyMe - Confirm Your Account
@endsection

@section('style')
    <style>
        .verify-email-page {
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

        @media (max-width: 576px) {
            .card {
                margin: 0 15px;
            }
        }
    </style>
@endsection

@section('body')
    <div class="verify-email-page bg-light">
        <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
            <div class="card shadow-lg p-3 p-md-4" style="width: 100%; max-width: 500px;">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img src="{{ asset('images/email-verification.png') }}" alt="Email Verification"
                            class="img-fluid mb-3" width="120">
                        <h2 class="fw-bold text-success">Verify Your Email Address</h2>

                        @if (session('resent'))
                            <div class="alert alert-success mt-3">
                                A fresh verification link has been sent to your email address.
                            </div>
                        @endif
                    </div>

                    <p class="mb-4">
                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email,
                    </p>

                    <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg px-4 py-2">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Click here to request another
                        </button>
                    </form>

                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3">
                            <h5 class="text-muted">Didn't get the email?</h5>
                        </div>
                        <ul class="list-unstyled text-start">
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Check your spam/junk folder
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Make sure you entered the correct email
                            </li>
                            <li>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Wait a few minutes and try again
                            </li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted">Need help? <a href="{{ route('contact.create') }}"
                                class="text-primary">Contact our support team</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Form submission loading state
            $('form').on('submit', function() {
                const submitButton = $(this).find('button[type="submit"]');
                const spinner = submitButton.find('.spinner-border');

                submitButton.prop('disabled', true);
                spinner.removeClass('d-none');
                submitButton.html(spinner.prop('outerHTML') + ' Sending...');
            });
        });
    </script>
@endsection

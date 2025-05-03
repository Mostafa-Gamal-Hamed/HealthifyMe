@extends('user.layout')

@section('meta')
    <meta name="title" content="Contact HealthifyMe | Customer Support & Feedback">
    <meta name="description"
        content="Need help or have feedback? Contact HealthifyMe's support team via email, phone, or our contact form. We're here to assist you with all health and nutrition inquiries.">
    <meta name="keywords" content="healthifyme contact, customer support, nutrition help, feedback form, health questions">
    <meta property="og:title" content="Contact HealthifyMe | Customer Support & Feedback">
    <meta property="og:description"
        content="Reach out to HealthifyMe's support team for assistance with your health and nutrition journey.">
    <meta property="og:image" content="{{ asset('images/contact-social.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
@endsection

@section('title')
    Contact Us | HealthifyMe Support
@endsection

@section('style')
    <style>
        .contact {
            padding: 3rem 0;
            background-color: #f8f9fa;
        }

        .contact-form {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            margin-top: 2rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-control,
        .form-select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }

        .btn-submit {
            background-color: #4e73df;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #3a5ec0;
            transform: translateY(-2px);
        }

        .error {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .contact-info {
            background: #ffffff;
            border-radius: 12px;
            padding: 2rem;
            height: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .contact-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .contact-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            color: #4e73df;
        }

        .social-icon {
            font-size: 1.25rem;
            color: #4e73df;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            color: #3a5ec0;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .contact-form {
                padding: 1.5rem;
            }

            .contact-info {
                margin-top: 2rem;
            }
        }
    </style>
@endsection

@section('body')
    <div id="contact" class="contact">
        <div class="container py-5">
            <div class="contact-header">
                <h1 class="display-5 fw-bold mb-3">We'd Love to Hear From You</h1>
                <p class="lead">Have questions, feedback, or suggestions? Our team is ready to help you on your health
                    journey.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="contact-form">
                        <h3 class="mb-4">Send us a message</h3>

                        <form action="{{ route('contact.store') }}" method="post" id="contactForm" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">Full Name *</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name') }}" placeholder="Your name" required>
                                @error('name')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    value="{{ old('email') }}" placeholder="your@email.com">
                                @error('email')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="subject" class="form-label">Subject *</label>
                                <select name="subject" class="form-select @error('subject') is-invalid @enderror"
                                    id="subject" required>
                                    <option value="" disabled selected>Select a subject</option>
                                    <option value="General Inquiry" @selected(old('subject') == 'General Inquiry')>General Inquiry</option>
                                    <option value="Technical Support" @selected(old('subject') == 'Technical Support')>Technical Support
                                    </option>
                                    <option value="Feedback" @selected(old('subject') == 'Feedback')>Feedback</option>
                                    <option value="Partnership" @selected(old('subject') == 'Partnership')>Partnership</option>
                                </select>
                                @error('subject')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Your Message *</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" rows="5"
                                    placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                                @error('g-recaptcha-response')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-submit py-3">
                                    <span class="submit-text">Send Message</span>
                                    <span class="spinner-border spinner-border-sm d-none" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contact-info">
                        <h3 class="mb-4">Contact Information</h3>

                        <div class="d-flex align-items-start mb-4">
                            <i class="fas fa-map-marker-alt contact-icon"></i>
                            <div>
                                <h5 class="mb-1">Our Office</h5>
                                <p class="mb-0">10 Talaat Harb Square, Cairo City</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <i class="fas fa-envelope contact-icon"></i>
                            <div>
                                <h5 class="mb-1">Email Us</h5>
                                <p class="mb-0">healthifyme@healthifyme.com</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <i class="fas fa-phone-alt contact-icon"></i>
                            <div>
                                <h5 class="mb-1">Call Us</h5>
                                <p class="mb-0">+20 1141669674</p>
                                <p class="mb-0">Sun-Thu: 9am-5pm</p>
                            </div>
                        </div>

                        <div class="mt-4 rounded overflow-hidden">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55251.33663471533!2d31.217264582635075!3d30.059556316973204!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583fa60b21beeb%3A0x79dfb296e8423bba!2sCairo%2C%20Cairo%20Governorate%2C%20Egypt!5e0!3m2!1sen!2sus!4v1746015458104!5m2!1sen!2sus"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        {{-- <hr class="my-4">

                        <h5 class="mb-3">Follow Us</h5>
                        <div class="d-flex gap-3">
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        $(document).ready(function() {
            // Form Validation
            $("#contactForm").validate({
                errorClass: "error",
                validClass: "is-valid",
                errorElement: "div",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                    $(element).closest('.form-control, .form-select').addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                    $(element).closest('.form-control, .form-select').removeClass('is-invalid');
                },
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100
                    },
                    subject: {
                        required: true
                    },
                    message: {
                        required: true,
                        minlength: 10,
                        maxlength: 1000
                    },
                    'g-recaptcha-response': {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your full name",
                        minlength: "Name must be at least 3 characters",
                        maxlength: "Name cannot exceed 50 characters"
                    },
                    email: {
                        required: "Please enter your email address",
                        email: "Please enter a valid email address",
                        maxlength: "Email cannot exceed 100 characters"
                    },
                    subject: {
                        required: "Please select a subject"
                    },
                    message: {
                        required: "Please enter your message",
                        minlength: "Message must be at least 10 characters",
                        maxlength: "Message cannot exceed 1000 characters"
                    },
                    'g-recaptcha-response': {
                        required: "Please complete the reCAPTCHA verification"
                    }
                },
                submitHandler: function(form) {
                    // Show loading state
                    const submitBtn = $(form).find('button[type="submit"]');
                    const submitText = submitBtn.find('.submit-text');
                    const spinner = submitBtn.find('.spinner-border');

                    submitText.addClass('d-none');
                    spinner.removeClass('d-none');
                    submitBtn.prop('disabled', true);

                    // Submit form
                    form.submit();
                }
            });

            // Prevent form resubmission on page refresh
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        });
    </script>
@endsection

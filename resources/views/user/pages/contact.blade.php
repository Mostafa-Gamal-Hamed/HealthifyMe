@extends('user.layout')

@section('meta')
    <meta name="keywords"
        content="contact HealthifyMe, get in touch, support, feedback, questions, health support, customer service">
    <meta name="description"
        content="Have questions, feedback, or suggestions? Reach out to HealthifyMe — we’d love to hear from you. Contact our support or team today.">
@endsection

@section('title')
    Contact us | HealthifyMe
@endsection

@section('style')
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
@endsection

@section('body')
    {{-- Message --}}
    @include('message')

    {{-- Contact us --}}
    <div id="contact" class="contact mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="titlepage">
                        <h2>Contact <strong class="llow">us</strong></h2>
                    </div>
                </div>
            </div>

            <div class="white_color rounded">
                <form action="{{ route('contact.store') }}" method="post" id="myForm" novalidate>
                    @csrf
                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            id="name" value="{{ old('name') }}" placeholder="Your name" required minlength="3">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            id="email" value="{{ old('email') }}" placeholder="Your email" required>
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Subject --}}
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            id="subject" value="{{ old('subject') }}" placeholder="Subject" required>
                        @error('subject')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Message --}}
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="message" rows="3"
                            placeholder="Your message" required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success rounded fs-5 px-4">Send</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#myForm").validate({
                highlight: function(element) {
                    $(element).css("border", "2px solid red");
                },
                unhighlight: function(element) {
                    $(element).css("border", "");
                },
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    age: {
                        required: true,
                        digits: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        minlength: "Name must be at least 3 characters long"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email"
                    },
                    subject: {
                        required: "Please enter the subject",
                    },
                    message: {
                        required: "Please enter the message",
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@endsection

@extends('admin.layout')

@section('firstName')
    Add Admin
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">Add new admin</h2>

        {{-- Message --}}
        @include('admin.success')

        <div class="shadow shadow-lg bg-light text-dark p-3 mb-5">
            <div class="row justify-content-center">
                <div class="col">
                    <form action="{{ route('admin.admin.store') }}" method="post">
                        @csrf
                        {{-- First name --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="firstName"
                                class="form-control @error('firstName') is-invalid @enderror" id="firstName"
                                value="{{ old('firstName') }}" placeholder="First name">
                            <label for="firstName">First name</label>
                            @error('firstName')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Last name --}}
                        <div class="form-floating mb-3">
                            <input type="text" name="lastName"
                                class="form-control @error('lastName') is-invalid @enderror" id="lastName"
                                value="{{ old('lastName') }}" placeholder="Last name">
                            <label for="lastName">Last name</label>
                            @error('lastName')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email') }}" placeholder="Email">
                            <label for="email">Email</label>
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <select class="form-select form-select @error('role') is-invalid @enderror" name="role" id="role">
                                <option hidden>Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="superAdmin">Super admin</option>
                            </select>
                            @error('role')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Password --}}
                        <div class="form-floating mb-3">
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" id="password"
                                value="{{ old('password') }}" placeholder="Password">
                            <label for="password">Password</label>
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm password --}}
                        <div class="form-floating mb-3">
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" value="{{ old('password_confirmation') }}"
                                placeholder="Confirm password">
                            <label for="password">Confirm password</label>
                            @error('password_confirmation')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md px-5 btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.6.1/tinymce.min.js"
        integrity="sha512-bib7srucEhHYYWglYvGY+EQb0JAAW0qSOXpkPTMgCgW8eLtswHA/K4TKyD4+FiXcRHcy8z7boYxk0HTACCTFMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        tinymce.init({
            selector: '#desc',
            plugins: 'autoresize link image lists table code fullscreen',
            toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | forecolor backcolor removeformat | table media | lineheight outdent indent | charmap emoticons | code fullscreen preview | pagebreak anchor codesample | ltr rtl",
            height: 200,
            menubar: false,
            toolbar_sticky: true,
            branding: false,
            content_style: 'body { font-family:Arial, sans-serif; font-size:14px; }',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            },
        });
    </script>
@endsection

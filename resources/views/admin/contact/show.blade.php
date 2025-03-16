@extends('admin.layout')

@section('title')
    {{ $message->subject }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $message->email }}</h2>

        {{-- Message --}}
        @include("message")

        <div class="shadow shadow-xl text-dark p-3 mb-5" style="background-color: #eeeeee;">
            <div class="text-center overflow-auto">
                {{-- Name --}}
                <div class="mb-3">
                    <p>Name</p>
                    <h4 class="w-50 m-auto p-2 rounded" style="background-color: white;">{{ $message->name }}</h4>
                </div>
                {{-- Email --}}
                <div class="mb-3">
                    <p>Email</p>
                    <h4 class="w-auto m-auto p-2 rounded" style="background-color: white;">{{ $message->email }}</h4>
                </div>
                {{-- Subject --}}
                <div class="mb-3">
                    <p>Subject</p>
                    <h4 class="w-50 m-auto p-2 rounded" style="background-color: white;">{{ $message->subject }}</h4>
                </div>
                {{-- Message --}}
                <div class="mb-3">
                    <p>Message</p>
                    <h4 class="p-2 rounded" style="background-color:white;">{{ $message->message }}</h4>
                </div>
            </div>
            <hr>
            <div class="d-flex">
                <div class="col">
                    <a href="#" class="btn btn-md btn-success w-75" id="reply" title="Replay message">
                        <i class="fa-solid fa-reply"></i>
                    </a>
                </div>
                <form action="{{ route('admin.contact.secondDelete', $message->id) }}" method="POST" class="col">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md w-75" onclick="return confirm('Are you sure?');"
                        title="Delete message">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        <hr>

        {{-- Sent message --}}
        <div class="shadow shadow-xl text-dark p-3 mb-5 text-center" id="sentMessage" style="background-color: #eeeeee; display: none;">
            <h2 class="mb-3">Sent message</h2>
            <form action="{{ route('admin.sentMessage.store') }}" method="post">
                @csrf
                {{-- Email --}}
                <div class="input-group mb-3">
                    <span class="input-group-text" id="email">To</span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ $message->email }}" aria-describedby="email">
                </div>
                @error('email')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                {{-- Message --}}
                <div class="input-group mb-3">
                    <span class="input-group-text">Message</span>
                    <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" aria-label="message"></textarea>
                </div>
                @error('message')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn btn-primary px-5">Send</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Sent message
            $('#reply').click(function (e) {
                e.preventDefault();
                $('#sentMessage').toggle(500);
            });
        });
    </script>
@endsection
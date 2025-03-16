@extends('admin.layout')

@section('title')
    {{ $message->subject }}
@endsection

@section('body')
    <div class="container-fluid mb-5">
        <h2 class="text-center text-success fw-bold mt-3 mb-3">{{ $message->email }}</h2>

        {{-- Message --}}
        @include('message')

        {{-- Contact message --}}
        <div class="shadow shadow-xl text-dark p-3 mb-5" style="background-color: #eeeeee;">
            <div class="text-center overflow-auto">
                <h2 class="text-center">Contact message</h2>
                {{-- User name --}}
                <div class="mb-3">
                    <p>User name</p>
                    <h4 class="w-50 m-auto p-2 rounded" style="background-color: white;">
                        {{ $message->contact->name }}
                    </h4>
                </div>
                {{-- User message --}}
                <div class="mb-3">
                    <p>User subject</p>
                    <h4 class="w-50 m-auto p-2 rounded" style="background-color: white;">
                        {{ $message->contact->subject }}
                    </h4>
                </div>
                {{-- User message --}}
                <div class="mb-3">
                    <p>User message</p>
                    <h4 class="w-50 m-auto p-2 rounded" style="background-color: white;">
                        {{ $message->contact->message }}
                    </h4>
                </div>
            </div>
        </div>

        {{-- Replay message --}}
        <div class="shadow shadow-xl text-dark p-3 mb-5" style="background-color: #eeeeee;">
            <div class="text-center overflow-auto">
                <h2 class="text-center text-primary">Replay message</h2>
                {{-- Name --}}
                <div class="mb-3">
                    <p>Sender Name</p>
                    <h4 class="w-50 m-auto p-2 rounded" style="background-color: white;">
                        {{ $message->user->firstName }} {{ $message->user->lastName }}
                    </h4>
                </div>
                {{-- Email --}}
                <div class="mb-3">
                    <p>To</p>
                    <h4 class="w-auto m-auto p-2 rounded" style="background-color: white;">{{ $message->email }}</h4>
                </div>
                {{-- Message --}}
                <div class="mb-3">
                    <p>Message</p>
                    <h4 class="p-2 rounded" style="background-color:white;">{{ $message->message }}</h4>
                </div>
                <hr>

                <form action="{{ route('admin.sentMessage.secondDelete', $message->id) }}" class="text-center"
                    method="POST" class="col">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md px-5" onclick="return confirm('Are you sure?');"
                        title="Delete message">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

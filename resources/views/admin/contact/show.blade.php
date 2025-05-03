@extends('admin.layout')

@section('title', $message->subject)

@section('style')
    <style>
        .message-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .message-field {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .reply-form {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .message-content {
            white-space: pre-wrap;
            line-height: 1.6;
        }

        .action-btn {
            transition: transform 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        {{-- Message --}}
        @include("message")

        <div class="row justify-content-center">
            <div class="col-lg-8">
                {{-- Message Header --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0 text-primary">Message Details</h2>
                    <span class="badge bg-{{ $message->status == 'unread' ? 'warning text-dark' : 'secondary' }}">
                        {{ ucfirst($message->status) }}
                    </span>
                </div>

                {{-- Message Content --}}
                <div class="message-container p-4 mb-4">
                    <div class="row">
                        {{-- Sender Info --}}
                        <div class="col-md-6 mb-3">
                            <div class="message-field">
                                <h6 class="text-muted mb-2">From</h6>
                                <h4>{{ $message->name }}</h4>
                                <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                    {{ $message->email }}
                                </a>
                            </div>
                        </div>

                        {{-- Message Info --}}
                        <div class="col-md-6 mb-3">
                            <div class="message-field">
                                <h6 class="text-muted mb-2">Subject</h6>
                                <h4>{{ $message->subject }}</h4>
                                <small class="text-muted">
                                    Received: {{ $message->created_at->format('M d, Y \a\t h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Message Body --}}
                    <div class="message-field">
                        <h6 class="text-muted mb-3">Message</h6>
                        <div class="message-content">
                            {{ $message->message }}
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="d-flex justify-content-between mt-4">
                        <button id="replyBtn" class="btn btn-success action-btn">
                            <i class="fas fa-reply me-2"></i> Reply
                        </button>

                        <form action="{{ route('admin.contact.secondDelete', $message->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger action-btn"
                                onclick="return confirm('Are you sure you want to delete this message?');">
                                <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Reply Form (Hidden by default) --}}
                <div id="replyForm" class="message-container reply-form p-4" style="display: none;">
                    <h3 class="mb-4 text-center">Compose Reply</h3>

                    <form action="{{ route('admin.sentMessage.store') }}" method="post">
                        @csrf

                        {{-- Recipient Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">To</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ $message->email }}" readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Reply Message --}}
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Reply</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6"
                                placeholder="Type your reply here..."></textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Form Actions --}}
                        <div class="d-flex justify-content-between">
                            <button type="button" id="cancelReply" class="btn btn-outline-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-2"></i> Send Reply
                            </button>
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
            // Toggle reply form
            $('#replyBtn').click(function() {
                $('#replyForm').slideDown(300);
                $(this).prop('disabled', true);
                $('html, body').animate({
                    scrollTop: $('#replyForm').offset().top - 20
                }, 300);
            });

            // Cancel reply
            $('#cancelReply').click(function() {
                $('#replyForm').slideUp(300);
                $('#replyBtn').prop('disabled', false);
            });
        });
    </script>
@endsection

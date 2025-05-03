@extends('admin.layout')

@section('title', $blog->title)

@section('style')
    <style>
        .blog-detail-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .blog-image {
            max-height: 400px;
            width: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
            cursor: zoom-in;
        }

        .blog-image:hover {
            transform: scale(1.02);
        }

        .blog-meta {
            border-left: 3px solid #dee2e6;
            padding-left: 1.5rem;
        }

        .blog-content {
            white-space: pre-line;
            line-height: 1.8;
        }

        .reaction-count {
            font-size: 1.1rem;
            font-weight: 600;
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
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">{{ $blog->title }}</h1>
                    <a href="{{ route('admin.blog.blogs') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Blogs
                    </a>
                </div>

                <div class="blog-detail-container p-4 mb-5">
                    <div class="row g-4">
                        {{-- Blog Image --}}
                        <div class="col-md-6 text-center">
                            <img src="{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}"
                                class="blog-image img-fluid rounded" alt="{{ $blog->title }}" data-bs-toggle="modal"
                                data-bs-target="#imageModal"
                                data-image="{{ $blog->image ? asset("storage/$blog->image") : asset('images/modern_logo.png') }}">
                        </div>

                        {{-- Blog Details --}}
                        <div class="col-md-6 blog-meta">
                            <div class="d-flex flex-column h-100">
                                {{-- Basic Info --}}
                                <div class="mb-4">
                                    <h4 class="fw-bold mb-3">
                                        <i class="fas fa-link me-2 text-muted"></i>
                                        <span class="text-primary">{{ $blog->slug }}</span>
                                    </h4>

                                    <h5 class="fw-bold mb-3">
                                        <i class="fas fa-user me-2 text-muted"></i>
                                        Author: {{ $blog->user->firstName }} {{ $blog->user->lastName }}
                                    </h5>

                                    <div class="mb-3">
                                        <h5 class="fw-bold mb-2">
                                            <i class="fas fa-align-left me-2 text-muted"></i>Description:
                                        </h5>
                                        <div class="blog-content p-3 bg-white rounded">
                                            {!! $blog->desc !!}
                                        </div>
                                    </div>
                                </div>

                                {{-- Stats and Actions --}}
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="reaction-count text-primary">
                                            <i class="fas fa-thumbs-up me-1"></i> {{ count($likes) }} Likes
                                        </span>
                                        <span class="reaction-count text-danger">
                                            <i class="fas fa-thumbs-down me-1"></i> {{ count($disLikes) }} Dislikes
                                        </span>
                                    </div>

                                    <div class="text-muted text-end mb-3">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Created: {{ $blog->created_at->format('M d, Y') }}
                                        ({{ $blog->created_at->diffForHumans() }})
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.blog.edit', $blog->id) }}"
                                            class="btn btn-success action-btn px-4" title="Edit Blog Post">
                                            <i class="fas fa-edit me-2"></i> Edit
                                        </a>

                                        <form action="{{ route('admin.blog.secondDelete', $blog->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger action-btn px-4"
                                                onclick="return confirm('Are you sure you want to delete this blog post?')"
                                                title="Delete Blog Post">
                                                <i class="fas fa-trash-alt me-2"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center p-0">
                    <img id="modalImage" src="" class="img-fluid" alt="Blog Image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize image modal
            const imageModal = document.getElementById('imageModal');
            if (imageModal) {
                imageModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const imageUrl = button.getAttribute('data-image');
                    const modalImage = document.getElementById('modalImage');
                    modalImage.src = imageUrl;
                });
            }
        });
    </script>
@endsection

@extends('admin.layout')

@section('title', $recipe->title)

@section('style')
    <style>
        .recipe-detail-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .media-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-item:hover {
            transform: translateY(-5px);
        }

        .gallery-item img,
        .gallery-item video {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.3);
        }

        .video-overlay i {
            font-size: 3rem;
            color: white;
        }

        .recipe-description {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .recipe-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 text-success fw-bold mb-0">{{ $recipe->title }}</h2>
                    <a href="{{ route('admin.recipe.recipes') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Recipes
                    </a>
                </div>

                <div class="recipe-detail-container p-4 mb-5">
                    {{-- Media Gallery --}}
                    <div class="media-gallery">
                        {{-- Images --}}
                        @if ($recipe->images && count(json_decode($recipe->images)))
                            @foreach (json_decode($recipe->images) as $image)
                                <div class="gallery-item">
                                    <img src="{{ asset('storage/' . $image) }}"
                                        alt="{{ $recipe->title }} Image {{ $loop->iteration }}" data-bs-toggle="modal"
                                        data-bs-target="#imageModal{{ $loop->index }}">
                                </div>

                                <!-- Image Modal -->
                                <div class="modal fade" id="imageModal{{ $loop->index }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-0">
                                                <img src="{{ asset('storage/' . $image) }}" class="img-fluid"
                                                    alt="{{ $recipe->title }} Image {{ $loop->iteration }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="gallery-item">
                                <img src="{{ asset('images/recipes/recipe.png') }}" alt="Default Recipe Image">
                            </div>
                        @endif

                        {{-- Video --}}
                        <div class="gallery-item">
                            @if ($recipe->video)
                                <video controls>
                                    <source src="{{ asset('storage/' . $recipe->video) }}" type="video/mp4">
                                </video>
                            @else
                                <div class="video-overlay">
                                    <i class="fas fa-video-slash"></i>
                                </div>
                                <img src="{{ asset('images/recipes/video.png') }}" alt="Default Video Placeholder">
                            @endif
                        </div>
                    </div>

                    {{-- Recipe Details --}}
                    <div class="recipe-description">
                        <h4 class="h5 fw-bold mb-3">Description</h4>
                        <div class="recipe-content">
                            {!! $recipe->description !!}
                        </div>
                    </div>

                    <div class="recipe-meta">
                        <div class="nutrition-info">
                            <span class="badge bg-success p-2">
                                <i class="fas fa-fire me-1"></i> {{ $recipe->calories }} Calories
                            </span>
                        </div>
                        <div class="author-info">
                            <span class="text-muted me-2">Created by:</span>
                            <a href="{{ route('admin.user.show', $recipe->user->id) }}" class="text-decoration-none">
                                {{ $recipe->user->firstName }} {{ $recipe->user->lastName }}
                            </a>
                        </div>
                        <div class="date-info">
                            <span class="text-muted">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ $recipe->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="action-buttons">
                        <a href="{{ route('admin.recipe.edit', $recipe->id) }}" class="btn btn-success "
                            title="Edit Recipe">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>

                        <form action="{{ route('admin.recipe.secondDelete', $recipe->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger " title="Delete Recipe"
                                onclick="return confirm('Are you sure you want to delete this recipe?')">
                                <i class="fas fa-trash-alt me-2"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Initialize any tooltips
        $(function() {
            $('[title]').tooltip();
        });
    </script>
@endsection

{{-- Success message --}}
@if (session()->get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h6 class="text-center"><i class="fas fa-check"></i> {{ session()->get('success') }}</h6>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

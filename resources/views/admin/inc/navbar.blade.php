@php
    $messages = App\Models\Contact::where('status', 'unread')->count();
    $unread = App\Models\Contact::where('status', 'unread')->latest()->take(5)->get();
    $notiCount = App\Models\AskForDiet::count();
    $notifications = App\Models\AskForDiet::latest()->take(5)->get();
@endphp

<div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand navbar-light sticky-top px-4 py-0" style="background-color: #191C24;">
        <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
            <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
        </a>
        <a href="#" class="sidebar-toggler flex-shrink-0">
            <i class="fa fa-bars"></i>
        </a>
        <form class="d-none d-md-flex ms-4">
            <input class="form-control border-0" type="search" placeholder="Search">
        </form>
        <div class="navbar-nav align-items-center ms-auto">
            {{-- Messages --}}
            <div class="nav-item dropdown">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <i class="fa fa-envelope me-lg-2 text-light"></i>
                    <span class="fw-bold text-warning">{{ $messages ? $messages : '' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                    @foreach ($unread as $message)
                        <a href="{{ route('admin.contact.show', $message->id) }}" class="dropdown-item mb-2">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle" src="{{ asset('images/users/avatar.png') }}" alt=""
                                    style="width: 40px; height: 40px;">
                                <div class="ms-2">
                                    <h6 class="fw-normal mb-0">{{ $message->name }} send you a message</h6>
                                    <small>{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                        <hr class="dropdown-divider">
                    @endforeach
                    <a href="{{ route('admin.contact.contacts') }}" class="nav-link text-dark text-center">See all
                        message</a>
                </div>
            </div>
            {{-- Notifications --}}
            <div class="nav-item dropdown">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <i class="fa fa-bell me-lg-2 text-light"></i>
                    <span class="fw-bold text-warning">{{ $notiCount ? $notiCount : '' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                    @foreach ($notifications as $notification)
                        <a href="{{ route('admin.user.show', $notification->user->id) }}" class="dropdown-item">
                            <h6 class="fw-normal mb-0">{{ $notification->user->firstName }}</h6>
                            <span
                                class="fw-normal mb-0 badge bg-{{ $notification->ask === 'ask' ? 'primary' : 'warning text-dark' }}">
                                {{ ucfirst($notification->ask) }}
                                {{ $notification->ask === 'ask' ? 'activation' : 'diet' }}
                            </span><br>
                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                        </a>
                        <hr class="dropdown-divider">
                    @endforeach
                    <a href="{{ route('admin.dietRequests.diets') }}" class="dropdown-item text-center">See all
                        notifications</a>
                </div>
            </div>
            {{-- Account --}}
            <div class="nav-item dropdown">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="{{ asset('images/users/avatar.png') }}" alt=""
                        style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex text-light">{{ Auth::user()->firstName }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0"
                    style="background-color: #191C24;">
                    <a href="{{ route('dashboard') }}"
                        class="dropdown-item d-flex align-items-center gap-2 accountNav">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="{{ route('profile.edit') }}"
                        class="dropdown-item d-flex align-items-center gap-2 accountNav">
                        <i class="fas fa-user-cog"></i> Profile Settings
                    </a>

                    <div class="dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 accountNav">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    <!-- Content Start -->
    <div class="container position-relative bg-white p-3 m-0 mb-5">

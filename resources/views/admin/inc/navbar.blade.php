@php
    $messages = App\Models\Contact::where('status', 'unread')->count();
    $unread   = App\Models\Contact::where('status', 'unread')->latest()->take(5)->get();
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
            <div class="nav-item dropdown">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <i class="fa fa-envelope me-lg-2 text-light"></i>
                    <span class="d-none d-lg-inline-flex text-light">
                        Message
                    </span>
                    <span class="fw-bold text-warning">{{ $messages ? $messages : '' }}</span>
                    </a>
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                    @foreach ($unread as $message)
                        <a href="{{ route('admin.contact.show', $message->id) }}" class="dropdown-item mb-2" style="border-bottom: solid #b6b6b6;">
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle" src="{{ asset("images/users/avatar.png") }}" alt="" style="width: 40px; height: 40px;">
                                <div class="ms-2">
                                    <h6 class="fw-normal mb-0">{{ $message->name }} send you a message</h6>
                                    <small>{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                    @endforeach
                    <hr class="dropdown-divider">
                    <a href="{{ route('admin.contact.contacts') }}" class="nav-link text-dark text-center">See all message</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <i class="fa fa-bell me-lg-2 text-light"></i>
                    <span class="d-none d-lg-inline-flex text-light">Notificatin</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">
                        <h6 class="fw-normal mb-0">Profile updated</h6>
                        <small>15 minutes ago</small>
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item">
                        <h6 class="fw-normal mb-0">New user added</h6>
                        <small>15 minutes ago</small>
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item">
                        <h6 class="fw-normal mb-0">Password changed</h6>
                        <small>15 minutes ago</small>
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item text-center">See all notifications</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <img class="rounded-circle me-lg-2" src="{{ asset("images/users/avatar.png") }}" alt="" style="width: 40px; height: 40px;">
                    <span class="d-none d-lg-inline-flex text-light">{{ Auth::user()->firstName }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end border-0 rounded-0 rounded-bottom m-0" style="background-color: #191C24;">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item text-light">My Profile</a>
                    <a href="#" class="dropdown-item text-light">Settings</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item text-light">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
<!-- Content Start -->
<div class="container position-relative bg-white p-3 m-0 mb-5">
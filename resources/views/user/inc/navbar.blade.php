<nav class="navbar navbar-expand-sm navbar-dark px-5" style="background-color: #ececf0;">
    <a class="navbar-brand text-dark fw-medium" href="/"><strong>HealthifyMe</strong></a>
    <button class="navbar-toggler d-lg-none bg-dark" type="button" data-bs-toggle="collapse"
        data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
        aria-label="Toggle navigation"><span class="navbar-toggler-icon" style="width: 1rem;"></span></button>
    <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavId">
        <ul class="navbar-nav mt-2 mt-lg-0 gap-3">
            <li class="nav-item">
                <a class="nav-link fs-6 text-dark fw-medium {{ request()->is('/') || request()->is('home') ? 'active' : '' }}"
                    aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6 text-dark fw-medium {{ request()->is('about') ? 'active' : '' }}"
                    aria-current="page" href="{{ url('about') }}">About us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link fs-6 text-dark fw-medium {{ request()->is('blog') ? 'active' : '' }}"
                    aria-current="page" href="{{ route('blog.blogs') }}">Blogs</a>
            </li>
            <div class="dropdown nav-link fs-6 text-dark fw-medium {{ request()->is('food') ? 'active' : '' }}">
                <a class="nav-item dropdown-toggle food" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Food
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('food.foods', 'Fruit') }}" class="dropdown-item">
                            Fruits
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('food.foods', 'Vegetable') }}" class="dropdown-item">
                            Vegetables
                        </a>
                    </li>
                    <hr class="m-0 mt-2">
                    <li>
                        <a href="{{ route('food.foods', 'Vegetable') }}" class="dropdown-item">
                            See All
                        </a>
                    </li>
                </ul>
            </div>
            <li class="nav-item">
                <a class="nav-link fs-6 text-dark fw-medium {{ request()->is('contact') ? 'active' : '' }}"
                    aria-current="page" href="{{ route('contact.create') }}">Contact us</a>
            </li>
            @guest
                <li class="nav-item">
                    <a class="nav-link fs-6 text-dark fw-medium" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-6 text-dark fw-medium" href="{{ route('register') }}">Sign up</a>
                </li>
            @endguest
            @auth
                <div class="dropdown">
                    <button class="nav-link text-dark fs-6 fw-medium dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Account
                    </button>
                    <ul class="dropdown-menu text-center">
                        <li class="nav-item">
                            <a class="nav-link text-dark fw-medium {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="nav-link text-dark fw-medium" href="{{ route('profile.edit') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="nav-link text-dark fw-medium m-auto">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
        </ul>
    </div>
</nav>

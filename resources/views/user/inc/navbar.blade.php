@php
    use App\Models\Category;
    use App\Models\RecipeCategory;

    $foodCategory   = Category::latest()->get();
    $recipeCategory = RecipeCategory::latest()->get();
@endphp
<nav class="navbar navbar-expand-lg navbar-light bg-light px-3 px-md-5 py-3">
    <div class="container-fluid">
        <!-- Brand Logo -->
        <a class="navbar-brand text-dark fw-bold" href="/">
            <span style="color: #4CAF50;">Healthify</span><span style="color: #2196F3;">Me</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav align-items-center gap-2 gap-lg-3">
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : 'fw-medium' }}"
                        href="{{ url('/') }}">
                        Home
                    </a>
                </li>

                <!-- About -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active fw-bold' : 'fw-medium' }}"
                        href="{{ url('about') }}">
                        About Us
                    </a>
                </li>

                <!-- Blogs -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('blog*') ? 'active fw-bold' : 'fw-medium' }}"
                        href="{{ route('blog.blogs') }}">
                        Blogs
                    </a>
                </li>

                <!-- Diets -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('diet*') ? 'active fw-bold' : 'fw-medium' }}"
                        href="{{ route('diet.diets') }}">
                        Diets
                    </a>
                </li>

                <!-- Healthy Recipes Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('healthy-recipes*') ? 'active fw-bold' : 'fw-medium' }}"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Healthy Recipes
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($recipeCategory as $category)
                            <li><a class="dropdown-item" href="{{ route('healthy-recipe.category', $category->name) }}">{{ $category->name }}</a></li>
                        @endforeach
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('healthy-recipe.recipes') }}">See All Recipes</a>
                        </li>
                    </ul>
                </li>

                <!-- Food Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->is('food*') ? 'active fw-bold' : 'fw-medium' }}"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Food
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach ($foodCategory as $category)
                            <li><a class="dropdown-item" href="{{ route('food.type', "$category->name") }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </li>

                <!-- Contact -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact*') ? 'active fw-bold' : 'fw-medium' }}"
                        href="{{ route('contact.create') }}">
                        Contact Us
                    </a>
                </li>

                <!-- Auth Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success px-3 py-1" href="{{ route('login') }}">
                            Log in
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-success px-3 py-1" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                    href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}"
                                    href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

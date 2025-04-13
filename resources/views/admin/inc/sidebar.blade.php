<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('images/users/avatar.png') }}" alt=""
                    style="width: 40px; height: 40px;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->firstName }}</h6>
                <span class="text-light">{{ Auth::user()->role }}</span>
            </div>
        </div>

        <div class="navbar-nav w-100">
            <a href="{{ url('/') }}"
                class="nav-item nav-link {{ request()->is('/') || request()->is('home') ? 'text-dark active' : '' }}">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            {{-- Users --}}
            <div class="nav-item dropdown mt-2">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.user.users') || request()->routeIs('admin.dietRequests.diets') ? 'text-dark active show' : '' }}"
                    data-bs-toggle="dropdown">
                    <i class="fa fa-users me-2"></i> Users
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.user.users') || request()->routeIs('admin.user.show')
                    || request()->routeIs('admin.dietRequests.diets') || request()->routeIs('admin.dietRequests.show') ? 'show' : '' }}">
                    <a href="{{ route('admin.user.users') }}"
                        class="dropdown-item {{ request()->routeIs('admin.user.users') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-list text-info"></i> All users</a>
                    <a href="{{ route('admin.dietRequests.diets') }}"
                        class="dropdown-item {{ request()->routeIs('admin.dietRequests.diets') ? 'active' : '' }}">
                        <i class="fa-solid fa-hand-point-up text-danger"></i> Diet requests</a>
                </div>
            </div>

            {{-- Diets --}}
            <div class="nav-item dropdown mt-2">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-plate-wheat"></i> Diets
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.diet.diets') ||
                    request()->routeIs('admin.specialDiet.specialDiets') ||
                    request()->routeIs('admin.diet.create') ||
                    request()->routeIs('admin.diet.edit')
                        ? 'show'
                        : '' }}">

                    <a href="{{ route('admin.diet.diets') }}"
                        class="dropdown-item {{ request()->routeIs('admin.diet.diets') ? 'active' : '' }}"><i
                            class="fa-solid fa-table-list text-info"></i> All diets</a>
                    <a href="{{ route('admin.specialDiet.specialDiets') }}"
                        class="dropdown-item {{ request()->routeIs('admin.specialDiet.specialDiets') ? 'active' : '' }}"><i
                            class="fa-regular fa-star text-danger"></i> All special diets</a>
                    <a href="{{ route('admin.diet.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin.diet.create') ? 'active' : '' }}"><i
                            class="fa-solid fa-plus text-warning"></i> Add new diet</a>

                </div>
            </div>

            {{-- Blogs --}}
            <div class="nav-item dropdown mt-2">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.blog.blogs') || request()->routeIs('admin.blog.create') ? 'text-dark active show' : '' }}"
                    data-bs-toggle="dropdown">
                    <i class="fa-solid fa-blog"></i> Blogs
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.blog.blogs') || request()->routeIs('admin.blog.create') ? 'show' : '' }}">
                    <a href="{{ route('admin.blog.blogs') }}"
                        class="dropdown-item {{ request()->routeIs('admin.blog.blogs') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-list text-info"></i> All blogs
                    </a>
                    <a href="{{ route('admin.blog.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin.blog.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-plus text-warning"></i> Add new blog
                    </a>
                </div>
            </div>

            {{-- Food categories --}}
            <div class="nav-item dropdown mt-2">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.category.categories') || request()->routeIs('admin.category.create') || request()->routeIs('admin.category.show') ? 'text-dark active show' : '' }}"
                    data-bs-toggle="dropdown">
                    <i class="fa-solid fa-list"></i> Food categories
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.category.categories') || request()->routeIs('admin.category.edit') || request()->routeIs('admin.category.show') ? 'show' : '' }}">
                    <a href="{{ route('admin.category.categories') }}"
                        class="dropdown-item {{ request()->routeIs('admin.category.categories') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-list text-info"></i> All Categories
                    </a>
                </div>
            </div>

            {{-- Food --}}
            <div class="nav-item dropdown mt-2">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.food.foods') || request()->routeIs('admin.food.create') ? 'text-dark active show' : '' }}"
                    data-bs-toggle="dropdown">
                    <i class="fa-solid fa-utensils"></i> Food
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.food.foods') || request()->routeIs('admin.food.create') ? 'show' : '' }}">
                    <a href="{{ route('admin.food.foods') }}"
                        class="dropdown-item {{ request()->routeIs('admin.food.foods') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-list text-info"></i> All foods
                    </a>
                    <a href="{{ route('admin.food.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin.food.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-plus text-warning"></i> Add new food
                    </a>
                </div>
            </div>

            {{-- Recipe categories --}}
            <div class="nav-item dropdown mt-2">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.recipeCategory.categories') ||
                    request()->routeIs('admin.recipeCategory.create') || request()->routeIs('admin.recipeCategory.show') ? 'text-dark active show' : '' }}"
                    data-bs-toggle="dropdown">
                    <i class="fa-solid fa-list"></i> Recipe categories
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.recipeCategory.categories') ||
                    request()->routeIs('admin.recipeCategory.edit') || request()->routeIs('admin.recipeCategory.show') ? 'show' : '' }}">
                    <a href="{{ route('admin.recipeCategory.categories') }}"
                        class="dropdown-item {{ request()->routeIs('admin.recipeCategory.categories') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-list text-info"></i> All Categories
                    </a>
                </div>
            </div>

            {{-- Recipes --}}
            <div class="nav-item dropdown mt-2">
                <a href="#" class="nav-link" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-utensils"></i> Recipes
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.recipe.recipes') ||
                    request()->routeIs('admin.recipe.create') || request()->routeIs('admin.recipe.edit')
                        ? 'show'
                        : '' }}">
                    <a href="{{ route('admin.recipe.recipes') }}"
                        class="dropdown-item {{ request()->routeIs('admin.recipe.recipes') ? 'active' : '' }}">
                        <i class="fa-solid fa-wheat-awn-circle-exclamation text-info"></i> All Recipes</a>
                    <a href="{{ route('admin.recipe.create') }}"
                        class="dropdown-item {{ request()->routeIs('admin.recipe.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-plus text-warning"></i> Add new recipe</a>
                </div>
            </div>

            {{-- Contact --}}
            <div class="nav-item dropdown mt-2">
                <a href="#"
                    class="nav-link {{ request()->routeIs('admin.contact.contacts') ||
                    request()->routeIs('admin.contact.show') ||
                    request()->routeIs('admin.sentMessage.sentMessages')
                        ? 'text-dark active show'
                        : '' }}"
                    data-bs-toggle="dropdown">
                    <i class="fa fa-message me-2"></i> Messages
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 {{ request()->routeIs('admin.contact.contacts') ||
                    request()->routeIs('admin.contact.show') ||
                    request()->routeIs('admin.sentMessage.sentMessages') ||
                    request()->routeIs('admin.sentMessage.show')
                        ? 'show'
                        : '' }}">

                    <a href="{{ route('admin.contact.contacts') }}"
                        class="dropdown-item {{ request()->routeIs('admin.contact.contacts') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-list text-info"></i> All messages
                    </a>
                    <a href="{{ route('admin.sentMessage.sentMessages') }}"
                        class="dropdown-item {{ request()->routeIs('admin.sentMessage.sentMessages') ? 'active' : '' }}">
                        <i class="fa-solid fa-paper-plane text-info"></i> Sent
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->

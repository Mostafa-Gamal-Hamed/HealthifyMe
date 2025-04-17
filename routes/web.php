<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AskForDietController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DietController;
use App\Http\Controllers\Admin\DietRequestController;
use App\Http\Controllers\Admin\FoodController as AdminFoodController;
use App\Http\Controllers\Admin\RecipeCategoryController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Controllers\Admin\SpecialDietController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserDietsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HealthyRecipeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\superAdmin;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//// Home
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home');
    Route::get('home', 'home');
});


//// User side

// Auth
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile/edit', 'edit')->name('profile.edit');
        Route::patch('/profile/update', 'update')->name('profile.update');
        Route::patch('/profile/diet', 'dietUpdate')->name('profile.diet');
        Route::delete('/profile/destroy', 'destroy')->name('profile.destroy');
    });

    // Ask for diet
    Route::controller(AskForDietController::class)->group(function () {
        // Ask for diet
        Route::post('ask-for-diet', 'ask')->name('ask-for-diet.store');
        // Change diet
        Route::post('change-diet', 'change')->name('change-diet.store');
    });
});


// Email Verification Routes
Route::group(['middleware' => 'auth'], function () {
    // Email Verification Notice
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Email Verification Handler
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/home');
    })->middleware('signed')->name('verification.verify');

    // Resend Email Verification Notification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');
});
require __DIR__ . '/auth.php';


// Blog
Route::controller(BlogController::class)->group(function () {
    // Blogs
    Route::get('blogs', 'index')->name("blog.blogs");
    // Show
    Route::get('blog/{id}', 'show')->name("blog.show");
    // Like
    Route::post('blog/like/{id}', 'like')->name("blog.like");
    // DisLike
    Route::post('blog/disLike/{id}', 'disLike')->name("blog.disLike");
});

// Healthy recipe
Route::controller(HealthyRecipeController::class)->group(function () {
    // Healthy Recipes
    Route::get('healthy-recipes', 'index')->name("healthy-recipe.recipes");
    // Type recipe
    Route::get('healthy-recipes/{category}', 'category')->name("healthy-recipe.category");
    // Show
    Route::get('healthy-recipe/{id}', 'show')->name("healthy-recipe.show");
    // Search
    Route::get('healthy-recipe', 'search')->name("healthy-recipe.search");
});

// Food
Route::controller(FoodController::class)->group(function () {
    // All foods
    Route::get('foods', 'index')->name("food.foods");
    // Type food
    Route::get('foods/{type}', 'type')->name("food.type");
    // Show
    Route::get('food/{id}', 'show')->name("food.show");
});

// Contact us
Route::controller(ContactController::class)->group(function () {
    // Messages
    Route::get('messages', 'index')->name("contact.messages");
    // Show
    Route::get('message/{id}', 'show')->name("contact.show");
    // Create
    Route::get('contact', 'create')->name("contact.create");
    // Store
    Route::post('sendMessage', 'store')->name("contact.store");
    // Delete
    Route::delete('deleteMessage/{id}', 'destroy')->name("contact.delete");
    // Delete all
    Route::delete('deleteAllMessages', 'destroyAll')->name("contact.deleteAll");
});

// About us
Route::get('about', function () {
    return view('user.pages.about');
});

// Newsletter
Route::post('/store', [NewsletterController::class, 'store'])->name('newsletter.store');


//// Admin side
Route::middleware(IsAdmin::class)->group(function () {
    // Admin
    Route::middleware(superAdmin::class)->group(function() {
        Route::controller(AdminController::class)->group(function () {
            // All admins
            Route::get('admins', 'index')->name("admin.admin.admins");
            // Show
            Route::get('admin/{id}', 'show')->name("admin.admin.show");
            // Status
            Route::get('statusAdmin.admin.status/{type}/{id}', 'status')->name("admin.admin.status");
            // Create
            Route::get('createAdmin', 'create')->name("admin.admin.create");
            // Store
            Route::post('storeAdmin', 'store')->name("admin.admin.store");
            // Delete
            Route::delete('deleteAdmin/{id}', 'destroy')->name("admin.admin.delete");
            // Search
            Route::get('adminSearch/{search}', 'search')->name("admin.admin.search");
        });
    });

    // User
    Route::controller(UserController::class)->group(function () {
        // All users
        Route::get('users', 'index')->name("admin.user.users");
        // Show
        Route::get('user/{id}', 'show')->name("admin.user.show");
        // Status
        Route::get('status/{type}/{id}', 'status')->name("admin.user.status");
        // Delete
        Route::delete('deleteUser/{id}', 'destroy')->name("admin.user.delete");
        // Search
        Route::get('userSearch/{search}', 'search')->name("admin.user.search");
    });

    // User diets
    Route::controller(UserDietsController::class)->group(function () {
        // All diets
        Route::get('diets', 'index')->name("admin.user.diets");
        // Store diet
        Route::post('storeDiet/{id}', 'store')->name("admin.user.diet");
        // Delete diet
        Route::delete('deleteUserDiet/{id}', 'destroy')->name("admin.user.deleteDiet");
    });

    // Diet
    Route::controller(DietController::class)->group(function () {
        // All diets
        Route::get('diets', 'index')->name("admin.diet.diets");
        // Edit
        Route::get('editDiet/{id}', 'edit')->name("admin.diet.edit");
        // Update
        Route::put('updateDiet/{id}', 'update')->name("admin.diet.update");
        // Create
        Route::get('createDiet', 'create')->name("admin.diet.create");
        // Store
        Route::post('storeDiet', 'store')->name("admin.diet.store");
        // Delete
        Route::delete('deleteDiet/{id}', 'destroy')->name("admin.diet.delete");
        // Search
        Route::get('dietSearch/{search}', 'search')->name("admin.diet.search");
    });

    // Diet requests
    Route::controller(DietRequestController::class)->group(function () {
        // All diet requests
        Route::get('dietRequests', 'index')->name("admin.dietRequests.diets");
        // Show
        Route::get('dietRequest/{id}', 'show')->name("admin.dietRequests.show");
        // Delete
        Route::delete('deleteDietRequest/{id}', 'destroy')->name("admin.dietRequests.delete");
        // Search
        Route::get('dietRequestSearch/{search}', 'search')->name("admin.dietRequests.search");
    });

    // Special diet
    Route::controller(SpecialDietController::class)->group(function () {
        // All special diets
        Route::get('specialDiets', 'index')->name("admin.specialDiet.specialDiets");
        // Edit
        Route::get('editSpecialDiet/{id}', 'edit')->name("admin.specialDiet.edit");
        // Update
        Route::put('updateSpecialDiet/{id}', 'update')->name("admin.specialDiet.update");
        // Create
        Route::get('createSpecialDiet', 'create')->name("admin.specialDiet.create");
        // Store
        Route::post('storeSpecialDiet/{id}', 'store')->name("admin.specialDiet.store");
        // Delete
        Route::delete('deleteSpecialDiet/{id}', 'destroy')->name("admin.specialDiet.delete");
        // Search
        Route::get('specialDietSearch/{search}', 'search')->name("admin.specialDiet.search");
    });

    // Blogs
    Route::controller(AdminBlogController::class)->group(function () {
        // All blogs
        Route::get('adminBlogs', 'index')->name("admin.blog.blogs");
        // Show
        Route::get('showBlog/{id}', 'show')->name("admin.blog.show");
        // Edit
        Route::get('editBlog/{id}', 'edit')->name("admin.blog.edit");
        // Update
        Route::put('updateBlog/{id}', 'update')->name("admin.blog.update");
        // Create
        Route::get('createBlog', 'create')->name("admin.blog.create");
        // Store
        Route::post('storeBlog', 'store')->name("admin.blog.store");
        // Delete
        Route::delete('deleteBlog/{id}', 'destroy')->name("admin.blog.delete");
        // Second delete
        Route::delete('secondDeleteBlog/{id}', 'secondDestroy')->name("admin.blog.secondDelete");
        // Search
        Route::get('blogSearch/{search}', 'search')->name("admin.blog.search");
    });

    // Food category
    Route::controller(CategoryController::class)->group(function () {
        // All categories
        Route::get('categories', 'index')->name("admin.category.categories");
        // Show
        Route::get('showCategory/{id}', 'show')->name("admin.category.show");
        // Edit
        Route::get('editCategory/{id}', 'edit')->name("admin.category.edit");
        // Update
        Route::put('updateCategory/{id}', 'update')->name("admin.category.update");
        // Create
        Route::get('createCategory', 'create')->name("admin.category.create");
        // Store
        Route::post('storeCategory', 'store')->name("admin.category.store");
        // Delete
        Route::delete('deleteCategory/{id}', 'destroy')->name("admin.category.delete");
        // Search
        Route::get('categorySearch/{search}', 'search')->name("admin.category.search");
        // Second delete
        Route::delete('secondDeleteCategory/{id}', 'secondDestroy')->name("admin.category.secondDelete");
    });

    // Food
    Route::controller(AdminFoodController::class)->group(function () {
        // All foods
        Route::get('adminFoods', 'index')->name("admin.food.foods");
        // Show
        Route::get('showFood/{id}', 'show')->name("admin.food.show");
        // Edit
        Route::get('editFood/{id}', 'edit')->name("admin.food.edit");
        // Update
        Route::put('updateFood/{id}', 'update')->name("admin.food.update");
        // Create
        Route::get('createFood', 'create')->name("admin.food.create");
        // Store
        Route::post('storeFood', 'store')->name("admin.food.store");
        // Delete
        Route::delete('deleteFood/{id}', 'destroy')->name("admin.food.delete");
        // Second delete
        Route::delete('secondDeleteFood/{id}', 'secondDestroy')->name("admin.food.secondDelete");
        // Search
        Route::get('foodSearch/{search}', 'search')->name("admin.food.search");
    });

    // Recipe category
    Route::controller(RecipeCategoryController::class)->group(function () {
        // All categories
        Route::get('recipeCategories', 'index')->name("admin.recipeCategory.categories");
        // Show
        Route::get('show_RecipeCategory/{id}', 'show')->name("admin.recipeCategory.show");
        // Edit
        Route::get('edit_RecipeCategory/{id}', 'edit')->name("admin.recipeCategory.edit");
        // Update
        Route::put('update_RecipeCategory/{id}', 'update')->name("admin.recipeCategory.update");
        // Create
        Route::get('create_RecipeCategory', 'create')->name("admin.recipeCategory.create");
        // Store
        Route::post('store_RecipeCategory', 'store')->name("admin.recipeCategory.store");
        // Delete
        Route::delete('delete_RecipeCategory/{id}', 'destroy')->name("admin.recipeCategory.delete");
        // Search
        Route::get('recipeCategorySearch/{search}', 'search')->name("admin.recipeCategory.search");
        // Second delete
        Route::delete('secondDelete_RecipeCategory/{id}', 'secondDestroy')->name("admin.recipeCategory.secondDelete");
    });

    // Recipes
    Route::controller(RecipeController::class)->group(function () {
        // All recipes
        Route::get('recipes', 'index')->name("admin.recipe.recipes");
        // Show
        Route::get('showRecipe/{id}', 'show')->name("admin.recipe.show");
        // Edit
        Route::get('editRecipe/{id}', 'edit')->name("admin.recipe.edit");
        // Update
        Route::put('updateRecipe/{id}', 'update')->name("admin.recipe.update");
        // Create
        Route::get('createRecipe', 'create')->name("admin.recipe.create");
        // Store
        Route::post('storeRecipe', 'store')->name("admin.recipe.store");
        // Delete
        Route::delete('deleteRecipe/{id}', 'destroy')->name("admin.recipe.delete");
        // Second delete
        Route::delete('secondDeleteRecipe/{id}', 'secondDestroy')->name("admin.recipe.secondDelete");
        // Search
        Route::get('recipeSearch/{search}', 'search')->name("admin.recipe.search");
    });

    // Contact
    Route::controller(AdminContactController::class)->group(function () {
        // All contacts
        Route::get('adminContacts', 'index')->name("admin.contact.contacts");
        // Show
        Route::get('showContact/{id}', 'show')->name("admin.contact.show");
        // Delete
        Route::delete('deleteContact/{id}', 'destroy')->name("admin.contact.delete");
        // Second delete
        Route::delete('secondDeleteContact/{id}', 'secondDestroy')->name("admin.contact.secondDelete");
        // Search
        Route::get('contactSearch/{search}', 'search')->name("admin.contact.search");


        // Replay side
        // All Sent message
        Route::get('sentMessages', 'allSent')->name("admin.sentMessage.sentMessages");
        // Store
        Route::post('storeSentMessage', 'store')->name("admin.sentMessage.store");
        // Show
        Route::get('showSentMessage/{id}', 'showSentMessage')->name("admin.sentMessage.show");
        // Delete
        Route::delete('deleteSentMessage/{id}', 'destroySentMessage')->name("admin.sentMessage.delete");
        // Second delete
        Route::delete('secondDeleteSentMessage/{id}', 'secondDestroySentMessage')->name("admin.sentMessage.secondDelete");
        // Sent search
        Route::get('sentSearch/{search}', 'sentSearchMessage')->name("admin.sentMessage.search");
    });
});

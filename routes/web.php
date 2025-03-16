<?php

use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DietController;
use App\Http\Controllers\Admin\FoodController as AdminFoodController;
use App\Http\Controllers\Admin\SpecialDietController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use App\Models\Blog;
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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Email verification
Route::get('email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// The Email Verification Handler
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resending
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

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

// Food
Route::controller(FoodController::class)->group(function () {
    // Food
    Route::get('foods/{type}', 'index')->name("food.foods");
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

//// About us
Route::get('about', function () {
    return view('user.pages.about');
});




//// Admin side
Route::middleware(IsAdmin::class)->group(function () {
    // Users
    Route::controller(UserController::class)->group(function () {
        // All users
        Route::get('users', 'index')->name("admin.user.users");
        // Show
        Route::get('user/{id}', 'show')->name("admin.user.show");
        // Status
        Route::get('status/{type}/{id}', 'status')->name("admin.user.status");
        // User diet
        Route::post('userDiet', 'userDiet')->name("admin.user.diet");
        // Delete
        Route::delete('deleteUser/{id}', 'destroy')->name("admin.user.delete");
        // Search
        Route::get('userSearch/{search}', 'search')->name("admin.user.search");
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

    // Category
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

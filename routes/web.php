<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\Client\ClientCategoryController;
use App\Http\Controllers\ColorController;

// Trang Dashboard admin

// Nhóm route admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');


    // Product
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create-products', [ProductController::class, 'create'])->name('products.create');
        Route::post('/create', [ProductController::class, 'store'])->name('products.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/edit/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');
    });

    // Product Variants
    Route::resource('product-variants', ProductVariantController::class);
    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Sizes
    Route::get('/sizes', [SizeController::class, 'index'])->name('sizes.index');
    Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store');
    Route::get('/sizes/{size}', [SizeController::class, 'show'])->name('sizes.show');
    Route::get('/sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::put('/sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');
    Route::delete('/sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');


    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    //color
    Route::get('/colors', [ColorController::class, 'index'] )->name('colors.index');
    Route::get('/colors/create', [ColorController::class, 'create'] )->name('colors.create');
    Route::post('/colors', [ColorController::class, 'store'] )->name('colors.store');
    Route::get('/colors/{id}/edit', [ColorController::class, 'edit'] )->name('colors.edit');
    Route::put('/colors/{id}', [ColorController::class, 'update'] )->name('colors.update');
    Route::delete('/colors/{id}', [ColorController::class, 'destroy'] )->name('colors.destroy');
    Route::get('/colors/delete', [ColorController::class, 'delete'])->name('colors.delete');
    Route::delete('/colors/eliminate/{id}', [ColorController::class, 'eliminate'])->name('colors.eliminate');
    Route::delete('/colors/all-eliminate', [ColorController::class, 'forceDeleteAll'])->name('colors.all-eliminate');
    Route::get('/colors/restore/{id}', [ColorController::class, 'restore'])->name('colors.restore');
});
    




// Trang client (không nằm trong admin)
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/contact', function () {
    return view('clients.contact');
})->name('contact');;

Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])->name('client.categories.show');

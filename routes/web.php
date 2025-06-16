<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\ProductVariantController;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

use App\Http\Controllers\Client\ClientCategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Client\BlogController as ClientBlogController;


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
    Route::get('/colors', [ColorController::class, 'index'])->name('colors.index');
    Route::get('/colors/create', [ColorController::class, 'create'])->name('colors.create');
    Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
    Route::get('/colors/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit');
    Route::put('/colors/{id}', [ColorController::class, 'update'])->name('colors.update');
    Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');
    Route::get('/colors', [ColorController::class, 'index'])->name('colors.index');
    Route::get('/colors/create', [ColorController::class, 'create'])->name('colors.create');
    Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
    Route::get('/colors/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit');
    Route::put('/colors/{id}', [ColorController::class, 'update'])->name('colors.update');
    Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');
    Route::get('/colors/delete', [ColorController::class, 'delete'])->name('colors.delete');
    Route::delete('/colors/all-eliminate', [ColorController::class, 'forceDeleteAll'])->name('colors.all-eliminate');
    Route::delete('/colors/eliminate/{id}', [ColorController::class, 'eliminate'])->name('colors.eliminate');
    Route::get('/colors/restore/{id}', [ColorController::class, 'restore'])->name('colors.restore');

    //brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::get('/brands/delete', [BrandController::class, 'delete'])->name('brands.delete');
    Route::delete('/brands/eliminate/{id}', [BrandController::class, 'eliminate'])->name('brands.eliminate');
    Route::delete('/brands/all-eliminate', [BrandController::class, 'forceDeleteAll'])->name('brands.all-eliminate');
    Route::get('/brands/restore/{id}', [BrandController::class, 'restore'])->name('brands.restore');

    //Blog
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/delete', [BlogController::class, 'delete'])->name('blogs.delete');
    Route::get('/blogs/restore/{id}', [BlogController::class, 'restore'])->name('blogs.restore');
    Route::delete('/blogs/eliminate/{id}', [BlogController::class, 'eliminate'])->name('blogs.eliminate');
    Route::delete('/blogs/all-eliminate', [BlogController::class, 'forceDeleteAll'])->name('blogs.all-eliminate');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    Route::get('/blogs/{blog}', [BlogController::class, 'show'])->name('blogs.show');
});






// Trang client (không nằm trong admin)
Route::get('/home', [HomeController::class, 'index'])->name('home');


use App\Http\Controllers\Client\ContactController as ClientContactController;

Route::get('/contact', [ClientContactController::class, 'showForm'])->name('clients.contact');
Route::post('/contact', [ClientContactController::class, 'handleSubmit'])->name('contact.submit');


Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])->name('client.categories.show');


Route::get('/blog', [ClientBlogController::class, 'blog']);

use App\Http\Controllers\Client\ProductController as ClientProductController;

Route::get('/products', [ClientProductController::class, 'index'])->name('clients.products.index');
Route::get('/san-pham/{id}', [ClientProductController::class, 'show'])->name('client.products.show'); // nếu muốn có chi tiết sản phẩm
Route::prefix('products')->name('client.products.')->group(function () {
    Route::get('/', [ClientProductController::class, 'index'])->name('index');
    Route::get('/search', [ClientProductController::class, 'search'])->name('search');
    Route::get('/{id}', [ClientProductController::class, 'show'])->name('show');
});
Route::get('/products/search', [ClientProductController::class, 'search'])->name('clients.products.search');

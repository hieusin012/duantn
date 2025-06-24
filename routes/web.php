<?php

use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ThongKeController;
use App\Http\Controllers\BlogController as AdminBlogController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ShipTypeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductVariantController;

// Client Controllers
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\ContactController as ClientContactController;
use App\Http\Controllers\Client\BlogController as ClientBlogController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\ChangePasswordController;
use App\Http\Controllers\Client\ForgetPasswordController;
use App\Http\Controllers\Client\ClientCategoryController;

// Auth and Profile Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgetPasswordController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [ForgetPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgetPasswordController::class, 'resetPassword'])->name('password.update');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // Products Admin
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('/filter', [ProductController::class, 'filter'])->name('products.filter');
    });

    // Product Variants Admin
    Route::resource('product-variants', ProductVariantController::class);

    // Categories Admin
    Route::resource('categories', CategoryController::class)->except(['create', 'edit'])->parameters(['categories' => 'category']);
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

    // Banners Admin
    Route::resource('banners', BannerController::class)->except(['create', 'edit'])->parameters(['banners' => 'banner']);
    Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
    Route::get('/banners/{banner}/edit', [BannerController::class, 'edit'])->name('banners.edit');

    // Sizes Admin
    Route::resource('sizes', SizeController::class)->except(['create', 'edit'])->parameters(['sizes' => 'size']);
    Route::get('/sizes/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::get('/sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit');

    // Vouchers Admin
    Route::resource('vouchers', VoucherController::class);

    // Users Admin
    Route::resource('users', UserController::class)->except(['create', 'edit'])->parameters(['users' => 'user']);
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    // Colors Admin
    Route::prefix('colors')->group(function () {
        Route::get('/', [ColorController::class, 'index'])->name('colors.index');
        Route::get('/create', [ColorController::class, 'create'])->name('colors.create');
        Route::post('/', [ColorController::class, 'store'])->name('colors.store');
        Route::get('/deleted', [ColorController::class, 'delete'])->name('colors.delete'); // Renamed for clarity
        Route::delete('/all-eliminate', [ColorController::class, 'forceDeleteAll'])->name('colors.all-eliminate');
        Route::delete('/eliminate/{id}', [ColorController::class, 'eliminate'])->name('colors.eliminate');
        Route::get('/restore/{id}', [ColorController::class, 'restore'])->name('colors.restore');
        Route::delete('/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');
        Route::get('/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit');
        Route::put('/{id}', [ColorController::class, 'update'])->name('colors.update');
    });

    // Brands Admin
    Route::prefix('brands')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('brands.index');
        Route::get('/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('/', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/deleted', [BrandController::class, 'delete'])->name('brands.delete'); // Renamed for clarity
        Route::delete('/eliminate/{id}', [BrandController::class, 'eliminate'])->name('brands.eliminate');
        Route::delete('/all-eliminate', [BrandController::class, 'forceDeleteAll'])->name('brands.all-eliminate');
        Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');
        Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::get('/restore/{id}', [BrandController::class, 'restore'])->name('brands.restore');
    });

    // Blog Admin
    Route::prefix('blogs')->group(function () {
        Route::get('/', [AdminBlogController::class, 'index'])->name('blogs.index');
        Route::get('/create', [AdminBlogController::class, 'create'])->name('blogs.create');
        Route::post('/', [AdminBlogController::class, 'store'])->name('blogs.store');
        Route::get('/deleted', [AdminBlogController::class, 'delete'])->name('blogs.delete'); // Renamed for clarity
        Route::get('/restore/{id}', [AdminBlogController::class, 'restore'])->name('blogs.restore');
        Route::delete('/eliminate/{id}', [AdminBlogController::class, 'eliminate'])->name('blogs.eliminate');
        Route::delete('/all-eliminate', [AdminBlogController::class, 'forceDeleteAll'])->name('blogs.all-eliminate');
        Route::get('/{blog}/edit', [AdminBlogController::class, 'edit'])->name('blogs.edit');
        Route::put('/{blog}', [AdminBlogController::class, 'update'])->name('blogs.update');
        Route::delete('/{blog}', [AdminBlogController::class, 'destroy'])->name('blogs.destroy');
        Route::get('/{blog}', [AdminBlogController::class, 'show'])->name('blogs.show');
    });

    // Ship Types Admin
    Route::resource('shiptypes', ShipTypeController::class);

    // Orders Admin
    Route::resource('orders', OrderController::class);

    // Statistics Admin
    Route::prefix('thong-ke')->group(function () {
        Route::get('/san-pham', [ThongKeController::class, 'index'])->name('thongke.index');
        Route::get('/data', [ThongKeController::class, 'getData'])->name('thongke.data');
    });
});

// Client Routes
Route::prefix('')->name('client.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Products Client
    Route::prefix('products')->group(function () {
        Route::get('/', [ClientProductController::class, 'index'])->name('products.index');
        Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');
        Route::get('/san-pham/{slug}', [ClientProductController::class, 'show'])->name('products.show');
    });

    // Categories Client
    Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])->name('categories.show');

    // Contact Client
    Route::get('/contact', [ClientContactController::class, 'showForm'])->name('contact');
    Route::post('/contact', [ClientContactController::class, 'handleSubmit'])->name('contact.submit');

    // Blog Client
    Route::prefix('blog')->group(function () {
        Route::get('/', [ClientBlogController::class, 'index'])->name('blogs.index');
        Route::get('/{slug}', [ClientBlogController::class, 'show'])->name('blogs.show');
    });

    // Wishlist Client (requires authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
    });

    // Cart Client (requires authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
        Route::delete('/cart/remove/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    });

    // Profile Client (requires authentication)
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('profile.change-password');
        Route::post('/profile/update-password', [ChangePasswordController::class, 'changePassword'])->name('profile.update-password');
    });
});
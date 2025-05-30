<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Client\ClientCategoryController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;

Route::get('/',[DashboardController::class, 'index'])->name('dashboard.index');

// Product
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/create', [ProductController::class, 'store'])->name('products.store');
    Route::get('/show/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    Route::put('/edit/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('products/filter', [ProductController::class, 'filter'])->name('products.filter');

});
Route::get('/products/product-variants', [ProductVariantController::class, 'indexAll'])->name('productVariants.all');
Route::get('product-variants/{id}', [ProductVariantController::class, 'index'])->name('productVariants.index');
Route::get('product-variants/create/{id}', [ProductVariantController::class, 'create'])->name('productVariants.create');
Route::post('product-variants', [ProductVariantController::class, 'store'])->name('productVariants.store');
Route::get('product-variants/edit/{id}', [ProductVariantController::class, 'edit'])->name('productVariants.edit');
Route::put('product-variants/update/{id}', [ProductVariantController::class, 'update'])->name('productVariants.update');
Route::delete('product-variants/{id}', [ProductVariantController::class, 'destroy'])->name('productVariants.destroy');


// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


// Size
Route::get('sizes', [SizeController::class, 'index'])->name('sizes.index');           
Route::get('sizes/create', [SizeController::class, 'create'])->name('sizes.create');   
Route::post('sizes', [SizeController::class, 'store'])->name('sizes.store'); 
Route::get('sizes/{size}', [SizeController::class, 'show'])->name('sizes.show');
Route::get('sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit'); 
Route::put('sizes/{size}', [SizeController::class, 'update'])->name('sizes.update'); 
Route::delete('sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');

//home web 
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::prefix('shop')->group(function () {
//     Route::get('/', [ClientProductController::class, 'index'])->name('client.products.index');           // Danh sách sản phẩm
//     Route::get('/{slug}', [ClientProductController::class, 'show'])->name('client.products.show');        // Chi tiết sản phẩm
// });

Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])->name('client.categories.show');

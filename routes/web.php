<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CategoryController;
Route::get('/', function () {
    return view('admin.dashboard');
});


// Product
// Route::get('/product',[CategoryController::class, 'index'])->name('product.index');


// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


// Size
Route::get('sizes', [SizeController::class, 'index'])->name('sizes.index');           // Hiển thị danh sách size
Route::get('sizes/create', [SizeController::class, 'create'])->name('sizes.create');   // Hiển thị form tạo mới size
Route::post('sizes', [SizeController::class, 'store'])->name('sizes.store');           // Xử lý lưu size mới
Route::get('sizes/{size}', [SizeController::class, 'show'])->name('sizes.show');       // Hiển thị chi tiết size
Route::get('sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit');  // Hiển thị form sửa size
Route::put('sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');   // Xử lý cập nhật size
Route::delete('sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');// Xử lý xóa size
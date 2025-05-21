<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashBoardController;

Route::prefix('admin')->name('admin.')->group(function () {
    // Resource route cho categories, tự động tạo tất cả CRUD
    Route::resource('categories', CategoryController::class);

    // Route cho dashboard admin
    Route::get('/', [DashBoardController::class, 'index'])->name('index');
});

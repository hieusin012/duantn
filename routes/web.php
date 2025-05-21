
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.layouts.index');
})->name('home');
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');

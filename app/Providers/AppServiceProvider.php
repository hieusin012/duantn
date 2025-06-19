<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

public function boot()
{
    // Kích hoạt phân trang Bootstrap
    Paginator::useBootstrap();

    // Truyền dữ liệu cho header.blade.php
    View::composer('clients.layouts.partials.header', function ($view) {
        $headerCategories = Category::whereNull('parent_id')->orderBy('name')->get();
        $brands = Brand::whereNull('deleted_at')->orderBy('name')->get();

        $view->with('headerCategories', $headerCategories);
        $view->with('brands', $brands);
    });
}
}

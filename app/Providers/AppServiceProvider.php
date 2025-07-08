<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\BlogCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

            $wishlistCount = 0;
            if (Auth::check()) {
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            }

            $view->with('headerCategories', $headerCategories);
            $view->with('brands', $brands);
            $view->with('wishlistCount', $wishlistCount);
        });
        View::composer('*', function ($view) {
            $categories = Category::where('is_active', 1)->get();
            $view->with('header_categories', $categories);
        });
        view()->composer('*', function ($view) {
            $view->with('blog_categories', BlogCategory::all());
        });
    }
}

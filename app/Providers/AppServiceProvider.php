<?php

namespace App\Providers;

use App\Models\Category;
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
    View::composer('clients.layouts.partials.header', function ($view) {
        $categories = Category::whereNull('parent_id')->orderBy('name')->get();
        $view->with('headerCategories', $categories);
    });
}
}

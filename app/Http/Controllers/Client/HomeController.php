<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Banner;


class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm mới nhất và tải kèm thông tin comments, wishlists
        $products = Product::with(['comments', 'wishlists'])
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->latest()
            ->take(8)
            ->get();

        $blogs = Blog::where('status', 1)->latest()->take(3)->get(); // chỉ bài đăng công khai
        $banners = Banner::where('is_active', true)->latest()->get();
        $category = Category::get();
        $brand = Brand::get();

        return view('clients.home', compact('products', 'blogs', 'category', 'brand', 'banners'));
    }
}

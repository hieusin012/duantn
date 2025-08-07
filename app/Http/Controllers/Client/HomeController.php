<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Banner;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        // Lấy 8 sản phẩm mới nhất và tải kèm thông tin comments, wishlists
        $products = Product::with(['comments', 'wishlists'])
            ->where('is_active', 1)
            ->where('status', 1)
            // ->where('is_hot_deal', false) // 🔥 Loại bỏ sản phẩm hot deal
            
            // ->where(function ($query) use ($now) {
            //     $query->where('is_hot_deal', false)
            //         ->orWhereNull('deal_start_at')
            //         ->orWhere('deal_start_at', '>', $now)
            //         ->orWhere('deal_end_at', '<=', $now);
            // })
            ->whereNull('deleted_at')
            ->latest()
            ->take(8)
            ->get();

        $blogs = Blog::where('status', 1)->latest()->take(3)->get(); // chỉ bài đăng công khai
        $banners = Banner::where('is_active', true)->latest()->get();
        $category = Category::where('is_active', 1)->latest()->take(3)->get();
        $brand = Brand::get();

        return view('clients.home', compact('products', 'blogs', 'category', 'brand', 'banners'));
    }
}

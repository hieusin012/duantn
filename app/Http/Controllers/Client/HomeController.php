<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;

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

    return view('clients.home', compact('products', 'blogs'));
}
}

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
        // Lấy 8 sản phẩm mới nhất
        $products = Product::latest()->take(8)->get();

        // // Lấy 8 sản phẩm bán chạy nhất (giả sử có cột 'sold' trong bảng products)
        $bestSellers = Product::orderBy('sold', 'desc')->take(8)->get();
        $blogs = Blog::where('status', 0)->latest()->take(3)->get(); // chỉ bài đăng công khai
       return view('clients.home', compact('products','blogs'));
    }
}

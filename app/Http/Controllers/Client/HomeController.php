<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 8 sản phẩm mới nhất
        $latestProducts = Product::latest()->take(8)->get();

        // // Lấy 8 sản phẩm bán chạy nhất (giả sử có cột 'sold' trong bảng products)
        // $bestSellers = Product::orderBy('sold', 'desc')->take(8)->get();

        return view('clients.home', compact('latestProducts'));
    }
}

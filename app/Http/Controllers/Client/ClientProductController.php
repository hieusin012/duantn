<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{
    public function index()
    {
        $latestProducts = Product::orderBy('created_at', 'desc')->take(4)->get();

        return view('client.products.index', compact('latestProducts'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
        return view('clients.layouts.products.show', compact('product'));
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', 1)
                        ->whereNull('deleted_at')
                        ->latest()
                        ->paginate(12);

        return view('clients.products.index', compact('products'));
    }
    public function show($id)
{
    $product = Product::findOrFail($id);
    return view('clients.products.show', compact('product'));
}

}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        // Chặn nếu danh mục bị gỡ
        if (!$category->is_active) {
            abort(404);
        }

        $products = $category->products()->latest()->get();

        return view('clients.products.index', compact('products', 'category'));
    }
}

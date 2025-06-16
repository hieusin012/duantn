<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', 1)
            ->whereNull('deleted_at')
            ->latest()
            ->paginate(12);

        $categories = Category::whereNull('deleted_at')->get();
        $brands = Brand::whereNull('deleted_at')->get();

        return view('clients.products.index', compact('products', 'categories', 'brands'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('clients.products.show', compact('product'));
    }

    /**
     * Handle product search by name, category, brand, and price range.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
{
    

    $query = Product::where('is_active', 1)
        ->whereNull('deleted_at');

    // Search by name
    $search = $request->input('search');
    if (!empty($search)) {
        $query->where('name', 'like', '%' . $search . '%');
    }

    // Filter by category (and subcategories)
    if ($request->filled('category') && $request->input('category') != 0) {
        $categoryId = $request->input('category');
        $categoryIds = Category::where('is_active', 1)
            ->whereNull('deleted_at')
            ->where(function ($q) use ($categoryId) {
                $q->where('id', $categoryId)
                  ->orWhere('parent_id', $categoryId);
            })
            ->pluck('id')
            ->toArray();

        $query->whereIn('category_id', $categoryIds);
    }

    // Filter by brand
    if ($request->filled('brand')) {
        $query->where('brand_id', $request->input('brand'));
    }

    // Filter by price range
    $min = $request->input('min_price');
    $max = $request->input('max_price');

    if ($min !== null && $max !== null && (float)$min <= (float)$max) {
        $query->whereBetween('price', [(float)$min, (float)$max]);
    } elseif ($min !== null) {
        $query->where('price', '>=', (float)$min);
    } elseif ($max !== null) {
        $query->where('price', '<=', (float)$max);
    }

    // Pagination with filters
    $products = $query->latest()->paginate(12)
        ->appends($request->only(['search', 'category', 'brand', 'min_price', 'max_price']));

    // Get categories and brands for filter form
    $categories = Category::whereNull('deleted_at')->get();
    $brands = Brand::whereNull('deleted_at')->get();

    // Store search keyword in session (history)
    $history = session('search_history', []);
    if (!empty($search)) {
        $history = array_values(array_unique(array_merge([$search], $history)));
        $history = array_slice($history, 0, 5);
        session(['search_history' => $history]);
    }

    return view('clients.products.index', compact('products', 'categories', 'brands'));
}

}

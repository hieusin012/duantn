<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;



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


 /**
     * Handle product search by name and category.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = Product::query()
    ->where('is_active', 1)
    ->whereNull('deleted_at');


        // Search by product name
        if ($request->has('search') && !empty($request->input('search'))) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter by category, including subcategories
        if ($request->has('category') && $request->input('category') != 0) {
            $categoryId = $request->input('category');
            // Get the selected category and its descendants
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

        $products = $query->latest()->paginate(12);

        // Append query parameters to pagination links to preserve search filters
        $products->appends($request->only(['search', 'category']));
        $products = $query->paginate(12);
$products->appends($request->only(['search', 'category', 'brand', 'min_price', 'max_price']));

        return view('clients.products.index', compact('products'));
    }
    

}
// Filter by brand
if ($request->filled('brand')) {
    $query->where('brand_id', $request->input('brand'));
}

// Filter by min price
if ($request->filled('min_price')) {
    $query->where('price', '>=', $request->input('min_price'));
}

// Filter by max price
if ($request->filled('max_price')) {
    $query->where('price', '<=', $request->input('max_price'));
}

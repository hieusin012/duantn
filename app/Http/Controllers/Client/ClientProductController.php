<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ClientProductController extends Controller
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

    public function show($slug)
{
    $product = Product::with(['productGalleries', 'reviews'])
        ->where('slug', $slug)
        ->firstOrFail();

    $productImages = $product->productGalleries; // lấy danh sách ảnh phụ
    $averageRating = optional($product->reviews)->avg('rating'); // tính trung bình đánh giá an toàn

    return view('clients.products.show', compact('product', 'productImages', 'averageRating'));
}



    /**
     * Handle product search by name and category.
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

        // Filter by min price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        // Filter by max price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $products = $query->latest()->paginate(12);
        $products->appends($request->only(['search', 'category', 'brand', 'min_price', 'max_price']));

        $categories = Category::whereNull('deleted_at')->get();
        $brands = Brand::whereNull('deleted_at')->get();

        return view('clients.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Get product images - adjust based on your image storage structure
     */
    public function getProductImages($product)
    {
        // Nếu bạn có trường gallery hoặc images trong database
        if (isset($product->gallery) && !empty($product->gallery)) {
            return json_decode($product->gallery, true);
        }
        
        // Hoặc nếu bạn có bảng riêng cho images
        // return $product->images()->get();
        
        // Tạm thời return array mặc định với image chính
        return [
            $product->image ?? 'assets/images/products/default.jpg'
        ];
    }
}
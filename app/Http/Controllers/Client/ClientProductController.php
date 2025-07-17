<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductVariant;
use App\Models\Color;
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
        $product = Product::with(['galleries', 'variants.color', 'variants.size', 'brand', 'category'])
            ->where('slug', $slug)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->firstOrFail();

        $productImages = $product->galleries;

        // ✅ Lấy color_id từ các biến thể
        $variantColorIds = $product->variants->pluck('color_id')->filter()->unique();

        // ✅ Truy vấn bảng colors từ color_id của product_variants
        $colors = Color::whereIn('id', $variantColorIds)
            ->whereNull('deleted_at')
            ->get();

        $relatedProducts = Product::with(['brand', 'galleries'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->take(5)
            ->get();

        // ✅ Truyền biến colors xuống view
        return view('clients.products.show', compact('product', 'productImages', 'relatedProducts', 'colors'));
    }

    public function search(Request $request)
    {
        $query = Product::query()
            ->where('is_active', 1)
            ->whereNull('deleted_at');

        if ($request->has('search') && !empty($request->input('search'))) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

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

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->input('brand'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $products = $query->latest()->paginate(12);
        $products->appends($request->only(['search', 'category', 'brand', 'min_price', 'max_price']));

        $categories = Category::whereNull('deleted_at')->get();
        $brands = Brand::whereNull('deleted_at')->get();

        return view('clients.products.index', compact('products', 'categories', 'brands'));
    }

    public function getProductImages($product)
    {
        return $product->galleries->pluck('image')->toArray() ?: [
            $product->image ?? 'assets/images/products/default.jpg'
        ];
    }



    public function getVariantInfo(Request $request)
    {
        $productId = $request->input('product_id');
        $colorId = $request->input('color_id');

        $availableSizes = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->pluck('size_id')
            ->toArray();

        return response()->json([
            'available_sizes' => $availableSizes
        ]);
    }
}

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
        // Thêm 'comments' vào eager loading
        $products = Product::with(['comments', 'wishlists']) // <--- SỬA DÒNG NÀY
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->latest()
            ->paginate(12);

        $categories = Category::whereNull('deleted_at')->get();
        $brands = Brand::whereNull('deleted_at')->get();

        return view('clients.products.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Tải các mối quan hệ cần thiết
        $product->load([
            'galleries',
            'category',
            'brand',
            'variants' => function ($q) {
                $q->withTrashed()->with(['color', 'size']);
            },
            'comments' // Eager load comments để tối ưu
        ]);

        // Lấy sản phẩm liên quan
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(15)
            ->get();

        $productImages = $product->galleries;
        $variants = $product->variants;

        $colors = $product->variants->pluck('color')->unique('id')->values();
        $sizes = $product->variants->pluck('size')->unique('id')->values();
        $quantity = $product->variants->pluck('quantity')->unique('id')->values();

        // ================= LOGIC MỚI CHO PHẦN ĐÁNH GIÁ =================
        // Lấy tất cả bình luận đã được duyệt cho sản phẩm này
        $comments = $product->comments()->where('status', 1)->with('user')->latest()->get();

        $totalReviews = $comments->count();
        $averageRating = 0;
        $ratingPercentages = [
            '5' => 0,
            '4' => 0,
            '3' => 0,
            '2' => 0,
            '1' => 0
        ];

        if ($totalReviews > 0) {
            // Tính rating trung bình
            $averageRating = round($comments->avg('rating'), 1);

            // Đếm số lượng review cho mỗi mức sao
            $ratingCounts = $comments->groupBy('rating')->map->count();

            // Tính phần trăm cho mỗi mức sao
            foreach ($ratingCounts as $rating => $count) {
                if (isset($ratingPercentages[$rating])) {
                    $ratingPercentages[$rating] = round(($count / $totalReviews) * 100);
                }
            }
        }
        // =================== KẾT THÚC LOGIC MỚI =======================


        return view('clients.products.show', compact(
            'product',
            'productImages',
            'relatedProducts',
            'variants',
            'colors',
            'sizes',
            // Truyền các biến mới sang view
            'comments',
            'totalReviews',
            'averageRating',
            'ratingPercentages'
        ));
    }




    /**
     * Handle product search by name, category, brand, and price range.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {


        $query = Product::with(['comments', 'wishlists']) // <--- SỬA DÒNG NÀY
            ->where('is_active', 1)
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
    public function showByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        if (!$category->is_active) {
            abort(404);
        }

        $products = Product::where('category_id', $category->id)->paginate(12);

        return view('clients.products.by_category', compact('category', 'products'));
    }
}

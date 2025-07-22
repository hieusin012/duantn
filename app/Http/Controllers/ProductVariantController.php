<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])
            ->orderByDesc('created_at') // hoặc ->orderBy('created_at', 'desc')
            ->paginate(10);
        $color = Color::all();
        $size = Size::all();
        return view('admin.product_variants.index', compact('variants', 'color', 'size'));
    }

    public function create()
    {
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product_variants.create', compact('products', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'quantity' => 'required|integer',
            'image' => 'nullable|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_variants', 'public'); // lưu vào storage/app/public/product_variants
        }

        ProductVariant::create([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'sale_start_date' => $request->sale_start_date,
            'sale_end_date' => $request->sale_end_date,
            'quantity' => $request->quantity,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.product-variants.index')->with('success', 'Tạo biến thể thành công');
    }

    public function show(ProductVariant $productVariant)
    {
        $productVariant->load(['product', 'color', 'size']);
        return view('admin.product_variants.show', compact('productVariant'));
    }

    public function edit(ProductVariant $productVariant)
    {
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product_variants.edit', compact('productVariant', 'products', 'colors', 'sizes'));
    }

    public function update(Request $request, ProductVariant $productVariant)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'quantity' => 'required|integer',
            'image' => 'nullable|image'
        ]);

        $data = $request->only([
            'product_id',
            'color_id',
            'size_id',
            'price',
            'sale_price',
            'sale_start_date',
            'sale_end_date',
            'quantity',
        ]);

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            // Xoá ảnh cũ nếu có
            if ($productVariant->image) {
                Storage::disk('public')->delete($productVariant->image);
            }

            $data['image'] = $request->file('image')->store('product_variants', 'public');
        }

        $productVariant->update($data);

        return redirect()->route('admin.product-variants.index')->with('success', 'Cập nhật thành công');
    }


    public function destroy(ProductVariant $productVariant)
    {
        if ($productVariant->image && Storage::disk('public')->exists($productVariant->image)) {
            Storage::disk('public')->delete($productVariant->image);
        }

        $productVariant->delete();
        return redirect()->route('admin.product-variants.index')
            ->with('success', 'Product variant deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = ProductVariant::with('product', 'color', 'size');

        if ($keyword = $request->keyword) {
            $query->whereHas('product', function ($q2) use ($keyword) {
                $q2->where('name', 'like', "%{$keyword}%");
            });
        }

        if ($request->color) {
            $query->whereHas('color', function ($q) use ($request) {
                $q->where('name', $request->color);
            });
        }
        if ($request->size) {
            $query->whereHas('size', function ($q) use ($request) {
                $q->where('name', $request->size);
            });
        }

        if ($request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        $variants = $query->latest()->paginate(10);
        $color = Color::all();
        $size = Size::all();

        return view('admin.product_variants.index', compact('variants', 'color', 'size'));
    }
}

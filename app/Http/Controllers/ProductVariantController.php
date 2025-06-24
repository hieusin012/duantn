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
        $variants = ProductVariant::with(['product', 'color', 'size'])->paginate(10);
        return view('admin.product_variants.index', compact('variants'));
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
            'quantity' => 'required|integer',
            'image' => 'nullable|image'
        ]);

        $data = $request->only([
            'product_id',
            'color_id',
            'size_id',
            'price',
            'sale_price',
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
}

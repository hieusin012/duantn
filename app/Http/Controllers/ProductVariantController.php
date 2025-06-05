<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductVariantController extends Controller
{
    public function index()
    {
        $variants = ProductVariant::with(['product', 'color', 'size'])->paginate(10); // Use paginate instead of get
        return view('admin.product_variants.index', compact('variants'));
    }

    // Rest of the controller remains unchanged
    public function create()
    {
        $products = Product::all();
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product_variants.create', compact('products', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProductVariant::create($request->all());
        return redirect()->route('admin.product-variants.index')->with('success', 'Product variant created successfully.');
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
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $productVariant->update($request->all());
        return redirect()->route('admin.product-variants.index')->with('success', 'Product variant updated successfully.');
    }

    public function destroy(ProductVariant $productVariant)
    {
        $productVariant->delete();
        return redirect()->route('admin.product-variants.index')->with('success', 'Product variant deleted successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     * $id là id của sản phẩm, để lấy danh sách biến thể sản phẩm đó.
     */
    public function indexAll()
{
    $productVariants = ProductVariant::with('product', 'color', 'size')->paginate(10);
    return view('admin.productsvariants.index_all', compact('productVariants'));
}


    public function index($id)
    {
        $productVariants = ProductVariant::with('product', 'size', 'color')
            ->where('product_id', $id)
            ->paginate(8);

        return view('admin.productsvariants.index', compact('productVariants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $product = Product::findOrFail($id);
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.productsvariants.create', compact('colors', 'sizes', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductVariantRequest $request)
    {
        $productVariant = new ProductVariant();

        $productVariant->product_id = $request->product_id;
        $productVariant->color_id = $request->color_id;
        $productVariant->size_id = $request->size_id;
        $productVariant->quantity = $request->quantity;
        $productVariant->price = $request->price;
        $productVariant->sale_price = $request->sale_price;
        $productVariant->sale_start_date = $request->sale_start_date;
        $productVariant->sale_end_date = $request->sale_end_date;

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_variants', 'public');
                $imagePaths[] = $path;
            }
            $productVariant->images = json_encode($imagePaths);
        }

        $productVariant->save();

        return redirect()->route('productVariants.index', $request->product_id)
                         ->with('success', 'Tạo biến thể sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $variant = ProductVariant::with(['product', 'color', 'size'])->findOrFail($id);

        return view('admin.productsvariants.show', compact('variant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.productsvariants.edit', compact('productVariant', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, $id)
    {
        $productVariant = ProductVariant::findOrFail($id);

        $productVariant->product_id = $request->product_id;
        $productVariant->color_id = $request->color_id;
        $productVariant->size_id = $request->size_id;
        $productVariant->quantity = $request->quantity;
        $productVariant->price = $request->price;
        $productVariant->sale_price = $request->sale_price;
        $productVariant->sale_start_date = $request->sale_start_date;
        $productVariant->sale_end_date = $request->sale_end_date;

        if ($request->hasFile('images')) {
            // Xóa ảnh cũ nếu có
            if ($productVariant->images) {
                $oldImages = json_decode($productVariant->images, true);
                foreach ($oldImages as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_variants', 'public');
                $imagePaths[] = $path;
            }
            $productVariant->images = json_encode($imagePaths);
        }

        $productVariant->save();

        return redirect()->route('productVariants.index', $request->product_id)
                         ->with('success', 'Cập nhật biến thể sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $variant = ProductVariant::findOrFail($id);

        // Xoá ảnh nếu có
        if ($variant->images) {
            $images = json_decode($variant->images, true);
            foreach ($images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $variant->delete();

        return back()->with('success', 'Xoá biến thể sản phẩm thành công!');
    }

    /**
     * Check for duplicate variant via AJAX.
     */
    public function checkDuplicate(Request $request)
    {
        $exists = ProductVariant::where('product_id', $request->product_id)
            ->where('color_id', $request->color_id)
            ->where('size_id', $request->size_id)
            ->exists();

        return response()->json(['exists' => $exists]);
    }
}

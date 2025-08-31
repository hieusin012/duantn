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
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'quantity' => 'required|integer',
            'image' => 'nullable|max:2048'
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'color_id.required' => 'Vui lòng chọn màu sắc.',
            'color_id.exists' => 'Màu sắc không hợp lệ.',
            'size_id.required' => 'Vui lòng chọn kích thước.',
            'size_id.exists' => 'Kích thước không hợp lệ.',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'sale_price.numeric' => 'Giá khuyến mãi phải là số.',
            'sale_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'sale_start_date.date' => 'Ngày bắt đầu khuyến mãi không hợp lệ.',
            'sale_end_date.date' => 'Ngày kết thúc khuyến mãi không hợp lệ.',
            'sale_end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'image.image' => 'Tệp phải là hình ảnh.',
            'image.max' => 'Ảnh không được vượt quá 2MB.'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_variants', 'public'); // lưu vào storage/app/public/product_variants
        }
        
        // Biến thể này đã tồn tại
        $exists = ProductVariant::where([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id
        ])->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Biến thể này đã tồn tại, vui lòng chọn thông tin khác'])->withInput();
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
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'sale_start_date' => 'nullable|date',
            'sale_end_date' => 'nullable|date|after_or_equal:sale_start_date',
            'quantity' => 'required|integer',
            'image' => 'nullable|image'
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'color_id.required' => 'Vui lòng chọn màu sắc.',
            'color_id.exists' => 'Màu sắc không hợp lệ.',
            'size_id.required' => 'Vui lòng chọn kích thước.',
            'size_id.exists' => 'Kích thước không hợp lệ.',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'sale_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'sale_price.numeric' => 'Giá khuyến mãi phải là số.',
            'sale_start_date.date' => 'Ngày bắt đầu khuyến mãi không hợp lệ.',
            'sale_end_date.date' => 'Ngày kết thúc khuyến mãi không hợp lệ.',
            'sale_end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'image.image' => 'Tệp phải là hình ảnh.'
        ]);

        // Biến thể này đã tồn tại
        $exists = ProductVariant::where([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
        ])->where('id', '!=', $productVariant->id)->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Biến thể này đã tồn tại, vui lòng chọn thông tin khác'])->withInput();
        }


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
                Storage::disk('public');
            }

            $data['image'] = $request->file('image')->store('product_variants', 'public');
        }

        $productVariant->update($data);

        return redirect()->route('admin.product-variants.index')->with('success', 'Cập nhật thành công');
    }


    // public function destroy(ProductVariant $productVariant)
    // {
    //     if ($productVariant->image && Storage::disk('public')->exists($productVariant->image)) {
    //         Storage::disk('public')->delete($productVariant->image);
    //     }

    //     $productVariant->delete();
    //     return redirect()->route('admin.product-variants.index')
    //         ->with('success', 'Product variant deleted successfully.');
    // }

    public function destroy(ProductVariant $productVariant)
    {
        // Kiểm tra nếu biến thể đang được dùng trong đơn hàng
        $isUsedInOrders = $productVariant->orderDetails()->exists();

        // if ($isUsedInOrders) {
        //     return redirect()->back()->with('error', 'Không thể xóa biến thể đang được sử dụng trong đơn hàng.');
        // }

        // Nếu có ảnh thì xóa ảnh
        // if ($productVariant->image && Storage::disk('public')->exists($productVariant->image)) {
        //     Storage::disk('public')->delete($productVariant->image);
        // }

        $productVariant->delete();

        return redirect()->route('admin.product-variants.index')
            ->with('success', 'Đã ẩn biến thể thành công.');
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
    // Hiển thị danh sách đã xóa mềm
    public function delete()
    {
        $deletedVariants = ProductVariant::onlyTrashed()->with(['product', 'color', 'size'])->get();
        return view('admin.product_variants.delete', compact('deletedVariants'));
    }

    // Khôi phục 1 biến thể
    public function restore($id)
    {
        $variant = ProductVariant::withTrashed()->findOrFail($id);
        $variant->restore();
        return redirect()->route('admin.product-variants.index')->with('success', 'Khôi phục biến thể thành công!');
    }

    // Xóa vĩnh viễn 1 biến thể
    public function eliminate($id)
    {
        $variant = ProductVariant::withTrashed()->findOrFail($id);

        // XÓA ảnh nếu tồn tại
        if ($variant->image && Storage::disk('public')->exists($variant->image)) {
            Storage::disk('public')->delete($variant->image);
        }
        $variant->forceDelete();
        return redirect()->route('admin.product-variants.delete')->with('success', 'Xóa vĩnh viễn biến thể thành công!');
    }

    // Xóa vĩnh viễn tất cả
    public function forceDeleteAll()
    {
        $variants = ProductVariant::onlyTrashed()->get();
        foreach ($variants as $variant) {
        // XÓA ảnh nếu tồn tại
        if ($variant->image && Storage::disk('public')->exists($variant->image)) {
            Storage::disk('public')->delete($variant->image);
        }

            $variant->forceDelete();
        }
        return redirect()->route('admin.product-variants.delete')->with('success', 'Xóa vĩnh viễn tất cả biến thể thành công!');
    }
}

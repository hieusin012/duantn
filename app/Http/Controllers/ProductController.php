<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand'])->whereNull('deleted_at'); // Respect soft deletes

        // Tìm kiếm theo từ khóa nếu có
        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%")
                  ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                  ->orWhereHas('brand', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
            });
        }

        // Lọc theo danh mục
        if ($category_id = $request->input('category_id')) {
            $query->where('category_id', $category_id);
        }

        // Lọc theo thương hiệu
        if ($brand_id = $request->input('brand_id')) {
            $query->where('brand_id', $brand_id);
        }

        // Lọc theo khoảng giá
        if ($min_price = $request->input('min_price')) {
            $query->where('price', '>=', $min_price);
        }
        if ($max_price = $request->input('max_price')) {
            $query->where('price', '<=', $max_price);
        }

        // Lọc theo trạng thái active nếu có
        if (!is_null($request->input('is_active'))) {
            $query->where('is_active', $request->input('is_active'));
        }

        // Sắp xếp theo tên hoặc ngày tạo
        if ($sort = $request->input('sort')) {
            $order = $sort === 'az' ? 'asc' : 'desc';
            $query->orderBy('name', $order);
        } else {
            $query->orderByDesc('created_at');
        }

        // Lấy danh sách danh mục và thương hiệu cho form lọc
        $categories = Category::whereNull('deleted_at')->get(); // Respect soft deletes
        $brands = Brand::whereNull('deleted_at')->get(); // Respect soft deletes
        $products = $query->paginate(10)->appends($request->all());

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    // Form thêm sản phẩm mới
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();

        // Tạo mã ngẫu nhiên duy nhất
        do {
            $code = (string)random_int(100000, 999999);
        } while (Product::where('code', $code)->exists());

        return view('admin.products.create', compact('categories', 'brands', 'colors', 'sizes', 'code'));
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        // Tạo mã code duy nhất
        do {
            $code = (string)random_int(100000, 999999);
        } while (Product::where('code', $code)->exists());

        $slug = Str::slug($validated['name']);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        Product::create([
            'code' => $code,
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'is_active' => $validated['is_active'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    // Form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'colors', 'sizes'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|max:20|unique:products,code,' . $id,
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        $slug = Str::slug($validated['name']);
        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            if ($imagePath && is_file(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        $product->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'is_active' => $validated['is_active'],
            'category_id' => $validated['category_id'],
            'brand_id' => $validated['brand_id'],
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    }
}

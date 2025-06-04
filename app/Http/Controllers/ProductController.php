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
    public function index()
    {
        $products = Product::orderByDesc('created_at')->paginate(10);
        return view('admin.products.index', compact('products'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
        ]);

        // Tạo mã ngẫu nhiên duy nhất
        do {
            $code = (string)random_int(100000, 999999);
        } while (Product::where('code', $code)->exists());

        $slug = Str::slug($request->name);
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/products'), $imageName);
            $imagePath = 'uploads/products/' . $imageName;
        }

        Product::create([
            'code' => $code,
            'name' => $request->name,
            'slug' => $slug,
            'image' => $imagePath,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status,
            'is_active' => $request->is_active,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    // Form chỉnh sửa
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

        $validatedData = $request->validate([
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

        $slug = Str::slug($request->name);
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
            'code' => $validatedData['code'],
            'name' => $validatedData['name'],
            'slug' => $slug,
            'image' => $imagePath,
            'price' => $validatedData['price'],
            'description' => $validatedData['description'] ?? null,
            'status' => $validatedData['status'],
            'is_active' => $validatedData['is_active'],
            'category_id' => $validatedData['category_id'],
            'brand_id' => $validatedData['brand_id'],
        ]);

        return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && file_exists(public_path($product->image))) {
            @unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Xóa sản phẩm thành công');
    }

    // Tìm kiếm
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::query()
            ->with(['category', 'brand'])
            ->where('name', 'like', "%$keyword%")
            ->orWhere('code', 'like', "%$keyword%")
            ->orWhereHas('category', fn($q) => $q->where('name', 'like', "%$keyword%"))
            ->orWhereHas('brand', fn($q) => $q->where('name', 'like', "%$keyword%"))
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // Lọc sản phẩm
    public function filter(Request $request)
    {
        $query = Product::query();

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('sort')) {
            $query->orderBy('name', $request->sort === 'az' ? 'asc' : 'desc');
        }

        $products = $query->paginate(10);

        return view('admin.products.index', compact('products'));
    }
}

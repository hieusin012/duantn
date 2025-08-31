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
        // if (!is_null($request->input('is_active'))) {
        //     $query->where('is_active', $request->input('is_active'));
        // }

        // Lọc theo trạng thái ẩn/hiện
        if (!is_null($request->input('status'))) {
            $query->where('status', $request->input('status'));
        }

        // Lọc theo còn hàng/hết hàng
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
        // $categories = Category::all();
        $categories = Category::where('is_active', 1)->get(); // ✅ Lấy các danh mục đang hoạt động
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
            'name' => 'required|string|max:255|unique:products,name',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_hot_deal' => 'nullable|boolean',
            'discount_percent' => 'nullable|required_if:is_hot_deal,1|integer|min:1|max:100',
            'deal_start_at' => 'nullable|required_if:is_hot_deal,1|date|after:now|before:deal_end_at',
            'deal_end_at' => 'nullable|required_if:is_hot_deal,1|date|after:now',

        ], [
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'is_active.required' => 'Vui lòng chọn tình trạng.',
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'brand_id.required' => 'Vui lòng chọn thương hiệu.',
            'discount_percent.required_if' => 'Vui lòng nhập phần trăm giảm khi sản phẩm là ưu đãi.',
            'discount_percent.min' => 'Phần trăm giảm phải lớn hơn 0%.',
            'discount_percent.max' => 'Phần trăm giảm tối đa là 100%.',
            'deal_start_at.required_if' => 'Vui lòng nhập thời gian bắt đầu ưu đãi.',
            'deal_start_at.after' => 'Thời gian bắt đầu ưu đãi phải sau thời điểm hiện tại.',
            'deal_start_at.before' => 'Thời gian bắt đầu ưu đãi phải trước thời gian kết thúc.',
            'deal_end_at.required_if' => 'Vui lòng nhập thời gian kết thúc ưu đãi.',
            'deal_end_at.after' => 'Thời gian kết thúc ưu đãi phải sau thời điểm hiện tại.',
        ]);

        // Tạo mã code duy nhất
do {
    $code = (string)random_int(100000, 999999);
} while (Product::where('code', $code)->exists());

// Tạo slug duy nhất
$baseSlug = Str::slug($validated['name']);
$slug = $baseSlug;
$counter = 1;

while (Product::where('slug', $slug)->exists()) {
    $slug = $baseSlug . '-' . $counter++;
}

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
    'is_hot_deal' => $request->has('is_hot_deal'),
    'discount_percent' => $request->input('discount_percent'),
    'deal_start_at' => $request->input('deal_start_at'),
    'deal_end_at' => $request->input('deal_end_at'),
]);


        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công');
    }

    // Form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // Lấy các danh mục đang hoạt động
        $categories = Category::where('is_active', 1)->get();

        // Nếu danh mục của sản phẩm hiện tại đã bị ẩn → thêm thủ công để vẫn hiển thị trong select
        if ($product->category && !$product->category->is_active) {
            $categories->push($product->category);
        }

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
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'is_active' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'is_hot_deal' => 'nullable|boolean',
            'discount_percent' => 'nullable|required_if:is_hot_deal,1|integer|min:1|max:100',
            'deal_start_at' => 'nullable|required_if:is_hot_deal,1|date|after:now|before:deal_end_at',
            'deal_end_at' => 'nullable|required_if:is_hot_deal,1|date|after:now',
        ], [
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'is_active.required' => 'Vui lòng chọn tình trạng.',
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'brand_id.required' => 'Vui lòng chọn thương hiệu.',
            'discount_percent.required_if' => 'Vui lòng nhập phần trăm giảm khi sản phẩm là ưu đãi.',
            'discount_percent.min' => 'Phần trăm giảm phải lớn hơn 0%.',
            'discount_percent.max' => 'Phần trăm giảm tối đa là 100%.',
            'deal_start_at.required_if' => 'Vui lòng nhập thời gian bắt đầu ưu đãi.',
            'deal_start_at.after' => 'Thời gian bắt đầu ưu đãi phải sau thời điểm hiện tại.',
            'deal_start_at.before' => 'Thời gian bắt đầu ưu đãi phải trước thời gian kết thúc.',
            'deal_end_at.required_if' => 'Vui lòng nhập thời gian kết thúc ưu đãi.',
            'deal_end_at.after' => 'Thời gian kết thúc ưu đãi phải sau thời điểm hiện tại.',
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
            'is_hot_deal' => $request->has('is_hot_deal'),
            'discount_percent' => $request->input('discount_percent'),
            'deal_start_at' => $request->input('deal_start_at'),
            'deal_end_at' => $request->input('deal_end_at'),
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    // Xóa sản phẩm
    // public function destroy($id)
    // {
    //     $product = Product::findOrFail($id);

    //     if ($product->image && file_exists(public_path($product->image))) {
    //         @unlink(public_path($product->image)); // Xóa file ảnh
    //     }

    //     $product->delete();

    //     return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công');
    // }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Kiểm tra nếu có đơn hàng liên quan
        // if ($product->orderDetails()->exists()) {
        //     return redirect()->back()->with('error', 'Không thể xóa sản phẩm đã có trong đơn hàng.');
        // }
        // KHÔNG xóa file ảnh khi chỉ soft delete
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Ẩn sản phẩm thành công');
    }

    public function trash()
    {
        $deletedProducts = Product::onlyTrashed()->paginate(10);
        return view('admin.products.trash', compact('deletedProducts'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.products.trash')->with('success', 'Đã khôi phục sản phẩm!');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('admin.products.trash')->with('success', 'Đã xóa vĩnh viễn sản phẩm!');
    }

    public function forceDeleteAll()
    {
        Product::onlyTrashed()->forceDelete();

        return redirect()->route('admin.products.trash')->with('success', 'Đã xóa vĩnh viễn tất cả sản phẩm!');
    }
}

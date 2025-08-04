<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $categories = Category::with('parent')
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories->appends(['q' => $query]);

        return view('admin.categories.index', compact('categories', 'query'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        // Sinh slug từ tên
        $slug = Str::slug($data['name']);
        $originalSlug = $slug;
        $counter = 1;

        // Kiểm tra và đảm bảo slug là duy nhất
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $data['slug'] = $slug;

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Tạo danh mục thành công.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if ($data['name'] !== $category->name) {
            $slug = Str::slug($data['name']);
            $originalSlug = $slug;
            $counter = 1;

            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data['slug'] = $slug;
        }

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($category->image);
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục thành công.');
    }

    public function toggleStatus(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->is_active = $request->input('is_active') ? 1 : 0;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái đã được cập nhật.',
            'status' => $category->is_active
        ]);
    }
}

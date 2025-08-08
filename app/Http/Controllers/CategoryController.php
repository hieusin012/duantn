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
    $showTrashed = $request->input('trashed') === 'true';

    $categories = Category::with('parent')
        ->when($showTrashed, function ($q) {
            $q->onlyTrashed();
        }, function ($q) {
            $q->whereNull('deleted_at'); 

        })
        ->when($query, function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $categories->appends(['q' => $query, 'trashed' => $showTrashed]);

    return view('admin.categories.index', compact('categories', 'query', 'showTrashed'));
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
    // Khôi phục bản ghi đã xoá mềm
    public function restore($id)
    {
    $category = Category::onlyTrashed()->findOrFail($id);
    $category->restore();

    return redirect()->route('admin.categories.index')->with('success', 'Khôi phục danh mục thành công.');
    }

    // Xoá vĩnh viễn
    public function forceDelete($id)
    {
    $category = Category::onlyTrashed()->findOrFail($id);
    
    if ($category->image) {
        Storage::disk('public')->delete($category->image);
    }

    $category->forceDelete();

    return redirect()->route('admin.categories.index')->with('success', 'Xoá vĩnh viễn thành công.');
    }

}

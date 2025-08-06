<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::latest()->paginate(10);
        return view('admin.blog_categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = BlogCategory::whereNull('parent_id')->get();
        return view('admin.blog_categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.string' => 'Tên danh mục phải là chuỗi.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
        ]);

        BlogCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Đã tạo danh mục!');
    }

    public function edit(BlogCategory $blogCategory)
    {
        $parents = BlogCategory::whereNull('parent_id')->where('id', '!=', $blogCategory->id)->get();
        return view('admin.blog_categories.edit', compact('blogCategory', 'parents'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $blogCategory->id,
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.string' => 'Tên danh mục phải là chuỗi.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
        ]);


        $blogCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        return back()->with('success', 'Đã xoá danh mục!');
    }
    public function delete()
    {
        $deletedCategories = BlogCategory::onlyTrashed()->paginate(10);
        return view('admin.blog_categories.delete', compact('deletedCategories'));
    }

    public function restore($id)
    {
        $category = BlogCategory::onlyTrashed()->findOrFail($id);
        $category->restore();

        return back()->with('success', 'Khôi phục danh mục thành công!');
    }

    public function eliminate($id)
    {
        $category = BlogCategory::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return back()->with('success', 'Đã xóa vĩnh viễn danh mục!');
    }
    public function forceDeleteAll()
    {
        $deletedCategories = BlogCategory::onlyTrashed()->get();

        foreach ($deletedCategories as $category) {
            $category->forceDelete();
        }

        return back()->with('success', 'Đã xóa vĩnh viễn tất cả danh mục!');
    }

}

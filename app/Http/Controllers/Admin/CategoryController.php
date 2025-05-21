<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean',
        ]);
    
        $data = $request->only('name', 'parent_id', 'is_active');
    
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/categories', 'public');
        }
    
        Category::create($data);
    
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }
    
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:200',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'image' => 'nullable|image',
            'is_active' => 'required|boolean',
        ]);
    
        $data = $request->only('name', 'parent_id', 'is_active');
    
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('uploads/categories', 'public');
        }
    
        $category->update($data);
    
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }
    
    
    
    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục!');
    }
}

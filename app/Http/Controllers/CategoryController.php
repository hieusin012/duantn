<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        // dd($parents);

        return view('admin.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:200',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Tạo danh mục thành công.');
    }

    public function edit(Category $category)
    {
        $parents = Category::where('id', '!=', $category->id)->get();
        return view('admin.categories.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|max:200',
            'image' => 'nullable|image',
            'is_active' => 'boolean',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($category->image);
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Đã xóa danh mục.');
    }
}

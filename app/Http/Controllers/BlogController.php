<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::join('categories', 'blogs.category_id', '=', 'categories.id')
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->select('blogs.*', 'categories.name as category_name', 'users.fullname as user_name')
            ->orderBy('blogs.created_at', 'desc')
            ->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }
    public function show($id)
    {
        $blog = Blog::join('categories', 'blogs.category_id', '=', 'categories.id')
            ->join('users', 'blogs.user_id', '=', 'users.id')
            ->select('blogs.*', 'categories.name as category_name', 'users.fullname as user_name')->findOrFail($id);
        return view('admin.blogs.detail', compact('blog'));
    }
   public function create(){
    $blogs = Blog::all();
    $categories = \App\Models\Category::all();
    $users = \App\Models\User::all();
    return view('admin.blogs.create', compact('blogs', 'categories', 'users'));  
   }
   public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

       $data = [
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $request->slug,
            'status' => $request->status == 1,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
        ];
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }
        Blog::create($data);
        return redirect()->route('admin.blogs.index')->with('success', 'Thêm bài viết thành công!');
    }
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Xóa bài viết thành công!');
    }
    public function delete()
    {
        $blogs = Blog::onlyTrashed()->get();
        return view('admin.blogs.delete', compact('blogs'));
    }
}

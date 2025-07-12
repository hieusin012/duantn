<?php

namespace App\Http\Controllers\Client;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(6);
        return view('clients.blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::with(['user.blogs', 'category'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // Kiểm tra nếu danh mục đã bị gỡ hoặc không tồn tại
        if (!$blog->category || !$blog->category->is_active) {
            abort(404);
        }

        $recentBlogs = Blog::select('id', 'title', 'slug', 'image', 'created_at')
            ->where('id', '!=', $blog->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('clients.blogs.show', compact('blog', 'recentBlogs'));
    }


    public function showByCategory($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        if (!$category->is_active) {
            abort(404);
        }

        $blogs = Blog::where('category_id', $category->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('clients.blogs.by_category', compact('blogs', 'category'));
    }

}

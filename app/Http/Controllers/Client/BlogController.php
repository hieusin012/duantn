<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(6);
        return view('clients.blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::with(['user.blogs', 'category'])->where('slug', $slug)->where('status', 1)->firstOrFail();

        $recentBlogs = Blog::select('id', 'title', 'slug', 'image', 'created_at')
            ->where('id', '!=', $blog->id)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('clients.blogs.show', compact('blog', 'recentBlogs'));
    }
}

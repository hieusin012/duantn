<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;


class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->paginate(6);
        return view('clients.blogs.index', compact('blogs')); // SỬA TỪ 'client.blogs.index' thành 'clients.blogs.index'
    }
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('clients.blogs.show', compact('blog')); // SỬA TỪ 'client.blogs.show' thành 'clients.blogs.show'
    }
}
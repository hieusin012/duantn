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
    public function create()
    {
        $blogs = Blog::all();
        return view('admin.blogs.create', compact('blogs'));
    }
}

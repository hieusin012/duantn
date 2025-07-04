<?php

// namespace App\Http\Controllers;

// use App\Models\Blog;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;

// class BlogController extends Controller
// {
//     public function index()
//     {
//         $blogs = Blog::join('categories', 'blogs.category_id', '=', 'categories.id')
//             ->join('users', 'blogs.user_id', '=', 'users.id')
//             ->select('blogs.*', 'categories.name as category_name', 'users.fullname as user_name')
//             ->orderBy('blogs.created_at', 'desc')
//             ->paginate(10);
//         return view('admin.blogs.index', compact('blogs'));
//     }
//     public function show($id)
//     {
//         $blog = Blog::join('categories', 'blogs.category_id', '=', 'categories.id')
//             ->join('users', 'blogs.user_id', '=', 'users.id')
//             ->select('blogs.*', 'categories.name as category_name', 'users.fullname as user_name')->findOrFail($id);
//         return view('admin.blogs.detail', compact('blog'));
//     }
//    public function create(){
//     $blogs = Blog::all();
//     $categories = \App\Models\Category::all();
//     $users = \App\Models\User::all();
//     return view('admin.blogs.create', compact('blogs', 'categories', 'users'));  
//    }
//    public function store(Request $request)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'content' => 'required|string',
//             'slug' => 'required|string|max:255|unique:blogs,slug',
//             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
//             'category_id' => 'required|exists:categories,id',
//             'user_id' => 'required|exists:users,id',
//         ]);

//        $data = [
//             'title' => $request->title,
//             'content' => $request->content,
//             'slug' => $request->slug,
//             'status' => $request->status == 1,
//             'category_id' => $request->category_id,
//             'user_id' => $request->user_id,
//         ];
//         if ($request->hasFile('image')) {
//             $data['image'] = $request->file('image')->store('blogs', 'public');
//         }
//         Blog::create($data);
//         return redirect()->route('admin.blogs.index')->with('success', 'Thêm bài viết thành công!');
//     }
//     public function edit($id)
//     {
//         $blog = Blog::findOrFail($id);
//         $categories = \App\Models\Category::all();
//         $users = \App\Models\User::all();
//         return view('admin.blogs.edit', compact('blog', 'categories', 'users'));
//     }
//     public function update(Request $request, $id)
//     {
//         $request->validate([
//             'title' => 'required|string|max:255',
//             'content' => 'required|string',
//             'slug' => 'required|string|max:255|unique:blogs,slug,' . $id,
//             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
//             'category_id' => 'required|exists:categories,id',
//             'user_id' => 'required|exists:users,id',
//         ]);

//         $blog = Blog::findOrFail($id);
//         $data = [
//             'title' => $request->title,
//             'content' => $request->content,
//             'slug' => $request->slug,
//             'status' => $request->status == 1,
//             'category_id' => $request->category_id,
//             'user_id' => $request->user_id,
//         ];
//         if ($request->hasFile('image')) {
//             if ($blog->image) {
//                 Storage::disk('public')->delete($blog->image);
//             }
//             $data['image'] = $request->file('image')->store('blogs', 'public');
//         }
//         $blog->update($data);
//         return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật bài viết thành công!');
//     }
//     public function destroy($id)
//     {
//         $blog = Blog::findOrFail($id);
//         $blog->delete();
//         return redirect()->route('admin.blogs.index')->with('success', 'Xóa bài viết thành công!');
//     }
//     public function delete()
//     {
//         $blogs = Blog::onlyTrashed()->get();
//         return view('admin.blogs.delete', compact('blogs'));
//     }
//     public function restore($id)
//     {
//         $blog = Blog::withTrashed()->findOrFail($id);
//         $blog->restore();
//         return redirect()->route('admin.blogs.index')->with('success', 'Khôi phục bài viết thành công!');
//     }
//     public function eliminate($id)
//     {
//         $blog = Blog::withTrashed()->findOrFail($id);
//         if ($blog->image) {
//             Storage::disk('public')->delete($blog->image);
//         }
//         $blog->forceDelete();
//         return redirect()->route('admin.blogs.delete')->with('success', 'Xóa vĩnh viễn bài viết thành công!');
//     }
//     public function forceDeleteAll()
//     {
//         $blogs = Blog::onlyTrashed()->get();
//         foreach ($blogs as $blog) {
//             if ($blog->image) {
//                 Storage::disk('public')->delete($blog->image);
//             }
//             $blog->forceDelete();
//         }
//         return redirect()->route('admin.blogs.delete')->with('success', 'Xóa vĩnh viễn tất cả bài viết thành công!');
//     }
// }



namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function show($id)
    {
        $blog = Blog::with(['category', 'user'])->findOrFail($id);
        return view('admin.blogs.detail', compact('blog'));
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', 1)->get(); // ✅ chỉ lấy danh mục đang hiển thị
        $users = User::all(); // nếu bạn cần hiển thị danh sách người viết

        return view('admin.blogs.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:blog_categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $data = $request->only(['title', 'content', 'slug', 'category_id', 'user_id']);
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Thêm bài viết thành công!');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        $users = User::all();

        return view('admin.blogs.edit', compact('blog', 'categories', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:blog_categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $blog = Blog::findOrFail($id);

        $data = $request->only(['title', 'content', 'slug', 'category_id', 'user_id']);
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Xóa bài viết thành công!');
    }

    public function delete()
    {
        $blogs = Blog::onlyTrashed()->with(['category', 'user'])->get();
        return view('admin.blogs.delete', compact('blogs'));
    }

    public function restore($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);
        $blog->restore();

        return redirect()->route('admin.blogs.index')->with('success', 'Khôi phục bài viết thành công!');
    }

    public function eliminate($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);

        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->forceDelete();

        return redirect()->route('admin.blogs.delete')->with('success', 'Xóa vĩnh viễn bài viết thành công!');
    }

    public function forceDeleteAll()
    {
        $blogs = Blog::onlyTrashed()->get();

        foreach ($blogs as $blog) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $blog->forceDelete();
        }

        return redirect()->route('admin.blogs.delete')->with('success', 'Đã xóa vĩnh viễn tất cả bài viết!');
    }
}

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
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
{
    $query = Blog::with(['category', 'user']);

    if ($request->filled('keyword')) {
        $query->where('title', 'like', '%' . $request->keyword . '%');
    }

    $blogs = $query->latest()->paginate(10);
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
            'content' => [
                'required',
                'string',
                'max:10000',
                function ($attribute, $value, $fail) {
                    if (preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $value)) {
                        $fail('Nội dung không hợp lệ – không được chứa mã script.');
                    }
                },
            ],
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:blog_categories,id',
            // 'user_id' => 'required|exists:users,id',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Nội dung là bắt buộc.',
            'content.max' => 'Nội dung không được vượt quá 10000 ký tự.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'image.image' => 'Ảnh không hợp lệ.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif, svg, webp.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
            'category_id.required' => 'Danh mục là bắt buộc.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            // 'user_id.required' => 'Tác giả là bắt buộc.',
            // 'user_id.exists' => 'Tác giả không hợp lệ.',
        ]);

        $data = $request->only(['title', 'content', 'slug', 'category_id', 'user_id']);

        // Gán user_id từ người dùng đang đăng nhập
        $data['user_id'] = Auth::id();

        // Chặn mã độc trong nội dung
        $data['content'] = strip_tags($data['content'], '<p><b><i><ul><ol><li><br><strong><em>');

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
            'content' => [
                'required',
                'string',
                'max:10000',
                function ($attribute, $value, $fail) {
                    if (preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $value)) {
                        $fail('Nội dung không hợp lệ – không được chứa mã script.');
                    }
                },
            ],
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required|exists:blog_categories,id',
            // 'user_id' => 'required|exists:users,id',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề bài viết.',
            'title.string' => 'Tiêu đề bài viết phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề bài viết không được vượt quá :max ký tự.',

            'content.required' => 'Vui lòng nhập nội dung bài viết.',
            'content.string' => 'Nội dung bài viết phải là chuỗi.',
            'content.max' => 'Nội dung bài viết không được vượt quá :max ký tự.',

            'slug.required' => 'Vui lòng nhập đường dẫn (slug).',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá :max ký tự.',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng chọn slug khác.',

            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg hoặc webp.',
            'image.max' => 'Hình ảnh không được vượt quá :max KB.',

            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',

            // 'user_id.required' => 'Vui lòng chọn tác giả.',
            // 'user_id.exists' => 'Tác giả đã chọn không hợp lệ.',
        ]);

        $blog = Blog::findOrFail($id);

        $data = $request->only(['title', 'content', 'slug', 'category_id', 'user_id']);

        // Chặn mã độc trong nội dung 
        $data['content'] = strip_tags($data['content'], '<p><b><i><ul><ol><li><br><strong><em>');

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

        // Nếu bài viết đang có danh mục liên kết thì không cho xóa
        // if (!empty($blog->category_id)) {
        //     return redirect()->route('admin.blogs.index')
        //         ->with('error', 'Không thể xóa bài viết đang được liên kết.');
        // }

        // Cho phép xóa bài viết nếu danh mục đã bị ẩn hoặc đã xóa mềm
        // if ($blog->category && ($blog->category->is_active == 1 || $blog->category->deleted_at != null)) {
        //     return redirect()->route('admin.blogs.index')
        //         ->with('error', 'Không thể xóa bài viết vì danh mục liên kết vẫn đang hoạt động.');
        // }

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

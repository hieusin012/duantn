<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    //
    // Hiển thị danh sách bình luận
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'product']);

        if ($keyword = $request->input('keyword')) {
            $query->where('content', 'like', "%{$keyword}%")
                ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                ->orWhereHas('product', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
        }

        $comments = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.comments.index', compact('comments'));
    }

    // Hiển thị form thêm bình luận
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.comments.create', compact('users', 'products'));
    }

    // Lưu bình luận mới
    public function store(Request $request)
    {
        $request->validate([
    'content' => 'required|string',
    'rating' => 'nullable|integer|min:1|max:5',
    'status' => 'required|boolean',
]);

Comment::create($request->only(['user_id', 'product_id', 'content', 'rating', 'status']));


        return redirect()->route('comments.index')->with('success', 'Đã thêm bình luận.');
    }

    // Hiển thị form chỉnh sửa
    public function edit(Comment $comment)
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.comments.edit', compact('comment', 'users', 'products'));
    }

    // Cập nhật bình luận
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|min:3',
        ]);

        $comment->update($request->only(['user_id', 'product_id', 'content']));

        return redirect()->route('comments.index')->with('success', 'Cập nhật thành công.');
    }

    // Xóa bình luận
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index')->with('success', 'Xóa bình luận thành công.');
    }
    public function storeClient(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'content' => 'required|string|min:3',
        'rating' => 'nullable|integer|min:1|max:5',
    ]);

    Comment::create([
        'user_id' => Auth::id(),
        'product_id' => $request->product_id,
        'content' => $request->content,
        'rating' => $request->rating,
        'status' => true, // nếu cần duyệt thì set false
    ]);

    return redirect()->back()->with('success', 'Bình luận đã được gửi.');
}
}
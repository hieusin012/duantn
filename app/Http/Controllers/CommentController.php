<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductComment;

class CommentController extends Controller
{
    // Danh sách + tìm kiếm + lọc trạng thái
    public function index(Request $request)
    {
        $keyword = $request->input('keyword') ?? $request->input('q');

        $comments = ProductComment::with(['user','product'])
            ->when($keyword, fn($q) => $q->where('content', 'like', '%'.$keyword.'%'))
            ->when($request->filled('status'), fn($q) => $q->where('status', (int)$request->status))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    // Toggle ẩn/hiện – KHÔNG cho sửa nội dung
    public function toggle(ProductComment $comment)
    {
        $new = $comment->status ? 0 : 1;
        $comment->update(['status' => $new]);

        return back()->with('success', $new ? 'Đã hiển thị bình luận.' : 'Đã ẩn bình luận.');
    }
}

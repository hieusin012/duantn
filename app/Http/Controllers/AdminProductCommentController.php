<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class AdminProductCommentController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $comments = ProductComment::query()
            ->with(['product:id,name', 'user:id,fullname,email'])
            ->when($keyword, fn($q) => $q->where('content', 'like', "%{$keyword}%"))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.product_comments.index', compact('comments', 'keyword'));
    }

    public function toggle(ProductComment $comment)
    {
        $comment->is_visible = ! $comment->is_visible;
        $comment->save();

        return response()->json([
            'success'    => true,
            'is_visible' => $comment->is_visible,
            'message'    => $comment->is_visible ? 'Đã hiển thị bình luận' : 'Đã ẩn bình luận',
        ]);
    }
}

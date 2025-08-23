<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductComment;
use Illuminate\Support\Facades\Auth;

class ProductCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:product_comments,id'
        ]);

        $comment = ProductComment::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment->load('user', 'replies')
        ]);
    }

    public function list($productId)
{
    $comments = ProductComment::where('product_id', $productId)
        ->visible() // chỉ lấy comment hiện
        ->whereNull('parent_id')
        ->with(['user', 'replies' => function ($q) {
            $q->visible()->with('user', 'replies');
        }])
        ->latest()
        ->limit(10)
        ->get();

    return response()->json($comments);
}
}

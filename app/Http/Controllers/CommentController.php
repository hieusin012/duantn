<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    //
    // Hiển thị danh sách đánh giá
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'product'])->orderByDesc('created_at');

        if ($search = $request->input('keyword')) {
            $query->where('content', 'like', '%' . $search . '%');
        }

        $comments = $query->paginate(10);

        return view('admin.comments.index', compact('comments'));
    }

    // Hiển thị form thêm đánh giá
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.comments.create', compact('users', 'products'));
    }

    // Lưu đánh giá mới
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|boolean',
        ], [
            'user_id.required' => 'Vui lòng chọn người dùng.',
            'user_id.exists' => 'Người dùng không tồn tại.',
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'content.required' => 'Nội dung đánh giá không được để trống.',
            'content.min' => 'Nội dung phải có ít nhất :min ký tự.',
            'content.max' => 'Nội dung không được vượt quá :max ký tự.',
            'rating.integer' => 'Đánh giá phải là một số.',
            'rating.min' => 'Đánh giá tối thiểu là :min sao.',
            'rating.max' => 'Đánh giá tối đa là :max sao.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        Comment::create($request->only(['user_id', 'product_id', 'content', 'rating', 'status']));


        return redirect()->route('admin.comments.index')->with('success', 'Đã thêm đánh giá.');
    }

    // Hiển thị form chỉnh sửa
    public function edit(Comment $comment)
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.comments.edit', compact('comment', 'users', 'products'));
    }

    // Cập nhật đánh giá
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|min:3',
            'rating' => 'nullable|integer|min:1|max:5',
            'status' => 'required|boolean',
        ], [
            'user_id.required' => 'Vui lòng chọn người dùng.',
            'user_id.exists' => 'Người dùng không tồn tại.',
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'content.required' => 'Nội dung đánh giá không được để trống.',
            'content.min' => 'Nội dung phải có ít nhất :min ký tự.',
            'content.max' => 'Nội dung không được vượt quá :max ký tự.',
            'rating.integer' => 'Đánh giá phải là một số.',
            'rating.min' => 'Đánh giá tối thiểu là :min sao.',
            'rating.max' => 'Đánh giá tối đa là :max sao.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái không hợp lệ.',
        ]);

        $comment->update($request->only(['user_id', 'product_id', 'content', 'rating', 'status']));

        return redirect()->route('admin.comments.index')->with('success', 'Cập nhật thành công.');
    }


    // Xóa đánh giá
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments.index')->with('success', 'Xóa đánh giá thành công.');
    }
    public function storeClient(Request $request, $variantId)
    {
        // $request->validate([
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|max:500|min:10|not_regex:/<script\b[^>]*>(.*?)<\/script>/i',
            'rating_' . $variantId => 'required|integer|min:1|max:5',
            'variant_id' => 'required|exists:product_variants,id',
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'content.required' => 'Vui lòng nhập nội dung đánh giá.',
            'content.min' => 'Nội dung đánh giá phải có ít nhất :min ký tự.',
            'content.max' => 'Nội dung đánh giá không được vượt quá :max ký tự.',
            'content.not_regex' => 'Nội dung không hợp lệ.',
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.integer' => 'Điểm đánh giá phải là một số.',
            'rating.min' => 'Điểm đánh giá tối thiểu là :min.',
            'rating.max' => 'Điểm đánh giá tối đa là :max.',
            'variant_id.required' => 'Vui lòng chọn biến thể sản phẩm.',
            'variant_id.exists' => 'Biến thể sản phẩm không tồn tại.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        Comment::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'variant_id' => $request->variant_id,
            'content' => $request->content,
            'rating' => $request->rating_ . $variantId,
            'status' => true, // nếu cần duyệt thì set false
        ]);
        

        // return redirect()->back()->with('success', 'Bình luận đã được gửi.');
        return response()->json([
            'success' => true,
            'message' => 'Đánh giá đã được gửi.'
        ]);
    }
}
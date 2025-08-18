<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ReturnRequestController extends Controller
{
    public function index()
    {
        $requests = ReturnRequest::where('user_id', Auth::id())
                                 ->with('order')
                                 ->latest()
                                 ->paginate(5);
        return view('clients.return_requests.index', compact('requests'));
    }

    public function create($orderId)
    {
        $order = Order::where('id', $orderId)
                    ->where('user_id', Auth::id())
                    ->where('status', 'Đã giao hàng') // Chỉ cho phép đơn đã giao hàng
                    ->firstOrFail();

        // Kiểm tra đã gửi yêu cầu chưa
        $existing = ReturnRequest::where('order_id', $order->id)
                    ->where('user_id', Auth::id())
                    ->first();

        if ($existing) {
            return redirect()->route('client.return-requests.index')->with('error', 'Bạn đã gửi yêu cầu trả hàng cho đơn này.');
        }

        return view('clients.return_requests.create', compact('order'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'order_id'        => 'required|exists:orders,id',
            'reason'          => 'required|string|max:1000',
            'refund_method'   => 'required|string|in:bank_transfer,wallet',
            'bank_account'    => 'required_if:refund_method,bank_transfer|max:255',
            'wallet_info'     => 'required_if:refund_method,wallet|max:255',
            'image'           => 'required|image|max:2048',
        ], [
            'order_id.required'        => 'Vui lòng chọn đơn hàng.',
            'order_id.exists'          => 'Đơn hàng không tồn tại.',
            'reason.required'          => 'Vui lòng nhập lý do trả hàng.',
            'reason.max'               => 'Lý do không được vượt quá 1000 ký tự.',
            'refund_method.required'   => 'Vui lòng chọn phương thức hoàn tiền.',
            'refund_method.in'         => 'Phương thức hoàn tiền không hợp lệ.',
            'bank_account.required_if' => 'Vui lòng nhập số tài khoản ngân hàng.',
            'wallet_info.required_if'  => 'Vui lòng nhập thông tin ví điện tử.',
            'image.required'           => 'Vui lòng tải lên ảnh minh chứng.',
            'image.image'              => 'Tệp tải lên phải là hình ảnh.',
            'image.max'                => 'Ảnh minh chứng không được vượt quá 2MB.',
        ]);


        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('return_images', 'public');
        }

        ReturnRequest::create([
            'order_id'      => $request->order_id,
            'user_id'       => Auth::id(),
            'reason'        => $request->reason,
            'status'        => 'pending',
            'refund_method' => $request->refund_method,
            'bank_account'  => $request->bank_account,
            'wallet_info'   => $request->wallet_info,
            'image'         => $imagePath,
        ]);

        return redirect()->route('client.return-requests.index')->with('success', 'Gửi yêu cầu trả hàng thành công.');
    }
    public function getStatus($id)
    {
        $request = ReturnRequest::where('id', $id)
            ->where('user_id', Auth::id()) // đảm bảo chỉ xem được của chính mình
            ->firstOrFail();

        return response()->json([
            'status' => $request->status,
            'admin_note' => $request->admin_note
        ]);
    }

}

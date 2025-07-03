<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ClientOrderController extends Controller
{
    // Hiển thị danh sách đơn hàng của người dùng
    public function orderHistory()
    {
        $orders = Order::with('orderDetails.variant.product')

            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('clients.order_history', compact('orders'));
    }

    // Hiển thị chi tiết một đơn hàng
    public function orderDetail($id)
    {
        $order = Order::with('orderDetails.variant.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('clients.order_detail', compact('order'));
    }
}

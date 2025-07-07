<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function reorder($id)
    {
        $order = Order::with('orderDetails.variant.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Lấy hoặc tạo giỏ hàng active
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status' => 'active'
        ]);

        foreach ($order->orderDetails as $item) {
            if ($item->variant && $item->variant->product) {
                $existingItem = $cart->items()
                    ->where('product_id', $item->variant->product_id)
                    ->where('variant_id', $item->variant_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->increment('quantity', $item->quantity);
                } else {
                    $cart->items()->create([
                        'product_id' => $item->variant->product_id,
                        'variant_id' => $item->variant_id,
                        'quantity' => $item->quantity,
                        'price_at_purchase' => $item->price,
                    ]);
                }
            }
        }

        return redirect()->route('client.cart')->with('success', 'Sản phẩm đã được thêm lại vào giỏ hàng.');
    }

}

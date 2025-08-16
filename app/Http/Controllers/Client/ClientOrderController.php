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
            ->paginate(5);

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

    // public function reorder($id)
    // {
    //     $order = Order::with('orderDetails.variant.product')
    //         ->where('id', $id)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();

    //     // Lấy hoặc tạo giỏ hàng active
    //     $cart = Cart::firstOrCreate([
    //         'user_id' => Auth::id(),
    //         'status' => 'active'
    //     ]);

    //     foreach ($order->orderDetails as $item) {
    //         if ($item->variant && $item->variant->product) {
    //             $existingItem = $cart->items()
    //                 ->where('product_id', $item->variant->product_id)
    //                 ->where('variant_id', $item->variant_id)
    //                 ->first();

    //             if ($existingItem) {
    //                 $existingItem->increment('quantity', $item->quantity);
    //             } else {
    //                 $cart->items()->create([
    //                     'product_id' => $item->variant->product_id,
    //                     'variant_id' => $item->variant_id,
    //                     'quantity' => $item->quantity,
    //                     'price_at_purchase' => $item->price,
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->route('client.cart')->with('success', 'Sản phẩm đã được thêm lại vào giỏ hàng.');
    // }


    public function reorder($id)
    {
        $order = Order::with('orderDetails.variant.product')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'status' => 'active'
        ]);

        $unavailableProducts = [];

        foreach ($order->orderDetails as $item) {
            $variant = $item->variant;
            $product = $variant?->product;

            // Kiểm tra: sản phẩm hoặc biến thể đã bị xóa hoặc không còn bán
            if (!$variant || !$product || !$product->is_active) {
                $unavailableProducts[] = $product?->name ?? 'Sản phẩm không xác định';
                continue;
            }

            // Kiểm tra item đã tồn tại trong giỏ chưa
            $existingItem = $cart->items()
                ->where('product_id', $variant->product_id)
                ->where('variant_id', $variant->id)
                ->first();

            if ($existingItem) {
                $existingItem->increment('quantity', $item->quantity);
            } else {
                $cart->items()->create([
                    'product_id' => $variant->product_id,
                    'variant_id' => $variant->id,
                    'quantity' => $item->quantity,
                    'price_at_purchase' => $item->price,
                ]);
            }
        }

        // Xử lý phản hồi
        if (!empty($unavailableProducts)) {
            return redirect()->route('client.cart')->with('warning', 'Một số sản phẩm không còn bán: ' . implode(', ', $unavailableProducts));
        }

        return redirect()->route('client.cart')->with('success', 'Sản phẩm đã được thêm lại vào giỏ hàng.');
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_note' => 'nullable|string|max:1000',
        ]);

        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'Chờ xác nhận')
            ->firstOrFail();

        $order->status = 'Đơn hàng đã hủy';
        $order->cancel_reason = $request->cancel_reason;
        $order->cancel_note = $request->cancel_note;
        $order->save();

        return redirect()->route('order.history')->with('success', 'Đơn hàng đã được hủy.');
    }
    // Thêm method mới
    public function getStatus($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'status' => $order->status,
            'payment_status' => $order->payment_status
        ]);
    }
}

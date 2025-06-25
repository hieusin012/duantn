<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class ApplyVoucherController extends Controller
{
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string|max:255',
        ]);

        $voucher = Voucher::where('code', $request->voucher_code)->first();

        if (!$voucher) {
            return response()->json(['message' => 'Mã giảm giá không tồn tại'], 404);
        }

        if ($voucher->isExpired()) {
            return response()->json(['message' => 'Mã giảm giá đã hết hạn'], 400);
        }

        $cart = Cart::with('items')->where('user_id', Auth::id())->where('status', 0)->first();

        if (!$cart) {
            return response()->json(['message' => 'Giỏ hàng không tồn tại'], 404);
        }

        $cart->applyVoucher($voucher); // đã có hàm này rồi

        // Tính tổng giá
        $total = $cart->items->sum(fn($i) => $i->price_at_purchase * $i->quantity);

        $discount = $voucher->type === 'percent'
            ? $total * $voucher->discount / 100
            : $voucher->discount;

        $totalAfterDiscount = max(0, $total - $discount);

        return response()->json([
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount' => round($discount),
            'total' => round($total),
            'total_after_discount' => round($totalAfterDiscount)
        ]);
    }
}

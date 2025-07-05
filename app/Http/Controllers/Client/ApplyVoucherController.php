<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Voucher; // Đảm bảo import Voucher Model
use App\Models\Cart;    // Đảm bảo import Cart Model

class ApplyVoucherController extends Controller
{
    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string|max:255',
        ]);

        $code = $request->input('voucher_code');
        $voucher = Voucher::where('code', $code)->first();

        // 1. Kiểm tra voucher tồn tại
        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại.'], 404);
        }

        // 2. Sử dụng phương thức isValid() từ Model Voucher để kiểm tra toàn diện
        if (!$voucher->isValid()) {
            // Cung cấp thông báo cụ thể hơn nếu muốn
            $message = 'Mã giảm giá không hợp lệ hoặc đã hết hạn.';
            if ($voucher->isExpired()) {
                $message = 'Mã giảm giá đã hết hạn.';
            } elseif (!$voucher->is_active) {
                $message = 'Mã giảm giá không hoạt động.';
            } elseif ($voucher->quantity <= $voucher->used) { // Kiểm tra số lượng đã dùng
                $message = 'Mã giảm giá đã hết lượt sử dụng.';
            } elseif ($voucher->start_date && now()->lt($voucher->start_date)) { // Kiểm tra ngày bắt đầu
                $message = 'Mã giảm giá chưa đến ngày áp dụng.';
            }
            return response()->json(['success' => false, 'message' => $message], 400);
        }

        $userId = Auth::id();
        // 3. Tìm giỏ hàng với status 'active' (đã thống nhất)
        $cart = Cart::with('items')->where('user_id', $userId)->where('status', 'active')->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy giỏ hàng hoạt động.'], 404);
        }

        // Tính tổng tiền hiện tại của giỏ hàng (subtotal)
        $cartSubtotal = $cart->items->sum(function($item) {
            return $item->price_at_purchase * $item->quantity;
        });

        // 4. Tính toán số tiền giảm giá chính xác
        $discountAmount = 0;
        if ($voucher->discount_type === 'fixed') { // Sử dụng discount_type từ Model
            $discountAmount = $voucher->discount;
        } elseif ($voucher->discount_type === 'percent') { // Sử dụng discount_type từ Model
            $discountAmount = ($cartSubtotal * $voucher->discount) / 100;
        }

        // 5. Áp dụng giới hạn giảm giá tối đa nếu có max_price
        if ($voucher->max_price && $discountAmount > $voucher->max_price) {
            $discountAmount = $voucher->max_price;
        }

        // Đảm bảo giảm giá không làm tổng tiền âm
        $discountAmount = min($discountAmount, $cartSubtotal);

        // Áp dụng voucher vào giỏ hàng (lưu voucher_id)
        $cart->voucher_id = $voucher->id;
        $cart->save();

        // **Lưu ý quan trọng:** Không tăng $voucher->used ở đây để tránh trùng lặp nếu nó cũng được tăng trong CheckoutController.
        // Chỉ nên tăng khi đơn hàng thực sự được xác nhận và tạo thành công (tốt nhất là trong CheckoutController).

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount' => round($discountAmount),
            'total_after_discount' => round($cartSubtotal - $discountAmount)
        ]);
    }
}
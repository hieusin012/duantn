<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Voucher; // Đảm bảo import Voucher Model
use App\Models\Cart;    // Đảm bảo import Cart Model
use Carbon\Carbon;

class ApplyVoucherController extends Controller
{
    public function applyVoucher(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'code' => 'required|string'
        ]);

        $voucher = Voucher::where('code', $request->code)
            ->where('is_active', 1)
            ->where('quantity', '>', 0)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>=', Carbon::now())
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Mã không hợp lệ hoặc đã hết hạn!'
            ]);
        }

        // ✅ Kiểm tra user đã dùng chưa
        if ($voucher->users()->where('user_id', $userId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng mã giảm giá này rồi!'
            ]);
        }

        // ✅ Kiểm tra số lượt còn lại
        if ($voucher->used >= $voucher->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher đã hết lượt sử dụng!'
            ]);
        }

        // Giả sử tổng tiền từ frontend gửi lên
        $cartTotal = (int) $request->cart_total;

        // Tính tiền giảm
        $discount = $voucher->discount_type === 'percent'
            ? $cartTotal * ($voucher->discount / 100)
            : $voucher->discount;

        // Giới hạn giảm tối đa
        if ($voucher->max_price && $discount > $voucher->max_price) {
            $discount = $voucher->max_price;
        }

        $newTotal = max($cartTotal - $discount, 0);


        return response()->json([
            'success' => true,
            'discount' => $discount,
            'discount_display' => number_format($discount, 0, ',', '.') . ' ₫',
            'total_display' => number_format($newTotal, 0, ',', '.') . ' ₫',
        ]);
    }
}

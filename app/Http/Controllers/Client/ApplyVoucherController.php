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

        // Giả sử tổng tiền từ frontend gửi lên (hoặc tự tính)
        $cartTotal = (int) $request->cart_total;

        // Tính tiền giảm
        if ($voucher->discount_type === 'percent') {
            $discount = $cartTotal * ($voucher->discount / 100);
        } else {
            $discount = $voucher->discount;
        }

        // Áp dụng giới hạn giảm tối đa
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
        return redirect()->route('client.cart.index')->with('success', 'Áp dụng mã thành công!');
    }
}
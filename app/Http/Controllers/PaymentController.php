<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{

    public function vnpayReturn(Request $request)
    {
        // 1. Lấy ra hash secret từ .env
        $vnp_HashSecret = env('VNP_HASHSECRET');

        // 2. Lấy toàn bộ tham số trả về từ VNPay
        $vnpData = $request->all();

        // 3. Lưu lại hash nhận được từ VNPay
        $vnp_SecureHash = $vnpData['vnp_SecureHash'] ?? '';

        // 4. Xoá hash khỏi mảng để tạo lại chữ ký mới
        unset($vnpData['vnp_SecureHash']);
        unset($vnpData['vnp_SecureHashType']);

        // 5. Sắp xếp theo key
        ksort($vnpData);

        // 6. Tạo chuỗi hash data (không urlencode!!!)
        $hashData = collect($vnpData)->map(function ($value, $key) {
            return "$key=$value";
        })->implode('&');

        // 7. Tạo hash để kiểm tra chữ ký
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // 8. So sánh hash
        if ($secureHash === $vnp_SecureHash) {
            if ($vnpData['vnp_ResponseCode'] === '00') {
                return "✅ Thanh toán thành công!";
            } else {
                return "❌ Thanh toán thất bại!";
            }
        } else {
            // 🐞 Debug
            Log::error("Hash mismatch", [
                'hashData' => $hashData,
                'myHash' => $secureHash,
                'vnpHash' => $vnp_SecureHash,
            ]);
            return "🚫 Chữ ký không hợp lệ!";
        }
    }
}

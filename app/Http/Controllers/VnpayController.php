<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\ProductVariant;

class VnpayController extends Controller
{
    public function redirectToVNPAY(Request $request)
    {
        $orderData = session('pending_order');

        if (!$orderData || !isset($orderData['total'])) {
            return redirect()->route('client.cart')->with('error', 'Không tìm thấy thông tin đơn hàng VNPay.');
        }

        $vnp_TmnCode = Config::get('services.vnpay.tmn_code');
        $vnp_HashSecret = Config::get('services.vnpay.hash_secret');
        $vnp_Url = Config::get('services.vnpay.url');
        $vnp_ReturnUrl = Config::get('services.vnpay.return_url');

        $vnp_TxnRef = strtoupper(Str::random(10));
        $vnp_OrderInfo = 'Thanh toán đơn hàng trên website';
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $orderData['total'] * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        // Sort and create query
        ksort($inputData);
        $hashdata = "";
        $query = [];

        foreach ($inputData as $key => $value) {
            $hashdata .= $key . "=" . $value . "&";
            $query[] = urlencode($key) . "=" . urlencode($value);
        }

        $hashdata = rtrim($hashdata, "&");
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= "?" . implode("&", $query) . "&vnp_SecureHash=" . $vnp_SecureHash;

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $orderData = session('pending_order');
        $cartId = $orderData['cart_id'] ?? null;

        if (!$orderData || !$cartId) {
            return redirect()->route('client.cart')->with('error', 'Không tìm thấy thông tin đơn hàng sau khi thanh toán.');
        }

        // Verify hash
        $input = $request->all();
        $vnp_HashSecret = Config::get('services.vnpay.hash_secret');
        $secureHash = $input['vnp_SecureHash'];
        unset($input['vnp_SecureHash'], $input['vnp_SecureHashType']);

        ksort($input);
        $data = "";
        foreach ($input as $key => $value) {
            $data .= $key . "=" . $value . "&";
        }
        $data = rtrim($data, "&");
        $calculatedHash = hash_hmac('sha512', $data, $vnp_HashSecret);

        // Nếu thanh toán thành công
        if ($secureHash === $calculatedHash && $request->vnp_ResponseCode == '00') {
            DB::beginTransaction();
            try {
                $cart = Cart::with('items.variant.color', 'items.variant.size', 'voucher')->find($cartId);

                if (!$cart || $cart->status !== 'active') {
                    throw new \Exception('Không tìm thấy giỏ hàng hợp lệ.');
                }

                $userId = Auth::id();
                $cartItems = $cart->items;
                $subtotal = $orderData['subtotal'];
                $discount = $orderData['discount'];
                $shipping = $orderData['shipping'];
                $tax = $orderData['tax'];
                $finalTotalPrice = $orderData['total'];

                // Tạo đơn hàng
                $order = Order::create([
                    'user_id' => $userId,
                    'code' => 'ORD-' . Str::upper(Str::random(8)),
                    'fullname' => $orderData['fullname'],
                    'phone' => $orderData['phone'],
                    'address' => $orderData['address'],
                    'email' => $orderData['email'],
                    'payment' => 'Thanh toán qua VNPay',
                    'status' => 'Chờ xác nhận',
                    'payment_status' => 'Đã thanh toán',
                    'shiping' => $shipping,
                    'discount' => $discount,
                    'total_price' => $finalTotalPrice,
                    'note' => $orderData['note'] ?? null,
                    'voucher_id' => $orderData['voucher_id'] ?? null,
                ]);

                foreach ($cartItems as $item) {
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'variant_id' => $item->variant_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price_at_purchase,
                        'total_price' => $item->price_at_purchase * $item->quantity,
                    ]);

                    $variant = ProductVariant::find($item->variant_id);
                    if ($variant) {
                        $variant->quantity -= $item->quantity;
                        $variant->save();
                    }
                }

                // Dọn giỏ hàng
                $cart->items()->delete();
                $cart->update(['status' => 'inactive']);

                Session::forget('pending_order');
                DB::commit();

                return redirect()->route('checkout.success', ['order' => $order->code])
                                 ->with('success', 'Thanh toán VNPay thành công! Mã đơn hàng: ' . $order->code);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('VNPAY RETURN ERROR: ' . $e->getMessage());
                return redirect()->route('client.cart')->with('error', 'Đã thanh toán thành công nhưng không thể tạo đơn. Vui lòng liên hệ quản trị viên.');
            }
        }

        // Trường hợp thất bại
        return redirect()->route('client.cart')->with('error', 'Thanh toán VNPay thất bại hoặc bị hủy.');
    }
}

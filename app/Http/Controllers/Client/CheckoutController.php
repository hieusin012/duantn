<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Voucher; // THÊM DÒNG NÀY
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;


class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thanh toán với thông tin giỏ hàng.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showCheckoutForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
        }

        $userId = Auth::id();
        // Tải luôn mối quan hệ voucher nếu có
        $cart = Cart::with('voucher')->where('user_id', $userId)->where('status', 'active')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $cartItems = $cart->items()->with('product', 'variant.color', 'variant.size')->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price_at_purchase * $item->quantity;
        }

        $shippingCost = 0;
        $tax = 10;
        $discount = 0; // Khởi tạo giảm giá bằng 0

        // Tính toán giảm giá từ voucher nếu có
        if ($cart->voucher && $cart->voucher->isValid()) {
            $voucher = $cart->voucher;
            if ($voucher->discount_type === 'fixed') {
                $discount = $voucher->discount;
            } elseif ($voucher->discount_type === 'percent') {
                $discount = ($subtotal * $voucher->discount) / 100;
            }

            // Giới hạn giảm giá tối đa
            if ($voucher->max_price && $discount > $voucher->max_price) {
                $discount = $voucher->max_price;
            }
        }

        $totalPrice = $subtotal + $shippingCost + $tax - $discount;

        return view('clients.checkout', compact('cart', 'cartItems', 'subtotal', 'shippingCost', 'tax', 'discount', 'totalPrice')); // Đã sửa tên view
    }


    /**
     * Xử lý thông tin đặt hàng từ form thanh toán.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function processCheckout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
        }

        $userId = Auth::id();
        $cart = Cart::with('voucher')->where('user_id', $userId)->where('status', 'active')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $validatedData = $request->validate([
            'fullname' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:199',
            'email' => 'required|email|max:199',
            'payment' => 'required|in:Thanh toán khi nhận hàng,Thanh toán bằng thẻ,Thanh toán qua VNPay,Thanh toán bằng mã QR',
            'note' => 'nullable|string',
            'agree_terms' => 'accepted',
        ]);

        DB::beginTransaction();
        try {
            $cartItems = $cart->items()->with('product', 'variant')->get();
            $subtotal = 0;

            foreach ($cartItems as $item) {
                if (!$item->variant || $item->variant->quantity < $item->quantity) {
                    DB::rollBack();
                    $variantInfo = '';
                    if ($item->variant) {
                        $variantInfo = ' (' . ($item->variant->color->name ?? 'N/A') . ' - ' . ($item->variant->size->name ?? 'N/A') . ')';
                    }
                    return redirect()->route('client.cart')->with('error', 'Sản phẩm "' . ($item->product->name ?? 'N/A') . $variantInfo . '" không đủ số lượng trong kho. Vui lòng kiểm tra lại giỏ hàng.');
                }
                $subtotal += $item->price_at_purchase * $item->quantity;
            }

            $shippingCost = 0;
            $tax = 10;
            $discount = 0;

            if ($cart->voucher && $cart->voucher->isValid()) {
                $voucher = $cart->voucher;
                if ($voucher->discount_type === 'fixed') {
                    $discount = $voucher->discount;
                } elseif ($voucher->discount_type === 'percent') {
                    $discount = ($subtotal * $voucher->discount) / 100;
                }
                if ($voucher->max_price && $discount > $voucher->max_price) {
                    $discount = $voucher->max_price;
                }
            }

            $finalTotalPrice = $subtotal + $shippingCost + $tax - $discount;

            $order = Order::create([
                'user_id' => $userId,
                'code' => 'ORD' . strtoupper(Str::random(8)),
                'fullname' => $validatedData['fullname'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
                'payment' => $validatedData['payment'],
                'status' => 'Chờ xác nhận',
                'payment_status' => 'Chưa thanh toán',
                'shiping' => $shippingCost,
                'discount' => $discount,
                'total_price' => $finalTotalPrice,
                'note' => $validatedData['note'] ?? null,
                'voucher_id' => $cart->voucher_id,
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

            $cart->items()->delete();
            $cart->update(['status' => 'inactive']);

            DB::commit();

            if ($validatedData['payment'] === 'Thanh toán qua VNPay') {
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                $vnp_Returnurl = "http://127.0.0.1:8000/vnpay-return";
                $vnp_TmnCode = "PTCDRZQD"; //Mã website tại VNPAY 
                $vnp_HashSecret = "MJC8R1W7KOJOWN6KNTHT7I6P5QV4RZ6I"; //Chuỗi bí mật
                $vnp_TxnRef = $order->code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                $vnp_OrderInfo = "Thanh toán hóa đơn";
                $vnp_OrderType = "Shop quàn áo";
                $vnp_Amount = $order->total_price * 100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = "NCB";
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

                $inputData = array(
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
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,

                );

                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
                    $inputData['vnp_Bill_State'] = $vnp_Bill_State;
                }

                //var_dump($inputData);
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array(
                    'code' => '00',
                    'message' => 'success',
                    'data' => $vnp_Url
                );
                if (isset($_POST['redirect'])) {
                    header('Location: ' . $vnp_Url);
                    die();
                } else {
                    return redirect($vnp_Url);
                }
            }
            if ($validatedData['payment'] === 'Thanh toán khi nhận hàng') {
                Mail::to($validatedData['email'])->send(new OrderPlacedMail($order));
                return redirect()->route('checkout.success', ['order' => $order->code])
                ->with('success', 'Đơn hàng của bạn đã được đặt thành công! Mã đơn hàng: ' . $order->code);
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại. ' . $e->getMessage());
        }
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = "MJC8R1W7KOJOWN6KNTHT7I6P5QV4RZ6I";

        $vnpData = [];
        foreach ($request->query() as $key => $value) {
            if (substr($key, 0, 4) === 'vnp_') {
                $vnpData[$key] = $value;
            }
        }

        $vnp_SecureHash = $vnpData['vnp_SecureHash'];
        unset($vnpData['vnp_SecureHash']);
        unset($vnpData['vnp_SecureHashType']);

        // ✅ Hash theo đúng thứ tự và format như bên gửi đi
        ksort($vnpData);
        $hashData = '';
        $first = true;
        foreach ($vnpData as $key => $value) {
            if ($first) {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $first = false;
            } else {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        if ($secureHash === $vnp_SecureHash) {
            // ✅ Lấy thông tin đơn hàng
            $orderCode = $vnpData['vnp_TxnRef'];
            $order = Order::where('code', $orderCode)->first();

            if ($order && $vnpData['vnp_ResponseCode'] === '00' && $vnpData['vnp_TransactionStatus'] === '00') {
                // ✅ Cập nhật đơn hàng
                $order->payment_status = 'Đã thanh toán';
                $order->status = 'Đã xác nhận'; // Hoặc giữ nguyên logic của anh
                $order->save();
                Mail::to($order->email)->send(new OrderPlacedMail($order));

                // ✅ Lưu thông tin thanh toán
                Payment::create([
                    'order_code' => $orderCode,
                    'transaction_no' => $vnpData['vnp_TransactionNo'] ?? null,
                    'bank_code' => $vnpData['vnp_BankCode'] ?? null,
                    'card_type' => $vnpData['vnp_CardType'] ?? null,
                    'amount' => ($vnpData['vnp_Amount'] ?? 0) / 100,
                    'pay_date' => $vnpData['vnp_PayDate'] ?? null,
                    'response_code' => $vnpData['vnp_ResponseCode'] ?? null,
                    'transaction_status' => $vnpData['vnp_TransactionStatus'] ?? null,
                ]);

                return redirect()->route('checkout.success', ['order' => $order->code])
                    ->with('success', 'Bạn đã thanh toán đơn hàng thành công!');;
            }

            return redirect('/cart')->with('error', 'Giao dịch không hợp lệ hoặc đơn hàng không tồn tại!');
        } else {
            return redirect('/cart')->with('error', 'Chữ ký không hợp lệ!');
        }
    }


    /**
     * Hiển thị trang đặt hàng thành công.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\View\View
     */
    public function success(Order $order)
    {
        // Tải các mối quan hệ cần thiết để hiển thị chi tiết đơn hàng
        // THÊM 'voucher' vào danh sách load
        $order->load('orderDetails.variant.product', 'orderDetails.variant.color', 'orderDetails.variant.size', 'voucher');
        return view('clients.checkout_success', compact('order'));
    }
}

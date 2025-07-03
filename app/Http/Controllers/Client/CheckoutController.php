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
        // Tải luôn mối quan hệ voucher nếu có
        $cart = Cart::with('voucher')->where('user_id', $userId)->where('status', 'active')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $validatedData = $request->validate([
            'fullname' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:199',
            'email' => 'required|email|max:199',
            'payment' => 'required|in:Thanh toán khi nhận hàng,Thanh toán bằng thẻ,Thanh toán qua VNPay',
            'note' => 'nullable|string',
            'agree_terms' => 'accepted',
        ], [
            'fullname.required' => 'Họ và tên là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'payment.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment.in' => 'Phương thức thanh toán không hợp lệ.',
            'agree_terms.accepted' => 'Bạn phải đồng ý với các điều khoản và điều kiện.',
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

                // Tăng số lần đã sử dụng của voucher (nếu chưa tăng trong ApplyVoucherController)
                // Lưu ý: Nếu bạn đã tăng trong ApplyVoucherController, có thể bỏ qua bước này để tránh trùng lặp
                // $voucher->increment('used');
            }

            $finalTotalPrice = $subtotal + $shippingCost + $tax - $discount;

            // Tạo đơn hàng chính (Order)
            $order = Order::create([
                'user_id' => $userId,
                'code' => 'ORD-' . Str::upper(Str::random(8)),
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
                'voucher_id' => $cart->voucher_id, // THÊM DÒNG NÀY ĐỂ LƯU VOUCHER_ID
            ]);

            // Tạo chi tiết đơn hàng (Order Details) và cập nhật số lượng tồn kho
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price_at_purchase,
                    'total_price' => $item->price_at_purchase * $item->quantity,
                ]);

                // Giảm số lượng tồn kho của biến thể sản phẩm
                $variant = ProductVariant::find($item->variant_id);
                if ($variant) {
                    $variant->quantity -= $item->quantity;
                    $variant->save();
                }
            }

            // Xóa các mặt hàng trong giỏ hàng và đánh dấu giỏ hàng là không hoạt động
            $cart->items()->delete();
            $cart->update(['status' => 'inactive']);

            DB::commit();

            return redirect()->route('checkout.success', ['order' => $order->code])->with('success', 'Đơn hàng của bạn đã được đặt thành công! Mã đơn hàng: ' . $order->code);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại. ' . $e->getMessage());
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

<?php

namespace App\Http\Controllers\Client; // Đảm bảo namespace này là đúng

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


class CheckoutController extends Controller
{
    /**
     * Hiển thị trang thanh toán với thông tin giỏ hàng.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showCheckoutForm()
    {
        // Đảm bảo người dùng đã đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
        }

        $userId = Auth::id();
        // Tìm giỏ hàng của người dùng với status 'active'
        $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();

        // Nếu không tìm thấy giỏ hàng hoặc giỏ hàng trống
        if (!$cart || $cart->items->isEmpty()) { // Sửa cartItems() thành items()
            return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống.'); // Đã sửa tên route
        }

        // Lấy các mặt hàng trong giỏ hàng kèm thông tin sản phẩm, biến thể, màu sắc, kích thước
        // Sử dụng mối quan hệ 'items' đã định nghĩa trong Cart Model
        $cartItems = $cart->items()->with('product', 'variant.color', 'variant.size')->get();

        // Tính toán tổng tiền sản phẩm (subtotal)
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price_at_purchase * $item->quantity;
        }

        // Các chi phí khác (phí vận chuyển, thuế, giảm giá)
        $shippingCost = 0; // 'FREE SHIPPING'
        $tax = 10; // '$10.00'
        $discount = 0; // Giả sử chưa có mã giảm giá được áp dụng

        $totalPrice = $subtotal + $shippingCost + $tax - $discount;

        // Truyền dữ liệu sang view
        return view('clients.checkout', compact('cart', 'cartItems', 'subtotal', 'shippingCost', 'tax', 'discount', 'totalPrice'));
    }


    /**
     * Xử lý thông tin đặt hàng từ form thanh toán.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processCheckout(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
        }

        $userId = Auth::id();
        // Lấy giỏ hàng của người dùng đang hoạt động
        $cart = Cart::where('user_id', $userId)->where('status', 'active')->first();

        // Nếu không có giỏ hàng hoặc giỏ hàng trống
        if (!$cart || $cart->items->isEmpty()) { // Sửa cartItems() thành items()
            return redirect()->route('client.cart')->with('error', 'Giỏ hàng của bạn đang trống.'); // Đã sửa tên route
        }

        // Xác thực dữ liệu người dùng gửi lên
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:199',
            'email' => 'required|email|max:199',
            'payment' => 'required|in:Thanh toán khi nhận hàng,Thanh toán bằng thẻ,Thanh toán qua VNPay',
            'note' => 'nullable|string',
            'agree_terms' => 'accepted', // Yêu cầu đồng ý điều khoản
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

        // Bắt đầu một transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::beginTransaction();
        try {
            // Lấy các mặt hàng trong giỏ hàng để xử lý
            $cartItems = $cart->items()->with('product', 'variant')->get(); // Sửa cartItems() thành items()

            $subtotal = 0;
            foreach ($cartItems as $item) {
                // Kiểm tra số lượng tồn kho trước khi tạo đơn hàng
                if (!$item->variant || $item->variant->quantity < $item->quantity) {
                    DB::rollBack();
                    // Thêm thông tin biến thể cụ thể vào thông báo lỗi
                    $variantInfo = '';
                    if ($item->variant) {
                        $variantInfo = ' (' . ($item->variant->color->name ?? 'N/A') . ' - ' . ($item->variant->size->name ?? 'N/A') . ')';
                    }
                    return redirect()->route('client.cart')->with('error', 'Sản phẩm "' . ($item->product->name ?? 'N/A') . $variantInfo . '" không đủ số lượng trong kho. Vui lòng kiểm tra lại giỏ hàng.'); // Đã sửa tên route
                }
                $subtotal += $item->price_at_purchase * $item->quantity;
            }

            $shippingCost = 0; // Miễn phí vận chuyển
            $tax = 10; // Thuế 10.00
            $discount = 0; // Giả sử chưa có mã giảm giá

            $finalTotalPrice = $subtotal + $shippingCost + $tax - $discount;

            // 1. Tạo đơn hàng chính (Order)
            $order = Order::create([
                'user_id' => $userId,
                'code' => 'ORD-' . Str::upper(Str::random(8)), // Tạo mã đơn hàng duy nhất
                'fullname' => $validatedData['fullname'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'email' => $validatedData['email'],
                'payment' => $validatedData['payment'],
                'status' => 'Chờ xác nhận', // Trạng thái ban đầu
                'payment_status' => 'Chưa thanh toán', // Trạng thái thanh toán ban đầu
                'shiping' => $shippingCost,
                'discount' => $discount,
                'total_price' => $finalTotalPrice,
                'note' => $validatedData['note'] ?? null,
            ]);

            // 2. Tạo chi tiết đơn hàng (Order Details) và cập nhật số lượng tồn kho
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price_at_purchase, // Giá tại thời điểm mua hàng
                    'total_price' => $item->price_at_purchase * $item->quantity,
                ]);

                // Giảm số lượng tồn kho của biến thể sản phẩm
                $variant = ProductVariant::find($item->variant_id);
                if ($variant) {
                    $variant->quantity -= $item->quantity;
                    $variant->save();
                }
            }

            // 3. Xóa các mặt hàng trong giỏ hàng và đánh dấu giỏ hàng là không hoạt động
            $cart->items()->delete(); // Sửa cartItems() thành items()
            $cart->update(['status' => 'inactive']); // Đánh dấu giỏ hàng không còn hoạt động

            DB::commit(); // Hoàn tất transaction

            // Chuyển hướng đến trang thông báo đặt hàng thành công
            return redirect()->route('checkout.success', ['order' => $order->code])->with('success', 'Đơn hàng của bạn đã được đặt thành công! Mã đơn hàng: ' . $order->code);
        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu có lỗi
            Log::error('Checkout failed: ' . $e->getMessage(), ['exception' => $e]); // Ghi log lỗi
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
        $order->load('orderDetails.variant.product', 'orderDetails.variant.color', 'orderDetails.variant.size');
        return view('clients.checkout_success', compact('order'));
    }
}

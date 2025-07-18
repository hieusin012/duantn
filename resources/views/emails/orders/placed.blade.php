@component('mail::message')
<style>
    .order-box {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
    }

    .order-box h2 {
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .order-box p {
        margin: 6px 0;
    }
</style>

<h1 style="font-size: 24px;">🛒 Xác nhận đơn hàng thành công!</h1>

<p>Xin chào <strong>{{ $order->fullname }}</strong>,</p>
<p>Cảm ơn bạn đã đặt hàng tại <strong>{{ config('app.name') }}</strong>!</p>

<div class="order-box">
    <h2>📦 Thông tin đơn hàng:</h2>
    <p><strong>Mã đơn hàng:</strong> {{ $order->code }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p>
    <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Thanh toán:</strong> {{ ucfirst($order->payment_status) }}</p>
</div>

@component('mail::button', ['url' => url('/checkout/success/'.$order->code)])
Xem chi tiết đơn hàng
@endcomponent

<p>Trân trọng,</p>
<p><strong>SportBay</strong></p>
@endcomponent
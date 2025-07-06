<x-mail::message>

    Xác nhận đơn hàng

    Xin chào **{{ $order->fullname }}** ! Chúng tôi xin trân thành cảm ơn bạn vì đã đặt hàng bên shop của chúng tôi.

    **Mã đơn hàng:** {{ $order->code }}
    **Tổng tiền:** {{ number_format($order->total_price) }} VNĐ
    **Trạng thái:** {{ $order->status }}
    **Thanh toán:** {{ $order->payment_status }}

    <x-mail::button :url="url('/checkout/success/'.$order->code)">
        Xem chi tiết đơn hàng
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}

</x-mail::message>
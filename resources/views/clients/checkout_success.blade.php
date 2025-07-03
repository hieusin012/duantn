{{-- resources/views/clients/checkout_success.blade.php --}}

@extends('clients.layouts.master')

@section('title', 'Đặt Hàng Thành Công')

@section('content')
<div class="container my-5 text-center">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Đặt hàng thành công!</h4>
        <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đã được đặt thành công.</p>
        <hr>
        <p class="mb-0">Mã đơn hàng của bạn là: <strong>{{ $order->code }}</strong></p>
    </div>

    <div class="card mt-4 mb-4 text-start">
        <div class="card-header">
            Chi Tiết Đơn Hàng #{{ $order->code }}
        </div>
        <div class="card-body">
            <h5>Thông Tin Khách Hàng</h5>
            <p><strong>Họ và Tên:</strong> {{ $order->fullname }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Địa Chỉ Giao Hàng:</strong> {{ $order->address }}</p>
            <p><strong>Phương Thức Thanh Toán:</strong> {{ $order->payment }}</p>
            <p><strong>Trạng Thái Đơn Hàng:</strong> {{ $order->status }}</p>
            <p><strong>Trạng Thái Thanh Toán:</strong> {{ $order->payment_status }}</p>
            <p><strong>Ghi Chú:</strong> {{ $order->note ?? 'Không có' }}</p>

            {{-- THÊM PHẦN VOUCHER VÀO ĐÂY --}}
            @if ($order->voucher) {{-- Kiểm tra nếu có voucher_id được lưu --}}
            <p><strong>Mã Giảm Giá Đã Áp Dụng:</strong> <span class="text-success">{{ $order->voucher->code }}</span></p>
            <p><strong>Số Tiền Giảm Giá:</strong> <span class="text-success">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
            @elseif ($order->discount > 0) {{-- Nếu có giảm giá nhưng không có voucher_id (ví dụ, giảm giá thủ công) --}}
            <p><strong>Số Tiền Giảm Giá:</strong> <span class="text-info">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
            @endif
            {{-- KẾT THÚC PHẦN VOUCHER --}}


            <h5 class="mt-4">Sản Phẩm Trong Đơn Hàng</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Màu sắc</th>
                        <th>Kích thước</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->variant->product->name ?? 'N/A' }}</td>
                        <td>{{ $detail->variant->color->name ?? 'N/A' }}</td>
                        <td>{{ $detail->variant->size->name ?? 'N/A' }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->total_price, 0, ',', '.') }} VNĐ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h4 class="text-end mt-4">Tổng Cộng Đơn Hàng: {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</h4>
            {{-- Có thể thêm dòng hiển thị giảm giá ở đây nếu bạn muốn nó tách biệt khỏi tổng cộng --}}
            @if ($order->discount > 0)
            <p class="text-end text-success">Giảm giá: -{{ number_format($order->discount, 0, ',', '.') }} VNĐ</p>
            @endif
        </div>
    </div>

    <a href="{{ route('client.home') }}" class="btn btn-primary">Tiếp Tục Mua Sắm</a>
<<<<<<< HEAD
    <a href="{{ route('order.history') }}" class="btn btn-secondary">Xem Lịch Sử Đơn Hàng</a> {{-- Thay 'customer.orders.index' bằng route xem lịch sử đơn hàng của khách hàng --}}
=======
    <a href="{{-- route('customer.orders.index') --}}" class="btn btn-secondary">Xem Lịch Sử Đơn Hàng</a>
>>>>>>> e53302c3431521fda4a5819a713ebda095e2c502
</div>
@endsection
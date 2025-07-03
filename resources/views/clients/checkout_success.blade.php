@extends('clients.layouts.master') {{-- Giả sử bạn có một layout cơ bản tên là app.blade.php --}}

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
        </div>
    </div>

    <a href="{{ route('client.home') }}" class="btn btn-primary">Tiếp Tục Mua Sắm</a>
    <a href="{{ route('order.history') }}" class="btn btn-secondary">Xem Lịch Sử Đơn Hàng</a> {{-- Thay 'customer.orders.index' bằng route xem lịch sử đơn hàng của khách hàng --}}
</div>
@endsection
@extends('clients.layouts.master')

@section('title', 'Đặt Hàng Thành Công')

@section('content')
<style>
    .order-success-box {
        background-color: #f8f9fa;
        border: 1px solid rgb(74, 74, 75);
        padding: 20px;
        /* giảm padding */
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        font-size: 0.9rem;
        /* thu nhỏ toàn bộ chữ */
    }

    .order-title {
        font-size: 1.5rem;
        /* nhỏ hơn tí */
        font-weight: bold;
        color: #198754;
    }

    .section-title {
        font-weight: 600;
        color: rgb(0, 98, 255);
        font-size: 1.1rem;
        /* nhỏ hơn tí */
        margin-bottom: 12px;
    }

    .total-amount {
        font-size: 1.3rem;
        /* nhỏ lại cho gọn */
        color: #dc3545;
        font-weight: bold;
    }

    .btn-order-action {
        min-width: 160px;
        font-size: 0.9rem;
        /* nút nhỏ lại */
        padding: 8px 16px;
    }

    .table td,
    .table th {
        padding: 8px;
        font-size: 0.9rem;
    }

    .table img {
        width: 40px;
    }

    .text-muted {
        font-size: 0.85rem;
    }
</style>

<div class="container my-5">
    <div class="text-center mb-5">
        <h1 class="order-title"><i class="bi bi-check-circle-fill me-2"></i>ĐẶT HÀNG THÀNH CÔNG</h1>
        <p class="text-muted">Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi.</p>
    </div>

    <div class="order-success-box">
        <h3 class="section-title"><i class="bi bi-receipt-cutoff me-2"></i>Thông Tin Đơn Hàng</h3>
        <p><strong>Mã đơn hàng:</strong> #{{ $order->code }}</p>
        <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment }}</p>
        <p><strong>Trạng thái đơn hàng:</strong> {{ $order->status }}</p>
        <p><strong>Trạng thái thanh toán:</strong> {{ $order->payment_status }}</p>

        <hr class="my-4">

        <h3 class="section-title"><i class="bi bi-person-fill me-2"></i>Thông Tin Khách Hàng</h3>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td><strong>Họ và tên:</strong></td>
                    <td>{{ $order->fullname }}</td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td>{{ $order->email }}</td>
                </tr>
                <tr>
                    <td><strong>Số điện thoại:</strong></td>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <td><strong>Địa chỉ:</strong></td>
                    <td>{{ $order->address }}</td>
                </tr>
                <tr>
                    <td><strong>Ghi chú:</strong></td>
                    <td>{{ $order->note ?? 'Không có' }}</td>
                </tr>
            </tbody>
        </table>

        @if ($order->voucher || $order->discount > 0)
        <div class="mt-3">
            @if ($order->voucher)
            <p><strong>Mã Giảm Giá:</strong> <span class="text-success">{{ $order->voucher->code }}</span></p>
            @endif
            @if ($order->discount > 0)
            <p><strong>Giảm giá:</strong> <span class="text-danger">-{{ number_format($order->discount, 0, ',', '.') }} ₫</span></p>
            @endif
        </div>
        @endif

        <hr class="my-4">

        <h3 class="section-title"><i class="bi bi-box-seam me-2"></i>Sản Phẩm Trong Đơn</h3>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Ảnh</th>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>Đơn giá</th>
                        <th>SL</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->variant->product->name ?? 'N/A' }}</td>
                        <td><img src="{{ $detail->variant->image ? asset('storage/' . $detail->variant->image) : asset('images/no-image.jpg') }}" width="50" class="rounded"></td>
                        <td>{{ $detail->variant->color->name ?? 'N/A' }}</td>
                        <td>{{ $detail->variant->size->name ?? 'N/A' }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} ₫</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->total_price, 0, ',', '.') }} ₫</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-end mt-4">
            <span class="me-2 fs-5">Tổng tiền đơn hàng:</span>
            <span class="total-amount">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('client.home') }}" class="btn btn-outline-primary btn-order-action me-2">
            🛒 Tiếp Tục Mua Sắm
        </a>
        <a href="{{ route('order.history') }}" class="btn btn-secondary btn-order-action">
            📦 Xem Lịch Sử Đơn Hàng
        </a>
    </div>
</div>
@endsection
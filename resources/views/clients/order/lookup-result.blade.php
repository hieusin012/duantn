{{-- @extends('clients.layouts.master')
@section('title', 'Kết quả tra cứu đơn hàng')
@section('content')
<div class="container py-4">
    <h2 class="mb-3 text-center">Kết quả đơn hàng</h2>
    <div class="card p-3">
        <p><strong>Mã đơn hàng:</strong> {{ $order->code }}</p>
        <p><strong>Họ tên:</strong> {{ $order->fullname }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }} VND</p>
        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <a href="{{ route('order.lookup.form') }}" class="btn btn-secondary mt-3">Tra cứu đơn khác</a>
</div>
@endsection --}}


@extends('clients.layouts.master')
@section('title', 'Kết quả tra cứu đơn hàng')
@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">📄 Kết quả tra cứu đơn hàng</h2>

    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-body p-4">
            <table class="table table-bordered align-middle mb-0">
                <tbody>
                    <tr>
                        <th style="width: 200px;">🆔 Mã đơn hàng</th>
                        <td>{{ $order->code }}</td>
                    </tr>
                    <tr>
                        <th>👤 Họ tên</th>
                        <td>{{ $order->fullname }}</td>
                    </tr>
                    <tr>
                        <th>📧 Email</th>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <th>📱 Số điện thoại</th>
                        <td>{{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <th>🏠 Địa chỉ</th>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <th>📦 Trạng thái</th>
                        <td>
                            @switch($order->status)
                                @case('Chờ xác nhận')
                                    <span class="badge bg-warning text-dark">Chờ xác nhận</span>
                                    @break
                                @case('Đã xác nhận')
                                    <span class="badge bg-info text-dark">Đã xác nhận</span>
                                    @break
                                @case('Đang chuẩn bị hàng')
                                    <span class="badge bg-secondary">Đang chuẩn bị hàng</span>
                                    @break
                                @case('Đang giao hàng')
                                    <span class="badge bg-primary">Đang giao hàng</span>
                                    @break
                                @case('Đã giao hàng')
                                    <span class="badge bg-success">Đã giao hàng</span>
                                    @break
                                @case('Đơn hàng đã hủy')
                                    <span class="badge bg-danger">Đơn hàng đã hủy</span>
                                    @break
                                @case('Đã hoàn hàng')
                                    <span class="badge bg-info">Đã hoàn hàng</span>
                                    @break
                                @default
                                    <span class="badge bg-dark">Không xác định</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>💰 Tổng tiền</th>
                        <td>{{ number_format($order->total_price) }} VND</td>
                    </tr>
                    <tr>
                        <th>🕒 Ngày đặt</th>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('order.lookup.form') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="anm anm-undo-l me-1"></i> Tra cứu đơn khác
        </a>
    </div>
</div>
@endsection


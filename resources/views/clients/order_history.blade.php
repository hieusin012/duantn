{{-- @extends('clients.layouts.master')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<h3>Lịch sử đơn hàng</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Tổng tiền</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>#{{ $order->id }}</td>

<td>{{ $order->created_at->format('d/m/Y') }}</td>
<td>{{ \App\Models\Order::getStatuses()[$order->status] ?? $order->status }}</td>
<td>{{ number_format($order->total_price) }}đ</td>
<td><a href="{{ route('order.details', $order->id) }}" class="btn btn-sm btn-primary">Xem</a></td>
</tr>
@endforeach
</tbody>
</table>
@endsection --}}





@extends('clients.layouts.master')

@section('title', 'Lịch sử đơn hàng')

@section('content')
<div class="container py-4">
    <h3 class="mb-4 text-primary">📦 Lịch sử đơn hàng</h3>

    {{-- Thông tin khách hàng --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-dark fw-bold">
            👤 Thông tin tài khoản khách hàng
        </div>
        <div class="card-body">
            <p><strong>Họ tên:</strong> {{ auth()->user()->fullname ?? auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Số điện thoại:</strong> {{ auth()->user()->phone ?? 'Chưa cập nhật' }}</p>
            <p><strong>Địa chỉ:</strong> {{ auth()->user()->address ?? 'Chưa cập nhật' }}</p>
        </div>
    </div>

    {{-- Danh sách đơn hàng --}}
    @if($orders->isEmpty())
    <div class="alert alert-info text-center shadow-sm">🛒 Bạn chưa có đơn hàng nào.</div>
    @else
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
            📃 Danh sách đơn hàng của bạn
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover align-middle text-center mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Phương thức</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Ngày mua</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        @php
                        $status = \App\Models\Order::getStatuses()[$order->status] ?? $order->status;
                        $badgeClass = match($order->status) {
                        'Chờ xác nhận' => 'warning',
                        'Đã xác nhận' => 'primary',
                        'Đang chuẩn bị hàng' => 'primary',
                        'Đang giao hàng' => 'primary',
                        'Đã giao hàng' => 'success',
                        'Đơn hàng đã hủy' => 'danger',
                        default => 'secondary'
                        };
                        @endphp
                        <tr>
                            <td><strong>{{ $order->code ?? str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                            <td><span class="text-uppercase">{{ $order->payment }}</span></td>
                            <td>
                                <span class="badge bg-{{ $badgeClass }} px-3 py-2">{{ $status }}</span>
                            </td>
                            <td class="text-end">{{ number_format($order->total_price, 0, ',', '.') }} <small>₫</small></td>
                            <td>{{ $order->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-sm btn-outline-info shadow-sm">
                                    Chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3 mb-3 d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
// resources/views/admin/orders/show.blade.php
@extends('admin.layouts.index')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chi tiết đơn hàng #{{ $order->code }}</h3>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Thông tin khách hàng</h4>
                        <p><strong>Họ và tên:</strong> {{ $order->fullname }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                        <p><strong>Khách hàng:</strong> {{ $order->user ? $order->user->name : 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h4>Thông tin đơn hàng</h4>
                        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment }}</p>
                        <p><strong>Trạng thái:</strong> 
                            <span class="badge {{ $order->status == 'Đã giao hàng' ? 'bg-success' : ($order->status == 'Đơn hàng đã hủy' ? 'bg-danger' : 'bg-warning') }}">
                                {{ $order->status }}
                            </span>
                        </p>
                        <p><strong>Trạng thái thanh toán:</strong> 
                            <span class="badge {{ $order->payment_status == 'Đã thanh toán' ? 'bg-success' : 'bg-danger' }}">
                                {{ $order->payment_status }}
                            </span>
                        </p>
                        <p><strong>Phí vận chuyển:</strong> {{ number_format($order->shiping ?? 0, 0, ',', '.') }} đ</p>
                        <p><strong>Giảm giá:</strong> {{ number_format($order->discount ?? 0, 0, ',', '.') }} đ</p>
                        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} đ</p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4>Ghi chú</h4>
                        <p>{{ $order->note ?? 'Không có ghi chú' }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary">Sửa đơn hàng</a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div>
@endsection
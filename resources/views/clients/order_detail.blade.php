@extends('clients.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<h3>Chi tiết đơn hàng #{{ $order->id }}</h3>
<p>Trạng thái: <strong>{{ \App\Models\Order::getStatuses()[$order->status] ?? $order->status }}</strong></p>

<table class="table">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->orderDetails as $item)
        <tr>
            <td>{{ $item->variant->product->name ?? 'Sản phẩm không tồn tại' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price) }}đ</td>
            <td>{{ number_format($item->price * $item->quantity) }}đ</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h4 class="text-end">Tổng cộng: <strong>{{ number_format($order->total_price) }}đ</strong></h4>
@endsection

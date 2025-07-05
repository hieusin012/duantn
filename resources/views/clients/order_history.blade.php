@extends('clients.layouts.master')

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
@endsection

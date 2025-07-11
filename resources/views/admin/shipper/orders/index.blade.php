@extends('admin.layouts.index')

@section('title', 'Quản lý đơn hàng Shipper')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <h5 class="mb-3">Danh sách đơn hàng Shipper</h5>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Shipper</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->code }}</td>
                            <td>{{ $order->fullname }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge {{ $order->status == 'Đã giao hàng' ? 'bg-success' : ($order->status == 'Đang giao hàng' ? 'bg-warning' : 'bg-secondary') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->shipper_id ? $order->shipper->name : 'Chưa nhận' }}</td>
                            <td>
                                @if(!$order->shipper_id)
                                    <a href="{{ route('admin.shipper.orders.accept', $order->id) }}" class="btn btn-sm btn-success">Nhận đơn</a>
                                @elseif($order->shipper_id == Auth::id() && $order->status == 'Đang giao hàng')
                                    <a href="{{ route('admin.shipper.orders.complete', $order->id) }}" class="btn btn-sm btn-primary">Giao xong</a>
                                @else
                                    <span class="badge bg-info">Đang xử lý</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination mt-3">
                    {{ $orders->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

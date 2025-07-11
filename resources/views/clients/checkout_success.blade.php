{{-- resources/views/clients/checkout_success.blade.php --}}

@extends('clients.layouts.master')

@section('title', 'Đặt Hàng Thành Công')

@section('content')
<div class="container text-center my-5">
    <div class="text-center border p-3">
        <h1>HÓA ĐƠN THANH TOÁN</h1>

        <div class="card mt-4 mb-4 text-start">

            <div class="card-body">
                <h2>Thông tin đơn hàng</h2>
                <p><strong>Mã đơn hàng: </strong> #{{ $order->code }}</p>
                <p><strong>Ngày tạo đơn: </strong> {{ $order->created_at }}</p>
                <p><strong>Phương Thức Thanh Toán:</strong>{{ $order->payment }}</p>
                <p><strong>Trạng Thái Đơn Hàng:</strong> {{ $order->status }}</p>
                <p><strong>Trạng Thái Thanh Toán:</strong> {{ $order->payment_status }}</p>

            </div>
            <div class="card-body">
                <h2>Thông Tin Khách Hàng</h2>
                <table class="table table-bordered table-striped table-hover">
                    <tr>
                        <td>
                            <strong>Họ và Tên:</strong>
                        </td>
                        <td>
                            {{ $order->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Email:</strong>
                        </td>
                        <td>
                            {{ $order->email }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Số điện thoại:</strong>
                        </td>
                        <td>
                            {{ $order->phone }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Địa chỉ giao hàng:</strong>
                        </td>
                        <td>
                            {{ $order->address }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Ghi chú:</strong>
                        </td>
                        <td>
                            {{ $order->note ?? 'Không có' }}
                        </td>
                    </tr>
                </table>
                {{-- THÊM PHẦN VOUCHER VÀO ĐÂY --}}
                @if ($order->voucher) {{-- Kiểm tra nếu có voucher_id được lưu --}}
                <p><strong>Mã Giảm Giá Đã Áp Dụng:</strong> <span class="text-success">{{ $order->voucher->code }}</span></p>
                <p><strong>Số Tiền Giảm Giá:</strong> <span class="text-success">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
                @elseif ($order->discount > 0) {{-- Nếu có giảm giá nhưng không có voucher_id (ví dụ, giảm giá thủ công) --}}
                <p><strong>Số Tiền Giảm Giá:</strong> <span class="text-info">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
                @endif
                {{-- KẾT THÚC PHẦN VOUCHER --}}


                <h2 class="mt-4">Sản Phẩm Trong Đơn Hàng</h2>
                <table class="table text-center table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Ảnh sản phẩm</th>
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
                            <td class="align-middle">{{ $detail->variant->product->name ?? 'N/A' }}</td>
                            <td class="align-middle"><img src="{{ $detail->variant->image ? asset('storage/' . $detail->variant->image) : asset('images/no-image.jpg') }}" width="50" class="rounded"></td>
                            <td class="align-middle">{{ $detail->variant->color->name ?? 'N/A' }}</td>
                            <td class="align-middle">{{ $detail->variant->size->name ?? 'N/A' }}</td>
                            <td class="align-middle">{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                            <td class="align-middle">{{ $detail->quantity }}</td>
                            <td class="align-middle">{{ number_format($detail->total_price, 0, ',', '.') }} VNĐ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h1 class="text-end mt-4">Tổng Cộng Đơn Hàng: {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</h1>
                {{-- Có thể thêm dòng hiển thị giảm giá ở đây nếu bạn muốn nó tách biệt khỏi tổng cộng --}}
                @if ($order->discount > 0)
                <p class="text-end text-success">Giảm giá: -{{ number_format($order->discount, 0, ',', '.') }} VNĐ</p>
                @endif
            </div>
        </div>
    </div>
    <div class="mt-5">
        <a href="{{ route('client.home') }}" class="btn btn-primary">Tiếp Tục Mua Sắm</a>
        <a href="{{ route('order.history') }}" class="btn btn-secondary">Xem Lịch Sử Đơn Hàng</a> {{-- Thay 'customer.orders.index' bằng route xem lịch sử đơn hàng của khách hàng --}}
    </div>

</div>
@endsection
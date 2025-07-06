@extends('admin.layouts.index')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4>Chi tiết đơn hàng #{{ $order->code }}</h4>
        </div>
        <div class="card-body">
            <div class="row element-button">
                <div class="col-sm-2">
                    <a class="btn btn-delete btn-sm pdf-file" href="{{ route('invoice.pdf', ['order' => $order->code]) }}" type="button" title="Export PDF"><i class="fas fa-file-pdf"></i> Xuất đơn hàng</a>
                </div>
            </div>
            {{-- Thông tin đơn hàng --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="mb-3">🧾 Thông tin đơn hàng</h5>
                    <p><strong>Mã đơn hàng:</strong> #{{ $order->code }}</p>
                    <p><strong>Ngày tạo đơn:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Phương thức thanh toán:</strong> {{ $order->payment }}</p>
                    <p><strong>Trạng thái đơn hàng:</strong>
                        <span class="badge bg-info">{{ $order->status }}</span>
                    </p>
                    <p><strong>Trạng thái thanh toán:</strong>
                        <span class="badge {{ $order->payment_status === 'Đã thanh toán' ? 'bg-success' : 'bg-warning' }}">
                            {{ $order->payment_status }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3">👤 Thông tin khách hàng</h5>
                    <table class="table table-sm table-borderless">
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
                    </table>

                    {{-- Thông tin giảm giá / voucher --}}
                    @if ($order->voucher)
                    <p><strong>Mã giảm giá:</strong> <span class="text-success">{{ $order->voucher->code }}</span></p>
                    <p><strong>Số tiền giảm:</strong> <span class="text-success">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
                    @elseif ($order->discount > 0)
                    <p><strong>Giảm giá thủ công:</strong> <span class="text-info">-{{ number_format($order->discount, 0, ',', '.') }} VNĐ</span></p>
                    @endif
                </div>
            </div>

            {{-- Sản phẩm trong đơn hàng --}}
            <h5 class="mb-3">📦 Sản phẩm trong đơn hàng</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Màu</th>
                            <th>Size</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $detail)
                        <tr class="text-center">
                            <td class="align-middle">{{ $detail->variant->product->name ?? 'N/A' }}</td>
                            <td class="align-middle">
                                <img src="{{ $detail->variant->image ? asset('storage/' . $detail->variant->image) : asset('images/no-image.jpg') }}"
                                    width="60" class="img-thumbnail">
                            </td>
                            <td class="align-middle">{{ $detail->variant->color->name ?? 'N/A' }}</td>
                            <td class="align-middle">{{ $detail->variant->size->name ?? 'N/A' }}</td>
                            <td class="align-middle">{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                            <td class="align-middle">{{ $detail->quantity }}</td>
                            <td class="align-middle">{{ number_format($detail->total_price, 0, ',', '.') }} VNĐ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tổng cộng --}}
            <div class="text-end mt-4">
                @if ($order->discount > 0)
                <p class="mb-1 text-success"><strong>Giảm giá:</strong> -{{ number_format($order->discount, 0, ',', '.') }} VNĐ</p>
                @endif
                <h4 class="text-dark"><strong>Tổng cộng:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</h4>
            </div>

            {{-- Hành động --}}
            <div class="mt-4">
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Sửa đơn hàng
                </a>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
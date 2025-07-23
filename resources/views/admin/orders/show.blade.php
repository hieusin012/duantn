@extends('admin.layouts.index')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container-fluid">
    <div class="card mb-4 shadow">
        <div class="card-header bg-primary text-white d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <h4 class="mb-0">
                🧾 Chi tiết đơn hàng <span class="text-warning">#{{ $order->code }}</span>
            </h4>

            <div class="d-flex gap-2">
                <a href="{{ route('invoice.pdf', ['order' => $order->code]) }}" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-file-pdf me-1"></i> Xuất PDF
                </a>
                <a href="{{ route('admin.orders.print', ['id' => $order->id]) }}" class="btn btn-outline-success btn-sm mf-1 " title="In dữ liệu">
                    <i class="fas fa-print me-1"></i> In dữ liệu
                </a>
            </div>
        </div>

        <div class="card-body">
            {{-- Hiển thị thông tin đơn hàng --}}
            <div class="container">
                {{-- Thông tin đơn hàng --}}
                <div class="mb-4 p-4 rounded shadow border bg-light">
                    <h5 class="mb-3">📋 Thông tin đơn hàng</h5>
                    <div class="row">
                        <div class="col-md-3"><strong>Mã đơn hàng:</strong><br>#{{ $order->code }}</div>
                        <div class="col-md-3"><strong>Ngày tạo:</strong><br>{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        <div class="col-md-3"><strong>Phương thức thanh toán:</strong><br>{{ $order->payment }}</div>
                        <div class="col-md-3">
                            <strong>Thanh toán:</strong><br>
                            {{-- <span class="badge {{ $order->payment_status === 'Đã thanh toán' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $order->payment_status }}
                            </span> --}}
                            @php
                                $paymentClass = match($order->payment_status) {
                                    'Chưa thanh toán' => 'bg-danger',
                                    'Đã thanh toán' => 'bg-success',
                                    'Đã hoàn tiền' => 'bg-warning',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $paymentClass }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-3 d-flex align-items-center gap-2">
                        <strong>Trạng thái:</strong>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="m-0">
                            @csrf @method('PATCH')
                            @php
                            $statusColor = match($order->status) {
                            'Chờ xác nhận' => 'btn-outline-warning',
                            'Đã xác nhận' => 'btn-outline-info',
                            'Đang chuẩn bị hàng' => 'btn-outline-info',
                            'Đang giao hàng' => 'btn-outline-info',
                            'Đã giao hàng' => 'btn-outline-success',
                            'Đơn hàng đã hủy' => 'btn-outline-danger',
                            default => 'btn-outline-secondary'
                            };
                            @endphp
                            <button type="submit" class="btn {{ $statusColor }} btn-sm rounded-pill shadow-sm mf-4" title="Click để chuyển trạng thái">
                                <i class="fas fa-sync-alt me-1"></i>{{ $order->status }}
                            </button>
                        </form>
                    </div>

                    @if ($order->status === 'Đơn hàng đã hủy')
                    <p class="mt-2"><strong>Lý do hủy:</strong> {{ $order->cancel_reason }}</p>
                    @if ($order->cancel_note)
                    <p><strong>Ghi chú:</strong> {{ $order->cancel_note }}</p>
                    @endif
                    @endif
                </div>

                <div class="row">
                    {{-- Người đặt --}}
                    <div class="col-md-6 mb-4">
                        <div class="p-4 rounded shadow border bg-white h-100">
                            <h5 class="mb-3">👤 Thông tin người đặt</h5>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td><strong>Họ và tên:</strong></td>
                                    <td>{{ optional($order->user)->fullname }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ optional($order->user)->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Điện thoại:</strong></td>
                                    <td>{{ optional($order->user)->phone ?? 'Chưa đăng kí' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Địa chỉ:</strong></td>
                                    <td>{{ optional($order->user)->address ?? 'Chưa đăng kí' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Người nhận --}}
                    <div class="col-md-6 mb-4">
                        <div class="p-4 rounded shadow border bg-white h-100">
                            <h5 class="mb-3">📦 Thông tin người nhận</h5>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td><strong>Họ và tên:</strong></td>
                                    <td>{{ $order->fullname }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $order->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Điện thoại:</strong></td>
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

                            @if ($order->voucher)
                            <p class="mt-2 mb-0"><strong>Mã giảm giá:</strong> <span class="text-success">{{ $order->voucher->code }}</span></p>
                            <p class="mb-0"><strong>Số tiền giảm:</strong> <span class="text-success">-{{ number_format($order->discount, 0, ',', '.') }} ₫</span></p>
                            @elseif ($order->discount > 0)
                            <p class="mt-2 mb-0"><strong>Giảm giá thủ công:</strong> <span class="text-info">-{{ number_format($order->discount, 0, ',', '.') }} ₫</span></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>





            {{-- Danh sách sản phẩm --}}
            <h5 class="mb-3">📦 Sản phẩm trong đơn hàng</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle table-sm shadow-sm rounded">
                    <thead class="table-primary">
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
                        <tr>
                            <td class="fw-medium text-nowrap">{{ $detail->variant->product->name ?? 'N/A' }}</td>
                            <td>
                                <img src="{{ $detail->variant->image ? asset('storage/' . $detail->variant->image) : asset('images/no-image.jpg') }}"
                                    width="60" class="img-thumbnail border border-secondary" alt="Ảnh sản phẩm" />
                            </td>
                            <td class="text-nowrap">{{ $detail->variant->color->name ?? 'N/A' }}</td>
                            <td class="text-nowrap">{{ $detail->variant->size->name ?? 'N/A' }}</td>
                            <td class="text-nowrap text-danger fw-semibold">{{ number_format($detail->price, 0, ',', '.') }} <sup>₫</sup></td>
                            <td class="text-nowrap">{{ $detail->quantity }}</td>
                            <td class="text-nowrap text-success fw-semibold">{{ number_format($detail->total_price, 0, ',', '.') }} <sup>₫</sup></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            {{-- Tổng cộng --}}
            <div class="text-end mt-4">
                @if ($order->discount > 0)
                <p class="mb-1 text-success"><strong>Giảm giá:</strong> -{{ number_format($order->discount, 0, ',', '.') }} ₫</p>
                @endif
                <h4 class="text-dark"><strong>Tổng cộng:</strong> {{ number_format($order->total_price, 0, ',', '.') }} ₫</h4>
            </div>

            {{-- Hành động --}}
            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
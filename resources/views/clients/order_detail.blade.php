{{-- @extends('clients.layouts.master')

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
@endsection --}}



@extends('clients.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div class="container py-4">
        <h3 class="mb-4 text-primary">📄 Chi tiết đơn hàng: <span
                class="text-dark">{{ $order->code ?? str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></h3>
        {{-- Thông tin đơn hàng --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="border rounded p-3 bg-light">
                    <h5 class="mb-3 text-secondary">📝 Thông tin đơn hàng</h5>
                    <p><strong>Mã đơn hàng:</strong> <span
                            class="text-dark">{{ $order->code ?? str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                    <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                    <p>
                        <strong>Trạng thái:</strong>
                        @php
                            $statusText = \App\Models\Order::getStatuses()[$order->status] ?? $order->status;
                            $badgeClass = match ($order->status) {
                                'pending' => 'warning',
                                'processing' => 'primary',
                                'completed' => 'success',
                                'canceled' => 'danger',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeClass }} px-3 py-2">{{ $statusText }}</span>
                    </p>
                </div>
            </div>

            {{-- Thông tin khách hàng --}}
            <div class="col-md-6">
                <div class="border rounded p-3 bg-light">
                    <h5 class="mb-3 text-secondary">👤 Thông tin người đặt</h5>
                    <p><strong>Họ tên:</strong> {{ $order->fullname }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                </div>
            </div>
        </div>

        {{-- Danh sách sản phẩm --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                🛒 Danh sách sản phẩm
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0 text-center">
                        <thead class="table-secondary">
                            <tr>
                                <th>#</th>
                                <th>Sản phẩm</th>
                                <th>Ảnh</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($order->orderDetails as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->variant->product->name ?? 'Sản phẩm không tồn tại' }}</td>
                                    <td>
                                        @if (isset($item->variant->product->image))
                                            <img src="{{ asset($item->variant->product->image) }}" alt="Ảnh sản phẩm"
                                                width="80" class="rounded shadow-sm">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }} ₫</td>
                                    <td class="fw-bold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        ₫</td>
                                </tr>
                            @endforeach --}}
                            @foreach ($order->orderDetails as $item)
                                @php
                                    $product = $item->variant->product ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($product)
                                            {{ $product->name }}
                                        @else
                                            <span class="text-danger">Sản phẩm không tồn tại</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product && $product->image)
                                            <img src="{{ asset($item->variant->product->image) }}" alt="Ảnh sản phẩm" width="80" class="rounded shadow-sm">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price) }} ₫</td>
                                    <td>{{ number_format($item->total_price) }} ₫</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tổng cộng --}}
        <div class="text-end">
            <h5 class="text-dark">Tổng cộng:
                <span class="text-danger fw-bold">{{ number_format($order->total_price, 0, ',', '.') }} ₫</span>
            </h5>
        </div>

        <div class="mt-4 d-flex flex-wrap justify-content-between gap-2">
            {{-- Quay lại --}}
            <a href="{{ route('order.history') }}" class="btn btn-outline-secondary">
                ← Quay lại danh sách đơn hàng
            </a>

            <div class="d-flex gap-2">
                {{-- Hủy đơn nếu chưa xác nhận --}}
                {{-- @if ($order->status === 'Chờ xác nhận')
                    <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-outline-danger">❌ Hủy đơn hàng</button>
                    </form>
                @endif --}}

                @if ($order->status === 'Chờ xác nhận')
                    <!-- Nút mở modal -->
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        ❌ Hủy đơn hàng
                    </button>

                    <!-- Modal Hủy đơn hàng -->
                    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('order.cancel', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="cancelModalLabel">❌ Hủy đơn hàng</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Vui lòng chọn lý do hủy đơn hàng:</p>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason1" value="Đặt nhầm" checked>
                                            <label class="form-check-label" for="reason1">Đặt nhầm</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason2" value="Không cần nữa">
                                            <label class="form-check-label" for="reason2">Không cần nữa</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason3" value="Muốn thay đổi sản phẩm">
                                            <label class="form-check-label" for="reason3">Muốn thay đổi sản phẩm</label>
                                        </div>

                                        <div class="mt-3">
                                            <label for="cancel_note" class="form-label">Ghi chú (nếu có):</label>
                                            <textarea name="cancel_note" id="cancel_note" rows="3" class="form-control" placeholder="Lý do chi tiết..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- Hoàn hàng nếu trong 7 ngày --}}
                @php
                    $isDelivered = $order->status === 'Đã giao hàng';
                    $canReturn = $isDelivered && $order->created_at->diffInDays(\Carbon\Carbon::now()) <= 7;
                @endphp

                @if ($canReturn)
                    <a href="{{ route('client.return-requests.create', $order->id) }}"
                    class="btn btn-outline-warning"
                    onclick="return confirm('Bạn có chắc muốn gửi yêu cầu trả hàng cho đơn này?')">
                    ↩️ Hoàn lại đơn hàng
                    </a>
                @endif

                {{-- Nút Mua lại --}}
                {{-- @if ($isDelivered)
                    <form action="{{ route('order.reorder', $order->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-success">🔁 Mua lại</button>
                    </form>
                @endif --}}
                @if (in_array($order->status, ['Đã giao hàng', 'Đơn hàng đã hủy']))
                    <form action="{{ route('order.reorder', $order->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-success">🔁 Mua lại</button>
                    </form>
                @endif
            </div>
        </div>


    </div>
@endsection

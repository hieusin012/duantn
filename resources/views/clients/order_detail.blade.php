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
                    {{-- <p><strong>Ngày nhận hàng:</strong> 
                        {{ $order->delivered_at ? $order->delivered_at->format('d/m/Y H:i:s') : 'Chưa nhận' }}
                    </p> --}}
                    <p><strong>Ngày nhận hàng:</strong> 
                        @php
                            switch ($order->status) {
                                case 'Đã giao hàng':
                                case 'Đã hoàn hàng':
                                    echo $order->delivered_at 
                                        ? $order->delivered_at->format('d/m/Y H:i:s') 
                                        : 'Đã giao nhưng thiếu thời gian';
                                    break;
                                case 'Đơn hàng đã hủy':
                                    echo 'Đơn hàng đã bị hủy';
                                    break;
                                default:
                                    echo 'Chưa giao';
                            }
                        @endphp
                    </p>
                    <p>
                        <strong>Trạng thái:</strong>
                        @php
                            $statusText = \App\Models\Order::getStatuses()[$order->status] ?? $order->status;
                            $badgeClass = match ($order->status) {
                                'Chờ xác nhận' => 'warning',
                                'Đã xác nhận' => 'primary',
                                'Đang chuẩn bị hàng' => 'primary',
                                'Đang giao hàng' => 'primary',
                                'Đã giao hàng' => 'success',
                                'Đơn hàng đã hủy' => 'danger',
                                'Đã hoàn hàng' => 'secondary',
                                default => 'secondary',
                            };
                        @endphp
                        {{-- <span class="badge bg-{{ $badgeClass }} px-3 py-2">{{ $statusText }}</span> --}}
                        <span class="badge bg-{{ $badgeClass }} px-3 py-2 order-status" data-order-id="{{ $order->id }}">
                            {{ $statusText }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Thông tin khách hàng --}}
            <div class="col-md-6">
                <div class="border rounded p-3 bg-light">
                    <h5 class="mb-3 text-secondary">👤 Thông tin người nhận</h5>
                    <p><strong>Họ tên:</strong> {{ $order->fullname }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                    <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
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
                                <th>Màu</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($order->orderDetails as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->product_name ?? 'Sản phẩm không tồn tại' }}</td>
                                    <td>
                                        @if (isset($item->product_image))
                                            <img src="{{ asset('storage/' . $item->product_image) }}" alt="Ảnh sản phẩm"
                                                width="80" class="rounded shadow-sm">
                                        @else
                                            <span class="text-muted">Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->color ?? 'N/A' }}</td>
                                    <td>{{ $item->size ?? 'N/A' }}</td>
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

        {{-- Giảm giá --}}
        <div class="text-end">
            @if ($order->discount > 0)
                <p><strong class="text-dark">Giảm giá:</strong> <span class="text-danger">-{{ number_format($order->discount, 0, ',', '.') }} ₫</span></p>
            @endif
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

                @php
                    $canCancel = $order->status === 'Chờ xác nhận' || $order->status === 'Đã xác nhận';
                    $shouldShowCancel = in_array($order->status, ['Chờ xác nhận', 'Đã xác nhận', 'Đang chuẩn bị hàng', 'Đang giao hàng']);
                @endphp

                {{-- @if ($order->status === 'Chờ xác nhận')
                    <!-- Nút mở modal -->
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        ❌ Hủy đơn hàng
                    </button> --}}

                    {{-- Nút Hủy đơn hàng --}}
                    {{-- @if ($shouldShowCancel)
                        <button type="button"
                            class="btn btn-outline-danger {{ $canCancel ? '' : 'disabled' }}"
                            data-bs-toggle="{{ $canCancel ? 'modal' : '' }}"
                            data-bs-target="{{ $canCancel ? '#cancelModal' : '' }}"
                            style="{{ $canCancel ? '' : 'pointer-events: none; opacity: 0.5;' }}"
                            title="{{ $canCancel ? '' : 'Không thể hủy đơn ở trạng thái hiện tại' }}">
                            ❌ Hủy đơn hàng
                        </button>
                    @endif --}}
                    @if ($shouldShowCancel)
                        @if ($canCancel)
                            <!-- Nút bình thường -->
                            <button type="button"
                                class="btn btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#cancelModal">
                                ❌ Hủy đơn hàng
                            </button>
                        @else
                            <!-- Nút bị khóa + tooltip -->
                            <span data-bs-toggle="tooltip" title="Không thể hủy đơn ở trạng thái hiện tại">
                                <button type="button"
                                    class="btn btn-outline-danger"
                                    style="pointer-events: none; opacity: 0.5;"
                                    disabled>
                                    ❌ Hủy đơn hàng
                                </button>
                            </span>
                        @endif
                    @endif
                    
                    <!-- Modal Hủy đơn hàng -->
                    @if ($canCancel)
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
                                            <input class="form-check-input" type="radio" name="cancel_reason" id="reason1" value="Đặt nhầm" required>
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
                {{-- @php
                    $isDelivered = $order->status === 'Đã giao hàng';
                    $canReturn = $isDelivered && $order->created_at->diffInDays(\Carbon\Carbon::now()) <= 7;
                @endphp --}}
                @php
                    $isDelivered = $order->status === 'Đã giao hàng';
                    // $canReturn = $isDelivered && $order->delivered_at && now()->diffInDays($order->delivered_at) <= 7;
                    $canReturn = $isDelivered && now()->lessThanOrEqualTo($order->delivered_at->copy()->addDays(7));
                @endphp

                @if ($canReturn)
                    <a href="{{ route('client.return-requests.create', $order->id) }}"
                    class="btn btn-outline-warning"
                    onclick="return confirm('Bạn có chắc muốn gửi yêu cầu trả hàng cho đơn này?')" title="Hoàn hàng trong vòng 7 ngày kể từ ngày nhận hàng">
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
                @if (in_array($order->status, ['Đã giao hàng', 'Đơn hàng đã hủy', 'Đã hoàn hàng']))
                    <form action="{{ route('order.reorder', $order->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-success">🔁 Mua lại</button>
                    </form>
                @endif
            </div>
        </div>


    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function fetchOrderStatus(orderId) {
        $.get(`/order/status/${orderId}`, function(data) {
            const span = $('.order-status[data-order-id="'+orderId+'"]');
            if (span.text() !== data.status) { // chỉ update khi khác
                let badgeClass = 'secondary';
                switch(data.status) {
                    case 'Chờ xác nhận': badgeClass='warning'; break;
                    case 'Đã xác nhận': 
                    case 'Đang chuẩn bị hàng':
                    case 'Đang giao hàng': badgeClass='primary'; break;
                    case 'Đã giao hàng': badgeClass='success'; break;
                    case 'Đơn hàng đã hủy': badgeClass='danger'; break;
                    case 'Đã hoàn hàng': badgeClass='secondary'; break;
                }
                span.text(data.status)
                    .removeClass()
                    .addClass('badge bg-'+badgeClass+' px-3 py-2 order-status');
            }
        });
    }

    // Chỉ update trạng thái đơn hàng hiện tại
    setInterval(function() {
        const orderId = $('.order-status').data('order-id');
        fetchOrderStatus(orderId);
    }, 1000);
    </script>
@endsection

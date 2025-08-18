@extends('clients.layouts.master')
@section('title', 'Yêu cầu trả hàng')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center text-primary">📦 Yêu cầu trả hàng của bạn</h2>

    @if($requests->isEmpty())
        <div class="alert alert-info text-center">Bạn chưa có yêu cầu trả hàng nào.</div>
    @else
    <div class="table-responsive shadow rounded">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead class="table text-center" style="background-color: #fdebd0;">
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày gửi</th>
                    <th>Lý do</th>
                    <th>Trạng thái</th>
                    <th>PT Hoàn tiền</th>
                    <th>Minh chứng</th>
                    <th>Phản hồi từ Shop</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($requests as $item)
                <tr>
                    <td class="fw-semibold text-primary">{{ $item->order->code ?? 'Không rõ' }}</td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-start">{{ $item->reason }}</td>
                    <td class="order-status" data-request-id="{{ $item->id }}">
                        @switch($item->status)
                            @case('pending')
                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Chờ xác nhận</span>
                                @break
                            @case('approved')
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Đã duyệt</span>
                                @break
                            @case('rejected')
                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Từ chối</span>
                                @break
                            @case('refunded')
                                <span class="badge bg-info text-dark"><i class="bi bi-wallet2 me-1"></i>Đã hoàn tiền</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Không rõ</span>
                        @endswitch
                    </td>
                    <td>
                        @if($item->refund_method === 'bank_transfer')
                            <span class="text-primary">Chuyển khoản</span>
                        @elseif($item->refund_method === 'wallet')
                            <span class="text-success">Ví điện tử</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($item->image)
                            <a href="{{ asset('storage/' . $item->image) }}" target="_blank">
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-thumbnail" width="60">
                            </a>
                        @else
                            <span class="text-muted">Không có</span>
                        @endif
                    </td>
                    <td id="note-{{ $item->id }}">
                        @if($item->admin_note)
                            <span class="text-muted fst-italic">{{ $item->admin_note }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $requests->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchReturnStatuses() {
        $('.order-status').each(function() {
            const cell = $(this);
            const requestId = cell.data('request-id');

            $.get(`/return-request/status/${requestId}`, function(data) {
                let badgeHtml = '';
                switch(data.status) {
                    case 'pending':
                        badgeHtml = '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>Chờ xác nhận</span>';
                        break;
                    case 'approved':
                        badgeHtml = '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Đã duyệt</span>';
                        break;
                    case 'rejected':
                        badgeHtml = '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Từ chối</span>';
                        break;
                    case 'refunded':
                        badgeHtml = '<span class="badge bg-info text-dark"><i class="bi bi-wallet2 me-1"></i>Đã hoàn tiền</span>';
                        break;
                    default:
                        badgeHtml = '<span class="badge bg-secondary">Không rõ</span>';
                }
                cell.html(badgeHtml);

                // cập nhật luôn ghi chú của admin (nếu có)
                $(`#note-${requestId}`).text(data.admin_note || '-');
            });
        });
    }

    // Polling mỗi 3 giây (1 giây hơi nặng)
    setInterval(fetchReturnStatuses, 1000);
</script>
@endsection

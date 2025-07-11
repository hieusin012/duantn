@extends('admin.layouts.index')
@section('title', 'Quản lý yêu cầu trả hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table text-center">
                            <tr>
                                <th width="10">ID</th>
                                <th>Người dùng</th>
                                <th>Mã đơn</th>
                                <th>Lý do</th>
                                <th>Hoàn tiền qua</th>
                                <th>Trạng thái</th>
                                <th>Ngày gửi</th>
                                <th>Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $req)
                            <tr>
                                <td class="text-center">{{ $req->id }}</td>
                                <td>{{ $req->user->fullname ?? '-' }}</td>
                                <td>{{ $req->order->code ?? '-' }}</td>
                                <td>{{ Str::limit($req->reason, 40) }}</td>
                                <td class="text-center">
                                    @if($req->refund_method === 'bank_transfer')
                                        <span class="badge bg-secondary">Ngân hàng</span>
                                    @elseif($req->refund_method === 'wallet')
                                        <span class="badge bg-primary">Ví điện tử</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @switch($req->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success">Chấp nhận</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">Từ chối</span>
                                            @break
                                        @case('refunded')
                                            <span class="badge bg-info text-dark">Đã hoàn tiền</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">Không rõ</span>
                                    @endswitch
                                </td>
                                <td class="text-center">{{ $req->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.return-requests.show', $req->id) }}" class="btn btn-sm btn-primary" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="pagination justify-content-center mt-3">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

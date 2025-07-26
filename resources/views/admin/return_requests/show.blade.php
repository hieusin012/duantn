@extends('admin.layouts.index')
@section('title', 'Chi tiết yêu cầu trả hàng')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile p-4">
                <h3 class="tile-title mb-4 text-primary">Chi tiết yêu cầu #{{ $request->id }}</h3>

                <div class="container">
                    {{-- Thông tin chung --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Người yêu cầu:</strong>
                            <div class="text-muted">{{ $request->user->fullname ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <strong>Đơn hàng:</strong>
                            <div class="text-muted">{{ $request->order->code ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>Lý do:</strong>
                        <div class="text-muted">{{ $request->reason }}</div>
                    </div>

                    {{-- Phương thức hoàn tiền --}}
                    <div class="mb-3">
                        <strong>Phương thức hoàn tiền:</strong>
                        <div class="text-muted">
                            @if ($request->refund_method === 'bank_transfer')
                                Chuyển khoản ngân hàng
                            @elseif ($request->refund_method === 'wallet')
                                Ví điện tử
                            @else
                                -
                            @endif
                        </div>
                    </div>

                    @if ($request->refund_method === 'bank_transfer')
                        <div class="mb-3">
                            <strong>Số tài khoản ngân hàng:</strong>
                            <div class="text-muted">{{ $request->bank_account ?? '-' }}</div>
                        </div>
                    @endif

                    @if ($request->refund_method === 'wallet')
                        <div class="mb-3">
                            <strong>Thông tin ví điện tử:</strong>
                            <div class="text-muted">{{ $request->wallet_info ?? '-' }}</div>
                        </div>
                    @endif

                    {{-- Ảnh minh chứng --}}
                    <div class="mb-4">
                        <strong>Ảnh minh chứng:</strong><br>
                        @if ($request->image)
                            <img src="{{ asset('storage/' . $request->image) }}" alt="proof" class="img-thumbnail mt-2" style="max-width: 300px;">
                        @else
                            <div class="text-muted">Không có ảnh</div>
                        @endif
                    </div>

                    {{-- Form cập nhật --}}
                    <form action="{{ route('admin.return-requests.update', $request->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status" class="form-label fw-bold">Trạng thái</label>
                            {{-- <select name="status" id="status" class="form-control">
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Chấp nhận</option>
                                <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                                <option value="refunded" {{ $request->status == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
                            </select> --}}
                            <select name="status" id="status" class="form-control" {{ $request->status === 'refunded' ? 'disabled' : '' }}>
                                @php $status = $request->status; @endphp

                                @if ($status === 'pending')
                                    <option value="pending" selected>Chờ duyệt</option>
                                    <option value="approved">Chấp nhận</option>
                                    <option value="rejected">Từ chối</option>
                                @elseif ($status === 'approved')
                                    <option value="approved" selected>Chấp nhận</option>
                                    <option value="refunded">Đã hoàn tiền</option>
                                @elseif ($status === 'rejected')
                                    <option value="rejected" selected>Từ chối</option>
                                    <option value="approved">→ Chấp nhận lại (sửa nhầm)</option>
                                @elseif ($status === 'refunded')
                                    <option value="refunded" selected>Đã hoàn tiền</option>
                                @endif
                            </select>
                            @if ($request->status === 'refunded')
                                <small class="text-danger mt-1 d-block">Đơn hàng đã hoàn tiền, không thể thay đổi trạng thái.</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="admin_note" class="form-label fw-bold">Ghi chú (Hỗ trợ khách hàng)</label>
                            <textarea name="admin_note" class="form-control" rows="3" placeholder="Phản hồi đến khách hàng...">{{ $request->admin_note }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.return-requests.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

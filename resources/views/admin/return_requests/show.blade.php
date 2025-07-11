@extends('admin.layouts.index')
@section('title', 'Chi tiết yêu cầu trả hàng')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chi tiết yêu cầu #{{ $request->id }}</h3>
                <div class="container">


                    <div class="mb-3">
                        <strong>Người yêu cầu:</strong> {{ $request->user->fullname ?? '-' }}
                    </div>
                    <div class="mb-3">
                        <strong>Đơn hàng:</strong> {{ $request->order->code ?? '-' }}
                    </div>
                    <div class="mb-3">
                        <strong>Lý do:</strong> {{ $request->reason }}
                    </div>
                    <div class="mb-3">
                        <strong>Phương thức hoàn tiền:</strong>
                        {{ $request->refund_method === 'bank_transfer' ? 'Chuyển khoản ngân hàng' : ($request->refund_method === 'wallet' ? 'Ví điện tử' : '-') }}
                    </div>

                    @if ($request->refund_method === 'bank_transfer')
                        <div class="mb-3">
                            <strong>Số tài khoản ngân hàng:</strong> {{ $request->bank_account ?? '-' }}
                        </div>
                    @endif

                    @if ($request->refund_method === 'wallet')
                        <div class="mb-3">
                            <strong>Thông tin ví điện tử:</strong> {{ $request->wallet_info ?? '-' }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <strong>Ảnh minh chứng:</strong><br>
                        @if ($request->image)
                            <img src="{{ asset('storage/' . $request->image) }}" alt="proof" width="200">
                        @else
                            Không có ảnh
                        @endif
                    </div>

                    <form action="{{ route('admin.return-requests.update', $request->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" class="form-control">
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Chờ duyệt
                                </option>
                                <option value="approved" {{ $request->status == 'approved' ? 'selected' : '' }}>Chấp nhận
                                </option>
                                <option value="rejected" {{ $request->status == 'rejected' ? 'selected' : '' }}>Từ chối
                                </option>
                                <option value="refunded" {{ $request->status == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="admin_note">Ghi chú (Hỗ trợ khách hàng)</label>
                            <textarea name="admin_note" class="form-control" rows="3" placeholder="Phản hồi đến khách hàng...">{{ $request->admin_note }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Cập nhật</button>
                        <a href="{{ route('admin.return-requests.index') }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

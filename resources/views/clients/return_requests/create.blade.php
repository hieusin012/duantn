@extends('clients.layouts.master')
@section('title', 'Yêu cầu trả hàng')

@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4">
        <div class="card-header text-dark rounded-top-4" style="background-color: #d1f2eb;">

            <h4 class="mb-0"><i class="bi bi-box-arrow-in-left me-2"></i>Yêu cầu trả hàng - Mã đơn: {{ $order->code }}</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('client.return-requests.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Lý do trả hàng <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control rounded-3" rows="4" placeholder="Vui lòng mô tả lý do...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Phương thức hoàn tiền</label>
                    <select name="refund_method" class="form-select" id="refund_method">
                        <option value="">-- Chọn phương thức --</option>
                        <option value="bank_transfer" {{ old('refund_method') == 'bank_transfer' ? 'selected' : '' }}>Chuyển khoản ngân hàng</option>
                        <option value="wallet" {{ old('refund_method') == 'wallet' ? 'selected' : '' }}>Ví điện tử</option>
                    </select>
                    @error('refund_method')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mt-2" id="bank-info" style="display:none;">
                        <label>Số tài khoản ngân hàng</label>
                        <input type="text" name="bank_account" class="form-control" placeholder="Nhập STK ngân hàng" value="{{ old('bank_account') }}">
                        @error('bank_account')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-2" id="wallet-info" style="display:none;">
                        <label>Thông tin ví điện tử</label>
                        <input type="text" name="wallet_info" class="form-control" placeholder="Nhập tên ví hoặc SĐT ví" value="{{ old('wallet_info') }}">
                        @error('wallet_info')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Ảnh minh chứng <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control rounded-3">
                    <small class="text-muted">Vui lòng chọn lại ảnh nếu có lỗi khi gửi.</small>
                    @error('image')
                        <div class="text-danger small fw-bold">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-3">
                        <i class="bi bi-send-check me-1"></i> Gửi yêu cầu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const methodSelect = document.getElementById('refund_method');
    const bankInfo = document.getElementById('bank-info');
    const walletInfo = document.getElementById('wallet-info');

    function toggleFields(value) {
        bankInfo.style.display = value === 'bank_transfer' ? 'block' : 'none';
        walletInfo.style.display = value === 'wallet' ? 'block' : 'none';
    }

    methodSelect.addEventListener('change', function () {
        toggleFields(this.value);
    });

    // Gọi lúc load lại trang để giữ trạng thái form
    toggleFields(methodSelect.value);
</script>
@endpush


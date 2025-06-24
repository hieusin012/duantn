@extends('admin.layouts.index')

@section('title', 'Chỉnh sửa voucher')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chỉnh sửa voucher: <strong>{{ $voucher->code }}</strong></h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group col-md-4">
                        <label class="control-label">Mã voucher</label>
                        <input class="form-control" type="text" name="code" maxlength="10" value="{{ old('code', $voucher->code) }}" readonly>
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Giảm giá</label>
                        <input class="form-control" type="number" name="discount" min="0" step="0.01" value="{{ old('discount', $voucher->discount) }}">
                        @error('discount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Loại giảm giá</label>
                        <select class="form-control" name="discount_type">
                            <option value="percent" {{ old('discount_type', $voucher->discount_type) == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                            <option value="fixed" {{ old('discount_type', $voucher->discount_type) == 'fixed' ? 'selected' : '' }}>Cố định (VNĐ)</option>
                        </select>
                        @error('discount_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Số lượng</label>
                        <input class="form-control" type="number" name="quantity" min="1" value="{{ old('quantity', $voucher->quantity) }}">
                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Đã dùng</label>
                        <input class="form-control" type="number" name="used" min="0" value="{{ old('used', $voucher->used) }}">
                        @error('used')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Giảm tối đa</label>
                        <input class="form-control" type="number" name="max_price" step="0.01" value="{{ old('max_price', $voucher->max_price) }}">
                        @error('max_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Ngày bắt đầu</label>
                        <input class="form-control" type="date" name="start_date" value="{{ old('start_date', $voucher->start_date) }}">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Ngày kết thúc</label>
                        <input class="form-control" type="date" name="end_date" value="{{ old('end_date', $voucher->end_date) }}">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label class="control-label">Tình trạng</label>
                        <select class="form-control" name="is_active">
                            <option value="1" {{ old('is_active', $voucher->is_active) == '1' ? 'selected' : '' }}>Kích hoạt</option>
                            <option value="0" {{ old('is_active', $voucher->is_active) == '0' ? 'selected' : '' }}>Vô hiệu</option>
                        </select>
                        @error('is_active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Cập nhật</button>
                        <a class="btn btn-cancel" href="{{ route('admin.vouchers.index') }}">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

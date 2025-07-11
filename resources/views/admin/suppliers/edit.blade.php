@extends('admin.layouts.index')

@section('title', isset($supplier) ? 'Cập nhật nhà cung cấp' : 'Thêm nhà cung cấp')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">{{ isset($supplier) ? 'Cập nhật' : 'Thêm' }} nhà cung cấp</h3>
            <div class="tile-body">
                <form class="row" action="{{ isset($supplier) ? route('admin.suppliers.update', $supplier->id) : route('admin.suppliers.store') }}" method="POST">
                    @csrf
                    @if(isset($supplier)) @method('PUT') @endif

                    <div class="form-group col-md-4">
                        <label class="control-label">Tên nhà cung cấp</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label class="control-label">Số điện thoại</label>
                        <input class="form-control" type="text" name="phone" value="{{ old('phone', $supplier->phone ?? '') }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label">Địa chỉ</label>
                        <input class="form-control" type="text" name="address" value="{{ old('address', $supplier->address ?? '') }}">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label">Ghi chú</label>
                        <textarea class="form-control" name="note">{{ old('note', $supplier->note ?? '') }}</textarea>
                        @error('note')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Trạng thái</label>
                        <select class="form-control" name="is_active">
                            <option value="1" {{ old('is_active', $supplier->is_active ?? 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('is_active', $supplier->is_active ?? 1) == 0 ? 'selected' : '' }}>Tạm khóa</option>
                        </select>
                        @error('is_active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <button class="btn btn-save" type="submit">{{ isset($supplier) ? 'Cập nhật' : 'Lưu' }}</button>
                        <a class="btn btn-cancel" href="{{ route('admin.suppliers.index') }}">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

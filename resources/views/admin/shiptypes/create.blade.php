@extends('admin.layouts.index')

@section('title', 'Thêm loại ship')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Tạo mới loại ship</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.shiptypes.store') }}" method="POST">
                    @csrf

                    <div class="form-group col-md-6">
                        <label class="control-label">Tên loại ship</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label">Giá tiền (VNĐ)</label>
                        <input class="form-control" type="number" name="price" min="0" step="1000" value="{{ old('price') }}">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Lưu lại</button>
                        <a class="btn btn-cancel" href="{{ route('admin.shiptypes.index') }}">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

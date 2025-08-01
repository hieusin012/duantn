@extends('admin.layouts.index')

@section('title', 'Thêm mới kích cỡ')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Thêm mới kích cỡ</h3>
            <div class="tile-body">
                <form action="{{ route('admin.sizes.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên kích cỡ</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" maxlength="255" placeholder="VD: M, L, XL">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label">Giá trị kích cỡ</label>
                        <input type="number" class="form-control" id="value" name="value" value="{{ old('value', $size->value ?? '') }}" min="1" step="1" placeholder="VD: 36, 37, 38">
                        @error('value')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-save btn-sm">
                        Lưu
                    </button>
                    <a href="{{ route('admin.sizes.index') }}" class="btn btn-cancel btn-sm">
                        Quay lại
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

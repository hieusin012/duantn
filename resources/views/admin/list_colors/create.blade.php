@extends('admin.layouts.index')

@section('title', 'Tạo mới màu sắc')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Thêm màu sắc</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.colors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-3">
                        <label class="control-label">Tên màu sắc</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Mã màu</label>
                        <input class="form-control form-control-color" type="color" name="color_code" id="color_code" value="{{ old('color_code', '#000000') }}">
                        @error('color_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Lưu</button>
                        <a class="btn btn-cancel" href="{{ route('admin.colors.index') }}">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
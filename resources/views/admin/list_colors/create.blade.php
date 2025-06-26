@extends('admin.layouts.index')

@section('title', 'Chỉnh sửa màu sắc')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chỉnh sửa màu sắc</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.colors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-3">
                        <label class="control-label">Tên màu sắc</label>
                        <input class="form-control" type="text" name="name" id="name" value="">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Mã màu</label>
                        <input class="form-control form-control-color" type="color" name="color_code" id="color_code" value="#000000">
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
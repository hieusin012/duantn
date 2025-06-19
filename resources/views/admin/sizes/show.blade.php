@extends('admin.layouts.index')

@section('title', 'Chi tiết kích cỡ')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chi tiết kích cỡ</h3>
            <div class="tile-body">
                <p><strong>ID:</strong> {{ $size->id }}</p>
                <p><strong>Tên:</strong> {{ $size->name }}</p>
                <p><strong>Ngày tạo:</strong> {{ $size->created_at }}</p>
                <p><strong>Ngày cập nhật:</strong> {{ $size->updated_at }}</p>

                <a href="{{ route('admin.sizes.index') }}" class="btn btn-cancel btn-sm">
                    Quay lại
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

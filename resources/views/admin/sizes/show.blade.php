@extends('admin.layouts.index')

@section('content')
    <h1>Chi tiết Size</h1>

    <p><strong>ID:</strong> {{ $size->id }}</p>
    <p><strong>Tên:</strong> {{ $size->name }}</p>
    <p><strong>Ngày tạo:</strong> {{ $size->created_at }}</p>
    <p><strong>Ngày cập nhật:</strong> {{ $size->updated_at }}</p>

    <a href="{{ route('sizes.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection

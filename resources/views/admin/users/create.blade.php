@extends('admin.layouts.index')

@section('title', 'Thêm mới')

@section('content')
<div class="container">
    <h3 class="tile-title">Thêm người dùng mới</h3>
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @include('admin.users.form')

        <button type="submit" class="btn btn-save">Lưu</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">Quay lại</a>
    </form>
</div>
@endsection

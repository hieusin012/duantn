@extends('admin.layouts.index')

@section('title', 'Chỉnh sửa')

@section('content')
<div class="container">
    <h3 class="tile-title">Chỉnh sửa người dùng</h3>
    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @include('admin.users.form', ['user' => $user])

        <button type="submit" class="btn btn-save">Cập nhật</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">Quay lại</a>
    </form>
</div>
@endsection

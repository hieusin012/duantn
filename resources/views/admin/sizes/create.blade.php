@extends('admin.layouts.index')

@section('content')
    <h1>Thêm mới kích cỡ</h1>

    <form action="{{ route('admin.sizes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên kích cỡ</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" maxlength="255">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-save">Lưu</button>
        <a href="{{ route('admin.sizes.index') }}" class="btn btn-cancel">Quay lại</a>
    </form>
@endsection
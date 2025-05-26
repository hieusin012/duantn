@extends('admin.layouts.index')

@section('content')
    <h1>Chỉnh sửa Size</h1>

    <form action="{{ route('sizes.update', $size->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên size</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $size->name) }}" required maxlength="255">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('sizes.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection

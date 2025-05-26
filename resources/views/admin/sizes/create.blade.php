@extends('admin.layouts.index')

@section('content')
    <h1>Thêm mới Size</h1>

    <form action="{{ route('sizes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên size</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required maxlength="255">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
        <a href="{{ route('sizes.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
@endsection

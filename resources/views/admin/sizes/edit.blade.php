@extends('admin.layouts.index')

@section('title', 'Sửa kích cỡ')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chỉnh sửa kích cỡ</h3>
            <div class="tile-body">
                <form action="{{ route('admin.sizes.update', $size->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên kích cỡ</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $size->name) }}" required maxlength="255">
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-save btn-sm">
                        Cập nhật
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

@extends('admin.layouts.index')


@section('content')
<h1>Thêm danh mục mới</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">Tên danh mục</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" >
    </div>

    <div class="mb-3">
        <label for="parent_id" class="form-label">Danh mục cha</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="">-- Không chọn --</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Ảnh đại diện</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label for="is_active" class="form-label">Trạng thái</label>
        <select name="is_active" id="is_active" class="form-control" required>
            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Kích hoạt</option>
            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Không kích hoạt</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Thêm mới</button>
</form>
@endsection

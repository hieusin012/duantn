@extends('admin.layouts.index')

@section('content')
<h1>Sửa danh mục: {{ $category->name }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Tên danh mục</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" >
    </div>

    <div class="mb-3">
        <label for="parent_id" class="form-label">Danh mục cha</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="">-- Không chọn --</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ (old('parent_id', $category->parent_id) == $parent->id) ? 'selected' : '' }}>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Ảnh đại diện</label><br>
        @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="80"><br>
        @endif
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label for="is_active" class="form-label">Trạng thái</label>
        <select name="is_active" id="is_active" class="form-control" required>
            <option value="1" {{ (old('is_active', $category->is_active) == '1') ? 'selected' : '' }}>Kích hoạt</option>
            <option value="0" {{ (old('is_active', $category->is_active) == '0') ? 'selected' : '' }}>Không kích hoạt</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection

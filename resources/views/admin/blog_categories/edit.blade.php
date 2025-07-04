@extends('admin.layouts.index')

@section('title', 'Sửa danh mục bài viết')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chỉnh sửa danh mục: {{ $blogCategory->name }}</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.blog-categories.update', $blogCategory->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group col-md-4">
                        <label for="name">Tên danh mục:</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $blogCategory->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="slug">Slug:</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $blogCategory->slug) }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="parent_id">Danh mục cha:</label>
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="">-- Không có --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $blogCategory->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="is_active" class="d-block">Trạng thái:</label>
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" {{ old('is_active', $blogCategory->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Hiển thị danh mục</label>
                        </div>
                    </div>

                    <div class="form-group col-md-12 mt-3">
                        <button type="submit" class="btn btn-save">Cập nhật</button>
                        <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-cancel">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function slugify(str) {
        return str.toString().toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/đ/g, 'd')
            .replace(/[^a-z0-9\s-]/g, '')
            .trim().replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }

    document.getElementById('name').addEventListener('input', function () {
        document.getElementById('slug').value = slugify(this.value);
    });
</script>
@endsection

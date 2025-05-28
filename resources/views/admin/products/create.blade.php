@extends('admin.layouts.index')

@section('content')
<h1>Thêm sản phẩm mới</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="code" class="form-label">Mã sản phẩm</label>
        <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $code ?? '') }}" readonly>
        <small class="text-muted">Tự động tạo mã</small>
    </div>
    
    

    <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="Nhập tên sản phẩm">
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Ảnh sản phẩm</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Giá</label>
        <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ old('price') }}" required placeholder="Nhập giá sản phẩm">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea name="description" id="description" class="form-control" placeholder="Mô tả chi tiết sản phẩm">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Trạng thái</label>
        <select name="status" id="status" class="form-select" required>
            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="is_active" class="form-label">Kích hoạt</label>
        <select name="is_active" id="is_active" class="form-select" required>
            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Có</option>
            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Không</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Danh mục</label>
        <select name="category_id" id="category_id" class="form-select" required>
            <option value="">-- Chọn danh mục --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="brand_id" class="form-label">Thương hiệu</label>
        <select name="brand_id" id="brand_id" class="form-select" required>
            <option value="">-- Chọn thương hiệu --</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection

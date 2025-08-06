@extends('admin.layouts.index')

@section('title', 'Tạo mới biến thể sản phẩm')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
            <h4 class="mb-0"><i class="bi bi-plus-square me-2"></i> Tạo biến thể sản phẩm</h4>
            <a href="{{ route('admin.product-variants.index') }}" class="btn btn-sm btn-light text-primary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="bi bi-exclamation-triangle-fill text-danger"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.product-variants.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6 mb-2">
                        <label for="product_id" class="form-label fw-semibold">Sản phẩm <span class="text-danger">*</span></label>
                        <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Chọn sản phẩm --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="color_id" class="form-label fw-semibold">Màu sắc <span class="text-danger">*</span></label>
                        <select name="color_id" id="color_id" class="form-control @error('color_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Chọn màu sắc --</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('color_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="size_id" class="form-label fw-semibold">Kích thước <span class="text-danger">*</span></label>
                        <select name="size_id" id="size_id" class="form-control @error('size_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Chọn kích thước --</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('size_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="price" class="form-label fw-semibold">Giá tiền <span class="text-danger">*</span></label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" required min="0" step="0.01" placeholder="Nhập giá gốc">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="sale_price" class="form-label fw-semibold">Giá khuyến mãi</label>
                        <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" class="form-control @error('sale_price') is-invalid @enderror" min="0" step="0.01" placeholder="Nhập giá khuyến mãi nếu có">
                        @error('sale_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="quantity" class="form-label fw-semibold">Số lượng <span class="text-danger">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control @error('quantity') is-invalid @enderror" required min="0" placeholder="Nhập số lượng tồn kho">
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="sale_start_date" class="form-label fw-semibold">Ngày bắt đầu giảm giá</label>
                        <input type="date" name="sale_start_date" id="sale_start_date" value="{{ old('sale_start_date') }}" class="form-control @error('sale_start_date') is-invalid @enderror">
                        @error('sale_start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="sale_end_date" class="form-label fw-semibold">Ngày kết thúc giảm giá</label>
                        <input type="date" name="sale_end_date" id="sale_end_date" value="{{ old('sale_end_date') }}" class="form-control @error('sale_end_date') is-invalid @enderror">
                        @error('sale_end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="image" class="form-label fw-semibold">Ảnh sản phẩm (có thể chọn nhiều)</label>
                        <input type="file" name="image" id="image" class="form-control" multiple accept="image/*">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="bi bi-save2-fill me-1"></i> Lưu biến thể
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

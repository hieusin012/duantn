@extends('admin.layouts.index')

@section('title', 'Tạo mới biến thể sản phẩm')

@section('content')
<div class="container">
    <h2>Tạo biến thể sản phẩm</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.product-variants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="product_id" class="form-label">Sản phẩm <span class="text-danger">*</span></label>
            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            @error('product_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="color_id" class="form-label">Màu sắc <span class="text-danger">*</span></label>
            <select name="color_id" id="color_id" class="form-control @error('color_id') is-invalid @enderror" required>
                @foreach ($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
            @error('color_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="size_id" class="form-label">Kích thước <span class="text-danger">*</span></label>
            <select name="size_id" id="size_id" class="form-control @error('size_id') is-invalid @enderror" required>
                @foreach ($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
            @error('size_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá tiền <span class="text-danger">*</span></label>
            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" required min="0" step="0.01">
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_price" class="form-label">Giá khuyến mãi</label>
            <input type="number" name="sale_price" id="sale_price" class="form-control @error('sale_price') is-invalid @enderror" min="0" step="0.01">
            @error('sale_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_start" class="form-label">Ngày bắt đầu giảm giá</label>
            <input type="date" name="sale_start" id="sale_start" class="form-control @error('sale_start') is-invalid @enderror">
            @error('sale_start')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_end" class="form-label">Ngày kết thúc giảm giá</label>
            <input type="date" name="sale_end" id="sale_end" class="form-control @error('sale_end') is-invalid @enderror">
            @error('sale_end')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" required min="0">
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Ảnh sản phẩm (nhiều ảnh)</label>
            <input type="file" name="image" class="form-control" multiple accept="image/*">
        </div>
        

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
@endsection
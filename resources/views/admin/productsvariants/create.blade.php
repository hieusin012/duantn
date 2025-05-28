@extends('admin.layouts.index')

@section('content')
<div class="container">
    <h2 class="my-3">Thêm biến thể cho sản phẩm: {{ $product->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('productVariants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="mb-3">
            <label for="color_id" class="form-label">Màu sắc</label>
            <select id="color_id" name="color_id" class="form-select @error('color_id') is-invalid @enderror" required>
                <option value="">-- Chọn màu sắc --</option>
                @foreach($colors as $color)
                    <option value="{{ $color->id }}" {{ old('color_id') == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                @endforeach
            </select>
            @error('color_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="size_id" class="form-label">Kích cỡ</label>
            <select id="size_id" name="size_id" class="form-select @error('size_id') is-invalid @enderror" required>
                <option value="">-- Chọn kích cỡ --</option>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}" {{ old('size_id') == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                @endforeach
            </select>
            @error('size_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" class="form-control @error('quantity') is-invalid @enderror" min="0" required>
            @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" id="price" name="price" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" min="0" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_price" class="form-label">Giá khuyến mãi (tuỳ chọn)</label>
            <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" class="form-control @error('sale_price') is-invalid @enderror" min="0">
            @error('sale_price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_start_date" class="form-label">Ngày bắt đầu sale</label>
            <input type="date" id="sale_start_date" name="sale_start_date" value="{{ old('sale_start_date', $productVariant->sale_start_date ?? '') }}" class="form-control @error('sale_start_date') is-invalid @enderror">
            @error('sale_start_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sale_end_date" class="form-label">Ngày kết thúc sale</label>
            <input type="date" id="sale_end_date" name="sale_end_date" value="{{ old('sale_end_date', $productVariant->sale_end_date ?? '') }}" class="form-control @error('sale_end_date') is-invalid @enderror">
            @error('sale_end_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Ảnh sản phẩm (có thể chọn nhiều ảnh)</label>
            <input type="file" id="images" name="images[]" multiple class="form-control @error('images') is-invalid @enderror" accept="image/*">
            @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success mt-3">Thêm mới</button>
        <a href="{{ route('productVariants.index', $product->id) }}" class="btn btn-secondary mt-3 ms-2">Quay lại</a>
    </form>
</div>
@endsection

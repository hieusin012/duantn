@extends('admin.layouts.index')

@section('content')
    <h1>Chi tiết sản phẩm: {{ $product->name }}</h1>

    <p><strong>Mã sản phẩm:</strong> {{ $product->code }}</p>
    <p><strong>Slug:</strong> {{ $product->slug }}</p>
    <p><strong>Giá:</strong> {{ number_format($product->price) }} VND</p>
    <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
    <p><strong>Thương hiệu:</strong> {{ $product->brand->name }}</p>
    <p><strong>Trạng thái:</strong> {{ $product->status ? 'Còn hàng' : 'Hết hàng' }}</p>
    <p><strong>Hoạt động:</strong> {{ $product->is_active ? 'Hiển thị' : 'Ẩn' }}</p>
    <p><strong>Mô tả:</strong> {{ $product->description }}</p>

    @if ($product->image)
        <p><strong>Hình ảnh:</strong></p>
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="200">
    @endif
    <div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Quay lại danh sách</a>

    </div>

  
@endsection

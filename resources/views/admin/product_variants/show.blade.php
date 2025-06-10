@extends('admin.layouts.index')

@section('title', 'Chi tiết biến thể sản phẩm')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chi tiết biến thể sản phẩm</h3>
            <div class="tile-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Sản phẩm:</strong> {{ $productVariant->product->name ?? 'N/A' }}</p>
                        <p><strong>Màu sắc:</strong> {{ $productVariant->color->name ?? 'N/A' }}</p>
                        <p><strong>Kích thước:</strong> {{ $productVariant->size->name ?? 'N/A' }}</p>
                        <p><strong>Giá tiền:</strong> {{ number_format($productVariant->price, 0, ',', '.') }} đ</p>
                        <p><strong>Giá khuyến mãi:</strong> {{ $productVariant->sale_price ? number_format($productVariant->sale_price, 0, ',', '.') : 'N/A' }} đ</p>
                        <p><strong>Số lượng:</strong> {{ $productVariant->quantity }}</p>
                    </div>
                    <td>
                        @if ($productVariant->image)Ảnh Sản Phẩm:
                            <img src="{{ asset('storage/' . $productVariant->image) }}" alt="Ảnh biến thể"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <span>Không có ảnh</span>
                        @endif                       
                    <td>
                </div>
                <a href="{{ route('admin.product-variants.index') }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('admin.product-variants.edit', $productVariant->id) }}" class="btn btn-primary">Sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection
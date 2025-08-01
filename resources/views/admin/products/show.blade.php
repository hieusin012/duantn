@extends('admin.layouts.index')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<style>
    .product-detail-label {
        font-weight: 600;
        color: #495057;
    }
    .product-detail-value {
        color: #212529;
    }
    .product-image {
        width: 120px;
        height: auto;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }
    .product-box {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .badge-status {
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 20px;
    }
</style>

<div class="container-fluid mb-5">
    <div class="product-box">
        <h4 class="mb-4">📦 Chi tiết sản phẩm</h4>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="product-detail-label">Mã sản phẩm:</div>
                <div class="product-detail-value">{{ $product->code }}</div>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Tên sản phẩm:</div>
                <div class="product-detail-value">{{ $product->name }}</div>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Slug:</div>
                <div class="product-detail-value">{{ $product->slug }}</div>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Danh mục:</div>
                <div class="product-detail-value">{{ $product->category->name ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="product-detail-label">Nhà cung cấp:</div>
                <div class="product-detail-value">{{ $product->brand->name ?? 'N/A' }}</div>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Giá bán:</div>
                <div class="product-detail-value text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</div>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Trạng thái:</div>
                <span class="badge-status {{ $product->status == 1 ? 'bg-success' : 'bg-secondary' }}">
                    {{ $product->status == 1 ? 'Kích hoạt' : 'Không kích hoạt' }}
                </span>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Tình trạng kho:</div>
                <span class="badge-status {{ $product->is_active == 1 ? 'bg-info' : 'bg-danger' }}">
                    {{ $product->is_active == 1 ? 'Còn hàng' : 'Hết hàng' }}
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="product-detail-label">Hot Deal:</div>
                <div class="product-detail-value">{{ $product->is_hot_deal ? 'Có' : 'Không' }}</div>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Giảm giá:</div>
                <div class="product-detail-value">{{ $product->discount_percent ? $product->discount_percent . '%' : '0%' }}</div>
            </div>
            <div class="col-md-3">
                <div class="product-detail-label">Hết hạn ưu đãi:</div>
                <div class="product-detail-value">{{ $product->deal_end_at ? \Carbon\Carbon::parse($product->deal_end_at)->format('H:i d/m/Y') : 'Không có' }}</div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="product-detail-label mb-2">Ảnh sản phẩm:</div>
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" class="product-image" alt="{{ $product->name }}">
                @else
                    <div class="text-muted">Không có ảnh</div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="product-detail-label mb-2">Mô tả sản phẩm:</div>
                <div class="border rounded p-3" style="min-height: 200px; background: #f8f9fa;">
                    {!! $product->description !!}
                </div>
            </div>
        </div>

        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            ← Quay lại danh sách
        </a>
    </div>
</div>
@endsection

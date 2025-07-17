@extends('admin.layouts.index')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chi tiết sản phẩm</h3>
            <div class="tile-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Mã sản phẩm:</strong> {{ $product->code }}</div>
                    <div class="col-md-3"><strong>Tên sản phẩm:</strong> {{ $product->name }}</div>
                    <div class="col-md-3"><strong>Slug:</strong> {{ $product->slug }}</div>
                    <div class="col-md-3"><strong>Danh mục:</strong> {{ $product->category->name ?? 'N/A' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Nhà cung cấp:</strong> {{ $product->brand->name ?? 'N/A' }}</div>
                    <div class="col-md-3"><strong>Giá bán:</strong> {{ number_format($product->price, 0, ',', '.') }} đ</div>
                    <div class="col-md-3"><strong>Trạng thái:</strong> 
                        <span class="badge badge-{{ $product->status == 1 ? 'success' : 'secondary' }}">
                            {{ $product->status == 1 ? 'Kích hoạt' : 'Không kích hoạt' }}
                        </span>
                    </div>
                    <div class="col-md-3"><strong>Tình trạng:</strong> 
                        <span class="badge badge-{{ $product->is_active == 1 ? 'info' : 'danger' }}">
                            {{ $product->is_active == 1 ? 'Còn hàng' : 'Hết hàng' }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Là Hot Deal?:</strong>
                        {{ $product->is_hot_deal ? 'Có' : 'Không' }}
                    </div>
                    <div class="col-md-3"><strong>Phần trăm giảm (%):</strong>
                        {{ $product->discount_percent ? $product->discount_percent . '%' : '0%' }}
                    </div>
                    <div class="col-md-3"><strong>Hết hạn ưu đãi:</strong>
                        {{ $product->deal_end_at ? \Carbon\Carbon::parse($product->deal_end_at)->format('H:i d/m/Y') : 'Không có' }}
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <strong>Ảnh sản phẩm:</strong><br>
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" height="80" width="80px;">
                        @else
                            <p>Không có ảnh</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Mô tả sản phẩm:</strong><br>
                        <div class="border p-3" style="min-height: 200px;">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div>
@endsection

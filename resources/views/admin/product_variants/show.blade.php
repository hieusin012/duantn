@extends('admin.layouts.index')

@section('title', 'Chi tiết biến thể sản phẩm')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Chi tiết biến thể sản phẩm</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Sản phẩm:</strong> {{ $productVariant->product->name ?? 'N/A' }}</p>
                        <p><strong>Màu sắc:</strong> 
                            <span class="badge bg-info">{{ $productVariant->color->name ?? 'N/A' }}</span>
                        </p>
                        <p><strong>Kích thước:</strong> 
                            <span class="badge bg-secondary">{{ $productVariant->size->name ?? 'N/A' }}</span>
                        </p>
                        <p><strong>Giá tiền:</strong> 
                            <span class="text-primary fw-bold">{{ number_format($productVariant->price, 0, ',', '.') }} đ</span>
                        </p>
                        <p><strong>Giá khuyến mãi:</strong>
                            @if ($productVariant->sale_price)
                                <span class="text-danger fw-bold">{{ number_format($productVariant->sale_price, 0, ',', '.') }} đ</span>
                            @else
                                <span class="text-muted">Không có</span>
                            @endif
                        </p>
                        <p><strong>Số lượng trong kho:</strong> {{ $productVariant->quantity }}</p>
                        <p><strong>Ngày bắt đầu khuyến mãi:</strong> 
                            {{ $productVariant->sale_start_date ? $productVariant->sale_start_date->format('d/m/Y') : 'Không có' }}
                        </p>
                        <p><strong>Ngày kết thúc khuyến mãi:</strong> 
                            {{ $productVariant->sale_end_date ? $productVariant->sale_end_date->format('d/m/Y') : 'Không có' }}
                        </p>
                    </div>
                    <div class="col-md-6 text-center">
                        <p><strong>Ảnh sản phẩm</strong></p>
                        @if ($productVariant->image)
                            <img src="{{ asset('storage/' . $productVariant->image) }}" alt="Ảnh biến thể"
                                 class="img-fluid rounded shadow" style="max-height: 220px; object-fit: cover;">
                        @else
                            <p class="text-muted">Không có ảnh</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light d-flex justify-content-between">
                <a href="{{ route('admin.product-variants.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
                <a href="{{ route('admin.product-variants.edit', $productVariant->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-edit"></i> Sửa biến thể
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

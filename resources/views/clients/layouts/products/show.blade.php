@extends('clients.layouts.master')
@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-5">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded border">
        </div>
        <div class="col-md-7">
            <h1 class="fw-bold">{{ $product->name }}</h1>

            <p class="text-muted fs-5">
                <strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VND
            </p>

            <p><strong>Mô tả:</strong> {{ $product->description }}</p>

            <p><strong>Lượt xem:</strong> {{ $product->views }}</p>

            <p><strong>Trạng thái:</strong> 
                @if($product->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-secondary">Đã ẩn</span>
                @endif
            </p>

            <p><strong>Kích hoạt:</strong> 
                @if($product->is_active == 1)
                    <span class="badge bg-primary">Đang bán</span>
                @else
                    <span class="badge bg-danger">Ngưng bán</span>
                @endif
            </p>

            <p><strong>Danh mục:</strong> {{ $product->category->name ?? 'Không rõ' }}</p>
            <p><strong>Thương hiệu:</strong> {{ $product->brand->name ?? 'Không rõ' }}</p>

           

            <button class="btn btn-success mt-3">Thêm vào giỏ hàng</button>
        </div>
    </div>
</div>
@endsection

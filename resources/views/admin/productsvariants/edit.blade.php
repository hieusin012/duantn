@extends('admin.layouts.index')

@section('content')
<div class="container">
    <h2 class="my-3">Sửa biến thể sản phẩm</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('productVariants.update', $productVariant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <input type="hidden" name="product_id" value="{{ $productVariant->product_id }}">

        <div class="form-group">
            <label for="color_id">Màu sắc</label>
            <select name="color_id" class="form-control">
                @foreach($colors as $color)
                    <option value="{{ $color->id }}" {{ $productVariant->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="size_id">Kích cỡ</label>
            <select name="size_id" class="form-control">
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}" {{ $productVariant->size_id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Số lượng</label>
            <input type="number" name="quantity" class="form-control" value="{{ $productVariant->quantity }}">
        </div>

        <div class="form-group">
            <label>Giá</label>
            <input type="number" name="price" class="form-control" value="{{ $productVariant->price }}">
        </div>

        <div class="form-group">
            <label>Giá khuyến mãi</label>
            <input type="number" name="sale_price" class="form-control" value="{{ $productVariant->sale_price }}">
        </div>

        <div class="form-group">
            <label>Ảnh hiện tại</label><br>
            @if($productVariant->image)
                <img src="{{ asset($productVariant->image) }}" width="100">
            @endif
        </div>

        <div class="form-group">
            <label>Thay ảnh mới (nếu có)</label>
            <input type="file" name="image" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-success mt-3">Cập nhật</button>
        <a href="{{ route('productVariants.index', $productVariant->product_id) }}" class="btn btn-secondary mt-3">Quay lại</a>
    </form>
</div>
@endsection

@extends('admin.layouts.index')

@section('title', 'Sửa biến thể sản phẩm')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Sửa biến thể sản phẩm</h3>
            <div class="tile-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.product-variants.update', $productVariant->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="product_id">Sản phẩm</label>
                        <select name="product_id" class="form-control" required>
                            <option value="">Chọn sản phẩm</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ $productVariant->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="color_id">Màu sắc</label>
                        <select name="color_id" class="form-control" required>
                            <option value="">Chọn màu sắc</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}" {{ $productVariant->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="size_id">Kích thước</label>
                        <select name="size_id" class="form-control" required>
                            <option value="">Chọn kích thước</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}" {{ $productVariant->size_id == $size->id ? 'selected' : '' }}>{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Giá tiền</label>
                        <input type="number" name="price" class="form-control" required value="{{ old('price', $productVariant->price) }}">
                    </div>
                    <div class="form-group">
                        <label for="sale_price">Giá khuyến mãi</label>
                        <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $productVariant->sale_price) }}">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Số lượng</label>
                        <input type="number" name="quantity" class="form-control" required value="{{ old('quantity', $productVariant->quantity) }}">
                    </div>
                    <div class="form-group">
                        <label for="image">Ảnh</label>
                        <input type="file" name="image" class="form-control" value="{{ old('image', $productVariant->image) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="{{ route('admin.product-variants.index') }}" class="btn btn-secondary">Hủy</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
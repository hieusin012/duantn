@extends('admin.layouts.index')

@section('title', 'Sửa biến thể sản phẩm')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sửa biến thể sản phẩm</h5>
                <a href="{{ route('admin.product-variants.index') }}" class="btn btn-sm btn-light text-primary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.product-variants.update', $productVariant->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Cột trái -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Sản phẩm <span class="text-danger">*</span></label>
                                <select name="product_id" class="form-control" required>
                                    <option value="">-- Chọn sản phẩm --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ $productVariant->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Màu sắc <span class="text-danger">*</span></label>
                                <select name="color_id" class="form-control" required>
                                    <option value="">-- Chọn màu sắc --</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}" {{ $productVariant->color_id == $color->id ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kích thước <span class="text-danger">*</span></label>
                                <select name="size_id" class="form-control" required>
                                    <option value="">-- Chọn kích thước --</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}" {{ $productVariant->size_id == $size->id ? 'selected' : '' }}>
                                            {{ $size->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Cột phải -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Giá tiền <span class="text-danger">*</span></label>
                                <input type="number" name="price" class="form-control" required value="{{ old('price', $productVariant->price) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Giá khuyến mãi</label>
                                <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $productVariant->sale_price) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Số lượng <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control" required value="{{ old('quantity', $productVariant->quantity) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Ảnh -->
                    <div class="mb-3">
                        <label class="form-label">Ảnh sản phẩm</label>
                        <input type="file" name="image" class="form-control" onchange="previewImage(event)">
                        <div class="mt-2 d-flex gap-3 align-items-start">
                            @if ($productVariant->image)
                                <div>
                                    <p class="mb-1 small text-muted">Ảnh hiện tại:</p>
                                    <img src="{{ asset('storage/' . $productVariant->image) }}" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                                </div>
                            @endif
                            <div id="previewContainer" style="display: none;">
                                <p class="mb-1 small text-muted">Ảnh mới chọn:</p>
                                <img id="preview" class="img-thumbnail" style="width: 120px; height: 120px; object-fit: cover;">
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script preview ảnh -->
@push('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const container = document.getElementById('previewContainer');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    }
</script>
@endpush
@endsection

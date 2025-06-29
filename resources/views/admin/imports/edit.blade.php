@extends('admin.layouts.index')

@section('title', 'Sửa phiếu nhập')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Sửa phiếu nhập: {{ $import->code }}</h3>

            <div class="alert alert-warning">
                ⚠️ Chức năng sửa phiếu nhập có thể ảnh hưởng đến tồn kho. Hãy kiểm tra kỹ trước khi lưu!
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="tile-body">
                <form action="{{ route('admin.imports.update', $import->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="supplier_id" class="control-label">Nhà cung cấp</label>
                            <select name="supplier_id" class="form-control">
                                <option value="">-- Chọn nhà cung cấp --</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $import->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-8">
                            <label for="note" class="control-label">Ghi chú</label>
                            <textarea name="note" class="form-control" rows="1">{{ old('note', $import->note) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <h5>Danh sách sản phẩm nhập</h5>
                        <button type="button" class="btn btn-secondary mb-3" id="add-product"><i class="fas fa-plus"></i> Thêm sản phẩm</button>
                        <table class="table table-bordered" id="product-table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá nhập</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (old('products', $import->details->toArray()) as $index => $detail)
                                <tr>
                                    <td>
                                        <select name="products[{{ $index }}][product_id]" class="form-control">
                                            <option value="">-- Chọn sản phẩm --</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" {{ old("products.$index.product_id", $detail['product_id']) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        @error("products.$index.product_id")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{ $index }}][quantity]" class="form-control" value="{{ old("products.$index.quantity", $detail['quantity']) }}">
                                        @error("products.$index.quantity")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{ $index }}][price]" class="form-control" value="{{ old("products.$index.price", $detail['price']) }}">
                                        @error("products.$index.price")
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-row">Xóa</button></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-save">Cập nhật</button>
                        <a href="{{ route('admin.imports.index') }}" class="btn btn-cancel">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let rowIndex = {{ count(old('products', $import->details)) }};

    document.getElementById('add-product').addEventListener('click', () => {
        const row = `
        <tr>
            <td>
                <select name="products[\${rowIndex}][product_id]" class="form-control" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="products[\${rowIndex}][quantity]" class="form-control" required></td>
            <td><input type="number" name="products[\${rowIndex}][price]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">Xóa</button></td>
        </tr>`;
        document.querySelector('#product-table tbody').insertAdjacentHTML('beforeend', row);
        rowIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endpush

@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã ẩn sản phẩm')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-cancel btn-sm" href="{{ route('admin.products.index') }}" title="Quay lại">Quay lại</a>
                    </div>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
                            <th>Tình trạng</th>
                            <th>Danh mục</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deletedProducts as $product)
                        <tr>
                            <td><input type="checkbox" name="check[]" value="{{ $product->id }}"></td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="80">
                                @else
                                    Không có ảnh
                                @endif
                            </td>
                            <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            <td>
                                @if ($product->is_active)
                                <span class="badge bg-success">Còn hàng</span>
                                @else
                                <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.products.restore', $product->id) }}" title="Khôi phục"><i class="fas fa-undo"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $deletedProducts->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

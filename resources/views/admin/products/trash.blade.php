@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã xóa sản phẩm')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-cancel btn-sm" href="{{ route('admin.products.index') }}" title="Quay lại">Quay lại</a>
                    </div>
                    <form action="{{ route('admin.products.force-delete-all') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-dark btn-sm" title="Xóa tất cả"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tất cả sản phẩm đã xóa mềm?')">
                                <i class="fas fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </div>
                    </form>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá</th>
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
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.products.restore', $product->id) }}" title="Khôi phục"><i class="fas fa-undo"></i></a>
                                <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa vĩnh viễn" onclick="return confirm('Bạn có chắc muốn xóa {{ $product->name }} vĩnh viễn không?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
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

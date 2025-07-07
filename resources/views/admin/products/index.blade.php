@extends('admin.layouts.index')

@section('title', 'Quản lý sản phẩm')

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
                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.products.index') }}" class="container-fluid bg-light p-3 rounded shadow-sm mb-3">
                    <div class="row g-2">
                        {{-- Dòng 1 --}}
                        <div class="col-md-3">
                            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Tìm theo tên, mã sản phẩm..." value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">Tất cả danh mục</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="brand_id" class="form-select form-select-sm">
                                <option value="">Tất cả thương hiệu</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Tất cả trạng thái</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Còn hàng</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Hết hàng</option>
                            </select>
                        </div>
                    </div>
                
                    <div class="row g-2 mt-2">
                        {{-- Dòng 2 --}}
                        <div class="col-md-3">
                            <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Giá từ..." value="{{ request('min_price') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Giá đến..." value="{{ request('max_price') }}">
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-sm w-100">
                                <i class="fa fa-filter"></i> Lọc
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-dark btn-sm w-100">
                                <i class="fa fa-times"></i> Xóa
                            </a>
                        </div>
                     
                    </div>
                </form>
                
                

                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.products.create') }}" title="Thêm"><i class="fas fa-plus"></i> Tạo mới sản phẩm</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập"><i class="fas fa-file-upload"></i> Tải từ file</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm print-file" type="button" title="In"><i class="fas fa-print"></i> In dữ liệu</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm js-textareacopybtn" type="button" title="Sao chép"><i class="fas fa-copy"></i> Sao chép</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="In"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-danger btn-sm" type="button" title="Xóa" href="{{ route('admin.products.trash') }}"><i class="fas fa-trash-alt"></i> Dữ liệu đã xóa</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm" type="button" title="Xóa"><i class="fas fa-trash-alt"></i> Xóa tất cả</a>
                    </div>
                </div>
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá tiền</th>
                            <th>Tình trạng</th>
                            <th>Danh mục</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td width="10"><input type="checkbox" name="check[]" value="{{ $product->id }}"></td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" height="80" width="80px;">
                                @else
                                    <span>Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->is_active ? 'Còn hàng' : 'Hết hàng' }}
                                </span>
                            </td>
                            <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm edit" title="Sửa" data-toggle="modal" data-target="#ModalUP">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary btn-sm trash" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-primary btn-sm" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
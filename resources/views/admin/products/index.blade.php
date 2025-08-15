@extends('admin.layouts.index')

@section('title', 'Quản lý sản phẩm')

@section('content')

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
                            <select name="category_id" class="form-control form-select-sm">
                                <option value="">Tất cả danh mục</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="brand_id" class="form-control form-select-sm">
                                <option value="">Tất cả thương hiệu</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control form-select-sm">
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
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập"><i class="fas fa-file-upload"></i> Tải từ file</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm print-file" type="button" title="In"><i class="fas fa-print"></i> In dữ liệu</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm js-textareacopybtn" type="button" title="Sao chép"><i class="fas fa-copy"></i> Sao chép</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="In"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    </div> --}}
                    <div class="col-sm-2">
                        <a class="btn btn-danger btn-sm" type="button" title="Xóa" href="{{ route('admin.products.trash') }}"><i class="fas fa-trash-alt"></i> Dữ liệu đã xóa</a>
                    </div>
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm" type="button" title="Xóa"><i class="fas fa-trash-alt"></i> Xóa tất cả</a>
                    </div> --}}
                </div>
                <table class="table table-bordered table-hover align-middle text-center" id="sampleTable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col"><input type="checkbox" id="all"></th>
                            <th scope="col">Mã SP</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Tình trạng</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td><input type="checkbox" name="check[]" value="{{ $product->id }}"></td>
                            <td>{{ $product->code }}</td>
                            <td class="text-start">{{ $product->name }}</td>
                            <td>
                                @if ($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded shadow-sm" width="60" height="60">
                                @else
                                <span class="text-muted fst-italic">Không có ảnh</span>
                                @endif
                            </td>
                            <td><b>{{ number_format($product->price, 0, ',', '.') }} ₫</b></td>
                            <td>
                                @if ($product->is_active)
                                <span class="badge bg-success">Còn hàng</span>
                                @else
                                <span class="badge bg-danger">Hết hàng</span>
                                @endif
                            </td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info text-white" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
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
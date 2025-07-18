@extends('admin.layouts.index')

@section('title', 'Quản lý biến thể sản phẩm')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row element-button">
                        <div class="col-sm-2">
                            <a class="btn btn-add btn-sm" href="{{ route('admin.product-variants.create') }}"
                               title="Thêm"><i class="fas fa-plus"></i> Tạo mới biến thể</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập"><i
                                    class="fas fa-file-upload"></i> Tải từ file</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm print-file" type="button" title="In"><i
                                    class="fas fa-print"></i> In dữ liệu</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm js-textareacopybtn" type="button" title="Sao chép"><i
                                    class="fas fa-copy"></i> Sao chép</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-excel btn-sm" href="#" title="In"><i
                                    class="fas fa-file-excel"></i> Xuất Excel</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm pdf-file" type="button" title="In"><i
                                    class="fas fa-file-pdf"></i> Xuất PDF</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm" type="button" title="Xóa"><i
                                    class="fas fa-trash-alt"></i> Xóa tất cả</a>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Kích thước</th>
                            <th>Giá tiền</th>
                            <th>Giá khuyến mãi</th>
                            <th>Số lượng</th>
                            <th>Ảnh</th>
                            <th>Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($variants as $variant)
                            <tr>
                                <td width="10"><input type="checkbox" name="check[]" value="{{ $variant->id }}"></td>
                                <td>{{ $variant->product->name ?? 'N/A' }}</td>
                                <td>{{ $variant->color->name ?? 'N/A' }}</td>
                                <td>{{ $variant->size->name ?? 'N/A' }}</td>
                                <td>{{ number_format($variant->price, 0, ',', '.') }} ₫</td>
                                <td>{{ $variant->sale_price ? number_format($variant->sale_price, 0, ',', '.') : 'N/A' }}
                                    ₫
                                </td>
                                <td>{{ $variant->quantity }}</td>
                                                            
                                <td>
                                    @if ($variant->image)
                                        <img src="{{ asset('storage/' . $variant->image) }}" alt="Ảnh biến thể"
                                             style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <span>Không có ảnh</span>
                                    @endif      
                                </td>                 
                                <td>
                
                                    <a href="{{ route('admin.product-variants.show', $variant->id) }}"
                                       class="btn btn-primary btn-sm" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.product-variants.edit', $variant->id) }}"
                                       class="btn btn-primary btn-sm edit" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.product-variants.destroy', $variant->id) }}"
                                          method="POST" style="display:inline;"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa biến thể này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm trash" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $variants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
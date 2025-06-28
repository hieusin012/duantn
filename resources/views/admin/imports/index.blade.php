@extends('admin.layouts.index')

@section('title', 'Quản lý phiếu nhập')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <!-- Thanh công cụ -->
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.imports.create') }}" title="Thêm">
                            <i class="fas fa-plus"></i> Tạo phiếu nhập
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm print-file" type="button" title="Print">
                            <i class="fas fa-print"></i> In dữ liệu
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm js-textareacopybtn" type="button" title="Copy">
                            <i class="fas fa-copy"></i> Sao chép
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="Export Excel">
                            <i class="fas fa-file-excel"></i> Xuất Excel
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="Export PDF">
                            <i class="fas fa-file-pdf"></i> Xuất PDF
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm" type="button" title="Xóa tất cả">
                            <i class="fas fa-trash-alt"></i> Xóa tất cả
                        </a>
                    </div>
                </div>

                <!-- Bảng dữ liệu -->
                <table class="table table-hover table-bordered" id="imports-table">
                    <thead>
                        <tr>
                            <th>Mã phiếu</th>
                            <th>Nhà cung cấp</th>
                            <th>Người nhập</th>
                            <th>Tổng tiền</th>
                            <th>Ngày tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imports as $import)
                            <tr>
                                <td>{{ $import->code }}</td>
                                <td>{{ $import->supplier->name }}</td>
                                <td>{{ $import->user->fullname }}</td>
                                <td>{{ number_format($import->total_price, 0, ',', '.') }} VND</td>
                                <td>{{ $import->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.imports.show', $import->id) }}" class="btn btn-info btn-sm" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.imports.edit', $import->id) }}" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.imports.destroy', $import->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phiếu này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm trash" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Phân trang -->
                <div class="pagination">
                    {{ $imports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

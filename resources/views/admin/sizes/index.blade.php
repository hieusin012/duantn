@extends('admin.layouts.index')

@section('title', 'Quản lý kích cỡ')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a href="{{ route('admin.sizes.create') }}" class="btn btn-add btn-sm" title="Thêm kích cỡ">
                            <i class="fas fa-plus"></i> Thêm mới kích cỡ
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Import"><i class="fas fa-file-upload"></i> Nhập tệp</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm print-file" type="button" title="Print"><i class="fas fa-print"></i> In dữ liệu</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm js-textareacopybtn" type="button" title="Copy"><i class="fas fa-copy"></i> Sao chép</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="Export"><i class="fas fa-file-excel"></i> Xuất sang Excel</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="Export PDF"><i class="fas fa-file-pdf"></i> Xuất sang PDF</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm" type="button" title="Delete All"><i class="fas fa-trash-alt"></i> Xóa tất cả</a>
                    </div>
                </div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sizes as $size)
                            <tr>
                                <td>{{ $size->id }}</td>
                                <td>{{ $size->name }}</td>
                                <td>{{ $size->created_at }}</td>
                                <td>{{ $size->updated_at }}</td>
                                <td>
                                    <a href="{{ route('admin.sizes.show', $size->id) }}" class="btn btn-info btn-sm" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.sizes.edit', $size->id) }}" class="btn btn-primary btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa kích cỡ này không?');">
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
                    {{ $sizes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã xóa nhà cung cấp')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-cancel btn-sm" href="{{ route('admin.suppliers.index') }}" title="Quay lại">Quay lại</a>
                    </div>

                    <div class="col-sm-3">
                        <form action="{{ route('admin.suppliers.all-eliminate') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete btn-sm text-dark" title="Xóa tất cả"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tất cả nhà cung cấp đã xóa mềm?')">
                                <i class="fas fa-trash-alt text-dark"></i> Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>


                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên nhà cung cấp</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deletedSuppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->email ?? 'Không có' }}</td>
                            <td>{{ $supplier->phone ?? 'Không có' }}</td>
                            <td>{{ $supplier->address ?? 'Không có' }}</td>
                            <td>{{ $supplier->is_active ? 'Hoạt động' : 'Tạm khóa' }}</td>
                            <td>
                                <form action="{{ route('admin.suppliers.restore', $supplier->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" title="Khôi phục"><i class="fas fa-undo"></i></button>
                                </form>

                                <form action="{{ route('admin.suppliers.eliminate', $supplier->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn {{ $supplier->name }} không?')" title="Xóa vĩnh viễn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $deletedSuppliers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

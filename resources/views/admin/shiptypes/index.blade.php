@extends('admin.layouts.index')

@section('title', 'Quản lý loại ship')

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

                <div class="row element-button mb-3">
                    <div class="col-sm-3">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.shiptypes.create') }}" title="Thêm">
                            <i class="fas fa-plus"></i> Tạo mới loại ship
                        </a>
                    </div>
                </div>

                <!-- Tìm kiếm -->
                <form action="{{ route('admin.shiptypes.index') }}" method="GET" class="mb-3 d-flex">
                    <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Tìm kiếm theo tên..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-dark">Tìm</button>
                </form>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên loại ship</th>
                            <th>Giá tiền</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipTypes as $shipType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $shipType->name }}</td>
                                <td>{{ number_format($shipType->price) }} đ</td>
                                <td>
                                    <a href="{{ route('admin.shiptypes.edit', $shipType->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.shiptypes.destroy', $shipType->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa loại ship này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('admin.shiptypes.show', $shipType->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $shipTypes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

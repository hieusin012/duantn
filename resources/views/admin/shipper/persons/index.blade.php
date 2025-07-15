@extends('admin.layouts.index')

@section('title', 'Quản lý danh sách Shipper')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <h5 class="mb-3">Danh sách Shipper</h5>

                <a href="{{ route('admin.shipper.persons.create') }}" class="btn btn-primary mb-3">
                    + Thêm shipper mới
                </a>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shippers as $shipper)
                            <tr>
                                <td>{{ $shipper->id }}</td>
                                <td>{{ $shipper->fullname }}</td>
                                <td>{{ $shipper->email }}</td>
                                <td>{{ $shipper->phone }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $shipper->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $shipper->status == 'active' ? 'Đang hoạt động' : 'Tạm nghỉ' }}
                                    </span>
                                </td>
                                <td>
                                    
                                    <a href="{{ route('admin.shipper.persons.edit', $shipper->id) }}" 
                                       class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>

                                    <form action="{{ route('admin.shipper.persons.destroy', $shipper->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Bạn có chắc chắn xoá?')" 
                                                class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Chưa có shipper nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination mt-3 justify-content-center">
                    {{ $shippers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

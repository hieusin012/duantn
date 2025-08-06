@extends('admin.layouts.index')
@section('title', 'Dữ liệu đã xóa người dùng')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button mb-3">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.users.index') }}"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    </div>
                    <div class="col-sm-3">
                        <form action="{{ route('admin.users.all-eliminate') }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa vĩnh viễn tất cả?')">
                                <i class="fas fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deletedUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'admin' ? 'warning' : 'secondary' }}">
                                    {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                    {{ $user->status === 'active' ? 'Hoạt động' : 'Tạm khóa' }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.users.restore', $user->id) }}"><i class="fas fa-undo"></i></a>
                                <form action="{{ route('admin.users.eliminate', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Xóa vĩnh viễn {{ $user->fullname }}?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger">Không có người dùng nào đã xóa mềm</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection

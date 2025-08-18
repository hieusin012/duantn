@extends('admin.layouts.index')

@section('title', 'Quản lý người dùng')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-add btn-sm" title="Thêm người dùng">
                            <i class="fas fa-plus"></i> Thêm người dùng
                        </a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-danger btn-sm" type="button" title="Xóa" href="{{ route('admin.users.deleted') }}"><i class="fas fa-trash-alt"></i> Dữ liệu đã xóa</a>
                    </div>
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Import"><i class="fas fa-file-upload"></i> Nhập tệp</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm print-file" type="button" title="Print"><i class="fas fa-print"></i> In dữ liệu</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm js-textareacopybtn" type="button" title="Copy"><i class="fas fa-copy"></i> Sao chép</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="Export"><i class="fas fa-file-excel"></i> Xuất sang Excel</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="Export PDF"><i class="fas fa-file-pdf"></i> Xuất sang PDF</a>
                    </div> --}}
                    {{-- <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm" type="button" title="Delete All"><i class="fas fa-trash-alt"></i> Xóa tất cả</a>
                    </div> --}}
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3 d-flex">
                            <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm kiếm người dùng..." value="{{ request('keyword') }}">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </form>
                        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3 d-inline-block">
                            @if(request('keyword'))
                            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                            @endif
                            <select name="role" class="form-control d-inline-block w-auto" onchange="this.form.submit()">
                                <option value="">-- Tất cả vai trò --</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>User</option>
                            </select>
                        </form>
                    </div>
                </div>
                <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded bg-white" id="users-table">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Điện thoại</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
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
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger fw-bold py-3">
                                Không tìm thấy người dùng phù hợp.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>


                <div class="pagination">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
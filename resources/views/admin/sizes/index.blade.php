@extends('admin.layouts.index')

@section('content')
    <h1>Danh sách kích cỡ</h1>
    <a href="{{ route('admin.sizes.create') }}" class="btn btn-primary mb-3">Thêm mới kích cỡ</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
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
                    {{-- <td>
                        <a href="{{ route('admin.sizes.show', $size->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('admin.sizes.edit', $size->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa không?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td> --}}
                    <td>
                        <a href="{{ route('admin.sizes.show', $size->id) }}" class="btn btn-info btn-sm" title="Show">
                            <i class="fas fa-eye"></i>
                        </a>
    
                        <a href="{{ route('admin.sizes.edit', $size->id) }}" class="btn btn-primary btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.sizes.destroy', $size->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa kích cỡ này không?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary btn-sm trash" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sizes->links() }}
@endsection
@extends('admin.layouts.index') {{-- Giả sử bạn có layout admin --}}

@section('content')
<div class="container">
    <h2>Danh sách danh mục</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Ảnh</th>
                <th>Hiển thị</th>
                <th>Danh mục cha</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td>
                        @if($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" alt="{{ $cat->name }}" width="50" height="50">
                        @endif
                    </td>
                    <td>{{ $cat->is_active ? '✔' : '✖' }}</td>
                    <td>{{ $cat->parent->name ?? 'Không có' }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $cat) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('categories.destroy', $cat) }}" method="POST" style="display:inline;">
                            @csrf 
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection

@extends('admin.layouts.index')

@section('content')
<h1>Danh sách danh mục</h1>

<a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên danh mục</th>
            <th>Danh mục cha</th>
            <th>Trạng thái</th>
            <th>Ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->parent ? $category->parent->name : '-' }}</td>
            <td>{{ $category->is_active ? 'Kích hoạt' : 'Không kích hoạt' }}</td>
            <td>
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" width="50">
                @endif
            </td>
            <td>
                <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-sm">Xem</a>
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $categories->links() }}

@endsection

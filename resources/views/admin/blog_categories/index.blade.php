@extends('admin.layouts.index')

@section('title', 'Quản lý danh mục bài viết')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">

                <div class="row element-button mb-3">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.blog-categories.create') }}" title="Thêm danh mục">
                            <i class="fas fa-plus"></i> Thêm danh mục
                        </a>
                    </div>
                    <div class="col-sm-2 mb-2">
                        <a class="btn btn-danger btn-sm" type="button" title="Xóa" href="{{ route('admin.blog-categories.delete') }}"><i class="fas fa-trash-alt"></i> Dữ liệu đã xóa</a>
                    </div>
                </div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Danh mục cha</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->slug }}</td>
                                <td>{{ $item->parent ? $item->parent->name : 'Không có' }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                        {{ $item->is_active ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.blog-categories.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.blog-categories.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xoá?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Xoá">
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
                    {{ $categories->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

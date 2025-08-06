@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã xóa danh mục bài viết')
@section('blog-categories')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.blog-categories.index') }}" title="Quay lại">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    <form action="{{ route('admin.blog-categories.all-eliminate') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa tất cả"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tất cả danh mục đã xóa mềm?')">
                                <i class="fas fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </div>
                    </form>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Danh mục cha</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deletedCategories as $category)
                        <tr>
                            <td width="10"><input type="checkbox" name="check[]" value="{{ $category->id }}"></td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->parent ? $category->parent->name : 'Không có' }}</td>
                            <td>
                                <span class="badge bg-{{ $category->is_active ? 'success' : 'secondary' }}">
                                    {{ $category->is_active ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.blog-categories.restore', $category->id) }}" title="Khôi phục">
                                    <i class="fas fa-undo"></i>
                                </a>
                                <form action="{{ route('admin.blog-categories.eliminate', $category->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                        onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn {{ $category->name }} không?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">Không có danh mục bài viết nào đã xóa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination (nếu có) -->
                <div class="pagination">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

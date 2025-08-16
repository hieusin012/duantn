@extends('admin.layouts.index')

@section('title', 'Quản Lý Danh Mục')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.categories.create') }}" title="Add"><i class="fas fa-plus"></i> Thêm danh mục</a>
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
                    <div class="col-sm-2">
                        @if(request()->has('trashed') && request()->trashed == 'true')
                            <a class="btn btn-secondary btn-sm" href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-list"></i> Danh sách hiện tại
                            </a>
                        @else
                            <a class="btn btn-danger btn-sm" href="{{ route('admin.categories.index', ['trashed' => 'true']) }}">
                                <i class="fas fa-trash-alt"></i> Dữ liệu đã xóa
                            </a>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 d-flex align-items-center">
                        <form action="{{ route('admin.categories.index') }}" method="GET">
                            <div class="input-group shadow-sm rounded">
                                <input
                                    type="text"
                                    name="q"
                                    class="form-control rounded-start-pill"
                                    placeholder="🔍 Tìm kiếm danh mục..."
                                    value="{{ $query ?? '' }}">
                                <input type="hidden" name="trashed" value="{{ request('trashed') }}">
                                <button type="submit" class="btn btn-success rounded-end-pill px-4 mt-1">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <table class="table table-hover table-bordered" id="categories-table">
                    <thead>
                        <tr>
                            <th>Trạng thái</th>
                            <th>Tên</th>
                            <th>Slug</th>
                            <th>Hình ảnh</th>
                            <th>Danh mục cha</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td class="text-center">
                                @if (request('trashed') !== 'true')
                                    <input type="checkbox" class="toggle-status" data-id="{{ $category->id }}" {{ $category->is_active ? 'checked' : '' }}>
                                @else
                                    <span class="{{ $category->is_active ? 'text-success' : 'text-danger' }}">
                                        {{ $category->is_active ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                @endif
                            </td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if ($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" width="100px;" />
                                @else
                                <span>No image</span>
                                @endif
                            </td>
                            <td>{{ $category->parent ? $category->parent->name : 'None' }}</td>
                            <td>
                                @if (request('trashed') == 'true')
                                    <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Khôi phục"
                                            onclick="return confirm('Khôi phục danh mục này?')">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.categories.force-delete', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Xoá vĩnh viễn"
                                            onclick="return confirm('Xoá vĩnh viễn danh mục này?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm trash" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.toggle-status').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const categoryId = this.dataset.id;
                const isActive = this.checked ? 1 : 0;

                fetch(`/admin/categories/${categoryId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            is_active: isActive
                        }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Cập nhật trạng thái thất bại!');
                        }
                    })
                    .catch(() => alert('Có lỗi xảy ra khi kết nối máy chủ.'));
            });
        });
    });
</script>
<style>
    input.form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
        border-color: #86b7fe;
    }
</style>
@endpush
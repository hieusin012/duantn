@extends('admin.layouts.index')
@php
    use Illuminate\Support\Str;
@endphp
@section('title', 'Quản lý bài viết')
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
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.blogs.index') }}" title="Thêm">Quay lại</a>
                    </div>
                    <form action="{{ route('admin.blogs.all-eliminate') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa tất cả"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tất cả bài viết đã xóa mềm?')">
                                <i class="fas fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </div>
                    </form>
                </div>

                <table class="table table-hover table-bordered text-center" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Tiêu đề</th>
                            <th>Ảnh minh họa</th>
                            <th>Nội dung</th>
                            <th>Danh mục</th>
                            <th>Người viết</th>
                            <th>Trạng thái</th>
                            <th>Hoạt động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($blogs as $blog)
                        <tr>
                            <td><input type="checkbox" name="check[]" value="{{ $blog->id }}"></td>
                            <td>{{ $blog->title }}</td>
                            <td>
                                @if ($blog->image)
                                <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" width="100px">
                                @else
                                <span>No image</span>
                                @endif
                            </td>
                            <td>{{ Str::limit(strip_tags($blog->content), 100) }}</td>
                            <td>{{ $blog->category->name ?? '------' }}</td>
                            <td>{{ $blog->user->fullname ?? '------' }}</td>
                            <td>{{ $blog->status == 1 ? 'Đã đăng' : 'Đã gỡ' }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.blogs.restore', $blog->id) }}" title="Khôi phục">
                                    <i class="fas fa-undo"></i>
                                </a>
                                <form action="{{ route('admin.blogs.eliminate', $blog->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="pagination">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
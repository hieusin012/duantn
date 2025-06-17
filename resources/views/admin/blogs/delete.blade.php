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
                        <a class="btn btn-add btn-sm" href="{{ route('admin.blogs.create') }}" title="Thêm"><i class="fas fa-plus"></i> Quay lại</a>
                    </div>

                    <div class="col-sm-2">
                        <a class="btn btn-danger btn-sm" type="button" title="Xóa" href="{{ route('admin.blogs.delete') }}"><i class="fas fa-trash-alt"></i> Dữ liệu đã xóa</a>
                    </div>
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
                            <td>{{ $blog->category_name }}</td>
                            <td>{{ $blog->user_name }}</td>
                            <td>{{ $blog->status == 1 ? 'Đã đăng' : 'Đã gỡ' }}</td>
                            <td>
                            <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-info btn-sm" title="Xem">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.blogs.edit', $blog->id) }}" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
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
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
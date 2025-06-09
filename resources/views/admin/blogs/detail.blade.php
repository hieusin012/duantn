@extends('admin.layouts.index')

@section('title', 'Chi tiết bài viết')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chi tiết bài viết</h3>

            <a href="{{ route('admin.blogs.index') }}" class="btn btn-cancel btn-sm mb-3">
                <i class="fas fa-undo"></i> Quay lại danh sách
            </a>

            <div class="tile-body">
                @if($blog->image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="image" style="max-width: 150px; border-radius: 8px;">
                    </div>
                @endif

                <table class="table table-bordered">
                    <tbody>
                        <tr><th>ID</th><td>{{ $blog->id }}</td></tr>
                        <tr><th>Tiêu đề</th><td>{{ $blog->title }}</td></tr>
                        <tr><th>Ảnh minh họa</th><td>
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="image" style="max-width: 100px; border-radius: 8px;">
                            @else
                                -
                            @endif
                        </td></tr>
                        <tr><th>Nội dung</th><td>{{ $blog->content ?? '-' }}</td></tr>
                        <tr><th>Slug</th><td>{{ $blog->slug ?? '-' }}</td></tr>
                        <tr><th>Danh mục</th><td>{{ $blog->category_name ?? '------' }}</td></tr>
                        <tr><th>Người viết</th><td>{{ $blog->user_name ?? '------' }}</td></tr>
                        <tr><th>Trạng thái</th><td><code>{{ $blog->status == 1 ? 'Đã đăng' : 'Đã xóa' }}</code></td></tr>
                        <tr><th>Ngày đăng</th><td>{{ $blog->created_at }}</td></tr>
                        <tr><th>Ngày cập nhật</th><td>{{ $blog->updated_at }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

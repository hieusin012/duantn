@extends('admin.layouts.index')

@section('title', 'Chi tiết bài viết')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="tile p-4 shadow-sm rounded">
            <h3 class="tile-title mb-4 text-primary">📝 Chi tiết bài viết</h3>

            <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-secondary mb-3">
                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
            </a>

            @if($blog->image)
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Ảnh bài viết" class="img-thumbnail" style="max-width: 250px; border-radius: 8px;">
                </div>
            @endif

            <table class="table table-bordered table-striped table-sm align-middle">
                <tbody>
                    <tr><th style="width: 30%;">ID</th><td>{{ $blog->id }}</td></tr>
                    <tr><th>Tiêu đề</th><td>{{ $blog->title }}</td></tr>
                    <tr>
                        <th>Ảnh minh họa</th>
                        <td>
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="Ảnh nhỏ" style="max-width: 100px; border-radius: 6px;">
                            @else
                                <em class="text-muted">Không có</em>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Nội dung</th><td>{!! nl2br(e($blog->content ?? '-')) !!}</td></tr>
                    <tr><th>Slug</th><td>{{ $blog->slug ?? '-' }}</td></tr>
                    <tr><th>Danh mục</th><td>{{ $blog->category->name ?? '-' }}</td></tr>
                    <tr><th>Người viết</th><td>{{ $blog->user->fullname ?? '-' }}</td></tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            @if($blog->status == 1)
                                <span class="badge bg-success">Đã đăng</span>
                            @else
                                <span class="badge bg-danger">Đã gỡ</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Ngày đăng</th><td>{{ $blog->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><th>Ngày cập nhật</th><td>{{ $blog->updated_at->format('d/m/Y H:i') }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

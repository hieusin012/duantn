@extends('admin.layouts.index')

@php
    use Illuminate\Support\Str;
@endphp

@section('title', 'Quản lý bài viết')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <!-- Nút thao tác -->
                <div class="d-flex justify-content-between mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('admin.blogs.create') }}">
                        <i class="fas fa-plus me-1"></i> Thêm bài viết
                    </a>
                    <a class="btn btn-danger btn-sm" href="{{ route('admin.blogs.delete') }}">
                        <i class="fas fa-trash-alt me-1"></i> Dữ liệu đã xóa
                    </a>
                </div>

                <!-- Bảng dữ liệu -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center table-hover" id="sampleTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="30"><input type="checkbox" id="all"></th>
                                <th>Tiêu đề</th>
                                <th>Ảnh</th>
                                <th>Nội dung</th>
                                <th>Danh mục</th>
                                <th>Người viết</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $blog)
                            <tr>
                                <td><input type="checkbox" name="check[]" value="{{ $blog->id }}"></td>
                                <td class="text-start">{{ $blog->title }}</td>
                                <td>
                                    @if ($blog->image)
                                        <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" class="img-thumbnail" width="80">
                                    @else
                                        <span class="text-muted">Không có</span>
                                    @endif
                                </td>
                                <td class="text-start">{{ Str::limit(strip_tags($blog->content), 100) }}</td>
                                <td>
                                    {{ $blog->category->name ?? '—' }}
                                </td>
                                <td>
                                    {{ $blog->user->fullname ?? '—' }}
                                </td>
                                <td>
                                    @if ($blog->status)
                                        <span class="badge bg-success">Đã đăng</span>
                                    @else
                                        <span class="badge bg-secondary">Đã gỡ</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-sm btn-info" title="Xem">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-primary" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Xóa">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                <div class="mt-3">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

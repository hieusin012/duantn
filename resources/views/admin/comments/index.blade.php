{{-- @extends('admin.layouts.index')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh sách đánh giá</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Người dùng</th>
                <th>Sản phẩm</th>
                <th>Nội dung</th>
                <th>Đánh giá</th>
                <th>Trạng thái</th>
                <th>Ngày đánh giá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @forelse($comments as $comment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $comment->user->fullname ?? 'Không xác định' }}</td>
                <td>{{ $comment->product->name ?? 'Không xác định' }}</td>
                <td>{{ $comment->content }}</td>
                <td>{{ $comment->rating ?? 'Không có' }}</td>
                <td>
                    @if($comment->status == 1)
                        <span class="badge bg-success">Hiển thị</span>
                    @else
                        <span class="badge bg-secondary">Ẩn</span>
                    @endif
                </td>
                <td>{{ $comment->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8">Không có đánh giá nào.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $comments->links() }}
</div>
@endsection --}}


@extends('admin.layouts.index')

@section('title', 'Quản lý đánh giá')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm print-file" type="button" title="In dữ liệu"><i class="fas fa-print"></i> In dữ liệu</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm js-textareacopybtn" type="button" title="Sao chép"><i class="fas fa-copy"></i> Sao chép</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="Export"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="Export PDF"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    </div>
                </div>
                <form method="GET" action="{{ route('admin.comments.index') }}" class="mb-3 d-flex">
                    <input type="text" name="keyword" class="form-control me-2" style="width: 350px;" placeholder="Tìm theo nội dung đánh giá ..." value="{{ request('keyword') }}">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </form>

                <table class="table table-hover table-bordered mt-3" id="comments-table">
                    <thead class="table">
                        <tr>
                            <th>#</th>
                            <th>Người dùng</th>
                            <th>Sản phẩm</th>
                            <th>Nội dung</th>
                            <th>Đánh giá</th>
                            <th>Trạng thái</th>
                            <th>Ngày đánh giá</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $comment->user->fullname ?? 'Không xác định' }}</td>
                                <td>{{ $comment->product->name ?? 'Không xác định' }}</td>
                                <td>{{ $comment->content }}</td>
                                <td>{{ $comment->rating ?? 'Không có' }}</td>
                                <td>
                                    @if($comment->status == 1)
                                        <span class="badge bg-success">Hiển thị</span>
                                    @else
                                        <span class="badge bg-secondary">Ẩn</span>
                                    @endif
                                </td>
                                <td>{{ $comment->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.comments.edit', $comment->id) }}" class="btn btn-primary btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn chắc chắn muốn xóa đánh giá này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Không có đánh giá nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination mt-3">
                    {{ $comments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

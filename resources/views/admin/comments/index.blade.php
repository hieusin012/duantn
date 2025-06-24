@extends('admin.layouts.index')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Danh sách bình luận</h2>

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
                <th>Ngày bình luận</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        @forelse($comments as $comment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $comment->user->name ?? 'Không xác định' }}</td>
                <td>{{ $comment->product->name ?? 'Không xác định' }}</td>
                <td>{{ $comment->content }}</td>
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
            <tr><td colspan="6">Không có bình luận nào.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $comments->links() }}
</div>
@endsection

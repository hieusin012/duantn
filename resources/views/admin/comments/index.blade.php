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
        <form method="GET" action="{{ route('admin.comments.index') }}" class="mb-3 d-flex gap-2">
          <input type="text" name="keyword" class="form-control" style="max-width:360px"
                 placeholder="Tìm theo nội dung đánh giá ..." value="{{ request('keyword') }}">
          {{-- Lọc trạng thái (tuỳ chọn) --}}
          <select name="status" class="form-select" style="max-width:160px">
            <option value="">-- Tất cả --</option>
            <option value="1" {{ request('status')==='1' ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ request('status')==='0' ? 'selected' : '' }}>Ẩn</option>
          </select>
          <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
        </form>

        <table class="table table-hover table-bordered mt-3" id="comments-table">
          <thead>
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
                {{-- số thứ tự đúng khi phân trang --}}
                <td>{{ $comments->firstItem() + $loop->index }}</td>

                {{-- fullname có thể không tồn tại, fallback về name --}}
                <td>{{ $comment->user->fullname ?? $comment->user->name ?? 'Không xác định' }}</td>

                <td>{{ $comment->product->name ?? 'Không xác định' }}</td>

                <td>{{ $comment->content }}</td>

                {{-- nếu không có rating thì hiển thị "—" --}}
                <td>{{ isset($comment->rating) ? $comment->rating : '—' }}</td>

                <td>
                  @if(isset($comment->status))
                    <span class="badge {{ $comment->status ? 'bg-success' : 'bg-secondary' }}">
                      {{ $comment->status ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                  @else
                    —
                  @endif
                </td>

                <td>{{ optional($comment->created_at)->format('d/m/Y') }}</td>

                <td class="text-nowrap">
                  {{-- Nút Ẩn/Hiển ngay tại danh sách --}}
                  @if(isset($comment->status))
                    <form action="{{ route('admin.comments.toggle', $comment) }}" method="POST" style="display:inline">
                      @csrf
                      @method('PATCH')
                      @if($comment->status)
                        <button type="submit" class="btn btn-warning btn-sm" title="Ẩn bình luận">
                          <i class="fas fa-eye-slash"></i> Ẩn
                        </button>
                      @else
                        <button type="submit" class="btn btn-success btn-sm" title="Hiển thị bình luận">
                          <i class="fas fa-eye"></i> Hiển
                        </button>
                      @endif
                    </form>
                  @else
                    <span class="text-muted">—</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">Không có đánh giá nào.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="pagination mt-3">
          {{ $comments->withQueryString()->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

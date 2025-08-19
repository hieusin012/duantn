@extends('admin.layouts.index')
@section('title', 'Chỉnh sửa đánh giá')

@section('content')
<div class="container mt-4">
  <h3>Chỉnh sửa đánh giá</h3>

  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <ul class="mb-0">
        @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <form action="{{ route('admin.comments.update', $comment->id) }}" method="POST">
    @csrf @method('PUT')

    {{-- Người dùng --}}
    <div class="mb-3">
      <label class="form-label">Người dùng</label>
      <input type="text" class="form-control" value="{{ $comment->user->fullname ?? $comment->user->name ?? 'Không xác định' }}" disabled>
    </div>

    {{-- Sản phẩm --}}
    <div class="mb-3">
      <label class="form-label">Sản phẩm</label>
      <input type="text" class="form-control" value="{{ $comment->product->name ?? 'Không xác định' }}" disabled>
    </div>

    {{-- Nội dung --}}
    <div class="mb-3">
      <label class="form-label">Nội dung</label>
      <textarea name="content" class="form-control" rows="4" required>{{ old('content', $comment->content) }}</textarea>
    </div>

    {{-- Trạng thái --}}
    <div class="mb-3">
      <label class="form-label">Trạng thái</label>
      <select name="status" class="form-select" required>
        <option value="1" @selected(old('status', $comment->status)==1)>Hiển thị</option>
        <option value="0" @selected(old('status', $comment->status)==0)>Ẩn</option>
      </select>
    </div>

    <button type="submit" class="btn btn-success">Cập nhật</button>
    <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">Quay lại</a>
  </form>
</div>
@endsection

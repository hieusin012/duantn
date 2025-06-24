@extends('admin.layouts.index')

@section('content')
<div class="container mt-4">
    <h2>Sửa bình luận</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="user_id" class="form-label">Người dùng</label>
            <select name="user_id" id="user_id" class="form-select" disabled>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $comment->user_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Sản phẩm</label>
            <select name="product_id" id="product_id" class="form-select" disabled>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $product->id == $comment->product_id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea name="content" id="content" class="form-control" rows="4" required>{{ old('content', $comment->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Đánh giá (1-5)</label>
            <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" value="{{ old('rating', $comment->rating) }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" class="form-select">
                <option value="1" {{ $comment->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                <option value="0" {{ $comment->status == 0 ? 'selected' : '' }}>Ẩn</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('comments.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

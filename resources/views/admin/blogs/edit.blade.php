@extends('admin.layouts.index')

@section('title', 'Chỉnh sửa bài viết')

@section('content')

<div class="row justify-content-center mb-5">
    <div class="col-lg-10">
        <div class="card shadow-sm p-4">
            <h4 class="mb-4 text-primary">✍️ Chỉnh sửa bài viết</h4>

            <form class="row g-3" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Tiêu đề --}}
                <div class="col-md-6">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title', $blog->title ?? '') }}">
                    @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Slug --}}
                <div class="col-md-6">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" name="slug" value="{{ old('slug', $blog->slug ?? '') }}">
                    @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Danh mục --}}
                <div class="col-md-4">
                    <label class="form-label">Danh mục</label>
                    <select class="form-control" name="category_id">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Người viết --}}
                <div class="col-md-4">
                    <label class="form-label">Người viết</label>
                    <select class="form-control" name="user_id">
                        <option value="">-- Chọn người viết --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $blog->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->fullname }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Trạng thái --}}
                <div class="col-md-4">
                    <label class="form-label d-block">Trạng thái</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $blog->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Đã đăng</label>
                    </div>
                </div>

                {{-- Nội dung --}}
                <div class="col-md-12">
                    <label class="form-label">Nội dung</label>
                    <textarea class="form-control" name="content" id="mota" rows="5">{{ old('content', $blog->content ?? '') }}</textarea>
                    @error('content')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                {{-- Ảnh minh họa --}}
                <div class="col-md-12">
                    <label class="form-label">Hình ảnh minh họa</label>
                    <div class="text-center border rounded p-3 mb-2">
                        <img id="thumbimage" 
                            src="{{ $blog->image ? Storage::url($blog->image) : '#' }}" 
                            class="img-thumbnail" 
                            style="max-height: 300px; {{ $blog->image ? '' : 'display:none;' }}">
                        <br>
                        <input type="file" id="uploadfile" name="image" accept="image/*" hidden onchange="readURL(this);">
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('uploadfile').click();">
                                <i class="fas fa-upload me-1"></i> Chọn hình
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearImage();">
                                <i class="fas fa-trash me-1"></i> Xóa hình
                            </button>
                        </div>
                        @error('image')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Nút --}}
                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="fas fa-save me-1"></i> Lưu
                    </button>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script ảnh --}}
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('thumbimage');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImage() {
        const img = document.getElementById('thumbimage');
        img.src = '';
        img.style.display = 'none';
        document.getElementById('uploadfile').value = '';
    }
</script>

@endsection

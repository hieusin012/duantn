@extends('admin.layouts.index')

@section('title', 'Sửa banner')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Sửa banner</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-3">
                        <label class="control-label">Tiêu đề</label>
                        <input class="form-control" type="text" name="title" value="{{ old('title', $banner->title) }}">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Slug</label>
                        <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug', $banner->slug) }}">
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Link</label>
                        <input class="form-control" type="url" name="link" value="{{ old('link', $banner->link) }}">
                        @error('link')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Ảnh hiện tại</label><br>
                        @if ($banner->image)
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" height="100" width="100">
                        @else
                            <span>Không có ảnh</span>
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        <label for="is_active" class="control-label">Trạng thái</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ old('is_active', $banner->is_active) == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('is_active', $banner->is_active) == 0 ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                        @error('is_active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="location" class="control-label">Vị trí</label>
                        <select class="form-control" name="location" id="location">
                            <option value="">-- Chọn vị trí --</option>
                            <option value="1" {{ old('location', $banner->location) == 1 ? 'selected' : '' }}>Hiển thị</option>
                            <option value="0" {{ old('location', $banner->location) == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                        @error('location')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Thay ảnh mới</label>
                        <div id="myfileupload">
                            <input type="file" id="uploadfile" name="image" onchange="readURL(this);" accept="image/*" />
                        </div>
                        <div id="thumbbox">
                            <img height="450" width="400" alt="Thumb image" id="thumbimage" style="display: none" />
                            <a class="removeimg" href="javascript:" onclick="clearImage()">Xóa ảnh</a>
                        </div>
                        <div id="boxchoice">
                            <a href="javascript:" class="Choicefile" onclick="document.getElementById('uploadfile').click();"><i class="fas fa-cloud-upload-alt"></i> Chọn ảnh</a>
                            <p style="clear:both"></p>
                        </div>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Lưu lại</button>
                        <a class="btn btn-cancel" href="{{ route('admin.banners.index') }}">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var thumbImage = document.getElementById('thumbimage');
            thumbImage.src = e.target.result;
            thumbImage.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearImage() {
    var thumbImage = document.getElementById('thumbimage');
    thumbImage.src = '';
    thumbImage.style.display = 'none';
    document.getElementById('uploadfile').value = '';
}

document.querySelector('input[name="title"]').addEventListener('input', function() {
    let title = this.value;
    let slug = title.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    document.getElementById('slug').value = slug;
});
</script>
@endsection
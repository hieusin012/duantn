@extends('admin.layouts.index')

@section('title', 'Chỉnh sửa danh mục')

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
            <h3 class="tile-title">Chỉnh sửa danh mục</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-3">
                        <label class="control-label">Tên danh mục</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $category->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Slug</label>
                        <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}">
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="parent_id" class="control-label">Danh mục cha</label>
                        <select class="form-control" name="parent_id" id="parent_id">
                            <option value="">-- Chọn danh mục chính --</option>
                            @foreach ($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Hình ảnh danh mục</label>
                        <div id="myfileupload">
                            <input type="file" id="uploadfile" name="image" onchange="readURL(this);" accept="image/*" />
                        </div>
                        <div id="thumbbox">
                            @if ($category->image)
                                <img height="450" width="400" alt="Thumb image" id="thumbimage" src="{{ Storage::url($category->image) }}" style="display: block" />
                            @else
                                <img height="450" width="400" alt="Thumb image" id="thumbimage" style="display: none" />
                            @endif
                            <a class="removeimg" href="javascript:" onclick="clearImage()">Xóa hình ảnh</a>
                        </div>
                        <div id="boxchoice">
                            <a href="javascript:" class="Choicefile" onclick="document.getElementById('uploadfile').click();"><i class="fas fa-cloud-upload-alt"></i> Chọn hình ảnh</a>
                            <p style="clear:both"></p>
                        </div>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
<<<<<<< HEAD
                        <button class="btn btn-save" type="submit">Save</button>
                        <a class="btn btn-cancel" href="{{ route('admin.categories.index') }}">Cancel</a>
=======
                        <button class="btn btn-save" type="submit">Lưu</button>
                        <a class="btn btn-cancel" href="{{ route('admin.categories.index') }}">Quay lại</a>
>>>>>>> 3ca3222fe360990db1371432c56f817073c6a92c
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

document.getElementById('name').addEventListener('input', function() {
    var name = this.value;
    var slugInput = document.getElementById('slug');
    var slug = name
        .toLowerCase()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
    slugInput.value = slug;
});
</script>
@endsection
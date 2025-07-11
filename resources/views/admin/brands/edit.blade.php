@extends('admin.layouts.index')

@section('title', 'Chỉnh sửa thương hiệu')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chỉnh sửa thương hiệu</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-3">
                        <label class="control-label">Tên thương hiệu</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $brand->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Hình ảnh danh mục</label>
                        <div id="myfileupload">
                            <input type="file" id="uploadfile" name="logo" onchange="readURL(this);" accept="image/*" />
                        </div>
                        <div id="thumbbox">
                            @if ($brand->logo)
                                <img height="450" width="400" alt="Thumb image" id="thumbimage" src="{{ Storage::url($brand->logo) }}" style="display: block" />
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
                        <button class="btn btn-save" type="submit">Lưu</button>
                        <a class="btn btn-cancel" href="{{ route('admin.brands.index') }}">Quay lại</a>

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
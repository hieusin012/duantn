@extends('admin.layouts.index')

@section('title', 'Chỉnh sửa màu sắc')

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
            <h3 class="tile-title">Chỉnh sửa màu sắc</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.colors.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-3">
                        <label class="control-label">Tên màu sắc</label>
                        <input class="form-control" type="text" name="name" id="name" value="">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Mã màu</label>
                        <input class="form-control" type="text" name="color_code" id="color_code" value="">
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Lưu</button>
                        <a class="btn btn-cancel" href="{{ route('admin.colors.index') }}">Quay lại</a>

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
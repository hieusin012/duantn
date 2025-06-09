@extends('admin.layouts.index')

@section('title', isset($user) ? 'Cập nhật người dùng' : 'Thêm người dùng')

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
            <h3 class="tile-title">Thêm bài viết</h3>
            <div class="tile-body">
                <form class="row" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($user)) @method('PUT') @endif

                    <div class="form-group col-md-4">
                        <label for="fullname">Tiêu đề</label>
                        <input type="text" class="form-control" name="fullname" value="">
                        @error('fullname')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="introduction">Nội dung</label>
                        <textarea name="introduction" rows="3" class="form-control">{{ old('introduction', $user->introduction ?? '') }}</textarea>
                        @error('introduction')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="fullname">Tiêu đề</label>
                        <input type="text" class="form-control" name="fullname" value="">
                        @error('fullname')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label">Ảnh minh họa</label>
                        <div id="myfileupload">
                            <input type="file" id="uploadfile" name="image" onchange="readURL(this);" accept="image/*" />
                        </div>
                        <div id="thumbbox">
                            @if(!empty($user->avatar))
                            <img id="thumbimage" src="{{ asset('storage/' . $user->avatar) }}" height="200" />
                            @else
                            <img height="200" id="thumbimage" style="display: none;" />
                            @endif
                            <a class="removeimg" href="javascript:" onclick="clearImage()">Xóa hình ảnh</a>
                        </div>
                        <div id="boxchoice">
                            <a href="javascript:" class="Choicefile" onclick="document.getElementById('uploadfile').click();">
                                <i class="fas fa-cloud-upload-alt"></i> Chọn hình ảnh
                            </a>
                        </div>
                        @error('avatar')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>




                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Lưu</button>
                        <a class="btn btn-cancel" href="{{ route('admin.users.index') }}">Quay lại</a>
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
</script>

@endsection
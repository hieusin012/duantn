@extends('admin.layouts.index')

@section('title', 'Thêm bài viết')

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
                <form class="row" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group col-md-4">
                        <label for="title">Tiêu đề:</label>
                        <input type="text" class="form-control" name="title" value="">
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label">Nội dung:</label>
                        <textarea class="form-control" name="content" id="mota"></textarea>
                        @error('content')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="form-group col-md-4">
                        <label for="fullname">Danh mục:</label>
                        <select class="form-control" name="category">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ (isset($user) && $user->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="user_id">Người viết:</label>
                        <select class="form-control" name="user">
                            <option value="">Chọn người viết</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (isset($blog) && $blog->user_id == $user->id) ? 'selected' : '' }}>
                                {{ $user->fullname }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>






                    <div class="form-group col-md-12">
                        <label class="control-label">Ảnh minh họa</label>
                        <div id="myfileupload">
                            <input type="file" id="uploadfile" name="image" onchange="readURL(this);" accept="image/*" />
                        </div>
                        <div id="thumbbox">
                            @if(!empty($blogs->image))
                            <img id="thumbimage" src="{{ asset('storage/' . $blogs->image) }}" height="200" />
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
@extends('admin.layouts.index')

@section('title', 'Thêm bài viết')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Thêm bài viết</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group col-md-4">
                        <label for="title">Tiêu đề:</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}">
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label">Nội dung:</label>
                        <textarea class="form-control" name="content" id="mota">{{ old('content') }}</textarea>
                        @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="slug">Slug:</label>
                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}">
                        @error('slug')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="category_id">Danh mục bài viết:</label>
                        <select class="form-control" name="category_id">
                            <option value="">Chọn danh mục bài viết</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    {{-- <div class="form-group col-md-4">
                        <label for="user_id">Người viết:</label>
                        <select class="form-control" name="user_id">
                            <option value="">Chọn người viết</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->fullname }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div> --}}
                    <div class="form-group col-md-4">
                        <label for="">Người viết:</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->fullname ?? Auth::user()->name }}" readonly>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="status">Trạng thái:</label><br>
                        <input type="checkbox" name="status" id="status" value="1" {{ old('status') ? 'checked' : '' }}>
                        <label for="status">Đã đăng</label>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label">Ảnh minh họa</label>
                        <div id="myfileupload">
                            <input type="file" id="uploadfile" name="image" onchange="readURL(this);" accept="image/*" />
                        </div>
                        <div id="thumbbox">
                            <img height="200" id="thumbimage" style="display: none;" />
                            <a class="removeimg" href="javascript:" onclick="clearImage()">Xóa hình ảnh</a>
                        </div>
                        <div id="boxchoice">
                            <a href="javascript:" class="Choicefile" onclick="document.getElementById('uploadfile').click();">
                                <i class="fas fa-cloud-upload-alt"></i> Chọn hình ảnh
                            </a>
                        </div>
                        @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Lưu</button>
                        <a class="btn btn-cancel" href="{{ route('admin.blogs.index') }}">Quay lại</a>
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
    
    function slugify(str) {
        return str.toString().toLowerCase()
            .normalize('NFD')                     // chuẩn hóa Unicode
            .replace(/[\u0300-\u036f]/g, '')     // xóa dấu
            .replace(/đ/g, 'd')                  // đ → d
            .replace(/[^a-z0-9 -]/g, '')         // xóa ký tự không hợp lệ
            .replace(/\s+/g, '-')                // khoảng trắng → dấu -
            .replace(/-+/g, '-')                 // nhiều dấu - → 1 dấu
            .replace(/^-+|-+$/g, '');            // xóa dấu - đầu/cuối
    }

    document.getElementById('title').addEventListener('input', function () {
        const title = this.value;
        document.getElementById('slug').value = slugify(title);
    });
</script>

@endsection

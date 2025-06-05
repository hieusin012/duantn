@extends('admin.layouts.index')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Tạo mới sản phẩm</h3>
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#exampleModalCenter"><i class="fas fa-folder-plus"></i> Thêm nhà cung cấp</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#adddanhmuc"><i class="fas fa-folder-plus"></i> Thêm danh mục</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" data-toggle="modal" data-target="#addtinhtrang"><i class="fas fa-folder-plus"></i> Thêm tình trạng</a>
                    </div>
                </div>
                <form class="row" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-3">
                        <label class="control-label">Mã sản phẩm</label>
                        <input class="form-control" type="text" name="code" value="{{ $code }}" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Tên sản phẩm</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Slug</label>
                        <input class="form-control" type="text" name="slug" id="slug" value="{{ old('slug') }}">
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="category_id" class="control-label">Danh mục</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="brand_id" class="control-label">Nhà cung cấp</label>
                        <select class="form-control" name="brand_id" id="brand_id">
                            <option value="">-- Chọn nhà cung cấp --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Giá bán</label>
                        <input class="form-control" type="number" name="price" value="{{ old('price') }}" min="0" step="0.01">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="status" class="control-label">Trạng thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Kích hoạt</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Không kích hoạt</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="is_active" class="control-label">Tình trạng</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="">-- Chọn tình trạng --</option>
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Còn hàng</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Hết hàng</option>
                        </select>
                        @error('is_active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Ảnh sản phẩm</label>
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
                        <label class="control-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" name="description" id="mota">{{ old('description') }}</textarea>
                        <script>CKEDITOR.replace('mota');</script>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Lưu lại</button>
                        <a class="btn btn-cancel" href="{{ route('admin.products.index') }}">Hủy bỏ</a>
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

document.querySelector('input[name="name"]').addEventListener('input', function() {
    let name = this.value;
    let slug = name.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    document.getElementById('slug').value = slug;
});


</script>
@endsection
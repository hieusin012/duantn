@extends('admin.layouts.index')

@section('title', 'Sửa sản phẩm')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chỉnh sửa sản phẩm</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-md-3">
                        <label class="control-label">Mã sản phẩm</label>
                        <input class="form-control" type="text" name="code" value="{{ old('code', $product->code) }}" readonly>
                        @error('code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Tên sản phẩm</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name', $product->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="category_id" class="control-label">Danh mục</label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Giá bán</label>
                        <input class="form-control" type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="status" class="control-label">Trạng thái</label>
                        <select class="form-control" name="status" id="status">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Kích hoạt</option>
                            <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Không kích hoạt</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label for="is_active" class="control-label">Tình trạng</label>
                        <select class="form-control" name="is_active" id="is_active">
                            <option value="">-- Chọn tình trạng --</option>
                            <option value="1" {{ old('is_active', $product->is_active) == '1' ? 'selected' : '' }}>Còn hàng</option>
                            <option value="0" {{ old('is_active', $product->is_active) == '0' ? 'selected' : '' }}>Hết hàng</option>
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
                            @if ($product->image)
                                <img height="450" width="400" alt="Thumb image" id="thumbimage" src="{{ asset($product->image) }}" style="display: block" />
                            @else
                                <img height="450" width="400" alt="Thumb image" id="thumbimage" style="display: none" />
                            @endif
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
                    <div class="form-group col-md-3">
                        <label class="control-label">Là Hot Deal?</label><br>
                        <input type="checkbox" name="is_hot_deal" value="1" {{ old('is_hot_deal', $product->is_hot_deal) ? 'checked' : '' }}> Đánh dấu nếu là hot deal
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Phần trăm giảm (%)</label>
                        <input type="number" class="form-control" name="discount_percent" value="{{ old('discount_percent', $product->discount_percent) }}" min="0" max="100">
                        @error('discount_percent')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label class="control-label">Thời gian bắt đầu ưu đãi</label>
                        <input type="datetime-local" class="form-control" name="deal_start_at" 
                            value="{{ old('deal_start_at', $product->deal_start_at ? \Carbon\Carbon::parse($product->deal_start_at)->format('Y-m-d\TH:i') : '') }}">
                        @error('deal_start_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label">Thời gian kết thúc ưu đãi</label>
                        <input type="datetime-local" class="form-control" name="deal_end_at" 
                            value="{{ old('deal_end_at', $product->deal_end_at ? \Carbon\Carbon::parse($product->deal_end_at)->format('Y-m-d\TH:i') : '') }}">
                        @error('deal_end_at')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Mô tả sản phẩm</label>
                        <textarea class="form-control" name="description" id="mota">{{ old('description', $product->description) }}</textarea>
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
</script>
@endsection
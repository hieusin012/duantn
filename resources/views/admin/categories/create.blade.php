@extends('admin.layouts.index')

@section('content')
<div class="container">
    <h1>Thêm Mới</h1>



        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ảnh banner</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="url" name="link" id="link" class="form-control" value="{{ old('link') }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <select name="status" id="status" class="form-select" required>
                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Kích hoạt</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không kích hoạt</option>
            </select>
        </div>

        {{-- Nếu bạn dùng thêm trường location, bỏ comment phần này --}}

        <div class="mb-3">
            <label for="location" class="form-label">Vị trí</label>
            <select name="location" id="location" class="form-select" required>
                <option value="0" {{ old('location') == 0 ? 'selected' : '' }}>Vị trí 0</option>
                <option value="1" {{ old('location') == 1 ? 'selected' : '' }}>Vị trí 1</option>
            </select>
        </div> 
    

        <button type="submit" class="btn btn-primary">Lưu</button>
    </form>
</div>
@endsection

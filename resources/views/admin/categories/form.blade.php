@csrf

<div class="mb-3">
    <label for="name" class="form-label">Tên danh mục</label>
    <input type="text" name="name" id="name" class="form-control" 
           value="{{ old('name', $category->name ?? '') }}" required maxlength="200">
    @error('name')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="image" class="form-label">Ảnh</label>
    <input type="file" name="image" id="image" class="form-control">
    @if (!empty($category->image))
        <img src="{{ asset('storage/' . $category->image) }}" alt="Ảnh danh mục" width="100" class="mt-2">
    @endif
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="is_active" class="form-label">Trạng thái</label>
    <select name="is_active" id="is_active" class="form-control">
        <option value="1" {{ old('is_active', $category->is_active ?? 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
        <option value="0" {{ old('is_active', $category->is_active ?? 1) == 0 ? 'selected' : '' }}>Ẩn</option>
    </select>
    @error('is_active')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="parent_id" class="form-label">Danh mục cha</label>
    <select name="parent_id" id="parent_id" class="form-control">
        <option value="">-- Không có --</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" 
                {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                {{ $parent->name }}
            </option>
        @endforeach
    </select>
    @error('parent_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-success">Lưu</button>
<a href="{{ route('categories.index') }}" class="btn btn-secondary">Quay lại</a>

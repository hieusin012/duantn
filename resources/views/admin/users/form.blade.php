@extends('admin.layouts.index')

@section('title', isset($user) ? 'Cập nhật người dùng' : 'Thêm người dùng')

@section('content')

<div class="row justify-content-center mb-5">
    <div class="col-lg-10">
        <div class="card shadow-sm p-4">
            <h4 class="mb-4 fw-bold">
                {{ isset($user) ? '🛠 Cập nhật người dùng' : '➕ Thêm người dùng' }}
            </h4>

            <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                method="POST" enctype="multipart/form-data" class="needs-validation">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                {{-- Ảnh đại diện --}}
                <div class="mb-4 text-center">
                    <img id="thumbimage"
                        src="{{ !empty($user->avatar) ? asset('storage/' . $user->avatar) : '#' }}"
                        class="rounded-circle mb-2"
                        style="width: 120px; height: 120px; object-fit: cover; {{ empty($user->avatar) ? 'display: none;' : '' }}">
                    <div>
                        <input type="file" id="uploadfile" name="avatar" onchange="readURL(this);" accept="image/*" hidden>
                        <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="document.getElementById('uploadfile').click();">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Chọn hình
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="clearImage();">
                            <i class="fas fa-trash-alt me-1"></i> Xóa
                        </button>
                        @error('avatar')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Thông tin cá nhân --}}
                <h4>Thông tin cá nhân</h4>
                <div class="row g-3">
                    <div class="col-md-4 mt-2">
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="fullname" class="form-control"
                            value="{{ old('fullname', $user->fullname ?? '') }}">
                        @error('fullname')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $user->email ?? '') }}">
                        @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="@if(isset($user))Để trống nếu không đổi @endif">
                        @error('password')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $user->phone ?? '') }}">
                        @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control"
                            value="{{ old('address', $user->address ?? '') }}">
                        @error('address')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="birthday" class="form-control"
                            value="{{ old('birthday', isset($user->birthday) ? $user->birthday->format('Y-m-d') : '') }}">
                        @error('birthday')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Giới tính</label>
                        <select name="gender" class="form-control">
                            <option value="">-- Chọn --</option>
                            <option value="Nam" {{ old('gender', $user->gender ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender', $user->gender ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gender', $user->gender ?? '') == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr class="my-4">

                {{-- Thông tin hệ thống --}}
                <h4>Cài đặt hệ thống</h4>
                <div class="row g-3">
                    <div class="col-md-4 mt-2">
                        <label class="form-label">Vai trò</label>
                        <select name="role" class="form-control">
                            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="member" {{ old('role', $user->role ?? '') == 'member' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $user->status ?? '') == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('status', $user->status ?? '') == 0 ? 'selected' : '' }}>Tạm khóa</option>
                        </select>
                        @error('status')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mt-2">
                        <label class="form-label">Ngôn ngữ</label>
                        <input type="text" name="language" class="form-control"
                            value="{{ old('language', $user->language ?? '') }}">
                        @error('language')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="form-label">Giới thiệu</label>
                        <textarea name="introduction" rows="3" class="form-control">{{ old('introduction', $user->introduction ?? '') }}</textarea>
                        @error('introduction')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Nút hành động --}}
                <div class="text-end mt-4">
                    <button class="btn btn-success me-2" type="submit">
                        <i class="fas fa-save me-1"></i> Lưu
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script xử lý ảnh --}}
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('thumbimage');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function clearImage() {
        const img = document.getElementById('thumbimage');
        img.src = '';
        img.style.display = 'none';
        document.getElementById('uploadfile').value = '';
    }
</script>

@endsection

@extends('admin.layouts.index')

@section('title', isset($user) ? 'Cập nhật người dùng' : 'Thêm người dùng')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">{{ isset($user) ? 'Cập nhật người dùng' : 'Thêm người dùng' }}</h3>
            <div class="tile-body">
                <form class="row" action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($user)) @method('PUT') @endif

                    <div class="form-group col-md-4">
                        <label for="fullname">Họ tên</label>
                        <input type="text" class="form-control" name="fullname" value="{{ old('fullname', $user->fullname ?? '') }}">
                        @error('fullname')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email ?? '') }}">
                        @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" name="password">
                        @if(isset($user))<small class="text-muted">Bỏ trống nếu không đổi mật khẩu</small>@endif
                        @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="control-label">Ảnh đại diện</label>
                        <div id="myfileupload">
                            <input type="file" id="uploadfile" name="avatar" onchange="readURL(this);" accept="image/*" />
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


                    <div class="form-group col-md-4">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                        @error('phone')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{ old('address', $user->address ?? '') }}">
                        @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="role">Vai trò</label>
                        <select class="form-control" name="role">
                            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="member" {{ old('role', $user->role ?? '') == 'member' ? 'selected' : '' }}>User</option>
                        </select>
                        @error('role')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="status">Trạng thái</label>
                        <select class="form-control" name="status">
                            <option value="1" {{ old('status', $user->status ?? '') == 1 ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('status', $user->status ?? '') == 0 ? 'selected' : '' }}>Tạm khóa</option>
                        </select>
                        @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="gender">Giới tính</label>
                        <select class="form-control" name="gender">
                            <option value="">-- Chọn --</option>
                            <option value="Nam" {{ old('gender', $user->gender ?? '') == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender', $user->gender ?? '') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Khác" {{ old('gender', $user->gender ?? '') == 'Khác' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('gender')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="birthday">Ngày sinh</label>
                        <input type="date" class="form-control" name="birthday" value="{{ old('birthday', isset($user->birthday) ? $user->birthday->format('Y-m-d') : '') }}">
                        @error('birthday')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="language">Ngôn ngữ</label>
                        <input type="text" class="form-control" name="language" value="{{ old('language', $user->language ?? '') }}">
                        @error('language')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label for="introduction">Giới thiệu</label>
                        <textarea name="introduction" rows="3" class="form-control">{{ old('introduction', $user->introduction ?? '') }}</textarea>
                        @error('introduction')<span class="text-danger">{{ $message }}</span>@enderror
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
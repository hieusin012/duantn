@extends('clients.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light text-white text-center">
                    <h4 class="mb-0">Chỉnh sửa hồ sơ cá nhân</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Họ tên --}}
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input type="text" name="fullname" value="{{ old('fullname', $user->fullname) }}" class="form-control">
                            @error('fullname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Ảnh đại diện --}}
                        <div class="mb-3">
                            <label class="form-label">Ảnh đại diện</label><br>
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                            @else
                            
                                <i>Chưa có ảnh</i>
                            @endif
                            <input type="file" name="avatar" class="form-control mt-2">
                            @error('avatar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Số điện thoại --}}
                        <div class="mb-3">
                            <label class="form-label">Điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Địa chỉ --}}
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Giới tính --}}
                        <div class="mb-3">
                            <label class="form-label">Giới tính</label>
                            <select name="gender" class="form-select">
                                <option value="">-- Chọn --</option>
                                <option value="Nam" {{ $user->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ $user->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                <option value="Khác" {{ $user->gender == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('gender')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Ngày sinh --}}
                        <div class="mb-3">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" name="birthday" value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}" class="form-control">
                            @error('birthday')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Ngôn ngữ --}}
                        <div class="mb-3">
                            <label class="form-label">Ngôn ngữ</label>
                            <input type="text" name="language" value="{{ old('language', $user->language) }}" class="form-control">
                            @error('language')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Giới thiệu --}}
                        <div class="mb-3">
                            <label class="form-label">Giới thiệu</label>
                            <textarea name="introduction" rows="3" class="form-control">{{ old('introduction', $user->introduction) }}</textarea>
                            @error('introduction')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Nút hành động --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

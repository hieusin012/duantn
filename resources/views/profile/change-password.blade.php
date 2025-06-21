@extends('clients.layouts.master')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light text-white text-center">
                    <h4 class="mb-0">Thay đổi mật khẩu</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update-password') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Họ tên --}}
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu hiện tại" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">👁</button>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="new-password" name="password" placeholder="Nhập mật khẩu mới" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="NewPassword()">👁</button>
                            @error('new_password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="change-password" name="password" placeholder="Xác nhận mật khẩu" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="ChangePassword()">👁</button>
                            @error('change_password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
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
<script>
function togglePassword() {
  const input = document.getElementById("password");
  input.type = input.type === "password" ? "text" : "password";
}
function NewPassword() {
  const input = document.getElementById("new-password");
  input.type = input.type === "password" ? "text" : "password";
}
function ChangePassword() {
  const input = document.getElementById("chang-password");
  input.type = input.type === "password" ? "text" : "password";
}
</script>
@endsection
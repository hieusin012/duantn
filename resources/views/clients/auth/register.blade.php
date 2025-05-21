@extends('clients.layouts.master')

@section('title', 'Đăng ký tài khoản')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4"><i class="fa fa-user-plus me-2 text-primary"></i>Đăng ký tài khoản</h3>
                <form method="POST" action="#">
                    {{-- @csrf --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nguyễn Văn A">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Địa chỉ Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ít nhất 8 ký tự">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Tạo tài khoản</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none text-muted">Đã có tài khoản? <b>Đăng nhập</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

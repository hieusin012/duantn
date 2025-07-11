@extends('clients.layouts.master')

@section('title', 'Đăng ký')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow p-4">
                <h2 class="text-center mb-4">Đăng ký tài khoản</h2>
                <form method="POST" action="{{ route('register.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Họ và tên:</label>
                        <input type="text" id="fullname" name="fullname"
                            class="form-control @error('fullname') is-invalid @enderror"
                            value="{{ old('fullname') }}" placeholder="Nhập tên...">
                        @error('fullname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="Nhập email...">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu:</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Nhập mật khẩu...">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác nhận mật khẩu:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Nhập lại mật khẩu...">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Đăng ký</button>
                    </div>
                </form>

                <div class="my-3 text-center position-relative">
                    <hr class="text-muted">
                    <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted">Hoặc đăng ký bằng</span>
                </div>

                <div class="text-center">
                    <a href="#" class="btn btn-light border d-inline-flex align-items-center justify-content-center shadow-sm p-2 rounded-circle" style="width: 48px; height: 48px;">
                        <img src="{{ asset('images/google-icon.png') }}" alt="Google" width="24" height="24">
                    </a>
                </div>

                <div class="text-center mt-3">
                    <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

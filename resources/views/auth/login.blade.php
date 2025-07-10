@extends('clients.layouts.master')

@section('title', 'Đăng nhập')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow p-4">
                <h2 class="text-center mb-4">Đăng nhập tài khoản</h2>

                @if(session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @elseif(session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

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
                    <div class="form-check mb-3">
                        <a href="{{ route('forgot-password') }}" class="float-end">Quên mật khẩu?</a>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </div>
                </form>

                <div class="my-3 text-center position-relative">
                    <hr class="text-muted">
                    <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted">Hoặc đăng nhập bằng</span>
                </div>

                <div class="text-center">
                    <a href="{{ route('google.redirect') }}" class="btn btn-light border d-inline-flex align-items-center justify-content-center shadow-sm p-2 rounded-circle" style="width: 48px; height: 48px;">
                        <img src="{{ asset('images/google-icon.png') }}" alt="Google" width="24" height="24">
                    </a>
                </div>

                <div class="text-center mt-3">
                    <p>Bạn chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

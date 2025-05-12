@extends('clients.layouts.master')

@section('title', 'Đăng nhập')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4"><i class="fa fa-sign-in-alt me-2 text-success"></i>Đăng nhập</h3>
                <form method="POST" action="#">
                    {{-- @csrf --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Địa chỉ Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Đăng nhập</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="text-decoration-none text-muted">Chưa có tài khoản? <b>Đăng ký</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

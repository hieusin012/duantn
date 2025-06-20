@extends('clients.layouts.master')

@section('title', 'Đăng nhập')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow p-4">
                <h2 class="text-center mb-4">Nhập email để lấy lại mật khẩu</h2>

                @if(session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
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

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Gửi Email</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p><a href="{{ route('login') }}" class="text-primary">Đăng nhập</a>   -----hoặc-----   <a href="{{ route('register') }}" class="text-primary">Đăng ký</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

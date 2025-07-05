@extends('clients.layouts.master')
@section('title', 'Tra cứu đơn hàng')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow rounded-4">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">🔍 Tra cứu đơn hàng</h3>

                    @if(session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('order.lookup') }}" method="POST" class="row g-4">
                        @csrf
                        <div class="col-12">
                            <label for="order_code" class="form-label fw-semibold">📦 Mã đơn hàng</label>
                            <input type="text" class="form-control rounded-pill px-4 @error('order_code') is-invalid @enderror" name="order_code" value="{{ old('order_code') }}" placeholder="VD: ORD123456">
                            @error('order_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="email_or_phone" class="form-label fw-semibold">📧 Email hoặc 📱 SĐT</label>
                            <input type="text" class="form-control rounded-pill px-4 @error('email_or_phone') is-invalid @enderror" name="email_or_phone" value="{{ old('email_or_phone') }}" placeholder="VD: example@gmail.com hoặc 0987654321">
                            @error('email_or_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill">
                                <i class="anm anm-search-l me-1"></i> Tra cứu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('clients.layouts.master')

@section('title', 'Thanh toán bằng mã QR')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4 text-success">Quét mã QR để thanh toán</h2>

    <p>Vui lòng chuyển khoản đúng số tiền <strong>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</strong> vào tài khoản bên dưới.</p>

    <img src="{{ asset('uploads/products/loaloa.jfif') }}"alt="Mã QR" style="max-width: 300px;" class="img-fluid">


    
    <p class="mt-3">Nội dung chuyển khoản: <strong>{{ $order->code }}</strong></p>
    <p>Ngân hàng: Techcombank<br>
        Chủ tài khoản: Nguyễn Đức Hiếu<br>
        SĐT/Zalo: 0375961216
    </p>

    <a href="{{ route('client.home') }}" class="btn btn-primary mt-4">Về trang chủ</a>
</div>
@endsection

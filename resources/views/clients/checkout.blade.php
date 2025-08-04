@extends('clients.layouts.master')

@section('title', 'Thanh Toán Đơn Hàng')

@section('content')
<style>
    /** thông tin giao hàng */
    .form-section .form-label {
        font-weight: 600;
        color: #333;
    }

    .form-section .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
        padding: 10px 15px;
        transition: all 0.3s ease-in-out;
        box-shadow: none;
    }

    .form-section .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
        background-color: #fefeff;
    }

    .form-section .form-label::before {
        content: attr(data-icon);
        margin-right: 8px;
    }

    .form-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        border: 1px solid #e3e6ea;
    }

    /* tóm tắt đơn hàng */
    .scrollable-products {
        max-height: 300px;
        overflow-y: auto;
        padding: 12px;
        background-color: #f8f9fa;
        border: 2px solid #0d6efd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }

    .scrollable-products::-webkit-scrollbar {
        width: 6px;
    }

    .scrollable-products::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .scrollable-products {
            max-height: 200px;
        }
    }

    .hover-shadow {
        transition: all 0.2s ease-in-out;
        border-radius: 8px;
    }

    .hover-shadow:hover {
        background-color: #ffffff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
        /* nổi lên một chút */
        border: 1px solid rgb(0, 0, 0);
        /* viền xanh nổi bật khi hover */
    }

    /* phuong thuc thanh toán */
    .payment-option {
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 16px;
        transition: 0.2s ease-in-out;
        cursor: pointer;
        background-color: #fff;
        display: flex;
        align-items: center;

    }

    .payment-option:hover {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.1);
    }

    .payment-option.selected {
        border-color: #198754;
        background-color: #e6ffed;
    }

    .payment-option .form-check-input {
        transform: scale(1.1);
        margin-right: 12px;
        margin-top: 0;
    }

    .payment-icon {
        font-size: 1.2rem;
        margin-right: 8px;
    }

    .payment-label {
        font-weight: 500;
        flex-grow: 1;
    }

    .payment-logo {
        width: 60px;
        object-fit: contain;
    }
</style>
<div class="page-header text-center">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h1>Trang thanh toán</h1>
                </div>
                <div class="breadcrumbs">
                    <a href="{{ route('client.home') }}" title="Back to the home page">Home</a>
                    <span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Sản phẩm</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <input type="hidden" name="voucher_code" value="{{ request('voucher_code') }}">
        <input type="hidden" name="selected_items" value="{{ request()->input('selected_items') }}">

        <div class="row">
            <!-- Cột trái -->
            <div class="col-md-8">
                <h2 class="mb-4">Thông Tin Thanh Toán</h2>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card mb-4 border shadow">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-truck me-2"></i>Thông Tin Giao Hàng
                    </div>
                    <div class="card-body form-section">
                        <div class="mb-3">
                            <label for="fullname" class="form-label" data-icon="👤">Họ và Tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                value="{{ old('fullname', Auth::user()->fullname ?? '') }}" placeholder="Nhập họ và tên (VD: Nguyễn Văn A)" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label" data-icon="📞">Số Điện Thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone', Auth::user()->phone ?? '') }}" placeholder="Nhập số điện thoại (VD: 0987654321)" pattern="[0-9]{10,11}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label" data-icon="🏠">Địa Chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address', Auth::user()->address ?? '') }}" placeholder="Nhập địa chỉ (VD: Số nhà 10, Ngõ 5, Đường Láng, Quận Đống Đa, Hà Nội)" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label" data-icon="📧">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', Auth::user()->email ?? '') }}" placeholder="Nhập email (VD: user@gmail.com)" required>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label" data-icon="📝">Ghi Chú (Tùy chọn)</label>
                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note') }}</textarea>
                        </div>
                    </div>

                </div>


                <div class="card mb-4 border shadow">
                    <div class="card-header bg-success text-white fw-bold">
                        <i class="bi bi-truck me-2"></i>Phương thức thanh toán
                    </div>
                    <div class="card-body">

                        @php
                        $selected = old('payment');
                        @endphp

                        <div class="payment-option {{ $selected == 'Thanh toán khi nhận hàng' ? 'selected' : '' }}">
                            <input class="form-check-input" type="radio" name="payment" id="paymentCod"
                                value="Thanh toán khi nhận hàng" {{ $selected == 'Thanh toán khi nhận hàng' ? 'checked' : '' }} required>
                            <label for="paymentCod" class="d-flex align-items-center w-100 mb-0">
                                <span class="payment-icon">🛵</span>
                                <span class="payment-label">Thanh toán khi nhận hàng (COD)</span>
                            </label>
                        </div>

                        <div class="payment-option {{ $selected == 'Thanh toán bằng mã QR' ? 'selected' : '' }}">
                            <input class="form-check-input" type="radio" name="payment" id="paymentQr"
                                value="Thanh toán bằng mã QR" {{ $selected == 'Thanh toán bằng mã QR' ? 'checked' : '' }} required>
                            <label for="paymentQr" class="d-flex align-items-center w-100 mb-0">
                                <span class="payment-icon">📱</span>
                                <span class="payment-label">Thanh toán bằng mã QR (chuyển khoản)</span>
                            </label>
                        </div>

                        <div class="payment-option {{ $selected == 'Thanh toán qua VNPay' ? 'selected' : '' }}">
                            <input class="form-check-input" type="radio" name="payment" id="paymentVnPay"
                                value="Thanh toán qua VNPay" {{ $selected == 'Thanh toán qua VNPay' ? 'checked' : '' }} required>
                            <label for="paymentVnPay" class="d-flex align-items-center w-100 mb-0">
                                <span class="payment-icon">💳</span>
                                <span class="payment-label">Thanh toán qua VNPay</span>
                                <img src="{{ asset('assets/client/images/logo/vnpay.png') }}" class="payment-logo ms-auto" alt="VNPay">
                            </label>
                        </div>

                    </div>
                </div>

            </div>

            <!-- Cột phải -->
            <div class="col-md-4">
                <h3 class="mb-4">Tóm Tắt Đơn Hàng</h3>
                <div class="card shadow-lg rounded-4">
                    <div class="card-header bg-dark text-white fw-bold">
                        <i class="bi bi-truck me-2"></i>Thông tin sản phẩm
                    </div>
                    <div class="card-body">
                        <div class="product-item p-2 mb-2 rounded border hover-shadow" style="max-height: 270px; overflow-y: auto;">
                            @foreach ($cartItems as $item)
                            <div class="product-item hover-shadow p-2 mb-2 bg-white">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h2 class="mb-0 fw-bold">{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</h2>
                                        <small class="text-muted">
                                            <b>Màu:</b> {{ $item->variant->color->name ?? 'N/A' }},<br>
                                            <b>Size:</b> {{ $item->variant->size->name ?? 'N/A' }}
                                        </small><br>
                                        <small><strong>SL:</strong> {{ $item->quantity }} x {{ number_format($item->price_at_purchase, 0, ',', '.') }} ₫</small>
                                    </div>
                                    <span class="fw-bold">{{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }} ₫</span>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Tổng tiền sản phẩm:</span>
                            <span>{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Mã giảm giá:</span>
                            <span class="text-danger">- {{ number_format($discount, 0, ',', '.') }} ₫</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($shippingCost, 0, ',', '.') }} ₫ <small class="text-success">(FREE)</small></span>
                        </div>

                        <div class="d-flex justify-content-between fw-bold fs-5 text-primary bg-light p-3 rounded">
                            <span>TỔNG SỐ TIỀN:</span>
                            <span>{{ number_format($totalPrice, 0, ',', '.') }} ₫</span>
                        </div>

                        <div class="mt-4">
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" {{ old('agree_terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="agree_terms">
                                    Tôi đồng ý với các điều khoản và điều kiện <span class="text-danger">*</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-danger btn-lg w-100 shadow">
                                💳 HOÀN TẤT ĐẶT HÀNG
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- phuong thuc thanh toán -->
<script>
    document.querySelectorAll('input[name="payment"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-option').forEach(function(el) {
                el.classList.remove('selected');
            });
            this.closest('.payment-option').classList.add('selected');
        });
    });
</script>

@endsection
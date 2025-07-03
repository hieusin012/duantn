@extends('clients.layouts.master') {{-- Đã sửa đường dẫn layout --}}

@section('title', 'Thanh Toán Đơn Hàng')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Thông Tin Thanh Toán</h2>

            {{-- Hiển thị lỗi validation --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Hiển thị thông báo thành công/lỗi từ controller --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="card mb-4">
                    <div class="card-header">Thông Tin Giao Hàng</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                            {{-- Lấy giá trị cũ hoặc từ Auth::user() nếu có --}}
                            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', Auth::user()->fullname ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa Chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', Auth::user()->address ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi Chú (Tùy chọn)</label>
                            <textarea class="form-control" id="note" name="note" rows="3">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Phương Thức Thanh Toán</div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="paymentCod" value="Thanh toán khi nhận hàng" {{ old('payment') == 'Thanh toán khi nhận hàng' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="paymentCod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <!-- <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="paymentCard" value="Thanh toán bằng thẻ" {{ old('payment') == 'Thanh toán bằng thẻ' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="paymentCard">
                                Thanh toán bằng thẻ
                            </label>
                            {{-- Bạn có thể thêm các trường nhập liệu thẻ tín dụng ở đây nếu xử lý trực tiếp --}}
                        </div> -->
                        <div class="form-check mb-2">
    <input class="form-check-input" type="radio" name="payment" id="paymentQr" value="Thanh toán bằng mã QR" {{ old('payment') == 'Thanh toán bằng mã QR' ? 'checked' : '' }} required>
    <label class="form-check-label" for="paymentQr">
        Thanh toán bằng mã QR (Chuyển khoản ngân hàng)
    </label>
</div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment" id="paymentVnPay" value="Thanh toán qua VNPay" {{ old('payment') == 'Thanh toán qua VNPay' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="paymentVnPay">
                                Thanh toán qua VNPay
                            </label>
                            {{-- Tích hợp VNPAY API sẽ cần mã nguồn JS và logic xử lý ở đây --}}
                        </div>
                    </div>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" {{ old('agree_terms') ? 'checked' : '' }} required>
                    <label class="form-check-label" for="agree_terms">
                        Tôi đồng ý với các điều khoản và điều kiện <span class="text-danger">*</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">HOÀN TẤT ĐẶT HÀNG</button>
            </form>
        </div>

        <div class="col-md-4">
            <h3 class="mb-4">Tóm Tắt Đơn Hàng</h3>
            <div class="card">
                <div class="card-body">
                    {{-- Duyệt qua các sản phẩm trong giỏ hàng để hiển thị --}}
                    @foreach ($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <h6 class="mb-0">{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</h6>
                                <small>Màu: {{ $item->variant->color->name ?? 'N/A' }}, Size: {{ $item->variant->size->name ?? 'N/A' }}</small><br>
                                <small>SL: {{ $item->quantity }} x {{ number_format($item->price_at_purchase, 0, ',', '.') }} VNĐ</small>
                            </div>
                            <span>{{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <hr>
                    @endforeach

                    <div class="d-flex justify-content-between mb-2">
                        <span>Tổng tiền sản phẩm:</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Mã giảm giá:</span>
                        <span>{{ number_format($discount, 0, ',', '.') }} VNĐ</span> {{-- Đã tính toán từ controller --}}
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Thuế:</span>
                        <span>{{ number_format($tax, 0, ',', '.') }} VNĐ</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Phí vận chuyển:</span>
                        <span>{{ number_format($shippingCost, 0, ',', '.') }} VNĐ (FREE SHIPPING)</span>
                    </div>

                    <div class="d-flex justify-content-between fw-bold fs-5 text-primary">
                        <span>TỔNG SỐ TIỀN:</span>
                        <span>{{ number_format($totalPrice, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
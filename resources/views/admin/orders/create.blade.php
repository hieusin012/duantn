
@extends('admin.layouts.index')

@section('title', 'Tạo mới đơn hàng')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Tạo mới đơn hàng</h3>
            <div class="tile-body">
                <form method="POST" action="{{ route('admin.orders.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" name="fullname" class="form-control @error('fullname') is-invalid @enderror" value="{{ old('fullname') }}">
                                @error('fullname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- <div class="form-group">
                                <label>Khách hàng</label>
                                <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
                                    <option value="">Chọn khách hàng</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label>Phương thức thanh toán</label>
                                <select name="payment" class="form-control @error('payment') is-invalid @enderror">
                                    @foreach (['Thanh toán khi nhận hàng', 'Thanh toán bằng thẻ', 'Thanh toán qua VNPay'] as $payment)
                                        <option value="{{ $payment }}" {{ old('payment') == $payment ? 'selected' : '' }}>
                                            {{ $payment }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Trạng thái đơn hàng</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    @foreach (['Chờ xác nhận', 'Đã xác nhận', 'Đang chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng', 'Đơn hàng đã hủy', 'Đã hoàn hàng'] as $status)
                                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Trạng thái thanh toán</label>
                                {{-- <select name="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                                    @foreach (['Chưa thanh toán', 'Đã thanh toán'] as $payment_status)
                                        <option value="{{ $payment_status }}" {{ old('payment_status') == $payment_status ? 'selected' : '' }}>
                                            {{ $payment_status }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                <select name="payment_status" class="form-control @error('payment_status') is-invalid @enderror">
                                    @foreach (['Chưa thanh toán', 'Đã thanh toán', 'Đã hoàn tiền'] as $payment_status)
                                        <option value="{{ $payment_status }}" {{ old('payment_status') == $payment_status ? 'selected' : '' }}>
                                            {{ $payment_status }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('payment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phí vận chuyển</label>
                                <input type="number" name="shiping" class="form-control @error('shiping') is-invalid @enderror" value="{{ old('shiping') }}">
                                @error('shiping')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Giảm giá</label>
                                <input type="number" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount') }}">
                                @error('discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tổng tiền</label>
                                <input type="number" name="total_price" class="form-control @error('total_price') is-invalid @enderror" value="{{ old('total_price') }}">
                                @error('total_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea name="note" class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
                        @error('note')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
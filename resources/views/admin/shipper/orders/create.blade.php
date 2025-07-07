@extends('admin.layouts.index')

@section('title', 'Tạo đơn hàng mới')

@section('content')
<div class="container">
    <h3 class="mb-4">Tạo đơn hàng mới</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.shipper.orders.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Họ và tên</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Số điện thoại</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Địa chỉ giao hàng</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phương thức thanh toán</label>
            <select name="payment" class="form-select" required>
                <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                <option value="Thanh toán bằng thẻ">Thanh toán bằng thẻ</option>
                <option value="Thanh toán qua VNPay">Thanh toán qua VNPay</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tổng tiền (VNĐ)</label>
            <input type="number" name="total_price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú (nếu có)</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
        <a href="{{ route('admin.shipper.orders.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
    
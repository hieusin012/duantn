@extends('admin.layouts.master')

@section('title', 'Bảng điều khiển')
@section('page-title', 'Bảng điều khiển')

@section('content')
    <div class="row g-4">
        <div class="col-md-4">
            <div class="bg-white p-4 rounded shadow-sm">
                <h5><i class="fa fa-shirt me-2 text-primary"></i> Tổng số sản phẩm</h5>
                <p class="fs-4 fw-bold">152</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white p-4 rounded shadow-sm">
                <h5><i class="fa fa-cart-shopping me-2 text-success"></i> Đơn hàng hôm nay</h5>
                <p class="fs-4 fw-bold">24</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bg-white p-4 rounded shadow-sm">
                <h5><i class="fa fa-users me-2 text-warning"></i> Khách hàng</h5>
                <p class="fs-4 fw-bold">430</p>
            </div>
        </div>
    </div>
@endsection

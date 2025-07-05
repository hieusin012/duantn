@extends('admin.layouts.index')

@section('title', 'Báo cáo doanh thu')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                {{-- Bộ lọc thời gian --}}
                <form method="GET" action="{{ route('admin.orders.report') }}" class="container-fluid bg-light p-3 rounded shadow-sm mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>Từ ngày</label>
                            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
                        </div>
                        <div class="col-md-3">
                            <label>Đến ngày</label>
                            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
                        </div>
                        <div class="col-md-3 align-self-end d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-sm w-100"><i class="fa fa-filter"></i> Lọc</button>
                            <a href="{{ route('admin.orders.report') }}" class="btn btn-dark btn-sm w-100"><i class="fa fa-times"></i> Xóa</a>
                        </div>
                    </div>
                </form>

                {{-- Thống kê --}}
                <div class="mb-3">
                    <p><strong>Tổng số đơn hàng:</strong> {{ $totalOrders }}</p>
                    <p><strong>Tổng doanh thu:</strong> {{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</p>
                </div>

                {{-- Nút chức năng --}}
                <div class="row element-button mb-3">
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm print-file" type="button" title="In"><i class="fas fa-print"></i> In dữ liệu</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="Xuất Excel"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="Xuất PDF"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    </div>
                </div>

                {{-- Bảng đơn hàng --}}
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Ngày giao hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $order->code }}</td>
                                <td>{{ $order->fullname }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Phân trang (nếu cần) --}}
                {{-- <div class="pagination">{{ $orders->links() }}</div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

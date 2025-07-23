@extends('admin.layouts.index')

@section('title', 'Quản lý đơn hàng')

@section('content')
<style>
    .filter-form {
        background: #ffffff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.12);
        border: 1px solid #e0e0e0;
        transition: box-shadow 0.3s ease;
    }

    .filter-form:hover {
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.16);
    }


    .filter-form .form-control-sm {
        border-radius: 8px;
        height: 38px;
    }

    .filter-form select,
    .filter-form input {
        font-size: 14px;
    }

    .filter-form .btn-sm {
        border-radius: 8px;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .filter-form .row>div {
            margin-bottom: 10px;
        }
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                {{-- Filter --}}
                <form method="GET" action="{{ route('admin.orders.index') }}" class="filter-form mb-4">
                    <div class="row g-6 align-items-end">
                        <div class="col-md-2">
                            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Mã đơn / Số điện thoại" value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control form-control-sm">
                                <option value="">-- Trạng thái --</option>
                                @foreach (['Chờ xác nhận', 'Đã xác nhận', 'Đang chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng', 'Đơn hàng đã hủy', 'Đã hoàn hàng', 'Hoàn tất'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="payment_status" class="form-control form-control-sm">
                                <option value="">-- Thanh toán --</option>
                                @foreach (['Chưa thanh toán', 'Đã thanh toán', 'Đã hoàn tiền'] as $payment_status)
                                <option value="{{ $payment_status }}" {{ request('payment_status') == $payment_status ? 'selected' : '' }}>{{ $payment_status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="user_id" class="form-control form-control-sm">
                                <option value="">-- Khách hàng --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Từ" value="{{ request('min_price') }}">
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Đến" value="{{ request('max_price') }}">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-sm" style="margin-left: 15px; margin-top: 10px">
                                <i class="fas fa-filter me-1"></i> Lọc 
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm" style="margin-left: 20px; margin-top: 10px">
                                <i class="fas fa-sync-alt me-1"></i> Reset 
                            </a>
                        </div>
                    </div>
                </form>
                {{-- Button Add --}}
                <div class="mb-3">
                    <a class="btn btn-success btn-sm" href="{{ route('admin.orders.create') }}">
                        <i class="fas fa-plus"></i> Tạo đơn hàng mới
                    </a>
                </div>

                {{-- Orders Table --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th><input type="checkbox" id="all"></th>
                                <th>Mã đơn</th>
                                <th>Người nhận</th>
                                <th>Điện thoại</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Lý do hủy</th>
                                <th>Thanh toán</th>
                                <th>Khách hàng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td><input type="checkbox" name="check[]" value="{{ $order->id }}"></td>
                                <td class="fw-bold text-primary">{{ $order->code }}</td>
                                <td>{{ $order->fullname }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }} ₫</td>
                                <td>
                                    @php
                                    $statusClass = match($order->status) {
                                    'Chờ xác nhận' => 'bg-secondary',
                                    'Đã xác nhận' => 'bg-info',
                                    'Đang chuẩn bị hàng' => 'bg-primary',
                                    'Đang giao hàng' => 'bg-warning text-dark',
                                    'Đã giao hàng' => 'bg-success',
                                    'Hoàn tất' => 'bg-success',
                                    'Đơn hàng đã hủy' => 'bg-danger',
                                    'Đã hoàn hàng' => 'bg-dark text-warning',
                                    default => 'bg-light text-dark'
                                    };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    @if ($order->status === 'Đơn hàng đã hủy')
                                    <small class="text-danger">{{ $order->cancel_reason }}</small>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>
                                    {{-- <span class="badge {{ $order->payment_status === 'Đã thanh toán' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $order->payment_status }}
                                    </span> --}}
                                    @php
                                        $paymentClass = match($order->payment_status) {
                                            'Chưa thanh toán' => 'bg-danger',
                                            'Đã thanh toán' => 'bg-success',
                                            'Đã hoàn tiền' => 'bg-warning',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $paymentClass }}">
                                        {{ $order->payment_status }}
                                    </span>
                                </td>
                                <td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-success btn-sm" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('admin.layouts.index')

@section('title', 'Quản lý đơn hàng')

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.orders.index') }}" class="container-fluid bg-light p-3 rounded shadow-sm mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Tìm theo mã đơn, tên khách..." value="{{ request('keyword') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select form-select-sm form-control">
                                <option value="">Tất cả trạng thái</option>
                                @foreach (['Chờ xác nhận', 'Đã xác nhận', 'Đang chuẩn bị hàng', 'Đang giao hàng', 'Đã giao hàng', 'Đơn hàng đã hủy'] as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="payment_status" class="form-select form-select-sm form-control">
                                <option value="">Tất cả trạng thái thanh toán</option>
                                @foreach (['Chưa thanh toán', 'Đã thanh toán'] as $payment_status)
                                    <option value="{{ $payment_status }}" {{ request('payment_status') == $payment_status ? 'selected' : '' }}>
                                        {{ $payment_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="user_id" class="form-select form-select-sm form-control">
                                <option value="">Tất cả khách hàng</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                    <div class="row g-2 mt-2">
                        <div class="col-md-3">
                            <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Giá từ..." value="{{ request('min_price') }}">
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Giá đến..." value="{{ request('max_price') }}">
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-warning btn-sm w-100">
                                <i class="fa fa-filter"></i> Lọc
                            </button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-dark btn-sm w-100">
                                <i class="fa fa-times"></i> Xóa
                            </a>
                        </div>
                    </div>
                </form>

                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.orders.create') }}" title="Thêm"><i class="fas fa-plus"></i> Tạo mới đơn hàng</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-excel btn-sm" href="#" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                    </div>
                    <div class="col-sm-2">
                        <a class="btn btn-delete btn-sm pdf-file" type="button" title="In"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    </div>
                </div>
                
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Mã đơn hàng</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Lý do hủy</th>
                            <th>Thanh toán</th>
                            <th>Khách hàng</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td width="10"><input type="checkbox" name="check[]" value="{{ $order->id }}"></td>
                            <td>{{ $order->code }}</td>
                            <td>{{ $order->fullname }}</td>
                            <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge {{ $order->status == 'Đã giao hàng' ? 'bg-success' : ($order->status == 'Đơn hàng đã hủy' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                @if ($order->status == 'Đơn hàng đã hủy')
                                    {{ $order->cancel_reason }}<br>
                                    <small class="text-muted">{{ $order->cancel_note }}</small>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $order->payment_status == 'Đã thanh toán' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td>{{ $order->user ? $order->user->name : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary btn-sm edit" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary btn-sm trash" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary btn-sm" title="Xem chi tiết">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
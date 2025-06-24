@extends('admin.layouts.index')

@section('title', 'Quản lý voucher')

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

                <div class="row element-button mb-3">
                    <div class="col-sm-3">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.vouchers.create') }}" title="Thêm"><i class="fas fa-plus"></i> Tạo mới voucher</a>
                    </div>
                </div>

                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã Voucher</th>
                            <th>Loại</th>
                            <th>Giảm</th>
                            <th>Tối đa</th>
                            <th>Số lượng</th>
                            <th>Đã dùng</th>
                            <th>Thời gian</th>
                            <th>Trạng thái</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $voucher->code }}</strong></td>
                                <td>{{ $voucher->discount_type == 'percent' ? 'Phần trăm' : 'Cố định' }}</td>
                                <td>{{ $voucher->discount }} {{ $voucher->discount_type == 'percent' ? '%' : 'đ' }}</td>
                                <td>{{ $voucher->max_price ? number_format($voucher->max_price) . ' đ' : 'Không giới hạn' }}</td>
                                <td>{{ $voucher->quantity }}</td>
                                <td>{{ $voucher->used }}</td>
                                <td>
                                    @if ($voucher->start_date && $voucher->end_date)
                                        {{ $voucher->start_date }} - {{ $voucher->end_date }}
                                    @else
                                        Không giới hạn
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $voucher->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $voucher->is_active ? 'Kích hoạt' : 'Vô hiệu' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa voucher này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                    <a href="{{ route('admin.vouchers.show', $voucher->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    {{ $vouchers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

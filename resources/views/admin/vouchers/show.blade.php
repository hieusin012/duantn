@extends('admin.layouts.index')

@section('title', 'Chi tiết voucher')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile">
            <h3 class="tile-title mb-3">Chi tiết voucher: <strong>{{ $voucher->code }}</strong></h3>
            <div class="tile-body">

                <table class="table table-bordered">
                    <tr>
                        <th>Mã voucher</th>
                        <td>{{ $voucher->code }}</td>
                    </tr>
                    <tr>
                        <th>Giảm giá</th>
                        <td>
                            {{ $voucher->discount }}
                            {{ $voucher->discount_type == 'percent' ? '%' : 'VNĐ' }}
                            @if($voucher->max_price)
                                (Tối đa {{ number_format($voucher->max_price) }} VNĐ)
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Loại giảm giá</th>
                        <td>{{ $voucher->discount_type == 'percent' ? 'Phần trăm' : 'Cố định' }}</td>
                    </tr>
                    <tr>
                        <th>Số lượng</th>
                        <td>{{ $voucher->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Đã dùng</th>
                        <td>{{ $voucher->used }}</td>
                    </tr>
                    <tr>
                        <th>Ngày hiệu lực</th>
                        <td>
                            @if($voucher->start_date && $voucher->end_date)
                                Từ {{ \Carbon\Carbon::parse($voucher->start_date)->format('d/m/Y') }}
                                đến {{ \Carbon\Carbon::parse($voucher->end_date)->format('d/m/Y') }}
                            @else
                                Không giới hạn
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            <span class="badge {{ $voucher->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $voucher->is_active ? 'Kích hoạt' : 'Vô hiệu' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tạo lúc</th>
                        <td>{{ $voucher->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Cập nhật lúc</th>
                        <td>{{ $voucher->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3">
                    <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

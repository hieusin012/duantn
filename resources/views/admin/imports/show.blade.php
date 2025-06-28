@extends('admin.layouts.index')

@section('title', 'Chi tiết phiếu nhập')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Chi tiết phiếu nhập: {{ $import->code }}</h3>
            <div class="tile-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Nhà cung cấp:</strong> {{ $import->supplier->name ?? 'N/A' }}</p>
                        <p><strong>Người nhập:</strong> {{ $import->user->fullname ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ghi chú:</strong> {{ $import->note ?? 'Không có' }}</p>
                        <p><strong>Tổng tiền:</strong> {{ number_format($import->total_price, 0, ',', '.') }} đ</p>
                    </div>
                </div>

                <h5>Danh sách sản phẩm</h5>
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($import->details as $detail)
                        <tr>
                            <td>{{ $detail->product->name ?? 'Không xác định' }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($detail->total_price, 0, ',', '.') }} đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('admin.imports.index') }}" class="btn btn-cancel mt-3">Quay lại</a>
            </div>
        </div>
    </div>
</div>
@endsection

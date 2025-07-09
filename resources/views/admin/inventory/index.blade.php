@extends('admin.layouts.index')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Quản lý tồn kho</h4>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Sản phẩm</th>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>Số lượng tồn</th>
                        <th>Đã bán</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($variants as $index => $variant)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $variant->product->name }}</td>
                            <td>{{ $variant->color->name ?? '-' }}</td>
                            <td>{{ $variant->size->name ?? '-' }}</td>
                            <td>{{ $variant->quantity }}</td>
                            <td>{{ $variant->orderDetails->sum('quantity') }}</td>
                            <td>
                                @if($variant->quantity == 0)
                                <span class="badge bg-danger">Hết hàng</span>
                                @elseif($variant->quantity < $lowStockThreshold)
                                <span class="badge bg-light text-danger border border-danger">Sắp hết hàng</span>
                                @else
                                <span class="badge bg-success">Còn hàng</span>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    @if($variants->isEmpty())
                        <tr>
                            <td colspan="7">Không có dữ liệu tồn kho.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


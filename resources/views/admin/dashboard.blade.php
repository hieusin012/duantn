@extends('admin.layouts.index')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="row">
    <div class="col-md-12 col-lg-6">
        <div class="row">
            <div class="col-md-6">
                <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
                    <div class="info">
                        <h4>Tổng khách hàng</h4>
                        <p><b>{{ $totalCustomers ?? 0 }} khách hàng</b></p>
                        <p class="info-tong">Tổng số khách hàng được quản lý.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
                    <div class="info">
                        <h4>Tổng sản phẩm</h4>
                        <p><b>{{ $totalProducts ?? 0 }} sản phẩm</b></p>
                        <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
                    <div class="info">
                        <h4>Tổng đơn hàng</h4>
                        <p><b>{{ $totalOrders ?? 0 }} đơn hàng</b></p>
                        <p class="info-tong">Tổng số hóa đơn bán hàng trong tháng.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="widget-small danger coloured-icon"><i class='icon bx bxs-error-alt fa-3x'></i>
                    <div class="info">
                        <h4>Sắp hết hàng</h4>
                        {{-- Biến $lowStockProducts đang bị tạm khóa trong Controller, hãy mở lại sau khi bạn có cột stock --}}
                        <p><b>{{ $lowStockProducts ?? 'N/A' }} sản phẩm</b></p>
                        <p class="info-tong">Số sản phẩm cảnh báo hết cần nhập thêm.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Tình trạng đơn hàng</h3>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID đơn hàng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->code }}</td>
                                    {{-- Sử dụng fullname từ model User liên kết qua order --}}
                                    <td>{{ $order->user->fullname ?? $order->fullname }}</td>
                                    {{-- Sử dụng total_price từ model Order --}}
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                                    <td><span class="badge bg-info">{{ $order->status }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">Không có đơn hàng nào gần đây.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Khách hàng mới</h3>
                    <div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên khách hàng</th>
                                    <th>Ngày sinh</th>
                                    <th>Số điện thoại</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($newCustomers as $customer)
                                <tr>
                                    <td>#{{ $customer->id }}</td>
                                    {{-- Sử dụng các cột từ model User --}}
                                    <td>{{ $customer->fullname }}</td>
                                    <td>{{ $customer->birthday ? $customer->birthday->format('d/m/Y') : 'Chưa có' }}</td>
                                    <td><span class="tag tag-success">{{ $customer->phone }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">Không có khách hàng mới nào.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6">
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Khách hàng mới 6 tháng qua</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Thống kê 6 tháng doanh thu</h3>
                    <div class="embed-responsive embed-responsive-16by9">
                        <canvas class="embed-responsive-item" id="barChartDemo"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Nhúng thư viện Chart.js từ CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">
    // --- Biểu đồ Doanh thu (Bar Chart) ---
    const ctxBar = document.getElementById('barChartDemo');
    if (ctxBar) {
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($revenueLabels ?? []),
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: @json($revenueValues ?? []),
                    backgroundColor: 'rgba(220, 220, 220, 0.5)',
                    borderColor: 'rgba(220, 220, 220, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // --- Biểu đồ Khách hàng mới (Line Chart) ---
    const ctxLine = document.getElementById('lineChartDemo');
    if (ctxLine) {
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($customerLabels ?? []),
                datasets: [{
                    label: 'Khách hàng mới',
                    data: @json($customerValues ?? []),
                    fill: false,
                    borderColor: 'rgba(151, 187, 205, 1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // <-- THÊM DÒNG NÀY ĐỂ BẮT BUỘC TRỤC Y LÀ SỐ NGUYÊN
                        }
                    }
                }
            }
        });
    }
</script>
@endpush
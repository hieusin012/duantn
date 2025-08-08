@extends('admin.layouts.index')

@section('title', 'Bảng điều khiển')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f9fafb;
    }

    .widget-small {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        transition: transform 0.2s ease;
    }

    .widget-small:hover {
        transform: translateY(-2px);
    }

    .widget-small .icon {
        font-size: 36px;
        margin-right: 16px;
        color: #3b82f6;
    }

    .widget-small.primary .icon {
        color: #2563eb;
    }

    .widget-small.info .icon {
        color: #0ea5e9;
    }

    .widget-small.warning .icon {
        color: #f59e0b;
    }

    .widget-small.danger .icon {
        color: #ef4444;
    }

    .widget-small .info h4 {
        font-size: 16px;
        margin: 0;
        color: #374151;
    }

    .widget-small .info p {
        margin: 4px 0;
        font-size: 18px;
        font-weight: 600;
        color: #111827;
    }

    .info-tong {
        font-size: 12px;
        color: #6b7280;
    }

    .tile {
        background-color: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
    }

    .tile-title {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
    }

    .btn {
        border-radius: 8px;
    }

    .table th {
        background-color: #f3f4f6;
        color: #374151;
    }

    .table td {
        vertical-align: middle;
    }

    .badge.bg-info {
        background-color: #3b82f6 !important;
        color: white;
        padding: 4px 10px;
        border-radius: 6px;
    }

    .tag-success {
        background-color: #dcfce7;
        color: #16a34a;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 14px;
    }

    .text-primary {
        font-size: 20px;
        font-weight: 600;
        color: #2563eb !important;
    }

    .form-control {
        border-radius: 8px;
    }

    input[type="date"] {
        min-width: 160px;
    }

    canvas {
        max-height: 320px;
    }
</style>

<div class="row mb-4">
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
                    <h3 class="tile-title">Đơn hàng chờ xử lý</h3>
                    <div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID đơn hàng</th>
                                    <th>Tên khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Hành động</th>
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
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-success btn-sm" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
                    <h3 class="tile-title">Thống kê tăng trưởng người dùng</h3>
                    <form method="GET" class="row align-items-end g-2 mb-4">
                        <div class="col-auto">
                            <label for="user_start" class="form-label mb-0">Từ ngày</label>
                            <input type="date" id="user_start" class="form-control" />
                        </div>
                        <div class="col-auto">
                            <label for="user_end" class="form-label mb-0">Đến ngày</label>
                            <input type="date" id="user_end" class="form-control" />
                        </div>
                        <div class="col-auto">
                            <button type="button" onclick="loadUserChart()" class="btn btn-success">
                                <i class="bx bx-bar-chart"></i> Xem biểu đồ
                            </button>
                        </div>
                    </form>

                    <div class="tile mt-4">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Thống kê doanh thu</h3>
                    <form method="GET" class="row align-items-end g-2 mb-4">
                        <div class="col-auto">
                            <label for="revenue_start" class="form-label mb-0">Từ ngày</label>
                            <input type="date" id="revenue_start" class="form-control" />
                        </div>
                        <div class="col-auto">
                            <label for="revenue_end" class="form-label mb-0">Đến ngày</label>
                            <input type="date" id="revenue_end" class="form-control" />
                        </div>
                        <div class="col-auto">
                            <button type="button" onclick="loadRevenueChart()" class="btn btn-success">
                                <i class="bx bx-line-chart"></i> Xem doanh thu
                            </button>
                        </div>
                    </form>

                    <div class="mb-3">
                        <h4 class="text-primary">Tổng doanh thu:

                        </h4>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <canvas id="revenueChart"></canvas>
                        </div>
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

<script>
    let revenueChart;
    let userChart;

    const numberWithCommas = (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    function loadRevenueChart() {
        const start = document.getElementById('revenue_start').value;
        const end = document.getElementById('revenue_end').value;

        fetch(`/admin/dashboard/revenue-chart-data?start_date=${start}&end_date=${end}`)
            .then(res => res.json())
            .then(data => {
                if (revenueChart) revenueChart.destroy();

                revenueChart = new Chart(document.getElementById('revenueChart'), {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Tổng doanh thu',
                            data: data.data,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw;
                                        return ' ' + numberWithCommas(value) + ' đ';
                                    }
                                }
                            },
                            legend: {
                                labels: {
                                    color: '#333',
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#555'
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                ticks: {
                                    color: '#555',
                                    callback: value => numberWithCommas(value) + ' đ'
                                },
                                grid: {
                                    borderDash: [5, 5],
                                    color: '#eee'
                                }
                            }
                        }
                    }
                });

                const total = data.data.reduce((sum, val) => sum + parseFloat(val), 0);
                document.querySelector('.text-primary').textContent = `Tổng doanh thu: ${numberWithCommas(total)} đ`;
            });
    }

    function loadUserChart() {
        const start = document.getElementById('user_start').value;
        const end = document.getElementById('user_end').value;

        fetch(`/admin/dashboard/user-chart-data?start_date=${start}&end_date=${end}`)
            .then(res => res.json())
            .then(data => {
                if (userChart) userChart.destroy();

                userChart = new Chart(document.getElementById('userChart'), {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                                label: 'Hoạt động',
                                data: data.active,
                                backgroundColor: '#10b981',
                                borderRadius: 6
                            },
                            {
                                label: 'Bị khóa',
                                data: data.banned,
                                backgroundColor: '#ef4444',
                                borderRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: context => `${context.dataset.label}: ${context.raw} tài khoản`
                                }
                            },
                            legend: {
                                labels: {
                                    color: '#333',
                                    font: {
                                        size: 14
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    color: '#444'
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                ticks: {
                                    color: '#444',
                                    stepSize: 1
                                },
                                grid: {
                                    borderDash: [5, 5],
                                    color: '#eee'
                                }
                            }
                        }
                    }
                });
            });
    }
</script>



@endpush
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

<div class="row mb-4 g-4">
    <!-- Bộ lọc doanh thu -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <form class="d-flex align-items-end justify-content-center gap-3 flex-wrap">
                    <div class="mr-3">
                        <label for="start" class="form-label mb-1">Từ ngày</label>
                        <input type="date" id="start" class="form-control form-control-sm" />
                    </div>
                    <div class="mr-3">
                        <label for="end" class="form-label mb-1">Đến ngày</label>
                        <input type="date" id="end" class="form-control form-control-sm" />
                    </div>
                    <div>
                        <button type="button" onclick="loadCharts()" class="btn btn-success btn-sm mt-4">
                            <i class="bx bx-line-chart me-1"></i> Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <a href="{{ route('admin.users.index') }}">
            <div class="widget-small primary coloured-icon"><i class='icon bx bxs-user-account fa-3x'></i>
                <div class="info">
                    <h4>Tổng khách hàng</h4>
                    <p><b>{{ $totalCustomers ?? 0 }} khách hàng</b></p>
                    <p class="info-tong">Tổng số khách hàng được quản lý.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('admin.products.index') }}">
            <div class="widget-small info coloured-icon"><i class='icon bx bxs-data fa-3x'></i>
                <div class="info">
                    <h4>Tổng sản phẩm</h4>
                    <p><b>{{ $totalProducts ?? 0 }} sản phẩm</b></p>
                    <p class="info-tong">Tổng số sản phẩm được quản lý.</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('admin.orders.index') }}">
            <div class="widget-small warning coloured-icon"><i class='icon bx bxs-shopping-bags fa-3x'></i>
                <div class="info">
                    <h4>Số đơn hàng cần xử lý</h4>
                    <p><b>{{ $totalOrders ?? 0 }} đơn hàng</b></p>
                    <p class="info-tong">Tổng số đơn hàng đang chờ xử lý</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <div class="widget-small danger coloured-icon"><i class='icon bx bxs-error-alt fa-3x'></i>
            <div class="info">
                <h4>Sắp hết hàng</h4>
                {{-- Biến $lowStockProducts đang bị tạm khóa trong Controller, hãy mở lại sau khi bạn có cột stock --}}
                <p><b>{{ $lowStockProducts ?? '0' }} sản phẩm</b></p>
                <p class="info-tong">Số sản phẩm cảnh báo hết cần nhập thêm.</p>
            </div>
        </div>
    </div>
    <!-- Biểu đồ -->
    <div class="col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Thống kê tăng trưởng người dùng</h5>
            </div>
            <div class="card-body" style="height: 400px;">
                <div class="mb-3">
                    <p id="totalUsers" class="fw-bold fs-5"></p>
                </div>
                <canvas id="userChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Thống kê doanh thu</h5>
            </div>
            <div class="card-body" style="height: 400px;">
                <h4 class="text-primary mb-3">Tổng doanh thu:</h4>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Thống kê số đơn hàng</h5>
            </div>
            <div class="card-body">
                <h4 class="text-danger mb-3">Tổng đơn hàng:</h4>
                <canvas id="orderPieChart" style="height:400px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Top 5 sản phẩm bán chạy</h5>
            </div>
            <div class="card-body table-responsive" style="height:400px;">
                <table id="topProductsTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Ảnh</th>
                            <th>Giá tiền</th>
                            <th>Số lượng bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Khách hàng mới -->
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Khách hàng mới</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Ngày sinh</th>
                            <th>SĐT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($newCustomers as $customer)
                        <tr>
                            <td>#{{ $customer->id }}</td>
                            <td>{{ $customer->fullname }}</td>
                            <td>{{ $customer->birthday ? $customer->birthday->format('d/m/Y') : 'Chưa có' }}</td>
                            <td>{{ $customer->phone ?? 'Chưa có' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Không có khách hàng mới</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
    let orderPieChart;

    const numberWithCommas = (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    function loadCharts() {
        const start = document.getElementById('start').value;
        const end = document.getElementById('end').value;

        fetch(`/admin/dashboard/chart-data?start_date=${start}&end_date=${end}`)
            .then(res => res.json())
            .then(data => {
                // --- Biểu đồ doanh thu ---
                if (revenueChart) revenueChart.destroy();
                revenueChart = new Chart(document.getElementById('revenueChart'), {
                    type: 'line',
                    data: {
                        labels: data.revenue.labels,
                        datasets: [{
                            label: 'Tổng doanh thu',
                            data: data.revenue.data,
                            borderColor: '#0051ffff',
                            backgroundColor: 'rgba(0, 170, 255, 0.3)',
                            tension: 0.4,
                            fill: 'start',
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

                const totalRevenue = data.revenue.data.reduce((sum, val) => sum + parseFloat(val), 0);
                document.querySelector('.text-primary').textContent =
                    `Tổng doanh thu: ${numberWithCommas(totalRevenue)} đ`;

                // --- Biểu đồ người dùng ---
                if (userChart) userChart.destroy();
                const totalActive = data.users.active.reduce((sum, val) => sum + val, 0);
                const totalBanned = data.users.banned.reduce((sum, val) => sum + val, 0);
                const totalUsers = totalActive + totalBanned;
                document.getElementById('totalUsers').innerHTML =
                    `Tổng tài khoản: <b>${totalUsers}</b><br>
                     Hoạt động: <span style="color:#10b981">${totalActive}</span>, 
                     Bị khóa: <span style="color:#ef4444">${totalBanned}</span>`;

                userChart = new Chart(document.getElementById('userChart'), {
                    type: 'line',
                    data: {
                        labels: data.users.labels,
                        datasets: [{
                                label: 'Hoạt động',
                                data: data.users.active,
                                borderColor: '#00ff5dff',
                                backgroundColor: 'rgba(153, 253, 163, 0.3)',
                                tension: 0.4,
                                fill: 'start',
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Bị khóa',
                                data: data.users.banned,
                                borderColor: '#ff0000ff',
                                backgroundColor: 'rgba(253, 153, 153, 0.3)',
                                tension: 0.4,
                                fill: 'start',
                                pointRadius: 4,
                                pointHoverRadius: 6
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

                // --- Biểu đồ đơn hàng (Pie chart) ---
                const orders = data.orders; // ✅ Lấy orders từ API
                const totalSuccess = orders.success.reduce((a, b) => a + b, 0);
                const totalCanceled = orders.canceled.reduce((a, b) => a + b, 0);
                const totalCompleted = orders.completed.reduce((a, b) => a + b, 0);
                const totalProcessing = orders.processing.reduce((a, b) => a + b, 0);

                const totalOrders = totalSuccess + totalCanceled + totalCompleted + totalProcessing;
                document.querySelector('.text-danger.mb-3').textContent =
                    `Tổng đơn hàng: ${totalOrders.toLocaleString()} đơn hàng`;

                if (orderPieChart) orderPieChart.destroy(); // ✅ Hủy chart cũ trước khi vẽ mới

                const ctx = document.getElementById('orderPieChart').getContext('2d');
                orderPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Đã giao hàng', 'Đã hủy', 'Hoàn hàng', 'Đang xử lý'],
                        datasets: [{
                            data: [totalSuccess, totalCanceled, totalCompleted, totalProcessing],
                            backgroundColor: [
                                'rgba(40, 167, 69, 0.85)', // Xanh lá
                                'rgba(220, 53, 69, 0.85)', // Đỏ
                                'rgba(7, 127, 255, 0.85)', // Vàng
                                'rgba(246, 197, 0, 1)' // Hồng
                            ],
                            borderColor: '#fff',
                            borderWidth: 2,
                            hoverOffset: 20, // Khi hover sẽ nổi ra
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: '#333',
                                    font: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    padding: 20
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleFont: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 14
                                },
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw;
                                        return `${context.label}: ${value} đơn`;
                                    }
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true
                        }
                    }

                });
                // Cập nhật bảng top sản phẩm
                const topProductsTbody = document.querySelector('#topProductsTable tbody');
                topProductsTbody.innerHTML = ''; // Xóa dữ liệu cũ nếu có

                data.top_products.forEach(product => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
        <td>#${product.code}</td>
        <td>${product.name}</td>
        <td><img src="${product.image}" style="max-width:50px;" /></td>
        <td>${numberWithCommas(product.price)} đ</td>
        <td>${product.total_sold}</td>
    `;
                    topProductsTbody.appendChild(tr);
                });

            });
    }
</script>

@endpush
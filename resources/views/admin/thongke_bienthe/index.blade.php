@extends('admin.layouts.index')

@section('title', 'Thống kê biến thể sản phẩm')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Thống kê số lượng biến thể theo sản phẩm, danh mục, size và màu</h3>
            <div class="tile-body">
                <form id="filter-form" class="row">
                    <div class="form-group col-md-4">
                        <label>Từ ngày</label>
                        <input type="date" name="from_date" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Đến ngày</label>
                        <input type="date" name="to_date" class="form-control">
                    </div>
                    <div class="form-group col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </form>

                <hr>

                <canvas id="variantChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('variantChart').getContext('2d');
    let chart;

    $('#variantChart').hide(); // Ẩn biểu đồ ban đầu

    function renderChart(labels, data) {
        if (chart) chart.destroy(); // Xóa biểu đồ cũ nếu có

        $('#variantChart').show(); // Hiện biểu đồ

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Số lượng biến thể',
                    data: data,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45,
                            minRotation: 30
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Số lượng: ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    }

    function fetchData() {
        const fromDate = $('input[name="from_date"]').val();
        const toDate = $('input[name="to_date"]').val();

        // if (!fromDate || !toDate) {
        //     alert('Vui lòng chọn khoảng thời gian!');
        //     return;
        // }
        if (!fromDate && !toDate) {
            alert('Vui lòng nhập ít nhất một ngày (Từ ngày hoặc Đến ngày)!');
            return;
        }

        const formData = $('#filter-form').serialize();

        $.get("{{ route('admin.thongke.bienthe.data') }}", formData, function(response) {
            if (response.length === 0) {
                alert('Không có dữ liệu trong khoảng thời gian này!');
                $('#variantChart').hide();
                return;
            }

            const labels = response.map(item => `${item.product_name} (${item.category_name})\nSize: ${item.size_name} - Màu: ${item.color_name}`);
            const data = response.map(item => item.total_variants);

            renderChart(labels, data);
        });
    }

    $(document).ready(function () {
        $('#filter-form').on('submit', function (e) {
            e.preventDefault();
            fetchData();
        });
    });
</script>
@endsection

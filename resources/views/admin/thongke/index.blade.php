@extends('admin.layouts.index')

@section('title', 'Thống kê sản phẩm theo danh mục')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-4">
                        <label><strong>Chọn tháng/năm:</strong></label>
                        <input type="month" id="filter-month" class="form-control">
                    </div>
                    <div class="col-sm-2 align-self-end">
                        <button id="loadData" class="btn btn-primary btn-sm">
                            Tải thống kê
                        </button>
                    </div>
                </div>

                <canvas id="thongkeChart" height="120" style="margin-top: 30px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery & Chart.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const dataUrl = "{{ route('admin.thongke.data') }}";

    $('#loadData').on('click', function () {
        const value = $('#filter-month').val();
        const month = value ? new Date(value).getMonth() + 1 : null;
        const year = value ? new Date(value).getFullYear() : null;

        fetch(`${dataUrl}?month=${month}&year=${year}`)
            .then(res => res.json())
            .then(data => {
                const labels = data.map(item => item.category_name);
                const totals = data.map(item => item.total);

                const ctx = document.getElementById('thongkeChart').getContext('2d');
                if (window.myChart) window.myChart.destroy();

                window.myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Số sản phẩm',
                            data: totals,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Thống kê sản phẩm theo danh mục'
                            }
                        }
                    }
                });
            })
            .catch(err => console.error("Lỗi khi tải dữ liệu:", err));
    });
</script>
@endsection

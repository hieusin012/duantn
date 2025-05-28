<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Siêu Đẹp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    :root {
      --primary: #4e73df;
      --dark: #1b1e23;
      --light: #f8f9fc;
      --sidebar-bg: #2e3b55;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--light);
    }

    .sidebar {
      width: 240px;
      min-height: 100vh;
      background: var(--sidebar-bg);
      position: fixed;
      color: white;
      transition: all 0.3s ease;
      box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
    }

    .sidebar h4 {
      padding: 20px;
      text-align: center;
      background: linear-gradient(45deg, #4e73df, #224abe);
      font-weight: bold;
      margin: 0;
    }

    .sidebar a {
      display: block;
      color: #ddd;
      padding: 15px 25px;
      text-decoration: none;
      transition: background 0.3s ease, color 0.2s;
    }

    .sidebar a:hover {
      background: #445879;
      color: #fff;
    }

    .main {
      margin-left: 240px;
      padding: 30px;
    }

    .navbar {
      background-color: white;
      border-bottom: 1px solid #dee2e6;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      transition: 0.3s;
    }

    .card:hover {
      transform: translateY(-4px);
    }

    .card .card-body h5 {
      font-size: 1rem;
      color: #555;
    }

    .card .card-body p {
      font-size: 1.6rem;
      font-weight: bold;
      color: #222;
    }

    .footer {
      background: #2e3b55;
      color: #ccc;
      padding: 20px;
      text-align: center;
      margin-top: 50px;
      border-top-left-radius: 20px;
    }

    .table th, .table td {
      vertical-align: middle;
    }

    .badge {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<!-- Sidebar -->

@include('admin.layouts.partials.sidebar')
<!-- Main content -->
<div class="main">
  <!-- Header -->
@include('admin.layouts.partials.nav')
  

  <!-- Dashboard Cards -->
@include('admin.layouts.partials.header')

  <!-- Table -->
  <div class="card mb-4">
    <div class="card-header bg-primary text-white">
      Biểu đồ doanh thu theo tháng
    </div>
    <div class="card-body">
      <canvas id="revenueChart" height="100"></canvas>
    </div>
  </div>
  
 

  <!-- Footer -->
 @include('admin.layouts.partials.footer')
</div>

</body>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
        datasets: [{
          label: 'Doanh thu (VND)',
          data: [12000000, 19000000, 30000000, 25000000, 22000000],
          backgroundColor: '#4e73df',
          borderRadius: 10,
          hoverBackgroundColor: '#2e59d9'
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false },
          tooltip: { callbacks: {
            label: function(context) {
              return context.dataset.label + ': ₫' + context.raw.toLocaleString();
            }
          }}
        },
        scales: {
          y: {
            ticks: {
              callback: function(value) {
                return '₫' + value.toLocaleString();
              }
            },
            beginAtZero: true
          }
        }
      }
    });
  </script>
  
</html>

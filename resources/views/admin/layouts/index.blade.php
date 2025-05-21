<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Modern</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #5a67d8;
      --secondary: #4c556a;
      --sidebar-bg: #1f2a44;
      --light-bg: #f4f7fe;
      --text-primary: #2d3748;
      --text-secondary: #718096;
      --success: #48bb78;
      --warning: #ed8936;
      --danger: #f56565;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background-color: var(--light-bg);
      color: var(--text-primary);
      overflow-x: hidden;
    }

    .sidebar {
      width: 260px;
      min-height: 100vh;
      background: var(--sidebar-bg);
      position: fixed;
      top: 0;
      left: 0;
      color: white;
      transition: transform 0.3s ease;
      z-index: 1000;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
    }

    .sidebar .brand {
      padding: 1.5rem;
      text-align: center;
      background: linear-gradient(135deg, var(--primary), #2b6cb0);
      font-size: 1.5rem;
      font-weight: 700;
      letter-spacing: 1px;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      padding: 1rem 1.5rem;
      color: #e2e8f0;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      transform: translateX(5px);
    }

    .sidebar a i {
      margin-right: 0.75rem;
      font-size: 1.2rem;
    }

    .main-content {
      margin-left: 260px;
      padding: 2rem;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    .navbar-custom {
      background: white;
      padding: 1rem 1.5rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      margin-bottom: 2rem;
    }

    .card {
      border: none;
      border-radius: 12px;
      overflow: hidden;
      background: white;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.15);
    }

    .card-header {
      background: var(--primary);
      color: white;
      padding: 1rem;
      font-weight: 600;
    }

    .card-body h5 {
      font-size: 0.9rem;
      color: var(--text-secondary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .card-body p {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }

    .table {
      background: white;
      border-radius: 8px;
      overflow: hidden;
    }

    .table th {
      background: #edf2f7;
      color: var(--text-primary);
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.85rem;
      padding: 1rem;
    }

    .table td {
      padding: 1rem;
      vertical-align: middle;
    }

    .btn-action {
      padding: 0.4rem 0.8rem;
      font-size: 0.85rem;
    }

    .footer {
      background: var(--sidebar-bg);
      color: #a0aec0;
      padding: 1.5rem;
      text-align: center;
      margin-top: 3rem;
      border-radius: 12px 12px 0 0;
      font-size: 0.9rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-260px);
      }

      .sidebar.active {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .navbar-custom .toggle-sidebar {
        display: block;
      }
    }

    .navbar-custom .toggle-sidebar {
      display: none;
      font-size: 1.5rem;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
@include('admin.layouts.partials.sidebar')
  <!-- Main Content -->
  <div class="main-content">
    <!-- Navbar -->
   @include('admin.layouts.partials.nav')

    <!-- Dashboard Cards -->
    <div class="row g-4 mb-5">
      <div class="col-md-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5>Tổng sản phẩm</h5>
            <p>120</p>
            <i class="fas fa-boxes text-primary" style="font-size: 2rem; position: absolute; right: 1rem; top: 1rem; opacity: 0.2;"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5>Đơn hàng</h5>
            <p>85</p>
            <i class="fas fa-shopping-cart text-warning" style="font-size: 2rem; position: absolute; right: 1rem; top: 1rem; opacity: 0.2;"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5>Người dùng</h5>
            <p>50</p>
            <i class="fas fa-users text-success" style="font-size: 2rem; position: absolute; right: 1rem; top: 1rem; opacity: 0.2;"></i>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <h5>Doanh thu</h5>
            <p>₫50,000,000</p>
            <i class="fas fa-money-bill-wave text-danger" style="font-size: 2rem; position: absolute; right: 1rem; top: 1rem; opacity: 0.2;"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- main -->
    {{-- <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <span>Danh sách sản phẩm</span>
        <a href="" class="btn btn-light btn-sm"><i class="fas fa-plus me-1"></i> Thêm sản phẩm</a>
      </div>
      <div class="card-body table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên sản phẩm</th>
              <th>Hình ảnh</th>
              <th>Giá</th>
              <th>Số lượng</th>
              <th>Màu</th>
              <th>Size</th>
              <th>Danh mục</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td colspan="9" class="text-center text-muted">Không có sản phẩm nào.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> --}}
    @yield('content')

    <!-- Footer -->
    @include('admin.layouts.partials.footer')
  </div>

  <!-- Bootstrap JS and Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle sidebar for mobile
    document.querySelector('.toggle-sidebar').addEventListener('click', () => {
      document.querySelector('.sidebar').classList.toggle('active');
    });
  </script>
</body>
</html>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản trị Shop')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f1f3f5;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding-top: 60px;
            z-index: 1000;
        }
        .sidebar a {
            color: #ddd;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            color: #fff;
        }
        .admin-header {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            left: 250px;
            right: 0;
            top: 0;
            z-index: 999;
        }
        .admin-content {
            margin-left: 250px;
            padding-top: 80px;
            padding-right: 20px;
            padding-left: 20px;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="text-white text-center fw-bold mb-3">SHOP ADMIN</div>
        <a href="{{ route('admin.index') }}" class="{{ request()->routeIs('admin.index') ? 'active' : '' }}">
            <i class="fa fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="#">
            <i class="fa fa-shirt me-2"></i> Sản phẩm
        </a>
        <a href="#">
            <i class="fa fa-cart-shopping me-2"></i> Đơn hàng
        </a>
        <a href="#">
            <i class="fa fa-users me-2"></i> Khách hàng
        </a>
        <a href="#">
            <i class="fa fa-chart-line me-2"></i> Thống kê
        </a>
        <a href="#">
            <i class="fa fa-sign-out-alt me-2"></i> Đăng xuất
        </a>
    </div>

    {{-- Header --}}
    <header class="admin-header">
        <h6 class="mb-0 fw-bold">@yield('page-title', 'Trang quản trị')</h6>
        <div class="d-flex align-items-center gap-2">
            <i class="fa fa-user-circle fs-4 text-secondary"></i>
            <span class="text-muted">Admin</span>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="admin-content">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

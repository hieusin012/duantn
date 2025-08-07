<aside id="sidebar" class="app-sidebar" style="width: 250px">
      <div class="app-sidebar__user text-center py-4">
            <img class="app-sidebar__user-avatar shadow" src="{{ asset('assets/admin/ckeditor/samples/img/logo.png') }}" width="100" style="border-radius: 50%;" alt="User Image">
            <p class="app-sidebar__user-name fw-bold mt-3 mb-1 text-white">Trang quản lí</p>
      </div>
      <hr>

      <ul class="app-menu">
            <!-- Nhóm: Tổng quan & Hỗ trợ -->
            <li class="app-menu__section">TỔNG QUAN</li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}" href="{{route('admin.dashboard.index')}}">
                        <i class="app-menu__icon bx bx-tachometer"></i><span class="app-menu__label">Bảng điều khiển</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('chat.index') ? 'active' : '' }}" href="{{ route('admin.chat') }}">
                        <i class="app-menu__icon fas fa-comment-dots"></i><span class="app-menu__label">Hỗ trợ khách hàng</span></a></li>
            <li><a class="app-menu__item {{ request()->is('phan-mem-ban-hang*') ? 'active' : '' }}" href="phan-mem-ban-hang.html">
                        <i class="app-menu__icon bx bx-cart-alt"></i><span class="app-menu__label">POS Bán Hàng</span></a></li>
            

            <!-- Nhóm: Quản lý nội dung -->
            <li class="app-menu__section">QUẢN LÝ NỘI DUNG</li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="app-menu__icon bx bx-group"></i><span class="app-menu__label">Người dùng</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
                        <i class="app-menu__icon fas fa-newspaper"></i><span class="app-menu__label">Bài viết</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}" href="{{ route('admin.blog-categories.index') }}">
                        <i class="app-menu__icon fas fa-folder-open"></i><span class="app-menu__label">Danh mục bài viết</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                        <i class="app-menu__icon fas fa-comments"></i><span class="app-menu__label">Bình luận</span></a></li>

            <!-- Nhóm: Quản lý sản phẩm -->
            <li class="app-menu__section">QUẢN LÝ SẢN PHẨM</li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="app-menu__icon bx bx-category"></i><span class="app-menu__label">Danh mục sản phẩm</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="app-menu__icon bx bx-purchase-tag-alt"></i><span class="app-menu__label">Sản phẩm</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.product-variants.*') ? 'active' : '' }}" href="{{ route('admin.product-variants.index') }}">
                        <i class="app-menu__icon bx bx-layer"></i><span class="app-menu__label">Sản phẩm biến thể</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.colors.*') ? 'active' : '' }}" href="{{ route('admin.colors.index') }}">
                        <i class="app-menu__icon bx bx-palette"></i><span class="app-menu__label">Màu sắc</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}" href="{{ route('admin.sizes.index') }}">
                        <i class="app-menu__icon bx bx-ruler"></i><span class="app-menu__label">Kích cỡ</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                        <i class="app-menu__icon fas fa-tag"></i><span class="app-menu__label">Thương hiệu</span></a></li>

            <!-- Nhóm: Đơn hàng & Kho -->
            <li class="app-menu__section">ĐƠN HÀNG & KHO</li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="app-menu__icon fas fa-shopping-cart"></i><span class="app-menu__label">Đơn hàng</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.return-requests.*') ? 'active' : '' }}" href="{{ route('admin.return-requests.index') }}">
                        <i class="app-menu__icon fas fa-undo"></i><span class="app-menu__label">Hoàn trả</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}" href="{{ route('admin.inventory.index') }}">
                        <i class="app-menu__icon bx bx-box"></i><span class="app-menu__label">Kho hàng</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.vouchers*') ? 'active' : '' }}" href="{{ route('admin.vouchers.index') }}">
                        <i class="app-menu__icon fas fa-ticket-alt"></i><span class="app-menu__label">Vouchers</span></a></li>

            <!-- Nhóm: Vận chuyển -->
            <li class="app-menu__section">VẬN CHUYỂN</li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.shiptypes*') ? 'active' : '' }}" href="{{ route('admin.shiptypes.index') }}">
                        <i class="app-menu__icon fa fa-shipping-fast"></i><span class="app-menu__label">Loại shipper</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.shipper.orders*') ? 'active' : '' }}" href="{{ route('admin.shipper.orders.index') }}">
                        <i class="app-menu__icon fa fa-shipping-fast"></i><span class="app-menu__label">Đơn hàng shipper</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.shipper.persons*') ? 'active' : '' }}" href="{{ route('admin.shipper.persons.index') }}">
                        <i class="app-menu__icon fa fa-shipping-fast"></i><span class="app-menu__label">Danh sách shipper</span></a></li>

            <!-- Nhóm: Thống kê & Báo cáo -->
            <li class="app-menu__section">BÁO CÁO</li>
            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.thongke.index') ? 'active' : '' }}"
                        href="{{ route('admin.thongke.index') }}">
                        <i class="app-menu__icon bx bx-bar-chart-alt"></i>
                        <span class="app-menu__label">Thống kê</span>
                  </a>
            </li>
            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.thongke.bienthe.*') ? 'active' : '' }}"
                        href="{{ route('admin.thongke.bienthe.index') }}">
                        <i class="app-menu__icon bx bx-bar-chart-alt"></i>
                        <span class="app-menu__label">Thống kê biến thể</span>
                  </a>
            </li>
            <li><a class="app-menu__item {{ request()->is('quan-ly-bao-cao*') ? 'active' : '' }}" href="{{route('admin.orders.report')}}">
                        <i class="app-menu__icon bx bx-pie-chart-alt-2"></i><span class="app-menu__label">Doanh thu</span></a></li>

            <!-- Nhóm: Cấu hình hệ thống -->
            <li class="app-menu__section">HỆ THỐNG</li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                        <i class="app-menu__icon fas fa-image"></i><span class="app-menu__label">Banner</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.suppliers*') ? 'active' : '' }}" href="{{ route('admin.suppliers.index') }}">
                        <i class="app-menu__icon fa fa-building"></i><span class="app-menu__label">Nhà cung cấp</span></a></li>
            <li><a class="app-menu__item {{ request()->routeIs('admin.imports*') ? 'active' : '' }}" href="{{ route('admin.imports.index') }}">
                        <i class="app-menu__icon fa fa-receipt"></i><span class="app-menu__label">Nhập hàng</span></a></li>
            <li><a class="app-menu__item {{ request()->is('cai-dat*') ? 'active' : '' }}" href="#">
                        <i class="app-menu__icon bx bx-cog"></i><span class="app-menu__label">Cài đặt</span></a></li>
      </ul>
</aside>

<style>
      .app-sidebar {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #40667b;
      }

      .app-sidebar__user {
            flex-shrink: 0;
      }

      .app-menu {
            overflow-y: auto;
            scrollbar-width: thin;
            /* Firefox */
            scrollbar-color: #888 transparent;
            /* Firefox */
      }

      /* Chrome, Edge */
      .app-menu::-webkit-scrollbar {
            width: 4px;
            /* nhỏ lại */
      }

      .app-menu::-webkit-scrollbar-thumb {
            background-color: #999;
            border-radius: 10px;
      }

      .app-menu::-webkit-scrollbar-track {
            background: transparent;
      }


      .app-menu__section {
            color: #fff !important;
            border-bottom: 1px solid white;
            padding-bottom: 10px;
            margin-top: 15px;
            margin-bottom: 10px;
      }

      .app-menu__item {
    color: #fff;
    background-color: transparent;
    transition: all 0.3s ease;
}

.app-menu__item i {
    color: inherit;
}

/* Hover */
.app-menu__item {
    color: #fff;
    background-color: transparent;
    transition: all 0.3s ease;
    border: none;
    border-radius: 8px;
    padding: 10px 15px;
    margin: 4px 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.app-menu__item i {
    color: inherit;
}

/* Hover */
.app-menu__item:hover {
    background-color: #4e7c92;
    color: #fff;
    border: none;
}

/* Active */
.app-menu__item.active {
    background-color: #ffda44;
    color: #000;
    font-weight: bold;
    border: none;
}
/* Active */
.app-menu__item.active {
    background-color: #ffda44;
    color: #000;
    font-weight: bold;
}

      /* Ẩn sidebar ban đầu (khi có class 'collapsed') */
      .app-sidebar.collapsed {
            transform: translateX(-100%);
            transition: transform 0.3s ease;
      }

      /* Sidebar bình thường */
      .app-sidebar {
            width: 250px;
            background-color: #2c4857ff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            transition: transform 0.3s ease;
            z-index: 999;
      }
</style>
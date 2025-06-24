<aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('assets/admin/ckeditor/samples/img/logo.png') }}" width="50px"
                  alt="User Image">
            <div>
                  <p class="app-sidebar__user-name"><b>ADMIN</b></p>
                  <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
            </div>
      </div>
      <hr>
      <ul class="app-menu">
            <li><a class="app-menu__item {{ request()->is('phan-mem-ban-hang*') ? 'active' : '' }}" href="phan-mem-ban-hang.html"><i class='app-menu__icon bx bx-cart-alt'></i>
                        <span class="app-menu__label">POS Bán Hàng</span></a></li>

            <li><a class="app-menu__item {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}" href="{{route('admin.dashboard.index')}}"><i class='app-menu__icon bx bx-tachometer'></i></i> <span
                              class="app-menu__label">Bảng điều khiển</span></a></li>
{{-- 
            <li><a class="app-menu__item" href="#"><i class='app-menu__icon bx bx-id-card'></i> <span
                              class="app-menu__label">Quản lý nhân viên</span></a></li> --}}

            <li><a class="app-menu__item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route(name: 'admin.users.index') }}"><i class='app-menu__icon bx bx-user-voice'></i><span
                              class="app-menu__label">Quản lý người dùng</span></a></li>

            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route(name: 'admin.categories.index') }}">
                        <i class='app-menu__icon bx bx-category'></i>
                        <span class="app-menu__label">Quản lý danh mục</span>
                  </a>
            </li>
            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}" href="{{ route(name: 'admin.blogs.index') }}">
                        <i class='app-menu__icon fas fa-newspaper'></i>
                        <span class="app-menu__label">Quản lý bài viết</span>
                  </a>
            </li>

            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route(name: 'admin.banners.index') }}">
                        <i class='app-menu__icon fas fa-image'></i>

                        <span class="app-menu__label">Quản lý banner</span>
                  </a>
            </li>

            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route(name: 'admin.brands.index') }}"><i class='app-menu__icon fas fa-tag'></i> <span
                              class="app-menu__label">Quản lý thương hiệu</span></a>
            </li>
            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.sizes.*') ? 'active' : '' }}" href="{{ route(name: 'admin.sizes.index') }}">
                        <i class='app-menu__icon bx bx-ruler'></i>
                        <span class="app-menu__label">Quản lý kích cỡ</span>
                  </a>
            </li>
            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.colors.*') ? 'active' : '' }}" href="{{ route(name: 'admin.colors.index') }}">
                        <i class="app-menu__icon bx bx-palette"></i>
                        <span class="app-menu__label">Quản lý màu sắc</span>
                  </a>
            </li>




            <li><a class="app-menu__item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{route('admin.products.index')}}"><i
                              class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Quản lý sản phẩm</span></a>
            </li>

            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.product-variants.*') ? 'active' : '' }}" href="{{ route('admin.product-variants.index') }}">
                        <i class='app-menu__icon bx bx-layer'></i>
                        <span class="app-menu__label">Quản lý sản phẩm thuộc tính</span>
                  </a>
            </li>
            <li>
                  <a class="app-menu__item {{ request()->routeIs('admin.thongke.*') ? 'active' : '' }}" href="{{ route('admin.thongke.index') }}">
                        <i class="app-menu__icon bx bx-bar-chart-alt"></i>
                        <span class="app-menu__label">Thống kê sản phẩm</span>
                  </a>
            </li>


            <li><a class="app-menu__item {{ request()->is('table-data-oder*') ? 'active' : '' }}" href="table-data-oder.html"><i class='app-menu__icon bx bx-task'></i><span
                              class="app-menu__label">Quản lý đơn hàng</span></a></li>
            <li><a class="app-menu__item {{ request()->is('table-data-banned*') ? 'active' : '' }}" href="table-data-banned.html"><i class='app-menu__icon bx bx-run'></i><span
                              class="app-menu__label">Quản lý nội bộ
                        </span></a></li>
            <li>
            <a class="app-menu__item {{ request()->routeIs('admin.comments.*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                  <i class='app-menu__icon fas fa-comments'></i>
                  <span class="app-menu__label">Quản lý bình luận</span>
            </a>
            </li>
            <li><a class="app-menu__item {{ request()->is('table-data-money*') ? 'active' : '' }}" href="table-data-money.html"><i class='app-menu__icon bx bx-dollar'></i><span
                              class="app-menu__label">Bảng kê lương</span></a></li>
            <li><a class="app-menu__item {{ request()->is('quan-ly-bao-cao*') ? 'active' : '' }}" href="quan-ly-bao-cao.html"><i
                              class='app-menu__icon bx bx-pie-chart-alt-2'></i><span class="app-menu__label">Báo cáo doanh thu</span></a>
            </li>
            <li><a class="app-menu__item {{ request()->is('page-calendar*') ? 'active' : '' }}" href="page-calendar.html"><i class='app-menu__icon bx bx-calendar-check'></i><span
                              class="app-menu__label">Lịch công tác </span></a></li>
            <li><a class="app-menu__item {{ request()->is('cai-dat*') ? 'active' : '' }}" href="#"><i class='app-menu__icon bx bx-cog'></i><span class="app-menu__label">Cài
                              đặt hệ thống</span></a></li>
      </ul>
</aside>
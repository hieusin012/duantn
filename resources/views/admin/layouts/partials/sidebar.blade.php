<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="/images/hay.jpg" width="50px"
        alt="User Image">
      <div>
        <p class="app-sidebar__user-name"><b>ADMIN</b></p>
        <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
      </div>
    </div>
    <hr>
    <ul class="app-menu">
      <li><a class="app-menu__item haha" href="phan-mem-ban-hang.html"><i class='app-menu__icon bx bx-cart-alt'></i>
          <span class="app-menu__label">POS Bán Hàng</span></a></li>
      <li><a class="app-menu__item active" href="{{route('admin.dashboard.index')}}"><i class='app-menu__icon bx bx-tachometer'></i><span
            class="app-menu__label">Bảng điều khiển</span></a></li>
      <li><a class="app-menu__item " href="{{route('admin.dashboard.index')}}"><i class='app-menu__icon bx bx-id-card'></i> <span
            class="app-menu__label">Quản lý nhân viên</span></a></li>
      <li><a class="app-menu__item" href="#"><i class='app-menu__icon bx bx-user-voice'></i><span
            class="app-menu__label">Quản lý khách hàng</span></a></li>

            <li>
                  <a class="app-menu__item" href="{{ route(name: 'admin.categories.index') }}">
                    <i class='app-menu__icon bx bx-category'></i>
                    <span class="app-menu__label">Quản lý danh mục</span>
                  </a>
            </li>
            <li>
                  <a class="app-menu__item" href="{{ route(name: 'admin.sizes.index') }}">
                        <i class='app-menu__icon bx bx-category'></i>
                        <span class="app-menu__label">Quản lý kích cỡ</span>
                  </a>
            </li>
                
                

      <li><a class="app-menu__item" href="{{route('admin.products.index')}}"><i
            class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Quản lý sản phẩm</span></a>
      </li>

      <li>
            <a class="app-menu__item" href="{{ route('admin.product-variants.index') }}">
              <i class='app-menu__icon bx bx-layer'></i>
              <span class="app-menu__label">Quản lý sản phẩm thuộc tính</span>
            </a>
          </li>
          

      <li><a class="app-menu__item" href="table-data-oder.html"><i class='app-menu__icon bx bx-task'></i><span
            class="app-menu__label">Quản lý đơn hàng</span></a></li>
      <li><a class="app-menu__item" href="table-data-banned.html"><i class='app-menu__icon bx bx-run'></i><span
            class="app-menu__label">Quản lý nội bộ
          </span></a></li>
      <li><a class="app-menu__item" href="table-data-money.html"><i class='app-menu__icon bx bx-dollar'></i><span
            class="app-menu__label">Bảng kê lương</span></a></li>
      <li><a class="app-menu__item" href="quan-ly-bao-cao.html"><i
            class='app-menu__icon bx bx-pie-chart-alt-2'></i><span class="app-menu__label">Báo cáo doanh thu</span></a>
      </li>
      <li><a class="app-menu__item" href="page-calendar.html"><i class='app-menu__icon bx bx-calendar-check'></i><span
            class="app-menu__label">Lịch công tác </span></a></li>
      <li><a class="app-menu__item" href="#"><i class='app-menu__icon bx bx-cog'></i><span class="app-menu__label">Cài
            đặt hệ thống</span></a></li>
    </ul>
  </aside>
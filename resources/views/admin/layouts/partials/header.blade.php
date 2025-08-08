<!-- HEADER -->
<header class="app-header d-flex justify-content-between align-items-center px-4 py-2 shadow-sm border-bottom" style="background-color: #2c4857ff;">
  <!-- Logo hoặc tiêu đề bên trái -->
  <div class="d-flex align-items-center text-white">
    <i class='bx bx-menu fs-4 me-3' id="sidebarToggle" style="cursor: pointer;"></i>
    <h5 class="mb-0 fw-bold">Trang Quản Trị</h5>
  </div>

  <!-- Nút logout bên phải -->
  <ul class="app-nav list-unstyled d-flex align-items-center mb-0">
    <li>
      <a href="{{ route('logout') }}" 
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
         class="btn btn-outline-light d-flex align-items-center" title="Đăng xuất">
        <i class='bx bx-log-out bx-rotate-180 fs-5'></i>
        <span class="ms-2 d-none d-md-inline">Đăng xuất</span>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</header>

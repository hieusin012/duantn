<!-- HEADER -->
<header class="app-header d-flex justify-content-between align-items-center px-4 shadow-sm">
  <!-- Nút toggle -->
  <button id="sidebarToggle" class="btn btn-outline-light">
    <i class="bx bx-menu"></i>
  </button>

  <!-- Các nút khác -->
  <ul class="app-nav">
    <li>
      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="app-nav__item" title="Logout">
        <i class='bx bx-log-out bx-rotate-180'></i>
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </li>
  </ul>
</header>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');

    toggleButton.addEventListener('click', function () {
      sidebar.classList.toggle('collapsed');
    });
  });
</script>

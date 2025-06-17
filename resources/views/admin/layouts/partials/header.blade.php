<header class="app-header">
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
      aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


      <!-- User Menu-->
      <li>
        <a href="{{ route('logout') }}" 
          onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
          class="app-nav__item" 
          title="Logout">
          <i class='bx bx-log-out bx-rotate-180'></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </header>
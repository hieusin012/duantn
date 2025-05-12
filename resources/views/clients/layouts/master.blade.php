<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shop Quần Áo')</title>
<!-- Bootstrap 5.3 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">




    <!-- {{-- Link CSS --}} -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">

    @stack('styles')
</head>


<body>
    {{-- HEADER --}}
    @include('clients.layouts.partials.header')

    {{-- NỘI DUNG CHÍNH --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('clients.layouts.partials.footer')


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <!-- {{-- Modal Đăng nhập / Đăng ký --}} -->
@include('clients.layouts.partials.login-register-modals')
</body>
</html>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Tìm kiếm
    const searchToggle = document.getElementById("searchToggle");
    const searchForm = document.getElementById("searchForm");
    searchToggle.addEventListener("click", function (e) {
        e.stopPropagation();
        searchForm.classList.toggle("d-none");
    });

    // Tài khoản
    const accountToggle = document.getElementById("accountToggle");
    const accountMenu = document.getElementById("accountMenu");
    accountToggle.addEventListener("click", function (e) {
        e.stopPropagation();
        accountMenu.classList.toggle("d-none");
    });

    // Đóng khi click ra ngoài
    document.addEventListener("click", function (e) {
        if (!e.target.closest('#searchArea')) {
            searchForm.classList.add("d-none");
        }
        if (!e.target.closest('#accountArea')) {
            accountMenu.classList.add("d-none");
        }
    });
});
</script>




<!--Header-->
<style>
    /* Giảm chiều cao của header */
.header {
    padding-top: 8px !important;
    padding-bottom: 8px !important;
}

/* Giới hạn chiều rộng và căn giữa nội dung header */
.header .container-fluid {
    max-width: 1280px;
    margin: 0 auto;
    padding-left: 16px !important;
    padding-right: 16px !important;
}

/* Giảm kích thước logo */
.header img {
    width: 160px !important;   /* hoặc 150px nếu muốn nhỏ hơn */
    height: auto !important;
}

/* Giảm khoảng cách giữa các phần tử */
.header nav a,
.header .btn {
    padding: 6px 10px;
    font-size: 15px;
}/* Hover cho các mục menu chính */
.header nav a {
    color: #000; /* màu mặc định */
    transition: color 0.3s, border-bottom 0.3s;
    border-bottom: 2px solid transparent;
    padding-bottom: 2px;
}

.header nav a:hover {
    color:rgb(20, 20, 20); /* màu xanh Bootstrap hoặc tùy chỉnh */
    border-bottom: 2px solid rgb(0, 0, 0);
    text-decoration: none;
}

</style>
<header class="header py-1 bg-light border-bottom">
    <div class="container-fluid d-flex justify-content-between align-items-center flex-wrap gap-3 px-4">

        {{-- Logo --}}
        <div class="d-flex align-items-center">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ url('custom-assets/logo/logo.png') }}" alt="Logo" width="200" height="82">
            </a>
        </div>

        {{-- Menu chính --}}
        <nav class="d-none d-lg-flex align-items-center gap-4 flex-wrap">
            <a href="{{ route('home') }}" class="text-dark text-decoration-none">Trang chủ</a>
            {{-- Danh mục động --}}
    <div class="dropdown">
        <a class="text-dark text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Danh mục
        </a>
        <ul class="dropdown-menu">
            @foreach ($headerCategories as $category)
                <li>
                    @if(!empty($category->slug))
                    <a href="{{ route('client.categories.show', ['slug' => $category->slug]) }}">
                        {{ $category->name }}
                    </a>
                @endif
                
                </li>
            @endforeach
        </ul>
    </div>
            <a href="{{route('contact')}}" class="text-dark text-decoration-none">Liên hệ</a>
            
        </nav>

        {{-- Tài khoản + Giỏ hàng + Tìm kiếm --}}
        <div class="d-flex align-items-center gap-3 ms-auto">

            {{-- Tài khoản --}}
            <div class="position-relative" id="accountArea">
                <button class="btn btn-outline-dark" id="accountToggle" type="button">
                    <i class="fas fa-user"></i>
                </button>

                <div id="accountMenu" class="position-absolute top-100 mt-2 bg-white p-2 rounded shadow d-none"
                    style="right: 0; z-index: 1050; min-width: 150px;">
                    <a href="#" class="d-block text-dark text-decoration-none py-1 px-2"
                       data-bs-toggle="modal" data-bs-target="#loginModal">
                        <i class="fa fa-sign-in-alt me-2"></i> Đăng nhập
                    </a>
                    <a href="#" class="d-block text-dark text-decoration-none py-1 px-2"
                       data-bs-toggle="modal" data-bs-target="#registerModal">
                        <i class="fa fa-user-plus me-2"></i> Đăng ký
                    </a>
                </div>
            </div>

            {{-- Giỏ hàng --}}
            <a href="#" class="btn btn-outline-dark position-relative">
                🛒
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ session('cart_count', 0) }}
                </span>
            </a>

            {{-- Tìm kiếm --}}
            <div class="position-relative" id="searchArea">
                <button class="btn btn-outline-dark" id="searchToggle" type="button">
                    <i class="fas fa-search"></i>
                </button>
                <form action="#" method="GET" id="searchForm"
                      class="position-absolute top-100 mt-2 bg-white p-2 rounded shadow d-none"
                      style="right: 0; z-index: 1050; min-width: 250px;">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Tìm kiếm sản phẩm...">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>

{{-- Slider dưới header --}}
@include('clients.layouts.partials.slider')

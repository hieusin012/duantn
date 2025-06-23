<header class="header d-flex align-items-center header-1 header-fixed">
    <div class="container">
        <div class="row">
            <div class="logo col-5 col-sm-3 col-md-3 col-lg-2 align-self-center">
                {{-- SỬA TỪ route('home') THÀNH route('client.home') --}}
                <a class="logoImg" href="{{ route('client.home') }}" title="SPORTBAY" rel="home">
                    <img src="{{ asset('assets/client/images/logo.png') }}" alt="SPORTBAY" class="logo-image" />
                </a>
            </div>
            <div class="col-1 col-sm-1 col-md-1 col-lg-8 align-self-center d-menu-col">
                <nav class="navigation" id="AccessibleNav">
                    <ul id="siteNav" class="site-nav medium center">
                        {{-- SỬA TỪ route('home') THÀNH route('client.home') --}}
                        <li class="lvl1 parent dropdown"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                        <li class="lvl1"><a href="{{ route('client.products.index') }}">Danh mục sản phẩm
                            <i class="icon anm anm-angle-down-l"></i></a>
                        </li>
                        <li class="lvl1 parent dropdown"><a href="#">HOT DEAL <i class="icon anm anm-angle-down-l"></i></a></li>
                        <li class="lvl1 parent dropdown"><a href="{{ route('client.blogs.index') }}">Blog</a></li>
                        {{-- SỬA TỪ route('clients.contact') THÀNH route('client.contact') --}}
                        <li class="lvl1 parent dropdown">
                            <a href="{{ route('client.contact') }}">Liên hệ</a>
                        </li>
                        <li class="lvl1 parent megamenu"><a href="#">Abous Us</a></li> {{-- Sửa route nếu có --}}
                    </ul>
                </nav>
            </div>
            <div class="col-7 col-sm-9 col-md-9 col-lg-2 align-self-center icons-col text-right">
                <div class="search-parent iconset">
                    <div class="site-search" title="Search">
                        <a href="#;" class="search-icon clr-none" data-bs-toggle="offcanvas" data-bs-target="#search-drawer"><i class="hdr-icon icon anm anm-search-l"></i></a>
                    </div>
                    <div class="search-drawer offcanvas offcanvas-top" tabindex="-1" id="search-drawer">
                        <div class="container">
                            <div class="search-header d-flex-center justify-content-between mb-3">
                                <h3 class="title m-0">Bạn Đang Tìm Gì Vậy?</h3>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="search-body">
                                {{-- SỬA TỪ route('clients.products.search') THÀNH route('client.products.search') --}}
                                <form action="{{ route('client.products.search') }}" method="GET" class="d-flex flex-wrap gap-2" id="search-form">

                                    <select name="category" class="form-select w-auto">
                                        <option value="">Danh mục</option>
                                        @foreach($headerCategories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <input type="text" name="search" class="form-control w-auto" placeholder="Tìm kiếm..." value="{{ request('search') }}">

                                    <select name="brand" class="form-select w-auto">
                                        <option value="">Thương hiệu</option>
                                        @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <input type="number" name="min_price" class="form-control w-auto" placeholder="Giá từ" value="{{ request('min_price') }}">
                                    <input type="number" name="max_price" class="form-control w-auto" placeholder="Giá đến" value="{{ request('max_price') }}">

                                    <button type="submit" class="btn btn-primary">Tìm</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="account-parent iconset">
                    <div class="account-link" title="Account"><i class="hdr-icon icon anm anm-user-al"></i></div>
                    <div id="accountBox">
                        <div class="customer-links">
                            <ul class="m-0">
                                @guest
                                <li><a href="{{ route('login') }}"><i class="icon anm anm-sign-in-al"></i>Sign In</a></li>
                                <li><a href="{{ route('register') }}"><i class="icon anm anm-user-al"></i>Register</a></li>
                                @endguest

                                @auth

                                {{-- Sửa route nếu muốn có trang profile tổng quan cho user --}}
                                <li><a href="{{ route('client.profile.show') }}"><i class="icon anm anm-user-cil"></i>{{ Auth::user()->fullname }}</a></li> 
                                {{-- Sửa route từ profile.show THÀNH client.profile.show --}}
                                <li><a href="{{ route('client.profile.show') }}"><i class="icon anm anm-user-al"></i>My Account</a></li>
                                {{-- Sửa route từ profile.edit THÀNH client.profile.edit --}}
                                <li><a href="{{ route('client.profile.edit') }}"><i class="icon anm anm-edit"></i>Edit Profile</a></li>
                                <li><a href="#"><i class="icon anm anm-heart-l"></i>Wishlist</a></li> {{-- Sửa route nếu có --}}
                                <li><a href="#"><i class="icon anm anm-random-r"></i>Compare</a></li> {{-- Sửa route nếu có --}}

                                <li><a href="#"><i class="icon anm anm-user-cil"></i>{{ Auth::user()->fullname }}</a></li>
                                <li><a href="{{ route('profile.show') }}"><i class="icon anm anm-user-al"></i>My Account</a></li>
                                <li><a href="{{ route('profile.edit') }}"><i class="icon anm anm-edit"></i>Edit Profile</a></li>
                                <li><a href="{{ route('wishlist.index') }}"><i class="icon anm anm-heart-l"></i>Wishlist</a></li>
                                <li><a href="#"><i class="icon anm anm-random-r"></i>Compare</a></li>

                                <li>
                                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="icon anm anm-sign-out-al"></i>Sign out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="wishlist-link iconset" title="Wishlist"><a href="wishlist-style1.html"><i class="hdr-icon icon anm anm-heart-l"></i><span class="wishlist-count">0</span></a></div>

                <!--End Account 2-->
                <!-- Wishlist -->
                <div class="wishlist-link iconset" title="Wishlist">
                    <a href="{{ route('wishlist.index') }}">
                        <i class="hdr-icon icon anm anm-heart-l"></i>
                        <span class="wishlist-count">{{ auth()->check() ? auth()->user()->wishlists()->count() : 0 }}</span>
                    </a>
                </div>

                <!-- End Wishlist -->
                <!--Minicart-->

                <div class="header-cart iconset" title="Cart">
                    {{-- Sửa route từ client.cart THÀNH client.cart --}}
                    <a href="{{ route('client.cart') }}" class="header-cart btn-minicart clr-none">
                        <i class="hdr-icon icon anm anm-cart-l"></i><span class="cart-count">{{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
                    </a>
                </div>
                <button type="button" class="iconset pe-0 menu-icon js-mobile-nav-toggle mobile-nav--open d-lg-none" title="Menu"><i class="hdr-icon icon anm anm-times-l"></i><i class="hdr-icon icon anm anm-bars-r"></i></button>
                </div>
            </div>
    </div>
</header>
{{-- MOBILE MENU --}}
{{-- Phần mobile menu thường được tái sử dụng code từ desktop menu. Bạn cần đảm bảo các route cũng được sửa đổi ở đây. --}}
<div class="mobile-nav-wrapper" role="navigation">
    <div class="closemobileMenu">Close Menu <i class="icon anm anm-times-l"></i></div>
    <ul id="MobileNav" class="mobile-nav">
        {{-- SỬA TỪ route('home') THÀNH route('client.home') --}}
        <li class="lvl1 parent dropdown"><a href="{{ route('client.home') }}">Home <i class="icon anm anm-angle-down-l"></i></a>
            <ul class="lvl-2">
                <li><a href="{{ route('client.home') }}" class="site-nav">Home 01 - Fashion</a></li>
                {{-- ... các link home mobile khác ... --}}
            </ul>
        </li>
        <li class="lvl1 parent megamenu"><a href="#">Shop <i class="icon anm anm-angle-down-l"></i></a>
            <ul class="lvl-2">
                <li><a href="#;" class="site-nav">Collection Page <i class="icon anm anm-angle-down-l"></i></a>
                    <ul class="lvl-3">
                        <li><a href="#" class="site-nav">Collection style1</a></li>
                        {{-- ... các link collection mobile khác ... --}}
                    </ul>
                </li>
                <li><a href="#;" class="site-nav">Shop Page <i class="icon anm anm-angle-down-l"></i></a>
                    <ul class="lvl-3">
                        <li><a href="{{ route('client.products.index') }}" class="site-nav">Shop Grid View</a></li>
                        {{-- ... các link shop mobile khác ... --}}
                    </ul>
                </li>
                <li><a href="#;" class="site-nav">Shop Other Page <i class="icon anm anm-angle-down-l"></i></a>
                    <ul class="lvl-3">
                        <li><a href="#" class="site-nav">Wishlist Style1</a></li>
                        {{-- ... các link shop other mobile khác ... --}}
                    </ul>
                </li>
            </ul>
        </li>
        <li class="lvl1 parent megamenu"><a href="#">Product <i class="icon anm anm-angle-down-l"></i></a>
            <ul class="lvl-2">
                <li><a href="#" class="site-nav">Product Page <i class="icon anm anm-angle-down-l"></i></a>
                    <ul class="lvl-3">
                        <li><a href="#" class="site-nav">Product Layout1</a></li>
                        {{-- ... các link product page mobile ... --}}
                    </ul>
                </li>
                <li><a href="#" class="site-nav">Product Page Types <i class="icon anm anm-angle-down-l"></i></a>
                    <ul class="lvl-3">
                        <li><a href="#" class="site-nav">Standard Product</a></li>
                        {{-- ... các link product page types mobile ... --}}
                    </ul>
                </li>
            </ul>
        </li>
        <li class="lvl1 parent dropdown"><a href="#;">Pages <i class="icon anm anm-angle-down-l"></i></a>
            <ul class="lvl-2">
                {{-- SỬA TỪ route('clients.contact') THÀNH route('client.contact') --}}
                <li><a href="{{ route('client.contact') }}" class="site-nav">Contact Us</a></li>
                {{-- ... các link pages mobile khác ... --}}
            </ul>
        </li>
        <li class="lvl1 parent dropdown"><a href="{{ route('client.blogs.index') }}">Blog <i class="icon anm anm-angle-down-l"></i></a>
            <ul class="lvl-2">
                <li><a href="{{ route('client.blogs.index') }}" class="site-nav">Grid View</a></li>
                {{-- ... các link blog mobile khác ... --}}
            </ul>
        </li>

        <li class="mobile-menu-bottom">
            <div class="mobile-links"> 
                <ul class="list-inline d-inline-flex flex-column w-100">
                    <li><a href="{{ route('login') }}" class="d-flex align-items-center"><i class="icon anm anm-sign-in-al"></i>Sign In</a></li>
                    <li><a href="{{ route('register') }}" class="d-flex align-items-center"><i class="icon anm anm-user-al"></i>Register</a></li>
                    {{-- SỬA TỪ route('profile.show') THÀNH route('client.profile.show') --}}
                    <li><a href="{{ route('client.profile.show') }}" class="d-flex align-items-center"><i class="icon anm anm-user-cil"></i>My Account</a></li>
                    <li class="title h5">Need Help?</li>
                    <li><a href="tel:401234567890" class="d-flex align-items-center"><i class="icon anm anm-phone-l"></i> (+40) 123 456 7890</a></li>
                    <li><a href="mailto:info@example.com" class="d-flex align-items-center"><i class="icon anm anm-envelope-l"></i> info@example.com</a></li>
                </ul>
            </div>
            <div class="mobile-follow mt-2">  
                <h5 class="title">Follow Us</h5>
                <ul class="list-inline social-icons d-inline-flex mt-1">
                    <li><a href="#" title="Facebook"><i class="icon anm anm-facebook-f"></i></a></li>
                    <li><a href="#" title="Twitter"><i class="icon anm anm-twitter"></i></a></li>
                    <li><a href="#" title="Pinterest"><i class="icon anm anm-pinterest-p"></i></a></li>
                    <li><a href="#" title="Linkedin"><i class="icon anm anm-linkedin-in"></i></a></li>
                    <li><a href="#" title="Instagram"><i class="icon anm anm-instagram"></i></a></li>
                    <li><a href="#" title="Youtube"><i class="icon anm anm-youtube"></i></a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>
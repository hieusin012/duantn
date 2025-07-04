<header class="header d-flex align-items-center header-1 header-fixed">
    <div class="container">
        <div class="row">
            <div class="logo col-5 col-sm-3 col-md-3 col-lg-2 align-self-center">

                <a class="logoImg" href="{{ route('client.home') }}" title="SPORTBAY" rel="home">
                    <img src="{{ asset('assets/client/images/logo.png') }}" alt="SPORTBAY" class="logo-image" />
                </a>
            </div>
            <div class="col-1 col-sm-1 col-md-1 col-lg-8 align-self-center d-menu-col">
                <nav class="navigation" id="AccessibleNav">
                    <ul id="siteNav" class="site-nav medium center">
                        <li class="lvl1 parent dropdown"><a href="{{ route('client.home') }}">Trang chủ</a></li>
                        <li class="lvl1 parent dropdown"><a href="{{ route('client.products.index') }}">Sản phẩm
                                <i class="icon anm anm-angle-down-l"></i></a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @foreach ($header_categories as $cat)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('products.byCategory', $cat->id) }}">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="lvl1 parent dropdown"><a href="#">HOT DEAL <i class="icon anm anm-angle-down-l"></i></a></li>
                        <li class="lvl1 parent dropdown"><a href="{{ route('client.blog') }}">Blog</a></li>
                        <li class="lvl1 parent dropdown">
                            <a href="{{ route('client.contact') }}">Liên hệ</a>
                        </li>
                        <li class="lvl1 parent megamenu"><a href="#">Abous Us</a></li>
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
                {{-- <div class="account-parent iconset">
                    <div class="account-link" title="Account"><i class="hdr-icon icon anm anm-user-al"></i></div>
                    <div id="accountBox">
                        <div class="customer-links">
                            <ul class="m-0">
                                <li><a href="login.html"><i class="icon anm anm-sign-in-al"></i>Sign In</a></li>
                                <li><a href="register.html"><i class="icon anm anm-user-al"></i>Register</a></li>
                                <li><a href="my-account.html"><i class="icon anm anm-user-cil"></i>My Account</a></li>
                                <li><a href="wishlist-style1.html"><i class="icon anm anm-heart-l"></i>Wishlist</a></li>
                                <li><a href="compare-style1.html"><i class="icon anm anm-random-r"></i>Compare</a></li>
                                <li><a href="login.html"><i class="icon anm anm-sign-out-al"></i>Sign out</a></li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
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
                                <li><a href="#"><i class="icon anm anm-user-cil"></i>{{ Auth::user()->fullname }}</a></li>
                                <li><a href="{{ route('profile.show') }}"><i class="icon anm anm-user-al"></i>My Account</a></li>
                                <li><a href="{{ route('profile.edit') }}"><i class="icon anm anm-edit"></i>Edit Profile</a></li>
                                <li><a href="{{ route('wishlist.index') }}"><i class="icon anm anm-heart-l"></i>Wishlist</a></li>
                                <li><a href="#"><i class="icon anm anm-random-r"></i>Compare</a></li>
                                <li><a href="{{ route('order.history') }}"><i class="hdr-icon icon anm anm-bag-l"></i>History</a></li>
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
                <div class="iconset" title="Tra cứu đơn hàng">
                    <a href="{{ route('order.lookup.form') }}">
                        <i class="hdr-icon icon anm anm-bag-l"></i>
                    </a>
                </div>
                <div class="wishlist-link iconset" title="Wishlist">
                    <a href="{{ route('wishlist.index') }}">
                        <i class="hdr-icon icon anm anm-heart-l"></i>
                        <span class="wishlist-count">{{ auth()->check() ? auth()->user()->wishlists()->count() : 0 }}</span>
                    </a>
                </div>

                <div class="header-cart iconset" title="Cart">
                    <a href="{{ route('client.cart') }}" class="header-cart btn-minicart clr-none">
                        <i class="hdr-icon icon anm anm-cart-l"></i>
                        <span class="cart-count">
                            {{ Auth::check() ? \App\Models\Cart::where('user_id', Auth::id())->where('status', 0)->first()?->items()->count() ?? 0 : 0 }}
                        </span>

                    </a>
                </div>
                <button type="button" class="iconset pe-0 menu-icon js-mobile-nav-toggle mobile-nav--open d-lg-none" title="Menu"><i class="hdr-icon icon anm anm-times-l"></i><i class="hdr-icon icon anm anm-bars-r"></i></button>
            </div>
        </div>
    </div>
</header>
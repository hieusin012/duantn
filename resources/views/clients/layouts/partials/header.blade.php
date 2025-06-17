        <!--Header-->
        <header class="header d-flex align-items-center header-1 header-fixed">
            <div class="container">
                <div class="row">
                    <!--Logo-->
                    <div class="logo col-5 col-sm-3 col-md-3 col-lg-2 align-self-center">
                        <a class="logoImg" href="{{ url('/') }}">
                            <img src="{{ asset('assets/client/images/logo.png') }}" alt="SPORTBAY" class="logo-image" />
                        </a>
                    </div>
                    <!--End Logo-->
                    <!--Menu-->
                    <div class="col-1 col-sm-1 col-md-1 col-lg-8 align-self-center d-menu-col">
                        <nav class="navigation" id="AccessibleNav">
                            <ul id="siteNav" class="site-nav medium center">
                                <li class="lvl1 parent dropdown"><a href="{{ route('home') }}">Home <i class="icon anm anm-angle-down-l"></i></a></li>
                                </li>
                                <li class="lvl1 parent megamenu"><a href="#">Shop <i class="icon anm anm-angle-down-l"></i></a>
                                </li>
                                <li class="lvl1"><a href="">Product<i class="icon anm anm-angle-right-l"></i></a></li>

                                <li class="lvl1 parent dropdown"><a href="#">Pages <i class="icon anm anm-angle-down-l"></i></a>
                                </li>
                                <li class="lvl1 parent dropdown">
                                    <a href="{{ route('blog.index') }}">Blog</a>
                                </li>
                                <li class="lvl1 parent dropdown">
                                    <a href="{{ route('clients.contact') }}">Liên hệ</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <!--Right Icon-->
                    <div class="col-7 col-sm-9 col-md-9 col-lg-2 align-self-center icons-col text-right">
                        <!--Search-->
                        <div class="search-parent iconset">
                            <div class="site-search" title="Search">
                                <a href="#;" class="search-icon clr-none" data-bs-toggle="offcanvas" data-bs-target="#search-drawer"><i class="hdr-icon icon anm anm-search-l"></i></a>
                            </div>
                            <div class="search-drawer offcanvas offcanvas-top" tabindex="-1" id="search-drawer">
                                <div class="container">
                                    <div class="search-header d-flex-center justify-content-between mb-3">
                                        <h3 class="title m-0">What are you looking for?</h3>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="search-body">
                                        <form class="form minisearch" id="header-search" action="#" method="get">
                                            <!--Search Field-->
                                            <div class="d-flex searchField">
                                                <div class="search-category">
                                                    <select class="rgsearch-category rounded-end-0">
                                                        <option value="0">All Categories</option>
                                                        <option value="1">- All</option>
                                                        <option value="2">- Fashion</option>
                                                        <option value="3">- Shoes</option>
                                                        <option value="4">- Electronic</option>
                                                        <option value="5">- Jewelry</option>
                                                        <option value="6">- Vegetables</option>
                                                        <option value="7">- Furniture</option>
                                                        <option value="8">- Accessories</option>
                                                    </select>
                                                </div>
                                                <div class="input-box d-flex fl-1">
                                                    <input type="text" class="input-text border-start-0 border-end-0" placeholder="Search for products..." value="" />
                                                    <button type="submit" class="action search d-flex-justify-center btn rounded-start-0"><i class="icon anm anm-search-l"></i></button>
                                                </div>
                                            </div>
                                            <!--End Search Field-->
                                            <!--Search popular-->
                                            <div class="popular-searches d-flex-justify-center mt-3">
                                                <span class="title fw-600">Trending Now:</span>
                                                <div class="d-flex-wrap searches-items">
                                                    <a class="text-link ms-2" href="#">T-Shirt,</a>
                                                    <a class="text-link ms-2" href="#">Shoes,</a>
                                                    <a class="text-link ms-2" href="#">Bags</a>
                                                </div>
                                            </div>
                                            <!--End Search popular-->
                                            <!--Search products-->
                                            <div class="search-products">
                                                <ul class="items g-2 g-md-3 row row-cols-lg-4 row-cols-md-3 row-cols-sm-2">
                                                    <li class="item empty w-100 text-center text-muted d-none">You don't have any items in your search.</li>
                                                    <li class="item">
                                                        <div class="mini-list-item d-flex align-items-center w-100 clearfix">
                                                            <div class="mini-image text-center"><a class="item-link" href="product-layout1.html"><img class="blur-up lazyload" data-src="assets/images/products/product1-120x170.jpg" src="assets/images/products/product1-120x170.jpg" alt="image" title="product" width="120" height="170" /></a></div>
                                                            <div class="ms-3 details text-left">
                                                                <div class="product-name"><a class="item-title" href="product-layout1.html">Oxford Cuban Shirt</a></div>
                                                                <div class="product-price"><span class="old-price">$114.00</span><span class="price">$99.00</span></div>
                                                                <div class="product-review d-flex align-items-center justify-content-start">
                                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                                    <span class="caption hidden ms-2">3 reviews</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="item">
                                                        <div class="mini-list-item d-flex align-items-center w-100 clearfix">
                                                            <div class="mini-image text-center"><a class="item-link" href="product-layout1.html"><img class="blur-up lazyload" data-src="assets/images/products/product2-120x170.jpg" src="assets/images/products/product2-120x170.jpg" alt="image" title="product" width="120" height="170" /></a></div>
                                                            <div class="ms-3 details text-left">
                                                                <div class="product-name"><a class="item-title" href="product-layout1.html">Cuff Beanie Cap</a></div>
                                                                <div class="product-price"><span class="price">$128.00</span></div>
                                                                <div class="product-review d-flex align-items-center justify-content-start">
                                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                                    <span class="caption hidden ms-2">9 reviews</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="item">
                                                        <div class="mini-list-item d-flex align-items-center w-100 clearfix">
                                                            <div class="mini-image text-center"><a class="item-link" href="product-layout1.html"><img class="blur-up lazyload" data-src="assets/images/products/product3-120x170.jpg" src="assets/images/products/product3-120x170.jpg" alt="image" title="product" width="120" height="170" /></a></div>
                                                            <div class="ms-3 details text-left">
                                                                <div class="product-name"><a class="item-title" href="product-layout1.html">Flannel Collar Shirt</a></div>
                                                                <div class="product-price"><span class="price">$99.00</span></div>
                                                                <div class="product-review d-flex align-items-center justify-content-start">
                                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                                                    <span class="caption hidden ms-2">30 reviews</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!--End Search products-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--End Search-->
                        <!--Account-->
                        <div class="account-parent iconset">
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
                        </div>
                        <!--End Account-->
                        <!--Wishlist-->
                        <div class="wishlist-link iconset" title="Wishlist"><a href="wishlist-style1.html"><i class="hdr-icon icon anm anm-heart-l"></i><span class="wishlist-count">0</span></a></div>
                        <!--End Wishlist-->
                        <!--Minicart-->
                        <div class="header-cart iconset" title="Cart">
                            <a href="#;" class="header-cart btn-minicart clr-none" data-bs-toggle="offcanvas" data-bs-target="#minicart-drawer"><i class="hdr-icon icon anm anm-cart-l"></i><span class="cart-count">2</span></a>
                        </div>
                        <!--End Minicart-->
                        <!--Mobile Toggle-->
                        <button type="button" class="iconset pe-0 menu-icon js-mobile-nav-toggle mobile-nav--open d-lg-none" title="Menu"><i class="hdr-icon icon anm anm-times-l"></i><i class="hdr-icon icon anm anm-bars-r"></i></button>
                        <!--End Mobile Toggle-->
                    </div>
                    <!--End Right Icon-->
                </div>
            </div>
        </header>
        <!--End Header-->
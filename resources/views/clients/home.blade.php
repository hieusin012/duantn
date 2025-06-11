<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hema - Laravel Blade</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/client/images/favicon.png') }}" />

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/plugins.css') }}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/style-min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/responsive.css') }}">
    
</head>
<!-- Load thư viện JS -->
<script src="{{ asset('assets/client/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/client/js/vendor/jquery-migrate-1.4.1.min.js') }}"></script>
<script src="{{ asset('assets/client/js/vendor/slick.min.js') }}"></script>
<script src="{{ asset('assets/client/js/plugins.js') }}"></script>
<script src="{{ asset('assets/client/js/main.js') }}"></script>

<!-- Khởi tạo slick -->
<script>
    $(document).ready(function () {
        $('.home-slideshow').slick({
            dots: true,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 3000,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });
</script>

<body class="template-index index-demo1">
        <!--Page Wrapper-->
        <div class="page-wrapper">
            <!--Marquee Text-->
            <div class="topbar-slider clearfix">
                <div class="container-fluid">
                    <div class="marquee-text">
                        <div class="top-info-bar d-flex">
                            <div class="flex-item center">
                                <a href="#">
                                    <span> <i class="anm anm-worldwide"></i> BUY ONLINE PICK UP IN STORE</span>
                                    <span> <i class="anm anm-truck-l"></i> FREE WORLDWIDE SHIPPING ON ALL ORDERS ABOVE $100</span>
                                    <span> <i class="anm anm-redo-ar"></i> EXTENDED RETURN UNTIL 30 DAYS</span>
                                </a>
                            </div>
                            <div class="flex-item center">
                                <a href="#">
                                    <span> <i class="anm anm-worldwide"></i> BUY ONLINE PICK UP IN STORE</span>
                                    <span> <i class="anm anm-truck-l"></i> FREE WORLDWIDE SHIPPING ON ALL ORDERS ABOVE $100</span>
                                    <span> <i class="anm anm-redo-ar"></i> EXTENDED RETURN UNTIL 30 DAYS</span>
                                </a>
                            </div>
                            <div class="flex-item center">
                                <a href="#">
                                    <span> <i class="anm anm-worldwide"></i> BUY ONLINE PICK UP IN STORE</span>
                                    <span> <i class="anm anm-truck-l"></i> FREE WORLDWIDE SHIPPING ON ALL ORDERS ABOVE $100</span>
                                    <span> <i class="anm anm-redo-ar"></i> EXTENDED RETURN UNTIL 30 DAYS</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Marquee Text-->

            <!--Top Header-->
            <!--End Top Header-->

            <!--Header-->
            <header class="header d-flex align-items-center header-1 header-fixed">
                <div class="container">        
                    <div class="row">
                        <!--Logo-->
                        <div class="logo col-5 col-sm-3 col-md-3 col-lg-2 align-self-center">
                          <a class="logoImg" href="{{ url('/') }}">
    <img src="{{ asset('assets/client/images/logo.jpg') }}" alt="Hema Multipurpose Html Template" title="Hema Multipurpose Html Template" width="129" weight="60" />
</a>

                        </div>
                        <!--End Logo-->
                        <!--Menu-->
                        <div class="col-1 col-sm-1 col-md-1 col-lg-8 align-self-center d-menu-col">
                            <nav class="navigation" id="AccessibleNav">
                                <ul id="siteNav" class="site-nav medium center">
                                    <li class="lvl1 parent dropdown"><a href="#">Home <i class="icon anm anm-angle-down-l"></i></a>
                                    </li>
                                    <li class="lvl1 parent megamenu"><a href="#">Shop <i class="icon anm anm-angle-down-l"></i></a>
                                    </li>
                                    <li class="lvl1 parent megamenu"><a href="#">Product <i class="icon anm anm-angle-down-l"></i></a>
                                    </li>
                                    <li class="lvl1 parent dropdown"><a href="#">Pages <i class="icon anm anm-angle-down-l"></i></a>
                                    </li>
                                    <li class="lvl1 parent dropdown"><a href="#">Blog <i class="icon anm anm-angle-down-l"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        <!--End Right Icon-->
                    </div>
                </div>
            </header>
            <!--End Header-->

            <!-- Body Container -->
            <div id="page-content" class="mb-0">
                <!--Home Slideshow-->
                <section class="slideshow slideshow-wrapper">
    <div class="home-slideshow slick-arrow-dots">

        <div class="slide">
            <div class="slideshow-wrap">
                <picture>
    <source media="(max-width:767px)" srcset="{{ asset('assets/client/images/slideshow/banner1-mbl.jpg') }}" width="1150" height="800">
    <img class="blur-up lazyload" src="{{ asset('assets/client/images/slideshow/banner1.jpg') }}" alt="slideshow" title="" width="1920" height="795" />
</picture> 
                <div class="container">
                    <div class="slideshow-content slideshow-overlay middle-left">
                        <div class="slideshow-content-in">
                            <div class="wrap-caption animation style1">
                                <p class="ss-small-title">Thiết kế năng động</p>
                                <h2 class="ss-mega-title">Truyền cảm hứng vận động  <br>đó là một nghệ thuật</h2>
                                <p class="ss-sub-title xs-hide">Tối ưu hiệu suất và thoải mái trong từng chuyển động</p>
                                <div class="ss-btnWrap">
                                    <a class="btn btn-primary" href="shop-grid-view.html">Mua sắm đồ thể thao nữ</a>
                                    <a class="btn btn-secondary" href="shop-grid-view.html">Mua sắm đồ thể thao nam</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slide">
            <div class="slideshow-wrap">
                <picture>
    <source media="(max-width:767px)" srcset="{{ asset('assets/client/images/slideshow/banner2-mbl.jpg') }}" width="1150" height="800">
    <img class="blur-up lazyload" src="{{ asset('assets/client/images/slideshow/banner2.jpg') }}" alt="slideshow" title="" width="1920" height="795" />
</picture>

                <div class="container">
                    <div class="slideshow-content slideshow-overlay middle-right">
                        <div class="slideshow-content-in">
                            <div class="wrap-caption animation style1">
                                <h2 class="ss-mega-title">Lan tỏa <br>Năng lượng thể thao cùng SportBay</h2>
                                <p class="ss-sub-title xs-hide">Trang phục thể thao không thể thiếu trong năm dành cho phái nữ</p>
                                <div class="ss-btnWrap d-flex-justify-start">
                                    <a class="btn btn-primary" href="shop-grid-view.html">Khám phá ngay!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="slide">
            <div class="slideshow-wrap">
                <picture>
    <source media="(max-width:767px)" srcset="{{ asset('assets/client/images/slideshow/banner3-mbl.jpg') }}" width="1150" height="800">
    <img class="blur-up lazyload" src="{{ asset('assets/client/images/slideshow/banner3.jpg') }}" alt="slideshow" title="" width="1920" height="795" />
</picture>

                <div class="container">
                    <div class="slideshow-content slideshow-overlay middle-right">
                        <div class="slideshow-content-in">
                            xx
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
</div>
</div>
</div>
</div>

</body>

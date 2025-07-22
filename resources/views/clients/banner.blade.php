{{-- <div id="page-content" class="mb-0">
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
                                    <h2 class="ss-mega-title">Truyền cảm hứng vận động <br>đó là một nghệ thuật</h2>
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
                        <img class="blur-up lazyload" src="{{ asset('assets/client/images/slideshow/banner4.jpg') }}" alt="slideshow" title="" width="1920" height="795" />
                    </picture>

                    <div class="container">
                        <div class="slideshow-content slideshow-overlay middle-right">
                            <div class="slideshow-content-in">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div> --}}


<div id="page-content" class="mb-0">
    <section class="slideshow slideshow-wrapper">
        <div class="home-slideshow slick-arrow-dots">
            @forelse ($banners as $banner)
                <div class="slide">
                    <div class="slideshow-wrap">
                        <picture>
                            <source media="(max-width:767px)" srcset="{{ asset('storage/' . ($banner->mobile_image ?? $banner->image)) }}">
                            <img class="blur-up lazyload slideshow-img" src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}">
                        </picture>

                        <div class="container">
                            <div class="slideshow-content slideshow-overlay middle-left">
                                <div class="slideshow-content-in">
                                    <div class="wrap-caption animation style1">
                                        @if($banner->title)
                                            <h2 class="ss-mega-title">{{ $banner->title }}</h2>
                                        @endif
                                        @if($banner->description)
                                            <p class="ss-sub-title">{{ $banner->description }}</p>
                                        @endif
                                        @if($banner->link)
                                            <div class="ss-btnWrap">
                                                <a class="btn btn-primary" href="{{ $banner->link }}">Xem chi tiết</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-danger">Không có banner nào hiển thị</p>
            @endforelse
        </div>
    </section>
</div>

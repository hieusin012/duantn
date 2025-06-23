@section('title', $product->name)
@extends('clients.layouts.master')

@section('content')
<div id="page-content">
    <!-- Page Header -->
    <div class="container">
        <div class="breadcrumbs-wrapper">
            <nav class="breadcrumbs">
                <a href="{{ url('/') }}">Trang chủ</a> >
                <span class="main-title fw-bold">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="product-single section">
            <div class="row">
                <!-- Product Image -->
                <div class="col-lg-6 col-md-6 col-sm-12 product-layout-img mb-4 mb-md-0">
                    <div class="product-sticky-style">
                        <div class="product-details-img product-thumb-left-style d-flex justify-content-center">
                            <!-- Product Thumb -->
                            <div class="product-thumb thumb-left">
                                <div id="gallery" class="product-thumb-vertical h-100">
                                    @foreach($product->galleries as $image)
                                    <a data-image="{{ asset('storage/' . $image->image) }}" data-zoom-image="{{ asset('storage/' . $image->image) }}" class="slick-slide">
                                        <img class="blur-up lazyload rounded-0" data-src="{{ asset('storage/' . $image->image) }}" src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}" />
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End Product Thumb -->

                            <!-- Product Main -->
                            <div class="zoompro-wrap product-zoom-right rounded-0">
                                <div class="zoompro-span">
                                    <img id="zoompro" class="zoompro rounded-0" src="{{ asset($product->image) }}" data-zoom-image="{{ asset($product->image) }}" alt="{{ $product->name }}" />
                                </div>
                            </div>
                            <!-- End Product Main -->
                        </div>

                        <!-- Social Sharing -->
                        <div class="social-sharing d-flex-center justify-content-center mt-3 mt-md-4 lh-lg">
                            <span class="sharing-lbl fw-600">Chia sẻ :</span>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-facebook"><i class="icon anm anm-facebook-f"></i><span class="share-title">Facebook</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-twitter"><i class="icon anm anm-twitter"></i><span class="share-title">Twitter</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-pinterest"><i class="icon anm anm-pinterest-p"></i><span class="share-title">Pinterest</span></a>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6 col-md-6 col-sm-12 product-layout-info">
                    <div class="product-single-meta">
                        <div class="product-main-subtitle mb-3 d-flex-center">
                            <div class="product-labels"><span class="lbl pr-label1 mb-0">Bán chạy</span></div>
                        </div>
                        <h2 class="product-main-title">{{ $product->name }}</h2>
                        <div class="product-review d-flex-center mb-3">
                            <div class="reviewStar d-flex-center"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><span class="caption ms-2">{{ rand(10, 30) }} Lượt đánh giá</span></div>
                            <a class="reviewLink d-flex-center" href="#reviews">Viết đánh giá</a>
                        </div>
                        <div class="product-price d-flex-center my-3">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <div class="sort-description mb-3">{{ $product->description ?? 'Lorem Ipsum là văn bản giả được sử dụng trong ngành in ấn và thiết kế.' }}</div>
                        <div class="product-availability p-0 m-0 mb-3">
                            <div class="lh-1 d-flex justify-content-between">
                                <div class="text-sold fw-600">Còn <strong class="text-link">{{ $product->quantity ?? 16 }}</strong> sản phẩm!</div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar w-{{ min(100, ($product->quantity / ($product->quantity + 10)) * 100) }}%" role="progressbar" aria-valuenow="{{ min(100, ($product->quantity / ($product->quantity + 10)) * 100) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="orderMsg d-flex-center mb-3">
                            <i class="icon anm anm-medapps"></i>
                            <p class="m-0"><strong class="items">{{ rand(5, 10) }}</strong> Đã bán trong <strong class="time">{{ rand(10, 24) }}</strong> giờ</p>
                            <p id="quantity_message" class="ms-2 ps-2 border-start">Còn <span class="items fw-bold">{{ $product->quantity - rand(1, 5) }}</span> sản phẩm!</p>
                        </div>
                        <div class="userViewMsg featureText mb-2"><i class="icon anm anm-eye-r"></i><b class="uersView">{{ rand(10, 30) }}</b> Người đang xem</div>
                    </div>

                    <!-- Product Form -->
                    <form method="post" action="#" class="product-form product-form-border hidedropdown">
                        <div class="product-swatches-option">
                            <div class="product-item swatches-image w-100 mb-4 swatch-0 option1" data-option-index="0">
                                <label class="label d-flex align-items-center">Màu sắc:<span class="slVariant ms-1 fw-bold">Xanh</span></label>
                                <ul class="variants-clr swatches d-flex-center pt-1 clearfix">
                                    <li class="swatch x-large available active blue"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Xanh"></span></li>
                                    <li class="swatch x-large available black"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Đen"></span></li>
                                    <li class="swatch x-large available purple"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Tím"></span></li>
                                </ul>
                            </div>
                            <div class="product-item swatches-size w-100 mb-4 swatch-1 option2" data-option-index="1">
                                <label class="label d-flex align-items-center">Kích thước:<span class="slVariant ms-1 fw-bold">S</span><a href="#sizechart-modal" class="text-link sizelink text-muted size-chart-modal" data-bs-toggle="modal" data-bs-target="#sizechart_modal">Hướng dẫn kích thước</a></label>
                                <ul class="variants-size size-swatches d-flex-center pt-1 clearfix">
                                    <li class="swatch x-large available active"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="S">S</span></li>
                                    <li class="swatch x-large available"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="M">M</span></li>
                                    <li class="swatch x-large available"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="L">L</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-action w-100 d-flex-wrap my-3 my-md-4">
                            <!-- Product Quantity -->
                            <div class="product-form-quantity d-flex-center me-3">
                                <div class="qtyField">
                                    <a class="qtyBtn minus" href="#;"><i class="icon anm anm-minus-r"></i></a>
                                    <input type="text" name="quantity" value="1" class="product-form-input qty" />
                                    <a class="qtyBtn plus" href="#;"><i class="icon anm anm-plus-r"></i></a>
                                </div>
                            </div>
                            <!-- End Product Quantity -->
                            <!-- Product Add -->
                            <div class="product-form-submit addcart fl-1 ms-3">
                                <button type="submit" name="add" class="btn btn-secondary product-form-cart-submit">
                                    <span>Thêm vào giỏ</span>
                                </button>
                            </div>
                            <!-- Product Add -->
                            <!-- Product Buy -->
                            <div class="product-form-submit buyit fl-1 ms-3">
                                <button type="submit" class="btn btn-primary proceed-to-checkout">
                                    <span>Mua ngay</span>
                                </button>
                            </div>
                            <!-- End Product Buy -->
                        </div>
                        <p class="infolinks d-flex-center justify-content-between">
                            <a class="text-link wishlist" href="{{ url('/wishlist/add/' . $product->id) }}"><i class="icon anm anm-heart-l me-2"></i><span>Thêm vào yêu thích</span></a>
                            <a class="text-link compare" href="{{ url('/compare/add/' . $product->id) }}"><i class="icon anm anm-sync-ar me-2"></i><span>So sánh</span></a>
                            <a href="#shipping-return" class="text-link shippingInfo"><i class="icon anm anm-paper-l-plane me-2"></i><span>Giao hàng & Trả hàng</span></a>
                            <a href="{{ url('/enquiry/' . $product->id) }}" class="text-link emaillink me-0"><i class="icon anm anm-question-cil me-2"></i><span>Hỏi đáp</span></a>
                        </p>
                    </form>

                    <div class="product-info">
                        <div class="freeShipMsg featureText mb-2"><i class="icon anm anm-shield-check-r"></i>Bảo hành <b class="freeShip">1 năm</b></div>
                        <div class="freeShipMsg featureText mb-2"><i class="icon anm anm-sync-ar"></i>Trả hàng trong <b class="freeShip">30</b> ngày</div>
                        <div class="freeShipMsg featureText mb-3"><i class="icon anm anm-podcast-r"></i>Thanh toán khi nhận hàng</div>
                        <p class="product-stock d-flex">Trạng thái:
                            <span class="d-flex-center stockLbl text-uppercase {{ $product->is_active ? 'instock' : 'outofstock' }}">
                                {{ $product->is_active ? 'Còn hàng' : 'Hết hàng' }}
                            </span>
                        </p>
                        <p class="product-vendor">Thương hiệu:<span class="text">{{ $product->brand->name ?? 'Không xác định' }}</span></p>
                        <p class="product-type">Danh mục:<span class="text">{{ $product->category->name ?? 'Áo nam' }}</span></p>
                        <p class="product-sku">Mã sản phẩm:<span class="text">{{ $product->code }}</span></p>
                    </div>
                    <div class="freeShipMsg featureText mt-3"><i class="icon anm anm-truck-r"></i>Miễn phí vận chuyển cho đơn từ <b class="freeShip">2.000.000 VNĐ</b></div>
                    <div class="shippingMsg featureText mb-0"><i class="icon anm anm-clock-r"></i>Ước tính giao hàng: <b>Từ {{ date('D, d/m', strtotime('+2 days')) }}</b> đến <b>{{ date('D, d/m', strtotime('+7 days')) }}</b>.</div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="tabs-listing section pb-0">
            <ul class="product-tabs list-unstyled d-flex-wrap border-bottom d-none d-md-flex">
                <li rel="description" class="active"><a class="tablink">Mô tả</a></li>
                <li rel="additionalInformation"><a class="tablink">Thông tin chi tiết</a></li>
                <li rel="size-chart"><a class="tablink">Bảng kích thước</a></li>
                <li rel="shipping-return"><a class="tablink">Vận chuyển & Trả lại</a></li>
                <li rel="reviews"><a class="tablink">Đánh giá</a></li>
            </ul>

            <div class="tab-container">
                <!-- Description -->
                <h3 class="tabs-ac-style d-md-none active" rel="description">Mô tả</h3>
                <div id="description" class="tab-content">
                    <div class="product-description">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                {{ $product->description ?? 'Lorem Ipsum là văn bản giả được sử dụng trong ngành in ấn và thiết kế.' }}
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="video-popup-content">
                                    <a href="#productVideo-modal" class="popup-video video-button d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#productVideo_modal">
                                        <img class="rounded-0 w-100 blur-up lazyload" data-src="{{ asset('assets/images/content/product-detail-img-1.jpg') }}" src="{{ asset('assets/images/content/product-detail-img-1.jpg') }}" alt="Video" />
                                        <i class="icon anm anm-play-cir"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <h3 class="tabs-ac-style d-md-none" rel="additionalInformation">Thông tin chi tiết</h3>
                <div id="additionalInformation" class="tab-content">
                    <div class="product-description">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Màu sắc</th>
                                    <td>{{ $product->variants->pluck('color.name')->implode(', ') ?? 'Đen, Trắng, Xanh' }}</td>
                                </tr>
                                <tr>
                                    <th>Kích thước sản phẩm</th>
                                    <td>15 x 15 x 3 cm; 250g</td>
                                </tr>
                                <tr>
                                    <th>Ngày ra mắt</th>
                                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Nhà sản xuất</th>
                                    <td>Fashion and Retail Limited</td>
                                </tr>
                                <tr>
                                    <th>Danh mục</th>
                                    <td>{{ $product->category->name ?? 'Áo nam' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Size Chart -->
                <h3 class="tabs-ac-style d-md-none" rel="size-chart">Bảng kích thước</h3>
                <div id="size-chart" class="tab-content">
                    <h4 class="mb-2">Quần áo sẵn có</h4>
                    <div class="size-chart-tbl table-responsive">
                        <table class="table-bordered">
                            <thead>
                                <tr>
                                    <th>Kích thước</th>
                                    <th>XS</th>
                                    <th>S</th>
                                    <th>M</th>
                                    <th>L</th>
                                    <th>XL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>UK</td>
                                    <td>6</td>
                                    <td>8</td>
                                    <td>10</td>
                                    <td>12</td>
                                    <td>14</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Shipping & Return -->
                <h3 class="tabs-ac-style d-md-none" rel="shipping-return">Vận chuyển & Trả lại</h3>
                <div id="shipping-return" class="tab-content">
                    <ul class="checkmark-info">
                        <li>Gửi hàng: Trong vòng 24 giờ</li>
                        <li>Bảo hành: 1 năm</li>
                        <li>Miễn phí vận chuyển cho đơn từ 2.000.000 VNĐ</li>
                        <li>Thời gian giao hàng quốc tế: 7-10 ngày</li>
                        <li>Thanh toán khi nhận hàng</li>
                        <li>Trả hàng dễ dàng trong 30 ngày</li>
                    </ul>
                </div>

                <!-- Reviews -->
                <h3 class="tabs-ac-style d-md-none" rel="reviews">Đánh giá</h3>
                <div id="reviews" class="tab-content">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="ratings-main">
                                <div class="avg-rating d-flex-center mb-3">
                                    <h4 class="avg-mark">4.5</h4>
                                    <div class="avg-content ms-3">
                                        <p class="text-rating">Đánh giá trung bình</p>
                                        <div class="ratings-full"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <section class="section product-slider pb-0">
        <div class="container">
            <div class="section-header">
                <h2>Sản phẩm liên quan</h2>
            </div>
            <div class="product-slider-4items gp10 grid-products">
                @foreach($relatedProducts as $related)
                <div class="item col-item">
                    <div class="product-box">
                        <div class="product-image">
                            <a href="{{ route('client.products.show', $related->slug) }}" class="product-img"><img class="blur-up lazyload" src="{{ asset($related->image) }}" alt="{{ $related->name }}" /></a>
                            <div class="product-labels"><span class="lbl on-sale">Giảm giá</span></div>
                        </div>
                        <div class="product-details text-left">
                            <div class="product-name"><a href="{{ route('client.products.show', $related->slug) }}">{{ $related->name }}</a></div>
                            <div class="product-price"><span class="price">{{ number_format($related->price, 0, ',', '.') }} VNĐ</span></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#zoompro').zoom();
        $('#gallery').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            infinite: true,
            arrows: true,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }]
        });
    });
</script>
@endsection
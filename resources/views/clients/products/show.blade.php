@section('title', $product->name)
@extends('clients.layouts.master')
@section('title', $product->name)

@push('styles')
<style>
    .btn-check:checked+.color-label {
        border: 3px solid black !important;
    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .cart-bounce {
        animation: bounce 0.5s ease;
    }

    .color-swatch {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Styles for the star rating input */
.rating-stars {
    display: flex;
    align-items: center;
    gap: 5px; /* Adjust spacing between stars */
    direction: ltr; /* Ensure left-to-right order */
}

.rating-stars input[type="radio"] {
    display: none; /* Hide the radio buttons */
}

.rating-stars label {
    cursor: pointer;
    font-size: 24px; /* Adjust star size */
    color: #ccc; /* Default star color (empty) */
}

/* Color for selected/hovered stars and their preceding stars */
.rating-stars label:hover,
.rating-stars label:hover ~ label,
.rating-stars input[type="radio"]:checked ~ label {
    color: #ffc107; /* Yellow/gold for filled stars */
}

/* Special rule to ensure selected stars stay yellow when mouseout occurs on an unselected star */
/* This specific rule ensures that if you click on 3 stars, and then hover over 1 star, only 1 star lights up,
   but when you move out, it correctly reverts to 3 stars being lit. */
.rating-stars input[type="radio"]:checked + label,
.rating-stars input[type="radio"]:checked + label ~ label {
    color: #ffc107;
}

/* When a label is hovered, or its associated radio is checked, set its color */
.rating-stars label:hover i,
.rating-stars input[type="radio"]:checked + label i {
    color: #ffc107;
}
/* All stars before the hovered one should also be colored */
.rating-stars label:hover ~ label i {
    color: #ffc107;
}

/* Ensure empty state when not hovered and not checked */
.rating-stars label i {
    color: #ccc;
}
/* Override for selected stars */
.rating-stars input[type="radio"]:checked + label i,
.rating-stars input[type="radio"]:checked + label ~ label i {
    color: #ffc107;
}
</style>
@endpush

@section('content')
<div id="page-content">
    <div class="page-header text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="breadcrumbs"><a href="index.html" title="Back to the home page">Home</a><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Chi tiết sản phẩm</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="product-single">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-img mb-4 mb-md-0">
                    <div class="product-sticky-style">
                        <div class="product-details-img product-thumb-left-style d-flex justify-content-center">
                            <div class="product-thumb thumb-left">
                                <div id="gallery" class="product-thumb-vertical h-100">
                                    @foreach($product->variants as $image)
                                    <a data-image="{{ asset('storage/' . $image->image) }}" data-zoom-image="{{ asset('storage/' . $image->image) }}" href="{{ asset('storage/' . $image->image) }}" class="product-thumb-image">
                                        <img class="blur-up lazyload rounded-0" data-src="{{ asset('storage/' . $image->image) }}" src="{{ asset('storage/' . $image->image) }}" alt="product" width="625" height="808" />
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="zoompro-wrap product-zoom-right rounded-0">
                                <div class="zoompro-span"><img id="zoompro" class="zoompro rounded-0 img-thumbnail rounded shadow" src="{{ asset($product->image) }}" data-zoom-image="assets/images/products/product2.jpg" alt="product" width="625" height="808" /></div>
                            </div>
                        </div>
                        <div class="social-sharing d-flex-center justify-content-center mt-3 mt-md-4 lh-lg">
                            <span class="sharing-lbl fw-600">Share :</span>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-facebook"><i class="icon anm anm-facebook-f"></i><span class="share-title">Facebook</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-twitter"><i class="icon anm anm-twitter"></i><span class="share-title">Tweet</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-pinterest"><i class="icon anm anm-pinterest-p"></i> <span class="share-title">Pin it</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-linkedin"><i class="icon anm anm-linkedin-in"></i><span class="share-title">Linkedin</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-email"><i class="icon anm anm-envelope-l"></i><span class="share-title">Email</span></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-info">
                    <div class="product-single-meta">
                        <div class="product-main-subtitle mb-3 d-flex-center">
                            <div class="product-labels position-static d-inline-flex"><span class="lbl pr-label1 mb-0">Best seller</span></div>
                            <span class="label-text ms-2 d-none">in Fashion</span>
                        </div>
                        <h2 class="product-main-title">{{ $product->name }}</h2>
                        <div class="product-review d-flex-center mb-3">
                            <div class="reviewStar d-flex-center"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><span class="caption ms-2">24 Lượt đánh giá</span></div>
                            <a class="reviewLink d-flex-center" href="#reviews">Write a Review</a>
                        </div>
                        <div class="product-price d-flex-center my-3">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <div class="sort-description mb-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum</div>
                        <div class="product-availability p-0 m-0 mb-3 position-static col-lg-9">
                            <div class="lh-1 d-flex justify-content-between">
                                <div class="text-sold fw-600">Currently, <strong class="text-link">16</strong> items are in stock!</div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="orderMsg d-flex-center mb-3" data-user="23" data-time="24">
                            <i class="icon anm anm-medapps"></i>
                            <p class="m-0"><strong class="items">8</strong> Sold in last <strong class="time">14</strong> hours</p>
                            <p id="quantity_message" class="ms-2 ps-2 border-start">Hurry up! only <span class="items fw-bold">4</span> products left in stock!</p>
                        </div>
                        <div class="userViewMsg featureText mb-2" data-user="20" data-time="11000"><i class="icon anm anm-eye-r"></i><b class="uersView">21</b> People are Looking for this Product</div>
                    </div>
                    <form method="post" action="{{ route('client.cart.add') }}" id="add-to-cart-form" class="product-form product-form-border hidedropdown">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="product-swatches-option">
                            <div class="product-item swatches-image w-100 mb-4 swatch-0 option1" data-option-index="0">
                                <div class="mb-3">
                                    <label class="form-label d-block">
                                        Chọn màu: <strong id="selectedColorName">Chưa chọn</strong>
                                    </label>

                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($colors as $color)
                                        <input
                                            type="radio"
                                            class="btn-check"
                                            name="color_id"
                                            id="color-{{ $color->id }}"
                                            value="{{ $color->id }}"
                                            autocomplete="off"
                                            data-color-name="{{ $color->name }}">

                                        <label
                                            class="btn border p-2 color-swatch"
                                            for="color-{{ $color->id }}"
                                            data-color-code="{{ $color->color_code }}"
                                            title="{{ $color->name }}">
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="product-item swatches-size w-100 mb-4 swatch-1 option2" data-option-index="1">
                                <div class="mb-3">
                                    <label class="form-label">Chọn size:</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($sizes as $size)
                                        <input type="radio" class="btn-check" name="size_id" id="size-{{ $size->id }}" value="{{ $size->id }}" autocomplete="off">
                                        <label class="btn btn-outline-warning" for="size-{{ $size->id }}">
                                            {{ $size->name }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-action w-100 d-flex-wrap my-3 my-md-4">
                            <div class="product-form-quantity d-flex-center">
                                <div class="input-group input-group-sm w-auto">
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                        –
                                    </button>
                                    <input type="number" name="quantity" value="1" min="1" class="form-control text-center" style="max-width: 80px;" />
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                        +
                                    </button>
                                </div>
                            </div>
                            <div class="product-form-submit addcart fl-1 ms-3">
                                <button type="submit" id="add-to-cart-btn" class="btn btn-primary">
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                    </form>
                    <div class="product-form-submit buyit fl-1 ms-3">
                        <button type="submit" class="btn btn-primary proceed-to-checkout">
                            <span>Mua ngay</span>
                        </button>
                    </div>
                </div>
                <p class="infolinks d-flex-center justify-content-between">
                    <a class="text-link wishlist" href="wishlist-style1.html"><i class="icon anm anm-heart-l me-2"></i> <span>Add to Wishlist</span></a>
                    <a class="text-link compare" href="compare-style1.html"><i class="icon anm anm-sync-ar me-2"></i> <span>Add to Compare</span></a>
                    <a href="#shippingInfo-modal" class="text-link shippingInfo" data-bs-toggle="modal" data-bs-target="#shippingInfo_modal"><i class="icon anm anm-paper-l-plane me-2"></i> <span>Delivery &amp; Returns</span></a>
                    <a href="#productInquiry-modal" class="text-link emaillink me-0" data-bs-toggle="modal" data-bs-target="#productInquiry_modal"><i class="icon anm anm-question-cil me-2"></i> <span>Enquiry</span></a>
                </p>
                <div class="product-info">
                    <div class="freeShipMsg featureText mb-2"><i class="icon anm anm-shield-check-r"></i> Bảo hành thương hiệu <b class="freeShip">1 năm</b></div>
                    <div class="freeShipMsg featureText mb-2"><i class="icon anm anm-sync-ar"></i><b class="freeShip">30</b> Day Return Policy</div>
                    <div class="freeShipMsg featureText mb-3"><i class="icon anm anm-podcast-r"></i>Cash on Delivery available</div>
                    <p class="product-stock d-flex">Trạng thái:
                        <span class="d-flex-center stockLbl text-uppercase {{ $product->is_active ? 'instock' : 'outofstock' }}">
                            {{ $product->is_active ? 'Còn hàng' : 'Hết hàng' }}
                        </span>
                    </p>
                    <p class="product-vendor">Thương hiệu:<span class="text"><a href="#"></a>{{ $product->brand->name }}</span></p>
                    <p class="product-type">Danh mục:<span class="text">{{ $product->category->name }}</span></p>
                    <p class="product-sku">Mã sản phẩm:<span class="text">{{ $product->code }}</span></p>
                </div>
                <div class="freeShipMsg featureText mt-3" data-price="199"><i class="icon anm anm-truck-r"></i>Spent <b class="freeShip"><span class="money" data-currency-usd="$199.00" data-currency="USD">$199.00</span></b> More for Free shipping</div>
                <div class="shippingMsg featureText mb-0"><i class="icon anm anm-clock-r"></i>Estimated Delivery Between <b id="fromDate">Wed, May 1</b> and <b id="toDate">Tue, May 7</b>.</div>
                <div class="trustseal-img mt-3 mt-md-4"><img src="assets/images/icons/powerby-cards.jpg" alt="powerby cards" width="470" /></div>
            </div>
        </div>
    </div>
    <a href="product-layout1.html" class="product-nav prev-pro clr-none d-flex-center justify-content-between" title="Previous Product">
        <span class="details">
            <span class="name">Oxford Cuban Shirt</span>
            <span class="price">$99.00</span>
        </span>
        <span class="img"><img class="rounded-0 rounded-start-0" src="" alt="product" width="120" height="170" /></span>
    </a>
    <a href="product-layout3.html" class="product-nav next-pro clr-none d-flex-center justify-content-between" title="Next Product">
        <span class="img"><img class="rounded-0 rounded-end-0" src="assets/images/products/product3-120x170.jpg" alt="product" width="120" height="170" /></span>
        <span class="details">
            <span class="name">Cuff Beanie Cap</span>
            <span class="price">$128</span>
        </span>
    </a>
    <div class="tabs-listing section pb-0">
        <ul class="product-tabs list-unstyled d-flex-wrap border-bottom d-none d-md-flex">
            <li rel="description" class="active"><a class="tablink">Mô tả</a></li>
            <li rel="additionalInformation"><a class="tablink">Thông tin chi tiết</a></li>
            <li rel="size-chart"><a class="tablink">Bảng kích thước</a></li>
            <li rel="shipping-return"><a class="tablink">Vận chuyển &amp; Trả lại</a></li>
            <li rel="reviews"><a class="tablink">Đánh giá</a></li>
        </ul>

        <div class="tab-container">
            <h3 class="tabs-ac-style d-md-none active" rel="description">Mô tả</h3>
            <div id="description" class="tab-content">
                <div class="product-description">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8">
                            {{ $product->description }}
                        </div>

                        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                            <div class="video-popup-content position-relative">
                                <a href="#productVideo-modal" class="popup-video video-button d-flex align-items-center justify-content-center rounded-0" data-bs-toggle="modal" data-bs-target="#productVideo_modal" title="View Video">
                                    <img class="rounded-0 w-100 d-block blur-up lazyload" data-src="assets/images/content/product-detail-img-1.jpg" src="assets/images/content/product-detail-img-1.jpg" alt="image" width="550" height="660" />
                                    <i class="icon anm anm-play-cir"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <h3 class="tabs-ac-style d-md-none" rel="additionalInformation">Additional Information</h3>
            <div id="additionalInformation" class="tab-content">
                <div class="product-description">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4 mb-md-0">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-part mb-0">
                                    <tr>
                                        <th>Color</th>
                                        <td>Black, White, Blue, Red, Gray</td>
                                    </tr>
                                    <tr>
                                        <th>Product Dimensions</th>
                                        <td>15 x 15 x 3 cm; 250 Grams</td>
                                    </tr>
                                    <tr>
                                        <th>Date First Available</th>
                                        <td>14 May 2023</td>
                                    </tr>
                                    <tr>
                                        <th>Manufacturer‏</th>
                                        <td>Fashion and Retail Limited</td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>Men Shirt</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="tabs-ac-style d-md-none" rel="size-chart">Size Chart</h3>
            <div id="size-chart" class="tab-content">
                <h4 class="mb-2">Ready to Wear Clothing</h4>
                <p class="mb-4">This is a standardised guide to give you an idea of what size you will need, however some brands may vary from these conversions.</p>
                <div class="size-chart-tbl table-responsive px-1">
                    <table class="table-bordered align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>XXS - XS</th>
                                <th>XS - S</th>
                                <th>S - M</th>
                                <th>M - L</th>
                                <th>L - XL</th>
                                <th>XL - XXL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>UK</th>
                                <td>6</td>
                                <td>8</td>
                                <td>10</td>
                                <td>12</td>
                                <td>14</td>
                                <td>16</td>
                            </tr>
                            <tr>
                                <th>US</th>
                                <td>2</td>
                                <td>4</td>
                                <td>6</td>
                                <td>8</td>
                                <td>10</td>
                                <td>12</td>
                            </tr>
                            <tr>
                                <th>Italy (IT)</th>
                                <td>38</td>
                                <td>40</td>
                                <td>42</td>
                                <td>44</td>
                                <td>46</td>
                                <td>48</td>
                            </tr>
                            <tr>
                                <th>France (FR/EU)</th>
                                <td>34</td>
                                <td>36</td>
                                <td>38</td>
                                <td>40</td>
                                <td>42</td>
                                <td>44</td>
                            </tr>
                            <tr>
                                <th>Denmark</th>
                                <td>32</td>
                                <td>34</td>
                                <td>36</td>
                                <td>38</td>
                                <td>40</td>
                                <td>42</td>
                            </tr>
                            <tr>
                                <th>Russia</th>
                                <td>40</td>
                                <td>42</td>
                                <td>44</td>
                                <td>46</td>
                                <td>48</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <th>Germany</th>
                                <td>32</td>
                                <td>34</td>
                                <td>36</td>
                                <td>38</td>
                                <td>40</td>
                                <td>42</td>
                            </tr>
                            <tr>
                                <th>Japan</th>
                                <td>5</td>
                                <td>7</td>
                                <td>9</td>
                                <td>11</td>
                                <td>13</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <th>Australia</th>
                                <td>6</td>
                                <td>8</td>
                                <td>10</td>
                                <td>12</td>
                                <td>14</td>
                                <td>16</td>
                            </tr>
                            <tr>
                                <th>Korea</th>
                                <td>33</td>
                                <td>44</td>
                                <td>55</td>
                                <td>66</td>
                                <td>77</td>
                                <td>88</td>
                            </tr>
                            <tr>
                                <th>China</th>
                                <td>160/84</td>
                                <td>165/86</td>
                                <td>170/88</td>
                                <td>175/90</td>
                                <td>180/92</td>
                                <td>185/94</td>
                            </tr>
                            <tr>
                                <th>Jeans</th>
                                <td>24-25</td>
                                <td>26-27</td>
                                <td>27-28</td>
                                <td>29-30</td>
                                <td>31-32</td>
                                <td>32-33</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <h3 class="tabs-ac-style d-md-none" rel="shipping-return">Shipping &amp; Return</h3>
            <div id="shipping-return" class="tab-content">
                <h4 class="pb-1">Shipping &amp; Return</h4>
                <ul class="checkmark-info">
                    <li>Dispatch: Within 24 Hours</li>
                    <li>1 Year Brand Warranty</li>
                    <li>Free shipping across all products on a minimum purchase of $50.</li>
                    <li>International delivery time - 7-10 business days</li>
                    <li>Cash on delivery might be available</li>
                    <li>Easy 30 days returns and exchanges</li>
                </ul>
                <h4 class="pt-1">Free and Easy Returns</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                <h4 class="pt-1">Special Financing</h4>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage.</p>
            </div>
            <h3 class="tabs-ac-style d-md-none" rel="reviews">Review</h3>
            <div id="reviews" class="tab-content">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-4">
                        <div class="ratings-main">
                            <div class="avg-rating d-flex-center mb-3">
                                <h4 class="avg-mark">4.5</h4>
                                <div class="avg-content ms-3">
                                    <p class="text-rating">Average Rating</p>
                                    <div class="ratings-full product-review">
                                        <a class="reviewLink d-flex-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><span class="caption ms-2">24 Ratings</span></a>
                                    </div>
                                </div>
                            </div>

                            <div class="ratings-list">
                                <div class="ratings-container d-flex align-items-center mt-1">
                                    <div class="ratings-full product-review m-0">
                                        <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i></a>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="99" aria-valuemin="0" aria-valuemax="100" style="width:99%;"></div>
                                    </div>
                                    <div class="progress-value">99%</div>
                                </div>
                                <div class="ratings-container d-flex align-items-center mt-1">
                                    <div class="ratings-full product-review m-0">
                                        <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i></a>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%;"></div>
                                    </div>
                                    <div class="progress-value">75%</div>
                                </div>
                                <div class="ratings-container d-flex align-items-center mt-1">
                                    <div class="ratings-full product-review m-0">
                                        <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></a>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"></div>
                                    </div>
                                    <div class="progress-value">50%</div>
                                </div>
                                <div class="ratings-container d-flex align-items-center mt-1">
                                    <div class="ratings-full product-review m-0">
                                        <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></a>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width:25%;"></div>
                                    </div>
                                    <div class="progress-value">25%</div>
                                </div>
                                <div class="ratings-container d-flex align-items-center mt-1">
                                    <div class="ratings-full product-review m-0">
                                        <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></a>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width:5%;"></div>
                                    </div>
                                    <div class="progress-value">05%</div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="spr-reviews">
                            <h3 class="spr-form-title">Customer Reviews</h3>
                            <div class="review-inner">
                                <div class="spr-review d-flex w-100">
                                    <div class="spr-review-profile flex-shrink-0">
                                        <img class="blur-up lazyload" data-src="assets/images/users/testimonial2.jpg" src="assets/images/users/testimonial2.jpg" alt="" width="200" height="200" />
                                    </div>
                                    <div class="spr-review-content flex-grow-1">
                                        <div class="d-flex justify-content-between flex-column mb-2">
                                            <div class="title-review d-flex align-items-center justify-content-between">
                                                <h5 class="spr-review-header-title text-transform-none mb-0">Eleanor Pena</h5>
                                                <span class="product-review spr-starratings m-0"><span class="reviewLink"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i></span></span>
                                            </div>
                                        </div>
                                        <b class="head-font">Good and High quality</b>
                                        <p class="spr-review-body">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                    </div>
                                </div>
                                <div class="spr-review d-flex w-100">
                                    <div class="spr-review-profile flex-shrink-0">
                                        <img class="blur-up lazyload" data-src="assets/images/users/testimonial1.jpg" src="assets/images/users/testimonial1.jpg" alt="" width="200" height="200" />
                                    </div>
                                    <div class="spr-review-content flex-grow-1">
                                        <div class="d-flex justify-content-between flex-column mb-2">
                                            <div class="title-review d-flex align-items-center justify-content-between">
                                                <h5 class="spr-review-header-title text-transform-none mb-0">Courtney Henry</h5>
                                                <span class="product-review spr-starratings m-0"><span class="reviewLink"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></span></span>
                                            </div>
                                        </div>
                                        <b class="head-font">Feature Availability</b>
                                        <p class="spr-review-body">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-4">
                        <form method="post" action="#" class="product-review-form new-review-form">
                            <h3 class="spr-form-title">Write a Review</h3>
                            <p>Your email address will not be published. Required fields are marked *</p>
                            <fieldset class="row spr-form-contact">
                                <div class="col-sm-6 spr-form-contact-name form-group">
                                    <label class="spr-form-label" for="nickname">Name <span class="required">*</span></label>
                                    <input class="spr-form-input spr-form-input-text" id="nickname" type="text" name="name" required />
                                </div>
                                <div class="col-sm-6 spr-form-contact-email form-group">
                                    <label class="spr-form-label" for="email">Email <span class="required">*</span></label>
                                    <input class="spr-form-input spr-form-input-email " id="email" type="email" name="email" required />
                                </div>
                                <div class="col-sm-6 spr-form-review-title form-group">
                                    <label class="spr-form-label" for="review">Review Title </label>
                                    <input class="spr-form-input spr-form-input-text " id="review" type="text" name="review" />
                                </div>
                                <div class="col-sm-6 spr-form-review-rating form-group">
                                    <label class="spr-form-label">Rating</label>
                                    <div class="product-review pt-1">
                                        <div class="review-rating">
                                            <a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 spr-form-review-body form-group">
                                    <label class="spr-form-label" for="message">Body of Review <span class="spr-form-review-body-charactersremaining">(1500) characters remaining</span></label>
                                    <div class="spr-form-input">
                                        <textarea class="spr-form-input spr-form-input-textarea" id="message" name="message" rows="3"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="spr-form-actions clearfix">
                                <input type="submit" class="btn btn-primary spr-button spr-button-primary" value="Submit Review" />
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@auth
<div class="container mt-4">
    <h4>Gửi đánh giá của bạn</h4>
    <form action="{{ route('client.comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="mb-3">
            <label for="rating">Đánh giá sao (tùy chọn):</label>
            <div class="rating-stars" id="ratingStars">
                @for ($i = 1; $i <= 5; $i++)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                    <label for="star{{ $i }}"><i class="icon anm anm-star-o"></i></label>
                    @endfor
            </div>
        </div>

        <div class="mb-3">
            <label for="content">Nội dung *</label>
            <textarea name="content" class="form-control" required rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
    </form>
</div>
@else
<div class="container mt-4">
    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.</p>
</div>
@endauth

<div class="container mt-5">
    <h3>Đánh giá sản phẩm</h3>

    @forelse($product->comments()->latest()->get() as $comment)
    <div class="border rounded p-3 mb-3">
        <strong>{{ $comment->user->name ?? 'Khách' }}</strong>
        <p class="mb-1 text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
        @if($comment->rating)
        <p>
            @for($i = 1; $i <= 5; $i++)
                <i class="icon anm {{ $i <= $comment->rating ? 'anm-star' : 'anm-star-o' }}"></i>
                @endfor
        </p>
        @endif
        <p>{{ $comment->content }}</p>
    </div>
    @empty
    <p>Chưa có đánh giá nào cho sản phẩm này.</p>
    @endforelse
</div>

<section class="section product-slider pb-0">
    <div class="container">
        <div class="section-header">
            <p class="mb-1 mt-0">Discover Similar</p>
            <h2>Sản phẩm liên quan</h2>
        </div>

        <div class="product-slider-4items gp10 arwOut5 grid-products">
            @foreach($relatedProducts as $product)
            <div class="item col-item">
                <div class="product-box">
                    <div class="product-image">
                        <a href="{{ route('client.products.show', $product->slug) }}" class="product-img rounded-0"><img class="rounded-0 blur-up lazyload" src="{{ asset($product->image) }}" alt="Product" title="Product" width="625" height="808" /></a>
                        <div class="product-labels"><span class="lbl on-sale">Sale</span></div>
                        <div class="button-set style1">
                            <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick Shop"><i class="icon anm anm-cart-l"></i><span class="text">Quick Shop</span></span>
                            </a>
                            <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                            </a>
                            <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="left" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                            <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                        </div>
                    </div>
                    <div class="product-details text-left text-center">
                        <div class="product-name">
                            <a href="product-layout1.html" class="text-decoration-none text-primary fw-bold fw-semibold fs-6">{{ $product->name }}</a>
                        </div>
                        <div class="product-review">
                            <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                            <span class="caption hidden ms-1">3 Reviews</span>
                        </div>
                        <div class="product-price">
                            <span class="price old-price">$114.00</span><span class="price text-danger fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
</div>
<script>
    const radios = document.querySelectorAll('input[name="color_id"]');
    const selectedName = document.getElementById('selectedColorName');

    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            const name = this.getAttribute('data-color-name');
            selectedName.textContent = name;
        });
    });

    document.querySelector('.product-form-cart-submit').addEventListener('click', function(e) {
        e.preventDefault();

        const form = this.closest('form');
        const formData = new FormData(form);

        fetch("{{ route('client.cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })

            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật số trên icon giỏ hàng
                    document.getElementById('cart-count').innerText = data.total_quantity;

                    // Thêm hiệu ứng nhảy
                    const cartIcon = document.getElementById('cart-count');
                    cartIcon.classList.add('cart-bounce');

                    setTimeout(() => {
                        cartIcon.classList.remove('cart-bounce');
                    }, 500);
                } else {
                    alert(data.message || 'Thêm vào giỏ hàng thất bại');
                }
            });
    });
    // JavaScript for star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const ratingStarsContainer = document.getElementById('ratingStars');
    if (!ratingStarsContainer) return;

    const radioInputs = ratingStarsContainer.querySelectorAll('input[type="radio"]');
    const labels = ratingStarsContainer.querySelectorAll('label');

    // Function to update the visual state of stars based on which radio is checked
    function updateStarDisplay() {
        radioInputs.forEach((radio) => {
            const label = document.querySelector(`label[for="${radio.id}"]`);
            if (label) {
                // Remove 'selected' class from all labels initially
                label.classList.remove('selected');
                // Remove filled star class from all icons initially
                label.querySelector('i').classList.remove('anm-star');
                label.querySelector('i').classList.add('anm-star-o');
            }
        });

        // Add 'selected' class to the checked radio's label and preceding labels
        const checkedRadio = ratingStarsContainer.querySelector('input[name="rating"]:checked');
        if (checkedRadio) {
            const checkedValue = parseInt(checkedRadio.value);
            labels.forEach((label, index) => {
                const starValue = parseInt(label.getAttribute('for').replace('star', ''));
                if (starValue <= checkedValue) {
                    label.classList.add('selected'); // Add selected class to label
                    label.querySelector('i').classList.remove('anm-star-o');
                    label.querySelector('i').classList.add('anm-star');
                }
            });
        }
    }

    // Event listeners for radio buttons (click event)
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            // No need to explicitly set currentRating here, as CSS handles checked state
            updateStarDisplay(); // Update display after a radio button is checked
        });
    });

    // Event listeners for labels (hover effects - handled primarily by CSS now)
    // We still keep the mouseout for consistency in case of complex interactions
    labels.forEach((label) => {
        label.addEventListener('mouseover', function() {
            const hoverValue = parseInt(this.getAttribute('for').replace('star', ''));
            // Manually add hover effect if CSS isn't fully robust for complex scenarios
            labels.forEach((lbl) => {
                const starValue = parseInt(lbl.getAttribute('for').replace('star', ''));
                if (starValue <= hoverValue) {
                    lbl.querySelector('i').classList.remove('anm-star-o');
                    lbl.querySelector('i').classList.add('anm-star');
                } else {
                    lbl.querySelector('i').classList.remove('anm-star');
                    lbl.querySelector('i').classList.add('anm-star-o');
                }
            });
        });

        label.addEventListener('mouseout', function() {
            // Revert to the checked state
            updateStarDisplay();
        });
    });

    // Initialize display on page load
    updateStarDisplay();
});
</script>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize Zoom
        $('#zoompro').zoom();

        // Initialize Thumb Slider
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
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2
                    }
                }
            ]
        });

        // Initialize Lightbox
        $('.lightboximages a').fancybox();
    });
</script>
<script>
    document.querySelectorAll('.color-swatch').forEach(function(el) {
        const color = el.getAttribute('data-color-code');
        if (color) {
            el.style.backgroundColor = `#${color}`;
        }
    });
</script>

@endsection
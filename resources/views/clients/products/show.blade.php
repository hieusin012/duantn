@section('title', $product->name)
@extends('clients.layouts.master')

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

    /* Styles for the star rating input in the review form */
    .rating-stars {
        display: inline-block;
        direction: rtl;
        /* Right-to-left to handle hover effect correctly */
    }

    .rating-stars input[type="radio"] {
        display: none;
        /* Hide the actual radio buttons */
    }

    .rating-stars label {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
        padding: 0 2px;
    }

    /* Change color on hover and for checked stars */
    .rating-stars label:hover,
    .rating-stars label:hover~label,
    .rating-stars input[type="radio"]:checked~label {
        color: #ffc107;
    }

    .product-single-meta .product-review {
        margin-bottom: 5rem;
    }

    .product-single-meta .product-price {
        margin-top: 5rem;
        margin-bottom: 5.5rem;
    }

    .product-single-meta .sort-description {
        margin-bottom: 5.5rem;
    }


    /* YÊU CẦU 2: TĂNG LỀ (PADDING) CHO NỘI DUNG BÊN TRONG CÁC TAB */
    .tab-container .tab-content {
        padding: 2.5rem;
        /* Tăng padding cho tất cả các tab */
    }

    .product-thumb-img:hover {
        transform: scale(1.05);
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        transition: all 0.2s ease-in-out;
    }
</style>
<style>
    .color-swatch {
        width: 36px;
        height: 36px;
        border: 2px solid #aaa;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: 0.2s;
        position: relative;
    }

    .border-for-white {
        border: 2px solid #888 !important;
        /* hoặc #000 cho rõ */
        box-shadow: 0 0 3px rgba(71, 71, 71, 0.4);
    }

    .btn-check:checked+.color-swatch {
        border: 3px solid #000;
        box-shadow: 0 0 0 2px rgba(2, 2, 2, 0.2);
    }

    .color-swatch .checkmark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
        width: 10px;
        height: 10px;
        background: white;
        border: 1px solid black;
        border-radius: 50%;
    }

    .btn-check:checked+.color-swatch .checkmark {
        display: block;
    }
</style>

@endpush

@section('content')
<div id="page-content">
    {{-- ================================================================= --}}
    {{-- HEADER & BREADCRUMBS                         --}}
    {{-- ================================================================= --}}
    <div class="page-header text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="breadcrumbs"><a href="/" title="Back to the home page">Home</a><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Chi tiết sản phẩm</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="product-single">
            <div class="row">
                {{-- ================================================================= --}}
                {{-- PRODUCT IMAGES                            --}}
                {{-- ================================================================= --}}
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-img mb-4 mb-md-0">
                    <div class="product-sticky-style">
                        <div class="product-details-img product-thumb-left-style d-flex justify-content-center">
                            @php
                            $colorsShown = [];
                            @endphp

                            <div class="product-thumb thumb-left">
                                <div id="gallery" class="product-thumb-vertical h-100 d-flex flex-column gap-3">
                                    @foreach($product->variants as $variant)
                                    @if(!in_array($variant->color, $colorsShown))
                                    <img
                                        src="{{ asset('storage/' . $variant->image) }}"
                                        class="product-thumb-img"
                                        alt="Thumbnail"
                                        onclick="changeMainImage(this)" />
                                    @php
                                    $colorsShown[] = $variant->color;
                                    @endphp
                                    @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="zoompro-wrap product-zoom-right rounded-0">
                                <div class="zoompro-span"><img id="main-image" class="zoompro rounded-0 img-thumbnail rounded shadow" src="{{ asset($product->image) }}" data-zoom-image="{{ asset($product->image) }}" alt="product" width="625" height="808" /></div>
                            </div>
                        </div>
                        <div class="social-sharing d-flex-center justify-content-center mt-3 mt-md-4 lh-lg">
                            <span class="sharing-lbl fw-600">Share :</span>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-facebook"><i class="icon anm anm-facebook-f"></i><span class="share-title">Facebook</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-twitter"><i class="icon anm anm-twitter"></i><span class="share-title">Tweet</span></a>
                            <a href="#" class="d-flex-center btn btn-link btn--share share-pinterest"><i class="icon anm anm-pinterest-p"></i> <span class="share-title">Pin it</span></a>
                        </div>
                    </div>
                </div>

                {{-- ================================================================= --}}
                {{-- PRODUCT INFO & FORM                         --}}
                {{-- ================================================================= --}}
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-info">
                    <div class="product-single-meta">
                        <h2 class="product-main-title">{{ $product->name }}</h2>
                        <div class="product-review d-flex-center mb-3">
                            @if ($totalReviews > 0)
                            <div class="review-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="icon anm {{ $i <= floor($averageRating) ? 'anm-star' : 'anm-star-o' }}"></i>
                                    @endfor
                            </div>
                            <span class="caption ms-2">{{ $totalReviews }} Lượt đánh giá</span>
                            @else
                            <span class="caption ms-2">Chưa có đánh giá</span>
                            @endif
                            <a class="reviewLink d-flex-center" href="#reviews">Viết đánh giá</a>
                        </div>
                        <div class="product-price d-flex-center my-3" id="product-price">
                            {{-- <span class="price fs-3" id="variant-price">
                                {{ number_format($product->price, 0, ',', '.') }} ₫
                            </span> --}}
                            {{-- @php
                            $price = $product->price;
                            $discountPercent = $product->discount_percent ?? 0;
                            $isHotDeal = $product->is_hot_deal
                            && $discountPercent > 0
                            && $product->deal_end_at
                            && \Carbon\Carbon::now()->lt($product->deal_end_at);

                            $salePrice = $isHotDeal ? $price * (1 - $discountPercent / 100) : null;
                            @endphp --}}
                            @php
                            $price = $product->price;
                            $discountPercent = $product->discount_percent ?? 0;
                            $now = \Carbon\Carbon::now();

                            $isHotDeal = $product->is_hot_deal
                            && $discountPercent > 0
                            && $product->deal_start_at
                            && $product->deal_start_at <= $now
                                && $product->deal_end_at
                                && $now < $product->deal_end_at;

                                    $salePrice = $isHotDeal ? $price * (1 - $discountPercent / 100) : null;
                                    @endphp
                                    @if ($isHotDeal)
                                    <div class="d-flex justify-content-between align-items-center bg-warning text-white p-2 rounded mb-2 w-100">
                                        <strong class="ms-2">F⚡ASH SALE</strong>
                                        <div class="me-2">
                                            <i class="bi bi-clock-fill me-1"></i>
                                            KẾT THÚC TRONG:
                                            <span class="countdown-timer text-danger fw-bold"
                                                data-deal-end="{{ \Carbon\Carbon::parse($product->deal_end_at)->timestamp * 1000 }}">
                                                <span class="time-remaining">--:--:--</span>
                                            </span>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="product-price d-flex-center my-3">
                                        @if ($isHotDeal)
                                        <span class="price fs-3 text-danger">
                                            {{ number_format($salePrice, 0, ',', '.') }} ₫
                                        </span>
                                        <del class="text-muted ms-2">
                                            {{ number_format($price, 0, ',', '.') }} ₫
                                        </del>
                                        <span class="text-danger fw-bold ms-2" style="font-size: 10px;">
                                            -{{ $discountPercent }}%
                                        </span>
                                        @else
                                        <span class="price fs-3" id="variant-price">
                                            {{ number_format($price, 0, ',', '.') }} ₫
                                        </span>
                                        @endif

                                    </div>
                        </div>
                    </div>

                    <form method="post" action="{{ route('client.cart.add') }}" id="add-to-cart-form" class="product-form product-form-border hidedropdown">
                        @csrf
                        <input type="hidden" name="product_id" id="product-id" value="{{ $product->id }}">
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
                                            data-color-name="{{ $color->name }}"
                                            {{ old('color_id') == $color->id ? 'checked' : '' }}
                                            autocomplete="off">

                                        <label
                                            class="btn color-swatch position-relative {{ strtolower($color->color_code) == '#ffffff' ? 'border-for-white' : '' }}"
                                            for="color-{{ $color->id }}"
                                            style="background-color: {{ $color->color_code }};"
                                            title="{{ $color->name }}">
                                            <span class="checkmark"></span>
                                        </label>

                                        @endforeach
                                    </div>


                                </div>
                                <div id="size-wrapper" style="display: none;" class="mt-3">
                                    <label>Chọn size:</label>
                                    <div class="d-flex flex-wrap gap-2" id="size-options">
                                        @foreach ($variants as $variant)
                                        <button type="button"
                                            class="btn btn-outline-dark size-btn d-none"
                                            data-color-id="{{ $variant->color_id }}"
                                            data-size-id="{{ $variant->size_id }}"
                                            data-variant-quantity="{{ $variant->quantity }}"
                                            data-image="{{ asset('storage/' . $variant->image) }}"
                                            data-price="{{ $variant->display_price }}">
                                            {{-- data-price="{{ $variant->sale_price ?? $variant->price }}"> --}}
                                            {{-- data-price="{{ $variant->price }}"> --}}
                                            {{ $variant->size->name }}
                                        </button>


                                        @endforeach
                                        <input type="hidden" name="size_id" id="selected-size-id">
                                    </div>
                                    <p id="out-of-stock-message" style="display: none; color: #dc3545; margin-top: 10px;">
                                        Mặt hàng này đã hết, vui lòng chọn mặt hàng khác.
                                    </p>
                                    <div id="stock-info"
                                        class="mt-3 px-3 py-2 rounded-3 d-inline-flex align-items-center bg-white border border-2 shadow-sm"
                                        style="display: none; font-size: 15px; min-width: 230px;">

                                        <i class="icon anm anm-cube me-2 text-primary fs-5"></i>

                                        <span class="me-1 text-secondary">Số lượng còn:</span>

                                        <strong id="stock-quantity" class="text-danger fs-6">0</strong>

                                        <span class="ms-1 text-muted">sản phẩm</span>
                                    </div>

                                </div>
                                <div class="product-action w-100 d-flex-wrap my-3 my-md-4">
                                    <div class="product-form-quantity d-flex align-items-center">
                                        <div class="quantity-wrapper d-flex align-items-center border rounded-pill overflow-hidden">
                                            <button type="button" class="qty-btn quantity-minus px-3 py-1 border-0 bg-white">
                                                <i class="icon anm anm-minus"></i>
                                            </button>
                                            <input type="number" name="quantity" id="quantity-input" value="1" min="1"
                                                class="qty-input text-center border-0" style="width: 50px;" readonly />
                                            <button type="button" class="qty-btn quantity-plus px-3 py-1 border-0 bg-white">
                                                <i class="icon anm anm-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="product-form-submit addcart fl-1 ms-3">
                                        <button type="submit" id="add-to-cart-btn" class="btn btn-primary">Thêm vào giỏ hàng</button>
                                    </div>
                                    <div class="product-form-submit buyit fl-1 ms-3">
                                        <button type="submit" class="btn btn-primary proceed-to-checkout"><span>Mua ngay</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Yêu thích -->
                    <!-- Yêu thích -->
                    <div class="d-flex align-items-center mb-3">
                        <a href="javascript:void(0);"
                            class="wishlist wishlist-toggle text-decoration-none d-flex align-items-center"
                            data-id="{{ $product->id }}"
                            data-bs-toggle="tooltip"
                            title="{{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' }}">
                            <i class="icon anm anm-heart me-2 fs-5 {{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'text-danger' : 'text-muted' }}"></i>
                            <span class="fw-medium text-dark">
                                {{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'Đã yêu thích' : 'Thêm vào yêu thích' }}
                            </span>
                        </a>
                    </div>

                    <hr class="my-2">

                    <!-- Thông tin sản phẩm -->
                    <table class="table table-borderless align-middle fs-9">
                        <tbody>
                            <tr>
                                <th scope="row" class="text-nowrap">
                                    Trạng thái:
                                </th>
                                <td>
                                    <span class="badge bg-success rounded-pill px-3 py-1">
                                        {{ $product->is_active ? 'Còn hàng' : 'Hết hàng' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-nowrap">
                                    Thương hiệu:
                                </th>
                                <td class="text-muted">{{ $product->brand->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-nowrap">
                                    Danh mục:
                                </th>
                                <td class="text-muted">{{ $product->category->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row" class="text-nowrap">
                                    Mã sản phẩm:
                                </th>
                                <td class="text-muted">{{ $product->code }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================= --}}
    {{-- TABS SECTION                              --}}
    {{-- ================================================================= --}}
    <div class="tabs-listing section pb-0">
        <ul class="product-tabs list-unstyled d-flex-wrap border-bottom d-none d-md-flex">
            <li rel="additionalInformation"><a class="tablink">Thông tin chi tiết</a></li>
            <li rel="size-chart"><a class="tablink">Bảng kích thước</a></li>
            <li rel="shipping-return"><a class="tablink">Vận chuyển &amp; Trả lại</a></li>
            <li rel="reviews"><a class="tablink">Đánh giá</a></li>
        </ul>


        <div class="tab-container">
            {{-- DESCRIPTION TAB --}}
            <h3 class="tabs-ac-style d-md-none active" rel="description">Mô tả</h3>
            <div id="description" class="tab-content">
                <div class="product-description">
                    <p>{{ $product->description }}</p>
                </div>
            </div>
            <h3 class="tabs-ac-style d-md-none" rel="size-chart">Bảng kích thước</h3>
            <div id="size-chart" class="tab-content p-4">
                <h4 class="mb-2">Bảng kích thước quần áo</h4>
                <p class="mb-4">Đây là hướng dẫn được tiêu chuẩn hóa để cho bạn biết về kích thước bạn sẽ cần, tuy nhiên một số thương hiệu có thể khác với các chuyển đổi này.</p>
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
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SHIPPING TAB --}}
            <h3 class="tabs-ac-style d-md-none" rel="shipping-return">Vận chuyển &amp; Trả lại</h3>
            <div id="shipping-return" class="tab-content">
                <h4 class="pb-1">Vận chuyển &amp; Trả lại</h4>
                <ul class="checkmark-info">
                    <li>Giao hàng: Trong vòng 24 giờ</li>
                    <li>Bảo hành thương hiệu 1 năm</li>
                    <li>Miễn phí vận chuyển cho đơn hàng từ 500.000 ₫.</li>
                    <li>Thời gian giao hàng toàn quốc - 2-5 ngày làm việc</li>
                    <li>Có thể thanh toán khi nhận hàng (COD)</li>
                    <li>Chính sách đổi trả dễ dàng trong 30 ngày</li>
                </ul>
            </div>

            {{-- ============================================================= --}}
            {{-- DYNAMIC REVIEWS TAB                         --}}
            {{-- ============================================================= --}}
            <h3 class="tabs-ac-style d-md-none" rel="reviews">Đánh giá</h3>
            <div id="reviews" class="tab-content">
                <div class="row">
                    {{-- LEFT COLUMN: STATISTICS --}}
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-4">
                        <div class="ratings-main">
                            @if ($totalReviews > 0)
                            <div class="avg-rating d-flex-center mb-3">
                                <h4 class="avg-mark">{{ $averageRating }}</h4>
                                <div class="avg-content ms-3">
                                    <p class="text-rating">Đánh giá trung bình</p>
                                    <div class="ratings-full product-review">
                                        <div class="review-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="icon anm {{ $i <= floor($averageRating) ? 'anm-star' : 'anm-star-o' }}"></i>
                                                @endfor
                                        </div><br>
                                        <span class="caption ms-2">{{ $totalReviews }} Đánh giá</span>
                                    </div>
                                </div>
                            </div>

                            <div class="ratings-list">
                                @for ($i = 5; $i >= 1; $i--)
                                <div class="ratings-container d-flex align-items-center mt-1">
                                    <div class="ratings-full product-review m-0 d-flex align-items-center">
                                        <span>{{ $i }}</span> <i class="icon anm anm-star ms-1"></i>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $ratingPercentages[$i] ?? 0 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $ratingPercentages[$i] ?? 0 }}%;"></div>
                                    </div>
                                    <div class="progress-value">{{ $ratingPercentages[$i] ?? 0 }}%</div>
                                </div>
                                @endfor
                            </div>
                            @else
                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                            @endif
                        </div>
                        <hr />
                        <div class="spr-reviews">
                            <h3 class="spr-form-title">Đánh giá từ khách hàng</h3>
                            <div class="review-inner">
                                @forelse ($comments as $comment)
                                <div class="spr-review d-flex w-100">
                                    <div class="spr-review-profile flex-shrink-0">
                                        <img class="blur-up lazyload" data-src="{{ asset('storage/' . $comment->user->avatar) }}" src="{{ asset('storage/' . $comment->user->avatar) }}" alt="" width="80" height="80" />
                                    </div>
                                    <div class="spr-review-content flex-grow-1">
                                        <div class="d-flex justify-content-between flex-column mb-2">
                                            <div class="title-review d-flex align-items-center justify-content-between">
                                                <h5 class="spr-review-header-title text-transform-none mb-0">{{ $comment->user->fullname ?? 'Khách' }}</h5>
                                                <span class="product-review spr-starratings m-0">
                                                    <span class="reviewLink">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="icon anm {{ $i <= $comment->rating ? 'anm-star' : 'anm-star-o' }}"></i>
                                                            @endfor
                                                    </span>
                                                </span>
                                            </div>
                                            <span class="spr-review-header-byline">{{ $comment->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <p class="spr-review-body">{{ $comment->content }}</p>
                                    </div>
                                </div>
                                @empty
                                <p>Hãy là người đầu tiên để lại bình luận.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: REVIEW FORM --}}
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-4">
                        @auth
                        @if($hasPurchased && !$hasReviewed)
                        <form method="post" action="{{ route('client.comments.store') }}" id="commentForm" class="product-review-form new-review-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <h3 class="spr-form-title">Viết đánh giá của bạn</h3>
                            <p>Email của bạn sẽ không được công khai. Các trường bắt buộc được đánh dấu *</p>
                            <fieldset class="row spr-form-contact">
                                <div class="col-sm-6 spr-form-contact-name form-group">
                                    <label class="spr-form-label" for="nickname">Tên <span class="required">*</span></label>
                                    <input class="spr-form-input spr-form-input-text" id="nickname" type="text" value="{{ auth()->user()->fullname }}" readonly />
                                </div>
                                <div class="col-sm-6 spr-form-contact-email form-group">
                                    <label class="spr-form-label" for="email">Email <span class="required">*</span></label>
                                    <input class="spr-form-input spr-form-input-email" id="email" type="email" value="{{ auth()->user()->email }}" readonly />
                                </div>

                                <div class="col-12 spr-form-review-rating form-group">
                                    <label class="spr-form-label">Đánh giá của bạn <span class="required">*</span></label>
                                    <div class="rating-stars" id="formRatingStars">
                                        <input type="radio" id="star5" name="rating" value="5"><label for="star5"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4"><label for="star4"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3"><label for="star3"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2"><label for="star2"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1"><label for="star1"><i class="icon anm anm-star-o"></i></label>
                                    </div>
                                    @error('rating')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 spr-form-review-body form-group">
                                    <label class="spr-form-label" for="message">Nội dung đánh giá <span class="required">*</span></label>
                                    <div class="spr-form-input">
                                        <textarea class="spr-form-input spr-form-input-textarea" id="message" name="content" rows="3"></textarea>
                                    </div>
                                    @error('content')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </fieldset>
                            <div class="spr-form-actions clearfix">
                                <input type="submit" class="btn btn-primary spr-button spr-button-primary" value="Gửi đánh giá" />
                            </div>
                        </form>
                        @elseif(!$hasPurchased)
                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <span>Bạn cần mua hàng để đánh giá sản phẩm này.</span>
                        </div>
                        @else
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <span>Bạn đã đánh giá sản phẩm này rồi.</span>
                        </div>
                        @endif


                        @else
                        <div class="text-center p-4 border rounded">
                            <h4 class="mb-3">Viết đánh giá</h4>
                            <p>Vui lòng <a href="{{ route('login') }}" class="fw-bold text-primary">Đăng nhập</a> để viết đánh giá.</p>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================================================================= --}}
{{-- RELATED PRODUCTS                             --}}
{{-- ================================================================= --}}
<section class="section product-slider pb-0">
    <div class="container">
        <div class="section-header">
            <p class="mb-1 mt-0">Discover Similar</p>
            <h2>Sản phẩm liên quan</h2>
        </div>

        <div class="product-slider-4items gp10 arwOut5 grid-products mb-5">
            @foreach($relatedProducts as $relatedProduct)
            <div class="item col-item">
                <div class="product-box">
                    <div class="product-image">
                        <a href="{{ route('client.products.show', $relatedProduct->slug) }}" class="product-img rounded-0"><img class="rounded-0 blur-up lazyload" src="{{ asset($relatedProduct->image) }}" alt="Product" title="Product" width="625" height="808" /></a>
                    </div>
                    <div class="product-details text-left text-center">
                        <div class="product-name">
                            <a href="{{ route('client.products.show', $relatedProduct->slug) }}" class="text-decoration-none text-primary fw-bold fw-semibold fs-6">{{ $relatedProduct->name }}</a>
                        </div>
                        <div class="product-price">
                            <span class="price text-danger fw-bold fs-5">{{ number_format($relatedProduct->price, 0, ',', '.') }} ₫</span>
                            <div>
                                <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="icon anm anm-eye"> </i> Xem chi tiết
                                </a>
                            </div>
                        </div>

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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle color swatch selection to show color name
        const radios = document.querySelectorAll('input[name="color_id"]');
        const selectedName = document.getElementById('selectedColorName');
        if (radios.length > 0) {
            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const name = this.getAttribute('data-color-name');
                    selectedName.textContent = name;
                });
            });
        }

        // Set background color for swatches
        document.querySelectorAll('.color-swatch').forEach(function(el) {
            const color = el.getAttribute('data-color-code');
            if (color) {
                el.style.backgroundColor = `${color}`;
            }
        });

        // Wishlist toggle functionality
        document.querySelectorAll('.wishlist-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                const token = '{{ csrf_token() }}';
                const icon = this.querySelector('i');
                const span = this.querySelector('span');

                fetch("{{ route('wishlist.toggle') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            window.location.href = "{{ route('login') }}";
                            return;
                        }

                        if (data.status === 'added') {
                            icon.classList.add('text-danger');
                            this.setAttribute('title', 'Bỏ yêu thích');
                            if (span) span.textContent = 'Đã yêu thích';
                        } else {
                            icon.classList.remove('text-danger');
                            this.setAttribute('title', 'Thêm vào yêu thích');
                            if (span) span.textContent = 'Thêm vào yêu thích';
                        }

                        const wishlistCountEl = document.querySelector('.wishlist-count');
                        if (wishlistCountEl) {
                            wishlistCountEl.textContent = data.count;
                        }
                    });
            });
        });
    });
</script>
<script>
    function changeMainImage(el) {
        const mainImg = document.getElementById('main-image');
        mainImg.src = el.src;
    }
</script>
<style>
    .quantity-wrapper {
        background: #f8f9fa;
        height: 40px;
    }

    .qty-btn {
        background-color: transparent;
        color: #333;
        font-size: 16px;
        transition: background-color 0.2s ease;
    }

    .qty-btn:hover {
        background-color: #e2e6ea;
    }

    .qty-input {
        pointer-events: none;
        /* Tắt tương tác chuột */
        background-color: #fff;
    }


    /* css size */
    .size-btn {
        border: 2px solid #ccc;
        background-color: #fff;
        color: #333;
        padding: 0.6rem 1rem;
        font-weight: 600;
        border-radius: 8px;
        margin: 0.25rem;
        cursor: pointer;
        transition: all 0.2s ease;
        min-width: 48px;
        text-align: center;
    }

    .size-btn:hover {
        border-color: #333;
        color: #000;
    }

    .size-btn.active {
        background-color: #000;
        color: #fff;
        border-color: #000;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    /* css color */
    .color-swatch {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        /* Bo góc nhẹ */
        border: 2px solid transparent;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .color-swatch:hover {
        opacity: 0.85;
        border-color: #999;
    }

    .btn-check:checked+.color-swatch {
        border-color: #000;
        box-shadow: 0 0 0 2px #00000010;
    }
</style>
<script>
    $(document).ready(function() {
        // Khi click size
        $('.size-btn').on('click', function() {
            // Bỏ active tất cả
            $('.size-btn').removeClass('active');

            // Đánh dấu size đang chọn
            $(this).addClass('active');

            // Gán vào input ẩn
            const sizeId = $(this).data('size-id');
            $('#selected-size-id').val(sizeId);
        });

        // Khi chọn màu
        $('input[name="color_id"]').on('change', function() {
            const selectedColorId = $(this).val();
            const selectedColorName = $(this).data('color-name');
            $('#selectedColorName').text(selectedColorName);

            // Reset size đang chọn
            $('.size-btn').removeClass('active');
            $('#selected-size-id').val('');

            // Ẩn tất cả
            $('.size-btn').addClass('d-none');

            // Hiện size đúng màu
            let hasSize = false;
            $('.size-btn').each(function() {
                if ($(this).data('color-id') == selectedColorId) {
                    $(this).removeClass('d-none');
                    hasSize = true;
                }
            });

            // Hiện khối chọn size nếu có
            if (hasSize) {
                $('#size-wrapper').show();
            } else {
                $('#size-wrapper').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Khi chọn size
        $('.size-btn').on('click', function() {
            // Bỏ active
            $('.size-btn').removeClass('active');
            $(this).addClass('active');

            // Gán size_id
            const sizeId = $(this).data('size-id');
            $('#selected-size-id').val(sizeId);

            // Cập nhật ảnh & giá
            const price = $(this).data('price');
            const image = $(this).data('image');

            $('#variant-price').text(
                new Intl.NumberFormat('vi-VN').format(price) + ' ₫'
            );
            $('#main-image').attr('src', image);
        });

        // Khi chọn màu
        $('input[name="color_id"]').on('change', function() {
            const selectedColorId = $(this).val();
            const selectedColorName = $(this).data('color-name');
            $('#selectedColorName').text(selectedColorName);

            $('.size-btn').removeClass('active d-none');
            $('#selected-size-id').val('');
            $('#size-wrapper').hide();

            let hasSize = false;
            $('.size-btn').each(function() {
                if ($(this).data('color-id') == selectedColorId) {
                    $(this).removeClass('d-none');
                    hasSize = true;
                } else {
                    $(this).addClass('d-none');
                }
            });

            if (hasSize) {
                $('#size-wrapper').show();
            }
        });

        // Nếu có sẵn màu khi load trang thì cập nhật lại giao diện
        const checkedColor = $('input[name="color_id"]:checked');
        if (checkedColor.length) {
            checkedColor.trigger('change');
        }
    });
</script>

<script>
    $(document).ready(function() {
        let maxQty = 1;

        // Khi chọn size
        $('.size-btn').on('click', function() {
            $('.size-btn').removeClass('active');
            $(this).addClass('active');

            const sizeId = $(this).data('size-id');
            const quantity = parseInt($(this).data('variant-quantity')) || 1;

            $('#selected-size-id').val(sizeId);
            $('#quantity-input').val(1);
            maxQty = quantity;
        });

        // Tăng số lượng
        $('.quantity-plus').on('click', function() {
            let current = parseInt($('#quantity-input').val());
            if (current < maxQty) {
                $('#quantity-input').val(current + 1);
            }
        });

        // Giảm số lượng
        $('.quantity-minus').on('click', function() {
            let current = parseInt($('#quantity-input').val());
            if (current > 1) {
                $('#quantity-input').val(current - 1);
            }
        });
        $('.size-btn').on('click', function() {
            $('.size-btn').removeClass('active');
            $(this).addClass('active');

            const sizeId = $(this).data('size-id');
            const variantQty = parseInt($(this).data('variant-quantity')) || 0;
            $('#selected-size-id').val(sizeId);

            // Cập nhật số lượng tồn kho và hiển thị
            $('#stock-quantity').text(variantQty);
            $('#stock-info').show();

            // Reset số lượng input về 1
            $('#quantity-input').val(1);
            maxQty = variantQty;
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const timers = document.querySelectorAll('.countdown-timer');

        timers.forEach(timer => {
            const endTimestamp = parseInt(timer.getAttribute('data-deal-end'));
            const timeSpan = timer.querySelector('.time-remaining');

            function updateCountdown() {
                const now = Date.now();
                const distance = endTimestamp - now;

                if (distance <= 0) {
                    timeSpan.innerText = "Đã hết hạn";
                    return;
                }

                const totalSeconds = Math.floor(distance / 1000);
                const days = Math.floor(totalSeconds / (3600 * 24));
                const hours = Math.floor((totalSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                let timeText = '';

                if (days > 0) {
                    timeText += `${days} ngày `;
                }

                timeText += `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                timeSpan.innerText = timeText;
            }

            updateCountdown();
            const interval = setInterval(() => {
                updateCountdown();
                if (Date.now() >= endTimestamp) clearInterval(interval);
            }, 1000);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('commentForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn reload trang

            // Xóa lỗi cũ
            document.querySelectorAll('.text-danger').forEach(el => el.remove());

            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        $.toast({
                            heading: 'Thành công!',
                            text: 'Gửi đánh giá thành công!',
                            showHideTransition: 'slide',
                            icon: 'success',
                            position: {
                                right: 1,
                                top: 83
                            },
                        });
                        location.reload();
                    } else if (data.errors) {
                        // Hiển thị lỗi dưới từng trường
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const fieldElement = form.querySelector(`[name="${field}"]`);
                            if (fieldElement) {
                                const errorDiv = document.createElement('div');
                                errorDiv.classList.add('text-danger', 'mt-1');
                                errorDiv.textContent = messages[0];
                                fieldElement.closest('.form-group').appendChild(errorDiv);
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Lỗi gửi đánh giá:', error);
                });
        });
    });
</script>


{{-- Nếu số lượng bằng 0 ➜ disable 2 nút. --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sizeButtons = document.querySelectorAll('.size-btn');
        const stockInfo = document.getElementById('stock-info');
        const stockQuantityEl = document.getElementById('stock-quantity');
        const addToCartBtn = document.getElementById('add-to-cart-btn');
        const buyNowBtn = document.querySelector('.proceed-to-checkout');
        const outOfStockMsg = document.getElementById('out-of-stock-message');

        sizeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const quantity = parseInt(this.dataset.variantQuantity);
                const sizeId = this.dataset.sizeId;

                document.getElementById('selected-size-id').value = sizeId;
                stockQuantityEl.textContent = quantity;
                stockInfo.style.display = 'flex';

                sizeButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                if (quantity <= 0) {
                    addToCartBtn.disabled = true;
                    buyNowBtn.disabled = true;
                    addToCartBtn.classList.add('disabled');
                    buyNowBtn.classList.add('disabled');
                    outOfStockMsg.style.display = 'block';
                } else {
                    addToCartBtn.disabled = false;
                    buyNowBtn.disabled = false;
                    addToCartBtn.classList.remove('disabled');
                    buyNowBtn.classList.remove('disabled');
                    outOfStockMsg.style.display = 'none';
                }
            });
        });
    });
</script>


@endsection
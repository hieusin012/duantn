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
        direction: rtl; /* Right-to-left to handle hover effect correctly */
    }

    .rating-stars input[type="radio"] {
        display: none; /* Hide the actual radio buttons */
    }

    .rating-stars label {
        font-size: 24px;
        color: #ccc;
        cursor: pointer;
        padding: 0 2px;
    }
    
    /* Change color on hover and for checked stars */
    .rating-stars label:hover,
    .rating-stars label:hover ~ label,
    .rating-stars input[type="radio"]:checked ~ label {
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
    padding: 2.5rem; /* Tăng padding cho tất cả các tab */
}
</style>
@endpush

@section('content')
<div id="page-content">
    {{-- ================================================================= --}}
    {{--                      HEADER & BREADCRUMBS                         --}}
    {{-- ================================================================= --}}
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
                {{-- ================================================================= --}}
                {{--                         PRODUCT IMAGES                            --}}
                {{-- ================================================================= --}}
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
                                <div class="zoompro-span"><img id="zoompro" class="zoompro rounded-0 img-thumbnail rounded shadow" src="{{ asset($product->image) }}" data-zoom-image="{{ asset($product->image) }}" alt="product" width="625" height="808" /></div>
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
                {{--                         PRODUCT INFO & FORM                         --}}
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
                        <div class="product-price d-flex-center my-3">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <div class="sort-description mb-3">{{ $product->description ?? 'Sản phẩm chất lượng cao từ thương hiệu uy tín.' }}</div>
                    </div>

                    <form method="post" action="{{ route('client.cart.add') }}" id="add-to-cart-form" class="product-form product-form-border hidedropdown">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="product-swatches-option">
                            <div class="product-item swatches-image w-100 mb-4 swatch-0 option1" data-option-index="0">
                                <label class="form-label d-block">Chọn màu: <strong id="selectedColorName">Chưa chọn</strong></label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($colors as $color)
                                    <input type="radio" class="btn-check" name="color_id" id="color-{{ $color->id }}" value="{{ $color->id }}" autocomplete="off" data-color-name="{{ $color->name }}">
                                    <label class="btn border p-2 color-swatch" for="color-{{ $color->id }}" data-color-code="{{ $color->color_code }}" title="{{ $color->name }}"></label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="product-item swatches-size w-100 mb-4 swatch-1 option2" data-option-index="1">
                                <label class="form-label">Chọn size:</label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($sizes as $size)
                                    <input type="radio" class="btn-check" name="size_id" id="size-{{ $size->id }}" value="{{ $size->id }}" autocomplete="off">
                                    <label class="btn btn-outline-warning" for="size-{{ $size->id }}">{{ $size->name }}</label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="product-action w-100 d-flex-wrap my-3 my-md-4">
                            <div class="product-form-quantity d-flex-center">
                                <div class="input-group input-group-sm w-auto">
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">–</button>
                                    <input type="number" name="quantity" value="1" min="1" class="form-control text-center" style="max-width: 80px;" />
                                    <button class="btn btn-outline-secondary" type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                                </div>
                            </div>
                            <div class="product-form-submit addcart fl-1 ms-3">
                                <button type="submit" id="add-to-cart-btn" class="btn btn-primary">Thêm vào giỏ hàng</button>
                            </div>
                            <div class="product-form-submit buyit fl-1 ms-3">
                                <button type="submit" class="btn btn-primary proceed-to-checkout"><span>Mua ngay</span></button>
                            </div>
                        </div>
                    </form>

                    <p class="infolinks d-flex-center justify-content-between">
                        <a href="javascript:void(0);" class="text-link wishlist wishlist-toggle" data-id="{{ $product->id }}" data-bs-toggle="tooltip" title="{{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' }}">
                            <i class="icon anm anm-heart {{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'text-danger' : '' }} me-1"></i>
                            <span>{{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'Đã yêu thích' : 'Thêm vào yêu thích' }}</span>
                        </a>
                    </p>

                    <div class="product-info">
                        <p class="product-stock d-flex">Trạng thái:
                            <span class="d-flex-center stockLbl text-uppercase {{ $product->is_active ? 'instock' : 'outofstock' }}">
                                {{ $product->is_active ? 'Còn hàng' : 'Hết hàng' }}
                            </span>
                        </p>
                        <p class="product-vendor">Thương hiệu:<span class="text"><a href="#">{{ $product->brand->name }}</a></span></p>
                        <p class="product-type">Danh mục:<span class="text">{{ $product->category->name }}</span></p>
                        <p class="product-sku">Mã sản phẩm:<span class="text">{{ $product->code }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================= --}}
    {{--                         TABS SECTION                              --}}
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
                    <li>Miễn phí vận chuyển cho đơn hàng từ 500.000 VNĐ.</li>
                    <li>Thời gian giao hàng toàn quốc - 2-5 ngày làm việc</li>
                    <li>Có thể thanh toán khi nhận hàng (COD)</li>
                    <li>Chính sách đổi trả dễ dàng trong 30 ngày</li>
                </ul>
            </div>
            
            {{-- ============================================================= --}}
            {{--                     DYNAMIC REVIEWS TAB                         --}}
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
                                        </div>
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
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{ $ratingPercentages[$i] ?? 0 }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $ratingPercentages[$i] ?? 0 }}%;"></div>
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
                                        <img class="blur-up lazyload" data-src="{{ asset('assets/images/users/default-avatar.jpg') }}" src="{{ asset('assets/images/users/default-avatar.jpg') }}" alt="" width="80" height="80" />
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
                        <form method="post" action="{{ route('client.comments.store') }}" class="product-review-form new-review-form">
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
                                    <label class="spr-form-label">Đánh giá của bạn *</label>
                                    <div class="rating-stars" id="formRatingStars">
                                        <input type="radio" id="star5" name="rating" value="5" required><label for="star5"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star4" name="rating" value="4"><label for="star4"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star3" name="rating" value="3"><label for="star3"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star2" name="rating" value="2"><label for="star2"><i class="icon anm anm-star-o"></i></label>
                                        <input type="radio" id="star1" name="rating" value="1"><label for="star1"><i class="icon anm anm-star-o"></i></label>
                                    </div>
                                </div>
                                <div class="col-12 spr-form-review-body form-group">
                                    <label class="spr-form-label" for="message">Nội dung đánh giá *</label>
                                    <div class="spr-form-input">
                                        <textarea class="spr-form-input spr-form-input-textarea" id="message" name="content" rows="3" required></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="spr-form-actions clearfix">
                                <input type="submit" class="btn btn-primary spr-button spr-button-primary" value="Gửi đánh giá" />
                            </div>
                        </form>
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
{{--                      RELATED PRODUCTS                             --}}
{{-- ================================================================= --}}
<section class="section product-slider pb-0">
    <div class="container">
        <div class="section-header">
            <p class="mb-1 mt-0">Discover Similar</p>
            <h2>Sản phẩm liên quan</h2>
        </div>

        <div class="product-slider-4items gp10 arwOut5 grid-products">
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
                            <span class="price text-danger fw-bold fs-5">{{ number_format($relatedProduct->price, 0, ',', '.') }} VNĐ</span>
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
            button.addEventListener('click', function () {
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
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.error) {
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
@endsection
@extends('clients.layouts.master')

@section('banner')
@include('clients.banner')
@endsection

@section('title', 'Trang Chủ')

@push('scripts')
<script>
    $(document).ready(function() {
        $('.home-slideshow').slick({
            dots: true,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 1000,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });

    document.addEventListener('scroll', function() {
        const header = document.querySelector('.header');
        if (window.scrollY > 10) {
            header.classList.add('shadow-on-scroll');
        } else {
            header.classList.remove('shadow-on-scroll');
        }
    });
</script>
@endpush
@push('styles')
<style>
    .category-card {
        transition: all 0.3s ease-in-out;
        padding: 15px;
        border-radius: 12px;
        background-color: #fff;
        box-shadow: 0 7px 15px rgba(0, 0, 0, 0.05);
        /* bóng nhẹ mặc định */
        border: 0.2px solid grey;
    }

    .category-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        /* bóng đậm hơn khi hover */
        background-color: #f9f9f9;
    }

    .category-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

    /* css bài viết */
    .card-img-top:hover {
        transform: scale(1.03);
        border-radius: 12px 12px 0 0;
    }

    /* slide */
    .home-slideshow {
        max-width: 100%;
        overflow: hidden;
    }

    .home-slideshow img {
        width: 100%;
        height: auto;
        border-radius: 6px;
    }

    .slideshow-img {
        width: 100%;
        height: 480px;
        object-fit: cover;
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .slideshow-img {
            height: 240px;
        }
    }

    .badge-new-ribbon {
        position: absolute;
        top: 10px;
        left: -40px;
        background: #e60023;
        color: white;
        padding: 5px 50px;
        font-size: 13px;
        font-weight: bold;
        transform: rotate(-45deg);
        z-index: 10;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        text-align: center;
        pointer-events: none;
    }

    .slide {
        height: 595px;
        overflow: hidden;
        position: relative;
    }

    .slideshow-img {
        width: 100%;
        height: 595px;
        object-fit: cover;
        border-radius: 12px;
    }

</style>


@endpush

@section('content')
<!-- Slideshow, sản phẩm, nội dung trang chủ -->
<div class="container py-4 mt-4">
    <div>
        <h1 class="mb-4 text-center fs-3">DANH MỤC SẢN PHẨM</h1>

        <div class="row justify-content-center">
            @foreach($category as $categories)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-4 d-flex justify-content-center">
                <a href="{{ route('products.byCategory', $categories->slug) }}" class="text-decoration-none text-dark category-card text-center">
                    <img src="{{ Storage::url($categories->image) }}" class="img-fluid rounded shadow-sm mb-2 category-image" alt="{{ $categories->name }}">
                    <p class="mb-0 fw-medium">{{ $categories->name }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <div class="mt-4">
        <h2 class="text-center mb-4 fs-3 fw-bold border-bottom pb-2 d-inline-block">
            SẢN PHẨM MỚI NHẤT
        </h2>
        <div class="product-slider-4items gp10 arwOut5 grid-products">
            @foreach ($products as $product)
            <div class="col-md-3 col-6 mb-4">
                <div class="product-box card border-0 bg-light rounded-3 shadow-sm position-relative overflow-hidden h-100">

                    <!-- Product Image -->
                    <div class="product-image position-relative">
                        <!-- NEW Badge -->
                        @if(\Carbon\Carbon::parse($product->created_at)->diffInDays(now()) <= 7)
                            <div class="badge-new-ribbon">NEW
                    </div>
                    @endif

                    <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}">
                        <img src="{{ asset($product->image ?? 'assets/images/placeholder.jpg') }}"
                            class="card-img-top blur-up lazyloaded"
                            alt="{{ $product->name }}"
                            width="625" height="808">
                    </a>

                    <!-- Hover Buttons -->
                    <div class="button-set style1">
                        <a href="#" class="btn-icon quickview" data-bs-toggle="tooltip" title="Quick View">
                            <i class="icon anm anm-search-plus-l"></i>
                        </a>
                        <a href="javascript:void(0);" class="btn-icon wishlist-toggle"
                            data-id="{{ $product->id }}"
                            data-bs-toggle="tooltip"
                            title="{{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' }}">
                            <i class="icon anm anm-heart {{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'text-danger' : '' }}"></i>
                        </a>
                        <a href="#" class="btn-icon compare" data-bs-toggle="tooltip" title="Add to Compare">
                            <i class="icon anm anm-random-r"></i>
                        </a>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}"
                            class="text-decoration-none text-primary fw-bold">
                            {{ $product->name }}
                        </a>
                    </h5>

                    <!-- Rating -->
                    <div class="product-review mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="icon anm {{ $i <= ($product->average_rating ?? 4) ? 'anm-star' : 'anm-star-o' }}"></i>
                            @endfor
                            <span class="caption hidden ms-1">{{ $product->reviews_count ?? 0 }} đánh giá</span>
                    </div>

                    <!-- Price -->
                    <p class="card-text fw-bold text-danger fs-5">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                    </p>

                    <!-- Xem chi tiết -->
                    <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}"
                        class="btn btn-primary btn-sm">
                        <i class="icon anm anm-eye"> </i> Xem chi tiết
                    </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>
{{-- @if(isset($banners) && !$banners->isEmpty())
<div class="home-slideshow slick-arrow-dots">
    Lặp qua từng banner
    @foreach($banners as $banner)
    <div class="slide">
        Bọc ảnh trong thẻ <a> với link của banner
        <a href="{{ $banner->link ?? '#' }}" target="_blank">
            <img class="blur-up lazyload slideshow-img" 
                 src="{{ asset('storage/' . $banner->image) }}" 
                 alt="{{ $banner->title }}" 
                 title="{{ $banner->title }}" />
        </a>
    </div>
    @endforeach
</div>
@endif --}}
<div class="container py-5">
    <h2 class="text-center mb-4 fs-3 fw-bold border-bottom pb-2 d-inline-block">
        TIN TỨC THỂ THAO & KHUYẾN MÃI
    </h2>
    <div class="row">
        @foreach ($blogs as $blog)
        <div class="col-md-4 col-12 mb-4">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <a href="{{ route('client.blogs.show', $blog->slug) }}">
                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top rounded-top-4" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover; transition: transform 0.3s;">
                </a>
                <div class="card-body px-4 py-3">
                    <h5 class="card-title fw-semibold fs-5 mb-2">
                        <a href="{{ route('client.blogs.show', $blog->slug) }}" class="text-decoration-none text-dark">
                            {{ $blog->title }}
                        </a>
                    </h5>
                    <p class="text-secondary small">{{ Str::limit($blog->content, 80) }}</p>
                    <p class="text-muted small mb-3">
                        {{ $blog->created_at->format('d/m/Y') }}
                    </p>
                    <a href="{{ route('client.blogs.show', $blog->slug) }}" class="btn btn-primary btn-sm rounded-pill px-3">
                        Xem chi tiết
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Kích hoạt tooltip lần đầu
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(el) {
            return new bootstrap.Tooltip(el);
        });
        //
        // Wishlist toggle
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
                        // Cập nhật giao diện
                        if (data.status === 'added') {
                            icon.classList.add('text-danger');
                            if (span) span.textContent = 'Đã yêu thích';
                            this.setAttribute('title', 'Bỏ yêu thích');
                        } else {
                            icon.classList.remove('text-danger');
                            if (span) span.textContent = 'Thêm vào yêu thích';
                            this.setAttribute('title', 'Thêm vào yêu thích');
                        }

                        // Cập nhật tooltip mới
                        bootstrap.Tooltip.getInstance(this)?.dispose(); // Xóa tooltip cũ
                        new bootstrap.Tooltip(this); // Tạo lại tooltip

                        // Cập nhật số lượng
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
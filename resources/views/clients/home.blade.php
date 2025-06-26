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

    document.addEventListener('scroll', function () {
        const header = document.querySelector('.header');
        if (window.scrollY > 10) {
            header.classList.add('shadow-on-scroll');
        } else {
            header.classList.remove('shadow-on-scroll');
        }
    });
</script>
@endpush

@section('content')
    <!-- Slideshow, sản phẩm, nội dung trang chủ -->
<div class="container py-4">
    <h2 class="text-center mb-4">Sản phẩm mới nhất</h2>
    <div class="row">
        @foreach ($products as $product)
        <div class="item col-md-3 col-6 mb-4">
            <div class="product-box position-relative">
                <!-- Product Image -->
                <div class="product-image">
                    <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}">
                        <img class="blur-up lazyloaded"
                            src="{{ asset($product->image ?? 'assets/images/placeholder.jpg') }}"
                            alt="{{ $product->name }}" width="625" height="808">
                    </a>
                    <!-- Hover Buttons -->
                    <div class="button-set style1">
                        <a href="#" class="btn-icon quickview" data-bs-toggle="tooltip" title="Quick View">
                            <i class="icon anm anm-search-plus-l"></i>
                        </a>
                        <a href="javascript:void(0);" 
                           class="btn-icon wishlist-toggle" 
                           data-id="{{ $product->id }}" 
                           data-bs-toggle="tooltip" 
                           title="Add to Wishlist">
                            <i class="icon anm anm-heart {{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'text-danger' : '' }}"></i>
                        </a>
                        <a href="#" class="btn-icon compare" data-bs-toggle="tooltip" title="Add to Compare">
                            <i class="icon anm anm-random-r"></i>
                        </a>
                    </div>
                </div>
                <!-- Product Details -->
                <div class="product-details text-center">
                    <div class="product-name">
                        <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}" 
                           class="text-decoration-none text-primary fw-bold fw-semibold fs-6">
                            {{ $product->name }}
                        </a>
                    </div>
                    <div class="product-review">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="icon anm {{ $i <= ($product->rating ?? 4) ? 'anm-star' : 'anm-star-o' }}"></i>
                        @endfor
                        <span class="caption hidden ms-1">{{ $product->reviews_count ?? 3 }} Reviews</span>
                    </div>
                    <div class="product-price mb-1">
                        <span class="price text-danger fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection

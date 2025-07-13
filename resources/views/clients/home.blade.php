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
                        @php
                        // Làm tròn số sao đến 0.5 gần nhất để hiển thị half-star nếu muốn
                        // Hoặc chỉ cần làm tròn số nguyên: $rating = round($product->average_rating);
                        $rating = $product->average_rating;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="icon anm {{ $i <= $rating ? 'anm-star' : 'anm-star-o' }}"></i>
                            @endfor
                            <span class="caption hidden ms-1">{{ $product->reviews_count }} Reviews</span>
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
<div class="container py-4">
    <h2 class="text-center mb-4">Bài viết mới nhất</h2>
    <div class="row">
        @foreach ($blogs as $blog)
        <div class="col-md-4 col-12 mb-4">
            <div class="card h-100 shadow-sm border-0">
                <a href="{{ route('client.blogs.show', $blog->slug) }}">
                    <img src="{{ asset('storage/' . $blog->image) }}" class="card-img-top" alt="{{ $blog->title }}" style="height: 200px; object-fit: cover;">
                </a>
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        <a href="{{ route('client.blogs.show', $blog->slug) }}" class="text-decoration-none text-dark">
                            {{ $blog->title }}
                        </a>
                    </h5>
                    <p class="text-muted mb-2">
                        {{ $blog->created_at->format('d/m/Y') }}
                    </p>
                    <a href="{{ route('client.blogs.show', $blog->slug) }}" class="btn btn-outline-primary btn-sm">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
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
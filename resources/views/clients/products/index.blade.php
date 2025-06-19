@extends('clients.layouts.master')

@section('content')
<div class="container py-4">
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
                            <a href="#" class="btn-icon addtocart" data-bs-toggle="tooltip" title="Add to Cart">
                                <i class="icon anm anm-cart-l"></i>
                            </a>
                            <a href="#" class="btn-icon quickview" data-bs-toggle="tooltip" title="Quick View">
                                <i class="icon anm anm-search-plus-l"></i>
                            </a>
                            <a href="#" class="btn-icon wishlist" data-bs-toggle="tooltip" title="Add to Wishlist">
                                <i class="icon anm anm-heart-l"></i>
                            </a>
                            <a href="#" class="btn-icon compare" data-bs-toggle="tooltip" title="Add to Compare">
                                <i class="icon anm anm-random-r"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="product-details">
                        <div class="product-name">
                            <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}">
                                {{ $product->name }}
                            </a>
                        </div>
                        <div class="product-price">
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="product-review">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="icon anm {{ $i <= ($product->rating ?? 4) ? 'anm-star' : 'anm-star-o' }}"></i>
                            @endfor
                            <span class="caption hidden ms-1">{{ $product->reviews_count ?? 3 }} Reviews</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection

<script>
    // Khi trang kết quả tìm kiếm load xong, reset form tìm kiếm
    window.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('search-form');
        if (form) {
            const inputs = form.querySelectorAll('input[type="text"], input[type="number"], select');
            inputs.forEach(input => {
                // Chỉ reset nếu không phải là input chọn từ lịch sử (ẩn)
                if (input.name !== '_token') {
                    input.value = '';
                }
            });
        }
    });
</script>

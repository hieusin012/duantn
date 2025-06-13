@extends('clients.layouts.master')

@section('content')
<div class="container py-4">
    <div class="row">
        @foreach ($products as $product)
            <div class="item col-md-3 col-6 mb-4">
                <div class="product-box position-relative">
                    <!-- Product Image -->
                    <div class="product-image">
                        <a href="{{ route('client.products.show', $product->id) }}" class="product-img rounded-3">
                            <img class="blur-up lazyloaded"
                                 src="{{ asset($product->image ?? 'assets/images/placeholder.jpg') }}"
                                 alt="{{ $product->name }}" width="625" height="808">
                        </a>

                        <!-- Sale Label -->
                        <!-- @if ($product->status === 1)
                            <div class="product-labels">
                                <span class="lbl on-sale">Sale</span>
                            </div>
                        @endif -->

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
                            <a href="{{ route('client.products.show', $product->id) }}">{{ $product->name }}</a>
                        </div>
                        <div class="product-price">
                            @if ($product->original_price > $product->price)
                                <span class="price old-price">{{ number_format($product->original_price, 0, ',', '.') }}đ</span>
                            @endif
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        </div>
                        <div class="product-review">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="icon anm {{ $i <= ($product->rating ?? 4) ? 'anm-star' : 'anm-star-o' }}"></i>
                            @endfor
                            <span class="caption hidden ms-1">{{ $product->reviews_count ?? 3 }} Reviews</span>
                        </div>

                        <!-- Color Swatches -->
                        <ul class="variants-clr swatches">
                            @foreach ($product->colors ?? [] as $color)
                                <li class="swatch medium radius">
                                    <span class="swatchLbl" data-bs-toggle="tooltip" title="{{ $color->name }}">
                                        <img src="{{ asset($color->image ?? 'assets/images/placeholder.jpg') }}" alt="{{ $color->name }}" width="625" height="808">
                                    </span>
                                </li>
                            @endforeach
                        </ul>
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

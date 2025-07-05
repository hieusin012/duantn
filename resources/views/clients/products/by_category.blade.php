@extends('clients.layouts.master')
@section('title', 'Danh mục: ' . $category->name)

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Danh mục: {{ $category->name }}</h2>

    @if ($products->count())
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-3 col-6 mb-4">
                    <div class="product-box card border-0 bg-light rounded-3 shadow-sm position-relative overflow-hidden h-100">

                        {{-- Product Image --}}
                        <div class="product-image position-relative">
                            <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}">
                                <img src="{{ asset($product->image ?? 'assets/images/placeholder.jpg') }}"
                                    class="card-img-top"
                                    alt="{{ $product->name }}">
                            </a>

                            {{-- Wishlist Icon --}}
                            <div class="button-set style1">
                                <a href="javascript:void(0);"
                                    class="btn-icon wishlist-toggle"
                                    data-id="{{ $product->id }}"
                                    data-bs-toggle="tooltip"
                                    title="{{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' }}">
                                    <i class="icon anm anm-heart {{ auth()->check() && $product->wishlists->where('user_id', auth()->id())->count() ? 'text-danger' : '' }}"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Product Info --}}
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>

                            {{-- Rating --}}
                            <div class="product-review mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="icon anm {{ $i <= ($product->average_rating ?? 4) ? 'anm-star' : 'anm-star-o' }}"></i>
                                @endfor
                                <span class="caption hidden ms-1">{{ $product->reviews_count ?? 0 }} đánh giá</span>
                            </div>

                            {{-- Price --}}
                            <p class="card-text fw-bold text-danger">{{ number_format($product->price, 0, ',', '.') }} VND</p>

                            {{-- Add to Cart --}}
                            <form method="POST" action="{{ route('client.cart.add') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="btn btn-primary btn-sm">
                                    <i class="icon anm anm-cart-l me-1"></i> Thêm vào giỏ hàng
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">Chưa có sản phẩm nào trong danh mục này.</div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.wishlist-toggle').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.id;
                const token = '{{ csrf_token() }}';
                const icon = this.querySelector('i');

                fetch("{{ route('wishlist.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'added') {
                        icon.classList.add('text-danger');
                        this.setAttribute('title', 'Bỏ yêu thích');
                    } else {
                        icon.classList.remove('text-danger');
                        this.setAttribute('title', 'Thêm vào yêu thích');
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

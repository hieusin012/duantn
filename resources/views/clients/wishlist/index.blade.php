@extends('clients.layouts.master')

@section('content')
<div class="container py-4">
    <h3 class="text-center mb-4">Danh sách sản phẩm yêu thích</h3>

    @if($wishlists->count())
        <div class="row">
            @foreach($wishlists as $item)
                <div class="col-md-3 col-6 mb-4">
                    <div class="product-box card border-0 bg-light rounded-3 shadow-sm position-relative overflow-hidden h-100">
                        {{-- Product Image + Hover Icons --}}
                        <div class="product-image position-relative">
                            <a href="{{ route('client.products.show', ['slug' => $item->product->slug]) }}">
                                <img src="{{ asset($item->product->image ?? 'assets/images/placeholder.jpg') }}"
                                    class="card-img-top"
                                    alt="{{ $item->product->name }}">
                            </a>

                            <div class="button-set style1">
                                <a href="javascript:void(0);"
                                    class="btn-icon wishlist-toggle"
                                    data-id="{{ $item->product->id }}"
                                    data-bs-toggle="tooltip"
                                    title="{{ auth()->check() && $item->product->wishlists->where('user_id', auth()->id())->count() ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' }}">
                                    <i class="icon anm anm-heart {{ auth()->check() && $item->product->wishlists->where('user_id', auth()->id())->count() ? 'text-danger' : '' }}"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Product Details --}}
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $item->product->name }}</h5>

                            {{-- Rating + Review --}}
                            <div class="product-review mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="icon anm {{ $i <= ($item->product->rating ?? 4) ? 'anm-star' : 'anm-star-o' }}"></i>
                                @endfor
                                <span class="caption hidden ms-1">{{ $item->product->reviews_count ?? 3 }} đánh giá</span>
                            </div>

                            {{-- Price --}}
                            <p class="card-text fw-bold text-danger">{{ number_format($item->product->price, 0, ',', '.') }} VND</p>

                            {{-- Add to Cart --}}
                            <form method="POST" action="{{ route('client.cart.add') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                <button class="btn btn-primary btn-sm">
                                    <i class="icon anm anm-cart-l me-1"></i> Thêm vào giỏ hàng
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">Bạn chưa có sản phẩm yêu thích nào.</p>
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
                    icon.classList.remove('anm-heart-l');
                    icon.classList.add('anm-heart', 'text-danger');
                    this.setAttribute('title', 'Bỏ yêu thích');
                } else {
                    icon.classList.remove('anm-heart', 'text-danger');
                    icon.classList.add('anm-heart-l');
                    this.setAttribute('title', 'Thêm vào yêu thích');
                    this.closest('.col-md-3')?.remove();
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

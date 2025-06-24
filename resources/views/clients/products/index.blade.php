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
                        <a href="#" class="btn-icon quickview" data-bs-toggle="tooltip" title="Quick View">
                            <i class="icon anm anm-search-plus-l"></i>
                        </a>
                        {{-- <a href="#" class="btn-icon wishlist" data-bs-toggle="tooltip" title="Add to Wishlist">
                            <i class="icon anm anm-heart-l"></i>
                        </a> --}}
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
                        <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}" class="text-decoration-none text-primary fw-bold fw-semibold fs-6">
                            {{ $product->name }}
                        </a>
                    </div>
                    <div class="product-review">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="icon anm {{ $i <= ($product->rating ?? 4) ? 'anm-star' : 'anm-star-o' }}"></i>
                            @endfor
                            <span class="caption hidden ms-1">{{ $product->reviews_count ?? 3 }} Reviews</span>
                    </div>
                    <div class=" product-price mb-1 ">
                        <span class="price text-danger fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
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
@section('scripts')
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
                .then(response => response.json())
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


{{-- Gộp lại script --}}

{{-- @section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Reset tìm kiếm khi trang load
        const form = document.getElementById('search-form');
        if (form) {
            const inputs = form.querySelectorAll('input[type="text"], input[type="number"], select');
            inputs.forEach(input => {
                if (input.name !== '_token') {
                    input.value = '';
                }
            });
        }

        // Wishlist toggle
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
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'added') {
                        icon.classList.add('text-danger');
                    } else {
                        icon.classList.remove('text-danger');
                    }
                });
            });
        });
    });
</script>
@endsection --}}


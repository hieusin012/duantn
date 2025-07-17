@extends('clients.layouts.master')

@section('content')
<div class="page-header text-center">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h1>Sản phẩm</h1>
                </div>
                <div class="breadcrumbs">
                    <a href="{{ route('client.home') }}" title="Back to the home page">Home</a>
                    <span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Sản phẩm</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container py-4">
    <div class="text-center page-title mb-5">
        <form method="GET" action="{{ route('client.products.search') }}" class="row mb-4 gx-2">
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="0">-- Danh mục --</option>
                    @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control" placeholder="Giá từ" value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control" placeholder="Giá đến" value="{{ request('max_price') }}">
            </div>

            <div class="col-md-2">
                <select name="brand" class="form-select">
                    <option value="">-- Thương hiệu --</option>
                    @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <input type="text" name="search" class="form-control" placeholder="Từ khóa" value="{{ request('search') }}">
            </div>

            <div class="col-md-1 d-grid">
                <button type="submit" class="btn btn-primary">Lọc</button>
            </div>
        </form>

        <h1>Danh sách sản phẩm</h1>
    </div>
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
                        @php
                        $rating = $product->average_rating;
                        @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="icon anm {{ $i <= $rating ? 'anm-star' : 'anm-star-o' }}"></i>
                            @endfor
                            <span class="caption hidden ms-1">{{ $product->reviews_count }} Reviews</span>
                    </div>
                    <div class=" product-price mb-1 ">
                        <span class="price text-danger fw-bold fs-5">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
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
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.wishlist-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                const token = '{{ csrf_token() }}';
                const icon = this.querySelector('i');

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
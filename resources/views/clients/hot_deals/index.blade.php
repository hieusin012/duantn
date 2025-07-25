{{-- @extends('clients.layouts.master')

@section('title', 'Hot Deals')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center">🔥 Ưu đãi hot hiện tại</h2>

        @if ($hotDeals->count())
            <div class="row">
                @foreach ($hotDeals as $product)
                    <div class="col-md-3 col-6 mb-4">
                        <div class="product-box card border-0 bg-light rounded-3 shadow-sm position-relative overflow-hidden h-100">

                            Product Image
                            <div class="product-image position-relative">
                                <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}">
                                    <img src="{{ asset($product->image ?? 'assets/images/placeholder.jpg') }}"
                                        class="card-img-top"
                                        alt="{{ $product->name }}">
                                </a>
                            </div>

                            Product Info
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $product->name }}</h5>

                                Giá
                                <p class="mb-1">
                                    <del class="text-muted small">{{ number_format($product->price, 0, ',', '.') }}₫</del>
                                </p>
                                <p class="text-danger fw-bold mb-1">
                                    {{ number_format($product->price * (1 - $product->discount_percent / 100), 0, ',', '.') }}₫
                                </p>
                                <p class="mb-2 text-muted small">Giảm {{ $product->discount_percent }}%</p>

                                Hết hạn
                                <p class="text-secondary small mb-2">
                                    Hết hạn: {{ \Carbon\Carbon::parse($product->deal_end_at)->format('H:i d/m/Y') }}
                                </p>

                                Nút xem chi tiết
                                <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}" class="btn btn-primary btn-sm">
                                    <i class="icon anm anm-search-l me-1"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">Không có sản phẩm hot deal nào hiện tại.</div>
        @endif
    </div>
@endsection --}}
@extends('clients.layouts.master')

@section('title', 'Hot Deals')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center">🔥 Ưu đãi hot hiện tại</h2>

        @if ($hotDeals->count())
            <div class="row">
                @foreach ($hotDeals as $product)
                    @php
                        $price = $product->price ?? 0;
                        $discountPercent = $product->discount_percent ?? 0;
                        $dealEnd = $product->deal_end_at ?? null;

                        $isHotDeal = $product->is_hot_deal && $discountPercent > 0 && $dealEnd && \Carbon\Carbon::now()->lt($dealEnd);
                        $salePrice = $isHotDeal ? $price * (1 - $discountPercent / 100) : null;
                    @endphp

                    <div class="col-md-3 col-6 mb-4">
                        <div class="product-box card border-0 bg-light rounded-3 shadow-sm position-relative overflow-hidden h-100">

                            {{-- Product Image --}}
                            <div class="product-image position-relative">
                                <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}">
                                    <img src="{{ asset($product->image ?? 'assets/images/placeholder.jpg') }}"
                                        class="card-img-top"
                                        alt="{{ $product->name }}">
                                </a>
                            </div>

                            {{-- Product Info --}}
                            <div class="card-body text-center">
                                <h6 class="card-title mb-2">
                                    <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}"
                                       class="text-decoration-none text-dark">
                                        {{ $product->name }}
                                    </a>
                                </h6>

                                {{-- Giá --}}
                                @php
                                    $price = $product->price;
                                    $discountPercent = $product->discount_percent ?? 0;
                                    $salePrice = $price * (1 - $discountPercent / 100);
                                @endphp

                                <p class="mb-1">
                                    <del class="text-muted small">{{ number_format($price, 0, ',', '.') }}₫</del>
                                </p>
                                <p class="text-danger fw-bold mb-1 fs-6">
                                    {{ number_format($salePrice, 0, ',', '.') }}₫
                                </p>

                                {{-- Phần trăm giảm --}}
                                @if ($discountPercent)
                                    <p class="mb-1 text-muted small">Giảm {{ $discountPercent }}%</p>
                                @endif

                                {{-- Hết hạn --}}
                                <p class="mb-1">
                                    <span class="countdown-timer"
                                        data-deal-end="{{ \Carbon\Carbon::parse($product->deal_end_at)->timestamp * 1000 }}">
                                        <i class="bi bi-clock-fill me-1"></i><span class="time-remaining">--:--:--</span>
                                    </span>
                                </p>
                                {{-- Nút xem chi tiết --}}
                                <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="icon anm anm-search-l me-1"></i> Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">Không có sản phẩm hot deal nào hiện tại.</div>
        @endif
    </div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const timers = document.querySelectorAll('.countdown-timer');

        timers.forEach(timer => {
            const endTimestamp = parseInt(timer.getAttribute('data-deal-end'));
            const timeSpan = timer.querySelector('.time-remaining');

            function updateCountdown() {
                const now = Date.now(); // Mili giây hiện tại
                const distance = endTimestamp - now;

                if (distance <= 0) {
                    timeSpan.innerText = "Đã hết hạn";
                    return;
                }

                const totalSeconds = Math.floor(distance / 1000);
                const days = Math.floor(totalSeconds / (3600 * 24));
                const hours = Math.floor((totalSeconds % (3600 * 24)) / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                let timeText = '';

                if (days > 0) {
                    timeText += `${days} ngày `;
                }

                timeText += `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                timeSpan.innerText = timeText;
            }

            updateCountdown(); // Gọi lần đầu
            const interval = setInterval(() => {
                updateCountdown();

                if (Date.now() >= endTimestamp) {
                    clearInterval(interval);
                }
            }, 1000);
        });
    });
</script>
@endpush


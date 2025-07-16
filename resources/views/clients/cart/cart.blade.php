@extends('clients.layouts.master')
@section('title', 'Giỏ hàng')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<style>
    /* Ẩn mũi tên tăng giảm của input[type=number] */
    input[type="number"].no-spinner::-webkit-outer-spin-button,
    input[type="number"].no-spinner::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"].no-spinner {
        -moz-appearance: textfield;
        /* Firefox */
    }

    /* (Tuỳ chọn) Làm cho input tròn đẹp hơn nếu muốn */
    input.cart-qty-input.qty {
        border-left: none;
        border-right: none;
        font-size: 15px;
        padding-left: 0;
        padding-right: 0;
        margin-top: 5px;
    }

    .input-group.quantity-group {
        border: 1px solid #ccc;
        border-radius: 6px;
        overflow: hidden;
    }

    .input-group.quantity-group button {
        border: none;
        background: #fff;
        transition: background 0.2s;
    }

    .input-group.quantity-group button:hover {
        background: #f0f0f0;
    }

    .input-group.quantity-group input {
        border: none;
    }

    .cart-image a img {
        transition: transform 0.3s ease;

    }

    .cart-image a:hover img {
        transform: scale(1.05);
    }



    .ribbon {
        z-index: 2;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div id="page-content">
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title">
                        <h1>Trang giỏ hàng của bạn</h1>
                    </div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="{{ route('client.home') }}" title="Back to the home page">Home</a><span class="main-title"><i class="icon anm anm-angle-right-l"></i>Giỏ hàng của bạn</span></div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container">
        <div class="row">
            <!--Cart Content-->
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 main-col">
                <!--Cart Form-->
                <table class="table align-middle">
                    <thead class="cart-row cart-header small-hide position-relative">
                        <tr>
                            <th class="action"><input type="checkbox" id="select-all"></th>
                            <th colspan="2" class="text-start">Sản phẩm</th>
                            <th class="text-center">Giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Tổng tiền</th>
                            <th class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($cart && $cart->items->count())
                        @foreach ($cart->items as $item)
                        <tr class="align-middle">
                            <td class="text-center">
                                <input type="checkbox"
                                    name="selected[]"
                                    value="{{ $item->id }}"
                                    class="cart-checkbox"
                                    data-id="{{ $item->id }}"
                                    data-price="{{ $item->price_at_purchase * $item->quantity }}">
                            </td>

                            {{-- Ảnh sản phẩm --}}
                            <td class="text-center">
                                <a href="{{ route('client.products.show', ['slug' => $item->product->slug]) }}"
                                    class="d-inline-block border rounded overflow-hidden shadow-sm"
                                    style="width: 70px; height: 70px;">
                                    <img src="{{ $item->variant->image ? asset('storage/' . $item->variant->image) : asset('images/no-image.jpg') }}"
                                        alt="{{ $item->product->name }}"
                                        class="img-fluid w-100 h-100"
                                        style="object-fit: cover;">
                                </a>
                            </td>

                            {{-- Tên và thông tin --}}
                            <td class="cart-meta">
                                <strong>{{ $item->product->name }}</strong><br>
                                Màu: {{ $item->variant->color->name ?? '—' }},
                                Size: {{ $item->variant->size->name ?? '—' }}
                            </td>

                            {{-- Giá --}}
                            <td class="text-center">{{ number_format($item->price_at_purchase) }} ₫</td>

                            {{-- Số lượng --}}
                            <td class="text-center">
                                <form action="{{ route('client.cart.update') }}" method="post" class="d-inline-block">
                                    @csrf
                                    <div class="input-group quantity-group" style="max-width: 120px;">
                                        <button type="button" class="btn btn-outline-secondary btn-sm qtyBtn minus px-2">
                                            <i class="icon anm anm-minus-r"></i>
                                        </button>
                                        <input type="number"
                                            name="quantity[{{ $item->id }}]"
                                            class="form-control text-center cart-qty-input qty no-spinner"
                                            value="{{ $item->quantity }}"
                                            min="1"
                                            style="padding: 0.375rem 0; height: 32px;" readonly />
                                        <button type="button" class="btn btn-outline-secondary btn-sm qtyBtn plus px-2">
                                            <i class="icon anm anm-plus-r"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>

                            {{-- Tổng tiền --}}
                            <td class="text-center">{{ number_format($item->price_at_purchase * $item->quantity) }} ₫</td>

                            {{-- Xóa --}}
                            <td class="text-center">
                                <button type="button" onclick="document.getElementById('delete-form-{{ $item->id }}').submit();">
                                    <i class="icon anm anm-times-r"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="alert alert-info"><strong>Giỏ hàng của bạn đang trống!</strong></div>
                            </td>
                        </tr>
                        @endif
                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-start"><a href="{{ route('client.products.index') }}" class="btn btn-outline-secondary btn-sm cart-continue"><i class="icon anm anm-angle-left-r me-2 d-none"></i> Tiếp tục mua sắm</a></td>
                            <td colspan="3" class="text-end">
                                <a href="{{ route('client.cart.hasdelete') }}" class="btn btn-outline-secondary btn-sm cart-continue"><i class="icon anm anm-angle-left-r me-2 d-none"></i>Sản phẩm đã xóa</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                @if ($cart && $cart->items)
                @foreach ($cart->items as $item)
                <form id="delete-form-{{ $item->id }}" action="{{ route('client.cart.remove', $item->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach
                @endif

                <!--End Cart Form-->
                <!--Note with Shipping estimates-->
                <div class="row my-4 pt-3">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-12 cart-col">
                        <div class="cart-discount">
                            <h5>Mã giảm giá</h5>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Chọn hoặc nhập mã giảm giá
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Mã giảm giá</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Nhập mã ưu đãi" id="manualVoucherCode">
                                                <button class="btn btn-danger" id="btnApplyManual">ÁP DỤNG</button>
                                            </div>

                                            <!-- Danh sách voucher -->
                                            <form id="voucher-form">
                                                @foreach($voucher as $item)
                                                <div class="card mb-2 border rounded p-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h1 class="mb-1">
                                                                <strong>
                                                                    Voucher
                                                                    @if ($item->discount_type == 'percent')
                                                                    {{ number_format($item->discount, 0, ',', '.') }}%
                                                                    @else
                                                                    {{ number_format($item->discount/1000, 0, ',', '.') }}K
                                                                    @endif
                                                                </strong>

                                                            </h1>
                                                            <p class="mb-1"><b>Mã:</b> {{ $item->code }}</p>
                                                            <small><b>HSD:</b> {{ \Carbon\Carbon::parse($item->end_date)->format('Y-m-d') }}</small>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="selected_voucher" value="{{ $item->id }}" data-code="{{ $item->code }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

                                                <button type="button" class="btn btn-danger w-100" id="btnApplyRadio">ÁP DỤNG</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!--End Note with Shipping estimates-->
            </div>
            <!--End Cart Content-->


            <!--Cart Sidebar-->
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 cart-footer">
                <div class="cart-info sidebar-sticky">
                    <div class="cart-order-detail cart-col">
                        <div class="cart-order-detail cart-col">
                            {{-- Tổng tiền gốc chưa giảm --}}
                            <div class="row g-0 border-bottom pb-2">
                                <span class="col-6 cart-subtotal-title"><strong>Tổng tiền gốc</strong></span>
                                <span class="col-6 cart-subtotal-title cart-subtotal text-end">
                                    <span class="money" id="original-total" style="font-size: 20px;">0 ₫</span>
                                </span>
                            </div>

                            {{-- Mã giảm giá --}}
                            <div class="row g-0 border-bottom py-2">
                                <span class="col-6 cart-subtotal-title"><strong>Mã giảm giá</strong></span>
                                <span class="col-6 cart-subtotal-title cart-subtotal text-end">
                                    <span class="money text-danger" id="discount-amount" style="font-size: 15px;">- 0 ₫</span>
                                </span>
                            </div>

                            {{-- Thuế, vận chuyển (không đổi) --}}
                            <div class="row g-0 border-bottom py-2">
                                <span class="col-6 cart-subtotal-title"><strong>Phí vận chuyển</strong></span>
                                <span class="col-6 cart-subtotal-title cart-subtotal text-end">
                                    <span class="money">Free</span>
                                </span>
                            </div>

                            {{-- Tổng thanh toán sau giảm --}}
                            <div class="row g-0 pt-2">
                                <span class="col-6 cart-subtotal-title fs-6"><strong>Tổng tiền</strong></span>
                                <span class="col-6 cart-subtotal-title fs-5 cart-subtotal text-end text-primary">
                                    <b class="money" id="cart-total">0 ₫</b>
                                </span>
                            </div>
                        </div>

                        <form id="checkoutForm" action="{{ route('checkout.form') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected_items" id="selectedItemsInput">
                            <input type="hidden" name="voucher_code" id="voucherCodeInput">
                            <button type="submit" class="btn btn-lg my-4 checkout w-100">Tiến hành thanh toán</button>
                        </form>


                        <div class="paymnet-img text-center"><img src="assets/client/images/icons/safepayment.png" alt="Payment" width="299" height="28" /></div>
                    </div>
                </div>
            </div>
            <!--End Cart Sidebar-->
        </div>
    </div>
    <!--End Main Content-->


    <!--Related Products-->
    <section class="section product-slider pb-0">
        <div class="container">
            <div class="section-header">
                <h2>Sản phẩm bạn có thể thích</h2>
            </div>
            <!--Product Grid-->
            <div class="product-slider-4items gp10 arwOut5 grid-products">
                @foreach($products as $product)
                <div class="item col-item">
                    <div class="product-box">
                        <!-- Start Product Image -->
                        <div class="product-image">
                            <!-- Start Product Image -->
                            <a href="{{ route('client.products.show', ['slug' => $product->slug]) }}" class="product-img rounded-0"><img class="rounded-0 blur-up lazyload" src="{{ asset($product->image ?? 'assets/images/placeholder.jpg') }}" alt="Product" title="Product" width="625" height="808" /></a>
                            <!-- End Product Image -->
                            <!-- Product label -->
                            <div class="product-labels"><span class="lbl on-sale">Sale</span></div>
                            <!-- End Product label -->
                            <!--Product Button-->
                            <div class="button-set style1">
                                <!--Cart Button-->
                                <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                    <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick Shop"><i class="icon anm anm-cart-l"></i><span class="text">Quick Shop</span></span>
                                </a>
                                <!--End Cart Button-->
                                <!--Quick View Button-->
                                <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                    <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                </a>
                                <!--End Quick View Button-->
                                <!--Wishlist Button-->
                                <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="left" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                <!--End Wishlist Button-->
                                <!--Compare Button-->
                                <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                <!--End Compare Button-->
                            </div>
                            <!--End Product Button-->
                        </div>
                        <!-- End Product Image -->
                        <!-- Start Product Details -->
                        <div class="product-details text-left">
                            <!-- Product Name -->
                            <div class="product-name">
                                <a href="product-layout1.html">{{ $product->name }}</a>
                            </div>
                            <!-- End Product Name -->
                            <!-- Product Price -->
                            <div class="product-price">
                                <span class="price">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                            </div>
                            <!-- End Product Price -->
                            <!-- Product Review -->
                            <div class="product-review">
                                <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                <span class="caption hidden ms-1">3 Reviews</span>
                            </div>
                            <!-- End Product Review -->
                        </div>
                        <!-- End product details -->
                    </div>
                </div>
                @endforeach
            </div>
            <!--End Product Grid-->
        </div>
    </section>
    <!--End Related Products-->
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.qtyBtn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const input = this.closest('.quantity-group').querySelector('.cart-qty-input');
                let value = parseInt(input.value);

                if (this.classList.contains('plus')) {
                    value += 1;
                } else if (this.classList.contains('minus') && value > 1) {
                    value -= 1;
                }

                input.value = value;

                // Submit form
                const form = this.closest('form');
                if (form) form.submit();
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkoutForm = document.getElementById('checkoutForm');
        const selectedInput = document.getElementById('selectedItemsInput');
        const voucherInput = document.getElementById('voucherCodeInput');

        const checkboxes = document.querySelectorAll(".cart-checkbox");
        const totalEl = document.getElementById("cart-total");
        const original = document.getElementById("original-total");

        // --- 1. Khôi phục checkbox đã chọn từ localStorage
        let selectedIds = JSON.parse(localStorage.getItem("selectedCartItems")) || [];
        checkboxes.forEach(cb => {
            if (selectedIds.includes(cb.dataset.id)) {
                cb.checked = true;
            }
        });

        // --- 2. Hàm cập nhật tổng tiền & lưu selected IDs
        function updateTotalAndSave() {
            let total = 0;
            let selected = [];

            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseFloat(cb.dataset.price);
                    selected.push(cb.dataset.id);
                }
            });

            totalEl.textContent = new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(total);

            original.textContent = totalEl.textContent;

            localStorage.setItem("selectedCartItems", JSON.stringify(selected));
        }

        // --- 3. Sự kiện chọn checkbox
        checkboxes.forEach(cb => {
            cb.addEventListener('change', updateTotalAndSave);
        });

        // --- 4. Gửi form thanh toán
        checkoutForm.addEventListener('submit', function (e) {
            const selectedCheckboxes = document.querySelectorAll('.cart-checkbox:checked');
            const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.dataset.id);

            if (selectedIds.length === 0) {
                e.preventDefault();
                toastr.warning('Vui lòng chọn sản phẩm để thanh toán.');
                return;
            }

            selectedInput.value = JSON.stringify(selectedIds);

            const storedVoucher = localStorage.getItem("appliedVoucherCode") || '';
            voucherInput.value = storedVoucher;

            console.log("🛒 selectedItems:", selectedInput.value);
            console.log("🎟️ voucherCode:", voucherInput.value);
        });

        // --- 5. Áp dụng voucher (từ nhập tay hoặc radio)
        function applyVoucher(code) {
            const total = getCartTotal();

            if (total <= 0) {
                toastr.warning("Vui lòng chọn sản phẩm để áp dụng mã giảm giá.");
                return;
            }

            fetch('/cart/apply-voucher', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    code: code,
                    cart_total: total
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('discount-amount').innerText = `- ${data.discount_display}`;
                    document.getElementById('cart-total').innerText = data.total_display;

                    localStorage.setItem("appliedVoucherCode", code); // ⚠️ lưu đúng mã
                    document.getElementById('voucherCodeInput').value = code;

                    const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                    if (modal) modal.hide();

                    toastr.success('Áp dụng mã giảm giá thành công!');
                } else {
                    toastr.error(data.message || 'Mã giảm giá không hợp lệ!');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                toastr.error('Có lỗi khi áp dụng mã giảm giá.');
            });
        }

        // --- 6. Nhấn ÁP DỤNG (nhập tay)
        document.getElementById('btnApplyManual').addEventListener('click', function () {
            const code = document.getElementById('manualVoucherCode').value.trim();
            if (!code) {
                alert('Vui lòng nhập mã.');
                return;
            }
            applyVoucher(code);
        });

        // --- 7. Nhấn ÁP DỤNG (voucher radio)
        document.getElementById('btnApplyRadio').addEventListener('click', function () {
            const selected = document.querySelector('input[name="selected_voucher"]:checked');
            if (!selected) {
                alert('Vui lòng chọn một mã giảm giá.');
                return;
            }
            const code = selected.dataset.code;
            applyVoucher(code);
        });

        // --- 8. Tính tổng tiền các checkbox đã chọn
        function getCartTotal() {
            let total = 0;
            document.querySelectorAll(".cart-checkbox:checked").forEach(cb => {
                total += parseFloat(cb.dataset.price);
            });
            return total;
        }

        // Gọi lần đầu để hiển thị tổng
        updateTotalAndSave();
    });
</script>





@endsection
@extends('clients.layouts.master')
@section('title', 'Giỏ hàng')
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
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
                <form action="{{ route('client.cart.update') }}" method="post" class="cart-table table-bottom-brd">
                    @csrf

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
                            <tr class="cart-row cart-flex position-relative">
                                <td class="cart-delete text-center small-hide">
                                    <input type="checkbox" name="selected[]" value="{{ $item->id }}" class="cart-checkbox" />

                                </td>
                                <td class="cart-image cart-flex-item">
                                    <a href="product-layout1.html"><img
                                            src="{{ ($item->variant && $item->variant->image) ? asset('storage/' . $item->variant->image) : asset('images/no-image.jpg') }}" width="60" hight="60" class="rounded" alt="{{ $item->product->name }}"></a>

                                </td>
                                <td class="cart-meta small-text-left cart-flex-item">
                                    {{-- <div class="list-view-item-title">
                                        <a href="product-layout1.html">{{ $item->product->name }}</a>
            </div> --}}
            <div class="list-view-item-title">
                <a href="{{ route('client.products.show', ['slug' => $item->product->slug]) }}">
                    {{ $item->product->name }}
                </a>
            </div>
            <div class="cart-meta-text">
                Color: {{ $item->variant->color->name ?? '—' }}<br>Size: {{ $item->variant->size->name ?? '—' }}<br>Qty: {{ $item->quantity }}
            </div>
            <div class="cart-price d-md-none">
                <span class="money fw-500">$99.00</span>
            </div>
            </td>
            <td class="cart-price cart-flex-item text-center small-hide">
                <span class="money">{{ number_format($item->price_at_purchase) }} VNĐ</span>
            </td>
            <td class="cart-update-wrapper cart-flex-item text-end text-md-center">
                <div class="cart-qty d-flex justify-content-end justify-content-md-center">
                    <div class="qtyField">
                        <a class="qtyBtn minus" href="#;"><i class="icon anm anm-minus-r"></i></a>
                        <input class="cart-qty-input qty" type="number" name="quantity[{{ $item->id }}]" value="{{ $item->quantity }}" pattern="[0-9]*" />
                        <a class="qtyBtn plus" href="#;"><i class="icon anm anm-plus-r"></i></a>
                    </div>
                </div>
                <a href="#" title="Remove" class="removeMb d-md-none d-inline-block text-decoration-underline mt-2 me-3">Remove</a>
            </td>
            <td class="cart-price cart-flex-item text-center small-hide">
                <span class="money fw-500">{{ number_format($item->price_at_purchase * $item->quantity) }} VNĐ</span>
            </td>
            <td class="cart-delete text-center small-hide">
                <button type="button" onclick="document.getElementById('delete-form-{{ $item->id }}').submit(); " title="Xóa">
                    <i class="icon anm anm-times-r"></i>
                </button>
            </td>
            </tr>
            @endforeach
            @else
            <tr class="cart-row cart-flex position-relative">
                <td colspan="7" class="text-center">
                    <div class="alert alert-info text-center" role="alert">
                        <strong>Giỏ hàng của bạn đang trống!</strong> Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm.
                    </div>
            </tr>
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-start"><a href="{{ route('client.products.index') }}" class="btn btn-outline-secondary btn-sm cart-continue"><i class="icon anm anm-angle-left-r me-2 d-none"></i> Tiếp tục mua sắm</a></td>
                    <td colspan="3" class="text-end">
                        <a href="{{ route('client.cart.hasdelete') }}" class="btn btn-outline-secondary btn-sm cart-continue"><i class="icon anm anm-angle-left-r me-2 d-none"></i>Sản phẩm đã xóa</a>
                        <button type="submit" name="update" class="btn btn-secondary btn-sm cart-continue ms-2"> Cập nhật giỏ hàng</button>
                    </td>
                </tr>
            </tfoot>
            </table>

            </form>
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
                    <div class="cart-note mb-4">
                        <h5>Add a note to your order</h5>
                        <label for="cart-note">Notes about your order, e.g. special notes for delivery.</label>
                        <textarea name="note" id="cart-note" class="form-control cart-note-input" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-12 cart-col">
                    <div class="cart-discount">
                        <h5>Mã giảm giá</h5>
                        <form id="voucher-form" data-url="{{ route('client.cart.applyVoucher') }}">
                            <div class="form-group">
                                <label for="voucher_code">Nhập mã giảm giá:</label>
                                <div id="voucher-result"></div>
                                <div class="input-group0">
                                    <input class="form-control" type="text" id="voucher_code" name="voucher_code" placeholder="Nhập mã..." required />
                                    <button type="submit" class="btn text-nowrap mt-3">Áp dụng</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-12 cart-col">
                    <div id="shipping-calculator" class="mt-4 mt-lg-0">
                        <h5>Get shipping estimates</h5>
                        <form class="estimate-form row row-cols-lg-3 row-cols-md-3 row-cols-1" action="#" method="post">
                            <div class="form-group">
                                <label for="address_country">Country</label>
                                <select id="address_country" name="address[country]" data-default="United States">
                                    <option value="0" label="Select a country ... " selected="selected">Select a country...</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address_province">State</label>
                                <select id="address_province" name="address[province]" data-default="">

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address_zip">Postal/Zip Code</label>
                                <input type="text" id="address_zip" name="address[zip]" />
                            </div>
                            <div class="actionRow">
                                <input type="button" class="btn btn-secondary get-rates" value="Calculate shipping" />
                            </div>
                        </form>
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
                    <div class="row g-0 border-bottom pb-2">
                        <span class="col-6 col-sm-6 cart-subtotal-title"><strong>Tổng tiền</strong> </span>
                        <span class="col-6 col-sm-6 cart-subtotal-title cart-subtotal text-end"><span class="money" id="total-price">@if(session('total_price')) {{ number_format(session('total_price')) }} VNĐ @else 0 VNĐ @endif</span></span>
                    </div>
                    <div class="row g-0 border-bottom py-2">
                        <span class="col-6 col-sm-6 cart-subtotal-title"><strong>Mã giảm giá</strong></span>
                        <span class="col-6 col-sm-6 cart-subtotal-title cart-subtotal text-end"><span class="money" id="discount-amount" class="mt-2"> 0 VNĐ</span></span>
                    </div>
                    <div class="row g-0 border-bottom py-2">
                        <span class="col-6 col-sm-6 cart-subtotal-title"><strong>Thuế</strong></span>
                        <span class="col-6 col-sm-6 cart-subtotal-title cart-subtotal text-end"><span class="money">$10.00</span></span>
                    </div>
                    <div class="row g-0 border-bottom py-2">
                        <span class="col-6 col-sm-6 cart-subtotal-title"><strong>Phí vận chuển</strong></span>
                        <span class="col-6 col-sm-6 cart-subtotal-title cart-subtotal text-end"><span class="money">Free shipping</span></span>
                    </div>
                    <div class="row g-0 pt-2">
                        <span class="col-6 col-sm-6 cart-subtotal-title fs-6"><strong>Tổng số tiền</strong></span>
                        <span class="col-6 col-sm-6 cart-subtotal-title fs-5 cart-subtotal text-end text-primary"><b class="money" id="total-after-discount">@if(session('total_price')) {{ number_format(session('total_price')) }} VNĐ @else 0 VNĐ @endif</b></span>
                    </div>

                    <p class="cart-shipping mt-3">Phí vận chuyển &amp; thuế được tính trước khi thanh toán</p>
                    <p class="cart-shipping fst-normal freeShipclaim"><i class="me-2 align-middle icon anm anm-truck-l"></i><b>FREE SHIPPING</b> ELIGIBLE</p>
                    <div class="customCheckbox cart-tearm">
                        <input type="checkbox" value="allen-vela" id="cart-tearm">
                        <label for="cart-tearm">I agree with the terms and conditions</label>
                    </div>
                    <a href="{{ route('checkout.form') }}" id="cartCheckout" class="btn btn-lg my-4 checkout w-100">Tiến hành thanh toán</a>
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
                            <span class="price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
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
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('input[name="selected[]"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('voucher-form');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const code = document.getElementById('voucher_code').value.trim();
            if (!code) {
                alert('Vui lòng nhập mã giảm giá');
                return;
            }

            fetch("{{ route('client.cart.applyVoucher') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        voucher_code: code
                    })
                })
                .then(async res => {
                    const data = await res.json();

                    if (!res.ok) {
                        document.getElementById('voucher-result').innerHTML = `
                        <div class="alert alert-danger">${data.message || 'Có lỗi xảy ra'}</div>`;
                        return;
                    }

                    // ✅ Thành công
                    document.getElementById('voucher-result').innerHTML = `
                    <div class="alert alert-success">
                        ${data.message}<br>
                        Giảm giá: <strong>${parseInt(data.discount).toLocaleString()} VNĐ</strong>
                    </div>`;

                    // ✅ Cập nhật số tiền
                    const totalElement = document.getElementById('total-price');
                    const discountElement = document.getElementById('discount-amount');
                    const afterDiscountElement = document.getElementById('total-after-discount');

                    if (totalElement && discountElement && afterDiscountElement) {
                        const totalRaw = totalElement.innerText.replace(/[^\d]/g, '');
                        const total = parseInt(totalRaw);
                        const discount = parseInt(data.discount);
                        const afterDiscount = total - discount;

                        discountElement.innerText = `-${discount.toLocaleString()} VNĐ`;
                        afterDiscountElement.innerHTML = `<span class="text-danger">${afterDiscount.toLocaleString()} VNĐ</span>`;
                    }
                })
                .catch(error => {
                    console.error('Lỗi fetch:', error);
                    document.getElementById('voucher-result').innerHTML = `
                    <div class="alert alert-danger">Lỗi kết nối máy chủ!</div>`;
                });
        });
    });
</script>

@endsection
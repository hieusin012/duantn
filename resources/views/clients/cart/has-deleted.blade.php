@extends('clients.layouts.master')
@section('title', 'Giỏ hàng')
@section('content')
<div id="page-content">
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title">
                        <h1>Sản phẩm đã xóa khỏi giỏ hàng</h1>
                    </div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="{{ route('client.home') }}" title="Back to the home page">Home</a><span class="main-title"><i class="icon anm anm-angle-right-l"></i>Giỏ hàng của bạn</span></div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <!--Cart Content-->
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 main-col w-100">
                <!--Cart Form-->
                <form action="{{ route('client.cart.restoreSelected') }}" method="post" class="cart-table table-bottom-brd">
                    @csrf

                    <table class="table align-middle w-100">
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
                            @if ($deletedItems && $deletedItems->count())
                            @foreach ($deletedItems as $item)
                            <tr class="cart-row cart-flex position-relative">
                                <td class="cart-delete text-center small-hide">
                                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}">

                                </td>
                                <td class="cart-image cart-flex-item">
                                    <a href="product-layout1.html"><img
                                            src="{{ $item->variant->image ? asset('storage/' . $item->variant->image) : asset('images/no-image.jpg') }}"
                                            width="60" hight="60" class="rounded" alt="{{ $item->product->name }}"></a>

                                </td>
                                <td class="cart-meta small-text-left cart-flex-item">
                                    <div class="list-view-item-title">
                                        <a href="product-layout1.html">{{ $item->product->name }}</a>
                                    </div>
                                    <div class="cart-meta-text">
                                        Color: {{ $item->variant->color->name ?? '—' }}<br>Size: {{ $item->variant->size->name ?? '—' }}<br>Qty: {{ $item->quantity }}
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
                                    <div class="alert alert-warning text-center" role="alert">
                                        <strong>Chưa có sản phẩm nào được xóa !</strong> Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm.
                                    </div>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-start"><a href="{{ route('client.cart') }}" class="btn btn-outline-secondary btn-sm cart-continue"><i class="bi bi-arrow-left"></i> Quay lại</a></td>
                                <td colspan="3" class="text-end">
                                    <button type="button" class="btn btn-danger btn-sm cart-continue ms-2"
                                        onclick="submitForceDeleteSelected()">
                                        Xoá tất cả
                                    </button>

                                    <button type="submit" name="update" class="btn btn-secondary btn-sm cart-continue ms-2">Mua lại sản phẩm</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>


                </form>
                <form id="force-delete-selected-form" action="{{ route('client.cart.forceDeleteSelected') }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="selected_items[]" id="selected-items-input">
                </form>

                @foreach ($deletedItems as $item)
                <form id="delete-form-{{ $item->id }}" action="{{ route('client.cart.forceDelete', $item->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach
            </div>
            <!--End Cart Content-->


        </div>
        <!--End Cart Sidebar-->
    </div>
</div>
<script>
    function submitForceDeleteSelected() {
        const checked = document.querySelectorAll('input[name="selected_items[]"]:checked');
        if (checked.length === 0) {
            alert('Vui lòng chọn ít nhất một sản phẩm để xoá!');
            return;
        }

        // Tạo mảng các ID được chọn
        const selectedIds = Array.from(checked).map(cb => cb.value);

        // Tạo input ẩn để gửi ID
        const form = document.getElementById('force-delete-selected-form');
        const container = document.getElementById('selected-items-input');

        // Xóa input cũ (nếu có)
        form.querySelectorAll('input[name="selected_items[]"]').forEach(i => i.remove());

        // Gắn từng input
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = id;
            form.appendChild(input);
        });

        form.submit();
    }
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>

@endsection
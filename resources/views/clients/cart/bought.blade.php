@extends('clients.layouts.master')
@section('title', 'Giỏ hàng đã mua')
@section('content')
<div id="page-content">
    <!-- Page Header -->
    <div class="page-header text-center py-4 bg-light border-bottom">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-12 col-md-6 text-md-start">
                    <h1 class="h3 mb-0">Sản phẩm đã mua</h1>
                </div>
                <div class="col-12 col-md-6 text-md-end small">
                    <a href="{{ route('client.home') }}">Trang chủ</a> 
                    <i class="icon anm anm-angle-right-l mx-1"></i> 
                    <span class="text-muted">Giỏ hàng đã mua</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">
        <div class="table-responsive shadow-sm rounded border p-3 bg-white">
            <form action="{{ route('client.cart.restoreSelected') }}" method="post">
                @csrf
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Hình ảnh</th>
                            <th>Sản phẩm</th>
                            <th class="text-center">Giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Tổng</th>
                            <th class="text-center">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($boughtCart && $boughtCart->count())
                            @foreach ($boughtCart as $item)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}">
                                </td>
                                <td>
                                    <img src="{{ $item->variant->image ? asset('storage/' . $item->variant->image) : asset('images/no-image.jpg') }}" 
                                        class="img-thumbnail rounded" width="60" alt="{{ $item->product->name }}">
                                </td>
                                <td>
                                    <strong>{{ $item->product->name }}</strong><br>
                                    <small>Màu: {{ $item->variant->color->name ?? '—' }}, Size: {{ $item->variant->size->name ?? '—' }}</small>
                                </td>
                                <td class="text-center">{{ number_format($item->price_at_purchase) }} đ</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">{{ number_format($item->price_at_purchase * $item->quantity) }} đ</td>
                                <td class="text-center">
                                    <button type="button" onclick="document.getElementById('delete-form-{{ $item->id }}').submit();" class="btn btn-sm btn-outline-danger">
                                        <i class="icon anm anm-times-r"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <strong>Bạn chưa mua sản phẩm nào.</strong> Hãy tiếp tục mua sắm!
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if ($boughtCart->count())
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('client.cart') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Quay lại giỏ hàng
                    </a>
                    <div>
                        <button type="button" class="btn btn-danger me-2" onclick="submitForceDeleteSelected()">
                            <i class="bi bi-trash"></i> Xóa tất cả
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-cart-check"></i> Mua lại sản phẩm
                        </button>
                    </div>
                </div>
                @endif
            </form>

            <!-- Form xóa hàng loạt -->
            <form id="force-delete-selected-form" action="{{ route('client.cart.forceDeleteSelected') }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
                <input type="hidden" name="selected_items[]" id="selected-items-input">
            </form>

            <!-- Form xóa từng item -->
            @foreach ($boughtCart as $item)
                <form id="delete-form-{{ $item->id }}" action="{{ route('client.cart.forceDelete', $item->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function submitForceDeleteSelected() {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Vui lòng chọn ít nhất một sản phẩm để xoá!');
            return;
        }

        const form = document.getElementById('force-delete-selected-form');
        form.querySelectorAll('input[name="selected_items[]"]').forEach(i => i.remove());

        checkboxes.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = cb.value;
            form.appendChild(input);
        });

        form.submit();
    }

    // Chọn tất cả checkbox
    document.getElementById('select-all')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>
@endsection

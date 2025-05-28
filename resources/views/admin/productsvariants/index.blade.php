@extends('admin.layouts.index')

@section('content')
<div class="container">
    <h2 class="my-3">Danh sách biến thể của sản phẩm</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('productVariants.create', request()->route('id')) }}" class="btn btn-primary mb-3">+ Thêm biến thể</a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Màu</th>
                <th>Kích cỡ</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Giá khuyến mãi</th>
                <th>Ngày bắt đầu KM</th>
                <th>Ngày kết thúc KM</th>
                <th>Ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productVariants as $variant)
            <tr>
                <td>{{ $variant->id }}</td>
                <td>{{ $variant->color->name ?? '-' }}</td>
                <td>{{ $variant->size->name ?? '-' }}</td>
                <td>{{ $variant->quantity }}</td>
                <td>{{ number_format($variant->price) }} đ</td>
                <td>{{ number_format($variant->sale_price ?? 0) }} đ</td>
                <td>
                    {{ $variant->sale_start_date ? \Carbon\Carbon::parse($variant->sale_start_date)->format('d/m/Y') : '-' }}
                </td>
                <td>
                    {{ $variant->sale_end_date ? \Carbon\Carbon::parse($variant->sale_end_date)->format('d/m/Y') : '-' }}
                </td>
                <td>
                    @php
                        $images = json_decode($variant->images, true);
                    @endphp
                    @if(!empty($images) && is_array($images))
                        <img src="{{ asset('storage/' . $images[0]) }}" width="60" alt="Ảnh biến thể">
                    @else
                        Không có
                    @endif
                </td>
                <td>
                    <a href="{{ route('productVariants.edit', $variant->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('productVariants.destroy', $variant->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button onclick="return confirm('Bạn chắc chắn muốn xóa?')" class="btn btn-danger btn-sm">Xoá</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $productVariants->links() }}
</div>
@endsection

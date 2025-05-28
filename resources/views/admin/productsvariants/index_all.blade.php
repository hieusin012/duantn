@extends('admin.layouts.index')

@section('content')
<div class="container">
    <h2 class="my-3">Tất cả biến thể sản phẩm</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Màu</th>
                <th>Kích cỡ</th>
                <th>Giá</th>
                <th>Giá sale</th>
                <th>Ngày bắt đầu sale</th>
<th>Ngày kết thúc sale</th>

                <th>Số lượng</th>
                <th>Ảnh</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productVariants as $variant)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $variant->product->name ?? 'N/A' }}</td>
                    <td>{{ $variant->color->name ?? 'N/A' }}</td>
                    <td>{{ $variant->size->name ?? 'N/A' }}</td>
                    <td>{{ number_format($variant->price) }} đ</td>
                    <td>{{ $variant->sale_price ? number_format($variant->sale_price) . ' đ' : 'Không có' }}</td>
                    <td>
                        {{ $variant->sale_start_date ? \Carbon\Carbon::parse($variant->sale_start_date)->format('d/m/Y') : '-' }}
                    </td>
                    <td>
                        {{ $variant->sale_end_date ? \Carbon\Carbon::parse($variant->sale_end_date)->format('d/m/Y') : '-' }}
                    </td>

                    <td>{{ $variant->quantity }}</td>
                    <td>
                        @if ($variant->images)
                            @foreach (json_decode($variant->images, true) as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Ảnh" width="50">
                            @endforeach
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

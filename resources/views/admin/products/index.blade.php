@extends('admin.layouts.index')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container mt-4">
    <h1>Danh sách sản phẩm</h1>

    {{-- Hiển thị thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form tìm kiếm --}}
    <form action="{{ route('products.search') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="{{ request('keyword') }}">
        
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Tìm kiếm
            </button>
        </div>
    </form>

    {{-- Form lọc --}}
    <form action="{{ route('products.filter') }}" method="GET" class="mb-3 d-flex align-items-center gap-3">
        <select name="is_active" class="form-select" style="max-width: 200px;">
            <option value="">-- Chọn trạng thái --</option>
            <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Kích hoạt</option>
            <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Không kích hoạt</option>
        </select>

        <select name="sort" class="form-select" style="max-width: 200px;">
            <option value="">-- Sắp xếp --</option>
            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Tên sản phẩm (A đến Z)</option>
            <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Tên sản phẩm (Z đến A)</option>
        </select>

        <button type="submit" class="btn btn-secondary">Lọc</button>
    </form>

    {{-- Nút thêm sản phẩm mới --}}
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Thêm sản phẩm mới
    </a>
    
    {{-- Bảng danh sách sản phẩm --}}
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Mã sản phẩm</th>
                <th>Tên</th>
                <th>Ảnh</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Trạng thái</th>
                <th>Kích hoạt</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" width="60">
                    @else
                        <span class="text-muted">Không có ảnh</span>
                    @endif
                </td>
                <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                <td>{{ $product->category->name ?? '[N\A]' }}</td>
                <td>{{ $product->brand->name ?? '[N\A]' }}</td>
                <td>
                    @if($product->status)
                        <span class="badge bg-success">Còn hàng</span>
                    @else
                        <span class="badge bg-danger">Hết hàng</span>
                    @endif
                </td>
                <td>
                    @if($product->is_active)
                        <span class="badge bg-primary">Kích hoạt</span>
                    @else
                        <span class="badge bg-secondary">Chưa kích hoạt</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm" title="Xem">
                        <i class="fas fa-eye"></i>
                    </a>
                
                    <a href="{{ route('productVariants.create', ['id' => $product->id]) }}" class="btn btn-primary btn-sm" title="Thêm biến thể">
                        <i class="fas fa-plus"></i>
                    </a>
                
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm" title="Sửa">
                        <i class="fas fa-edit"></i>
                    </a>
                
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Xóa">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
                
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">Không có sản phẩm nào.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection

@extends('admin.layouts.index')

@section('title', 'Danh sách biến thể đã xóa mềm')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.product-variants.index') }}">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    <form action="{{ route('admin.variants.all-eliminate') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn tất cả biến thể đã xóa mềm?')">
                                <i class="fas fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </div>
                    </form>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Sản phẩm</th>
                            <th>Màu sắc</th>
                            <th>Kích thước</th>
                            <th>Giá</th>
                            <th>Khuyến mãi</th>
                            <th>Số lượng</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deletedVariants as $variant)
                        <tr>
                            <td><input type="checkbox" name="check[]" value="{{ $variant->id }}"></td>
                            <td>{{ $variant->product->name ?? '[N/A]' }}</td>
                            <td>{{ $variant->color->name ?? '[N/A]' }}</td>
                            <td>{{ $variant->size->name ?? '[N/A]' }}</td>
                            <td>{{ number_format($variant->price) }}₫</td>
                            <td>
                                @if($variant->sale_price)
                                    {{ number_format($variant->sale_price) }}₫
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $variant->quantity }}</td>
                            <td>
                                @if ($variant->image)
                                <img src="{{ asset('storage/' . $variant->image) }}" alt="Ảnh biến thể"
                                    class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('admin.variants.restore', $variant->id) }}"
                                    title="Khôi phục"><i class="fas fa-undo"></i></a>

                                <form action="{{ route('admin.variants.eliminate', $variant->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa vĩnh viễn"
                                        onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn biến thể này không?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Không có biến thể nào đã bị xóa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination nếu cần --}}
                {{-- <div class="d-flex justify-content-center mt-3">
                    {{ $deletedVariants->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

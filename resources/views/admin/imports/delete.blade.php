@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã xóa phiếu nhập')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.imports.index') }}" title="Quay lại"><i class="fas fa-arrow-left"></i> Quay lại</a>
                    </div>

                    <form action="{{ route('admin.imports.all-eliminate') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa tất cả"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tất cả phiếu nhập đã xóa mềm?')">
                                <i class="fas fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </div>
                    </form>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Mã phiếu nhập</th>
                            <th>Nhà cung cấp</th>
                            <th>Người nhập</th>
                            <th>Ngày nhập</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deletedImports as $import)
                        <tr>
                            <td><input type="checkbox" name="check[]" value="{{ $import->id }}"></td>
                            <td>{{ $import->code }}</td>
                            <td>{{ $import->supplier->name ?? 'N/A' }}</td>
                            <td>{{ $import->user->fullname ?? $import->user->name }}</td>
                            <td>{{ $import->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($import->total_price, 0, ',', '.') }} VND</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.imports.restore', $import->id) }}" title="Khôi phục"><i class="fas fa-undo"></i></a>
                                <form action="{{ route('admin.imports.eliminate', $import->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                        onclick="return confirm('Bạn có chắc muốn xóa vĩnh viễn phiếu nhập {{ $import->code }} không?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger">Không có phiếu nhập nào đã xóa</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination mt-3 d-flex justify-content-end">
                    {{-- Thêm phân trang nếu bạn muốn --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

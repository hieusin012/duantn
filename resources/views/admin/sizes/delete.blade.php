@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã xóa size')
@section('size')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.sizes.index') }}" title="Quay lại">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                    </div>

                    <form action="{{ route('admin.sizes.all-eliminate') }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa tất cả"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tất cả size đã xóa mềm?')">
                                <i class="fas fa-trash-alt"></i> Xóa tất cả
                            </button>
                        </div>
                    </form>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Tên size</th>
                            <th>Giá trị kích cỡ</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($deletedSizes as $size)
                        <tr>
                            <td><input type="checkbox" name="check[]" value="{{ $size->id }}"></td>
                            <td>{{ $size->name }}</td>
                            <td>{{ $size->value }}</td>
                            <td>{{ $size->created_at }}</td>
                            <td>{{ $size->updated_at }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.sizes.restore', $size->id) }}" title="Khôi phục">
                                    <i class="fas fa-undo"></i>
                                </a>
                                <form action="{{ route('admin.sizes.eliminate', $size->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa"
                                        onclick="return confirm('Bạn có chắc muốn xóa {{ $size->name }} vĩnh viễn không?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-danger">Không có size nào đã xóa mềm.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination">
                    {{-- Nếu bạn cần phân trang thì thêm {{ $deletedSizes->links() }} --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã xóa màu sắc')
@section('color')
@endsection
@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.colors.index') }}" title="Thêm"><i class="fas fa-arrow-left"></i>  Quay lại</a>
                    </div>

                    <div class="col-sm-2">
                        <form action="{{ route('admin.colors.all-eliminate') }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Xóa tất cả"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn tất cả màu đã xóa mềm?')">
                                <i class="fas fa-trash-alt"></i>  Xóa tất cả
                            </button>
                        </form>
                    </div>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Tên màu</th>
                            <th>Mã màu</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deletedColors as $color)
                        <tr>
                            <td width="10"><input type="checkbox" name="check[]" value="{{ $color->id }}"></td>
                            <td>{{ $color->name }}</td>
                            <td>{{ $color->color_code }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.colors.restore', $color->id) }}" title="Khôi phục"><i class="fas fa-undo"></i></a>
                                <form action="{{ route('admin.colors.eliminate', $color->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa {{ $color->name }} không ?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="pagination">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
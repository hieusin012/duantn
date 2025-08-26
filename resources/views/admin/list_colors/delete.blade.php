@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã xóa màu sắc')
@section('color')
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.colors.index') }}" title="Thêm"><i class="fas fa-arrow-left"></i> Quay lại</a>
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
@extends('admin.layouts.index')

@section('title', 'Dữ liệu đã ẩn thương hiệu')
@section('color')
@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.brands.index') }}" title="Thêm"><i class="fas fa-arrow-left"></i>  Quay lại</a>
                    </div>
                </div>

                <table class="table table-hover table-bordered " id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th  class="text-center align-middle">Tên thương hiệu</th>
                            <th class="text-center align-middle">Logo</th>
                            <th  class="text-center align-middle">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deletedbrands as $brand)
                        <tr>
                            <td width="10"><input type="checkbox" name="check[]" value="{{ $brand->id }}"></td>
                            <td class="text-center align-middle">{{ $brand->name }}</td>
                            <td class="text-center align-middle"> 
                                @if ($brand->logo)
                                <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->logo }}" width="70px;" />
                                @else
                                <span>No image</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.brands.restore', $brand->id) }}" title="Khôi phục"><i class="fas fa-undo"></i></a>
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
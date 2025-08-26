@extends('admin.layouts.index')
@section('title', 'Quản lý thương hiệu')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.brands.create') }}" title="Thêm"><i class="fas fa-plus"></i> Thêm thương hiệu mới</a>
                    </div>

                    <div class="col-sm-2">
                        <a class="btn btn-danger btn-sm" type="button" title="Ẩn" href="{{ route('admin.brands.delete') }}"><i class="fas fa-eye-slash"></i> Dữ liệu đã ẩn</a>
                    </div>
                </div>

                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th class="text-center align-middle">Tên thương hiệu</th>
                            <th class="text-center align-middle">Logo</th>
                            <th class="text-center align-middle">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($brands as $brand)
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
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.brands.edit', $brand->id) }}" title="Sửa"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Ẩn"><i class="fas fa-eye-slash"></i></button>
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
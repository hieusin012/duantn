@extends('admin.layouts.index')

@section('title', 'Quản lý màu sắc')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
            <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.colors.create') }}" title="Thêm"><i class="fas fa-plus"></i> Tạo mới màu sắc</a>
                    </div>
                    
                    <div class="col-sm-2">
                        <a class="btn btn-danger btn-sm" type="button" title="Ẩn" href="{{ route('admin.colors.delete') }}"><i class="fas fa-eye-slash"></i> Dữ liệu đã ẩn</a>
                    </div>
                </div>
                <form method="GET" action="{{ route('admin.colors.index') }}" class="mb-3 d-flex">
                    <input type="text" name="keyword" class="form-control me-2" style="width: 350px;" placeholder="Tìm theo tên màu..." value="{{ request('keyword') }}">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                </form>
                {{-- @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif --}}


                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Tên màu</th>
                            <th>Mã màu</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach($colors as $color)
                        <tr>
                            <td width="10"><input type="checkbox" name="check[]" value="{{ $color->id }}"></td>
                            <td>{{ $color->name }}</td>
                            <td>
                                <div style="width: 30px; height: 30px; background-color: {{ $color->color_code }}; border: 1px solid #ccc; border-radius: 4px;" title="{{ $color->color_code }}"></div>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="{{ route('admin.colors.edit', $color->id) }}" title="Sửa"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Xóa"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody> --}}
                    <tbody>
                        @forelse($colors as $color)
                            <tr>
                                <td><input type="checkbox" name="check[]" value="{{ $color->id }}"></td>
                                <td>{{ $color->name }}</td>
                                <td>
                                    <div style="width: 30px; height: 30px; background-color: {{ $color->color_code }}; border: 1px solid #ccc; border-radius: 4px;" title="{{ $color->color_code }}"></div>
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.colors.edit', $color->id) }}" title="Sửa"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Ẩn"><i class="fas fa-eye-slash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-danger">Không tìm thấy màu phù hợp</td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>
                <!-- Pagination Links -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $colors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
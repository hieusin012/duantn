@extends('admin.layouts.index')

@section('title', 'Quản lý banner')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="row element-button">
                    <div class="col-sm-2">
                        <a class="btn btn-add btn-sm" href="{{ route('admin.banners.create') }}" title="Thêm"><i class="fas fa-plus"></i> Tạo mới banner</a>
                    </div>
                </div>
                <table class="table table-hover table-bordered" id="sampleTable">
                    <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th>Tiêu đề</th>
                            <th>Link</th>
                            <th>Ảnh</th>
                            <th>Trạng thái</th>
                            <th>Vị trí</th>
                            <th>Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banners as $banner)
                        <tr>
                            <td width="10"><input type="checkbox" name="check[]" value="{{ $banner->id }}"></td>
                            <td>{{ $banner->title ?? 'N/A' }}</td>
                            <td>{{ $banner->link ?? 'N/A' }}</td>
                            <td>
                                @if ($banner->image)
                                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title ?? 'Banner' }}" height="80" width="80">
                                @else
                                    <span>Không có ảnh</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $banner->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $banner->location ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $banner->location ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-primary btn-sm edit" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa banner này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary btn-sm trash" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="pagination">
                    {{ $banners->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
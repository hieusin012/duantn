@extends('admin.layouts.index')

@section('title', 'Chi tiết Shipper')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="tile">
            <div class="tile-body">
                <h5 class="mb-3">Thông tin chi tiết shipper</h5>

                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <td>{{ $shipper->id }}</td>
                    </tr>
                    <tr>
                        <th>Họ tên</th>
                        <td>{{ $shipper->fullname }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $shipper->email }}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại</th>
                        <td>{{ $shipper->phone }}</td>
                    </tr>
                    <tr>
                        <th>Địa chỉ</th>
                        <td>{{ $shipper->address ?? 'Chưa có' }}</td>
                    </tr>
                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            <span class="badge {{ $shipper->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $shipper->status == 'active' ? 'Đang hoạt động' : 'Tạm nghỉ' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td>{{ $shipper->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <a href="{{ route('admin.shipper.persons.index') }}" class="btn btn-secondary">Quay lại</a>
                <a href="{{ route('admin.shipper.persons.edit', $shipper->id) }}" class="btn btn-warning">Sửa</a>
            </div>
        </div>
    </div>
</div>
@endsection

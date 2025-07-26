@extends('admin.layouts.index')

@section('title', 'Chi tiết Shipper')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="tile p-4">
            <h4 class="mb-4 text-primary">
                <i class="fa fa-user-circle"></i> Thông tin chi tiết Shipper
            </h4>

            <div class="mb-3 d-flex">
                <strong class="me-3" style="width: 150px;">ID:</strong>
                <span>{{ $shipper->id }}</span>
            </div>

            <div class="mb-3 d-flex">
                <strong class="me-3" style="width: 150px;">Họ tên:</strong>
                <span>{{ $shipper->fullname }}</span>
            </div>

            <div class="mb-3 d-flex">
                <strong class="me-3" style="width: 150px;">Email:</strong>
                <span>{{ $shipper->email }}</span>
            </div>

            <div class="mb-3 d-flex">
                <strong class="me-3" style="width: 150px;">Số điện thoại:</strong>
                <span>{{ $shipper->phone }}</span>
            </div>

            <div class="mb-3 d-flex">
                <strong class="me-3" style="width: 150px;">Địa chỉ:</strong>
                <span>{{ $shipper->address ?? 'Chưa có' }}</span>
            </div>

            <div class="mb-3 d-flex">
                <strong class="me-3" style="width: 150px;">Trạng thái:</strong>
                <span>
                    <span class="badge {{ $shipper->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $shipper->status == 'active' ? 'Đang hoạt động' : 'Tạm nghỉ' }}
                    </span>
                </span>
            </div>

            <div class="mb-4 d-flex">
                <strong class="me-3" style="width: 150px;">Ngày tạo:</strong>
                <span>{{ $shipper->created_at->format('d/m/Y H:i') }}</span>
            </div>

            <div class="mt-3">
                <a href="{{ route('admin.shipper.persons.index') }}" class="btn btn-secondary me-2">
                    <i class="fa fa-arrow-left"></i> Quay lại
                </a>
                <a href="{{ route('admin.shipper.persons.edit', $shipper->id) }}" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Sửa thông tin
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('admin.layouts.index')

@section('title', 'Sửa thông tin Shipper')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="tile">
            <div class="tile-body">
                <h5 class="mb-3">Sửa thông tin shipper</h5>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.shipper.persons.update', $shipper->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Tên</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $shipper->fullname) }}">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $shipper->email) }}">
                    </div>

                    <div class="mb-3">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $shipper->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label>Địa chỉ</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $shipper->address) }}">
                    </div>

                    <div class="mb-3">
                        <label>Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $shipper->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="inactive" {{ $shipper->status == 'inactive' ? 'selected' : '' }}>Tạm nghỉ</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Cập nhật shipper</button>
                    <a href="{{ route('admin.shipper.persons.index') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

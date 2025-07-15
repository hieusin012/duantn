@extends('admin.layouts.index')

@section('title', 'Thêm Shipper')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="tile">
            <div class="tile-body">
                <h5 class="mb-3">Thêm shipper mới</h5>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('admin.shipper.persons.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Tên</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="mb-3">
                        <label>Mật khẩu</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <button class="btn btn-success">Thêm shipper</button>
                    <a href="{{ route('admin.shipper.persons.index') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

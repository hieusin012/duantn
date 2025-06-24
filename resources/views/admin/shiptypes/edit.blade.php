@extends('admin.layouts.index')

@section('title', 'Sửa loại ship')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Cập nhật loại ship</h3>
            <div class="tile-body">
                <form class="row" action="{{ route('admin.shiptypes.update', $shipType->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group col-md-6">
                        <label class="control-label">Tên loại ship</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name', $shipType->name) }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="control-label">Giá tiền (VNĐ)</label>
                        <input class="form-control" type="number" name="price" min="0" step="1000" value="{{ old('price', $shipType->price) }}">
                        @error('price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <button class="btn btn-save" type="submit">Cập nhật</button>
                        <a class="btn btn-cancel" href="{{ route('admin.shiptypes.index') }}">Hủy bỏ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('Admin.layout.app')
@section('title', "Sản phẩm")
@section('title-page', "Sản phẩm")
@section('single-page', "Cập nhật sản phẩm")
@section('content')
    <div class="row m-4 vh-90">
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <div class="card mt-3">
                        <h3 class="card-header">Sửa sản phẩm</h3>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="code" class="form-lable">Mã SKU</label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $product['code']) }}">
                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-lable">Tên sản phẩm</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $product['name']) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-lable">Hình ảnh: </label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror" value="{{ old('image') }}">
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                @if ($product->image)
                                    <img src="{{ asset($product->image) }}" width="100px" height="100px"
                                        alt="">
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-lable">Mô tả sản phẩm:</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" cols="30" rows="3">{{ old('description', $product['description']) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="material" class="form-lable">Chất liệu: </label>
                                <input type="text" name="material"
                                    class="form-control @error('material') is-invalid @enderror"
                                    value="{{ old('material', $product['material']) }}">
                                @error('material')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-lable">Trạng thái: </label>
                                {{-- <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" value="{{old('image')}}"> --}}
                                <select id="status" name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                    <option value="1" {{ $product->status ? 'selected' : '' }}>Hiển thị</option>
                                    <option value="0" {{ !$product->status ? 'selected' : '' }}>Ẩn</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="is_active" class="form-lable">Trạng thái: </label>
                                {{-- <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" value="{{old('image')}}"> --}}
                                <select id="is_active" name="is_active"
                                    class="form-select @error('is_active') is-invalid @enderror">
                                    <option value="1" {{ $product->is_active ? 'selected' : '' }}>Còn hàng</option>
                                    <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Hết hàng</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-lable">Danh mục: </label>
                                {{-- <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" value="{{old('image')}}"> --}}
                                {{-- <select class="form-select" name="category_id">
                                    @foreach ($categories as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select> --}}
                                <select name="category_id" id="category" class="form-control @error('category_id') is-invalid @enderror">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="brand_id" class="form-lable">Thương hiệu: </label>
                                {{-- <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" value="{{old('image')}}"> --}}
                                {{-- <select class="form-select" name="brand_id">
                                    @foreach ($brands as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select> --}}
                                <select name="brand_id" id="brand" class="form-control @error('brand_id') is-invalid @enderror">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>                    
                                @error('brand_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <input type="color" name="mamau">
                            </div>
                            <div class="mb-3 d-flex justify-content-center">
                                <button class="btn btn-success">Sửa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

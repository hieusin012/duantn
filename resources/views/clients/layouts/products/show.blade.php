@extends('clients.layouts.master')
@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-5">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
        </div>
        <div class="col-md-7">
            <h1>{{ $product->name }}</h1>
            <p class="text-muted">{{ number_format($product->price) }} VND</p>
            <p>{{ $product->description }}</p>
            <button class="btn btn-success">Thêm vào giỏ hàng</button>
        </div>
    </div>
</div>
@endsection

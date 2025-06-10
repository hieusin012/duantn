@extends('clients.layouts.master')

@section('title', 'Trang chủ')
@section('content')



{{-- Sản phẩm mới nhất --}}
<section class="section product-section">
   <div class="row">
    @foreach($latestProducts as $product)
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="product-card">
                <div class="product-img">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                </div>
                <div class="product-info mt-2">
                    <h5 class="product-title">{{ $product->name }}</h5>
                    <p class="product-price">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
              <a href="{{ route('client.products.show', ['id' => $product->id]) }}" class="btn btn-primary">
    Xem chi tiết</a>

                </div>
            </div>
        </div>
    @endforeach
</div>

</section>





@endsection
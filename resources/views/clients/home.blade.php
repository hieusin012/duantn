@extends('clients.layouts.master')

@section('title', 'Trang chủ')
@section('content')



{{-- Sản phẩm mới nhất --}}
<section class="section product-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">🆕 Sản phẩm mới nhất</h2>
        </div>
        <div class="row">
            @foreach($latestProducts as $product)
               
            @endforeach
        </div>
    </div>
</section>





@endsection
@extends('clients.layouts.master')

@section('banner')
    @include('clients.banner')
@endsection

@section('title', 'Trang Chủ')

@push('scripts')
<script>
    $(document).ready(function() {
        $('.home-slideshow').slick({
            dots: true,
            arrows: true,
            autoplay: true,
            autoplaySpeed: 1000,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1
        });
    });

    document.addEventListener('scroll', function () {
        const header = document.querySelector('.header');
        if (window.scrollY > 10) {
            header.classList.add('shadow-on-scroll');
        } else {
            header.classList.remove('shadow-on-scroll');
        }
    });
</script>
@endpush

@section('content')
    <!-- Slideshow, sản phẩm, nội dung trang chủ -->
@endsection

@extends('clients.layouts.master')

@section('title', 'Về Chúng Tôi')

@section('content')
<div class="page-title" style="background-color: #f5f5f5; padding: 40px 0; text-align: center; font-size: 32px; font-weight: bold;">
    VỀ CHÚNG TÔI
</div>

<div class="container py-5" style="max-width: 1200px;">
    <div class="intro text-center mb-5">
        <p><strong>SPORTBAY</strong> là điểm đến lý tưởng dành cho những tín đồ thể thao và phong cách năng động. Chúng tôi chuyên cung cấp các sản phẩm chất lượng cao về quần áo, giày dép và phụ kiện thể thao từ các thương hiệu uy tín.</p>
        <p>Với mục tiêu mang đến trải nghiệm mua sắm tốt nhất, SPORTBAY luôn cập nhật xu hướng mới, cải tiến dịch vụ và đặt sự hài lòng của khách hàng lên hàng đầu.</p>
    </div>

    <div class="row text-center">
        <div class="col-md-3 mb-4">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <i class="fas fa-bullseye fa-2x mb-3"></i>
                <h5 class="fw-bold">Tầm Nhìn</h5>
                <p>Trở thành thương hiệu thể thao trực tuyến hàng đầu tại Việt Nam.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <i class="fas fa-heart fa-2x mb-3"></i>
                <h5 class="fw-bold">Giá Trị Cốt Lõi</h5>
                <p>Chất lượng – Uy tín – Tận tâm.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <i class="fas fa-truck-fast fa-2x mb-3"></i>
                <h5 class="fw-bold">Dịch Vụ</h5>
                <p>Giao hàng toàn quốc, đổi trả dễ dàng, hỗ trợ nhanh chóng.</p>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="p-4 bg-light rounded shadow-sm h-100">
                <i class="fas fa-users fa-2x mb-3"></i>
                <h5 class="fw-bold">Đội Ngũ</h5>
                <p>Được vận hành bởi những người trẻ đam mê và chuyên nghiệp.</p>
            </div>
        </div>
    </div>
</div>
@endsection

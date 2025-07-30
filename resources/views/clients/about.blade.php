@extends('clients.layouts.master')

@section('title', 'Về Chúng Tôi')

@section('content')

<!-- Banner -->
<div class="bg-light py-5 text-center">
    <h1 class="fw-bold display-5">VỀ CHÚNG TÔI</h1>
    <p class="text-muted fs-5">Hành trình xây dựng một thương hiệu thể thao uy tín tại Việt Nam</p>
</div>

<!-- Giới thiệu -->
<div class="container py-5">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10 text-center">
            <p class="fs-5">
                <strong>SPORTBAY</strong> là nơi hội tụ của những sản phẩm thể thao chất lượng cao, được lựa chọn kỹ lưỡng từ các thương hiệu hàng đầu trên thế giới.
                Chúng tôi không chỉ cung cấp sản phẩm, mà còn mang đến phong cách sống năng động, hiện đại và đầy cảm hứng.
            </p>
            <p class="fs-5">
                Thành lập từ năm 2021, SPORTBAY đã và đang không ngừng đổi mới để trở thành nền tảng mua sắm thể thao trực tuyến được khách hàng tin tưởng và lựa chọn hàng đầu tại Việt Nam.
            </p>
        </div>
    </div>

    <!-- Hành trình phát triển -->
    <div class="mb-5">
        <h2 class="text-center fw-bold mb-4">Hành Trình Phát Triển</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h5 class="fw-bold">2021: Khởi đầu</h5>
                    <p>SPORTBAY được thành lập với tầm nhìn trở thành thương hiệu thể thao trực tuyến đáng tin cậy. Từ một website đơn giản, chúng tôi bắt đầu xây dựng quy trình vận hành chuyên nghiệp.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h5 class="fw-bold">2022: Tăng trưởng</h5>
                    <p>Chúng tôi ký kết hợp tác với hơn 20 thương hiệu quốc tế, mở rộng danh mục sản phẩm lên hơn 1.000 mặt hàng và đạt hơn 50.000 lượt truy cập/tháng.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <h5 class="fw-bold">2023 - Nay: Đổi mới và dẫn đầu</h5>
                    <p>Ứng dụng công nghệ AI, cải tiến giao diện người dùng, tích hợp chatbot và hệ thống quản lý đơn hàng tự động giúp nâng cao trải nghiệm khách hàng toàn diện.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tầm nhìn - Sứ mệnh - Giá trị -->
    <div class="mb-5">
        <h2 class="text-center fw-bold mb-4">Tầm Nhìn - Sứ Mệnh - Giá Trị Cốt Lõi</h2>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 hover-scale">
                    <i class="fas fa-eye fa-2x text-primary mb-3"></i>
                    <h5 class="fw-bold">Tầm Nhìn</h5>
                    <p>Trở thành nền tảng mua sắm thể thao trực tuyến hàng đầu tại Việt Nam và khu vực Đông Nam Á.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 hover-scale">
                    <i class="fas fa-bullhorn fa-2x text-success mb-3"></i>
                    <h5 class="fw-bold">Sứ Mệnh</h5>
                    <p>Đem đến cho người dùng Việt những sản phẩm thể thao chính hãng, trải nghiệm mua sắm tiện lợi và dịch vụ tận tâm.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100 hover-scale">
                    <i class="fas fa-star fa-2x text-warning mb-3"></i>
                    <h5 class="fw-bold">Giá Trị Cốt Lõi</h5>
                    <ul class="list-unstyled text-start small">
                        <li>✔ Khách hàng là trung tâm</li>
                        <li>✔ Chính trực và minh bạch</li>
                        <li>✔ Đổi mới không ngừng</li>
                        <li>✔ Tinh thần thể thao – đồng đội</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Dịch vụ -->
    <div class="mb-5">
        <h2 class="text-center fw-bold mb-4">Dịch Vụ Của Chúng Tôi</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <i class="fas fa-shipping-fast fa-lg text-info mb-2"></i>
                    <h5 class="fw-bold">Giao hàng toàn quốc</h5>
                    <p>Miễn phí giao hàng cho đơn từ 500.000đ, thời gian từ 1–3 ngày, kiểm tra hàng trước khi thanh toán.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white p-4 rounded shadow-sm h-100">
                    <i class="fas fa-undo fa-lg text-danger mb-2"></i>
                    <h5 class="fw-bold">Đổi trả linh hoạt</h5>
                    <p>Đổi sản phẩm trong vòng 7 ngày, hoàn tiền nhanh chóng nếu sản phẩm lỗi hoặc không đúng mô tả.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Đội ngũ -->
    <div class="mb-5">
        <h2 class="text-center fw-bold mb-4">Đội Ngũ Của Chúng Tôi</h2>
        <div class="text-center">
            <p class="fs-5">SPORTBAY được vận hành bởi một đội ngũ trẻ trung, sáng tạo, yêu thể thao và giàu kinh nghiệm trong lĩnh vực thương mại điện tử.</p>
            <p class="fs-5">Chúng tôi tin rằng con người là yếu tố cốt lõi của sự phát triển bền vững, vì vậy luôn đầu tư vào đào tạo và phát triển năng lực đội ngũ.</p>
        </div>
    </div>

    <!-- Kêu gọi hành động -->
    <div class="bg-primary text-white text-center rounded py-5 px-3">
        <h3 class="fw-bold">Cùng SPORTBAY nâng tầm thể thao Việt</h3>
        <p class="mb-4">Chúng tôi không ngừng đổi mới để mang đến trải nghiệm tốt nhất cho bạn. Cảm ơn bạn đã đồng hành!</p>
       
    </div>
</div>

@endsection



<style>
    .error-container {
        min-height: 80vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 20px;
        background: linear-gradient(to bottom right, #fdfdfd, #f8f9fa);
    }

    .error-image {
        max-width: 320px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0); }
    }

    .error-title {
        font-size: 3rem;
        font-weight: 700;
        margin-top: 30px;
        color: #343a40;
    }

    .error-message {
        font-size: 1.25rem;
        color: #6c757d;
        margin-top: 10px;
        margin-bottom: 30px;
    }

    .error-button {
        padding: 12px 24px;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 8px;
        background-color: #0d6efd;
        color: white;
        border: none;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .error-button:hover {
        background-color: #0b5ed7;
        color: white;
    }

    @media (max-width: 576px) {
        .error-title {
            font-size: 2rem;
        }
        .error-message {
            font-size: 1rem;
        }
    }
</style>

<div class="error-container">
    <img src="{{ asset('assets/client/images/404.png') }}" alt="404 - Không tìm thấy" class="error-image">
    <h1 class="error-title">Ôi không! Trang không tồn tại 😢</h1>
    <p class="error-message">Liên kết bạn truy cập có thể đã bị xóa, đổi tên hoặc chưa bao giờ tồn tại.</p>
    <a href="{{ url('/') }}" class="error-button">Quay về trang chủ</a>
</div>



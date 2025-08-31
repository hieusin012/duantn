<style>
    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: linear-gradient(to bottom right, #fdfdfd, #ffffff);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.1s ease-out;
    }

    .loading-spinner-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .spinner {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 5px solid #e0e0e0;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .loading-logo {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 48px;
        height: 48px;
        transform: translate(-50%, -50%);
        z-index: 2;
        animation: pulse 2s infinite ease-in-out;
        object-fit: contain;
    }

    /* Animation */
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        50% {
            transform: translate(-50%, -50%) scale(1.1);
            opacity: 0.8;
        }
    }
</style>
<!-- Màn hình loading -->
<div id="loading-screen">
    <div class="loading-spinner-wrapper">
        <div class="spinner"></div>
        <img src="{{ asset('assets/client/images/favicon.png') }}" alt="Logo" class="loading-logo">
    </div>
</div>


<script>
    window.addEventListener('load', function () {
        const loader = document.getElementById('loading-screen');
        loader.style.opacity = '0';
        setTimeout(() => loader.style.display = 'none', 100);
    });
</script>

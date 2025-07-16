<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SportBay')</title>
    <link rel="shortcut icon" href="{{ asset('assets/client/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style-min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style-min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />
    @stack('styles')
</head>

<body class="template-index index-demo1">
    <div class="page-wrapper">
        @include('clients.layouts.partials.header')
        @yield('banner')
        <main class="flex-grow-1">
            @yield('content')
        </main>
        @include('clients.layouts.partials.chat')
        @include('clients.layouts.partials.footer')
    </div>
    <script src="{{ asset('assets/client/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/vendor/jquery-migrate-1.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/client/js/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    @if(Session::has('success'))
    <script>
        $.toast({
            heading: 'Thành công !',
            text: "{{ Session::get('success') }}",
            showHideTransition: 'slide',
            icon: 'success',
            position: {
                right: 1,
                top: 83
            },
        })
    </script>
    @endif
    @if(Session::has('error'))
    <script>
        $.toast({
            heading: 'Thất bại !',
            text: "{{ Session::get('error') }}",
            showHideTransition: 'slide',
            icon: 'error',
            position: {
                right: 1,
                top: 83
            },
        })
    </script>
    @endif
    @if (request()->get('message') === 'success')
    <script>
        $.toast({
            heading: 'Thành công !',
            text: 'Bạn đã thanh toán đơn hàng thành công!',
            showHideTransition: 'slide',
            icon: 'success',
            position: {
                right: 1,
                top: 83
            },
        });
    </script>
    @endif
    @if (request()->get('message') === 'warning')
    <script>
        $.toast({
            heading: 'Cảnh báo !',
            text: 'Bạn đã đặt hàng thành công, nhưng chưa thanh toán!',
            showHideTransition: 'slide',
            icon: 'warning',
            position: {
                right: 1,
                top: 83
            },
        });
    </script>
    @endif
    @stack('scripts')
    @yield('scripts')
</body>

</html>
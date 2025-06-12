<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SportBay')</title>

    <link rel="shortcut icon" href="{{ asset('assets/client/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/client/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style-min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/custom.css') }}">

    @stack('styles')
</head>
<body class="template-index index-demo1">
    <div class="page-wrapper">
        @include('clients.layouts.partials.header')
        @yield('banner')

        @yield('content')

        @include('clients.layouts.partials.footer')
    </div>

    <script src="{{ asset('assets/client/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/vendor/jquery-migrate-1.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/client/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>

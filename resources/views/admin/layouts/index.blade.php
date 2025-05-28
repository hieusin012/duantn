<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Siêu Đẹp</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & FontAwesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin/assets1/css/style.css') }}">

  <!-- Thêm vào file layout -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  
</head>
<body>

<!-- Sidebar -->

@include('admin.layouts.partials.sidebar')
<!-- Main content -->
<div class="main">
  <!-- Header -->
  @include('admin.layouts.partials.nav')

  <!-- Dashboard Cards -->
@include('admin.layouts.partials.header')

  <!-- Table -->
@yield('content')

  <!-- Footer -->
 @include('admin.layouts.partials.footer')
</div>

</body>
</html>

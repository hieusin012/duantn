{{-- <!DOCTYPE html>
<html lang="en">

<head>
  <title> Quản trị Admin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/main.css')}}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
  <!-- or -->
  <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

</head>

<body onload="time()" class="app sidebar-mini rtl">
  <!-- Navbar-->
   @include('admin.layouts.partials.header')
  <!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
   @include('admin.layouts.partials.sidebar')
  <main class="app-content">
    <div class="row">
      <div class="col-md-12">
        <div class="app-title">
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><a href="#"><b>@yield('title')</b></a></li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>




  @yield('content')


    @include('admin.layouts.partials.footer')
  </main>
  <script src="js/jquery-3.2.1.min.js"></script>
  <!--===============================================================================================-->
  <script src="js/popper.min.js"></script>
  <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
  <!--===============================================================================================-->
  <script src="js/bootstrap.min.js"></script>
  <!--===============================================================================================-->
  <script src="js/main.js"></script>
  <!--===============================================================================================-->
  <script src="js/plugins/pace.min.js"></script>
  <!--===============================================================================================-->
  <script type="text/javascript" src="js/plugins/chart.js"></script>
  <!--===============================================================================================-->
  <script type="text/javascript">
    var data = {
      labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6"],
      datasets: [{
        label: "Dữ liệu đầu tiên",
        fillColor: "rgba(255, 213, 59, 0.767), 212, 59)",
        strokeColor: "rgb(255, 212, 59)",
        pointColor: "rgb(255, 212, 59)",
        pointStrokeColor: "rgb(255, 212, 59)",
        pointHighlightFill: "rgb(255, 212, 59)",
        pointHighlightStroke: "rgb(255, 212, 59)",
        data: [20, 59, 90, 51, 56, 100]
      },
      {
        label: "Dữ liệu kế tiếp",
        fillColor: "rgba(9, 109, 239, 0.651)  ",
        pointColor: "rgb(9, 109, 239)",
        strokeColor: "rgb(9, 109, 239)",
        pointStrokeColor: "rgb(9, 109, 239)",
        pointHighlightFill: "rgb(9, 109, 239)",
        pointHighlightStroke: "rgb(9, 109, 239)",
        data: [48, 48, 49, 39, 86, 10]
      }
      ]
    };
    var ctxl = $("#lineChartDemo").get(0).getContext("2d");
    var lineChart = new Chart(ctxl).Line(data);

    var ctxb = $("#barChartDemo").get(0).getContext("2d");
    var barChart = new Chart(ctxb).Bar(data);
  </script>
  <script type="text/javascript">
    //Thời Gian
    function time() {
      var today = new Date();
      var weekday = new Array(7);
      weekday[0] = "Chủ Nhật";
      weekday[1] = "Thứ Hai";
      weekday[2] = "Thứ Ba";
      weekday[3] = "Thứ Tư";
      weekday[4] = "Thứ Năm";
      weekday[5] = "Thứ Sáu";
      weekday[6] = "Thứ Bảy";
      var day = weekday[today.getDay()];
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      nowTime = h + " giờ " + m + " phút " + s + " giây";
      if (dd < 10) {
        dd = '0' + dd
      }
      if (mm < 10) {
        mm = '0' + mm
      }
      today = day + ', ' + dd + '/' + mm + '/' + yyyy;
      tmp = '<span class="date"> ' + today + ' - ' + nowTime +
        '</span>';
      document.getElementById("clock").innerHTML = tmp;
      clocktime = setTimeout("time()", "1000", "Javascript");

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
    }
  </script>
  
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Quản trị Admin</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- ✅ CSRF TOKEN -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/main.css') }}">

  <!-- Boxicons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

  <!-- jQuery Confirm -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- SweetAlert -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body onload="time()" class="app sidebar-mini rtl">
  <!-- Navbar -->
  @include('admin.layouts.partials.header')

  <!-- Sidebar -->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  @include('admin.layouts.partials.sidebar')

  <!-- Main content -->
  <main class="app-content">
    <div class="row mt-3">
      <div class="col-md-12">
        <div class="app-title">
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">
              <a href="#"><b>@yield('title')</b></a>
            </li>
          </ul>
          <div id="clock"></div>
        </div>
      </div>
    </div>

    <div id="main-content">
      @yield('content')
    </div>

    
  </main>
  <div class="app-wrapper d-flex flex-column min-vh-100" style="margin-left: 250px;">
    @include('admin.layouts.partials.footer')
  </div>

  <!-- JS: jQuery, Bootstrap, Chart.js -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Clock Script -->
  <script type="text/javascript">
    function time() {
      var today = new Date();
      var weekday = ["Chủ Nhật", "Thứ Hai", "Thứ Ba", "Thứ Tư", "Thứ Năm", "Thứ Sáu", "Thứ Bảy"];
      var day = weekday[today.getDay()];
      var dd = today.getDate();
      var mm = today.getMonth() + 1;
      var yyyy = today.getFullYear();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      var nowTime = h + " giờ " + m + " phút " + s + " giây";
      if (dd < 10) dd = '0' + dd;
      if (mm < 10) mm = '0' + mm;
      var todayStr = day + ', ' + dd + '/' + mm + '/' + yyyy;
      document.getElementById("clock").innerHTML = '<span class="date">' + todayStr + ' - ' + nowTime + '</span>';
      setTimeout(time, 1000);
    }

    function checkTime(i) {
      return (i < 10) ? "0" + i : i;
    }
  </script>
  <!-- Thông báo toastr -->
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
                top: 50
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
                top: 50
            },
        })
    </script>
    @endif
    
  <!-- Yield scripts from children views -->
  @yield('scripts')
  @stack('scripts')
  {{-- Muốn Sidebar không load lại thì bật comment <script> ở dưới --}}
  {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        function ajaxLoadContent(url) {
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#main-content')?.innerHTML;
                if (newContent) {
                    document.querySelector('#main-content').innerHTML = newContent;
                    history.pushState(null, '', url);
                    highlightActiveMenu(url);
                } else {
                    alert("Không thể tải nội dung.");
                }
            })
            .catch(error => {
                console.error('Lỗi khi tải nội dung:', error);
            });
        }

        function highlightActiveMenu(url) {
          const currentPath = new URL(url, location.origin).pathname.replace(/\/+$/, ''); // bỏ dấu / cuối

          let matched = false;

          document.querySelectorAll('.app-menu__item').forEach(link => {
              const linkPath = new URL(link.href, location.origin).pathname.replace(/\/+$/, '');

              if (!matched && linkPath === currentPath) {
                  link.classList.add('active');
                  matched = true; // Đảm bảo chỉ đánh dấu đúng 1 cái đầu tiên match
              } else {
                  link.classList.remove('active');
              }
          });
        }

        document.querySelectorAll('.app-menu__item').forEach(link => {
            link.addEventListener('click', function (e) {
              const url = this.getAttribute('href');
              if (url.startsWith('http') || url.startsWith('/')) {
                  e.preventDefault();
                  ajaxLoadContent(url);
              }
          });
        });
        
        // Hỗ trợ nút Back/Forward của trình duyệt
        window.addEventListener('popstate', () => {
            ajaxLoadContent(location.pathname);
        });
    });
  </script> --}}
</body>
</html>
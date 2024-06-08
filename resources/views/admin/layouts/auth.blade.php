<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <!-- site favicon -->
  <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logo/favicon.png')}}">
  <!-- bootstrap 4  -->
  <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap.min.css')}}">
  <!-- Line awesome  -->
  <link href="{{asset('assets/global/css/line-awesome.min.css')}}" rel="stylesheet">
  <!-- Toastr -->
  <link href="{{asset('assets/global/css/toastr.min.css')}}" rel="stylesheet" />
  @stack('css-link')
  <!-- main css -->
  <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
  @stack('css')
</head>
  <body>
  <!-- Authentication Area Start -->
    <div class="authentication-area">
      <!-- <img src="{{asset('assets/admin/images/1.jpg')}}" class="author-bg"> -->
      <div class="container">
        @yield('content')
      </div>
    </div>
  <!-- Authentication Area End -->
  <!-- jQuery library -->
  <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
  <!-- Toastr -->
  <script src="{{asset('assets/global/js/toastr.min.js')}}"></script>
  <!-- bootstrap js -->
  @stack('js-link')
  <script src="{{asset('assets/admin/js/bootstrap.bundle.min.js')}}"></script>
  <script>
        "use strict";
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }


       @if ($errors->any())
        @foreach ($errors->all() as $emsg)
          toastr.error('{{$emsg}}');
        @endforeach
        @endif
        @if(session()->has('alert'))
          @if(session('alert')[0] == 'danger')
          toastr.error('{{ session('alert')[1] }}');
          @elseif(session('alert')[0] == 'success')
          toastr.success('{{ session('alert')[1] }}');
          @else
          toastr.error('{{ session('alert')[1] }}');
          @endif
        @endif
        function systemAlert(type,message){
          if(type == 'danger'){
            toastr.error(message);
          }else if($type == 'success'){
            toastr.success(message);
          }else{
            toastr.error(message);
          }
        }
  </script>
  @stack('js')
</body>
</html>
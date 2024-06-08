<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$setting->site_name}}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('assets/classicmart/img/favicon.png')}}">
    <link href="{{asset('assets/classicmart/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('assets/classicmart/build/css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('assets/classicmart/build/css/intlTelInput.min.css')}}">
    <link href="{{asset('assets/global/css/toastr.min.css')}}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{asset('assets/css/style.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('assets/classicmart/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/classicmart/css/responsive.css')}}">
    <link href="{{asset('assets/global/css/toastr.min.css')}}" rel="stylesheet" />
    @stack('css-link')
    @stack('css')

</head>

<body>

    @yield('content')

    <script src="{{asset('assets/classicmart/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{asset('assets/classicmart/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/classicmart/js/bootstrap.min.js')}}"></script>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>
    <script src="{{asset('assets/global/js/toastr.min.js')}}"></script>
    <script src="{{asset('assets/classicmart/js/main.js')}}"></script>
    <script src="{{asset('assets/global/js/toastr.min.js')}}"></script>
    @stack('js-link')
    @stack('js')
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
</body>
</html>
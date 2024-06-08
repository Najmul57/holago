<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('assets/classicmart/images/logo/favicon.png')}}" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/bootstrap-extended.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/global/css/line-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/global/css/all.min.css')}}" rel="stylesheet">
    <!-- main css link -->
{{--        <link rel="stylesheet" href="{{asset($templateAssets.'css/main.css')}}"/>--}}
    <!-- loader-->
    <link href="{{asset('assets/admin/css/pace.min.css')}}" rel="stylesheet" />
    <!--plugins-->
    <link href="{{asset('assets/admin/css/simplebar.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/metisMenu.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/global/css/toastr.min.css')}}" rel="stylesheet" />
    <!--Theme Styles-->
    <link href="{{asset('assets/admin/css/dark-theme.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/light-theme.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/semi-dark.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/global/css/select2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/global/css/summernote.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet" />
     <link href="{{asset('assets/admin/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"/>

    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">

    @stack('css-link')
    <title>{{ $setting->site_name }} - @yield('title')</title>
    @stack('css')
</head>

<body>

    <!--start wrapper-->
    <div class="wrapper">
        @include('admin.includes.topbar')
        @include('admin.includes.sidebar')
        <section class="page-content">
            @include('admin.includes.titlebar')
            @yield('content')
        </section>
    </div>

    <!--plugins-->
    <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/bootstrap-toggle.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/global/js/toastr.min.js')}}"></script>
    <script src="{{asset('assets/global/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/pace.min.js')}}"></script>
    <script src="{{asset('assets/global/js/summernote.min.js')}}"></script>
    <!--app-->
    @stack('js-link')
    <script src="{{asset('assets/admin/js/app.js')}}"></script>
        <script src="{{asset('assets/admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/dataTables.bootstrap5.min.js')}}"></script>
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
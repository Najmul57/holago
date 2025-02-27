@extends('layouts.app')
@section('content')
@section('title','Verification Code')

<main class="main">
    <a href="{{ route('home')}}" title="@lang('Go Back')" class="auth-page-close">
        <i class="fa fa-xmark"></i>
    </a>
    <div class="auth">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="auth__content">
                        <div class="auth__wrapper">
                            <!-- login form -->
                            <div class="login__form" id="login__form">
                                <!-- form -->
                                <form action="{{ route('user.password.verify.code') }}" method="post">
                                    @csrf
                                    <h2 class="form__title" > <span id="login__back"><i class="fa fa-long-arrow-left" title="back"></i></span> @lang('Enter Verification Code')</h2>
                                    <p class="form_text">@lang('Access to all features. No credit card required').</p>
                                    <!-- step one -->
                                    <div class="stepOne_login">
                                        <p class="inner__title">@lang('Code')</p>
                                        <div class="form__input_inner">
                                            <input type="text" name="code" id="pincode-input3" required="">
                                        </div>
                                    </div>
                                    <!-- button -->
                                    <div class="submit__button">
                                        <button type="submit" title="back">@lang('Continue') <i class="fa fa-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                                <!-- anchor tag -->
                                <h5 class="d-flex align-items-center"><span id="notAmember">@lang('Don\'t have an Account')? &nbsp;</span><a href="{{ route('user.login')}}">@lang('Sign In')</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- login form end -->
@endsection
@push('css-link')
  <!-- bootstrap-pincode css -->
  <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-pincode-input.css')}}">
@endpush
@push('js-link')
  <script src="{{asset('assets/admin/js/bootstrap-pincode-input.js')}}"></script>
@endpush
@push('css')
<style type="text/css">
  .form-control:focus {
    color: var(--bs-body-color);
    background-color: var(--bs-form-control-bg);
    border: var(--borderColor);
    outline: 0;
    box-shadow:none;
  }
</style>
@endpush
@push('js')
<!-- bootstrap-pincode js -->
  <script>
    (function($){
      "use strict";
      $('#pincode-input3').pincodeInput({
        inputs:6,
        hidedigits:false
      });
    })(jQuery);
  </script>
@endpush

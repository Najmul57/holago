@extends($template.'layouts.frontend_master')
@section('content')
@section('title','Reset Password')
@include($templateInclude.'inner')
<!-- Forgot form -->
<section class="form_section section_padding">
    <div class="container">
        <div class="form_content">
            <!-- form title -->
            <div class="form_titlle">
                <h1 class="form_heading">@lang('Enter Verification Code')</h1>
                <p class="form_text">@lang('Access to all features. No credit card required').</p>
            </div>
            <!-- main form -->
            <form class="form" action="{{ route('company.password.verify.code') }}" method="post">
              @csrf
                <!-- form wrapper -->
                <div class="form_wrapper">

                    <!-- input inner -->
                    <div class="form_input_inner">
                        <input type="text" name="code" id="pincode-input3">
                        <!-- <input type="email" name="email" class="input_control contact_input" required> -->
                        <label class="contact_input_tile">@lang('Code')</label>
                    </div>
                    <!-- submit btn -->
                    <div class="form_submit">
                        <button type="submit" class="main_btn btnHover global_btn">@lang('Forgot Now')</button>
                    </div>
                    <!-- form_footer -->
                    <div class="form_fotter">
                        <span>@lang('Not Forgot Password')!</span>
                        <a href="{{ route('company.login') }}" class="form_link">@lang('Sign In')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Forgot form end -->
@endsection




@push('css-link')
  <!-- bootstrap-pincode css -->
  <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-pincode-input.css')}}">
@endpush
@push('js-link')
  <script src="{{asset('assets/admin/js/bootstrap-pincode-input.js')}}"></script>
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

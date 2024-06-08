@extends('admin.layouts.auth')
@section('content')
@section('title','Admin Login')
    <div class="row justify-content-center align-content-center">
      <div class="col-lg-5 col-md-6">
        <div class="favicon-area">
          <img src="{{asset('assets/images/logo/logo_dark.png')}}">
        </div>
        <div class="auth-card rounded">
          <div class="auth-card-body">
            <div class="login-header text-center pb-3">
              <h4>@lang('Welcome to') <strong>{{$setting->site_name}}</strong></h4>
              <p>@yield('title') @lang('to') {{$setting->site_name}} @lang('dashboard')</p>
            </div>
            <form action="{{ route('admin.login') }}" method="post">
              @csrf
              <div class="form-group mb-3">
                <label class="form-label">@lang('Username')</label>
                <div class="input-field">
                  <input type="text" name="username" class="form-control rounded-pill" required>
                  <i class="las la-user"></i>
                </div>
              </div>
              <div class="form-group mb-3">
                <label class="form-label">@lang('Password')</label>
                <div class="input-field">
                  <input type="password" name="password" class="form-control rounded-pill" required>
                  <i class="las la-lock"></i>
                </div>
              </div>
              <div class="form-group">
                  @php echo loadReCaptcha() @endphp
                  <div id="g-recaptcha-error"></div>
              </div>
              <div class="form-group">
                <div class=" mt-2 mb-sm-0 mb-3 forgot-icon">
                  <a href="{{ route('admin.password.reset') }}" class="text-muted">
                    <i class="las la-lock"></i> @lang('Forgot password?') 
                  </a>
                </div>
                <div class="login-button mt-25">
                  <button type="submit" class="btn btn-primary w-100 submit rounded-pill"><i class="las la-sign-in-alt"></i> @lang('Login')</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        function submitUserForm() {
            var response = grecaptcha.getResponse();
            if (response.length == 0) {
                document.getElementById('g-recaptcha-error').innerHTML = '<span class="text-danger">@lang("Captcha field is required.")</span>';
                return false;
            }
            return true;
        }
    </script>
@endpush
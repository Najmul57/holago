@extends('admin.layouts.auth')
@section('content')
@section('title','Reset Password')
<div class="row justify-content-center align-content-center">
  <div class="col-lg-4 col-md-6">
    <div class="favicon-area">
        <img src="{{asset('assets/images/logo/logo_dark.png') }}">
    </div>
    <div class="auth-card">
      <div class="auth-card-body">
        <form action="{{ route('admin.password.reset.submit') }}" method="post">
          @csrf
          <input type="hidden" name="email" value="{{ $email }}">
          <input type="hidden" name="token" value="{{ $token }}">
          <div class="form-group mb-3">
            <label class="form-label">@lang('New Password')</label>
            <div class="input-field">
              <input type="password" name="password" class="form-control rounded-pill">
              <i class="las la-lock"></i>
            </div>
          </div>
          <div class="form-group mb-3">
            <label class="form-label">@lang('Confirm Password')</label>
            <div class="input-field">
              <input type="password" name="password_confirmation" class="form-control rounded-pill">
              <i class="las la-lock"></i>
            </div>
          </div>
          <div class="form-group mt-25">
            <div class="float-start">
              <a href="{{ route('admin.login') }}"><i class="las la-arrow-circle-left"></i> @lang('Back to login')</a>
            </div>
            <div class="float-end">
              <button class="btn btn-primary rounded-pill"><i class="las la-check-circle"></i> @lang('Reset')</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

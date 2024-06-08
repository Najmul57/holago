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
        <form action="{{ route('admin.password.reset') }}" method="post">
          @csrf
          <div class="form-group">
            <label class="form-label">@lang('Enter Your E-mail')</label>
            <div class="input-field">
              <input type="email" name="email" class="form-control rounded-pill">
              <i class="las la-envelope"></i>
            </div>
          </div>
          <div class="form-group mt-25">
            <div class="float-start">
              <a href="{{ route('admin.login') }}"><i class="las la-arrow-circle-left"></i> @lang('Back')</a>
            </div>
            <div class="float-end">
              <button class="btn btn-primary rounded-pill"><i class="las la-check-circle"></i> @lang('Submit')</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

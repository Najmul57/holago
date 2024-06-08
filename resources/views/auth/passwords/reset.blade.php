@extends('layouts.app')
@section('content')
@section('title','Reset Password')

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
                                <form action="{{ route('user.password.reset.submit') }}" method="post">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="phone" value="{{ $phone ?? old('phone') }}">
                                    <h2 class="form__title" > <span><i class="fa fa-long-arrow-left" title="back"></i></span> @lang('New Password')</h2>
                                                <p class="form_text">@lang('Access to all features. No credit card required.')</p>
                                    <!-- step one -->
                                    <div class="stepOne_login">
                                        <p class="inner__title">@lang('New Password')</p>
                                        <div class="form__input_inner">
                                            <input type="password" name="password" required="">
                                        </div>
                                    </div>
                                    <!-- step one -->
                                    <div class="stepOne_login">
                                        <p class="inner__title">@lang('Confirm Password')</p>
                                        <div class="form__input_inner">
                                            <input type="password" name="password_confirmation" required="">
                                        </div>
                                    </div>
                                    <!-- button -->
                                    <div class="submit__button">
                                        <button type="submit" title="back">@lang('Confirm') <i class="fa fa-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                                <!-- anchor tag -->
                                <h5 class="d-flex align-items-center"><span id="notAmember">@lang('Not Reset Password')?
                                        &nbsp;</span><a href="{{ route('user.login')}}">@lang('Sign In')</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

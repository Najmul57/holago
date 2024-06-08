@extends('layouts.app')
@section('content')
@section('title', 'User Login')
<!-- login form -->
<main class="main">
    <a href="{{ route('home') }}" title="@lang('Go Back')" class="auth-page-close">
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
                                <form action="{{ route('user.login') }}" method="post" id="loginForm">
                                    @csrf
                                    <h2 class="form__title"> <span id="login__back"><i class="fa fa-long-arrow-left"
                                                title="back"></i></span> @lang('Login')</h2>
                                    <div class="alert alert-danger" id="error" style="display: none;"></div>
                                    <div class="alert alert-success" id="sentSuccess" style="display: none;"></div>
                                    <!-- step one -->
                                    <div class="stepOne_login">
                                        <p class="inner__title">@lang('Use Phone Number/E-mail')</p>
                                        <div class="form__input_inner">
                                            <input type="text" name="phone" id="phone" required>
                                        </div>
                                        <p class="inner__title">@lang('Use Password')</p>
                                        <div class="form__input_inner">
                                            <input type="password" name="password" id="password">
                                        </div>


                                        <div class="mt-4" id="recaptcha-container"></div>
                                        <br>
                                        <div class="remember">
                                            <input type="checkbox" class="form-check-input" id="remeber">
                                            <label for="remeber">@lang('Remember Me')</label>
                                        </div>
                                    </div>


                                    <!-- button -->
                                    <div class="submit__button">
                                        <button type="submit" title="back">@lang('Continue') <i
                                                class="fa fa-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                                <!-- anchor tag -->
                                <h5 class="d-flex align-items-center"><span id="notAmember">@lang('Not a member yet')?
                                        &nbsp;</span><a href="{{ route('user.register') }}"
                                        id="register__btn_link">@lang('Register Now')</a></h5>
                                <a href="{{ route('user.password.reset') }}">@lang('Reset Password')</a>
                            </div>
                            <!-- registration form -->
                            <div class="registar__form" id="registar__form">
                                <!-- form -->
                                <form action="">
                                    <h2 class="form__title">Register</h2>
                                    <div class="form__input_inner">
                                        <input type="text" id="mobile">
                                    </div>
                                    <!-- button -->
                                    <div class="submit__button">
                                        <button type="submit">Continue <i class="fa fa-long-arrow-right"></i>
                                    </div>
                                </form>
                                <!-- anchor tag -->
                                <h5><span>Already a member?</span><a id="login__btn_link"> Login Now</a></h5>
                            </div>
                            <!-- forgot form -->
                            {{-- <div class="forgot__form" id="forgot__form">
                                <!-- form -->
                                <form action="">
                                    <h2 class="form__title" title="back"> <span id="reset__back"><i
                                                class="fa fa-long-arrow-left"></i></span> Reset Password</h2>
                                    <p class="inner__title">Use Phone Number</p>
                                    <div class="form__input_inner">
                                        <input type="text" id="phone">
                                    </div>
                                    <!-- button -->
                                    <div class="submit__button">
                                        <button type="submit">Continue <i class="fa fa-long-arrow-right"></i>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection







@include('auth.script')
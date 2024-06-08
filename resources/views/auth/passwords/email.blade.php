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
                                <form action="{{ route('user.password.reset') }}" method="post" id="login__stepForm">
                                    @csrf
                                    <h2 class="form__title" > <span id="login__back"><i
                                                class="fa fa-long-arrow-left" title="back"></i></span> @lang('Reset Password')</h2>
                                    <!-- step one -->
                                    <div class="stepOne_login">
                                        <p class="inner__title">@lang('Phone Number')</p>
                                        <div class="form__input_inner">
                                            <input type="number" name="phone" id="phone" required>
                                        </div>
                                    </div>
                                    <!-- button -->
                                    <div class="submit__button">
                                        <button type="submit" title="back">@lang('Continue') <i class="fa fa-long-arrow-right"></i>
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

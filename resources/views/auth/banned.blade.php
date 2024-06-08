@extends('layouts.app')
@section('content')
@section('title','Banned')
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
                                    
                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif
                                     <div class="account-head-area">
                                        <i class="fas fa-ban text-danger"></i>
                                    </div>

                                    {{ __('Your account has been banned by admin') }}
                                
                                    <a href="{{ route('user.logout') }}" class="btn btn-link p-0 m-0 align-baseline">{{ __('Logout') }}</a>
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

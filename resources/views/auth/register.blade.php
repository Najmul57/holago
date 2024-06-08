@extends('layouts.app')
@section('content')
@section('title', 'User Registration')
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
                                <form action="" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h2 class="form__title"> <span id="login__back"><i class="fa fa-long-arrow-left"
                                                title="back"></i></span> @lang('User Registration')</h2>
                                    <div class="row">
                                        {{-- <div class="col-md-6"> --}}
                                        {{-- <p class="inner__title">@lang('Use Full Name')</p> --}}
                                        {{-- <div class="form__input_inner"> --}}
                                        {{-- <input type="text" name="name" id="name"> --}}
                                        {{-- </div> --}}
                                        {{-- </div> --}}
                                        {{-- <div class="col-md-6"> --}}
                                        {{-- <p class="inner__title">@lang('Username')</p> --}}
                                        {{-- <div class="form__input_inner"> --}}
                                        {{-- <input type="text" name="username" id="username" required> --}}
                                        {{-- </div> --}}
                                        {{-- </div> --}}
                                        <div class="col-md-6">
                                            <p class="inner__title">@lang('Use Number')</p>
                                            <div class="form__input_inner">
                                                <input type="number" name="phone" value="{{ old('phone') }}"
                                                    id="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="inner__title">@lang('Use Email')</p>
                                            <div class="form__input_inner">
                                                <input type="email" name="email" value="{{ old('email') }}"
                                                    id="email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p for="password" class="inner__title">@lang('Password')</p>
                                            <div class="form__input_inner">
                                                <input id="password" type="password" name="password">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p for="password-confirm" class="inner__title">@lang('Re-Password')</p>
                                            <div class="form__input_inner">
                                                <input id="password-confirm" type="password"
                                                    name="password_confirmation" required="">
                                            </div>
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
                                <h5 class="d-flex align-items-center"><span id="notAmember">@lang('Already a member')?
                                        &nbsp;</span><a href="{{ route('user.login') }}"
                                        id="register__btn_link">@lang('Login Now')</a></h5>
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

@push('css')
<style>
    .auth__wrapper {
        width: 800px !important;
    }
</style>
@endpush

@push('js')
<script src = "https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" >
</script>
<script>
function test(){
    const data = {
         _token:  "{{ csrf_token() }}",
    api_token: "5vnbfovj-5zwjqlbh-icxlcot9-tfyilidc-yvp7bsaz",
    sid: "HOLAGO",
    sms: "SMS Text",
    msisdn: "01790173857",
    csms_id: "01970173857"
};

// Make a POST request using Axios
axios.post('https://smsplus.sslwireless.com/api/v3/send-sms', data)
.then(function (response) {
// Handle the successful response here
console.log('Response:', response);
})
.catch(function (error) {
// Handle any errors that occurred during the request
console.error('Error:', error);
});
}
</script>
@endpush
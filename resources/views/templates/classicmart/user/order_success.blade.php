@extends($template.'layouts.master')
@section('content')




        <div class="vh-100 w-100 d-flex justify-content-center align-items-center">
            <div>
                <div class="mb-4 text-center">
                     <img src="{{asset('assets/images/success.png')}}" width="300" height="300" alt="">
                </div>
                <div class="text-center">
                    <h1>Thank You !</h1>
                    <p>For Completing Order </p>
                    <a href="{{route('home')}}" class="btn btn-primary">Back Home</a>
                </div>
            </div>





@endsection
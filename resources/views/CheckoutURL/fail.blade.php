@extends($template.'layouts.master')
@section('content')
    <div style="text-align: center">
        <h1>Sorry !! Payment Failed, Please try again later.</h1>
    </div>
    <br><br>
    <div style="text-align: center; color: red;">
        @if(isset($response))
            {{ $response }}
        @endif
    </div>
@endsection

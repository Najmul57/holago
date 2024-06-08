@extends($template.'layouts.master')
@section('content')
    <div style="text-align: center;">
        <h1>Congratulations !! Your payment has been successfully done.</h1>
    </div>
    <br><br>
    <div style="text-align: center;">
        @if(isset($response))
            {{ $response }}
        @endif
    </div>
@endsection

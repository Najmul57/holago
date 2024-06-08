@extends($template.'layouts.master')
@section('content')

        <div class="card">
            <div class="card-body">
                <h3>Invoice#<span>{{ $order_number }}</span></h3>
            </div>
        </div>


@endsection
@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endpush

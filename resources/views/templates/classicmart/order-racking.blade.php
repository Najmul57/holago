@extends($template.'layouts.master')
@section('content')
    <!-- tracking start -->
    <div class="tracking-area section-padding">
        <div class="container">
            <div class="row g-0 align-items-center">
                <div class="col-md-6">
                    <div class="tracking-map">
                        <img class="w-100" src="{{ displayImage($templateAssets.'img/Track.gif') }}"  alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tracking-content">
                        <p>To track your order please enter your Order ID in the box below and press the "Track"
                            button. This was given to you on your receipt and in the confirmation email you should
                            have received.</p>

                        <div class="tracking-form mt-3">
                            <form action="{{route('order.track')}}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="material-textfield">
                                                <input placeholder=" " type="text"  class="@error('order_number') is-invalid @enderror" name="order_number" required>
                                                <label>Order ID</label>
                                            </div>
                                            @error('order_number')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-12 col-sm-12 col-12">
                                        <div class="form-group">
                                            <div class="material-textfield">
                                                <input placeholder=" " type="email" name="email">
                                                <label>Billing email</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn">Track</button>
                            </form>
                        </div>
                        @if(isset($trackData))
                                <div class="track__box">
                                            <p> <span class="track_box_title">Order Number:</span> {{$trackData->order_number}}</p>
                                            <p> <span class="track_box_title">Status:</span>
                                                @if($trackData->status == 1)
                                                    <span>Pending</span>
                                                @elseif($trackData->status == 2)
                                                    <span>Confirmed</span>
                                                @elseif($trackData->status == 3)
                                                    <span>Processing</span>
                                                @elseif($trackData->status == 4)
                                                    <span>Delivered</span>
                                                @elseif($trackData->status == 5)
                                                    <span>Cancelled</span>
                                                @else
                                                    <span>Order Number Dosen't Match</span>
                                                @endif
                                            </p>
                                </div>
                            @else
                                <span></span>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- tracking end -->
@endsection

@extends($template.'layouts.master')
@section('content')
    <!-- account start -->
    <div class="account-area section-padding">
        <div class="container">
            <div class="row user-dashboard align-items-start">
                @include($templateUserInclude.'sidebar')
                <div class="col-xl-10 col-lg-8 col-md-7">
                    <div class="account-myorder">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title fs-5 fw-normal" id="viewOrderLabel">Order #HLG- <b>{{__($orders_data->order_number)}}</b> was placed on <b>{{ \Carbon\Carbon::parse($orders_data->created_at)->format('j F, Y') }}</b> and is currently Processing.</h6>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="order-received-product-info border">
                                                    <h4>Order details</h4>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <tbody>

                                                            @php
                                                                $sub_total = 0
                                                            @endphp
                                                            @foreach($orders_data->order_details as $key => $value)
                                                                <tr>
                                                                    <td scope="row">{{ $key+1 }}</td>
                                                                    <td>{{__($value->product->name)}}</td>
                                                                    <td>{{__($value->quantity)}}</td>
                                                                    <td>{{ __($setting->currency_symbol)}} {{__($value->regular_price)}}</td>
                                                                    <td>{{ __($setting->currency_symbol)}} {{__($value->regular_price * $value->quantity)}}</td>
                                                                </tr>
                                                                @php $sub_total += $value->product->regular_price * $value['quantity'] @endphp
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="checkout-payment-area p-4">
                                                        <p><strong>Subtotal :</strong> <span>{{__($setting->currency_symbol)}} {{__(number_format($sub_total,2))}}</span></p>
                                                        <p><strong>Shipping :</strong><span> {{__($setting->currency_symbol)}} {{__($orders_data->shipping_charge)}}</span></p>
                                                        <p><strong>Discount :</strong><span>{{__($setting->currency_symbol)}} 0.00</span></p>
                                                        <p><strong>Payment Method :</strong>
                                                            @if($orders_data->order_type == 'cod')
                                                            <span>Cash on delivery</span>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </p>
                                                        <p><strong>Total :</strong><span>{{__($setting->currency_symbol)}} {{ number_format(($sub_total + $orders_data->shipping_charge),2) }} (includes Tax)</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="user-address-info">
                                                    <div class="shipping-address border">
                                                        <h4>Shipping address</h4>
                                                        <address>
                                                            @php
                                                                $jsonData = $orders_data->shipping_address;
                                                                $data = $jsonData;
                                                            @endphp
                                                            <span>Name: {{ $data['name'] }}</span>
                                                            <span>Mobile: {{ $data['mobile'] }}</span>
                                                            <span>Email: {{ $data['email'] }}</span>
                                                            <span>District ID: {{ $data['district_id'] }}</span>
                                                            <span>Address: {{ $data['address'] }}</span>
                                                            <span>Shipping Place: {{ $data['shipping_place'] }}</span>
                                                            <span>Note: {{ $data['note'] }}</span>
                                                        </address>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- account end -->
    <!-- view order modal -->

@endsection
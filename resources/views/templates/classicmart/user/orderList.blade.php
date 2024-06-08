@extends($template.'layouts.master')
@section('content')

<!-- account start -->
<div class="account-area section-padding">
    <div class="container">
        <div class="row user-dashboard align-items-start">
        	@include($templateUserInclude.'sidebar')
            <div class="col-xl-10 col-lg-8 col-md-7">
                <div class="account-myorder">

                    <div class="user-dashboard-content table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($orders->count() > 0)
                            @foreach($orders as $order)
                                <tr>
                                        <td data-bs-toggle="modal" data-bs-target="#viewOrder">#HLG-{{__($order->order_number)}}</td>
                                        <td>{{showDateTime($order->updated_at,'d M, Y')}}</td>
                                        <td>Processing</td>
                                        <td>{{__($setting->currency_symbol)}} {{__(number_format($order->total_amount,2))}}</td>
                                        <td>
                                            <a href="{{route('user.my.order.data',$order->id)}}" target="_blank" class="btn"  title="View Order"><i class="fa fa-eye text-black"></i></a>
                                            <!-- <a href="#" class="btn " title="Invoice Download"><i class="fa fa-download text-black"></i></a> -->
                                        </td>
                                </tr>
                            @endforeach
                            @else
                                 <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                                 </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- account end -->
<!-- view order modal -->
<div class="modal fade" id="viewOrder" tabindex="-1" aria-labelledby="viewOrderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fs-5 fw-normal" id="viewOrderLabel">Order #HLG-50655 was placed on July
                    3, 2023 and is currently Processing.</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="order-received-product-info border">
                            <h4>Order details</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <span class="product-count"><i class="fa fa-xmark"></i> 1</span>
                                            <a href="#">
                                                Indigo Blue Dye Printed Panjabi
                                            </a>
                                        </td>
                                        <td>
                                                        <span>
                                                            Size : XXXL
                                                        </span>
                                        </td>
                                        <td>
                                            ৳1,400.00
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="checkout-payment-area p-4">
                                <p><strong>Subtotal :</strong> <span>৳15,400.00</span></p>
                                <p><strong>Shipping :</strong><span>৳50.00 via Dhaka</span></p>
                                <p><strong>Discount :</strong><span>৳50.00</span></p>
                                <p><strong>Payment Method :</strong><span>Cash on delivery</span></p>
                                <p><strong>Total :</strong><span>৳2,440.00 (includes ৳113.81 Tax)</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="user-address-info">
                            <div class="billing-address border">
                                <h4>Billing address</h4>
                                <address>
                                    <span>Md Najmul Hasan</span>
                                    <span>Classic IT</span>
                                    <span>Uttara</span>
                                    <span>Dhaka</span>
                                    <span>+8801937563157</span>
                                    <span>najmulcse2@gmail.com</span>
                                </address>
                            </div>
                            <div class="shipping-address border">
                                <h4>Shipping address</h4>
                                <address>
                                    <span>Md Najmul Hasan</span>
                                    <span>Classic IT</span>
                                    <span>Uttara</span>
                                    <span>Dhaka</span>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

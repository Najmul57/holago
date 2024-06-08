@extends($template.'layouts.master')
@section('content')
  <!-- cart start -->
  <div class="cart-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="h_clup_point_distibution d-flex align-items-center bg-black p-3 rounded">
                    <div class="h_club-header">
                        <img src="{{ asset($templateAssets.'img/level-default.png') }}" alt="">
                        <h6 class="text-white text-center">BASIC</h6>
                    </div>
                    <ul class="h_club-list">
                        <li class="text-white"><i class="fa fa-check text-white"></i>&nbsp; Complete this order
                            to get 4940 HOLAGO CLUB
                            POINTS. </li>
                        <li class="text-white"><i class="fa fa-check text-white"></i>&nbsp; Create an account to
                            get 1000 HOLAGO CLUB POINTS. <span data-toggle="tooltip" data-placement="top"
                                title="Join our club! For every ৳100 you get 100 HOLAGO CLUB POINTS.">
                                <i class="fa fa-info-circle text-white"></i>
                            </span>
                        </li>
                        <li>
                            <a href="{{route('user.my.points')}}">my holago club</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h4 class="text-center my-5">Shopping Cart</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-9 col-xl-9 col-lg-9">
                <div class="cart-list">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">@lang('PRODUCT DETAILS')</th>
                                    <th scope="col">@lang('PRODUCT ATTRIBUTE')</th>
                                    <th scope="col">@lang('UNIT PRICE')</th>
                                    <th scope="col">@lang('QUANTITY')</th>
                                    <th scope="col">@lang('AMOUNT')</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $sub_total = 0;
                            @endphp
                            {{-- @dd($data->productAttributes) --}}

                            @foreach ($data as $item)
                            {{-- @dd() --}}

                                <tr class="product_data">
                                    <input type="hidden" class="cartId" value="{{$item->id}}">
                                    <td>
                                        <div class="single-cart-product">
                                            <div class="single-cart-product-photo">
                                                <a href="#">
                                                    <img src="{{ asset($templateAssets.'images/products/'.$item->product->image) }}" alt="product image">
                                                </a>
                                            </div>
                                            <div class="single-cart-product-content">
                                                <div class="cart-product-name d-flex justify-content-between">
                                                    <div>
                                                        <h5><a href="#">{{__($item->product->name)}}</a></h5>
                                                        <h6>@lang('HOLAGO CLUB POINTS'): {{__($item->product->points)}}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->productAttributes == null)
                                        '-'
                                    @else
                                        {{__($item->productAttributes->content ?? '') }}
                                    @endif

                                    </td>
                                    <td>
                                        <div class="cart-product-price">
                                            @if($item->product->discount_price == null || $item->product->discount_price == 0)
                                                {{__($setting->currency_symbol)}} {{__($item->product->regular_price) }}
                                            @else
                                                {{__($setting->currency_symbol)}} {{__($item->product->discount_price) }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>

                                        <input type="hidden" class="prod_id" value="{{$item->product_id}}">
                                        <div class="cart-product-quantity d-flex justify-content-between align-items-center m-0">
                                            <div class="product_quantity cart-item">
                                                <a href=""  class="quantity__minus cart-decrease dec change_quantity"><span><i class="fa fa-minus"></i></span></a>
                                                <input type="text"  class="quantity__input pro_quantity"  min="1"  id='' name="quantity" value="{{$item->quantity}}">
                                                <a href="" class="quantity__plus cart-increase inc active change_quantity"><span><i
                                                            class="fa fa-plus"></i></span></a>
                                            </div>
                                            <div id="loading"></div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->product->discount_price == null || $item->product->discount_price == 0)
                                            {{__($setting->currency_symbol)}} {{__($item->product->regular_price * $item->quantity) }}
                                        @else
                                            {{__($setting->currency_symbol)}} {{__($item->product->discount_price * $item->quantity) }}
                                        @endif
                                    </td>
                                    <input type="hidden" class="selectAttribute" value="{{$item->product_attribute_id}}">
                                    <td>
                                        <a href="javascript:void(0)">
                                            <span class="edit remove-cart" data-id="{{$item->id}}"><i class="fa fa-xmark"  title="remove item"></i></span>
                                        </a>
                                    </td>
                                </tr>
                                @if($item->product->discount_price == null || $item->product->discount_price == 0)
                                    @php $sub_total += $item->product->regular_price * $item['quantity'] @endphp
                                @else
                                    @php $sub_total += $item->product->discount_price * $item['quantity'] @endphp
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{route('shop')}}" class="checkout-btn d-inline px-5 continueBtn">Continue Shopping</a>
                </div>
                <div class="cart-list-mobile d-none">
                    <div class="mobile-cart-table">
                        <table class="table table-bordered">
                            @php
                                $sub_total = 0;
                                $total_point =0;
                            @endphp
                            @foreach ($data as $item)
                            <tr>
                                <td>Product</td>
                                <td>
                                    <div class="single-cart-product">
                                        <div class="single-cart-product-photo">
                                            <a href="#">
                                                <img src="{{ asset($templateAssets.'images/products/'.$item->product->image) }}" alt="">
                                            </a>
                                        </div>
                                        <div class="single-cart-product-content">
                                            <div class="cart-product-name d-flex justify-content-between">
                                                <div>
                                                    <a href="#">{{__($item->product->name)}}</a>
                                                    <h6>HOLAGO CLUB POINTS: {{__($item->product->points)}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>
                                    @if($item->product->discount_price == null || $item->product->discount_price == 0)
                                        {{__($setting->currency_symbol)}}{{__($item->product->regular_price) }}
                                    @else
                                        {{__($setting->currency_symbol)}}{{__($item->product->discount_price) }}
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td>
                                    <input type="hidden" class="prod_id" value="{{$item->id}}">
                                    <div class="cart-product-quantity d-flex justify-content-between align-items-center m-0">
                                        <div class="product_quantity cart-item">
                                            <a href=""  class="quantity__minus cart-decrease dec change_quantity"><span><i class="fa fa-minus"></i></span></a>
                                            <input type="text"  class="quantity__input pro_quantity"  min="1"  id='' name="quantity" value="{{$item->quantity}}">
                                            <a href="" class="quantity__plus cart-increase  inc active change_quantity"><span><i
                                                        class="fa fa-plus"></i></span></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>AMOUNT</td>
                                @if($item->product->discount_price == null || $item->product->discount_price == 0)
                                    <td>{{__($setting->currency_symbol)}}{{__($item->product->regular_price * $item->quantity) }}</td>
                                @else
                                    <td>{{__($setting->currency_symbol)}}{{__($item->product->discount_price * $item->quantity) }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td></td>
                              <td>
                                  <a href="javascript:void(0)">
                                      <span class="edit remove-cart" data-id="{{$item->id}}"><i class="fa fa-xmark"  title="remove item"></i></span>
                                  </a>
                              </td>
                            </tr>
                                @if($item->product->discount_price == null || $item->product->discount_price == 0)
                                    @php $sub_total += $item->product->regular_price * $item['quantity'] @endphp
                                @else
                                    @php $sub_total += $item->product->discount_price * $item['quantity'] @endphp
                                @endif
                                @php $total_point += $item->product->points * $item['quantity'] @endphp
                            @endforeach
                        </table>
                    </div>
                    <a href="{{route('shop')}}" class="checkout-btn d-inline continueBtn">Continue Shopping</a>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3">
                <div class="cart-view-total-amount">
                    <div class="form-group position-relative">
                        <input type="text" class="form-control" name="coupon_code" placeholder="@lang('Enter Coupon Code')">
                        <button type="botton" name="coupon_apply">@lang('Apply Coupon')</button>
                    </div>

                    <div class="cart-view-grand-total">
                        <h5>Grand total</h5>
                        <div class="checkout-amount">
                            <p>
                                <span>Subtotal :</span>
                                <span>{{__($setting->currency_symbol)}} <span id="cartSubtotal">{{__(number_format($sub_total,2))}}</span></span>
                            </p>
                            <p>
                                <span>Discount :</span>
                                <span>{{__($setting->currency_symbol)}}<span id="couponAmount">{{@session('coupon')['amount']??0}}</span></span>
                            </p>
                            <p>
                                <span>Total Points :</span>
                                <span><span id="">{{$total_point}}</span></span>
                            </p>
                            <p>
                                <span>Total :</span>
                                <span>{{__($setting->currency_symbol)}} <span id="finalTotal">{{ number_format(($sub_total - @session('coupon')['amount'] ?? 0), 0) }}</span></span>
                            </p>
                        </div>
                        <a href="{{ route('checkout')}}" class="checkout-btn">@lang('CHECKOUT')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- cart end -->
@endsection
@push('js')


@endpush
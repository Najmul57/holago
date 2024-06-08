@if($data->count() > 0)
    <div class="offcanvas-body">
    @php
        $sub_total = 0;
    @endphp
        @foreach($data as $item)
            <div class="single-cart-item">
                <div class="single-cart-product d-flex">
                    <div class="sigle-cart-product-photo">
                        <a href="#">
                            <img src="{{ asset($templateAssets.'images/products/'.$item->product->image) }}" alt="">
                        </a>
                    </div>
                    <div class="sigle-cart-product-content">
                        <div class="cart-product-name d-flex justify-content-between">
                            <div>
                                <a href="#">{{ __($item->product->name) }} - {{__($item->productAttributes->content)}}</a>
                                <h6>HOLAGO CLUB POINTS: {{ __($item->product->points ?? 0) }}</h6>
                                <h6>HOLAGO CLUB POINTS: <br> {{ __($item->product->points ?? 0) }} ( {{ __($item->product->points ?? 0) }} * {{$item->quantity}} )</h6>
                            </div>
                            <a href="javascript:void(0)">
                                <span class="edit remove-cart" data-id="{{$item->id}}"><i class="fa fa-xmark"  title="remove item"></i></span>
                            </a>
                        </div>
                        <div class="cart-product-quantity d-flex justify-content-between align-items-center">

                            @if($item->product->discount_price == null)
                                <div>{{$setting->currency_symbol}}{{__($item->product->regular_price)}} x {{$item->quantity}}</div>
                            @else
                                <div>{{$setting->currency_symbol}}{{__($item->product->discount_price)}} x {{$item->quantity}}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @if($item->product->discount_price == null)
                @php $sub_total += $item->product->regular_price * $item->quantity @endphp
            @else
                @php $sub_total += $item->product->discount_price * $item->quantity @endphp
            @endif
        @endforeach
</div>
    <div class="offcanvas-footer p-3 cartModalFooter">
        <div class="footer-item d-flex align-items-center justify-content-between">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel"><strong>Subtotal : </strong></h5>
            <span>{{__($setting->currency_symbol)}}{{__(number_format($sub_total,2))}}</span>
        </div>
        <div class="footer-item pt-3">
            <a href="{{route('shopping-cart')}}" class="cartBtn cartBtn-top mb-2">@lang('VIEW CART')</a>
            <a href="{{ route('checkout')}}" class="cartBtn cartBtn-bottom">@lang('CHECKOUT')</a>
        </div>
    </div>
@else
    <div style="padding-top: 50px; text-align: center; color: red; font-size: 20px;">No product in your cart</div>
@endif

@push('js')
@endpush

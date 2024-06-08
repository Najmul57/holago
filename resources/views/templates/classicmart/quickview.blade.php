<style>
    .quick-image-size .btn.disabled::after {
        left: 50%;
    }

    .quick-image-size .btn.disabled::before {
        left: 50%;
}
</style>
<div class="row">
    <div class="col-md-5">
        <div class="quick_image">
            <img class="w-100" src="{{displayImage($templateAssets.'images/products/'.$product->image)}}" alt="">
        </div>
    </div>
    <div class="col-md-7">
        <div class="product_quick_view-content">
            <h4 class="name">{{__($product->name)}}</h4>
            <h6 class="price">
                @if($product->discount_price)
                    <span class="discount__price"><del>{{$setting->currency_symbol}}{{__($product->regular_price)}}</del></span>
                    {{$setting->currency_symbol}}{{__(number_format($product->discount_price,2))}}
                @else
                    {{$setting->currency_symbol}}{{__(number_format($product->regular_price,2))}}
                @endif
            </h6>
            <div class="content">
                <p class="description">@php echo __($product->description) @endphp</p>
            </div>
              <div class=" align-items-center">
                <strong>Size : <span class="attribute_size_of_stock"></span> </strong><br>
                <strong>stock :<span class="product_stock_of_size"></span></strong>
            </div>

           <div class="quick-image-size">
                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                   @foreach ($product->product_attribute as $size)
                                @php
                                    $productStock = \App\Models\ProductStocks::quantity($product->id, $size->id)->first();
                                @endphp

                                <input type="radio" class="btn-check" data-id="{{ $product->id }}" name="btnradio"
                                       autocomplete="off" value="{{ $size->id }}"
                                >

                                @if ($productStock && ($productStock->quantity == 0 || $productStock->quantity === null))
                                    <label class="btn product__size_btn disabled" attribute_id="{{ $size->id }}"
                                           data-id="{{ $product->id }}" title="&nbsp; {{ $size->content }} &nbsp;">
                                        {{ $size->content }}
                                    </label>
                                @else
                                    <label class="btn product__size_btn" attribute_id="{{ $size->id }}"
                                           data-id="{{ $product->id }}" title="&nbsp; {{ $size->content }} &nbsp;">
                                        {{ $size->content }}
                                    </label>
                                @endif

                                {{-- @dd($productStock->quantity); --}}
                    @endforeach

                </div>
            </div>
            <div class="quick-view_cart-product">
                <div class="cart-product-quantity d-flex align-items-center">
                    <div class="attr-data">
                    </div>
                    <div class="product_quantity cart-plus-minus quantity">
                        <div class="cart-decrease qtybutton dec">
                            <span><i class="fa fa-minus"></i></span>
                        </div>
                        <input type="number" name="quantity" step="1" min="1" value="1" class="integer-validation quantity__input">
                        <div class="cart-increase qtybutton inc"><span><i class="fa fa-plus"></i></span>
                        </div>
                    </div>
                    <button type="submit" class="addToCart cart-add-btn"  data-id="{{ $product->id }}">@lang('Add to cart')</button>
                    @php
                        $wCk = checkWishList($product->id);
                    @endphp
                    <div class="product_quick_heart">
                        <a href="javascript:void(0)" class="add-to-wish-list product_quick_heart" data-id="{{ $product->id }}"><span data-toggle="tooltip" data-bs-placement="top" title="Wishlist"><i class="fa fa-heart"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
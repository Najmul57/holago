@extends($template.'layouts.master')
@section('content')
     @php
    $setting = \App\Models\Setting::first();
    @endphp
    <div class="offer__section">
        <img src="{{ displayImage($templateAssets.'images/discount_banner/'.$setting->discount_image) }}"  width="100%" alt="">
    </div>
    <!-- productquick view Modal -->
    <div class="modal fade" id="quickViewModel" tabindex="-1" aria-labelledby="quickViewModel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body ghghgsdhfgd">

                </div>
            </div>
        </div>
    </div>

    <div class="section-padding">
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                        <div class="single-latest-product">
                            <div class="single-product-head d-flex align-items-start justify-content-between">
                                @if($product->is_featured == 1)
                                    <h6 style="background-color: #2c2c2c;">Hot</h6>
                                @endif
                                <div class="product-info">
                                    <a href="{{route('product.details',$product->slug)}}">
                                        <i class="fa fa-bag-shopping"></i>
                                    </a>
                                    <a href="#quickViewModel" class="viewBtn quick-view-btn" data-product="{{$product->id}}" data-bs-toggle="modal"><i class="fa fa-magnifying-glass-plus"></i></a>

{{--                                    <button class="viewBtn" data-bs-toggle="modal" data-bs-target="#quickViewModel"--}}
{{--                                            data-id="{{ __($product->id) }}"--}}
{{--                                            data-name="{{ __($product->name) }}"--}}
{{--                                            data-product_model="{{ __($product->product_model) }}"--}}
{{--                                            data-regular_price="{{ __($product->regular_price) }}"--}}
{{--                                            data-product_attribute="{{ json_encode($product->product_attribute) }}"--}}
{{--                                            data-points="{{ __($product->points) }}"--}}
{{--                                            data-image="{{ displayImage('assets/classicmart/images/products/'.$product->image) }}"--}}
{{--                                            data-description="{{ __($product->description) }}"--}}
{{--                                            data-summary="{{ __($product->summary) }}"--}}
{{--                                            data-action="{{ route('admin.language.edit', $product->id) }}"--}}
{{--                                            data-action_wishlist="{{ route('admin.language.edit', $product->id) }}">--}}
{{--                                        <span data-toggle="tooltip" data-bs-placement="left" title="Quick View">--}}
{{--                                            <i class="fa fa-magnifying-glass-plus"></i>--}}
{{--                                        </span>--}}
{{--                                    </button>--}}

                                </div>
                            </div>
                            <!-- product image  -->
                            <div class="latest-product-image" title="{{__($product->name)}}">
                                <a href="{{route('product.details',$product->slug)}}">
                                    <div class="front-image">
                                        <img src="{{ displayImage($templateAssets.'images/products/'.$product->image) }}" class="w-100" alt="">
                                    </div>
                                    <div class="back-image">
                                        <img src="{{ displayImage($templateAssets.'images/products/'.$product->image) }}" class="w-100" alt="">
                                    </div>
                                </a>
                                <div class="product-info-bottom">
                                    <a href="{{route('product.details',$product->slug)}}"><i class="fa fa-bag-shopping"></i></a>
                                </div>
                            </div>

                            <div class="latest-product-content">
                                <h5 class="d-flex align-items-center justify-content-between">
                                    <a href="{{route('product.details',$product->slug)}}">{{__($product->name)}}</a>
                                    @php
                                        $wCk = checkWishList($product->id);
                                    @endphp
                                    <a href="javascript:void(0)" class="add-to-wish-list" data-id="{{$product->id}}">
                                        <span data-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                            <i class="fa fa-heart"></i>
                                        </span>
                                    </a>
                                </h5>
                                <h5 class="price">
                                   <span class="discount__price"><del>{{$setting->currency_symbol}}{{__($product->regular_price)}}</del></span>
                                    {{$setting->currency_symbol}}{{__(number_format((float)$product->discount_price,2))}}
                                </h5>
                                @if($product->points)
                                    <div class="reward-point">
                                        <span>@lang('Earn up to') </span>
                                        <span> @lang('HOLAGO CLUB POINTS').</span>
                                        <span data-toggle="tooltip" data-placement="top"
                                              title="@lang('Join our club! For every ৳100 you get') {{__($product->points)}} @lang('HOLAGO CLUB POINTS').">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
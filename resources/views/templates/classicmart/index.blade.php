@extends($template . 'layouts.master')
@section('content')
    @if ($coupons->count() > 0)
        <!--@foreach ($coupons as $coupon)-->
            <!-- discount header start -->
        <!--    <div class="discount-header text-center">-->
        <!--        <a href="{{ route('shop') }}">-->
        <!--            <h1 class="text-white">{{ __($coupon->name) }} <span>@lang('use code') : {{ __($coupon->code) }}</span>-->
        <!--            </h1>-->
        <!--            <p>@lang('conditions applied')</p>-->
        <!--        </a>-->
        <!--    </div>-->
        <!--@endforeach-->
    @endif
    <!-- banner start -->
    <div class="banner-area">
        <div class="banner owl-carousel">
            @foreach ($banners as $banner)
                <a href="{{ url($banner->data->button_url) }}">
                    <img src="{{ displayImage($templateAssets . 'images/banner/' . $banner->data->image) }}" alt="banner"
                        class="w-100">
                </a>
            @endforeach
        </div>
    </div>
    <!-- banner end -->
    <!-- newly start -->

    <div class="category-area section-padding">
        <div class="container-fluid">
            <div class="row align-items-center mb-5">
                <div class="col-12">
                    <div class="section-header">
                        <h2>Top Category</h2>
                    </div>
                </div>
            </div>
            <div class="category__carousel__active owl-carousel">
                @foreach ($special_category as $category)
                    <div class="single-category">
                  <a href="{{ route('products.subcategory', $category->slug ) }}" class="category-image text-center d-block">
                        <img src="{{ displayImage($templateAssets.'images/sub_categories/'.$category->image) }}" alt="">
        </a>
                    <div class="category-title">
                       <a href="{{ route('products.subcategory', $category->slug ) }}">{{__($category->name)}}</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>


    <!-- productquick view Modal -->
    <div class="modal fade" id="quickViewModel" tabindex="-1" aria-labelledby="quickViewModel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body ghghgsdhfgd">

                </div>
            </div>
        </div>
    </div>

    <!-- latest product start -->
    <div class="latest-product-area section-padding" style="background-color: #F4F4F4;">
        <div class="container-fluid">
            <div class="row align-items-center mb-5">
                <div class="col-xl-6 col-lg-6 col-md-8 col-sm-8 col-7">
                    <div class="section-header">
                        <h2>@lang('Latest Products')</h2>
                        <span>@lang('Get the best for you!')</span>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-4 col-sm-4 col-5 text-end">
                    <div class="section-header">
                        <a href="{{ route('shop') }}">@lang('all products')</a>
                    </div>
                </div>
            </div>
            <div class="row align-items-sm-stretch">
                @foreach ($products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                        <div class="single-latest-product">
                            <div class="single-product-head d-flex align-items-start justify-content-between">
                                @if ($product->is_featured == 1)
                                    <h6 style="background-color: #2c2c2c;">Hot</h6>
                                @endif
                                <div class="product-info">
                                    <!--<a href="{{ route('product.details', $product->id) }}">-->
                                    <!--    <i class="fa fa-bag-shopping"></i>-->
                                    <!--</a>-->
                                  <a href="#quickViewModel" class="viewBtn quick-view-btn"
                                    data-product="{{ $product->id }}" data-bs-toggle="modal">
                                        <i class="fa fa-bag-shopping"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- product image  -->
                            <div class="latest-product-image" title="{{ __($product->name) }}">
                                <a href="{{ route('product.details', $product->slug) }}">
                                    <div class="front-image">
                                        <img src="{{ displayImage($templateAssets . 'images/products/' . $product->image) }}"
                                            class="w-100" alt="">
                                    </div>
                                    <div class="back-image">
                                        <img src="{{ displayImage($templateAssets . 'images/products/' . $product->image) }}"
                                            class="w-100" alt="">
                                    </div>
                                </a>
                                <div class="product-info-bottom">
                                    <a href="#quickViewModel" class="viewBtn quick-view-btn"
                                    data-product="{{ $product->id }}" data-bs-toggle="modal"><i
                                            class="fa fa-bag-shopping"></i></a>
                                </div>
                            </div>

                            <div class="latest-product-content">
                                <h5 class="d-flex justify-content-between">
                                    <a href="{{ route('product.details', $product->slug) }}">{{ __($product->name) }}</a>
                                    @php
                                        $wCk = checkWishList($product->id);
                                    @endphp
                                    <a href="javascript:void(0)" class="add-to-wish-list" data-id="{{ $product->id }}">
                                        <span data-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                            <i class="fa fa-heart"></i>
                                        </span>
                                    </a>
                                </h5>
                                <h5 class="price">
                                    @if ($product->discount_price == null || $product->discount_price == 0)
                                        {{ $setting->currency_symbol }}{{ __(number_format($product->regular_price, 2)) }}
                                    @else
                                        <span
                                            class="discount__price"><del>{{ $setting->currency_symbol }}{{ __($product->regular_price) }}</del></span>
                                        {{ $setting->currency_symbol }}{{ __(number_format($product->discount_price, 2)) }}
                                    @endif
                                </h5>
                                @if ($product->points)
                                    <div class="reward-point">
                                        <span>@lang('Earn up to') </span>
                                        <span> @lang('HOLAGO CLUB POINTS').</span>
                                        <span data-toggle="tooltip" data-placement="top"
                                            title="@lang('Join our club! For every ৳100 you get') {{ __($product->points) }} @lang('HOLAGO CLUB POINTS').">
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
    </div>
    <!-- latest product end -->

    <!-- holago logo -->
    <div class="holago-feature-image">
        <img src="{{ asset('assets/frontend/img/holago-pc-flash-logo-2.gif') }}" alt="" class="w-100">
    </div>
    <!-- holago logo -->

    <!-- refresh start -->
    <div class="refresh-area section-padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="refresh-content"
                        style="background-image: url('{{ displayImage('assets/classicmart/images/refresh/' . $refresh->data->image) }}');">
                        <h2>{{ __($refresh->data->title) }}</h2>
                        <div class="refresh-title">{{ __($refresh->data->first_title) }}
                            <br>{{ __($refresh->data->second_title) }} <br>{{ __($refresh->data->third_title) }}</div>
                        <div class="section-header mt-4">
                            <a href="{{ url($refresh->data->button_url) }}">{{ __($refresh->data->button_name) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- refresh end -->

    <!-- trending product start -->
    <div class="trending-product-area section-padding" style="background-color: #F4F4F4;">
        <div class="container-fluid">
            <div class="row align-items-center mb-5">
                <div class="col-xl-6 col-lg-6 col-md-7 col-sm-7 col-12">
                    <div class="section-header">
                        <h2>@lang('Trending Outfits')</h2>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-5 col-sm-5 col-12 text-end">
                    <div class="section-header">
                        <span>@lang('Shared by customers, just like you')!</span>
                    </div>
                </div>
            </div>
            <div class="row align-items-stretch gy-4">
                @foreach ($featured_products as $product)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="single-trending">
                            <div class="trending-image">
                                <img src="{{ asset($templateAssets . 'images/products/' . $product->image) }}" class="w-100"
                                    alt="">
                            </div>
                            <div class="trending-content">
                                <a href="{{ route('product.details', $product->slug) }}" class="content-item">
                                    <div class="trending-subcontent d-flex align-items-center">
                                        <div class="trending-subconent-image">
                                            <img src="{{ asset($templateAssets . 'images/products/' . $product->image) }}"
                                                alt="">
                                        </div>
                                        <div class="trending-subconent-content">
                                            <h3 class="title">{{ __($product->name) }}</h3>
                                            <span
                                                class="price">{{ __($setting->currency_symbol) }}{{ __($product->regular_price) }}</span>
                                            <span class="trending-select">Select options <i
                                                    class="fa-brands fa-youtube"></i> </span>
                                        </div>
                                    </div>
                                </a>
                                <div class="trending-icon-top"><i class="fa-solid fa-tag"></i></div>
                                <div class="trending-icon-bottom">
                                    <i class="fa fa-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- trending product end -->

    <!-- vintage start -->
    <div class="vintage-area section-padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7">
                    <div class="row g-0 align-items-stretch">
                        @foreach ($vintages as $vint)
                            <div class="col-md-4 col-sm-6 col-6">
                                <div class="single-instagram">
                                    <div class="instagram-photo">
                                        <img src="{{ displayImage($templateAssets . 'images/vintage/' . $vint->data->image) }}"
                                            alt="">
                                    </div>
                                    <a href="{{ url($vint->data->link) }}" target="_blank" class="instagram-logo">
                                        @php echo $vint->data->icon @endphp <br>
                                        <span>{{ __($vint->data->title) }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="vintage-content">
                        <div class="vintage-table">
                            <div class="vintage-title">{{ __($vintage->data->title) }}</div>
                            <p>{{ __($vintage->data->content) }}</p>
                            <h3><a href="{{ url($vintage->data->link) }}">#{{ __($vintage->data->link_name) }}</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- vintage end -->
@endsection
@push('js')
    <script>
        (function($) {
            "use strict";
            $('.viewBtn').on('click', function() {
                var viewModal = $('#quickViewModel');
                viewModal.find('#product_image').attr('src', $(this).data('image') + '?' + new Date()
            .getTime());

                viewModal.find('.name').text($(this).data('name'));
                viewModal.find('.price').text($(this).data('regular_price'));

                // Parse JSON data for product_attribute (no need for JSON.parse since it's already an array of objects)
                var productAttributes = $(this).data('product_attribute');
                var productAttributeHtml = '';

                // Use the same name attribute for radio buttons to group them
                var groupName = 'product_size';

                // Iterate through the product_attributes and build the HTML
                for (var i = 0; i < productAttributes.length; i++) {
                    var size = productAttributes[i].content;
                    var id = productAttributes[i].id;
                    var product_id = productAttributes[i].product_id;

                    productAttributeHtml += `
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check attribute-btn" data-id="${id}" data-product_id="${product_id}" value="${size}" id="a_${size}" name="${groupName}" autocomplete="off">
                            <label class="btn product__size_btn" title="${size}" for="a_${size}">${size}</label>
                        </div>
                    `;
                }

                // Set the product_attribute HTML in the viewModal
                viewModal.find('.quick-image-size.product_attribute').html(productAttributeHtml);

                // Handle click event for radio buttons
                viewModal.find('.btn-check.attribute-btn').on('click', function() {
                    // Remove 'active' class from all radio buttons in the same group
                    $('input[name="' + groupName + '"]').removeClass('active');
                    // Add 'active' class to the clicked radio button
                    $(this).addClass('active');
                });

                var productId = $(this).data('id');
                viewModal.find('.addToCart').attr('data-id', productId);
                viewModal.find('.add-to-wish-list').attr('data-id', productId);

                viewModal.find('.description').html($(this).data('description'));
            });
        })(jQuery);
    </script>

  <script>
        $(document).ready(function() {
            var $carousel = $('.category__carousel__active');

            function initCarousel() {
                $carousel.owlCarousel({
                    dots: false,
                    autoplay: true,
                    animateOut: 'fadeOut',
                    animateIn: 'fadeIn',
                    loop: true,
                    smartSpeed: 1000,
                    margin: 20,
                    items: 4,
                    navText: ['<i class="fa fa-arrow-left"></i>', '<i class="fa fa-arrow-right"></i>'],
                    nav: true,
                    responsive: {
                        0: {
                            items: 1,
                        },
                        480: {
                            items: 2,
                        },
                        600: {
                            items: 2,
                        },
                        800: {
                            items: 3,
                        },
                        1000: {
                            items: 4,
                        }
                    }
                });
            }

            function destroyCarousel() {
                if ($carousel.hasClass('owl-loaded')) {
                    $carousel.trigger('destroy.owl.carousel');
                }
            }

            if ($(window).width() >= 576) {
                initCarousel();
            } else {
                destroyCarousel();
                $carousel.css('display', 'grid');
                $carousel.css('grid-template-columns', 'repeat(auto-fill, minmax(46%, 1fr))');
                $carousel.css('gap', '5px');
                $carousel.children().css('width', '');
            }

            $(window).resize(function() {
                if ($(window).width() >= 576) {
                    initCarousel();
                    $carousel.css('display', '');
                    $carousel.css('grid-template-columns', '');
                    $carousel.css('gap', '');
                    $carousel.children().css('width', '');
                } else {
                    destroyCarousel();
                    $carousel.css('display', 'grid');
                    $carousel.css('grid-template-columns', 'repeat(auto-fill, minmax(46%, 1fr))');
                    $carousel.css('gap', '5px');
                    $carousel.children().css('width', '');
                }
            });
        });
    </script>
@endpush
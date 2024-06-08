@extends($template . 'layouts.master')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">-->
    <style>
        .quick-image-size .btn.disabled::after {
            left: 50%;
        }

        .quick-image-size .btn.disabled::before {
            left: 50%;
      }
    </style>
@endpush

@section('content')
    <div class="product-details section-padding">
        <div class="container">
            <div class="row">
                <div class="col-xll-6 col-xl-6 col-lg-6 col-md-6 d-md-block d-none">
                    <div class="items-slider-container product__details_photo">
                        <div class="slider slider-for thumbnail__product">
                            @foreach ($product->product_image as $value)
                                <div class="product-details-item">
                                    <a href="{{ displayImage($templateAssets . 'images/products/additionimage/' . $value->image) }}"
                                        data-lightbox="roadtrip">
                                        <img src='{{ displayImage($templateAssets . 'images/products/additionimage/' . $value->image) }}'
                                            title="" alt='' />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="slider slider-nav">
                            @foreach ($product->product_image as $value)
                                <img src="{{ displayImage($templateAssets . 'images/products/additionimage/' . $value->image) }}"
                                    alt="">
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="d-md-none col-12">
                    <div class="product-item-carousal owl-carousel">
                        @foreach ($product->product_image as $value)
                            <div class="col-12">
                                <div class="product-details-item">
                                    <a href="{{ displayImage($templateAssets . 'images/products/additionimage/' . $value->image) }}"
                                        data-lightbox="roadtrip">
                                        <img src='{{ displayImage($templateAssets . 'images/products/additionimage/' . $value->image) }}'
                                            alt='' />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xll-6 col-xl-6 col-lg-6 col-md-6 ">
                    <div class="product_quick_view-content">
                        <div class="product-breadcrumb">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Category</a></li>
                                <li>
                                    {{ $product->category->name ?? '' }}
                                </li>
                            </ul>
                        </div>

                        <h4>{{ __($product->name) }}</h4>
                        <h6>
                            @if ($product->discount_price)
                                <span
                                    class="discount__price"><del>{{ $setting->currency_symbol }}{{ __($product->regular_price) }}</del></span>
                                {{ $setting->currency_symbol }}{{ __(number_format($product->discount_price, 2)) }}
                            @else
                                {{ $setting->currency_symbol }}{{ __(number_format($product->regular_price, 2)) }}
                            @endif
                        </h6>
                          <div class=" align-items-center">
                            <strong>Size : <span id="attribute_size_of_stock"></span> </strong><br>
                            <strong>stock :<span id="product_stock_of_size"></span></strong>
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

                        <!--<div class="product_quantity" id="product_quantity">-->
                        <!--    <p class="quantity_item" id="quantity_s"><strong>S</strong> Stock in <strong>10</strong>-->
                        <!--    </p>-->

                        <!--</div>-->
                        <div class="quick-view_cart-product mt-3 mb-3">
                            <div class="cart-product-quantity d-flex align-items-center">
                                <div class="attr-data">
                                </div>
                                <div class="product_quantitys">
                                    <div class="cart-plus-minus quantity">
                                        <div class="cart-decrease qtybutton dec">
                                            <span><i class="fa fa-minus"></i></span>
                                        </div>
                                        <input type="number" name="quantity" step="1" min="1" value="1"
                                            class="integer-validation quantity__input">
                                        <div class="cart-increase qtybutton inc">
                                            <span><i class="fa fa-plus"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="addToCart cart-add-btn"
                                    data-id="{{ $product->id }}">@lang('Add To Cart')</button>
                                @php
                                    $wCk = checkWishList($product->id);
                                @endphp
                                <a href="javascript:void(0)" class="add-to-wish-list product_quick_heart"
                                    data-id="{{ $product->id }}">
                                    <span data-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                        <i class="fa fa-heart"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="accordion mt-3 single-product-content-info">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item active">
                                    <h2 class="accordion-header">
                                        <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#details" aria-expanded="false" aria-controls="details">
                                            Product Details
                                        </div>
                                    </h2>
                                    <div id="details" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @php echo __($product->description) @endphp
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    @php
                                        $data = \App\Models\RatingReview::where('product_id', $product->id)->get();
                                    @endphp
                                    <h2 class="accordion-header">
                                        <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#review" aria-expanded="false" aria-controls="review">
                                            Reviews ({{ $data->count() }})
                                        </div>
                                    </h2>
                                    <div id="review" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body product-review-section">
                                            <div class="single-review-item review-form">
                                                <h4>Customer Reviews</h4>
                                                <div
                                                    class="review-togglebar d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">

                                                        <p class="mb-0 text-black">&nbsp; Based on {{ $data->count() }}
                                                            reviews</p>
                                                    </div>
                                                    {{-- @dd(auth()->user()) --}}
                                                    @if(auth()->user())
                                                    <span id="review-toggle">Write a review</span>
                                                    @else

                                                    @endif
                                                </div>
                                                <div class="product-review-form">
                                                    <form action="{{ route('review.store') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="product_id"
                                                            value="{{ $product->id }}">
                                                        <div class="form-group mb-3 mt-1">
                                                            <label for="name" class="mb-1">Name</label>
                                                            <input type="text" class="form-control" name="name"
                                                                id="name" placeholder="Enter your Name" @if (auth()->user())
                                                                    value="{{auth()->user()->name ?? ''}}" readonly @else
                                                                @endif required>
                                                        </div>
                                                        <div class="form-group mb-3 mt-1">
                                                            <label for="name" class="mb-1">Rating</label>
                                                            <div class="rating-checked">
                                                                <input type="radio" name="rating" value="5"
                                                                    style="--r: #ffb301" />
                                                                <input type="radio" name="rating" value="4"
                                                                    style="--r: #ffb301" />
                                                                <input type="radio" name="rating" value="3"
                                                                    style="--r: #ffb301" />
                                                                <input type="radio" name="rating" value="2"
                                                                    style="--r: #ffb301" />
                                                                <input type="radio" name="rating" value="1"
                                                                    style="--r: #ffb301" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="title" class="mb-1">Review Title</label>
                                                            <input type="text" class="form-control"
                                                                name="review_title" id="title"
                                                                placeholder="Give your review a title" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="message" class="mb-1">Body of Review</label>
                                                            <textarea name="review" id="message" class="form-control" cols="30"
                                                                placeholder="Write your comments here..." rows="8" required></textarea>
                                                        </div>
                                                        <div class="section-header">
                                                            <button type="submit"
                                                                class="text-white d-inline-block p-2">Submit
                                                                Review</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @php
                                                $data = \App\Models\RatingReview::where('product_id', $product->id)->get();
                                            @endphp
                                            @foreach ($data as $value)
                                                <div class="single-review-item">
                                                    <div class="rating">
                                                        @if ($value->rating == '1')
                                                            <i class="fa fa-star"></i>
                                                        @elseif($value->rating == '2')
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif($value->rating == '3')
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif($value->rating == '4')
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @elseif($value->rating == '5')
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                        @else
                                                        @endif
                                                    </div>
                                                    <h5 class="review-title">{{ $value->review_title }}</h5>
                                                    <h6 class="review-user">{{ $value->name }}</h6>
                                                    <span class="review-description">{!! $value->review !!}</span>
                                                </div>
                                            @endforeach
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

    <!-- related product -->
    <div class="related-product">
        <div class="container-fluid">
            <div class="row align-items-center mb-3">
                <div class="col-12">
                    <div class="section-header">
                        <h2 class="fs-2 text-start">Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row align-items-stretch">
                @foreach ($relatedProduct as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                        <div class="single-latest-product">
                            <div class="single-product-head d-flex align-items-start justify-content-between">
                                @if ($product->is_featured == 1)
                                    <h6 style="background-color: #2c2c2c;">Hot</h6>
                                @endif
                                <div class="product-info">
                                    <a href="{{ route('product.details', $product->slug) }}"><i
                                            class="fa fa-bag-shopping"></i></a>
                                    <a href="#quickViewModel" class="viewBtn quick-view-btn"
                                        data-product="{{ $product->id }}" data-bs-toggle="modal"><i
                                            class="fa fa-magnifying-glass-plus"></i></a>
                                </div>
                            </div>

                            <!-- product image  -->
                            <div class="latest-product-image" title="TD0006">
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
                                    <a href="{{ route('product.details', $product->slug) }}"><i
                                            class="fa fa-bag-shopping"></i></a>
                                </div>
                            </div>
                            <div class="latest-product-content">
                                <h5 class="d-flex align-items-center justify-content-between">
                                    <a href="{{ route('product.details', $product->slug) }}">{{ __($product->name) }}</a>
                                    @php
                                        $wCk = checkWishList($product->id);
                                    @endphp
                                    <a href="javascript:void(0)" class="add-to-wish-list product_quick_heart"
                                        data-id="{{ $product->id }}">
                                        <span data-toggle="tooltip" data-bs-placement="top" title="Wishlist">
                                            <i class="fa fa-heart"></i>
                                        </span>
                                    </a>
                                </h5>
                                <h5 class="price">
                                    @if ($product->discount_price == null)
                                        {{ $setting->currency_symbol }}{{ __(number_format($product->regular_price, 2)) }}
                                    @else
                                        <span
                                            class="discount__price"><del>{{ $setting->currency_symbol }}{{ __($product->regular_price) }}</del></span>
                                        {{ $setting->currency_symbol }}{{ __(number_format($product->discount_price, 2)) }}
                                    @endif
                                </h5>
                                @if ($product->points)
                                    <div class="reward-point">
                                        <span>@lang('Earn up to')</span>
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
@endsection
@push('js')
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <!-- Initiate Lightbox -->

    <script>
        function magnify(images, zoom) {
            images.forEach(function(img) {
                var glass, w, h, bw;
                /*create magnifier glass:*/
                glass = document.createElement("DIV");
                glass.setAttribute("class", "img-magnifier-glass");
                /*insert magnifier glass:*/
                img.parentElement.insertBefore(glass, img);
                /*set background properties for the magnifier glass:*/
                glass.style.backgroundImage = "url('" + img.src + "')";
                glass.style.backgroundRepeat = "no-repeat";
                glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
                bw = 3;
                w = glass.offsetWidth / 2;
                h = glass.offsetHeight / 2;
                /*execute a function when someone moves the magnifier glass over the image:*/
                glass.addEventListener("mousemove", moveMagnifier);
                img.addEventListener("mousemove", moveMagnifier);
                /*and also for touch screens:*/
                glass.addEventListener("touchmove", moveMagnifier);
                img.addEventListener("touchmove", moveMagnifier);

                function moveMagnifier(e) {
                    var pos, x, y;
                    /*prevent any other actions that may occur when moving over the image*/
                    e.preventDefault();
                    /*get the cursor's x and y positions:*/
                    pos = getCursorPos(e);
                    x = pos.x;
                    y = pos.y;
                    /*prevent the magnifier glass from being positioned outside the image:*/
                    if (x > img.width - (w / zoom)) {
                        x = img.width - (w / zoom);
                    }
                    if (x < w / zoom) {
                        x = w / zoom;
                    }
                    if (y > img.height - (h / zoom)) {
                        y = img.height - (h / zoom);
                    }
                    if (y < h / zoom) {
                        y = h / zoom;
                    }
                    /*set the position of the magnifier glass:*/
                    glass.style.left = (x - w) + "px";
                    glass.style.top = (y - h) + "px";
                    /*display what the magnifier glass "sees":*/
                    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) +
                        "px";
                }

                function getCursorPos(e) {
                    var a, x = 0,
                        y = 0;
                    e = e || window.event;
                    /*get the x and y positions of the image:*/
                    a = img.getBoundingClientRect();
                    /*calculate the cursor's x and y coordinates, relative to the image:*/
                    x = e.pageX - a.left;
                    y = e.pageY - a.top;
                    /*consider any page scrolling:*/
                    x = x - window.pageXOffset;
                    y = y - window.pageYOffset;
                    return {
                        x: x,
                        y: y
                    };
                }
            });
        }

        var imagesToMagnify = document.querySelectorAll('.image');
        magnify(imagesToMagnify, 2);
    </script>

    <script>
        $(document).ready(function() {
            $('.product-details-item a').lightbox({
                nav: true,
                blur: true
            });
        });
    </script>

    <!--  mobile-single-product image slider -->
    <script>
        $('.product-item-carousal').owlCarousel({
            loop: true,
            margin: 10,
            dots: false,
            items: 1,
            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
            nav: true,
        })
    </script>

    <!--  review toggle -->
    <script>
        $("#review-toggle").click(function() {
            $(".product-review-form").toggle();
        });
    </script>

    <script>
        (function($) {
            "use strict";
            $('.viewBtn1').on('click', function() {
                var viewModal = $('#quickViewModel1');
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
        function magnify(images, zoom) {
            images.forEach(function(img) {
                var glass, w, h, bw;
                /*create magnifier glass:*/
                glass = document.createElement("DIV");
                glass.setAttribute("class", "img-magnifier-glass");
                /*insert magnifier glass:*/
                img.parentElement.insertBefore(glass, img);
                /*set background properties for the magnifier glass:*/
                glass.style.backgroundImage = "url('" + img.src + "')";
                glass.style.backgroundRepeat = "no-repeat";
                glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
                bw = 3;
                w = glass.offsetWidth / 2;
                h = glass.offsetHeight / 2;
                /*execute a function when someone moves the magnifier glass over the image:*/
                glass.addEventListener("mousemove", moveMagnifier);
                img.addEventListener("mousemove", moveMagnifier);
                /*and also for touch screens:*/
                glass.addEventListener("touchmove", moveMagnifier);
                img.addEventListener("touchmove", moveMagnifier);

                function moveMagnifier(e) {
                    var pos, x, y;
                    /*prevent any other actions that may occur when moving over the image*/
                    e.preventDefault();
                    /*get the cursor's x and y positions:*/
                    pos = getCursorPos(e);
                    x = pos.x;
                    y = pos.y;
                    /*prevent the magnifier glass from being positioned outside the image:*/
                    if (x > img.width - (w / zoom)) {
                        x = img.width - (w / zoom);
                    }
                    if (x < w / zoom) {
                        x = w / zoom;
                    }
                    if (y > img.height - (h / zoom)) {
                        y = img.height - (h / zoom);
                    }
                    if (y < h / zoom) {
                        y = h / zoom;
                    }
                    /*set the position of the magnifier glass:*/
                    glass.style.left = (x - w) + "px";
                    glass.style.top = (y - h) + "px";
                    /*display what the magnifier glass "sees":*/
                    glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) +
                        "px";
                }

                function getCursorPos(e) {
                    var a, x = 0,
                        y = 0;
                    e = e || window.event;
                    /*get the x and y positions of the image:*/
                    a = img.getBoundingClientRect();
                    /*calculate the cursor's x and y coordinates, relative to the image:*/
                    x = e.pageX - a.left;
                    y = e.pageY - a.top;
                    /*consider any page scrolling:*/
                    x = x - window.pageXOffset;
                    y = y - window.pageYOffset;
                    return {
                        x: x,
                        y: y
                    };
                }
            });
        }
        var imagesToMagnify = document.querySelectorAll('.image');
        magnify(imagesToMagnify, 2); // Zoom level: 3 for all images
    </script>

    <script>
        $(document).ready(function() {
            $('.product__details_photo .slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.product__details_photo .slider-nav',
            });
            $('.product__details_photo .slider-nav').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.product__details_photo .slider-for',
                dots: false,
                centerMode: false,
                focusOnSelect: true,
                arrows: false,
                accessibility: true,
                onAfterChange: function(slide, index) {
                    console.log("slider-nav change");
                    console.log(this.$slides.get(index));
                    $('.current-slide').removeClass('current-slide');
                    $(this.$slides.get(index)).addClass('current-slide');
                },
                onInit: function(slick) {
                    $(slick.$slides.get(0)).addClass('current-slide');
                }
            });
        });
    </script>
    <script>
        // $(document).ready(function() {
        //     $('select').niceSelect();
        // });
    </script>
        <script>
        // get attribute stock
        $(document).on("click", ".product__size_btn", function() {
            var productId = $(this).attr('data-id');
            var atributeId = $(this).attr('attribute_id');
            var size = $(this).text();
            var url = "{{ route('product.getStockByAttribute') }}";

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    productId: productId,
                    attributeId: atributeId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    var quantity = data?.data?.quantity;
                    $("#attribute_size_of_stock").text(size);
                    $("#product_stock_of_size").text(quantity ?? 0);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });

        })
    </script>
@endpush
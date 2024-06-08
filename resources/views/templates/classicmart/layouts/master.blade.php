<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $setting->site_name }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset($templateAssets . 'img/favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset($templateAssets . 'css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <!--<link rel="stylesheet"-->
    <!--    href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">-->
    <link href="{{ asset('assets/global/css/toastr.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset($templateAssets . 'css/style.css') }}">
    <link rel="stylesheet" href="{{ asset($templateAssets . 'css/responsive.css') }}">
    @stack('css')
        <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '560630165112583');
  fbq('track', 'PageView');

</script>
<noscript>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id=560630165112583&ev=PageView&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->




    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZFGS4Q66DQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZFGS4Q66DQ');
</script>
</head>

<body class="search-result">

    <!-- header start -->
    @include($templateInclude . 'header')
    <!-- header end -->

    <!-- main -->
    <main class="main">
        @yield('content')
    </main>

    <!-- footer start -->

    @include($templateInclude . 'footer')
    <!-- footer end -->

    <!-- bottom footer fixed start -->
    <div class="bottom-footer-fixed d-flex align-content-center justify-content-around d-none">
        <a href="{{ url('/') }}" class="single-footer-menu">
            <i class="fa fa-home"></i>
        </a>
        <a href="{{ route('user.login') }}" class="single-footer-menu">
            <i class="fa fa-user"></i>
        </a>
        <a href="#" class="single-footer-menu">
            <div data-bs-toggle="offcanvas" href="#cardModal" role="button" aria-controls="offcanvasExample">
                <i class="fa fa-shopping-cart"></i>
                <span class="cart-count amount">0</span>
            </div>
        </a>
        <a href="{{ route('wishlist') }}" class="single-footer-menu">
            <i class="fa fa-heart"></i>
            <span class="wishlist-count amount">0</span>
        </a>
    </div>
    <!-- bottom footer fixed end -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cardModal" aria-labelledby="cart-bar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cart-bar">YOUR CART</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="cart--products">

        </div>
    </div>



    <script src="{{ asset($templateAssets . 'js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset($templateAssets . 'js/popper.min.js') }}"></script>
    <script src="{{ asset($templateAssets . 'js/bootstrap.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>
    <script src="{{ asset('assets/global/js/toastr.min.js') }}"></script>
    <script src="{{ asset($templateAssets . 'js/main.js') }}"></script>
    @stack('js')
    <script>
        'use strict';
        (function($) {
            var product_id = 0;
            getWishlistData();
            getWishlistTotal();

            /* ADD TO WISHLIST */
            $(document).on('click', '.add-to-wish-list', function() {
                // getWishlistTotal();

                var product_id = $(this).data('id');
                var products = $(`.add-to-wish-list[data-id="${product_id}"]`);
                var data = {
                    product_id: product_id
                }
                if ($(this).hasClass('active')) {
                    systemAlert('danger', 'Already in the wishlist');
                } else {
                    $.ajax({
                        url: "{{ route('add-to-wishlist') }}",
                        method: "get",
                        data: data,
                        success: function(response) {
                            if (response.success) {
                                getWishlistData();
                                getWishlistTotal();
                                systemAlert('success', response.success);
                            } else if (response.error) {
                                systemAlert('danger', response.error);
                            } else {
                                systemAlert('danger', response);
                            }
                        }
                    });
                }
            });

            /* REMOVE FROM WISHLIST */
            $(document).on('click', '.remove-wishlist', function(e) {
                var id = $(this).data('id');
                var pid = $(this).data('pid');
                var url = '{{ route('removeFromWishlist', '') }}' + '/' + id;
                var page = $(this).data('page');
                var parent = $(this).parent().parent();
                $.ajax({
                    url: url,
                    method: "get",
                    success: function(response) {
                        if (response.success) {
                            getWishlistData();
                            getWishlistTotal();
                            systemAlert('success', response.success);
                        } else {
                            systemAlert('danger', response.error);
                        }
                    }
                }).done(function() {
                    if (pid) {
                        var products = $(`.add-to-wish-list[data-id="${pid}"]`);
                        $.each(products, function(i, v) {
                            if ($(v).hasClass('active')) {
                                $(v).removeClass('active');
                            }
                        });
                    }
                    if (page == 1) {

                        if (id == 0) {
                            $('.cart-table-body').html(`
                            <tr>
                                <td colspan="100%">
                                    @lang('Your wishlist is empty')
                                </td>
                            </tr>
                        `);
                            $('.remove-all-btn').hide(300);
                        } else {
                            parent.hide(300);
                        }
                    }
                });

            });
            /*
            ==========QUANTITY BUTTONS FUNCTIONALITIES==========
                */
            $(document).on("click", ".qtybutton", function() {
                var $button = $(this);
                $button.parent().find('.qtybutton').removeClass('active')
                $button.addClass('active');
                var oldValue = $button.parent().find("input").val();
                if ($button.hasClass('inc')) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                    }
                }
                $button.parent().find("input").val(newVal);
            });

            /*------VARIANT FUNCTIONALITIES-----*/
            $(document).on('click', '.attribute-btn', function() {
                var btn = $(this);
                var ti = btn.data('ti');
                var count_total = btn.data('attr_count');
                var discount = btn.data('discount');
                product_id = btn.data('product_id');
                var attr_data_size = btn.data('size');
                var attr_data_color = btn.data('bg');
                var attr_arr = [];
                var base_price = parseFloat(btn.data('base_price'));
                var extra_price = 0;
                btn.parents('.attr-area:first').find('.attribute-btn').removeClass('active');
                btn.addClass('active');

                if (btn.data('type') == 2 || btn.data('type') == 3) {
                    $.ajax({
                        url: "{{ route('product.get-image-by-variant') }}",
                        method: "GET",
                        data: {
                            'id': btn.data('id')
                        },
                        success: function(data) {
                            if (!data.error) {
                                btn.parents('.product-details-wrapper').find('.variant-images')
                                    .html(data);
                                triggerOwl();
                            }
                        }
                    });
                }

                if ($(document).find('.attribute-btn.active').length == count_total) {
                    var activeAttributes = $(document).find('attribute-btn.active');
                    $(document).find('.attribute-btn.active').each(function(key, attr) {
                        extra_price += parseFloat($(attr).data('price'));
                        var id = $(attr).data('id');
                        attr_arr.push(id.toString());
                    });
                    var attr_id = JSON.stringify(attr_arr.sort());
                    var data = {
                        attr_id: attr_id,
                        product_id: product_id
                    }
                    if (ti == 1) {
                        $.ajax({
                            url: "{{ route('product.get-stock-by-variant') }}",
                            method: "GET",
                            data: data,
                            success: function(data) {
                                $('.stock-qty').text(`${data.quantity}`);
                                $('.product-sku').text(`${data.sku}`);
                                if (data.quantity > 1) {
                                    $('.stock-status').addClass('badge--success').removeClass(
                                        'badge--danger');
                                } else {
                                    $('.stock-status').removeClass('badge--success').addClass(
                                        'badge--danger');
                                    notify('error',
                                        'Sorry! Your requested amount of quantity isn\'t available in our stock'
                                    );
                                }
                            }
                        });
                    }
                }

                if (extra_price > 0) {
                    base_price += extra_price;
                    $('.price-data').text(base_price.toFixed(2));
                    $('.special_price').text(base_price.toFixed(2) - discount);

                } else {
                    $('.price-data').text(base_price.toFixed(2));
                    $('.special_price').text(base_price.toFixed(2) - discount);
                }

            });


            /*
              ==========FUNCTIONALITIES AFTER ADD TO CART==========
              */
            /*------ADD TO CART-----*/
             $(document).on('click', '.cart-add-btn', function(e) {
                var product_id = $(this).data('id');
                var attributes = $('.product__size_btn.active');
                var selectedAttributeValues = attributes.map(function() {
                    return $(this).attr('attribute_id');
                }).get();

                // console.log("Selected attribute values:", selectedAttributeValues);
                // console.log("haire attributes", attributes)

                var output = '';
                attributes.each(function(key, attr) {

                    output +=
                        `<input type="hidden" name="selected_attributes" value="${$(attr).attr('attribute_id')}">`;
                });
                $('.attr-data').html(output);
                // console.log(output)

                var quantity = $('input[name="quantity"]').val();
                var attributes = $('input[name="selected_attributes"]').val();
                // console.log("are vai quantity", quantity)


                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                    url: "{{ route('add-to-cart') }}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        quantity: quantity,
                        attributes: attributes
                    },
                    success: function(response) {
                        if (response.success) {
                            getCartData();
                            getCartTotal();
                            systemAlert('success', response.success);
                        } else {
                            // console.log(response);
                            systemAlert('danger', response.error);
                        }
                    }
                });

            });

            $(document).ready(function() {
                getCartData();
                getCartTotal();
            })

            /*------REMOVE PRODUCTS FROM CART-----*/
            $(document).on('click', '.remove-cart', function(e) {
                var btn = $(this);
                var id = btn.data('id');

                var parent = btn.parents('.cart-row');
                var subTotal = parseFloat($('#cartSubtotal').text());
                var thisPrice = parseFloat(parent.find('.total_price').text());


                var url = '{{ route('remove-cart-item', '') }}' + '/' + id;
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    url: url,
                    method: "POST",
                    success: function(response) {
                        if (response.success) {
                            systemAlert('success', response.success);
                            parent.hide(300);

                            if (thisPrice) {
                                $('#cartSubtotal').text((subTotal - thisPrice).toFixed(2));
                            }

                            getCartData();
                            getCartTotal();
                            location.reload();

                        } else {
                            systemAlert('danger', response.error);
                        }
                    }
                });
            });

            $(document).on('click', 'button[name=coupon_apply]', function() {
                var code = $('input[name=coupon_code]').val();
                var subtotal = parseFloat($('#cartSubtotal').text());
                // console.log(subtotal);
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    url: `{{ route('applyCoupon') }}`,
                    method: "POST",
                    data: {
                        code: code,
                        subtotal: subtotal
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#couponAmount').text(response.amount);
                            $('#finalTotal').text(parseFloat((subtotal - response.amount).toFixed(
                                2)));

                            $('.couponCode').text(response.coupon_code);

                            $('.coupon-amount-total').removeClass('d-none').hide().show('300');
                            getCartData();
                            systemAlert('success', response.success);
                        } else if (response.danger) {
                            systemAlert('danger', response.danger);
                        } else {
                            systemAlert('danger', response);
                        }
                    }
                });
            });
            /*------REMOVE APPLIED COUPON FROM CART-----*/
            $(document).on('click', '.remove-coupon', function(e) {
                var btn = $(this);
                var url = '{{ route('removeCoupon', '') }}';
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    url: url,
                    method: "POST",
                    success: function(response) {
                        if (response.success) {
                            systemAlert('success', response.success);
                            getCartData();

                            $('.coupon-amount-total').hide('slow');
                            $('input[name=coupon_code]').val('')
                        }
                    }
                });
            });

            $('.pro_quantity').on('change', function(e) {
                e.preventDefault();
                var prod_id = $(this).closest('.product_data').find('.prod_id').val();
                var qty = $(this).closest('.product_data').find('.pro_quantity').val();
                var attribute = $(".selectAttribute").val();
                var cartId = $('.cartId').val();
                var data = {
                    'prod_id': prod_id,
                    'prod_qty': qty,
                    'attribute': attribute,
                    'cartId': cartId
                };
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "update-cart",
                    data: data,
                    success: function(response) {
                        systemAlert('success', response.success);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                });

            });
            $(document).on('click', '.cart-decrease', function(e) {
                e.preventDefault();
                var prod_id = $(this).closest('.product_data').find('.prod_id').val();
                var qty = $(this).closest('.product_data').find('.pro_quantity').val();
                var attribute = $(".selectAttribute").val();
                var cartId = $('.cartId').val();
                var data = {
                    'prod_id': prod_id,
                    'prod_qty': qty,
                    'attribute': attribute,
                    'cartId': cartId
                };
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "update-cart",
                    data: data,
                    success: function(response) {
                        systemAlert('success', response.success);
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                });
            });

            $(document).on('click', '.cart-increase', function(e) {
                e.preventDefault();
                var prod_id = $(this).closest('.product_data').find('.prod_id').val();
                var qty = $(this).closest('.product_data').find('.pro_quantity').val();
                var attribute = $(".selectAttribute").val();
                var cartId = $('.cartId').val();
                var data = {
                    'prod_id': prod_id,
                    'prod_qty': qty,
                    'attribute': attribute,
                    'cartId': cartId
                };
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "update-cart",
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            systemAlert('success', response.success);
                        } else {
                            systemAlert('danger', response.error);
                        }


                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                });
            });


            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            @if ($errors->any())
                @foreach ($errors->all() as $emsg)
                    toastr.error('{{ $emsg }}');
                @endforeach
            @endif
            @if (session()->has('alert'))
                @if (session('alert')[0] == 'danger')
                    toastr.error('{{ session('alert')[1] }}');
                @elseif (session('alert')[0] == 'success')
                    toastr.success('{{ session('alert')[1] }}');
                @else
                    toastr.error('{{ session('alert')[1] }}');
                @endif
            @endif
            function systemAlert(type, message) {
                if (type == 'danger') {
                    toastr.error(message);
                } else if (type == 'success') {
                    toastr.success(message);
                } else {
                    toastr.error(message);
                }
            }

        })(jQuery)

        function getWishlistData() {
            $.ajax({
                url: "{{ route('get-wishlist-data') }}",
                method: "get",
                success: function(response) {
                    $('.wish-products').html(response);
                }
            });
        }

        function getWishlistTotal() {
            $.ajax({
                url: "{{ route('get-wishlist-total') }}",
                method: "get",
                success: function(response) {
                    $('.wishlist-count').text(response);
                }
            });
        }

        function getCartTotal() {
            $.ajax({
                url: "{{ route('get-cart-total') }}",
                method: "get",
                success: function(response) {
                    $('.cart-count').text(response);
                }
            });
        }

        function getCartData() {
            $.ajax({
                url: "{{ route('get-cart-data') }}",
                method: "get",
                success: function(response) {

                    $('.cart--products').html(response);
                }
            });
        }

        $(document).on('click', '.quick-view-btn', function() {
            var modal = $('#quickViewModel');
            var product_id = $(this).data('product');
            $.ajax({
                url: "{{ route('quick-view') }}",
                method: "get",
                data: {
                    id: $(this).data('product')
                },
                success: function(response) {
                    modal.find('.ghghgsdhfgd').html(response);
                }
            });
            modal.modal('show');
        });

        let btnsizeActive = document.getElementsByClassName("btn__size_active");
    </script>

     <script>
        $(document).on("click", ".product__size_btn", function() {
            var productId = $(this).attr('data-id');
            var atributeId = $(this).attr('attribute_id');
            var size = $(this).text();

            $('.product__size_btn').removeClass('active');

            $(this).addClass('active');
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
                    $(".attribute_size_of_stock").text(size);
                    $(".product_stock_of_size").text(quantity ?? 0);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', errorThrown);
                }
            });
        })
    </script>
</body>
</html>
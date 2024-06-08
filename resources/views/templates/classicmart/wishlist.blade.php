@extends($template.'layouts.master')
@section('content')
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

    <!-- wishlist start -->
     <div class="wishlist-area section-padding">
        <div class="container">
            <div class="row gy-4 align-items-stretch">
                @if($wishlist_data->count() > 0)
                      @foreach ($wishlist_data as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6">
                    <div class="single-wishlist">
                        <div class="product-remove remove-wishlist" data-id="{{$product->id}}" data-page="1">
                            <i class="fa fa-xmark"></i>
                        </div>
                        <div class="product-thumbnail">
                            <a href="{{ route('product.details',$product->product->slug) }}">
                                <img src="{{ displayImage($templateAssets.'images/products/'.$product->product->image) }}" alt="">
                            </a>
{{--                            <a href="#quickViewModel" class="viewBtn quick-view-btn" data-product="{{$product->id}}" data-bs-toggle="modal"><i class="fa fa-magnifying-glass-plus"></i></a>--}}
                            <a href="#quickViewModel" class="viewBtn2  wishlist-icon quick-view-btn" data-product="{{$product->product->id}}" data-bs-toggle="modal">
                                        <span>
                                            <i class="fa fa-eye"></i>
                                        </span>
                            </a>
                        </div>
                        <div class="wishlist-product-info">
                            <div class="product-name">
                                <a href="{{ route('product.details',$product->product->slug) }}">{{__($product->product->name) }}</a>
                            </div>
                            <span class="added-date">
                                @lang('Added on'): {{$product->created_at->format('d F Y')}}
                            </span>
                            <div class="product-add-to-cart section-header">
                                <a href="{{ route('product.details',$product->product->slug) }}">@lang('Show Details')</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                    <div class="text-center">
                        <h1 class="text-danger">No Data Found</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- wishlist end -->
@endsection
@push('js')
    <script>
        (function($){
            "use strict";
            $('.viewBtn2').on('click', function() {
                var viewModal = $('#quickViewModel2');
                viewModal.find('#product_image').attr('src', $(this).data('image') + '?' + new Date().getTime());

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
@endpush
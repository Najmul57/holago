@extends($template.'layouts.master')
@section('content')
    @php
        $categories = App\Models\Category::where('status',1)->with('allSubCategories')->get();
    @endphp
    <div class="latest-product-area section-padding pb-0 search-result" >
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between filter-border g-0 position-relative">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="d-flex align-items-center product__filtering">
                        <div class="product-filter ">
                            <select class="sorting_item" id="sort_by">
                                <option value="0">Default Sorting</option>
                                <option value="latest">Latest Products</option>
                               <option value="asc">Price Low to High</option>
                               <option value="desc" >Price High to Low</option>
                            </select>
                        </div>
                        <input type="hidden" id="categoryId" value="{{$category_id ?? null}}">
                        <input type="hidden" id="subCategoryId" value="{{$subcategory_id ?? null}}">
                        <div class="product-filter">
                            <select class="category" id="sort_by_category">
                                <option value="0" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="filter-buttons d-none d-md-flex d-flex justify-content-end">
                        <div class="list-view-button active"><i class="fa fa-th-large" aria-hidden="true"></i></div>
                        <div class=" grid-view-button"><i class="fa fa-bars" aria-hidden="true"></i></div>
                    </div>
                </div>
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
            <!-- product -->
            <div id="search-result">
                <div class="row align-items-stretch gx-2">
                    <div class="col-12">
                        <ul id="singleProduct" class="list list-view-filter product-wrap mt-5">
                            @foreach($products as $product)
                                    <div class="single-latest-product single-category-product">
                                        <div class="single-product-head d-flex align-items-start justify-content-between">
                                            @if($product->is_featured == 1)
                                                <h6 style="background-color: #2c2c2c;">Hot</h6>
                                            @endif
                                            <div class="product-info">
                                                <!--<a href="{{ route('product.details',$product->id) }}"><i class="fa fa-bag-shopping"></i></a>-->
                                                <a href="#quickViewModel" class="viewBtn quick-view-btn" data-product="{{$product->id}}" data-bs-toggle="modal"><i class="fa fa-bag-shopping"></i></a>
                                            </div>
                                        </div>
                                        <!-- product image  -->
                                        <div class="latest-product-image" title="{{ __($product->name) }}">
                                            <a href="{{route('product.details',$product->slug)}}">
                                                <div class="front-image">
                                                    <img src="{{ displayImage($templateAssets.'images/products/'.$product->image) }}" class="w-100" alt="">
                                                </div>
                                                <div class="back-image">
                                                    <img src="{{ displayImage($templateAssets.'images/products/'.$product->hover_image) }}" class="w-100" alt="">
                                                </div>
                                            </a>
                                            <div class="product-info-bottom">
                                                <a href="#quickViewModel" class="viewBtn quick-view-btn" data-product="{{$product->id}}" data-bs-toggle="modal"><i class="fa fa-bag-shopping"></i></a>
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
                                                @if($product->discount_price)
                                                    <span class="discount__price"><del>{{$setting->currency_symbol}}{{__($product->regular_price)}}</del></span>
                                                    {{$setting->currency_symbol}}{{__(number_format($product->discount_price,2))}}
                                                @else
                                                    {{$setting->currency_symbol}}{{__(number_format($product->regular_price,2))}}
                                                @endif
                                            </h5>
                                            <div class="reward-point">
                                                <span>Earn up to </span>
                                                <span> HOLAGO CLUB POINTS.</span>
                                                <span data-toggle="tooltip" data-placement="top"
                                                      title="Join our club! For every ৳100 you get 1000 HOLAGO CLUB POINTS.">
                                                <i class="fa fa-info-circle"></i>
                                            </span>
                                            </div>

                                            <div class="grid-none">
                                                <div class="content">
                                                    <p> @php echo __($product->description) @endphp</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
{{--                            @empty--}}
{{--                            <div>--}}
{{--                                <span>@lang('Product Not Found')</span>--}}
{{--                            </div>--}}
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    @if($products->hasPages())
                        <div class='card-footer pagination__system d-flex justify-content-center pt-5 pb-3'>
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <style>
        .pagination__system .active>.page-link, .pagination__system .page-link.active{
            background-color: #000 !important;
            border-color: #000 !important;
        }
        .pagination__system .page-link{

        }
        .list-view-button,
        .grid-view-button {
            /* color: white;
            border: 1px solid white;
            padding: 5px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px; */
            cursor: pointer;
        }

        .grid-view-filter .single-latest-product {
            display: flex;
        }

        .list-view-button {
            margin-right: 10px;
        }

        .list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        /* li {
            background-color: #1f364d;
            color: white;
            border-radius: 3px;
            margin-bottom: 10px;
            transition: 0.3s;
        } */


        .list.list-view-filter {
            box-sizing: border-box;
            display: flex;
            gap: 15px;
            flex-flow: wrap;
        }

        .list.list-view-filter .single-latest-product {
            width: calc(32.7%);
            box-sizing: border-box;
        }

        .list.grid-view-filter {
            flex-flow: row wrap;
        }

        .list.grid-view-filter .single-latest-product {
            width: calc(50% - 0px);
        }
    </style>
@endpush
@push('js')
    <script>
        (function($){
            "use strict";
            $('.viewBtn4').on('click', function() {
                var viewModal = $('#quickViewModel4');
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


            // grid list view
            const listViewButton = document.querySelector('.list-view-button');
            const gridViewButton = document.querySelector('.grid-view-button');
            const list = document.querySelector('.product-wrap');

            listViewButton.onclick = function () {
                list.classList.remove('grid-view-filter');
                list.classList.add('list-view-filter');

                listViewButton.classList.add('active');
                gridViewButton.classList.remove('active');

                listViewButton.style.backgroundColor = 'black';
                gridViewButton.style.backgroundColor = '';
            }

            gridViewButton.onclick = function () {
                list.classList.remove('list-view-filter');
                list.classList.add('grid-view-filter');

                gridViewButton.classList.add('active');
                listViewButton.classList.remove('active');

                gridViewButton.style.backgroundColor = 'black';
                listViewButton.style.backgroundColor = '';
            }
        })(jQuery);
    </script>
@endpush
@push('js')
    <script>
        $(document).ready(function(){
            $('#sort_by').on('change',function(e) {
                e.preventDefault();
                  var sort_by = $('#sort_by').val();
                  var categoryId = $("#categoryId").val();
                  var subCategoryId = $("#subCategoryId").val();
                    $.ajax({
                        url: "{{route('sort_by')}}",
                        method: 'GET',
                        data: {sort_by:sort_by,category_id:categoryId,sub_category_id:subCategoryId},
                        success: function(response) {
                            var data = response.results.data;
                            var results = '';
                            // console.log(data)
                            if(data.length > 0)
                            {
                                for(var i = 0; i< data.length; i++)
                                {
                                    var singleData = data[i];
                                    var id = singleData.id;
                                    var productDetails = "{{route('product.details', '')}}"+"/"+singleData.slug;
                                    var languageEdit = "{{route('admin.language.edit', '')}}"+"/"+singleData.id;
                                    var item = `

<div class="single-latest-product single-category-product">
    <div class="single-product-head d-flex align-items-start justify-content-between">
        <!-- <h6 style="background-color: #2c2c2c;">Hot</h6> -->
        <div class="product-info">
            <a href="#quickViewModel" class="viewBtn quick-view-btn" data-product="${id}" data-bs-toggle="modal"><i class="fa fa-bag-shopping"></i></a>
           
        </div>
    </div>
    <!-- product image  -->
    <div class="latest-product-image" title="${singleData.name}">
        <a href="${productDetails}">
            <div class="front-image">
                <img src='${window.location.origin}/assets/classicmart/images/products/${singleData.image}' class="w-100" alt="">
            </div>
            <div class="back-image">
                <img src='${window.location.origin}/assets/classicmart/images/products/${singleData.hover_image}' class="w-100" alt="">
            </div>
        </a>
        <div class="product-info-bottom">
            <a  href="#quickViewModel" class="viewBtn quick-view-btn" data-product="${id}" data-bs-toggle="modal"><i class="fa fa-bag-shopping"></i></a>
        </div>
    </div>
    <div class="latest-product-content">
        <h5 class="d-flex align-items-center justify-content-between">
            <a href="${productDetails}">${singleData.name}</a>
                                 @php
                                        $wCk = checkWishList($product->id);
                                    @endphp
                                    <a href="javascript:void(0)" class="add-to-wish-list" data-id="${singleData.id}">
                                            <span data-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="fa fa-heart"></i>
                                            </span>
            </a>
        </h5>
        <h5 class="price">


                                              {{$setting->currency_symbol}} ${singleData.regular_price}


        </h5>
        <div class="reward-point">
            <span>Earn up to </span>
            <span> HOLAGO CLUB POINTS.</span>
            <span data-toggle="tooltip" data-placement="top"
                  title="Join our club! For every ৳100 you get 1000 HOLAGO CLUB POINTS.">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
        </div>

        <div class="grid-none">
            <div class="content">
                {{--<p> @php echo ${singleData.description} @endphp</p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>

`;
                                    results += item;
                                }
                                $('#singleProduct').html(results);
                            }
                            // console.log('sheikh hasina');
                        }
                    });
                  });

            });
    </script>
    <script>
        $(document).ready(function(){
            $('#sort_by_category').on('change',function(e) {
                e.preventDefault();
                  var sort_by_category = $('#sort_by_category').val();

                    $.ajax({
                        url: "{{route('search.by.category')}}",
                        method: 'GET',
                        data: {sort_by_category:sort_by_category},
                        success: function(response) {
                            var data = response.results.data;
                            var results = '';
                             console.log(data)
                            if(data.length > 0)
                            {
                                for(var i = 0; i< data.length; i++)
                                {
                                    var singleData = data[i];
                                    var id = singleData.id;
                                    var productDetails = "{{route('product.details', '')}}"+"/"+singleData.slug;
                                    var languageEdit = "{{route('admin.language.edit', '')}}"+"/"+singleData.id;
                                    var item = `
                                     <div class="single-latest-product single-category-product">
    <div class="single-product-head d-flex align-items-start justify-content-between">
        <!-- <h6 style="background-color: #2c2c2c;">Hot</h6> -->
        <div class="product-info">
            <a href="#quickViewModel" class="viewBtn quick-view-btn" data-product="${id}" data-bs-toggle="modal"><i class="fa fa-bag-shopping"></i></a>
        </div>
    </div>
    <!-- product image  -->
    <div class="latest-product-image" title="${singleData.name}">
        <a href="${productDetails}">
            <div class="front-image">
                <img src='${window.location.origin}/assets/classicmart/images/products/${singleData.image}' class="w-100" alt="">
            </div>
            <div class="back-image">
                <img src='${window.location.origin}/assets/classicmart/images/products/${singleData.hover_image}' class="w-100" alt="">
            </div>
        </a>
        <div class="product-info-bottom">
            <a href="#quickViewModel" class="viewBtn quick-view-btn" data-product="${id}" data-bs-toggle="modal"><i class="fa fa-bag-shopping"></i></a>
        </div>
    </div>
    <div class="latest-product-content">
        <h5 class="d-flex align-items-center justify-content-between">
            <a href="${productDetails}">${singleData.name}</a>
            @php
                                        $wCk = checkWishList($product->id);
                                    @endphp
                                    <a href="javascript:void(0)" class="add-to-wish-list" data-id="${singleData.id}">
                                            <span data-toggle="tooltip" data-bs-placement="left" title="Wishlist">
                                                <i class="fa fa-heart"></i>
                                            </span>
            </a>
        </h5>
        <h5 class="price">
            {{$setting->currency_symbol}} ${singleData.regular_price}
        </h5>
        <div class="reward-point">
            <span>Earn up to </span>
            <span> HOLAGO CLUB POINTS.</span>
            <span data-toggle="tooltip" data-placement="top"
                  title="Join our club! For every ৳100 you get 1000 HOLAGO CLUB POINTS.">
                                        <i class="fa fa-info-circle"></i>
                                    </span>
        </div>

        <div class="grid-none">
            <div class="content">
                {{--<p> @php echo ${singleData.description} @endphp</p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>

`;
                                    results += item;
                                }
                                $('#singleProduct').html(results);
                            }
                            // console.log('sheikh hasina');
                        }
                    });
                  });

            });
    </script>
@endpush
@php
     $categories = App\Models\Category::where('status', 1)
    ->where('top_category', 1)
    ->with(['allSubCategories' => function ($query) {
        $query->where('top_category', 1);
    }])
    ->get();
    $languages = App\Models\Language::get();
    $coupon = App\Models\Coupon::where('status', 1)
        ->orderBy('id', 'desc')
        ->limit(5)
        ->get();
    $products = App\Models\Product::where('status', 1)
        ->orderBy('id', 'desc')
        ->get();
    $contact = App\Models\Template::where('template_name', $setting->template)
        ->where('name', 'contact')
        ->where('is_multiple', 0)
        ->first();
@endphp
<!-- header start -->

<style>
    .najmul {
        padding: 0;
        width: auto;
        cursor: pointer;
    }

    .accordion-header.mobile__menu__collapse {
        display: flex;
        justify-content: space-between;
        padding: 5px 10px;
    }

    .accordion-header.mobile__menu__collapse .accordion-button:not(.collapsed) {
        background-color: transparent;
        box-shadow: none;
    }

    .najmulhasan {
        padding: 0 20px;
        padding-bottom: 10px;
    }

    .najmulhasan li:not(:last-child) {
        border-bottom: 1px solid #ddd;
    }

    .najmulhasan li a {
        display: block;
        padding: 5px 0;
    }

    .categoryBold{
        font-size: 15px;
        font-weight: bold;
    }

</style>

<header>
    <div class="h_header">
        <div class="header-top d-flex">
            <div class="h_header-left d-flex align-items-center position-relative">
                <div class="h_logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ displayImage($templateAssets . 'images/logo/logo.png') }}" alt="">
                    </a>
                </div>
                <div id="main_navigation">
                    <a href="{{ route('shop') }}">
                        @lang('MENS')
                    </a>
                </div>
            </div>


            <div class="h_header-middle position-relative">
                <form action="" method="get">
                    @csrf
                    <div class="form-group d-flex align-items-center position-relative" id="search__header">
                        <input type="search" name="search" class="w-100" id="search"
                            placeholder="What are you looking for?" autocomplete="off" required>
                        <button class="btn search__btn"><i class="fa fa-magnifying-glass"></i></button>
                        <div class="position-absolute search__show mt-5">
                            <div class="list-group list-group-flush" id="suggestions">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="h_header-right d-flex align-items-center justify-content-end">
                <a href="{{ route('user.dashboard') }}" class="h_header-action-item h_account">
                    <i class="fa fa-user"></i>
                </a>
                <a href="{{ route('wishlist') }}" class="h_header-action-item h_wishlist d-flex align-items-center"
                    id="wish-button">
                    <i class="fa fa-heart"></i>
                    <span class="wishlist-count amount">0</span>
                </a>
                <a class="h_header-action-item h_minicart d-flex align-items-center" data-bs-toggle="offcanvas"
                    href="#cardModal" role="button" aria-controls="offcanvasExample" id="cart-button">
                    <i class="fa fa-cart-shopping"></i>
                    <span class="cart-count amount">0</span>
                </a>
            </div>

            @if ($setting->multi_lang)
                <div class="h_header-right d-none align-items-center justify-content-end">
                    <!-- select item -->
                    <select class="language multilanguage_select">
                        @foreach ($languages as $language)
                            <option value="{{ $language->lang_code }}"
                                @if (session('lang') == $language->lang_code) selected @endif>{{ __($language->name) }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- search box for mobile -->
            <!-- <ul class="advance-search advance-mobile-search d-none">
                <h6>categories</h6>
                <li><a href="#">disco pants in <span>trousers<i class="fa fa-angle-right"></i></span></a></li>
                <li><a href="#">disco pants in <span>trousers<i class="fa fa-angle-right"></i></span></a></li>
                <li><a href="#">disco pants in <span>trousers<i class="fa fa-angle-right"></i></span></a></li>
            </ul> -->

        </div>
    </div>

    <!-- mobile menu -->
    <header class="header mobile-header d-none header-sticky">
        <div class="container">
            <div class="header-main">
                <div class="open-nav-menu">
                    <span></span>
                </div>
                <div class="menu-overlay">
                </div>
                <!-- navigation menu start -->
                <nav class="nav-menu">
                    <div class="close-nav-menu">
                        <img src="{{ displayImage($templateAssets . 'img/close.svg') }}" alt="close">
                    </div>

                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="category-tab" data-bs-toggle="pill"
                                data-bs-target="#category-pane" type="button" role="tab"
                                aria-controls="category-pane" aria-selected="true">@lang('CATEGORIES')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="menu-tab" data-bs-toggle="pill" data-bs-target="#menu-pane"
                                type="button" role="tab" aria-controls="menu-pane"
                                aria-selected="false">@lang('MENU')</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="category-pane" role="tabpanel"
                            aria-labelledby="category-tab" tabindex="0">
                            <ul class="menu">
                                <li class="menu-item">
                                    <a href="{{ route('home') }}">@lang('Home')</a>
                                </li>
                                <!--@foreach ($categories as $category)-->
                                <!--    <li class="menu-item menu-item-has-children">-->
                                <!--        <a href="{{ route('products.category', ['id' => $category->id, 'slug' => slug($category->name)]) }}"-->
                                <!--            data-toggle="sub-menu">{{ __($category->name) }} <i class="plus"></i></a>-->
                                <!--        <ul class="sub-menu">-->
                                <!--            @foreach ($category->allSubCategories as $subcategory)-->
                                <!--                <li class="menu-item"><a-->
                                <!--                        href="{{ route('products.subcategory', ['id' => $subcategory->id, 'slug' => slug($subcategory->name)]) }}">{{ __($subcategory->name) }}</a>-->
                                <!--                </li>-->
                                <!--            @endforeach-->
                                <!--        </ul>-->
                                <!--    </li>-->
                                <!--@endforeach-->
                                <div class="accordion accordion-flush" id="hasan">
                                    @foreach ($categories as $key => $category)
                                        <div class="accordion-item">
                                            <div class="accordion-header mobile__menu__collapse">
                                                <a
                                                    href="{{ route('products.category', $category->slug) }}">{{ __($category->name) }}</a>
                                                <span class="accordion-button collapsed najmul"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#h_najmul{{ $key }}"
                                                    aria-expanded="false"
                                                    aria-controls="h_najmul{{ $key }}">
                                                </span>
                                            </div>
                                            <div id="h_najmul{{ $key }}" class="collapse"
                                                data-bs-parent="#hasan">
                                                <ul class="najmulhasan">
                                                    @foreach ($category->allSubCategories as $subcategory)
                                                {{-- @dd($subcategory->id); --}}

                                                    <li>
                                                        <a href="{{ route('products.subcategory', $subcategory->slug ) }}">{{ __($subcategory->name) }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="menu-pane" role="tabpanel" aria-labelledby="menu-tab"
                            tabindex="0">

                            <ul class="sidebar-mobile-menu">
                                <li><a href="{{ route('shop') }}">@lang('shop')</a></li>
                                <li><a href="{{ route('holago.club') }}">@lang('HOLAGO Club')</a></li>
                                <li><a href="{{ route('wishlist') }}" id="wish-button"><i
                                            class="fa fa-heart"></i>(<label
                                            class="wishlist-count amount">0</label>)@LANG('Wishlist')</a></li>
                                <li><a href="{{ route('user.login') }}"> <i class="fa fa-user"></i>
                                        @lang('login/register')</a></li>
                            </ul>
                            @if ($setting->multi_lang)
                                <ul class="sidebar-mobile-menu">
                                    <!-- select item -->
                                    <select class="language multilanguage_select">
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->lang_code }}"
                                                @if (session('lang') == $language->lang_code) selected @endif>
                                                {{ __($language->name) }}</option>
                                        @endforeach
                                    </select>
                                </ul>
                            @endif
                            <ul class="sidebar-mobile-menu">
                                <span>@lang('need help')?</span>
                                <li class="border-0"><a href="tel:{{ $contact->data->phone }}"><i
                                            class="fa fa-phone"></i>{{ __($contact->data->phone) }}</a></li>
                                <li><a href="mailto:{{ $contact->data->email }}"><i
                                            class="fa fa-envelope"></i>{{ __($contact->data->email) }}</a></li>
                            </ul>

                        </div>
                    </div>


                </nav>
                <!-- navigation menu end -->
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ displayImage($templateAssets . 'images/logo/logo.png') }}" alt="">
                    </a>
                </div>
                <div class="mobile-header-search" data-bs-toggle="offcanvas" href="#mobile_header_search"
                    role="button" aria-controls="offcanvasExample">
                    <i class="fa fa-search"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile header search -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobile_header_search" aria-labelledby="search-bar">
        <div class="offcanvas-header">
            <h6 class="offcanvas-title" id="search-bar">@lang('SEARCH OUR SITE')</h6>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mobile-search">
            <form action="">
                <div class="form-group site-product-search" id="search__header">
                    <input type="search" name="search" class="form-control search" id=""
                        placeholder="What are you looking for?" autocomplete="off" required>
                    <i class="fa fa-search"></i>
                </div>
                <div class="position-absolute search__show mt-5">
                    <div class="list-group list-group-flush suggestions">
                    </div>
                </div>
            </form>
        </div>
        <div class="offcanvas-footer mobile-search-footer">
            <a href="{{ route('shop') }}">@lang('View All')({{ __($products->count()) }}) <i
                    class="fa fa-long-arrow-right"></i></a>
        </div>
    </div>



    {{--    <div class="h_header-middle position-relative"> --}}
    {{--        <form action=""  method="get"> --}}
    {{--            @csrf --}}
    {{--            <div class="form-group d-flex align-items-center position-relative" id="search__header"> --}}
    {{--                <input type="search" name="search" class="w-100" id="search" placeholder="What are you looking for?" autocomplete="off" required> --}}
    {{--                <button class="btn search__btn"><i class="fa fa-magnifying-glass"></i></button> --}}
    {{--                <div class="position-absolute search__show mt-5"> --}}
    {{--                    <div class="list-group list-group-flush" id="suggestions"> --}}
    {{--                    </div> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </form> --}}
    {{--    </div> --}}



    <div class="header-bottom header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="header-bottom-menu d-flex pl-100 pr-100 justify-content-center position-relative mb-0">
                        @foreach ($categories as $category)
                            <li><a
                                    href="{{ route('products.category', $category->slug) }}">{{ __($category->name) }} <span style="background-color: {{$category->tip_bg}}; border-radius:50px; padding:3px; font-weight:600;color:white">{{$category->tip_text ?? ''}}</span></a>
                                <div class="submenu position-absolute w-100">
                                    <div class="row">
                                        <div class="col-xxl-2 col-xl-2 col-lg-2">
                                            <ul class="submenu-item p-3">
                                                <h6>{{ __($category->name) }}</h6>
                                                @foreach ($category->allSubCategories as $subcategory)
                                                    <li>
                                                        <a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }}</a>

                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @if ($coupon)
                                            @foreach ($coupon as $code)
                                                <div class="col-xxl-2 col-xl-2 col-lg-2 bg-white">
                                                    <ul class="submenu-item submenu-offer-item p-2">
                                                        <h6>@lang('OFFERS')</h6>
                                                        <li><a href="#">{{ __($code->name) }}</a></li>
                                                        <li><a href="#">@lang('Next Day Delivery')!** @lang('Use Code'):
                                                                {{ __($code->code) }}</a></li>
                                                    </ul>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <span><a href="{{ route('shop') }}"
                                            class="text-white bg-black lh-1">@lang('NEW LINES ADDED DAILY!')</a></span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->


@push('js')
    <script>
        (function($) {
            "use strict";

            $('.language').on('change', function() {
                window.location.href = `{{ url('/language') }}/${$(this).val()}`;
            });

        })(jQuery);
    </script>
@endpush

@push('js')
    <script>
    //     $(document).ready(function() {
    //         function result(query = '') {
    //             if (query.length > 2) {
    //                 var route = "{{ route('search') }}";
    //                 var search = query;
    //                 $.ajax({
    //                     url: route,
    //                     method: "GET",
    //                     data: {
    //                         search: search
    //                     },
    //                     success: function(response) {
    //                         var suggestions = $('#suggestions');
    //                         suggestions.empty(); // Clear previous suggestions

    //                         var results = response.results;
    //                         if (results.length > 0) {
    //                             results.forEach(function(result) {
    //                                 var listItem = $('<li class="list-group-item"></li>').text(
    //                                     result.name);
    //                                 listItem.on('click', function() {
    //                                     var proId = result
    //                                         .slug; // Assuming there is an 'id' field in the result object
    //                                     window.location.href =
    //                                         "{{ route('product.details', '') }}/" +
    //                                         proId;
    //                                 });
    //                                 suggestions.append(listItem);
    //                             });
    //                         } else {
    //                             var noResultsItem = $('<li class="list-group-item"></li>').text(
    //                                 'No results found.');
    //                             suggestions.append(noResultsItem);
    //                         }
    //                     }
    //                 });
    //             } else {
    //                 $('#suggestions').html('');
    //             }
    //         }
    //         $('body').on('click', function() {
    //             $('#suggestions').empty();
    //         });

    //         $(document).on('keyup', '#search', function() {
    //             var query = $(this).val();
    //             result(query);
    //         });
    //     });
    </script>

     <script>
        $(document).ready(function() {
            function result(query = '') {
                if (query.length > 2) {
                    var route = "{{ route('search') }}";
                    var search = query;
                    $.ajax({
                        url: route,
                        method: "GET",
                        data: {
                            search: search
                        },
                        success: function(response) {
                            console.log('my response here', response);
                            var suggestions = $('#suggestions');
                            suggestions.empty();

                            var results = response.results;
                            if (results.length > 0) {
                                var groupedResults = {};
                                results.forEach(function(result) {
                                    console.log("result", result)
                                    var category = result?.category?.slug;

                                    if (!groupedResults[category]) {
                                        groupedResults[category] = [];
                                    }

                                    groupedResults[category]
                                        .push(result);
                                });
                                console.log("grouped result", groupedResults);

                                // results.forEach(function(result) {
                                //     console.log(results);
                                //     var listItem = $('<li class="list-group-item"></li>').text(
                                //         result.name);
                                //     listItem.on('click', function() {
                                //         if (results.slug) {

                                //             var categoryId = results.slug;
                                //             window.location.href =
                                //                 "{{ route('products.category', '') }}/" +
                                //                 categoryId;
                                //         } else {

                                //             var proId = results.slug;
                                //             window.location.href =
                                //                 "{{ route('product.details', '') }}/" +
                                //                 proId;
                                //         }
                                //     });
                                //     suggestions.append(listItem);
                                // });<ul>


                                // for (var category in groupedResults) {
                                //     console.log('category find:', groupedResults);
                                //     if (groupedResults.hasOwnProperty(category)) {
                                //         var categoryItem = $(
                                //             `<ul>
                            //            <li class="list-group-item category"></li>
                            //             <ul>
                            //             <li class="list-group-item"></li>
                            //             </ul>
                            //         </ul>`).text(
                                //             category);
                                //         suggestions.append(categoryItem);
                                //         console.log("suggesiton", suggestions)

                                //         groupedResults[category].forEach(function(result) {
                                //             var listItem = $(
                                //                 '<li class="list-group-item"></li>').text(
                                //                 result.name);
                                //             listItem.on('click', function() {
                                //                 var id = result.slug || result
                                //                     .id;
                                //                 window.location.href =
                                //                     "{{ route('product.details', '') }}/" +
                                //                     id;
                                //             });
                                //             suggestions.append(listItem);
                                //         });
                                //     }
                                // }

                                for (var category in groupedResults) {
                                    if (groupedResults.hasOwnProperty(category)) {
                                        var categoryRoute = "{{ route('products.category', '') }}/" + category;

                                        var categoryItem = $(
                                        `<ul class="list-group">
                                            <li class="list-group-item category text-bold">
                                                <a class="categoryBold" href="${categoryRoute}">Category Name: ${category}</a>
                                            </li>
                                            <ul class="list-group"></ul>
                                        </ul>`
                                    );




                                        suggestions.append(categoryItem);


                                        groupedResults[category].forEach(function(result) {

                                            var listItem = $(
                                                '<li class="list-group-item">' + result
                                                .name + '</li>'
                                            );


                                            listItem.on('click', function() {
                                                var id = result.slug || result.id;
                                                window.location.href =
                                                    "{{ route('product.details', '') }}/" +
                                                    id;
                                            });


                                            categoryItem.find('ul.list-group').append(listItem);
                                        });


                                    }
                                }


                            } else {
                                var noResultsItem = $('<li class="list-group-item"></li>').text(
                                    'No results found.');
                                suggestions.append(noResultsItem);
                            }
                        }
                    });
                } else {
                    $('#suggestions').html('');
                }
            }

            $('body').on('click', function() {
                $('#suggestions').empty();
            });

            $(document).on('keyup', '#search', function() {
                var query = $(this).val();
                result(query);
            });
        });
</script>
    <script>
        $(document).ready(function() {
            function result(query = '') {
                if (query.length > 2) {
                    var route = "{{ route('search') }}";
                    var search = query;
                    $.ajax({
                        url: route,
                        method: "GET",
                        data: {
                            search: search
                        },
                        success: function(response) {
                            var suggestions = $('.suggestions');
                            suggestions.empty(); // Clear previous suggestions

                            var results = response.results;
                            if (results.length > 0) {
                                results.forEach(function(result) {
                                    var listItem = $('<li class="list-group-item"></li>').text(
                                        result.name);
                                    listItem.on('click', function() {
                                        var proId = result
                                            .slug; // Assuming there is an 'id' field in the result object
                                        window.location.href =
                                            "{{ route('product.details', '') }}/" +
                                            proId;
                                    });
                                    suggestions.append(listItem);
                                });
                            } else {
                                var noResultsItem = $('<li class="list-group-item"></li>').text(
                                    'No results found.');
                                suggestions.append(noResultsItem);
                            }
                        }
                    });
                } else {
                    $('.suggestions').html('');
                }
            }
            $('body').on('click', function() {
                $('.suggestions').empty();
            });

            $(document).on('keyup', '.search', function() {
                var query = $(this).val();
                result(query);
            });
        });
    </script>
@endpush

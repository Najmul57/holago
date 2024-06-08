@extends('admin.layouts.master')
@section('content')
@section('title', 'Order Update')
@php
    $jsonData = $order->shipping_address;
    $data = $jsonData;
@endphp

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class='row mt-3'>
    <div class='col-12 col-lg-12'>
        <div class='card shadow-sm border-0'>
            <div class='card-body'>
                <form action="{{ route('admin.order.update', $order->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="orderIdForModal" value="{{ $order->id }}">
                    <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0">@lang('Order Update')</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="order_number01"
                                            class='font-weight-bold form-label'>@lang('Order_number')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="order_number"
                                            value="{{ __($order->order_number) }}" id="order_number01" disabled>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label for="customer01" class='form-label'>@lang('Customer')</label>
                                        @if ($order->customer_id)
                                            <select class="form-control " name="customer_id" id="customer01">
                                                <option selected value="">@lang('Select One')</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        @if ($customer->id == $order->customer_id) selected @endif>
                                                        {{ __($customer->name) }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <p>{{ 'N/A' }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="shipping_charge01"
                                            class='font-weight-bold form-label'>@lang('Shipping_charge')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="shipping_charge"
                                            value="{{ __($order->shipping_charge) }}" id="shipping_charge01">
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="total_amount01"
                                            class='font-weight-bold form-label'>@lang('Total_amount')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="total_amount"
                                            value="{{ __($order->total_amount) }}" id="total_amount01" disabled>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="coupon_code01"
                                            class='font-weight-bold form-label'>@lang('Coupon_code')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="coupon_code"
                                            value="{{ __($order->coupon_code) }}" id="coupon_code01">
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="coupon_amount01"
                                            class='font-weight-bold form-label'>@lang('Coupon_amount')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="coupon_amount"
                                            value="{{ __($order->coupon_amount) }}" id="coupon_amount01">
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="order_type01"
                                            class='font-weight-bold form-label'>@lang('Order_type')</label><span
                                            class='text-danger'>*</span>
                                        <select class="form-control" name="order_type" id="customer01">
                                            <option selected disabled>@lang('Select One')</option>
                                            <option value="cod" {{ $order->order_type == 'cod' ? 'selected' : '' }}>
                                                COD</option>
                                            <option value="sslcommerz"
                                                {{ $order->order_type == 'sslcommerz' ? 'selected' : '' }}>
                                                sslcommerz</option>

                                        </select>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="payment_status01"
                                            class='font-weight-bold form-label'>@lang('Payment_status')</label>
                                        <input type="text" class="form-control" name="payment_status"
                                            value="{{ __($order->payment_status) }}" id="payment_status01">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5>Shipping Address</h5>
                        <div class="card-body">
                            <div class="row g-3">
                                @php
                                    $jsonData = $order->shipping_address;
                                    $data = $jsonData;
                                @endphp
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="shipping_address01"
                                            class='font-weight-bold form-label'>@lang('Name')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="s_name"
                                            value="{{ $data['name'] }}" id="shipping_address01" required>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="shipping_charge01"
                                            class='font-weight-bold form-label'>@lang('Mobile')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="s_phone"
                                            value="{{ $data['mobile'] }}" id="shipping_charge01" required>
                                    </div>
                                </div>
                                <div class='col-md-6'>

                                    <div class='form-row form-group'>
                                        <label for="order_type01"
                                            class='font-weight-bold form-label'>@lang('Division')</label><span
                                            class='text-danger'>*</span>
                                        <select class="form-control" name="district_id" id="customer01">
                                            <option selected disabled>@lang('Select One')</option>
                                            @php
                                                $data2 = $data['district_id'];
                                            @endphp

                                            <option value="Dhaka" {{ 'Dhaka' == $data2 ? 'selected' : '' }}>Dhaka
                                            </option>
                                            <option value="Chittagong" {{ 'Chittagong' == $data2 ? 'selected' : '' }}>
                                                Chittagong</option>
                                            <option value="Barishal" {{ 'Barishal' == $data2 ? 'selected' : '' }}>
                                                Barishal</option>
                                            <option value="Rajshahi" {{ 'Rajshahi' == $data2 ? 'selected' : '' }}>
                                                Rajshahi</option>
                                            <option value="Rangpur" {{ 'Rangpur' == $data2 ? 'selected' : '' }}>
                                                Rangpur</option>
                                            <option value="Sylhet" {{ 'Sylhet' == $data2 ? 'selected' : '' }}>
                                                Sylhet</option>
                                            <option value="Mymensingh" {{ 'Mymensingh' == $data2 ? 'selected' : '' }}>
                                                Mymensingh</option>
                                            <option value="Khulna" {{ 'Khulna' == $data2 ? 'selected' : '' }}>
                                                Khulna</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="total_amount01"
                                            class='font-weight-bold form-label'>@lang('Email')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="s_email"
                                            value="{{ $data['email'] }}" id="total_amount01" required>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-row form-group'>
                                        <label for="coupon_code01"
                                            class='font-weight-bold form-label'>@lang('Address')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="s_address"
                                            value="{{ $data['address'] }}" id="coupon_code01" required>
                                    </div>
                                </div>
                                <div class='col-md-12'>
                                    <div class='form-row form-group'>
                                        <label for="coupon_code01"
                                            class='font-weight-bold form-label'>@lang('Note')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="s_note"
                                            value="{{ $data['note'] }}" id="coupon_code01" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h5>Order Details</h5>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">@lang('PRODUCT Image')</th>
                                                <th scope="col">@lang('PRODUCT NAME')</th>
                                                <th scope="col">@lang('ATTRIBUTE')</th>
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
                                            @foreach ($order->order_details as $item)
                                                <tr class="product_data">
                                                    <td>
                                                        <div class="single-cart-product">
                                                            <div class="single-cart-product-photo">
                                                                <a href="{{ route('product.details', $item->product->slug) }}"
                                                                    target="_blank">
                                                                    <img style="height:50px;width: 50px"
                                                                        src="{{ asset($templateAssets . 'images/products/' . $item->product->image) }}"
                                                                        alt="product image">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="single-cart-product-content">
                                                            <div
                                                                class="cart-product-name d-flex justify-content-between">
                                                                <div>
                                                                    <p><a href="{{ route('product.details', $item->product->slug) }}"
                                                                            target="_blank">{{ __($item->product->name) }}</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="single-cart-product-content">
                                                            <div
                                                                class="cart-product-name d-flex justify-content-between">
                                                                <div>
                                                                    <p style="text-align: center">
                                                                        {{ $item->attribute ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="cart-product-price">
                                                            @if ($item->product->discount_price == null || $item->product->discount_price == 0)
                                                                {{ __($setting->currency_symbol) }}{{ __($item->product->regular_price) }}
                                                            @else
                                                                {{ __($setting->currency_symbol) }}{{ __(number_format($item->product->discount_price, 2)) }}
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="cart-product-price">
                                                            {{ __($item->quantity) }}
                                                        </div>
                                                    </td>
                                                    @if ($item->product->discount_price == null || $item->product->discount_price == 0)
                                                        <td>{{ __($setting->currency_symbol) }}{{ __(number_format($item->product->regular_price * $item->quantity, 2)) }}
                                                        </td>
                                                    @else
                                                        <td>{{ __($setting->currency_symbol) }}{{ __(number_format($item->product->discount_price * $item->quantity, 2)) }}
                                                        </td>
                                                    @endif

                                                    <td>
                                                        @if (count($order->order_details) > 1)
                                                            <a id="delete" href="{{ route('admin.item_remove', $item->id) }}">
                                                                <button type="button" class="btn bg-gradient-danger btn-sm icon-btn ml-1">
                                                                    <i class="la la-trash"></i>
                                                                </button>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if ($item->product->discount_price == null || $item->product->discount_price == 0)
                                                    @php $sub_total += $item->product->regular_price * $item['quantity'] @endphp
                                                @else
                                                    @php $sub_total += $item->product->discount_price * $item['quantity'] @endphp
                                                @endif
                                            @endforeach

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary mb-3 mt-2" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">
                                                Add Product
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                                data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Product
                                                                Add</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">






                                                            <label for="" class="form-label">Product
                                                                Name</label>
                                                            <div class="mb-3">
                                                                <select name="name" id="selectModalProduct"
                                                                    class="form-select form-select-lg mb-3 "
                                                                    aria-label=".form-select-lg example">
                                                                    <option selected>Select Product</option>
                                                                    @foreach ($products as $product)
                                                                        <option value="{{ $product->id }}"
                                                                            data-price="{{ $product->regular_price }}">
                                                                            {{ $product->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label">Product Price</label>
                                                                <input type="text" name="regular_price"
                                                                    id="product-price"
                                                                    class="form-control modalProductPrice"
                                                                    placeholder="Product Price" value="0"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <select name="attribute" id="product-select"
                                                                    class="form-select form-select-lg mb-3 modalProductAttribute"
                                                                    aria-label=".form-select-lg example">
                                                                    <option selected>Select Attributes</option>

                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Stock
                                                                    Quantity</label>
                                                                <input type="number" readonly name="stock"
                                                                    class="form-control stockQuantityModal"
                                                                    value="0">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" class="form-label">Product
                                                                    Quantity</label>
                                                                <input type="number" name="quantity"
                                                                    id="product_quantity" min="1"
                                                                    class="form-control quantityInputModal"
                                                                    placeholder="Product Quantity">
                                                            </div>


                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button id="buttonModalStore" type="button"
                                                                    class="btn btn-primary">Submit</button>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3">
                        <div class="cart-view-total-amount">
                            <div class="cart-view-grand-total">
                                <h5>Grand total</h5>
                                <div class="checkout-amount">
                                    <p>
                                        <span>Subtotal :</span>
                                        <span>{{ __($setting->currency_symbol) }}<span
                                                id="cartSubtotal">{{ __(number_format($sub_total, 2)) }}</span></span>
                                        <input type="hidden" value="{{ $sub_total }}" name="sub_total">
                                    </p>
                                    <p>
                                        <span>Shipping :</span>
                                        <span>{{ __($setting->currency_symbol) }}{{ $order->shipping_charge }}</span>
                                    </p>
                                    <p>
                                        <span>Discount :</span>
                                        <span>{{ __($setting->currency_symbol) }}<span
                                                id="couponAmount">{{ @session('coupon')['amount'] ?? 0 }}</span></span>
                                    </p>
                                    <p>
                                        <span>Admin Discount :</span>
                                        <span>{{ __($setting->currency_symbol) }}
                                            <input type="text" name="special_discount"
                                                value="{{ $order->special_discount ?? 0 }}">
                                        </span>
                                    </p>
                                    <p>
                                        @php
                                            $shipping = $order->shipping_charge;
                                        @endphp
                                        <span>Total :</span>
                                        <span>{{ __($setting->currency_symbol) }}<span
                                                id="finalTotal">{{ number_format(($sub_total - @session('coupon')['amount'] ?? 0) + $shipping - $order->special_discount, 2) }}</span></span>
                                        <input type="hidden" name="final_total"
                                            value="{{ ($sub_total - @session('coupon')['amount'] ?? 0) + $shipping }}">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).on("change", "#selectModalProduct", function() {
        var productId = $(this).val();
        var url = "{{ route('admin.order.get-product-attribute', '') }}" + "/" + productId;

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var productData = data?.data;
                var discountPrice = productData?.discount_price;
                var regularPrice = productData?.regular_price;
                var productAttribute = productData?.product_attribute;
                var productPrice = (discountPrice == null || discountPrice == 0) ? regularPrice :
                    discountPrice;
                $(".modalProductPrice").val(productPrice);


                var result = '<option value="" selected>Select Attributes</option>';
                for (var i = 0; i < productAttribute.length; i++) {
                    var singlevalue = productAttribute[i];
                    result += `<option value="${singlevalue?.id}">${singlevalue?.content}</option>`;
                }


                $(".modalProductAttribute").empty();
                $(".modalProductAttribute").append(result);


            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });

    })



    $(document).on("change", ".modalProductAttribute", function() {
        var productAttributeId = $(this).val();
        var url = "{{ route('admin.order.get-product-attribute-quantity', '') }}" + "/" + productAttributeId;
     
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var quantity = data?.data?.quantity;
                $(".stockQuantityModal").val(quantity ?? 0);

            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        });


    })


    $(document).on("change", ".quantityInputModal", function() {
        var value = $(this).val();
        var stock = $(".stockQuantityModal").val();
        value = Math.min(stock, value);
        $(this).val(value)
    })
</script>

<script>
    $(document).on("click", "#buttonModalStore", function() {
        var order_id = $("#orderIdForModal").val();
        var product_id = $("#selectModalProduct").val();
        var attribute = $(".modalProductAttribute").val();
        var quantity = $(".quantityInputModal").val();
        var productPrice = $(".modalProductPrice").val();
        var totalPrice = productPrice * quantity;
        var url = "{{ route('admin.order.productStore') }}";
        if(quantity !== '0'){
             $.ajax({
            type: 'POST',
            url: url,
            data: {
                order_id,
                product_id,
                attribute,
                quantity,
                productPrice,
                totalPrice,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.status == 1) {
                    toastr.success(data?.message)
                    window.location.reload();
                } else {
                    toastr.error(data?.message)
                }
            }
        });
        }else{
            alert("quantity not to be zero");
        }
       


    });
</script>
@endpush
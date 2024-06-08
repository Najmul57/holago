<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        *{
            box-sizing: border-box;
            font-family: Roboto, sans-serif;
        }

        body {
            font-size: 14px;
            color: #4c5258;
            letter-spacing: .5px;
            font-family: Roboto, sans-serif;
            background-color: #f7f8fa;
            overflow-x: hidden;
        }

        .invoice_image{
            width: 100px;
        }

        .invoice_customer_name p {
            color: #000;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .invoice_main{
            position: relative;
            z-index: 1;
        }

        .select2-area{
            height: 42px !important;
            padding: 5px 15px !important;
        }

        .invoice_ttile strong{
            font-size: 24px;
            color: #7928ca;
        }

        .invoice_customer_name {
            font-size: 18px;
            color: #7928ca;
            font-weight: 500;
            line-height: 22px;
        }

        .invoice_innfo_list {
            margin-bottom: 3px;
            font-size: 14px;
            font-weight: 400;
        }

        .table thead th, .table tbody td {
            padding: 8px 25px;
        }

        .table thead th {
            color: #fff;
            background-color: #7367f0;
        }

        .table-striped>tbody>tr:nth-of-type(odd)>* {
            --bs-table-accent-bg: transform;
            color: var(--bs-table-striped-color);
        }

        .table-striped>tbody>tr:nth-of-type(even)>* {
            --bs-table-accent-bg: var(--bs-table-striped-bg);
            color: var(--bs-table-striped-color);
        }

        .table>:not(caption)>> {
            padding: 8px 25px;
        }

        .invoice_block_title {
            font-size: 16px;
            color: #7928ca;
            font-weight: 500;
        }

        .invoice_block_text {
            color: #63696f;
            font-size: 14px;
        }

        .payment_info_title {
            font-weight: 500;
            min-width: 120px;
            display: inline-block;
            font-size: 14px;
        }

        .invoice_payment {
            background: rgba(0, 0, 0, 0.05);
            max-width: 300px;
            width: 100%;
            padding: 10px;
        }

        .payment_info_list ul li span{
            font-size: 14px;
        }

        .invoice_payment ul li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 10px;
        }

        .invoice_payment ul li:not(:last-child) {
            margin-bottom: 4px;
        }

        .invoice_payment ul li:last-child {
            background: #7367f0;
            color: #fff;
        }

        .btn_text a{
            font-size: 14px;
        }

        .invoice_ttile{
            text-align: right;
        }

    </style>
</head>
<body>
    <div class="card invoice_main">
        <div class="card-body">
            <div class="container" id="containerID">
                <div class= "mb-5 mt-3">
                    <div class="invoice_top mb-5">
                        <div class="row justify-content-between">
                            {{-- <div class="col-sm-6">
                                <div class="invoice_image">
                                    <img class="w-100" src="../assets/images/pharmecylog.png" alt="">
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="invoice_ttile">
                                    <strong class=" fa-4x ms-0">@lang('Holago')</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $jsonData = $order->shipping_address;
                        $data = $jsonData;
                    @endphp
                    <div class="row gy-3 justify-content-between mb-5 align-items-end">
                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li class="invoice_customer_name">@lang('Invoice to'):</li>
                                <li class="invoice_innfo_lis">@lang('Name'): {{ $data['name'] }}</li>
                                <li class="invoice_innfo_list">@lang('Mobile'): {{ $data['mobile'] }}</li>
                                <li class="invoice_innfo_list">@lang('Email:'): {{ $data['email'] }}</li>
                                <li class="invoice_innfo_list">@lang('Address'): {{ $data['address'] }}</li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <div class="text-md-center invoice_ttile invoice_ttile_middle">
                                <strong class=" fa-4x ms-0">@lang('Invoice')</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled text-md-end">
                                <li class=""> <span class="fw-bold me-2 d-inline-block">@lang('ID'):</span>#{{__($order->order_number)}}</li>
                                <li class=""> <span class="fw-bold me-2 d-inline-block">@lang('Creation Date'): </span>{{ \Carbon\Carbon::parse($order->created_at)->format('j F, Y') }}</li>
                                       <li class="text-muted"><span
                                    class="me-1 fw-bold">Payment Status:</span>
                                @if ($order->payment_status == 'Paid')
                                    <span class="badge bg-success text-black fw-bold">@lang('Paid')</span>
                                @elseif($order->payment_status == 'Pending')
                                    <span class="badge bg-warning text-black fw-bold">@lang('Pending')</span>
                                @elseif($order->payment_status == 'Failed')
                                    <span class="badge bg-danger text-black fw-bold">@lang('Failed')</span>
                                @elseif($order->payment_status == 'Canceled')
                                    <span class="badge bg-primary text-black fw-bold">@lang('Canceled')</span>
                                @endif
                            </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row my-5 mx-1 justify-content-center table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead class="text-white">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@lang('Product Name')</th>
                                    <th scope="col">@lang('Product Attribute')</th>
                                    <th scope="col">@lang('Qty')</th>
                                    <th scope="col">@lang('Unit Price')</th>
                                    <th scope="col">@lang('Amount')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $sub_total = 0;
                              @endphp
                              @foreach($order->order_details as $key => $value)
                                  <tr>
                                      <th scope="row">{{ $key+1 }}</th>
                                      <td>{{__($value->product->name)}}</td>
                                      <td>{{__($value->attribute ?? '-')}}</td>
                                      <td>{{__($value->quantity)}}</td>
                                      @if($value->discount_price)
                                          <td>{{ __($setting->currency_symbol)}}{{__(number_format($value->discount_price,2))}}</td>
                                      @else
                                          <td>{{ __($setting->currency_symbol)}}{{__($value->regular_price)}}</td>
                                      @endif

                                      @if($value->discount_price)
                                          <td>{{ __($setting->currency_symbol)}}{{__(number_format($value->discount_price * $value->quantity,2))}}</td>
                                      @else
                                          <td>{{ __($setting->currency_symbol)}}{{__(number_format($value->regular_price * $value->quantity,2))}}</td>
                                      @endif
                                  </tr>
                                  @if($value->discount_price)
                                      @php $sub_total += $value->product->discount_price * $value['quantity'] @endphp
                                  @else
                                      @php $sub_total += $value->product->regular_price * $value['quantity'] @endphp
                                  @endif
                              @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row gy3">
                        <div class="col-md-6">
                            <p class="ms-3 invoice_block_title">Note:</p>
                            <p class="ms-3 invoice_block_text">{{$data['note'] ?? 'N/A'}}</p>
                        </div>

                        <div class="col-md-6">
                            <div class="invoice_payment ms-md-auto">
                                <ul class="list-unstyled text-md-end">
                                    <li class=""><strong class="me-4">@lang('SubTotal')</strong> <span>{{ __($setting->currency_symbol) }}{{__(number_format($sub_total,2))}}</span></li>
                                    <li class=""><strong class="me-4">@lang('Shipping Charge')</strong> <span>{{ __($setting->currency_symbol) }}{{__(number_format($order->shipping_charge,2))}}</span></li>
                                    <li class=""><strong class="me-4">@lang('Special Discount')</strong> <span>{{ __($setting->currency_symbol) }}{{__(number_format($order->special_discount,2))}}</span></li>
                                    <li class=""><strong class="me-4">@lang('Tax')(0%)</strong> <span>{{ __($setting->currency_symbol) }}{{ 0.00}}</span></li>
                                    <li class=""><strong class="">@lang('Total Amount')</strong> <span>{{ __($setting->currency_symbol) }}{{__(number_format($order->total_amount,2))}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
{{--                        <div class="col-12">--}}
{{--                        <p class="ms-3 invoice_block_title">Payment Information</p>--}}
{{--                            <div class="payment_info_list">--}}
{{--                                <ul class="ms-3 list-unstyled">--}}
{{--                                    <li>--}}
{{--                                        <span class="payment_info_title">Account No:</span>--}}
{{--                                        <span>Lorem Jhon</span>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <span class="payment_info_title">A/C Name:</span>--}}
{{--                                        <span>0000000000000000</span>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <span class="payment_info_title">Bank Details:</span>--}}
{{--                                        <span>Lorem ipsum.</span>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    <div class="row my-5">
                        <div class="col-md-6">
                            <p class="invoice_block_title text-black ms-3">Thank you for your purchase</p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <p class="invoice_block_title text-black text-md-end d-inline-block border-top">Signature</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
$(window).on('load', function () {
  let printStyle = document.createElement("style");
  printStyle.innerHTML = `
    @media print {
      #containerID {
        max-width: 100%;
      }
      .table thead th {
            -webkit-print-color-adjust: exact;
        }

        .invoice_ttile {
            text-align: center !important;
        }

        .invoice_payment {
            -webkit-print-color-adjust: exact;
            background: rgba(0, 0, 0, 0.05);
            margin-left: auto;
        }

        .row {
            justify-content: space-between;
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));
        }

        .text-md-end {
            text-align: right !important;
        }

        .text-md-center{
            text-align: center !important;
        }

        .col-md-4 {
            flex: 0 0 auto;
            width: 33.33333333%;
        }

        .col-md-6 {
            flex: 0 0 auto;
            width: 50%;
        }
    }
  `;
  document.head.appendChild(printStyle);
  window.print();
});

window.addEventListener("afterprint", function() {
  btn_wrapper.style.display = "block";
  document.head.removeChild(printStyle);
});

</script>
</body>
</html>

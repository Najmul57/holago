@extends('admin.layouts.master')
@section('content')
@section('title', 'Order Details')
<div class="card">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row d-flex align-items-baseline">
                <div class="col-xl-7">
                    <p style="color: #7e8d9f;font-size: 20px;">@lang('Invoice') >> <strong>ID:
                            {{ __($order->order_number) }}</strong></p>
                </div>
                <div class="col-xl-5 float-end">
                    <a href="{{ route('admin.order.print', $order->id) }}" target="_blank"
                        class="btn btn-light text-capitalize border-0" data-mdb-ripple-color="dark"><i
                            class="la la-print text-primary"></i> Print</a>
                    <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark">
                        <form action="{{ route('admin.order.change_status', $order->id) }}" method="POST">
                            @csrf
                            @method('put')
                            <input type="hidden" name="status" value="6">
                            <button class="btn_background" type="submit">
                                <i class="la la-check text-success"></i>&nbsp;&nbsp; {{ __('on hold') }}
                            </button>
                        </form>
                    </a>
                    @if ($order->status == 5)
                    @else
                        @if ($order->status == 1 || $order->status == 6)
                            <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark">
                                <form action="{{ route('admin.order.change_status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="status" value="2">
                                    <button class="btn_background" type="submit">
                                        <i class="la la-check text-success"></i>&nbsp;&nbsp; {{ __('Confirmed') }}
                                    </button>
                                </form>
                            </a>
                        @elseif($order->status == 2)
                            <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark">
                                <form action="{{ route('admin.order.change_status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="status" value="3">
                                    <button type="submit" class="btn_background">
                                        <i class="la la-check text-info"></i>&nbsp;&nbsp; {{ __('Processing') }}
                                    </button>
                                </form>
                            </a>
                        @elseif($order->status == 3)
                            <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark">
                                <form action="{{ route('admin.order.change_status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="status" value="7">
                                    <button type="submit" class="btn_background">
                                        <i class="la la-check text-primary"></i>&nbsp;&nbsp; {{ __('Shipped') }}
                                    </button>
                                </form>
                            </a>
                        @elseif($order->status == 7)
                            <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark">
                                <form action="{{ route('admin.order.change_status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" name="status" value="5">
                                    <button type="submit" class="btn_background">
                                        <i class="la la-check text-primary"></i>&nbsp;&nbsp; {{ __('Delivered') }}
                                    </button>
                                </form>
                            </a>
                        @endif

                        @if ($order->status == 1 || $order->status == 2 || $order->status == 3)
                            <a class="btn btn-light text-capitalize" data-mdb-ripple-color="dark">
                                <form action="{{ route('admin.order.cancelled_status', $order->id) }}" method="POST">
                                    @csrf
                                    @method('put')
                                    <input type="hidden" value="4" name="cancelled">
                                    <button type="submit" class="btn_background">
                                        <i class="la la-check text-danger"></i>&nbsp;&nbsp; {{ __('Cancelled') }}
                                    </button>
                                </form>
                            </a>
                        @endif
                    @endif
                </div>
                <hr>
            </div>

            <div class="container">
                <div class="col-md-12">
                    <div class="text-center mb-5">
                        <img height="150px" width="200px"
                            src="{{ displayImage($templateAssets.'images/logo/logo.png') }}" title="logo">
                    </div>
                </div>
                @php
                    $jsonData = $order->shipping_address;
                    $data = $jsonData;
                @endphp
                <div class="row">
                    <div class="col-xl-8">
                        <ul class="list-unstyled">
                            <li class="text-muted">To:</li>
                            <li class="text-muted">Name: <span style="color:#5d9fc5;">{{ $data['name'] }}</span></li>
                            <li class="text-muted">Mobile: {{ $data['mobile'] }}</li>
                            <li class="text-muted">Email: {{ $data['email'] }}</li>
                            <!--<li class="text-muted">Division: {{ $data['district_id']}}</li>-->

                             @php
                                $delimiter = ' ';
                                $valueParts = explode($delimiter, $data['shipping_place']);
                                // Remove the first part of the string
                                unset($valueParts[0]);
                                $secondValue = implode($delimiter, $valueParts);
                            @endphp
                            @if (!empty($data['shipping_place']))
                                <li class="text-muted">Location: {{ $secondValue ?? 'N/A' }}</li>
                  @endif
                            <li class="text-muted">Address: {{ $data['address'] }}</li>
                        </ul>
                    </div>
                    <div class="col-xl-4">
                        <p class="text-muted">Invoice</p>
                        <ul class="list-unstyled">
                            <li class="text-muted"><i class="la la-circle" style="color:#84B0CA ;"></i> <span
                                    class="fw-bold">ID:</span>{{ __($order->order_number) }}</li>
                            <li class="text-muted"><i class="la la-circle" style="color:#84B0CA ;"></i> <span
                                    class="fw-bold">Creation Date:
                                </span>{{ \Carbon\Carbon::parse($order->created_at)->format('j F, Y') }}</li>
                            <li class="text-muted"><i class="la la-circle" style="color:#84B0CA ;"></i> <span
                                    class="me-1 fw-bold">Status:</span>
                                @if ($order->status == 1)
                                    <span class="badge bg-warning text-black fw-bold">@lang('Pending')</span>
                                @elseif($order->status == 2)
                                    <span class="badge bg-success text-white fw-bold">@lang('Confirm')</span>
                                @elseif($order->status == 3)
                                    <span class="badge bg-info text-white fw-bold">@lang('Processing')</span>
                                @elseif($order->status == 4)
                                    <span class="badge bg-danger text-white fw-bold">@lang('Cancelled')</span>
                                @elseif($order->status == 5)
                                    <span class="badge bg-primary text-white fw-bold">@lang('Delivered')</span>
                                @elseif($order->status == 6)
                                    <span class="badge bg-danger text-white fw-bold">@lang('on hold')</span>
                                @elseif($order->status == 7)
                                    <span class="badge bg-secondary text-white fw-bold">@lang('shipped')</span>
                                @endif
                            </li>
                            <li class="text-muted"><i class="la la-circle" style="color:white ;"></i> <span
                                    class="me-1 fw-bold">Payment Status:</span>
                                @if ($order->payment_status == 'Paid')
                                    <span class="badge bg-success text-white fw-bold">@lang('Paid')</span>
                                @elseif($order->payment_status == 'Pending')
                                    <span class="badge bg-warning text-white fw-bold">@lang('Pending')</span>
                                @elseif($order->payment_status == 'Failed')
                                    <span class="badge bg-danger text-white fw-bold">@lang('Failed')</span>
                                @elseif($order->payment_status == 'Canceled')
                                    <span class="badge bg-primary text-white fw-bold">@lang('Canceled')</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="row my-2 mx-1 justify-content-center">
                    <table class="table table-striped table-borderless">
                        <thead style="background-color:#84B0CA ;" class="text-white mb-5">
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
                            @foreach ($order->order_details as $key => $value)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ __($value->product->name) }}</td>
                                    <td>{{ __($value->attribute ?? '-') }}</td>
                                    <td>{{ __($value->quantity) }}</td>
                                    @if ($value->discount_price)
                                        <td>{{ __($setting->currency_symbol) }}{{ __(number_format($value->discount_price, 2)) }}
                                        </td>
                                    @else
                                        <td>{{ __($setting->currency_symbol) }}{{ __($value->regular_price) }}</td>
                                    @endif

                                    @if ($value->discount_price)
                                        <td>{{ __($setting->currency_symbol) }}{{ __(number_format($value->discount_price * $value->quantity, 2)) }}
                                        </td>
                                    @else
                                        <td>{{ __($setting->currency_symbol) }}{{ __(number_format($value->regular_price * $value->quantity, 2)) }}
                                        </td>
                                    @endif
                                </tr>
                                @if ($value->discount_price)
                                    @php $sub_total += floatval($value->product->discount_price) * $value['quantity'] @endphp
                                @else
                                    @php $sub_total += floatval($value->product->regular_price) * $value['quantity'] @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-between">
                    <div class="col-xl-8">
                        <p class="ms-3">Add additional notes and payment information</p>
                        <p>{{$data['note'] ?? 'N/A'}}</p>

                    </div>
                    <div class="col-xl-3">
                        <div class="invoice_payment">
                            <ul class="list-unstyled">
                                <li class="text-muted"><span
                                        class="text-black me-4">@lang('SubTotal')</span>{{ __($setting->currency_symbol) }}{{ __(number_format($sub_total, 2)) }}
                                </li>
                                <li class="text-muted"><span
                                        class="text-black me-4">@lang('Shipping Charge')</span>{{ __($setting->currency_symbol) }}{{ __(number_format($order->shipping_charge, 2)) }}
                                </li>
                                <li class="text-muted"><span
                                        class="text-black me-4">@lang('Special Discount')</span>{{ __($setting->currency_symbol) }}{{ __(number_format($order->special_discount, 2)) }}
                                </li>
                                <li class="text-muted"><span
                                    {{-- @dd($order->special_discount); --}}
                                        class="text-black me-4">@lang('Club Discount')</span>{{ __($setting->currency_symbol) }}{{ __(number_format($order->point_discount, 2)) }}
                                </li>
                                <li class="text-muted mt-2"><span
                                        class="text-black me-4">@lang('Tax')(0%)</span>
                                    {{ __($setting->currency_symbol) }}0.00</li>
                                <li class="text-muted"><span class="me-3"> @lang('Total Amount'):</span><span
                                        style="font-size: 16px;">{{ __($setting->currency_symbol) }}{{ __(number_format($order->total_amount, 2)) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-10">
                        <p>@lang('Thank you for your purchase')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('css')
<style>
    .btn_background {
        background: transparent;
    }

    .invoice_payment {
        background: rgba(0, 0, 0, 0.05);
        max-width: 300px;
        width: 100%;
        padding: 10px;
    }

    .invoice_payment ul li:not(:last-child) {
        margin-bottom: 4px;
    }

    .invoice_payment ul li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 10px;
    }

    .invoice_payment ul li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 5px 10px;
    }

    .invoice_payment ul li:last-child {
        background: #7367f0;
        color: #fff !important;
    }
</style>
@endpush
@push('top-area')
<a href="{{ route('admin.order.index') }}" class="btn btn-primary btn-sm mb-2 mt-1"><i
        class="lab la-telegram-plane"></i>@lang('Order List')</a>
@endpush
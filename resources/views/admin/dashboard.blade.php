@extends('admin.layouts.master')
@section('content')
@section('title','Dashboard')

<!--start content-->
<div class="row mt-3">
    <div class="col-md-3 col-lg-6 col-xl-6 col-xxl-3">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">@lang('Total Customer')</p>
                           @php $user = \App\Models\User::all(); @endphp
                        <h4 class="my-1">{{$user->count()}}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="las la-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-6 col-xl-6 col-xxl-3">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">@lang('Total Order')</p>
                        @php $order = \App\Models\Order::all(); @endphp
                        <h4 class="my-1">{{$order->count()}}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-success text-white ms-auto"><i class="lab la-codepen"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-6 col-xl-6 col-xxl-3">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">@lang('Total Pending Order')</p>
                        @php $order_pending = \App\Models\Order::where('status',1)->count(); @endphp
                        <h4 class="my-1">{{$order_pending}}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="las la-luggage-cart"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-6 col-xl-6 col-xxl-3">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">@lang('Total Product')</p>
                        @php $product = \App\Models\Product::where('status',1)->count(); @endphp
                        <h4 class="my-1">{{$product}}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="lab la-accusoft"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-lg-6 col-xl-6 col-xxl-3">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">@lang('Total Today\'s Order Amount')</p>
                        @php $order_amount_today = \App\Models\Order::whereDate('created_at', \Illuminate\Support\Carbon::today())->sum('total_amount');
                         $setting =\App\Models\Setting::first();
                        @endphp
                        <h4 class="my-1">{{$setting->currency_symbol}}{{number_format($order_amount_today,2)}}</h4>
                    </div>
                    <div class="widget-icon-large bg-gradient-danger text-white ms-auto">{{$setting->currency_symbol}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->

<div class="row">
    <div class="col-md-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center pb-3">
                    <div class="col">
                        <h5 class="mb-0">@lang('Latest Order')</h5>
                    </div>
                </div>
                @php
                    $order_list = \App\Models\Order::with('order_details')->where('status',1)->latest()->limit(10)->get();
                @endphp

                <div id="summeryJob">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Order Number</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_list as $key => $data)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$data->order_number}}</td>
                                    <td>{{$setting->currency_symbol}}{{number_format($data->total_amount,2)}}</td>
                                    <td>
                                        @if($data->status == 1)
                                            Pending
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-6 d-flex">
        <div class="card radius-10 w-100">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center pb-3">
                    <div class="col">
                        <h5 class="mb-0">@lang('Latest Customer')</h5>
                    </div>
                </div>
                <div id="summeryJob">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SI</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $customer = \App\Models\User::latest()->limit(10)->get();
                        @endphp
                        @foreach($customer as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$data->name}}</td>
                                <td>{{$data->email?? 'N/A'}}</td>
                                <td>{{$data->phone}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->

@endsection

@push('css')
<style>
    .report-header{
        font-size: 20px;
    }
</style>
@endpush

@push('js')

<script>
    "use strict";

    var chart = new ApexCharts(document.querySelector("#summeryJob"), options);
    chart.render()


    // apex-bar-chart js
    var options = {
        series: [{
            name: 'Total Amount',
            data: [
              @foreach($months as $month)
                {{ @$depositsMonth->where('months',$month)->first()->depositAmount }},
              @endforeach
            ]
        }],
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($months),
        },
        yaxis: {
            title: {
                text: "{{__($setting->site_currency)}}",
                style: {
                    color: '#7c97bb'
                }
            }
        },
        grid: {
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "{{__($setting->site_currency)}}" + val + " "
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    //
    var ctx = document.getElementById('browserChart');
        var myChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: @json($chart['user_browser_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_browser_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                maintainAspectRatio: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });

        var ctx = document.getElementById('countryChart');
        var myChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: @json($chart['user_country_counter']->keys()),
                datasets: [{
                    data: {{ $chart['user_country_counter']->flatten() }},
                    backgroundColor: [
                        '#ff7675',
                        '#6c5ce7',
                        '#ffa62b',
                        '#ffeaa7',
                        '#D980FA',
                        '#fccbcb',
                        '#45aaf2',
                        '#05dfd7',
                        '#FF00F6',
                        '#1e90ff',
                        '#2ed573',
                        '#eccc68',
                        '#ff5200',
                        '#cd84f1',
                        '#7efff5',
                        '#7158e2',
                        '#fff200',
                        '#ff9ff3',
                        '#08ffc8',
                        '#3742fa',
                        '#1089ff',
                        '#70FF61',
                        '#bf9fee',
                        '#574b90'
                    ],
                    borderColor: [
                        'rgba(231, 80, 90, 0.75)'
                    ],
                    borderWidth: 0,

                }]
            },
            options: {
                aspectRatio: 1,
                responsive: true,
                elements: {
                    line: {
                        tension: 0 // disables bezier curves
                    }
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                legend: {
                    display: false,
                }
            }
        });


</script>

@endpush

@push('js-link')
<script src="{{asset('assets/global/js/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/global/js/chart.js.2.8.0.js')}}"></script>

@endpush
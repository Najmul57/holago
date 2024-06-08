@extends('admin.layouts.master')
@section('content')
@section('title','Payments List')

 <div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Company')</th>
                        <th>@lang('Gateway Name')</th>
                        <th>@lang('Trx Number')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ __($payment->company->name) }}</td>
                            <td>{{ __($payment->gatewayName()) }}</td>
                            <td>{{ __($payment->trx_number) }}</td>
                            <td>{{ __($payment->amount) }} {{ $setting->site_currency }}</td>
                            <td>
                                <button class="btn bg-gradient-info btn-sm  icon-btn ml-1 detailsBtn"
                                    data-id="{{ __($payment->id) }}"
                                    data-company="{{ __($payment->company->name) }}"
                                    data-username="{{ __($payment->company->username) }}"
                                    data-gateway_currency="{{ __($payment->gatewayName()) }}"
                                    data-trx_number="{{ __($payment->trx_number) }}"
                                    data-amount="{{ __($payment->amount) }}"
                                    data-charge="{{ __($payment->charge) }}"
                                    data-after_charge="{{ __($payment->after_charge) }}"
                                    data-rate="{{ __($payment->rate) }}"
                                    data-after_convert="{{ __($payment->after_convert) }}"
                                    data-status="{{ __($payment->status) }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailsModal"
                                    data-toggle="tooltip"
                                    data-original-title="@lang('Configure')">
                                    <i class="la la-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">@lang('Data not found')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
    <div class="card-footer">
        {{ $payments->links() }}
    </div>
    @endif
</div>
{{-- DETAILS MODAL --}}
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="detailsModal">@lang('Details Payment'): <span class="username"></span></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 m-b-30">
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <th>@lang('Username')</th>
                              <td class="username"></td>
                            </tr>
                            <tr>
                              <th>@lang('Company Name')</th>
                              <td class="name"></td>
                            </tr>
                            <tr>
                              <th>@lang('Gateway')</th>
                              <td class="gateway"></td>
                            </tr>
                            <tr>
                              <th>@lang('TRX')</th>
                              <td class="trx_number"></td>
                            </tr>
                            <tr>
                              <th>@lang('Amount')</th>
                              <td class="amount"></td>
                            </tr>
                            <tr>
                              <th>@lang('Charge')</th>
                              <td class="charge"></td>
                            </tr>
                            <tr>
                              <th>@lang('After Charge')</th>
                              <td class="after_charge"></td>
                            </tr>
                            <tr>
                              <th>@lang('Conversion Rate')</th>
                              <td class="rate"></td>
                            </tr>
                            <tr>
                              <th>@lang('After Convert')</th>
                              <td class="after_convert"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script>
        (function($){
            "use strict";
            $('.detailsBtn').on('click',function(){
                var editModal = $('#detailsModal');
                var currency = "{{ $setting->site_currency }}";
                
                editModal.find('.name').text($(this).data('company'));
                editModal.find('.username').text($(this).data('username'));
                editModal.find('.gateway').text($(this).data('gateway_currency'));
                editModal.find('.trx_number').text($(this).data('trx_number'));

                editModal.find('.amount').text($(this).data('amount') + ' ' + currency);
                editModal.find('.charge').text($(this).data('charge') + ' ' + currency);
                editModal.find('.after_charge').text($(this).data('after_charge') + ' ' + currency);
                editModal.find('.rate').text($(this).data('rate') + ' ' + currency);
                editModal.find('.after_convert').text($(this).data('after_convert') + ' ' + currency);
                editModal.find('.status').text($(this).data('status'));
            });

        })(jQuery);
    </script>
@endpush

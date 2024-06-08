@extends('admin.layouts.master')
@section('content')
@section('title','Payment Gateways')
	
<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Gateway</th>
                        <th>Supported Currency</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gateways as $gateway)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="product-box border">
                                    <img src="{{ displayImage('assets/images/paymentGateway/'.$gateway->image) }}" alt="">
                                </div>
                                <div class="product-info">
                                    <span class="product-name mb-1">{{ __($gateway->name) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{__($gateway->currencies->count())}}</td>
                        <td>
                            @if($gateway->status == 1)
                                <span class="badge badge-pill bg-gradient-success">@lang('Active')</span>
                            @else
                                <span class="badge badge-pill bg-gradient-danger">@lang('Disabled')</span>
                            @endif
                        </td>
                        <td>
                            <div class="align-items-center gap-3 fs-6">
                                <a href="{{ route('admin.gateway.method.edit',$gateway->id)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1" title="Edit"><i class="las la-edit"></i></a>
                                @if($gateway->status == 0)
                                    <button data-bs-toggle="modal" data-bs-target="#activateModal" class="btn bg-gradient-success btn-sm ml-1 activateBtn" data-act="{{$gateway->act}}" data-name="{{__($gateway->name)}}" data-original-title="@lang('Enable')">
                                        <i class="la la-eye"></i>
                                    </button>
                                @else
                                    <button data-bs-toggle="modal" data-bs-target="#deactivateModal" class="btn bg-gradient-danger btn-sm ml-1 deactivateBtn" data-act="{{$gateway->act}}" data-name="{{__($gateway->name)}}" data-original-title="@lang('Disable')">
                                        <i class="la la-eye-slash"></i>
                                    </button>
                                @endif
                            </div>
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
</div>

{{-- ACTIVATE METHOD MODAL --}}
<div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Payment Method Activation Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.gateway.method.activate')}}" method="POST">
                @csrf
                <input type="hidden" name="act">
                <div class="modal-body">
                    <p>@lang('Are you sure to activate') <span class="font-weight-bold method-name"></span> @lang('method')?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>

                    <button type="submit" class="btn btn-primary">@lang('Activate')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- DEACTIVATE METHOD MODAL --}}
<div id="deactivateModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Payment Method Disable Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.gateway.method.deactivate')}}" method="POST">
                @csrf
                <input type="hidden" name="act">
                <div class="modal-body">
                    <p>@lang('Are you sure to disable') <span class="font-weight-bold method-name"></span> @lang('method')?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-danger">@lang('Disable')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script>
        (function ($) {
            "use strict"
            $(document).on('click','.activateBtn',function () {
                var modal = $('#activateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=act]').val($(this).data('act'));
            });

            $(document).on('click','.deactivateBtn',function () {
                var modal = $('#deactivateModal');
                modal.find('.method-name').text($(this).data('name'));
                modal.find('input[name=act]').val($(this).data('act'));
            });
        })(jQuery);
    </script>
@endpush
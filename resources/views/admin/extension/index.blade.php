@extends('admin.layouts.master')
@section('content')
@section('title','Extensions')
 <div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Extension')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($extensions as $extension)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <div class="product-box border">
                                    <img src="{{ displayImage('assets/admin/images/extensions/'.@$extension->image) }}" alt="">
                                </div>
                                <div class="product-info">
                                    <span class="product-name mb-1">{{ __($extension->name) }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                             @if($extension->status == 1)
                            <span class="badge badge-pill bg-gradient-success">@lang('Active')</span>
                            @elseif($extension->status == 0)
                                <span class="badge badge-pill bg-gradient-danger">@lang('Disabled')</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn bg-gradient-info btn-sm icon-btn ml-1 editBtn" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ __($extension->id) }}"
                                    data-name="{{ __($extension->name) }}"
                                    data-site_key="{{ __(@$extension->shortcode->site_key) }}"
                                    data-secret_key="{{ __(@$extension->shortcode->secret_key) }}"
                                    data-action="{{ route('admin.setting.extensions.update', $extension->id) }}"
                                    data-toggle="tooltip"
                                    data-original-title="@lang('Configure')"> 
                                <i class="la la-cogs"></i>
                            </button>
                            <button class="btn bg-gradient-royal btn-sm icon-btn ml-1 helpBtn" data-bs-toggle="modal" data-bs-target="#helpModal"
                                    data-description="{{ __($extension->description) }}"
                                    data-support="{{ __($extension->support) }}"
                                    data-image="{{ displayImage('assets/admin/images/extension/'.$extension->image) }}"
                                    data-toggle="tooltip"
                                    data-original-title="@lang('Help')">
                                <i class="la la-question"></i>
                            </button>
                            @if($extension->status == 0)
                                <button class="btn bg-gradient-success btn-sm icon-btn ml-1 activateBtn" data-bs-toggle="modal" data-bs-target="#activateModal"
                                        data-id="{{ $extension->id }}" 
                                        data-name="{{ __($extension->name) }}"
                                        data-original-title="@lang('Enable')">
                                    <i class="la la-eye"></i>
                                </button>
                            @else
                                <button class="btn bg-gradient-danger btn-sm icon-btn ml-1 deactivateBtn" data-bs-toggle="modal" data-bs-target="#deactivateModal"
                                        data-id="{{ $extension->id }}"
                                        data-name="{{ __($extension->name) }}"
                                        data-original-title="@lang('Disable')">
                                    <i class="la la-eye-slash"></i>
                                </button>
                            @endif
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
    {{-- EDIT METHOD MODAL --}}
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Extension'): <span class="extension-name"></span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-12 control-label font-weight-bold">@lang('Site Key') <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                                <input type="text" name="site_key" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="col-md-12 control-label font-weight-bold">@lang('Secret Key') <span class="text-danger">*</span></label>
                            <div class="col-md-12">
                               <input type="text" name="secret_key" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary" id="editBtn">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- ACTIVATE METHOD MODAL --}}
    <div id="activateModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Extension Activation Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.setting.extensions.activate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to activate') <span class="font-weight-bold extension-name"></span> @lang('extension')?</p>
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
                    <h5 class="modal-title">@lang('Extension Disable Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.setting.extensions.deactivate') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to disable') <span class="font-weight-bold extension-name"></span> @lang('extension')?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-danger">@lang('Disable')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- HELP METHOD MODAL --}}
    <div id="helpModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Need Help')?</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   
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
    (function ($) {
        "use strict";

        $('.activateBtn').on('click', function () {
            var modal = $('#activateModal');
            modal.find('.extension-name').text($(this).data('name'));
            modal.find('input[name=id]').val($(this).data('id'));
        });

        $('.deactivateBtn').on('click', function () {
            var modal = $('#deactivateModal');
            modal.find('.extension-name').text($(this).data('name'));
            modal.find('input[name=id]').val($(this).data('id'));
        });

        $('.editBtn').on('click', function () {
            var modal = $('#editModal');
            modal.find('.extension-name').text($(this).data('name'));
            modal.find('input[name=site_key]').val($(this).data('site_key'));
            modal.find('input[name=secret_key]').val($(this).data('secret_key'));
            modal.find('form').attr('action',$(this).data('action'));

            modal.modal('show');
        });

        $('.helpBtn').on('click', function () {
            var modal = $('#helpModal');
            var path = "{{asset('assets/admin/images/extensions/') }}";
            modal.find('.modal-body').html(`<div class="mb-2">${$(this).data('description')}</div>`);
            if ($(this).data('support') != 'na') {
                modal.find('.modal-body').append(`<img src="${path}/${$(this).data('support')}">`);
            }
            modal.modal('show');
        });

    })(jQuery);

</script>
@endpush
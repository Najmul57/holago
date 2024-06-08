@extends('admin.layouts.master')
@section('content')
@section('title','Coupon')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('name')</th>
						<th scope='col'>@lang('code')</th>
						<th scope='col'>@lang('discount_type')</th>
						<th scope='col'>@lang('coupon_amount')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>
							
				<tbody>
					@forelse($coupons as $key => $coupon)
						<tr>
							<td scope='col'>{{ ++$key }}</td>
							<td scope='col'>{{__($coupon->name)}}</td>
						<td scope='col'>{{__($coupon->code)}}</td>
						<td scope='col'>{{__($coupon->discount_type)}}</td>
						<td scope='col'>{{__($coupon->coupon_amount)}}</td>
						<td scope='col'>
							@if($coupon->status == 1)
								<span class='badge badge-pill bg-gradient-success'>@lang('Enabled')</span>
							 @else
								<span class='badge badge-pill bg-gradient-danger'>@lang('Disable')</span>
							@endif
						</td>
						<td scope='col'>
							<div class="align-items-center gap-3 fs-6">
								<button class="btn bg-gradient-info btn-sm icon-btn ml-1 editBtn"
										data-bs-toggle="modal"
										data-bs-target="#editModal"
										data-id="{{ __($coupon->id)}}"
										data-action="{{ route('admin.coupon.update',$coupon->id) }}"
										data-name="{{ __($coupon->name)}}"
										data-code="{{ __($coupon->code)}}"
										data-discount_type="{{ __($coupon->discount_type)}}"
										data-coupon_amount="{{ __($coupon->coupon_amount)}}">
										<i class="la la-pencil"></i>
									</button>
							@if($coupon->status == 1)
								<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
									data-bs-toggle="modal"
									data-bs-target="#disableModal"
									data-id="{{ __($coupon->id)}}"
									>
									<i class="la la-eye-slash"></i>
								</button>
								@else
								<button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
									data-bs-toggle="modal"
									data-bs-target="#enableModal"
									data-id="{{ __($coupon->id)}}"
									>
									<i class="la la-eye"></i>
								</button>
								@endif
							</div>
						</td>
					</tr>
					@empty
						<tr>
							<td class='text-muted text-center' colspan='100%'>@lang('Data Not Found')</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@if($coupons->hasPages())
	<div class='card-footer'>
		{{ $coupons->links() }}
	</div>
@endif


{{-- NEW MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">"
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="createModalLabel"> @lang('Add New')</h4>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class='col-md-12'>
							<div class='form-row form-group mt-3'>
								<label for="customer01" class='font-weight-bold form-label'>@lang('Coupon Name')<span class='text-danger'>*</span></label>
								<input type="text" class="form-control" name="name" id="name" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="product01" class='font-weight-bold form-label'>@lang('Code')<span class='text-danger'>*</span></label>
								<input type="text" class="form-control" name="code" id="Code" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="session_id01" class='font-weight-bold form-label'>@lang('Discount Type')</label>
								<div class="col-md-12">
									<select class="form-control" id="discount_type" name="discount_type">
                                        <option selected value="">@lang('Select One')</option>
                                        <option value="1">@lang('Fixed')</option>
                                        <option value="2">@lang('Percentage')</option>
                                    </select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<div class="input-group">
                                    <input type="number" class="form-control numeric-validation" id="amount" name="amount">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">{{ $setting->site_currency }}</span>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-dark' data-bs-dismiss='modal'>@lang('Close')</button>
					<button type='submit' class='btn btn-primary' id='btn-save' value='add'>@lang('Save')</button>
				</div>
			</form>
		</div>
	</div>
</div>


{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">"
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="editModalLabel"> @lang('Add New')</h4>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class='col-md-12'>
							<div class='form-row form-group mt-3'>
								<label for="customer01" class='font-weight-bold form-label'>@lang('Coupon Name')<span class='text-danger'>*</span></label>
								<input type="text" class="form-control" name="name" id="name" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="product01" class='font-weight-bold form-label'>@lang('Code')<span class='text-danger'>*</span></label>
								<input type="text" class="form-control" name="code" id="Code" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="session_id01" class='font-weight-bold form-label'>@lang('Discount Type')</label>
								<div class="col-md-12">
									<select class="form-control" id="discount_type_edit" name="discount_type">
                                        <option selected value="">@lang('Select One')</option>
                                        <option value="1">@lang('Fixed')</option>
                                        <option value="2">@lang('Percentage')</option>
                                    </select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<div class="input-group">
                                    <input type="number" class="form-control numeric-validation" id="amount" name="amount">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">@if(old('discount_type') == 1){{ $setting->site_currency }}@else % @endif</span>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-dark' data-bs-dismiss='modal'>@lang('Close')</button>
					<button type='submit' class='btn btn-primary' id='btn-save' value='add'>@lang('Save')</button>
				</div>
			</form>
		</div>
	</div>
</div>



{{-- Enable --}}
<div id="enableModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">@lang('Coupon Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.coupon.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this coupon?')</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
					<button type="submit" class="btn btn-primary">@lang('Yes')</button>
				</div>
			</form>
		</div>
	</div>
</div>

{{-- Disable --}}
<div id="disableModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">@lang('Coupon Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.coupon.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this coupon?')</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
					<button type="submit" class="btn btn-primary">@lang('Yes')</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
@push('top-area')
	<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'><i class='lab la-telegram-plane'></i> @lang('Add Compare')</button>
@endpush
@push('js')
	<script>
		(function($){
			"use strict";

			$('.editBtn').on('click',function(){
				var editModal = $('#editModal');			
				editModal.find('input[name=name]').val($(this).data('name'));
				editModal.find('input[name=code]').val($(this).data('code'));
				editModal.find('input[name=amount]').val($(this).data('coupon_amount'));
				editModal.find('select[name=discount_type]').val($(this).data('discount_type'));
				editModal.find('form').attr('action',$(this).data('action'));
			});

			$('.enableBtn').on('click', function () {
				var modal = $('#enableModal');
				modal.find('input[name=id]').val($(this).data('id'));
			});
			$('.disableBtn').on('click', function () {
				var modal = $('#disableModal');
				modal.find('input[name=id]').val($(this).data('id'));
			});

			$('#discount_type').on('change', function () {
                var val = this.value;
                if(val == 1) {
                    $('#basic-addon2').text(`{{ $setting->site_currency }}`);
                }else{
                    $('#basic-addon2').text(`%`);
                }
            });

            updateAddonValue($('#discount_type_edit').val());

		    $('#discount_type_edit').on('change', function () {
		        var val = this.value;
		        updateAddonValue(val);
		    });

		    function updateAddonValue(val) {
		        var addonText;
		        if (val == 1) {
		            addonText = "{{ $setting->site_currency }}";
		        } else {
		            addonText = "%";
		        }
		        $('#basic-addon2').text(addonText);
		    }
				})(jQuery);
	</script>
@endpush
@extends('admin.layouts.master')
@section('content')
@section('title','Coupon_category')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('Customer')</th>
						<th scope='col'>@lang('Coupon')</th>
						<th scope='col'>@lang('Order')</th>
						<th scope='col'>@lang('amount')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>
							
				<tbody>
					@forelse($coupon_categories as $key => $coupon_category)
						<tr>
							<td scope='col'>{{ ++$key }}</td>
								<td scope='col'>{{__($coupon_category->customer->first_name)}}</td>
							<td scope='col'>{{__($coupon_category->coupon->name)}}</td>
							<td scope='col'>{{__($coupon_category->order->order_number)}}</td>
						<td scope='col'>{{__($coupon_category->amount)}}</td>
						<td scope='col'>
								@if($coupon_category->status == 1)
									<span class='badge badge-pill bg-gradient-success'>@lang('Enabled')</span>
								 @else
									<span class='badge badge-pill bg-gradient-danger'>@lang('Disable')</span>
								@endif
							</td>
							<td>
								<div class="align-items-center gap-3 fs-6">
									<button class="btn bg-gradient-info btn-sm icon-btn ml-1 editBtn"
										data-bs-toggle="modal"
										data-bs-target="#editModal"
										data-id="{{ __($coupon_category->id)}}"
										data-action="{{ route('admin.coupon_category.update',$coupon_category->id) }}"
										data-customer="{{ __($coupon_category->customer_id)}}"
										data-coupon="{{ __($coupon_category->coupon_id)}}"
										data-order="{{ __($coupon_category->order_id)}}"
										data-amount="{{ __($coupon_category->amount)}}">
										<i class="la la-pencil"></i>
									</button>
									@if($coupon_category->status == 1)
									<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
										data-bs-toggle="modal"
										data-bs-target="#disableModal"
										data-id="{{ __($coupon_category->id)}}"
										>
										<i class="la la-eye-slash"></i>
									</button>
									@else
									<button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
										data-bs-toggle="modal"
										data-bs-target="#enableModal"
										data-id="{{ __($coupon_category->id)}}"
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
@if($coupon_categories->hasPages())
	<div class='card-footer'>
		{{ $coupon_categories->links() }}
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
								<label for="customer01" class='font-weight-bold form-label'>@lang('Customer')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="customer" id="customer01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($customers as $customer)
												<option value="{{ $customer->id }}">{{__($customer->first_name) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="coupon01" class='font-weight-bold form-label'>@lang('Coupon')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="coupon" id="coupon01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($coupons as $coupon)
												<option value="{{ $coupon->id }}">{{__($coupon->name) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="order01" class='font-weight-bold form-label'>@lang('Order')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="order" id="order01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($orders as $order)
												<option value="{{ $order->id }}">{{__($order->order_number) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="amount01" class='font-weight-bold form-label'>@lang('Amount')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="amount" id="amount01" required>
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
								<label for="customer01" class='font-weight-bold form-label'>@lang('Customer')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="customer" id="customer01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($customers as $customer)
												<option value="{{ $customer->id }}">{{__($customer->first_name) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="coupon01" class='font-weight-bold form-label'>@lang('Coupon')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="coupon" id="coupon01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($coupons as $coupon)
												<option value="{{ $coupon->id }}">{{__($coupon->name) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="order01" class='font-weight-bold form-label'>@lang('Order')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="order" id="order01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($orders as $order)
												<option value="{{ $order->id }}">{{__($order->order_number) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="amount01" class='font-weight-bold form-label'>@lang('Amount')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="amount" id="amount01" required>
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
				<h5 class="modal-title">@lang('Coupon_category Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.coupon_category.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this coupon_category?')</p>
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
				<h5 class="modal-title">@lang('Coupon_category Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.coupon_category.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this coupon_category?')</p>
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
	<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'><i class='lab la-telegram-plane'></i> @lang('Add Coupon_category')</button>
@endpush
@push('js')
	<script>
		(function($){
			"use strict";
			
			$('.editBtn').on('click',function(){
				var editModal = $('#editModal');			
				editModal.find('select[name=customer]').val($(this).data('customer'));
				editModal.find('select[name=coupon]').val($(this).data('coupon'));
				editModal.find('select[name=order]').val($(this).data('order'));
				editModal.find('input[name=amount]').val($(this).data('amount'));
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
		})(jQuery);
	</script>
@endpush
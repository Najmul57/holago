@extends('admin.layouts.master')
@section('content')
@section('title','Cart')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('Customer')</th>
						<th scope='col'>@lang('Product')</th>
						<th scope='col'>@lang('session_id')</th>
						<th scope='col'>@lang('attributes')</th>
						<th scope='col'>@lang('quantity')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>
							
				<tbody>
					@forelse($carts as $key => $cart)
						<tr>
							<td scope='col'>{{ ++$key }}</td>
								<td scope='col'>{{__($cart->customer->first_name)}}</td>
							<td scope='col'>{{__($cart->product->name)}}</td>
						<td scope='col'>{{__($cart->session_id)}}</td>
						<td scope='col'>{{__($cart->attributes)}}</td>
						<td scope='col'>{{__($cart->quantity)}}</td>
						<td scope='col'>
								@if($cart->status == 1)
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
										data-id="{{ __($cart->id)}}"
										data-action="{{ route('admin.cart.update',$cart->id) }}"
										data-customer="{{ __($cart->customer_id)}}"
										data-product="{{ __($cart->product_id)}}"
										data-session_id="{{ __($cart->session_id)}}"
										data-attributes="{{ __($cart->attributes)}}"
										data-quantity="{{ __($cart->quantity)}}">
										<i class="la la-pencil"></i>
									</button>
									@if($cart->status == 1)
									<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
										data-bs-toggle="modal"
										data-bs-target="#disableModal"
										data-id="{{ __($cart->id)}}"
										>
										<i class="la la-eye-slash"></i>
									</button>
									@else
									<button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
										data-bs-toggle="modal"
										data-bs-target="#enableModal"
										data-id="{{ __($cart->id)}}"
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
@if($carts->hasPages())
	<div class='card-footer'>
		{{ $carts->links() }}
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
								<label for="product01" class='font-weight-bold form-label'>@lang('Product')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="product" id="product01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($products as $product)
												<option value="{{ $product->id }}">{{__($product->name) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="session_id01" class='font-weight-bold form-label'>@lang('Session_id')</label>
								<input type="text" class="form-control" name="session_id" id="session_id01" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="attributes01" class='font-weight-bold form-label'>@lang('Attributes')</label>
								<input type="text" class="form-control" name="attributes" id="attributes01" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="quantity01" class='font-weight-bold form-label'>@lang('Quantity')</label>
								<input type="text" class="form-control" name="quantity" id="quantity01" >
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
								<label for="product01" class='font-weight-bold form-label'>@lang('Product')<span class='text-danger'>*</span></label>
								<div class='col-md-12'>
									<select class="form-control " name="product" id="product01" required>
										<option selected value="">@lang('Select One')</option>
											@foreach($products as $product)
												<option value="{{ $product->id }}">{{__($product->name) }}</option>
											@endforeach
									</select>
								</div>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="session_id01" class='font-weight-bold form-label'>@lang('Session_id')</label>
								<input type="text" class="form-control" name="session_id" id="session_id01" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="attributes01" class='font-weight-bold form-label'>@lang('Attributes')</label>
								<input type="text" class="form-control" name="attributes" id="attributes01" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="quantity01" class='font-weight-bold form-label'>@lang('Quantity')</label>
								<input type="text" class="form-control" name="quantity" id="quantity01" >
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
				<h5 class="modal-title">@lang('Cart Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.cart.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this cart?')</p>
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
				<h5 class="modal-title">@lang('Cart Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.cart.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this cart?')</p>
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
	<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'><i class='lab la-telegram-plane'></i> @lang('Add Cart')</button>
@endpush
@push('js')
	<script>
		(function($){
			"use strict";
			
			$('.editBtn').on('click',function(){
				var editModal = $('#editModal');			
				editModal.find('select[name=customer]').val($(this).data('customer'));
				editModal.find('select[name=product]').val($(this).data('product'));
				editModal.find('input[name=session_id]').val($(this).data('session_id'));
			
				editModal.find('input[name=attributes]').val($(this).data('attributes'));
			
				editModal.find('input[name=quantity]').val($(this).data('quantity'));
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
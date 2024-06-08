@extends('admin.layouts.master')
@section('content')
@section('title','Order')
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class='card shadow-sm border-0'>
			<div class='card-body'>
				<form action="{{ route('admin.order.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Order Section')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class='form-row form-group mt-3'>
										<label for="order_number01" class='font-weight-bold form-label'>@lang('Order_number')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="order_number" id="order_number01" required>
									</div>
									<div class='form-group mb-3'>
										<label for="customer01" class='form-label'>@lang('Customer')</label>
										<select class="form-control " name="customer" id="customer01" required>
											<option selected value="">@lang('Select One')</option>
											@foreach($customers as $customer)
												<option value="{{ $customer->id }}">{{__($customer->first_name) }}</option>
											@endforeach
										</select>
									</div>
									<div class='form-group mb-3'>
										<label for="shipping01" class='form-label'>@lang('Shipping')</label>
										<select class="form-control " name="shipping" id="shipping01" required>
											<option selected value="">@lang('Select One')</option>
											@foreach($shippings as $shipping)
												<option value="{{ $shipping->id }}">{{__($shipping->name) }}</option>
											@endforeach
										</select>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="shipping_address01" class='font-weight-bold form-label'>@lang('Shipping_address')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="shipping_address" id="shipping_address01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="shipping_charge01" class='font-weight-bold form-label'>@lang('Shipping_charge')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="shipping_charge" id="shipping_charge01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="total_amount01" class='font-weight-bold form-label'>@lang('Total_amount')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="total_amount" id="total_amount01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="coupon_code01" class='font-weight-bold form-label'>@lang('Coupon_code')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="coupon_code" id="coupon_code01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="coupon_amount01" class='font-weight-bold form-label'>@lang('Coupon_amount')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="coupon_amount" id="coupon_amount01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="order_type01" class='font-weight-bold form-label'>@lang('Order_type')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="order_type" id="order_type01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="payment_status01" class='font-weight-bold form-label'>@lang('Payment_status')</label>
										<input type="text" class="form-control" name="payment_status" id="payment_status01" >
									</div>
					
								</div>
							</div>
						</div>
					</div>
					<div class="text-end">
						<button type="submit" class="btn btn-primary px-4">@lang('Save')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@extends('admin.layouts.master')
@section('content')
@section('title','Coupon')
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class='card shadow-sm border-0'>
			<div class='card-body'>
				<form action="{{ route('admin.coupon.update', $coupon->id) }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Coupon Section')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class='form-row form-group mt-3'>
										<label for="name01" class='font-weight-bold form-label'>@lang('Name')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="name" value="{{__($coupon->name)}}" id="name01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="code01" class='font-weight-bold form-label'>@lang('Code')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="code" value="{{__($coupon->code)}}" id="code01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="discount_type01" class='font-weight-bold form-label'>@lang('Discount_type')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="discount_type" value="{{__($coupon->discount_type)}}" id="discount_type01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="coupon_amount01" class='font-weight-bold form-label'>@lang('Coupon_amount')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="coupon_amount" value="{{__($coupon->coupon_amount)}}" id="coupon_amount01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="mini_spend01" class='font-weight-bold form-label'>@lang('Mini_spend')</label>
										<input type="text" class="form-control" name="mini_spend" value="{{__($coupon->mini_spend)}}" id="mini_spend01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="max_spend01" class='font-weight-bold form-label'>@lang('Max_spend')</label>
										<input type="text" class="form-control" name="max_spend" value="{{__($coupon->max_spend)}}" id="max_spend01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="customers_limit_per_coupon01" class='font-weight-bold form-label'>@lang('Customers_limit_per_coupon')</label>
										<input type="text" class="form-control" name="customers_limit_per_coupon" value="{{__($coupon->customers_limit_per_coupon)}}" id="customers_limit_per_coupon01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="customers_limit_per_customer01" class='font-weight-bold form-label'>@lang('Customers_limit_per_customer')</label>
										<input type="text" class="form-control" name="customers_limit_per_customer" value="{{__($coupon->customers_limit_per_customer)}}" id="customers_limit_per_customer01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="start_date01" class='font-weight-bold form-label'>@lang('Start_date')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="start_date" value="{{__($coupon->start_date)}}" id="start_date01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="end_date01" class='font-weight-bold form-label'>@lang('End_date')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="end_date" value="{{__($coupon->end_date)}}" id="end_date01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="description01" class='font-weight-bold form-label'>@lang('Description')</label>
										<textarea class="form-control summerNote" rows="5" name="description">{{ __($coupon->description) }}</textarea>
									</div>
					
								</div>
							</div>
						</div>
					</div>
					<div class="text-end">
						<button type="submit" class="btn btn-primary px-4">@lang('Update')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@extends('admin.layouts.master')
@section('content')
@section('title','Coupon_category')
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class='card shadow-sm border-0'>
			<div class='card-body'>
				<form action="{{ route('admin.coupon_category.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Coupon Product Section')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class='form-group mb-3'>
										<label for="coupon01" class='form-label'>@lang('Coupon')</label>
										<select class="form-control " name="coupon" id="coupon01" required>
											<option selected value="">@lang('Select One')</option>
											@foreach($coupons as $coupon)
												<option value="{{ $coupon->id }}">{{__($coupon->name) }}</option>
											@endforeach
										</select>
									</div>
									<div class='form-group mb-3'>
										<label for="product01" class='form-label'>@lang('Product')</label>
										<select class="form-control " name="product" id="product01" required>
											<option selected value="">@lang('Select One')</option>
											@foreach($products as $product)
												<option value="{{ $product->id }}">{{__($product->name) }}</option>
											@endforeach
										</select>
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
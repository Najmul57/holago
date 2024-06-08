@extends('admin.layouts.master')
@section('content')
@section('title','Order_details')
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class='card shadow-sm border-0'>
			<div class='card-body'>
				<form action="{{ route('admin.order_details.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Order Details Section')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class='form-group mb-3'>
										<label for="order01" class='form-label'>@lang('Order')</label>
										<select class="form-control " name="order" id="order01" required>
											<option selected value="">@lang('Select One')</option>
											@foreach($orders as $order)
												<option value="{{ $order->id }}">{{__($order->order_number) }}</option>
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
									<div class='form-row form-group mt-3'>
										<label for="buying_price01" class='font-weight-bold form-label'>@lang('Buying_price')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="buying_price" id="buying_price01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="regular_price01" class='font-weight-bold form-label'>@lang('Regular_price')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="regular_price" id="regular_price01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="wholesale_price01" class='font-weight-bold form-label'>@lang('Wholesale_price')</label>
										<input type="text" class="form-control" name="wholesale_price" id="wholesale_price01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="wholesale_minimum_quantity01" class='font-weight-bold form-label'>@lang('Wholesale_minimum_quantity')</label>
										<input type="text" class="form-control" name="wholesale_minimum_quantity" id="wholesale_minimum_quantity01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="total_price01" class='font-weight-bold form-label'>@lang('Total_price')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="total_price" id="total_price01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="details01" class='font-weight-bold form-label'>@lang('Details')</label>
										<input type="text" class="form-control" name="details" id="details01" >
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
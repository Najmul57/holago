@extends('admin.layouts.master')
@section('content')
@section('title',$title)

<div class="row mt-3">
	<div class="col-12 col-lg-12">
		<div class="card shadow-sm border-0">
			<div class="card-body">
	  			<form action="" method="post" enctype="multipart/form-data">
	  				@csrf
	  				<div class="card shadow-none border">
	    				<div class="card-body">
	      					<div class="row g-3">
	        					<div class="col-md-9">
	        						<div class="row">
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Gateway Name') <small class="text-danger">*</small></label>
			            						<input type="text" class="form-control" value="{{__($gateway_currency->paymentGateway->name)}}" readonly>
			          						</div>
	        							</div>
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Gateway Currency Name') <small class="text-danger">*</small></label>
			            						<input type="text" class="form-control" value="{{__($gateway_currency->currency_name)}}" readonly>
			          						</div>
	        							</div>
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Gateway Currency') <small class="text-danger">*</small></label>
			            						<input type="text" class="form-control" value="{{__($gateway_currency->currency)}}" readonly>
			          						</div>
	        							</div>
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Minimum Limit') <small class="text-danger">*</small></label>
			            						<div class="input-group">
			            							<input type="text" name="minimum" class="form-control" value="{{ numberFormat($gateway_currency->minimum)}}" placeholder="@lang('Minimum Limit')">
			            							<div class="input-group-append">
														<span class="input-group-text">{{__($setting->site_currency) }}</span>
													</div>
			            						</div>
			          						</div>
	        							</div>
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Maximum Limit') <small class="text-danger">*</small></label>
			            						<div class="input-group">
			            							<input type="text" name="maximum" class="form-control" value="{{ numberFormat($gateway_currency->maximum)}}" placeholder="@lang('Maximum Limit')">
			            							<div class="input-group-append">
														<span class="input-group-text">{{__($setting->site_currency) }}</span>
													</div>
			            						</div>
			          						</div>
	        							</div>
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Fixed Charge') <small class="text-danger">*</small></label>
			            						<div class="input-group">
			            							<input type="text" name="fixed_charge" class="form-control" value="{{ numberFormat($gateway_currency->fixed_charge)}}" placeholder="@lang('Fixed Charge')">
			            							<div class="input-group-append">
														<span class="input-group-text">{{__($setting->site_currency) }}</span>
													</div>
			            						</div>
			          						</div>
	        							</div>
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Percent Charge') <small class="text-danger">*</small></label>
			            						<div class="input-group">
			            							<input type="text" name="percent_charge" class="form-control" value="{{ numberFormat($gateway_currency->percent_charge)}}" placeholder="@lang('Percent Charge')">
			            							<div class="input-group-append">
														<span class="input-group-text">%</span>
													</div>
			            						</div>
			          						</div>
	        							</div>
	        							<div class="col-6">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Conversion Rate') <small class="text-danger">*</small> <small class="color-primary">( @lang('1') {{__($gateway_currency->currency)}} = ? {{__($setting->site_currency) }} )</small></label>
			            						<div class="input-group">
			            							<input type="text" name="conversion_rate" class="form-control" value="{{ numberFormat($gateway_currency->conversion_rate)}}" placeholder="@lang('Conversion Rate')">
			            							<div class="input-group-append">
														<span class="input-group-text">{{__($setting->site_currency) }}</span>
													</div>
			            						</div>
			          						</div>
	        							</div>
	        							@if($gateway_currency->is_manual)
	        							<div class="col-12">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Instruction')</label>
			            						<textarea class="summerNote" name="instruction">@php echo $gateway_currency->instruction @endphp</textarea>
			          						</div>
	        							</div>
	        							@endif
	        							<div class="col-12">
	        								<div class="form-group mb-3">
			            						<label class="form-label fw-bold">@lang('Status') <small class="text-danger">*</small></label>
			            						<div class="">
													<input type="checkbox" name="status" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Enable" data-off="Disabled" data-size="normal" @if($gateway_currency->enable_status) checked @endif>
												</div>
			          						</div>
	        							</div>
	        						</div>
	        					</div>
				                <div class="col-md-3">
				                  	<div class="form-group mt-4">
				                    	<div class="image-upload-area">
				                      		<img id="preview" src="{{ displayImage('assets/images/paymentGateway/gatewayCurrency/'.$gateway_currency->image) }}" alt="ggg"/>
				                      		<div class="custom-file">
				                        		<input type="file" name="image" class="custom-file-input upload-image" id="upload">
				                    			<label class="pick-image" for="upload">@lang('Upload Image')</label>
				                      		</div>
				                		</div>
				                  	</div>
				                </div>
	      					</div>
	    				</div>
	  				</div>
		          	<div class="text-end">
		            	<button type="submit" class="btn btn-primary px-4 w-100">@lang('Save Changes')</button>
		          	</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
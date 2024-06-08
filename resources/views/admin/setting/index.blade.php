@extends('admin.layouts.master')
@section('content')
@section('title','Site Setting')

<div class="row mt-3 justify-content-md-center">
    <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
      	<div class="card shadow-sm border-0">
        	<div class="card-body">
          		<form action="{{ route('admin.setting.update') }}" method="post" enctype="multipart/form-data">
          			@csrf
          			<div class="card shadow-none border">
            			<div class="card-header header-area">
              				<h6 class="mb-0">@lang('Site Setting')</h6>
            			</div>
			            <div class="card-body">
			              	<div class="row g-3">
				              	<div class="col-6">
				                	<label class="form-label">@lang('Site Name')</label>
				                	<input type="text" name="site_name" class="form-control" value="{{__($setting->site_name)}}" placeholder="Site Name">
				              	</div>
				              	<div class="col-6">
				                	<label class="form-label">@lang('Site Currency')</label>
				                	<input type="text" name="site_currency" class="form-control" value="{{__($setting->site_currency)}}" placeholder="Site Currency">
				              	</div>
				              	<div class="col-6">
				                	<label class="form-label">@lang('Currency Symbol')</label>
				                	<input type="text" name="currency_symbol" class="form-control" value="{{__($setting->currency_symbol)}}" placeholder="Currency Symbol">
				              	</div>
				              	<div class="col-6">
				                	<label class="form-label">@lang('Timezone')</label>
				                	<select class="form-select select2" name="timezone">
				                		@foreach($timezones as $timezone)
			                            <option value="'{{ @$timezone}}'" @if(config('app.timezone') == $timezone) selected @endif>{{ __($timezone) }}</option>
			                            @endforeach
				                	</select>
				              	</div>
				              	<div class="form-group col-6">
				                	<label class="form-label">@lang('Delivery Charge (Inside Dhaka)')</label>
				                	<input type="text" name="inside_dhaka" class="form-control" value="{{__($setting->inside_dhaka)}}" placeholder="inside dhaka">
				              	</div>
				              	<div class="form-group col-6">
				                	<label class="form-label">@lang('Delivery Charge (Sub Area Of Dhaka)')</label>
				                	<input type="text" name="subarea_dhaka" class="form-control" value="{{__($setting->subarea_dhaka ?? '')}}" placeholder="Sub Area dhaka">
				              	</div>
                                <div class="form-group col-6">
                                    <label class="form-label">@lang('Delivery Charge (Outside Dhaka)')</label>
                                    <input type="text" name="outside_dhaka" class="form-control" value="{{__($setting->outside_dhaka)}}" placeholder="outside dhaka">
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">@lang('Minimum Point Redeem')</label>
                                    <input type="number" name="min_point_redeem" class="form-control" value="{{__($setting->min_point_redeem ?? '')}}" placeholder="Minimum Point Redeem">
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">@lang('Point Redeem (Point for Calculate)')</label>
                                    <input type="number" name="point_redeem" class="form-control" value="{{__($setting->point_redeem ?? '')}}" placeholder="Point Redeem">
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">@lang('Point Redeem Amount (Calculate Amount)')</label>
                                    <input type="number" name="point_redeem_price" class="form-control" value="{{__($setting->point_redeem_price ?? '')}}" placeholder="Point Redeem Price">
                                </div>
                                <div class="form-group col-6">
                                    <label class="form-label">@lang('Shipping Discount (Minimum Amount For Shipping Discount)')</label>
                                    <input type="number" name="min_shipping_amount" class="form-control" value="{{__($setting->min_shipping_amount ?? '')}}" placeholder="Min Amount for Shopping Discount">
                                </div>
                                <div class="form-group col-12">
                                    <div class="image-upload-area">
                                        @if($setting->discount_image)
                                            <img id="preview" src="{{ displayImage($templateAssets.'images/discount_banner/'.$setting->discount_image) }}" alt="Logo"/>
                                        @else
                                            <img id="preview" src="{{ displayImage($templateAssets.'images/logo/logo.png') }}" alt="Logo"/>
                                        @endif
                                        <div class="custom-file">
                                            <input type="file" name="discount_image" class="custom-file-input upload-image" id="upload">
                                            <label class="pick-image" for="upload">@lang('Upload Discount Banner')</label>
                                        </div>
                                    </div>
                                </div>
				                <div class="form-group row pe-0 mt-3">
				                	<div class="form-group col-md-4 pe-0">
										<label class="form-label">@lang('Registration')</label>
										<div class="">
											<input type="checkbox" name="registration" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Enable" data-off="Disabled" data-size="normal" @if($setting->registration) checked @endif>
										</div>
									</div>
	                				<div class="form-group col-md-4 pe-0">
										<label class="form-label">@lang('Email Verified')</label>
										<div class="">
											<input type="checkbox" name="email_verification" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Verified" data-off="Un-Verified" data-size="normal" @if($setting->email_verification) checked @endif>
										</div>
									</div>
	                				<div class="form-group col-md-4 pe-0">
										<label class="form-label">@lang('Multiple Language')</label>
										<div class="">
											<input type="checkbox" name="multi_lang" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Enable" data-off="Disabled" data-size="normal" @if($setting->multi_lang) checked @endif>
										</div>
									</div>
								</div>
              				</div>
            			</div>
          			</div>
          			<div class="row">
          				<div class="col-md-12">
          					<div class="form-group">
            					<button type="submit" class="btn btn-primary btn-block btn-lg w-100">@lang('Save Changes')</button>
          					</div>
          				</div>
          			</div>
        		</form>
        	</div>
      	</div>
    </div>
</div>


@endsection
@extends('admin.layouts.master')
@section('content')
@section('title','Customer')
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class='card shadow-sm border-0'>
			<div class='card-body'>
				<form action="{{ route('admin.customer.update', $customer->id) }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Customer Section')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-8'>
									<div class='form-row form-group mt-3'>
										<label for="first_name01" class='font-weight-bold form-label'>@lang('First_name')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="first_name" value="{{__($customer->first_name)}}" id="first_name01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="last_name01" class='font-weight-bold form-label'>@lang('Last_name')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="last_name" value="{{__($customer->last_name)}}" id="last_name01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="username01" class='font-weight-bold form-label'>@lang('Username')</label>
										<input type="text" class="form-control" name="username" value="{{__($customer->username)}}" id="username01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="email01" class='font-weight-bold form-label'>@lang('Email')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="email" value="{{__($customer->email)}}" id="email01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="password01" class='font-weight-bold form-label'>@lang('Password')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="password" value="{{__($customer->password)}}" id="password01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="phone_number01" class='font-weight-bold form-label'>@lang('Phone_number')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="phone_number" value="{{__($customer->phone_number)}}" id="phone_number01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="address01" class='font-weight-bold form-label'>@lang('Address')</label>
										<textarea class="form-control " rows="5" name="address"><?php echo $customer->address; ?></textarea>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="city01" class='font-weight-bold form-label'>@lang('City')</label>
										<input type="text" class="form-control" name="city" value="{{__($customer->city)}}" id="city01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="zip_code01" class='font-weight-bold form-label'>@lang('Zip_code')</label>
										<input type="text" class="form-control" name="zip_code" value="{{__($customer->zip_code)}}" id="zip_code01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="state01" class='font-weight-bold form-label'>@lang('State')</label>
										<input type="text" class="form-control" name="state" value="{{__($customer->state)}}" id="state01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="country01" class='font-weight-bold form-label'>@lang('Country')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="country" value="{{__($customer->country)}}" id="country01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="email_verify01" class='font-weight-bold form-label'>@lang('Email_verify')</label>
										<input type="text" class="form-control" name="email_verify" value="{{__($customer->email_verify)}}" id="email_verify01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="sms_verify01" class='font-weight-bold form-label'>@lang('Sms_verify')</label>
										<input type="text" class="form-control" name="sms_verify" value="{{__($customer->sms_verify)}}" id="sms_verify01" >
									</div>
								</div>
								<div class='col-md-4'>
									<div class='form-group'>
										<div class='image-upload-area'>
											<img id='preview' src="{{ displayImage('assets/images/customers/'.@$customer->image) }}" alt='Image'/>
											<div class='custom-file'>
												<input type='file' name='image' class='custom-file-input upload-image' id='upload1'>
												<label class='pick-image' for='upload1'>@lang('Upload')</label>
											</div>
										</div>
									<small class="fw-bold text-center">Supported files: jpg,jpeg,png. Image will be re-size into: 1920x1100px</small>
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
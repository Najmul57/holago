@extends('admin.layouts.master')
@section('content')
@section('title','Logo & Favicon')
<div class="row justify-content-center mt-3">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
	            <h6 class="mb-0">@lang('Logo & Favicon')</h6>
	        </div>
			<form action="{{ route('admin.setting.logfav.update') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="card-body favicon-logo-area">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<div class="image-upload-area">
									<img id="preview" src="{{ displayImage($templateAssets.'images/logo/logo.png') }}" alt="Logo"/>
									<div class="custom-file">
										<input type="file" name="logo" class="custom-file-input upload-image" id="upload">
										<label class="pick-image" for="upload">@lang('Upload Light Logo')</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<div class="image-upload-area dark-section">
									<img id="preview" src="{{ displayImage($templateAssets.'images/logo/logo_dark.png') }}" alt="Logo"/>
									<div class="custom-file">
										<input type="file" name="logo_dark" class="custom-file-input upload-image" id="upload-dark">
										<label class="pick-image text-white" for="upload-dark">@lang('Upload Dark Logo')</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 favicon-area mb-30">
							<div class="form-group">
								<div class="image-upload-area">
									<img id="preview" src="{{ displayImage($templateAssets.'images/logo/favicon.png') }}" alt="Favicon"/>
									<div class="custom-file">
										<input type="file" name="favicon" class="custom-file-input upload-image" id="upload2">
										<label class="pick-image" for="upload2">@lang('Upload Favicon')</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-end">
					<button type="submit" class="btn btn-primary w-100"><i class="far fa-check-circle"></i> @lang('Update')</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@extends('admin.layouts.master')
@section('content')
@section('title',$title)
<div class="row">
	<div class="col-md-12">
		<div class="card shadow-sm border-0">
			<div class="card-body">
				<form action="{{ route('admin.theme.basis') }}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="key" value="{{ $basisName }}">
					<input type="hidden" name="type" value="multiple_item">
					<div class="card shadow-none border">
			            <div class="card-header">
			              	<h6 class="mb-0">{{ __($title)}} @lang('Add')</h6>
			            </div>
						<div class="card-body">
							<div class="row mb__30">
								<div class="col-md-{{ $hasImage ? 9 : 12 }} m-b-30">
									@foreach($item['multiple_item'] as $key => $data)
										@php
											$type = @$data['type'];
											$required = @$data['required'];
											if ($key == 'is_modal') {
												continue;
											}
										@endphp
										<div class="col-12 mb-3">
											@if(!@$data['is_image'])
												<label class="form-label fw-bold">{{ __(ucfirst(str_replace('_', ' ', $key))) }}</label>
											@endif
											@if($type == 'text')
											<div class="form-group">
												<input name="{{ $key }}" class="form-control" @if($required) required @endif>
											</div>
											@elseif($type == 'checkbox')
											<div class="form-group">
												<input type="checkbox" name="{{ $key }}" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-on="{{ @$data['switch_value'][0] }}" data-off="{{ @$data['switch_value'][1] }}" data-size="small" data-width="110">
											</div>
											@elseif($type == 'textarea')
											<div class="form-group">
												<textarea rows="5" class="form-control @if(@$data['rich']) summerNote @endif" name="{{ $key }}" @if($required) required @endif></textarea>
											</div>
											@elseif($type == 'file')
												@if(!@$data['is_image'])
													<div class="form-group">
														<input type="file" name="{{ $key }}" class="form-control" @if($required) required @endif>
														<small>@lang('Supported files'): {{ @$data['mimes'] }}</small>
													</div>
												@endif
											@elseif($type == 'select')
											<div class="form-group">
												<select name="{{ $key }}" class="form-control" @if($required) required @endif>
													@foreach(@$data['options'] as $option)
														<option value="{{ $option }}">{{ __(ucfirst(str_replace('_', ' ', $option))) }}</option>
													@endforeach
												</select>
											</div>
											@endif
										</div>
									@endforeach
								</div>
								@if($hasImage)
									<div class="col-md-3 m-b-30">
										@foreach($item['multiple_item'] as $fileKey => $data)
											@php
												$type = @$data['type'];
												$required = @$data['required'];
											@endphp
											@if($type == 'file' && @$data['is_image'])
												<div class="mb-3">
													<div class="image-upload-area">
														<img id="preview" src="{{ displayImage('assets/images/default.png') }}" alt="Image"/>
														<div class="custom-file">
															<input type="file" name="{{ $fileKey }}" class="custom-file-input upload-image" id="upload_{{$fileKey}}">
															<label class="pick-image" for="upload_{{$fileKey}}">@lang('Upload '.ucfirst(str_replace('_', ' ', $fileKey)))</label>
														</div>
													</div>
													<small>@lang('Supported files'): {{ @$data['mimes'] }}. @lang('Image will be re-size into'): {{ @$data['size'] }}@lang('px')</small>
												</div>
											@endif
										@endforeach
									</div>
								@endif
							</div>
						</div>
					</div>
					<div class="card-footer text-right">
						<button type="submit" class="btn btn-primary w-100"><i class="far fa-check-circle"></i> @lang('Save')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
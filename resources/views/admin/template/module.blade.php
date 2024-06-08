@extends('admin.layouts.master')
@section('content')
@section('title',$title)
@if(@$item['single_item'])
<div class="row mt-3">
	<div class="col-md-12 col-lg-12">
		<div class="card shadow-sm border-0">
			<div class="card-body">
				<form action="{{ route('admin.theme.basis',@$basis->id) }}" method="post" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="key" value="{{ $basisName }}">
					<input type="hidden" name="type" value="single_item">
					<div class="card shadow-none border">
            <div class="card-header">
              <h6 class="mb-0">{{__($title)}} @lang('Information')</h6>
            </div>
						<div class="card-body">
							<div class="row mb__30 justify-content-center">
								<div class="col-md-{{ $hasImage ? 9 : 12 }} m-b-30">
									@php
										$hasField = 0;
									@endphp	
									@foreach($item['single_item'] as $key => $data)
										@php
											$type = @$data['type'];
											if($type == 'file'){
												continue;
											}
											$required = @$data['required'];
											$hasField = 1;
										@endphp
										<div class="col-12 mb-3">
											@if(!@$data['is_image'])
												<label class="form-label fw-bold">{{ __(ucfirst(str_replace('_', ' ', $key))) }}</label>
											@endif
											@if($type == 'text')
											<div class="form-group">
												<input name="{{ $key }}" class="form-control" @if($required) required @endif value="{{ @$basis->data->$key }}">
											</div>
											@elseif($type == 'checkbox')
											<div class="form-group">
												<input type="checkbox" name="{{ $key }}" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-on="{{ @$data['switch_value'][0] }}" data-off="{{ @$data['switch_value'][1] }}" data-size="small" data-width="110" @if(@$basis->data->$key == '1') checked @endif>
											</div>
											@elseif($type == 'textarea')
											<div class="form-group">
												<textarea rows="5" class="form-control @if(@$data['rich']) summerNote @endif" name="{{ $key }}" @if($required) required @endif>@php echo @$basis->data->$key @endphp</textarea>
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
														<option value="{{ $option }}" @if(@$basis->data->$key == $option) selected @endif>{{ __(ucfirst(str_replace('_', ' ', $option))) }}</option>
													@endforeach
												</select>
											</div>
											@endif
										</div>
									@endforeach
									
								</div>
								@if($hasImage)
									<div class="col-md-{{ $hasField == 1 ? 3 : 6 }} m-b-30">
										@foreach($item['single_item'] as $fileKey => $data)
											@php
												$type = @$data['type'];
												$required = @$data['required'];
											@endphp
											@if($type == 'file' && @$data['is_image'])
												<div class="mb-3">
													<div class="image-upload-area">
														<img id="preview" src="{{ displayImage('assets/'.$setting->template.'/images/'.$basisName.'/'.@$basis->data->$fileKey) }}" alt="Image"/>
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
						<button type="submit" class="btn btn-primary w-100"><i class="far fa-check-circle"></i> @lang('Update')</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endif
@if(array_key_exists('multiple_item', $item))
@php
	$images = [];
	$themeItems = [];
@endphp
<div class="row mt-3">
	<div class="col-md-12">
		<div class="card">
			<div class="table-responsive">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">@lang('SL')</th>
                @foreach($item['multiple_item'] as $itemKey => $itemValue)
                	@if($itemKey == 'is_modal')
                		@continue
                	@endif
                  @if($itemValue['type'] != 'textarea' && $itemValue['type'] != 'checkbox' && $itemValue['type'] != 'file' && $itemKey != 'is_modal')
                  	<th scope="col">{{ ucfirst(str_replace('_',' ',$itemKey)) }}</th>
                  @endif
                @endforeach
                <th scope="col">@lang('Action')</th>
              </tr>
            </thead>
            <tbody>
            	@forelse($themeDatas as $themeKey => $data)
              	<tr>
              		<td>{{ $loop->iteration }}</td>
                  @foreach($item['multiple_item'] as $itemKey => $itemValue)
                    		@if($itemKey == 'is_modal')
                              @continue
                          @endif
                  	@if($itemValue['type'] == 'file' && $itemValue['is_image'] == true)
						@php
							$images[$itemKey] = displayImage('assets/'.$setting->template.'/images/'.$basisName.'/'.$data->data->$itemKey);
						@endphp
					@else
						@php
							$themeItems[$itemKey] = $data->data->$itemKey;
						@endphp
                  	@endif
                    @if($itemValue['type'] != 'textarea' && $itemValue['type'] != 'checkbox' && $itemValue['type'] != 'file' && $itemKey != 'is_modal')
                    	<td>{{ @__($data->data->$itemKey) }}</td>
                    @endif
                  @endforeach
                  <td>
                  	@if($item['multiple_item']['is_modal'] == true)
                  	<button class="btn bg-gradient-info btn-sm icon-btn ml-1 editBtn" data-value="{{ json_encode($themeItems) }}" data-action="{{ route('admin.theme.basis',@$data->id) }}" data-images="{{ json_encode($images) }}" data-bs-toggle="modal" data-bs-target="#themeEdit"><i class="la la-pencil"></i></button>
                  	@else
                  	<a href="{{ route('admin.theme.basis.edit',[$basisName,$data->id]) }}" class="btn bg-gradient-info btn-sm icon-btn ml-1"><i class="la la-pencil"></i></a>
                  	@endif
                  	<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 removeBtn" data-action="{{ route('admin.theme.basis.remove',@$data->id) }}"><i class="fas fa-trash-alt"></i></button>
                  </td>
              	</tr>
            @empty
            <tr>
            	<td class="text-center" colspan="100%">@lang('No data found')</td>
            </tr>
              @endforelse
            </tbody>
        </table>
    	</div>
		</div>
	</div>
</div>
@php
	$hasImage = searchForKey(true,'is_image', $item['multiple_item']);
	$i = 0;
@endphp
<!-- Modal -->
<div class="modal fade" id="theme" tabindex="-1" role="dialog" aria-labelledby="themeLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="createModalLabel"> @lang('Add New') {{ __(ucfirst(str_replace('_', ' ', @$basis->name)))}}</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <form class="form-horizontal" action="{{ route('admin.theme.basis') }}" method="post" enctype="multipart/form-data">
      	@csrf
      	<input type="hidden" name="key" value="{{ $basisName }}">
				<input type="hidden" name="type" value="multiple_item">
	      <div class="modal-body">
	      	<div class="row">
	      		<div class="col-md-{{ $hasImage ? 8 : 12 }} m-b-30">
		        	@foreach($item['multiple_item'] as $key => $data)
			        	@if($key == 'is_modal')
							@php continue @endphp
			        	@endif
						@php
							$type = @$data['type'];
							$required = @$data['required'];
						@endphp
						<div class="form-row form-group mb-3">
							@if(!@$data['is_image'])
								<label class="form-label fw-bold">{{ __(ucfirst(str_replace('_', ' ', $key))) }}</label>
							@endif
							@if($type == 'text')
							<div class="col-sm-12">
								<input name="{{ $key }}" class="form-control" @if($required) required @endif>
							</div>
							@elseif($type == 'checkbox')
							<div class="col-sm-12">
								<input type="checkbox" name="{{ $key }}" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-on="{{ @$data['switch_value'][0] }}" data-off="{{ @$data['switch_value'][1] }}" data-size="small" data-width="110">
							</div>
							@elseif($type == 'textarea')
							<div class="col-sm-12">
								<textarea rows="5" class="form-control @if(@$data['rich']) summerNote @endif" name="{{ $key }}" @if($required) required @endif></textarea>
							</div>
							@elseif($type == 'file')
								@if(!@$data['is_image'])
									<div class="col-sm-12">
										<input type="file" name="{{ $key }}" class="form-control" @if($required) required @endif>
										<small>@lang('Supported files'): {{ @$data['mimes'] }}</small>
									</div>
								@endif
							@elseif($type == 'select')
							<div class="col-sm-12">
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
					<div class="col-md-4 m-b-30">
						@foreach($item['multiple_item'] as $fileKey => $data)
							@php
								$type = @$data['type'];
                      			if(!$type){
                      				continue;
                      			}
								$required = @$data['required'];
							@endphp
							@if($type == 'file' && @$data['is_image'])
								<div class="mb-3">
									<div class="image-upload-area">
										<img id="preview" src="{{ displayImage('assets/images/default.jpg') }}" alt="Image"/>
										<div class="custom-file">
											<input type="file" name="{{ $fileKey }}" class="custom-file-input upload-image" id="create_upload_{{$fileKey}}">
											<label class="pick-image" for="create_upload_{{$fileKey}}">@lang('Upload '.ucfirst(str_replace('_', ' ', $fileKey)))</label>
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
	      <div class="modal-footer">
	        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
	        <button type="submit" class="btn btn-primary">@lang('Save')</button>
	      </div>
  	 </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="themeEdit" tabindex="-1" role="dialog" aria-labelledby="themeEditLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="themeEditLabel"><i class="las la-edit"></i> @lang('Edit') {{ __(ucfirst(str_replace('_', ' ', @$basis->name)))}}</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.theme.basis') }}" method="post" enctype="multipart/form-data">
      	@csrf
      	<input type="hidden" name="key" value="{{ $basisName }}">
		<input type="hidden" name="type" value="multiple_item">
	      <div class="modal-body">
	      	<div class="row">
	      		<div class="col-md-{{ $hasImage ? 8 : 12 }} mb-3">
		        	@foreach($item['multiple_item'] as $key => $data)
			        	@if($key == 'is_modal')
									@php continue @endphp
			        	@endif
								@php
									$type = @$data['type'];
									$required = @$data['required'];
								@endphp
								<div class="form-row form-group">
									@if(!@$data['is_image'])
										<label class="form-label fw-bold">{{ __(ucfirst(str_replace('_', ' ', $key))) }}</label>
									@endif
									@if($type == 'text')
									<div class="col-sm-12">
										<input name="{{ $key }}" class="form-control" @if($required) required @endif>
									</div>
									@elseif($type == 'checkbox')
									<div class="col-sm-12">
										<input type="checkbox" name="{{ $key }}" data-toggle="toggle" data-onstyle="success" data-offstyle="dark" data-on="{{ @$data['switch_value'][0] }}" data-off="{{ @$data['switch_value'][1] }}" data-size="small" data-width="110">
									</div>
									@elseif($type == 'textarea')
									<div class="col-sm-12">
										<textarea rows="5" class="form-control @if(@$data['rich']) summerNote @endif" name="{{ $key }}" @if($required) required @endif></textarea>
									</div>
									@elseif($type == 'file')
										@if(!@$data['is_image'])
											<div class="col-sm-12">
												<input type="file" name="{{ $key }}" class="form-control" @if($required) required @endif>
												<small>@lang('Supported files'): {{ @$data['mimes'] }}</small>
											</div>
										@endif
									@elseif($type == 'select')
									<div class="col-sm-12">
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
					<div class="col-md-4 m-b-30">
						@foreach($item['multiple_item'] as $fileKey => $data)
							@php
								$type = @$data['type'];
										$required = @$data['required'];
							@endphp
							@if($type == 'file' && @$data['is_image'])
								<div class="mb-3">
									<div class="image-upload-area">
										<img id="preview" src="{{ displayImage('assets/'.$setting->template.'/images/'.$basisName.'/'.@$basis->data->$fileKey) }}" alt="Image"/>
										<div class="custom-file">
											<input type="file" name="{{ $fileKey }}" class="custom-file-input upload-image" id="edit_upload_{{$i}}">
											<label class="pick-image" for="edit_upload_{{$i}}">@lang('Upload '.ucfirst(str_replace('_', ' ', $fileKey)))</label>
										</div>
									</div>
									<small>@lang('Supported files'): {{ @$data['mimes'] }}. @lang('Image will be re-size into'): {{ @$data['size'] }}@lang('px')</small>
								</div>
							@endif
							@php $i++; @endphp
						@endforeach
					</div>
				@endif
	      	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
	        <button type="submit" class="btn btn-primary">@lang('Save')</button>
	      </div>
  	 </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeModalLabel"><i class="las la-trash"></i>@lang('Delete') {{ __(ucfirst(str_replace('_', ' ', @$basis->name))) }}</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" enctype="multipart/form-data">
      	@csrf
	      <div class="modal-body">
	      	<h3 class="text-center">@lang('Are you sure to delete this item?')</h3>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
	        <button type="submit" class="btn btn-danger">@lang('Delete')</button>
	      </div>
  	 </form>
    </div>
  </div>
</div>
@endif

@endsection
@push('top-area')
	@if(array_key_exists('multiple_item', $item))
		@if($item['multiple_item']['is_modal'] == true)
		<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#theme"><i class="las la-plus-circle"></i>@lang('Add new')</button>
		@else
		<a href="{{ route('admin.theme.basis.create',$basisName) }}" class="btn btn-sm btn-primary"><i class="las la-plus-circle"></i>@lang('Add new')</a>
		@endif
	@endif
@endpush
@push('js')
<script>
	(function($){
		"use strict";
		$('.editBtn').on('click',function(){
			var themeModal = $('#themeEdit');
			var items = $(this).data('value');
			var action = $(this).data('action');
			var items = Object.entries(items);
			var images = $(this).data('images');
			var images = Object.entries(images);
			items.forEach( function(basis, index) {
				if(basis[0] != 'is_modal'){
					themeModal.find(`input[name=${basis[0]}]`).val(basis[1]);
					themeModal.find(`textarea[name=${basis[0]}]`).val(basis[1]);
					themeModal.find(`select[name=${basis[0]}]`).val(basis[1]);
				}
			});

			images.forEach( function(image, imageIndex) {
				var imageBasis = themeModal.find(`input[name=${image[0]}]`).closest('.image-upload-area').find('img').attr('src',image[1]);
			});
			themeModal.find('form').attr('action',$(this).data('action'));
		});

		$('.removeBtn').on('click',function(){
			var removeModal = $('#removeModal');
			removeModal.find('form').attr('action',$(this).data('action'));
			removeModal.modal('show');
		});
	})(jQuery);
</script>
@endpush
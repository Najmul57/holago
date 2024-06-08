@extends('admin.layouts.master')
@section('content')
@section('title','SEO Setting')

<!--start content-->
<div class="row mt-3">
	<div class="col-12 col-lg-12">
  		<div class="card shadow-sm border-0">
    		<div class="card-body">
      			<form action="" method="post" enctype="multipart/form-data">
      				@csrf
      				<div class="card shadow-none border">
        				<div class="card-header">
          					<h6 class="mb-0">@lang('SEO Update')</h6>
        				</div>
        				<div class="card-body">
          					<div class="row g-3">
            					<div class="col-md-8">
              						<div class="form-group mb-3">
                						<label class="form-label">@lang('Meta Keyword')</label>
                						<select class="select2-auto-tokenize form-control" name="keywords[]" multiple="multiple">
						                  @if(@$setting->seo->keywords)
												@foreach($setting->seo->keywords as $keyword)
													<option selected>{{ $keyword }}</option>
												@endforeach
						                  @endif
						                </select>
              						</div>
              						<div class="form-group mb-3">
                  						<label class="form-label">@lang('Meta Description')</label>
                  						<textarea class="form-control summerNote" name="meta_description" rows="5">{{ @$setting->seo->meta_description }}</textarea>
              						</div>
              						<div class="form-group mb-3">
                  						<label class="form-label">@lang('Social Title')</label>
                  						<input type="text" name="social_title" class="form-control" value="{{ @$setting->seo->social_title}}">
              						</div>
              						<div class="form-group mb-3">
                  						<label class="form-label">@lang('Social Description')</label>
                  						<textarea class="form-control summerNote" name="social_description" rows="5">{{ @$setting->seo->social_description }}</textarea>
              						</div>
					            </div>
        						<div class="col-md-4">
          							<div class="form-group">
            							<div class="image-upload-area">
              								<img id="preview" src="{{ displayImage($templateAssets.'images/seo/'.@$setting->seo->image) }}" alt="ggg"/>
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
		            	<button type="submit" class="btn btn-primary px-4">@lang('Update')</button>
		          	</div>
		    	</form>
	        </div>
	    </div>
	</div>
</div>

@endsection

@extends('admin.layouts.master')
@section('content')
@section('title','Child_category')
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class='card shadow-sm border-0'>
			<div class='card-body'>
				<form action="{{ route('admin.child_category.update', $child_category->id) }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Child Category Section')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-8'>			<td scope='col'>{{ isset($child_category->) ? __($child_category->) : 'N/A' }}</td>
				
									<div class='form-row form-group mt-3'>
										<label for="name01" class='font-weight-bold form-label'>@lang('Name')</label><span class='text-danger'>*</span>
										<input type="text" class="form-control" name="name" value="{{__($child_category->name)}}" id="name01" required>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="icon01" class='font-weight-bold form-label'>@lang('Icon')</label>
										<input type="text" class="form-control" name="icon" value="{{__($child_category->icon)}}" id="icon01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="meta_title01" class='font-weight-bold form-label'>@lang('Meta_title')</label>
										<input type="text" class="form-control" name="meta_title" value="{{__($child_category->meta_title)}}" id="meta_title01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="meta_description01" class='font-weight-bold form-label'>@lang('Meta_description')</label>
										<textarea class="form-control " rows="5" name="meta_description"><?php echo $child_category->meta_description; ?></textarea>
									</div>
									<div class='form-row form-group mt-3'>
										<label for="meta_keywords01" class='font-weight-bold form-label'>@lang('Meta_keywords')</label>
										<input type="text" class="form-control" name="meta_keywords" value="{{__($child_category->meta_keywords)}}" id="meta_keywords01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="top_category01" class='font-weight-bold form-label'>@lang('Top_category')</label>
										<input type="text" class="form-control" name="top_category" value="{{__($child_category->top_category)}}" id="top_category01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="special_category01" class='font-weight-bold form-label'>@lang('Special_category')</label>
										<input type="text" class="form-control" name="special_category" value="{{__($child_category->special_category)}}" id="special_category01" >
									</div>
									<div class='form-row form-group mt-3'>
										<label for="filter_category01" class='font-weight-bold form-label'>@lang('Filter_category')</label>
										<input type="text" class="form-control" name="filter_category" value="{{__($child_category->filter_category)}}" id="filter_category01" >
									</div>
								</div>
								<div class='col-md-4'>
									<div class='form-group'>
										<div class='image-upload-area'>
											<img id='preview' src="{{ displayImage('assets/images/child_categories/'.@$child_category->image) }}" alt='Image'/>
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
@extends('admin.layouts.master')
@section('content')
@section('title','Create Product')
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class=' border-0'>
			<div class=''>
				<form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Product Information')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
                                <div class="col-md-6">
                                    <div class='form-row form-group mb-1'>
                                        <label for="name01" class='font-weight-bold form-label'>@lang('Product Name')</label><span class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="name" id="name01" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class='form-row form-group mb-1'>
                                        <label for="slug" class='font-weight-bold form-label'>@lang('Product slug')</label><span class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="slug" id="slug" required >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class='form-row form-group mb-1'>
                                        <label for="product_model01" class='font-weight-bold form-label'>@lang('Product Model')</label>
                                        <input type="text" class="form-control" name="product_model" id="product_model01" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class='form-group mb-1'>
                                        <label for="brand01" class='form-label'>@lang('Category')</label><span class='text-danger'>*</span>
                                        <select class="select2-auto-tokenize1 form-control" name="category_id">
                                            <option disabled selected>select one</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class='form-group mb-1'>
                                        <label for="brand01" class='form-label'>@lang('Sub Category')</label><span class='text-danger'>*</span>
                                        <select class="select2-auto-tokenize1 form-control" name="sub_category_id">
                                            <option disabled selected>select one</option>
                                            @foreach($sub_categories as $subcategory)
                                                <option value="{{$subcategory->id}}">{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
							</div>
						</div>
					</div>
					<div class="card shadow-none border mt-3">
						<div class="card-header">
							<h6 class="mb-0">@lang('Product Pricing')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-6'>
									<label for="buying_price01" class='font-weight-bold form-label'>@lang('Buying Price')</label><span class='text-danger'>*</span>
									<div class="input-group">
	                                    <input type="number" class="form-control" name="buying_price" id="buying_price01" required>
	                                    <span class="input-group-text">{{__($setting->site_currency)}}</span>
	                                </div>
								</div>
								<div class='col-6'>
									<label for="regular_price01" class='font-weight-bold form-label'>@lang('Regular Price')</label><span class='text-danger'>*</span>
									<div class="input-group">
										<input type="number" class="form-control" name="regular_price" id="regular_price01" required>
	                                    <span class="input-group-text">{{__($setting->site_currency)}}</span>
	                                </div>
								</div>
                                <div class='col-6'>
                                    <label for="regular_price01" class='font-weight-bold form-label'>@lang('Discount Price')</label><span class='text-danger'></span>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="discount_price" id="">
                                        <span class="input-group-text">{{__($setting->site_currency)}}</span>
                                    </div>
                                </div>
								<div class='col-6'>
									<label for="points01" class='font-weight-bold form-label'>@lang('Product Points')</label>
									<input type="number" class="form-control" name="points" id="points01">
								</div>
							</div>
						</div>
					</div>
					<div class="card shadow-none border mt-3">
						<div class="card-header">
							<h6 class="mb-0">@lang('Product Description')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class='form-row form-group mb-3'>
										<label for="description01" class='font-weight-bold form-label'>@lang('Description')</label>
										<textarea class="form-control summerNote" rows="5" name="description"></textarea>
									</div>
									<div class='form-row form-group mb-3'>
										<label for="summary01" class='font-weight-bold form-label'>@lang('Summary')</label>
										<textarea class="form-control" rows="5" name="summary"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card shadow-none border mt-3">
						<div class="card-header">
							<h6 class="mb-0">@lang('Product SEO')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
                                <div class="col-md-6">
                                    <div class='form-row form-group mb-1'>
                                        <label for="meta_title01" class='font-weight-bold form-label'>@lang('Meta Title')</label>
                                        <input type="text" class="form-control" name="meta_title" id="meta_title01" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class='form-row form-group mb-1'>
                                        <label for="meta_keyword01" class='font-weight-bold form-label'>@lang('Meta keyword')</label>
                                        <select class="select2-auto-tokenize form-control" name="meta_keyword[]" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
									<div class='form-row form-group mb-1'>
										<label for="meta_description01" class='font-weight-bold form-label'>@lang('Meta Description')</label>
										<textarea class="form-control " rows="5" name="meta_description"></textarea>
									</div>
							</div>
						</div>
					</div>

					<div class="card shadow-none border mt-3">
						<div class="card-header">
							<h6 class="mb-0">@lang('Product Main Image')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-3'>
									<div class='form-group'>
										<label for="meta_description01" class='font-weight-bold form-label'>@lang('Product Main Image')</label><span class='text-danger'>*</span>
										<div class='image-upload-area'>
											<img id='preview' src="{{ displayImage('assets/images/default.jpg') }}" alt='Image'/>
											<div class='custom-file'>
												<input type='file' name='image' class='custom-file-input upload-image' id='upload'>
												<label class='pick-image' for='upload'>@lang('Upload')</label>
											</div>
										</div>
										<small class="fw-bold text-center">Supported files: jpg,jpeg,png. Image will be re-size into: 1708x2560px</small>
									</div>
								</div>
								<div class='col-md-3'>
									<div class='form-group'>
										<label for="meta_description01" class='font-weight-bold form-label'>@lang('Product Hover Image')</label>
										<div class='image-upload-area'>
											<img id='preview' src="{{ displayImage('assets/images/default.jpg') }}" alt='Image'/>
											<div class='custom-file'>
												<input type='file' name='hover_image' class='custom-file-input upload-image' id='upload45'>
												<label class='pick-image' for='upload45'>@lang('Upload')</label>
											</div>
										</div>
										<small class="fw-bold text-center">Supported files: jpg,jpeg,png. Image will be re-size into:1708x2560px</small>
									</div>
								</div>
								<div class='col-md-6'>
									<div class='form-row form-group mb-3'>
										<label for="sku01" class='font-weight-bold form-label'>@lang('Sku')</label><span class='text-danger'></span>
										<input type="text" class="form-control" name="sku" id="sku01">
									</div>
									<div class='form-row form-group mb-3'>
										<label for="video_link01" class='font-weight-bold form-label'>@lang('Video link')</label>
										<input type="text" class="form-control" name="video_link" id="video_link01">
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card shadow-none border mt-3">
						<div class="card-header d-flex justify-content-between align-items-md-center">
							<div class="mb-0">
								<h6 class="mb-0">@lang('Product Additional Images')</h6>
							</div>
							<div>
								<button type="button" class="btn btn-success add-additional"><i class="las la-plus-circle"></i></button>
							</div>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class="additional-info">
										<p class="p-2">@lang('Add Additional Images as you want by clicking the (+) button on the right side.')</p>
									</div>
            						<div class='row additional'>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card shadow-none border mt-3">
						<div class="card-header">
							<h6 class="mb-0">@lang('Product Activation')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class="form-group row pe-0 mt-3">
					                	<div class="form-group col-md-3 pe-0">
											<label class="form-label fw-bold">@lang('Track Inventory')</label>
											<div class="">
												<input type="checkbox" name="track_inventory" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" data-size="normal">
											</div>
										</div>
					                	<div class="form-group col-md-3 pe-0">
											<label class="form-label fw-bold">@lang('Has Variants')</label>
											<div class="">
												<input type="checkbox" name="has_variants" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" data-size="normal">
											</div>
										</div>
					                	<div class="form-group col-md-3 pe-0">
											<label class="form-label fw-bold">@lang('Is Hot Product')</label>
											<div class="">
												<input type="checkbox" name="is_featured" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" data-size="normal">
											</div>
										</div>
					                	<div class="form-group col-md-3 pe-0">
											<label class="form-label fw-bold">@lang('Is Special')</label>
											<div class="">
												<input type="checkbox" name="is_special" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Yes" data-off="No" data-size="normal">
											</div>
										</div>
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

@push('top-area')
	<a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-primary box-shadow1 text-small"><i class="las la-backward"></i>@lang('Go Back')</a>
@endpush

@push('css')
<style>
	.select2-container--default .select2-selection--single{
		border: 1px solid #ced4da !important;
	}
	.select2-container .select2-selection--single{
		height: 39px;
		border-radius: .375rem;
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow{
		top: 3px;
	}
	.select2-container .select2-selection--single .select2-selection__rendered{
		padding-top: 3px;
	}
	.select2-container .select2-selection--multiple{
		height: 39px;
	}
	.select2-container--default .select2-selection--multiple{
		border-radius: .375rem;
		border: 1px solid #ced4da !important;
	}
</style>
@endpush

@push('js')
<script>
	'use strict';
    (function($){
        var dropdownParent = $('.has-select2');
		$('.select2-multi-select').select2({
	        dropdownParent: dropdownParent,
	        closeOnSelect: false
	    });
	    //image upload preview
		  function readURL(input,thisElement) {
		    if (input.files && input.files[0]) {
		      var reader = new FileReader();
		      var parentElement = thisElement.closest('.image-upload-area');
		      var previewElement = parentElement.find('#preview');
		      reader.onload = function(e) {
		        previewElement.attr('src', e.target.result);
		      }

		      reader.readAsDataURL(input.files[0]); // convert to base64 string
		    }
		  }

		  $(document).on('change','.upload-image',function() {
		    var thisElement = $(this);
		    readURL(this,thisElement);
		  });

	    $(document).on('click','.add-specification',function(){
            $('.specification-info').addClass('d-none');
            var html = `<div class="specifications mb-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="specification_name[]" placeholder="@lang('Type Name Here...')">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group abs-form-group d-flex justify-content-between">

                                                    <input type="text" class="form-control" name="specification_value[]" placeholder="@lang('Type Value Here...')">
                                                    <button type="button" class="btn btn-danger remove-specification abs-button"><i class="la la-minus"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>`;
                    $('.specifications-wrapper').append(html);

	            $(document).on('click','.remove-specification',function(){
		            $(this).closest('.specifications').remove();
		        });
        });

	    $(document).on('click','.add-additional',function(){
            $('.additional-info').addClass('d-none');
            var count = $('.additional .image-upload-area').length;
            var html = `<div class='col-md-3 shamim_bhai'>
							<label for="meta_description01" class='font-weight-bold form-label'>@lang('Product Main Image')</label>
							<div class='image-upload-area'>
							<div>
								<button type="button" class="btn btn-sm btn-danger text-white text-end position-absolute remove-addition"><i class="las la-minus"></i></button>
							</div>
								<img id='preview' src="{{ displayImage('assets/images/default.jpg') }}" alt='Image'/>
								<div class='custom-file'>
									<input type='file' name='additional_image[]' class='custom-file-input upload-image' id='upload${count + 2}'>
									<label class='pick-image' for='upload${count + 2}'>@lang('Upload')</label>
								</div>
							</div>
							<small class="fw-bold text-center">Supported files: jpg,jpeg,png. Image will be re-size into: 1920x1100px</small>
						</div>`;
                    $('.additional').append(html);

	            $(document).on('click','.remove-addition',function(){
		            $(this).closest('.shamim_bhai').remove();
		        });
        });

	})(jQuery);
</script>

<script>
    document.getElementById('name01').addEventListener('input', function () {
        // Get the value from the "name" input
        var nameValue = this.value;

        // Replace spaces with hyphens and convert to lowercase for a basic slug
        var slugValue = nameValue.toLowerCase().replace(/\s+/g, '-');

        // Update the value of the "slug" input
        document.getElementById('slug').value = slugValue;
 });
</script>

@endpush
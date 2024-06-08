@extends('admin.layouts.master')
@section('content')
@section('title',$title)
<div class='row mt-3'>
	<div class='col-12 col-lg-12'>
		<div class='card shadow-sm border-0'>
            @if($existing_attributes->count() > 0)
            <div class="card-header">
                <h5 class="ml-3 text-white font-weight-bold">@lang('If you add new a new type of variant, your previous stock records for this product will be removed.')</h5>
            </div>
            @endif
			<div class='card-body'>
				<form action="{{ route('admin.product.attribute-store',$product_id) }}" method="post" enctype="multipart/form-data">
					@csrf
                    <input type="hidden" name="attr_type">
					<div class="card shadow-none border">
						<div class="card-header">
							<h6 class="mb-0">@lang('Category Section')</h6>
						</div>
						<div class="card-body">
							<div class="row g-3">
								<div class='col-md-12'>
									<div class='form-row form-group mt-3'>
										<label for="meta_keywords01" class='font-weight-bold form-label'>@lang('Meta_keywords')</label>
										<select class="form-control select2 attrId" name="attr_id" required>
                                            <option selected value="" disabled>@lang('Select One')</option>
                                            @foreach ($attributes as $attr)
                                                <option data-type="{{$attr->value_type}}" value="{{$attr->id}}">{{$attr->name}}</option>
                                            @endforeach
                                        </select>
									</div>
								</div>
							</div>
                            <div class="attr-wrapper"></div>
                            <button type="button" class="btn btn-success add_more d-none"><i class="la la-plus"></i></button>
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

<div class="row">
    <div class="col-lg-12 mt-5">
        <h6 class="page-title">@lang('Existing Variants')</h6>
    </div>
    @forelse ($existing_attributes as $attr)
    <div class="col-lg-12">
        <div class="card shadow-sm border-0 my-3">
            <div class="card-header">
                <h5>{{ $attr[0]->productAttribute->name }}</h5>
            </div>
            <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table align-middle mb-0'>
                        <thead class="table-light">
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Value')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attr as $item)
                               <tr>
                                   <td data-label="@lang('S.N.')">{{ $loop->iteration }}</td>
                                   <td data-label="@lang('Name')">{{ __($item->name) }}</td>
                                   <td data-label="@lang('Value')">
                                        @if($attr[0]->productAttribute->value_type == 2)
                                        <span class="px-3 p-2 w-50" style="background-color: #{{ $item->content }}">&nbsp;</span>

                                        @elseif($attr[0]->productAttribute->value_type == 3)
                                        <div class="thumbnails d-inline-block">
                                            <div class="thumb">
                                                <a href="" class="image-popup">
                                                    <img src="{{ displayImage('assets/images/product/attribute/'.@$item->content) }}" alt="@lang('image')">
                                                </a>
                                            </div>
                                        </div>

                                        @else
                                        {{ $item->content }}
                                        @endif
                                    </td>
                                   <td data-label="@lang('Action')">

                                    @if($attr[0]->productAttribute->value_type == 2 || $attr[0]->productAttribute->value_type == 3)
                                        <a href="{{ route('admin.product.add-variant-images', $item->id) }}" data-toggle="tooltip" data-title="@lang('Add Variant Images')" class="btn bg-gradient-info btn-sm icon-btn ml-1"> <i class="la la-image"></i></a>
                                    @endif
                                       <a href="javascript:void(0)" class="btn bg-gradient-info btn-sm icon-btn ml-1 editBtn" data-toggle="tooltip" data-title="@lang('Edit')" data-item="{{ $item }}" @if($attr[0]->productAttribute->value_type == 3) data-image="{{ displayImage('assets/images/product/attribute/'.@$item->content) }}" alt="@lang('image')" @endif>
                                           <i class="la la-pencil"></i>
                                       </a>

                                       <a href="javascript:void(0)" class="btn bg-gradient-danger btn-sm icon-btn deleteBtn ml-1" data-toggle="tooltip" data-title="@lang('Delete')"  data-link="{{route('admin.product.attribute-delete', $item->id)}}"><i class="la la-trash"></i></a>
                                        </div>
                                   </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-lg-12 mt-3">
        <div class="alert border border-warning" role="alert">
            <div class="alert_icon bg-warning"><i class="far fa-bell"></i></div>
            <p class="alert_message">{{ __($empty_message) }}</p>
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
    @endforelse
</div>

<!-- Modal -->
<div id="editModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Product Enable Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="deleteModal" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <form  method="POST" id="deleteForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="deleteModalLabel">@lang('Delete Variant')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   @lang('Are you sure to delete this Variant')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')

<script>
    'use strict';
    var itr = 0;
    (function($){

        $(document).on('click', '.deleteBtn' ,function () {
            var modal   = $('#deleteModal');
            var link    = $(this).data('link');
            var form    = $('#deleteForm');
            $(form).attr('action', link);
            modal.modal('show');
        });

        $(document).on('click', '.add_more' ,function(){
            var type = $('input[name="attr_type"]').val();
            console.log(type);
            itr ++;
            if(type==1){
                var content = textContent();
                $(content).appendTo('.attr-wrapper').hide().slideDown('slow');
            }else if(type==2){
               var content = colorContent();
                $(content).appendTo('.attr-wrapper').hide().slideDown('slow');
            }else if(type==3){
                var content = imageContent();
                $(content).appendTo('.attr-wrapper').hide().slideDown('slow');
            }

        });

        $(document).on('change', '.attrId' ,function(){
            itr=0;
            var type = $(this).children('option:selected').data('type');
            console.log(type)
            $('input[name="attr_type"]').val(type);
            if(type==1){
                var content = textContent();
                $('.attr-wrapper').html('');
                $(content).appendTo('.attr-wrapper').hide().slideDown('slow');
            }else if(type==2){
               var content = colorContent();
                $('.attr-wrapper').html('');
                $(content).appendTo('.attr-wrapper').hide().slideDown('slow');
            }else if(type==3){
                var content = imageContent();

                $('.attr-wrapper').html('');
                $(content).appendTo('.attr-wrapper').hide().slideDown('slow')
            }


            $('.add_more').removeClass('d-none');

        });

        $(document).on('click', '.removeBtn', function() {
            var parent = $(this).parents('.single-attr');
            parent.slideUp('slow', function(){
                this.remove();
            });

        });

        $(document).on('change', ".profilePicUpload", function () {
            proPicURL(this);
        });

        $('.editBtn').on('click', function(){
            var modal   = $('#editModal');
            var item    = $(this).data('item');
            modal.find('.modal-title').text(`@lang('Edit -  ${item.product_attribute.name}')`);
            var content = ``;
            if(item.product_attribute.value_type == 1){
                content = `<div class="form-group mt-3">
                                <label>@lang('Name')</label>
                                <input type="text" placeholder="@lang('Type Here')..." class="form-control" name="name" required />
                            </div>

                            <div class="form-group mt-3">
                                <label>@lang('Value')</label>
                                <input type="text" placeholder="@lang('Type Here')..." class="form-control" name="value" required />
                            </div>
                        `;
                modal.find('.modal-body').html(content);
                modal.find('input[name=name]').val(item.name);
                modal.find('input[name=value]').val(item.content);

            }else if(item.product_attribute.value_type == 2){
                content = `
                            <div class="form-group mt-3"><label>@lang('Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('Type Here')..." required />
                            </div>
                            <label>@lang('Color')</label>
                            <div class="input-group mt-3">
                                <span class="input-group-addon ">
                                    <input type='color' class="form-control colorPicker" value=""/>
                                </span>
                                <input type="text" class="form-control colorCode" name="value" value="" required/>
                            </div>
                        </div>
                `;
                modal.find('.modal-body').html(content);
                modal.find('input[name=name]').val(item.name);
                modal.find('input[name=value]').val(item.content);
                modal.find('.colorPicker').val(item.value_type);

            }else if(item.product_attribute.value_type == 3){
                content = `
                            <div class="form-group mt-3">
                                <label>@lang('Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@lang('Type Here')..." required />
                            </div>
                            <div class="form-group mt-3">
                                <div class="payment-method-item">
                                <label>@lang('Value')</label>
                                    <div class="payment-method-header">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview"></div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" name="image" class="profilePicUpload" id="image-update" accept=".png, .jpg, .jpeg" >
                                                <label for="image-update" class="bg-primary"><i class="la la-pencil"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                modal.find('.modal-body').html(content);
                modal.find('input[name=name]').val(item.name);
                var image    = $(this).data('image');
                modal.find('.profilePicPreview').css("background-image", "url(" + image + ")");
            }else{
                modal.find('.modal-body').html(content);
            }
            var form = document.getElementById('editForm');
            form.action = `{{ route('admin.product.attribute-update','') }}/${item.id}`;
            modal.modal('show');
        });
    })(jQuery);

    function textContent(){
        return `
                    <div class="row single-attr">
                        <div class="col-xl-3 mt-3">
                            <div class="form-group">
                                <label>@lang('Name')</label>
                                <input type="text" placeholder="@lang('Type Here')..." class="form-control" name="text[${itr}][name]" required />
                            </div>
                        </div>

                        <div class="col-xl-3 mt-3">
                            <div class="form-group">
                                <label>@lang('Value')</label>
                                <input type="text" placeholder="@lang('Type Here')..." class="form-control" name="text[${itr}][value]" required />
                            </div>
                        </div>
                        <div class="col-xl-3 mt-3">
                            <label>@lang('Remove')</label>
                            <div class="form-group abs-form-group d-flex justify-content-between flex-wrap">
                                <button type="button" class="btn btn-danger removeBtn abs-button"><i class="la la-minus"></i></button>
                            </div>
                        </div>
                    </div>

            `;
    }

    function colorContent(){
        return `
                <div class="row single-attr">
                    <div class="col-xl-4 mt-3">
                        <div class="form-group"><label>@lang('Name')</label>
                            <input type="text" class="form-control" name="color[${itr}][name]" placeholder="@lang('Type Here')..." required />
                        </div>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label>@lang('Color')</label>
                        <div class="input-group">
                            <span class="input-group-addon ">
                                <input type='text' class="form-control colorPicker" value="e81f1f"/>
                            </span>
                            <input type="text" class="form-control colorCode" name="color[${itr}][value]" value="e81f1f" required/>
                        </div>
                    </div>
                    <div class="col-xl-4 mt-3">
                        <label>@lang('Remove')</label>
                        <div class="form-group abs-form-group d-flex justify-content-between flex-wrap">
                            <button type="button" class="btn btn-danger  removeBtn abs-button"><i class="la la-minus"></i></button>
                        </div>
                    </div>
                </div>
            `;
    }

    function imageContent(){
        return `
            <div class="row single-attr">
                <div class="col-xl-4 mt-3">
                    <div class="form-group">
                        <label>@lang('Name')</label>
                        <input type="text" class="form-control" name="img[${itr}][name]" placeholder="@lang('Type Here')..." required />
                    </div>
                </div>
                <div class="col-xl-4 mt-3">
                    <div class="form-group">
                        <label for="inputAttachments">@lang('Value')</label>
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input type="file" name="img[${itr}][value]" class="file-upload-field" accept=".png, .jpg, .jpeg" required/>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <label>@lang('Remove')</label>
                    <div class="form-group abs-form-group d-flex justify-content-between flex-wrap">
                        <button type="button" class="btn btn-danger removeBtn abs-button"><i class="la la-minus"></i></button>
                    </div>
                </div>
            </div>
            `;
    }

</script>

@endpush

@push('css')
<style>
.alert button.close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 12px;
}
.alert_message {
    padding: 12px;
    padding-right: 22px;
}
.alert_icon {
    padding: 13px 14px;
    background-color: rgba(0,0,0,.1);
}
.alert {
    display: flex;
    align-items: center;
    padding: 0;
    border: none;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    -ms-border-radius: 5px;
    -o-border-radius: 5px;
    overflow: hidden;
    align-items: stretch;
}
.sp-replacer {
    padding: 0;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 5px 0 0 5px;
    border-right: none;
}
.sp-preview {
    width: 70px;
    height: 38px;
    border: 0;
}
.sp-preview-inner {
    width: 110px;
}
.sp-dd{
    display: none;
}
.input-group > .form-control:not(:first-child) {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
}

.file-upload-wrapper:before {
    background: #5E50EE;
}

.file-upload-wrapper:hover:before {
    background: #5E50EE;
    opacity: 0.9;
}
</style>
@endpush
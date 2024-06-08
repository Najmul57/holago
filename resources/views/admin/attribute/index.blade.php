@extends('admin.layouts.master')
@section('content')
@section('title','Attribute')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('Name')</th>
						<th scope='col'>@lang('Value Type')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>
							
				<tbody>
					@forelse($attributes as $key => $attribute)
						<tr>
							<td scope='col'>{{ ++$key }}</td>
							<td scope='col'>{{__($attribute->name)}}</td>
							<td scope='col'>@if($attribute->value_type==1) @lang('Text')  @elseif($attribute->value_type==2) @lang('Color')  @else @lang('Image') @endif</td>
							<td scope='col'>
								@if($attribute->status == 1)
									<span class='badge badge-pill bg-gradient-success'>@lang('Enabled')</span>
								 @else
									<span class='badge badge-pill bg-gradient-danger'>@lang('Disable')</span>
								@endif
							</td>
							<td>
								<div class="align-items-center gap-3 fs-6">
									<button class="btn bg-gradient-info btn-sm icon-btn ml-1 editBtn"
										data-bs-toggle="modal"
										data-bs-target="#editModal"
										data-id="{{ __($attribute->id)}}"
										data-action="{{ route('admin.attribute.update',$attribute->id) }}"
										data-name="{{ __($attribute->name)}}"
										data-value_type="{{ __($attribute->value_type)}}">
										<i class="la la-pencil"></i>
									</button>
									@if($attribute->status == 1)
									<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
										data-bs-toggle="modal"
										data-bs-target="#disableModal"
										data-id="{{ __($attribute->id)}}"
										>
										<i class="la la-eye-slash"></i>
									</button>
									@else
									<button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
										data-bs-toggle="modal"
										data-bs-target="#enableModal"
										data-id="{{ __($attribute->id)}}"
										>
										<i class="la la-eye"></i>
									</button>
									@endif
								</div>
							</td>
						</tr>
						@empty
							<tr>
								<td class='text-muted text-center' colspan='100%'>@lang('Data Not Found')</td>
							</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@if($attributes->hasPages())
	<div class='card-footer'>
		{{ $attributes->links() }}
	</div>
@endif


{{-- NEW MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">"
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="createModalLabel"> @lang('Add New')</h4>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class='col-md-12'>
							<div class='form-row form-group mt-3'>
								<label for="name01" class='font-weight-bold form-label'>@lang('Name')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="name" id="name01" required>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="value_type01" class='font-weight-bold form-label'>@lang('Value_type')</label><span class='text-danger'>*</span>
								<select class="select2" name="value_type" required>
	                                <option value="" disabled selected>@lang('Select One')</option>
	                                <option value="1">@lang('Text')</option>
	                                <option value="2">@lang('Color')</option>
	                                <option value="3">@lang('Image')</option>
	                            </select>
							</div>
						</div>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-dark' data-bs-dismiss='modal'>@lang('Close')</button>
					<button type='submit' class='btn btn-primary' id='btn-save' value='add'>@lang('Save')</button>
				</div>
			</form>
		</div>
	</div>
</div>

{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">"
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="editModalLabel"> @lang('Add New')</h4>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class='col-md-12'>
							<div class='form-row form-group mt-3'>
								<label for="name01" class='font-weight-bold form-label'>@lang('Name')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="name" id="name01" required>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="value_type01" class='font-weight-bold form-label'>@lang('Value_type')</label><span class='text-danger'>*</span>
								<select class="select2" name="value_type" required>
	                                <option value="" disabled selected>@lang('Select One')</option>
	                                <option value="1">@lang('Text')</option>
	                                <option value="2">@lang('Color')</option>
	                                <option value="3">@lang('Image')</option>
	                            </select>
							</div>
						</div>
					</div>
				</div>
				<div class='modal-footer'>
					<button type='button' class='btn btn-dark' data-bs-dismiss='modal'>@lang('Close')</button>
					<button type='submit' class='btn btn-primary' id='btn-save' value='add'>@lang('Save')</button>
				</div>
			</form>
		</div>
	</div>
</div>

{{-- Enable --}}
<div id="enableModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">@lang('Attribute Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.attribute.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this attribute?')</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
					<button type="submit" class="btn btn-primary">@lang('Yes')</button>
				</div>
			</form>
		</div>
	</div>
</div>

{{-- Disable --}}
<div id="disableModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">@lang('Attribute Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.attribute.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this attribute?')</p>
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

@push('top-area')
	<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'><i class='lab la-telegram-plane'></i> @lang('Add Attribute')</button>
@endpush
@push('css')
<style>
	.select2-dropdown{
		z-index: 9999999;
	}
</style>
@endpush
@push('js')
	<script>
		(function($){
			"use strict";
			
			$('.editBtn').on('click',function(){
				var editModal = $('#editModal');
				var type      = $(this).data('value_type');
				var attribute = type==1?'Text':type==2?'Color':'Image';		
				editModal.find('input[name=name]').val($(this).data('name'));
				editModal.find('select[name=value_type]').val($(this).data('value_type'));
	            editModal.find('select[name=type]').val(type);
	            editModal.find('.select2-selection__rendered').text(attribute);

				editModal.find('form').attr('action',$(this).data('action'));
			});
			$('.enableBtn').on('click', function () {
				var modal = $('#enableModal');
				modal.find('input[name=id]').val($(this).data('id'));
			});
			$('.disableBtn').on('click', function () {
				var modal = $('#disableModal');
				modal.find('input[name=id]').val($(this).data('id'));
			});
		})(jQuery);
	</script>
@endpush
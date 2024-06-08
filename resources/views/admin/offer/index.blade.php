@extends('admin.layouts.master')
@section('content')
@section('title','Offer')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('name')</th>
						<th scope='col'>@lang('discount_type')</th>
						<th scope='col'>@lang('amount')</th>
						<th scope='col'>@lang('start_date')</th>
						<th scope='col'>@lang('end_date')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>
							
				<tbody>
					@forelse($offers as $key => $offer)
						<tr>
							<td scope='col'>{{ ++$key }}</td>
							<td scope='col'>{{__($offer->name)}}</td>
						<td scope='col'>{{__($offer->discount_type)}}</td>
						<td scope='col'>{{__($offer->amount)}}</td>
						<td scope='col'>{{__($offer->start_date)}}</td>
						<td scope='col'>{{__($offer->end_date)}}</td>
						<td scope='col'>
								@if($offer->status == 1)
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
										data-id="{{ __($offer->id)}}"
										data-action="{{ route('admin.offer.update',$offer->id) }}"
										data-name="{{ __($offer->name)}}"
										data-discount_type="{{ __($offer->discount_type)}}"
										data-amount="{{ __($offer->amount)}}"
										data-start_date="{{ __($offer->start_date)}}"
										data-end_date="{{ __($offer->end_date)}}">
										<i class="la la-pencil"></i>
									</button>
									@if($offer->status == 1)
									<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
										data-bs-toggle="modal"
										data-bs-target="#disableModal"
										data-id="{{ __($offer->id)}}"
										>
										<i class="la la-eye-slash"></i>
									</button>
									@else
									<button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
										data-bs-toggle="modal"
										data-bs-target="#enableModal"
										data-id="{{ __($offer->id)}}"
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
@if($offers->hasPages())
	<div class='card-footer'>
		{{ $offers->links() }}
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
								<label for="discount_type01" class='font-weight-bold form-label'>@lang('Discount_type')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="discount_type" id="discount_type01" required>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="amount01" class='font-weight-bold form-label'>@lang('Amount')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="amount" id="amount01" required>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="start_date01" class='font-weight-bold form-label'>@lang('Start_date')</label>
								<input type="text" class="form-control" name="start_date" id="start_date01" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="end_date01" class='font-weight-bold form-label'>@lang('End_date')</label>
								<input type="text" class="form-control" name="end_date" id="end_date01" >
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
								<label for="discount_type01" class='font-weight-bold form-label'>@lang('Discount_type')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="discount_type" id="discount_type01" required>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="amount01" class='font-weight-bold form-label'>@lang('Amount')</label><span class='text-danger'>*</span>
								<input type="text" class="form-control" name="amount" id="amount01" required>
							</div>
							<div class='form-row form-group mt-3'>
								<label for="start_date01" class='font-weight-bold form-label'>@lang('Start_date')</label>
								<input type="text" class="form-control" name="start_date" id="start_date01" >
							</div>
							<div class='form-row form-group mt-3'>
								<label for="end_date01" class='font-weight-bold form-label'>@lang('End_date')</label>
								<input type="text" class="form-control" name="end_date" id="end_date01" >
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
				<h5 class="modal-title">@lang('Offer Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.offer.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this offer?')</p>
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
				<h5 class="modal-title">@lang('Offer Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.offer.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this offer?')</p>
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
	<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#createModal'><i class='lab la-telegram-plane'></i> @lang('Add Offer')</button>
@endpush
@push('js')
	<script>
		(function($){
			"use strict";
			
			$('.editBtn').on('click',function(){
				var editModal = $('#editModal');			
				editModal.find('input[name=name]').val($(this).data('name'));
			
				editModal.find('input[name=discount_type]').val($(this).data('discount_type'));
			
				editModal.find('input[name=amount]').val($(this).data('amount'));
			
				editModal.find('input[name=start_date]').val($(this).data('start_date'));
			
				editModal.find('input[name=end_date]').val($(this).data('end_date'));
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
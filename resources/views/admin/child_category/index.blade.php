@extends('admin.layouts.master')
@section('content')
@section('title','Child_category')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('Subcategory')</th>
						<th scope='col'>@lang('name')</th>
						<th scope='col'>@lang('icon')</th>
						<th scope='col'>@lang('meta_title')</th>
						<th scope='col'>@lang('meta_keywords')</th>
						<th scope='col'>@lang('top_category')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>
							
				<tbody>
					@forelse($child_categories as $key => $child_category)
						<tr>
							<td scope='col'>{{ ++$key }}</td>
								<td scope='col'>{{ isset($child_category->subcategory) ? __($child_category->subcategory) : 'N/A' }}</td>
						<td scope='col'>{{__($child_category->name)}}</td>
						<td scope='col'>{{__($child_category->icon)}}</td>
						<td scope='col'>{{__($child_category->meta_title)}}</td>
						<td scope='col'>{{__($child_category->meta_keywords)}}</td>
						<td scope='col'>{{__($child_category->top_category)}}</td>
						<td scope='col'>
								@if($child_category->status == 1)
									<span class='badge badge-pill bg-gradient-success'>@lang('Enabled')</span>
								 @else
									<span class='badge badge-pill bg-gradient-danger'>@lang('Disable')</span>
								@endif
							</td>
							<td scope='col'>
								<div class="align-items-center gap-3 fs-6">
									<a href="{{ route('admin.child_category.edit',$child_category->id)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1" title="Edit"><i class="las la-edit"></i></a>
							@if($child_category->status == 1)
									<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
										data-bs-toggle="modal"
										data-bs-target="#disableModal"
										data-id="{{ __($child_category->id)}}"
										>
										<i class="la la-eye-slash"></i>
									</button>
									@else
									<button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
										data-bs-toggle="modal"
										data-bs-target="#enableModal"
										data-id="{{ __($child_category->id)}}"
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
@if($child_categories->hasPages())
	<div class='card-footer'>
		{{ $child_categories->links() }}
	</div>
@endif


{{-- NEW MODAL --}}


{{-- EDIT MODAL --}}


{{-- Enable --}}
<div id="enableModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">@lang('Child_category Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.child_category.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this child_category?')</p>
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
				<h5 class="modal-title">@lang('Child_category Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.child_category.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this child_category?')</p>
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
@push("top-area")
	<a href="{{ route('admin.child_category.create') }}" class="btn btn-primary btn-sm"><i class="lab la-telegram-plane"></i>@lang("Add Child_category")</a>
@endpush
@push('js')
	<script>
		(function($){
			"use strict";
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
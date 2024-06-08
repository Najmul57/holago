@extends('admin.layouts.master')
@section('content')
@section('title','Customer')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('first_name')</th>
						<th scope='col'>@lang('last_name')</th>
						<th scope='col'>@lang('username')</th>
						<th scope='col'>@lang('email')</th>
						<th scope='col'>@lang('password')</th>
						<th scope='col'>@lang('phone_number')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>
							
				<tbody>
					@forelse($customers as $key => $customer)
						<tr>
							<td scope='col'>{{ ++$key }}</td>
							<td scope='col'>{{__($customer->first_name)}}</td>
						<td scope='col'>{{__($customer->last_name)}}</td>
						<td scope='col'>{{__($customer->username)}}</td>
						<td scope='col'>{{__($customer->email)}}</td>
						<td scope='col'>{{__($customer->password)}}</td>
						<td scope='col'>{{__($customer->phone_number)}}</td>
						<td scope='col'>
								@if($customer->status == 1)
									<span class='badge badge-pill bg-gradient-success'>@lang('Enabled')</span>
								 @else
									<span class='badge badge-pill bg-gradient-danger'>@lang('Disable')</span>
								@endif
							</td>
							<td scope='col'>
								<div class="align-items-center gap-3 fs-6">
									<a href="{{ route('admin.customer.edit',$customer->id)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1" title="Edit"><i class="las la-edit"></i></a>
							@if($customer->status == 1)
									<button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
										data-bs-toggle="modal"
										data-bs-target="#disableModal"
										data-id="{{ __($customer->id)}}"
										>
										<i class="la la-eye-slash"></i>
									</button>
									@else
									<button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
										data-bs-toggle="modal"
										data-bs-target="#enableModal"
										data-id="{{ __($customer->id)}}"
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
@if($customers->hasPages())
	<div class='card-footer'>
		{{ $customers->links() }}
	</div>
@endif


{{-- NEW MODAL --}}


{{-- EDIT MODAL --}}


{{-- Enable --}}
<div id="enableModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">@lang('Customer Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.customer.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this customer?')</p>
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
				<h5 class="modal-title">@lang('Customer Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.customer.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this customer?')</p>
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
	<a href="{{ route('admin.customer.create') }}" class="btn btn-primary btn-sm"><i class="lab la-telegram-plane"></i>@lang("Add Customer")</a>
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
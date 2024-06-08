@extends('admin.layouts.master')
@section('content')
@section('title','Order List')
<div class='card mt-3'>
	<div class='card-body'>
		<div class='table-responsive'>
			<table class='table align-middle mb-0'>
				<thead class='table-light'>
					<tr>
						<th scope='col'>@lang('ID')</th>
						<th scope='col'>@lang('order_number')</th>
						<th scope='col'>@lang('Date & Time')</th>
						<th scope='col'>@lang('Customer')</th>
						<th scope='col'>@lang('Customer Phone')</th>
						<th scope='col'>@lang('shipping_charge')</th>
						<th scope='col'>@lang('total_amount')</th>
						<th scope='col'>@lang('Status')</th>
						<th scope='col'>@lang('Action')</th>
					</tr>
				</thead>

				<tbody>
					@forelse($orders as $key => $order)
                        @php
                            $jsonData = $order->shipping_address;
                            $data = $jsonData;
                        @endphp
						<tr>

							<td scope='col'>{{ ++$key }}</td>
							<td scope='col'>{{__($order->order_number)}}</td>
							<td scope='col'>{{ $order->created_at->format('F j, Y h:i A') }} ({{ $order->created_at->diffForHumans()}})</td>
							<td scope='col'>{{ $order->customer->first_name ?? $data['name'] ?? 'N/A' }} </td>
							<td scope='col'>{{ $data['mobile'] ?? 'N/A' }} </td>
							{{-- <td scope='col'>
                                <p>Name: {{ $data['name'] }}</p>
                                <p>Mobile: {{ $data['mobile'] }}</p>
                                <p>Email: {{ $data['email'] }}</p>
                                <p>District ID: {{ $data['district_id'] }}</p>
                                <p>Address: {{ $data['address'] }}</p>
                                <p>Shipping Place: {{ $data['shipping_place'] }}</p>
                                <p>Note: {{ $data['note'] }}</p>
                            </td> --}}

                            <td scope='col'>{{ __($setting->currency_symbol)}}{{__($order->shipping_charge)}}</td>
                            <td scope='col'> {{ __($setting->currency_symbol)}}{{__(number_format($order->total_amount,2))}}</td>
                             <td scope='col'>
                                    @if($order->status == 1)
                                     <span class='badge badge-pill bg-gradient-warning'>@lang('Pending')</span>
                                     @elseif($order->status == 2)
                                     <span class='badge badge-pill bg-gradient-success'>@lang('Confirm')</span>
                                     @elseif($order->status == 3)
                                     <span class='badge badge-pill bg-gradient-royal'>@lang('Processing')</span>
                                     @elseif($order->status == 4)
                                     <span class='badge badge-pill bg-gradient-danger'>@lang('Cancelled')</span>
                                     @elseif($order->status == 5)
                                        <span class='badge badge-pill bg-gradient-info'>@lang('Delivered')</span>
                                     @elseif($order->status == 6)
                                        <span class='badge badge-pill bg-gradient-danger'>@lang('On Hold')</span>
                                     @elseif($order->status == 7)
                                        <span class='badge badge-pill bg-gradient-success'>@lang('Shipped')</span>
                                    @else
                                        <span class='badge badge-pill bg-gradient-danger'>@lang('N/A')</span>
                                    @endif
                            </td>
							<td scope='col'>
								<div class="align-items-center gap-3 fs-6">
                                    <a href="{{ route('admin.order.show',$order->id)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1" title="show details"><i class="las la-eye"></i></a>
									<a href="{{ route('admin.order.edit',$order->id)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1" title="Edit"><i class="las la-edit"></i></a>
										<a href="{{ route('admin.order.delete',$order->id)}}" class="btn bg-gradient-danger btn-sm icon-btn ml-1" title="delete"><i class="las la-trash"></i></a>
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
@if($orders->hasPages())
	<div class='card-footer'>
		{{ $orders->links() }}
	</div>
@endif


{{-- NEW MODAL --}}


{{-- EDIT MODAL --}}


{{-- Enable --}}
<div id="enableModal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">@lang('Order Enable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.order.enable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to Enable this order?')</p>
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
				<h5 class="modal-title">@lang('Order Disable Confirmation')</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.order.disable') }}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<p>@lang('Are you sure to disable this order?')</p>
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
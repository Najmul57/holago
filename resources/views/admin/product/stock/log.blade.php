@extends('admin.layouts.master')
@section('content')
@section('title',$title)
<div class='card mt-3'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table align-middle mb-0'>
                <thead class='table-light'>
                    <tr>
                        <th>@lang('SN.')</th>
                        <th class="text-center">@lang('Quantity')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Created At')</th>
                    </tr>
                </thead>
                <tbody class="list">
                    @forelse($stock_logs as $log)
                    <tr>
                        <td data-label="@lang('SN.')">{{$loop->iteration}}</td>
                        <td data-label="@lang('Quantity')" class="text-center">
                            <span class="badge badge-pill bg-gradient-{{$log->quantity>0?'success':'danger'}} ">
                                {{ sprintf('%2d',$log->quantity)}}
                            </span>
                        </td>
                        <td data-label="@lang('Description')">
                            {{$log->type==1?'Updated by admin':'Sold'}}
                        </td>
                        <td data-label="@lang('Created At')">{{ showDateTime($log->created_at) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@if($stock_logs->hasPages())
    <div class='card-footer'>
        {{ $stock_logs->links() }}
    </div>
@endif

@endsection

@push('top-area')
<a href="{{ route('admin.product.stock.create', $product_stock->product->id) }}" class="btn btn-sm btn-primary box-shadow1 text-small"><i class="las la-backward"></i>@lang('Go Back')</a>
@endpush

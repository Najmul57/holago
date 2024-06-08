@extends('admin.layouts.master')
@section('content')
@section('title','Purchase List')

 <div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Company')</th>
                        <th>@lang('Gateway Name')</th>
                        <th>@lang('Trx Number')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Status')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchses as $purchse)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ __($purchse->company->name) }}</td>
                            <td>{{ __($purchse->plan->name) }}</td>
                            <td>{{ __($purchse->trx_number) }}</td>
                            <td>{{ __($purchse->amount) }} {{ $setting->site_currency }}</td>
                            <td>
                            	@if($purchse->status == 0)
                                    <span class="badge badge-pill bg-gradient-warning">@lang('Unpaid')</span>
                                @elseif($purchse->status == 1)
                                    <span class="badge badge-pill bg-gradient-success">@lang('Paid')</span>
                                @else
                                    <span class="badge badge-pill bg-gradient-danger">@lang('Expired')</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="100%">@lang('Data not found')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($purchses->hasPages())
    <div class="card-footer">
        {{ $purchses->links() }}
    </div>
    @endif
</div>

@endsection
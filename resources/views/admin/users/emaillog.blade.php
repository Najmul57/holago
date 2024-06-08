@extends('admin.layouts.master')
@section('content')
@section('title',$title)

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('User')</th>
                        <th>@lang('Sent')</th>
                        <th>@lang('Mail Sender')</th>
                        <th>@lang('Subject')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>
                            <span class="font-weight-bold">{{ $log->user->fullname() }}</span>
                                <br>
                            <span class="small">
                                <a href="{{ route('admin.users.details', $log->user_id) }}"><span>@</span>{{ $log->user->username }}</a>
                            </span>
                        </td>
                        <td>
                            {{ showDateTime($log->created_at) }}
                            <br>
                            {{ $log->created_at->diffForHumans() }}
                        </td>
                        <td>
                            <span class="font-weight-bold">{{ __($log->mail_sender) }}</span>
                        </td>
                        <td>{{ __($log->subject) }}</td>
                        <td>
                            <a href="{{ route('admin.users.email.details',$log->id) }}" class="btn bg-gradient-info btn-sm icon-btn ml-1" target="_blank"><i class="las la-info-circle"></i></a>
                        </td>
                    </tr>
                	@empty
	                    <tr>
	                        <td class="text-muted text-center" colspan="100%">@lang('Data not found')</td>
	                    </tr>
                	@endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
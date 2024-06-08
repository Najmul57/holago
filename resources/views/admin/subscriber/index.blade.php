@extends('admin.layouts.master')
@section('content')
@section('title','Subscribers')

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('SL')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $subscriber->email }}</td>
							<td>
								<button class="btn btn-sm bg-gradient-danger deleteSub" data-action="{{ route('admin.subscriber.delete',$subscriber->id) }}" data-bs-toggle="modal" data-bs-target="#DelModal"><i class="las la-trash"></i></button>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="100%" class="no-data-found-text">@lang('Subscriber not found')</td>
						</tr>
					@endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($subscribers->hasPages())
    <div class="card-footer">
        {{ $subscribers->links() }}
    </div>
    @endif
</div>

{{-- DELETE MODAL --}}
<div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="DelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="DelModalLabel">@lang('Delete')!</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <strong>@lang('Are you sure to delete?')</strong>
            </div>
            <form action="" method="post">
                @csrf
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-danger ">@lang('Delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('top-area')
    <a href="{{ route('admin.subscriber.sendMail')}}" class="btn btn-primary btn-sm">@lang('Send Email')</a>
@endpush

@push('js')
    <script>
        (function($){
            "use strict";
            $('.deleteSub').on('click',function(){
            var deleteModal = $('#DelModal');
            deleteModal.find('form').attr('action',$(this).data('action'));
            });
        })(jQuery);
    </script>
@endpush
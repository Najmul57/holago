@extends('admin.layouts.master')
@section('content')
@section('title',$title)
<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('Key')
                        </th>
                        <th class="text-left">
                            {{__($lang->name)}}
                        </th>

                        <th class="w-85">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($json as $k => $language)
	                <tr>
	                    <td data-label="@lang('key')" class="white-space-wrap">{{$k}}</td>
	                    <td data-label="@lang('Value')" class="text-left white-space-wrap">{{$language}}</td>


	                    <td data-label="@lang('Action')">
	                        <a href="javascript:void(0)"
	                           data-bs-target="#editModal"
	                           data-bs-toggle="modal"
	                           data-title="{{$k}}"
	                           data-key="{{$k}}"
	                           data-value="{{$language}}"
	                           class="editModal icon-btn ml-1 btn bg-gradient-info"
	                           data-original-title="@lang('Edit')">
	                            <i class="la la-pencil"></i>
	                        </a>

	                        <a href="javascript:void(0)"
	                           data-key="{{$k}}"
	                           data-value="{{$language}}"
	                           data-bs-toggle="modal" 
	                           data-bs-target="#DelModal"
	                           class="deleteKey icon-btn btn--danger ml-1 btn bg-gradient-danger"
	                           data-original-title="@lang('Delete')">
	                            <i class="la la-trash"></i>
	                        </a>
	                    </td>
	                </tr>
	            @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- NEW MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel">@lang('Add New')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form class="form-horizontal" action="{{route('admin.language.store.key',$lang->id)}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-row form-group">
                        <label class="font-weight-bold form-label">@lang('Key') <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="key" name="key" placeholder="@lang('Key')" value="{{old('key')}}">
                        </div>
                    </div>

                    <div class="form-row form-group mt-3">
                        <label class="font-weight-bold form-label">@lang('Value') <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control"  id="value" name="value" placeholder="@lang('Value')" value="{{old('value')}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary" id="btn-save" value="add">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- EDIT MODAL --}}
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">@lang('Edit')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>

            <form action="{{route('admin.language.update.key',$lang->id)}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="inputName" class="form-label form-title fs-6 fw-bold"></label> <span class="text-danger">*</span>
                        <input type="text" class="form-control form-control" name="value" placeholder="@lang('Value')">
                    </div>
                    <input type="hidden" name="key">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                </div>
            </form>

        </div>
    </div>
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
            <form action="{{route('admin.language.delete.key',$lang->id)}}" method="post">
                @csrf
                <input type="hidden" name="key">
                <input type="hidden" name="value">
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
<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">@lang('Add New Key')</button>
@endpush

@push('js')
    <script>
        (function($){
            "use strict";
            $('.editModal').on('click',function(){
            var modal = $('#editModal');
            modal.find('.form-title').text($(this).data('title'));
            modal.find('input[name=key]').val($(this).data('key'));
            modal.find('input[name=value]').val($(this).data('value'));
            modal.find('form').attr('action',$(this).data('action'));

        });

            $('.deleteKey').on('click',function(){
            var deleteModal = $('#DelModal');
            deleteModal.find('input[name=key]').val($(this).data('key'));
            deleteModal.find('input[name=value]').val($(this).data('value'));
            });
        })(jQuery);
    </script>
@endpush
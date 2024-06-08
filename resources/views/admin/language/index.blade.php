@extends('admin.layouts.master')
@section('content')
@section('title','Language Manager')

 <div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Code')</th>
                        <th>@lang('Default')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($languages as $language)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <div class="product-box border">
                                        <img src="{{ displayImage('assets/images/language/'.@$language->icon) }}" alt="">
                                    </div>
                                    <div class="product-info">
                                        <span class="product-name mb-1">{{ __($language->name) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $language->lang_code }}</td>
                            <td>
                                @if($language->is_default == 1)
                                    <span class="badge badge-pill bg-gradient-success">@lang('Default')</span>
                                @else
                                    <span class="badge badge-pill bg-gradient-danger">@lang('Not Default')</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn bg-gradient-info btn-sm  icon-btn ml-1 editBtn"
                                    data-id="{{ __($language->id) }}"
                                    data-name="{{ __($language->name) }}"
                                    data-is_default="{{ __($language->is_default) }}" 
                                    data-lang_code="{{ __($language->lang_code) }}" 
                                    data-icon="{{ displayImage('assets/images/language/'.$language->icon) }}" 
                                    data-action="{{ route('admin.language.edit',$language->id) }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editLanguageModal"
                                    data-toggle="tooltip"
                                    data-original-title="@lang('Configure')">
                                    <i class="la la-pencil"></i>
                                </button>
                                <a href="{{ route('admin.language.translate',$language->id) }}" class="btn bg-gradient-success btn-sm icon-btn ml-1"><i class="fas fa-language"></i></a>
                                @if($language->lang_code != 'en')
                                <button class="btn bg-gradient-danger btn-sm icon-btn ml-1 deleteBtn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal" 
                                    data-id="{{ __($language->id)}}"
                                    data-name="{{ __($language->name)}}"
                                    data-action="{{ route('admin.language.delete',$language->id) }}">
                                    <i class="la la-trash"></i>
                                </button>
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
</div>

{{-- NEW MODAL --}}
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="createModalLabel"> @lang('Add New Language')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form class="form-horizontal" method="post" action="{{ route('admin.language.create')}}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-row form-group">
                                <label class="font-weight-bold form-label">@lang('Language Name') <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="code" name="name" placeholder="@lang('e.g. Japaneese, Portuguese')" required>
                                </div>
                            </div>

                            <div class="form-row form-group mt-3">
                                <label class="font-weight-bold form-label">@lang('Language Code') <span class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="link" name="code" placeholder="@lang('e.g. jp, pt-br')" required>
                                </div>
                            </div>

                            <div class="form-row form-group mt-3">
                                <div class="col-md-12">
                                    <label for="inputName" class="form-label">@lang('Default Language') <span class="text-danger">*</span></label>
                                    <input type="checkbox" name="default" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger"  data-on="@lang('SET')" data-off="@lang('UNSET')" name="default" data-size="normal">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload-area">
                                    <img id="preview" src="{{ displayImage('assets/images/default.jpg') }}" alt="Gateway Image"/>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input upload-image" id="upload">
                                        <label class="pick-image" for="upload">@lang('Upload')</label>
                                    </div>
                                </div>
                            </div>
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
<div class="modal fade" id="editLanguageModal" tabindex="-1" role="dialog" aria-labelledby="editLanguageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editLanguageModal">@lang('Edit Language'): <span class="language-code"></span></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="" method="post"enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-row">
                                <label for="inputName" class="form-label">@lang('Language Name') <span class="text-danger">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="inputName" class="form-label">@lang('Default Language') <span class="text-danger">*</span></label>
                                <input type="checkbox" name="is_default" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="@lang('SET')" data-off="@lang('UNSET')" data-size="normal">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="image-upload-area">
                                    <img id="preview" src="{{ displayImage('assets/images/default.jpg') }}" alt="Language Image"/>
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input upload-image" id="upload1">
                                        <label class="pick-image" for="upload1">@lang('Upload')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary" id="btn-save" value="add">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- DELETE MODAL --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModal">@lang('Delete Language'): <span class="language-name"></span></h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">@lang('Are you sure to delete?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-danger">@lang('Delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('top-area')
<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">@lang('Add New Language')</button>
@endpush

@push('js')
    <script>
        (function($){
            "use strict";
            $('.editBtn').on('click',function(){
            var editModal = $('#editLanguageModal');
            editModal.find('#preview').attr('src',$(this).data('icon'));
            editModal.find('.language-code').text($(this).data('lang_code'));
            editModal.find('input[name=name]').val($(this).data('name'));
            if ($(this).data('is_default') == 1) {
                editModal.find('input[name=is_default]').bootstrapToggle('on')
            }
            editModal.find('form').attr('action',$(this).data('action'));

        });

            $('.deleteBtn').on('click',function(){
            var deleteModal = $('#deleteModal');
            deleteModal.find('.language-name').text($(this).data('name'));
            deleteModal.find('form').attr('action',$(this).data('action'));
            });
        })(jQuery);
    </script>
@endpush
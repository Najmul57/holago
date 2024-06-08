@extends('admin.layouts.master')
@section('content')
@section('title',$title)
<div class='row mt-3'>
    <div class='col-12 col-lg-12'>
        <div class='card shadow-sm border-0'>
            <div class="card-header">
                <h4 class="text-white">@lang('Product Name') : {{ __($product_name) }}</h4>
                <h5 class="text-white">@lang('Attribute Name') : {{ __($variant->name) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card shadow-none border">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-field">
                        @if(count($images))
                        <h5 class="mb-2">@lang('Click inside the box below to add more images')</h5>
                        @endif
                        <div class="input-images"></div>
                        <small class="form-text text-muted">
                            <i class="las la-info-circle"></i> @lang('You can only upload a maximum of 6 images')</label>
                        </small>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-block btn-primary mt-3">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('top-area')
<a href="{{ route('admin.product.attribute-add', $variant->product->id) }}" class="btn btn-sm btn-primary box-shadow1 text-small"><i class="la la-backward"></i>@lang('Go Back')</a>
@endpush

@push('css')
<style>
    .image-uploader .upload-text {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>
@endpush
@push('js-link')
<script src="{{ asset('assets/admin/js/image-uploader.min.js') }}"></script>
@endpush

@push('css-link')
<link href="https://fonts.googleapis.com/css?family=Lato:300,700|Montserrat:300,400,500,600,700|Source+Code+Pro&display=swap"
rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/admin/css/image-uploader.min.css') }}">
@endpush


@push('js')
<script>

    'use strict';
    (function($){

        var dropdownParent = $('.has-select2');

        @if(isset($images))
            let preloaded = @json($images);
        @else
            let preloaded = [];
        @endif

        $('.input-images').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'photos',
            preloadedInputName: 'old',
            maxFiles: 6
        });

        $(document).on('input', 'input[name="images[]"]', function(){
            var fileUpload = $("input[type='file']");
            if (parseInt(fileUpload.get(0).files.length) > 6){
                $('#errorModal').modal('show');
            }
        });

    })(jQuery)

</script>
@endpush
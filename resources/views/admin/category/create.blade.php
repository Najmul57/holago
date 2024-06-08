@extends('admin.layouts.master')
@section('content')
@section('title', 'Category')
<style>
    .tip-background {
        display: none;
    }
</style>

<div class='row mt-3'>
    <div class='col-12 col-lg-12'>
        <div class='card shadow-sm border-0'>
            <div class='card-body'>
                <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-none border">
                        <div class="card-header">
                            <h6 class="mb-0">@lang('Category Section')</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class='col-md-8'>
                                    <div class='form-row form-group mt-3'>
                                        <label for="name01"
                                            class='font-weight-bold form-label'>@lang('Name')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="name" id="name01"
                                            required>
                                    </div>
                                      <div class='form-row form-group mt-3'>
                                        <label for="slug"
                                            class='font-weight-bold form-label'>@lang('Slug')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="slug" id="slug"
                                            required>
                                    </div>

                                     <div class='form-row form-group mt-3'>
                                        <label for="name01"
                                            class='font-weight-bold form-label'>@lang('Tip Text')</label><span
                                            class='text-danger'></span>
                                        <input type="text" class="form-control" name="tip_text" id="">
                                    </div>
                                      <div class="form-check mt-4">
                                        <input class="form-check-input" name="tip_status" type="checkbox" value="1" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                         Do you want Tip Background??
                                        </label>
                                      </div>

                                    <div class='form-row form-group mt-3 tip-background'>
                                        <label for="name01" class='font-weight-bold form-label'>@lang('Tip Background')</label>
                                        <span class='text-danger'></span>
                                        <input type="color" class="form-control" name="tip_bg" id="">
                                    </div>

                                    <!--<div class='form-row form-group mt-3'>-->
                                    <!--    <label for="name01"-->
                                    <!--        class='font-weight-bold form-label'>@lang('Tip Background')</label><span-->
                                    <!--        class='text-danger'></span>-->
                                    <!--    <input type="color" class="form-control" name="tip_bg" id="">-->
                                    <!--</div>-->
                                    <div class='form-row form-group mt-3'>
                                        <label for="meta_title01"
                                            class='font-weight-bold form-label'>@lang('Meta Title')</label>
                                        <input type="text" class="form-control" name="meta_title" id="meta_title01">
                                    </div>
                                    <div class='form-row form-group mt-3'>
                                        <label for="meta_description01"
                                            class='font-weight-bold form-label'>@lang('Meta Description')</label>
                                        <textarea class="form-control " rows="5" name="meta_description"></textarea>
                                    </div>
                                    <div class='form-row form-group mt-3'>
                                        <label for="meta_keywords01"
                                            class='font-weight-bold form-label'>@lang('Meta Keywords')</label>
                                        <select class="select2-auto-tokenize form-control" name="meta_keywords[]"
                                            multiple="multiple">
                                        </select>
                                    </div>
                                    <div class="form-group row pe-0 mt-3">
                                        <div class="form-group col-md-4 pe-0">
                                            <label class="form-label fw-bold">@lang('Top Category')</label>
                                            <div class="">
                                                <input type="checkbox" name="top_category" data-width="100%"
                                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                    data-on="Yes" data-off="No" data-size="normal">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 pe-0">
                                            <label class="form-label fw-bold">@lang('Special Category')</label>
                                            <div class="">
                                                <input type="checkbox" name="special_category" data-width="100%"
                                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                    data-on="Yes" data-off="No" data-size="normal">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 pe-0">
                                            <label class="form-label fw-bold">@lang('Filter Category')</label>
                                            <div class="">
                                                <input type="checkbox" name="filter_category" data-width="100%"
                                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                    data-on="Yes" data-off="No" data-size="normal">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <div class='image-upload-area'>
                                            <img id='preview' src="{{ displayImage('assets/images/default.jpg') }}"
                                                alt='Image' />
                                            <div class='custom-file'>
                                                <input type='file' name='image'
                                                    class='custom-file-input upload-image' id='upload1'>
                                                <label class='pick-image' for='upload1'>@lang('Upload')</label>
                                            </div>
                                        </div>
                                        <small class="fw-bold text-center">Supported files: jpg,jpeg,png. Image will be
                                            re-size into: 359x538px</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    document.getElementById('name01').addEventListener('input', function () {
        // Get the value from the "name" input
        var nameValue = this.value;

        // Replace spaces with hyphens and convert to lowercase for a basic slug
        var slugValue = nameValue.toLowerCase().replace(/\s+/g, '-');

        // Update the value of the "slug" input
        document.getElementById('slug').value = slugValue;
 });
</script>
<script>
    $(document).ready(function () {

        updateTipBackgroundVisibility();

        $("#flexCheckDefault").on("click", function () {
            updateTipBackgroundVisibility();
        });

        function updateTipBackgroundVisibility() {
            if ($("#flexCheckDefault").prop("checked")) {
                $(".tip-background").show();
            } else {
                $(".tip-background").hide();
            }
        }
    });
</script>
@endsection
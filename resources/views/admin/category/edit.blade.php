@extends('admin.layouts.master')
@section('content')
@section('title', 'Category')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
    .tip-background {
        display: none;
    }
</style>

<div class='row mt-3'>
    <div class='col-12 col-lg-12'>
        <div class='card shadow-sm border-0'>
            <div class='card-body'>
                <form action="{{ route('admin.category.update', $category->id) }}" method="post"
                    enctype="multipart/form-data">
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
                                        <input type="text" class="form-control" name="name"
                                            value="{{ __($category->name) }}" id="name01" required>
                                    </div>
                                    <div class='form-row form-group mt-3'>
                                        <label for="name01"
                                            class='font-weight-bold form-label'>@lang('Slug')</label><span
                                            class='text-danger'>*</span>
                                        <input type="text" class="form-control" name="slug"
                                            value="{{ __($category->slug) }}" id="slug" required>
                                    </div>

                                       <div class='form-row form-group mt-3'>
                                        <label for="name01"
                                            class='font-weight-bold form-label'>@lang('Tip Text')</label><span
                                            class='text-danger'></span>
                                        <input type="text" class="form-control" name="tip_text" value="{{ __($category->tip_text ?? '') }}" id="name01">
                                    </div>
                                    <!--<div class='form-row form-group mt-3'>-->
                                    <!--    <label for="name01"-->
                                    <!--        class='font-weight-bold form-label'>@lang('Tip Background')</label><span-->
                                    <!--        class='text-danger'></span>-->
                                    <!--    <input type="color" class="form-control" name="tip_bg" value="{{ __($category->tip_bg ?? '') }}" id="name01">-->
                                    <!--</div>-->
                                    
                                

                                    
                                      <div class="form-check mt-4">
                                        <input class="form-check-input" name="tip_status" type="checkbox" value="1" {{ $category->tip_status == 1 ? 'checked' : '' }} id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Do you want Tip Background??
                                        </label>
                                    </div>

                                    <div class="tip-background form-row form-group mt-3" style="{{ $category->tip_status == 1 ? '' : 'display:none;' }}">
                                        <label for="name01" class="font-weight-bold form-label">@lang('Tip Background')</label>
                                        <span class="text-danger"></span>
                                        <input type="color" class="form-control" name="tip_bg" value="{{ old('tip_bg', $category->tip_bg) }}" id="name01">
                                    </div>

                                    <div class='form-row form-group mt-3'>
                                        <label for="meta_title01"
                                            class='font-weight-bold form-label'>@lang('Meta_title')</label>
                                        <input type="text" class="form-control" name="meta_title"
                                            value="{{ __($category->meta_title) }}" id="meta_title01">
                                    </div>
                                    <div class='form-row form-group mt-3'>
                                        <label for="meta_description01"
                                            class='font-weight-bold form-label'>@lang('Meta_description')</label>
                                        <textarea class="form-control " rows="5" name="meta_description"><?php echo $category->meta_description; ?></textarea>
                                    </div>
                                    <div class='form-row form-group mt-3'>
                                        <label for="meta_keywords01"
                                            class='font-weight-bold form-label'>@lang('Meta_keywords')</label>
                                        <select class="select2-auto-tokenize form-control" name="meta_keywords[]"
                                            multiple="multiple">
                                            @if (@$category->meta_keywords)
                                                @foreach ($category->meta_keywords as $keyword)
                                                    <option selected>{{ $keyword }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group row pe-0 mt-3">
                                        <div class="form-group col-md-4 pe-0">
                                            <label class="form-label fw-bold">@lang('Top Category')</label>
                                            <div class="">
                                                <input type="checkbox" name="top_category" data-width="100%"
                                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                    data-on="Yes" data-off="No"
                                                    data-size="normal"@if ($category->top_category) checked @endif>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 pe-0">
                                            <label class="form-label fw-bold">@lang('Special Category')</label>
                                            <div class="">
                                                <input type="checkbox" name="special_category" data-width="100%"
                                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                    data-on="Yes" data-off="No"
                                                    data-size="normal"@if ($category->special_category) checked @endif>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 pe-0">
                                            <label class="form-label fw-bold">@lang('Filter Category')</label>
                                            <div class="">
                                                <input type="checkbox" name="filter_category" data-width="100%"
                                                    data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                    data-on="Yes" data-off="No"
                                                    data-size="normal"@if ($category->filter_category) checked @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <div class='form-group'>
                                        <div class='image-upload-area'>
                                            <img id='preview'
                                                src="{{ displayImage($templateAssets . 'images/categories/' . $category->image) }}"
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
                        <button type="submit" class="btn btn-primary px-4">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
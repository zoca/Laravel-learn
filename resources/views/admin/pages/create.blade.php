@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('pages.create-page') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')
<style>
    #content-field {
        height: 400px;
    }
</style>
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('pages.create-new-page') }}</h1>
<div class="row">

    <div class="offset-lg-2 col-lg-8 ">

        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('pages.new-page-details') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('pages.title') }} *</label>
                        <input name="title" type="text" value="{{ old('title') }}" class="form-control">
                        @error('title')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('pages.description') }} *</label>
                        <textarea name="description" rows="10" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('pages.image') }} *</label>
                        <input name="image" type="file" class="form-control">
                        @error('image')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('pages.content') }} *</label>
                        <textarea id="content-field" name="content" rows="10" class="form-control">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('pages.layout') }} *</label>
                        <select class="form-control" name="layout">
                            <option value="">-- {{ __('pages.choose-layout') }} --</option>
                            <option value="fullwidth" {{ (old('layout') == 'fullwidth') ? 'selected' : '' }}>{{ __('pages.fullwidth') }}</option>
                            <option value="leftaside" {{ (old('layout') == 'leftaside') ? 'selected' : '' }}>{{ __('pages.leftaside') }}</option>
                            <option value="rightaside" {{ (old('layout') == 'rightaside') ? 'selected' : '' }}>{{ __('pages.rightaside') }}</option>
                        </select>
                        @error('layout')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">{{ __('pages.contact-form') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="contact_form" type="radio" id="contact_form_1" value="0" {{ (old('contact_form', 0) == 0) ? 'checked' : '' }} class="form-check-input">
                            <label class="form-check-label" for="contact_form_1">{{ __('pages.no') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input name="contact_form" type="radio" id="contact_form_2" value="1" {{ (old('contact_form') == 1) ? 'checked' : '' }} class="form-check-input">
                            <label class="form-check-label" for="contact_form_2">{{ __('pages.yes') }}</label>
                        </div>
                        @error('contact_form')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">{{ __('pages.save') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection


@section('custom-js')
<script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content-field'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection
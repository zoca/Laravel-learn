@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('pages.edit-page') }} {{ $page->title }}</title>
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
<h1 class="h3 mb-4 text-gray-800">{{ __('pages.edit-page') }}</h1>
@if(session()->has('message-type'))
@include('admin.layout.partials.notification-message')
@endif
<div class="row">

    <div class="offset-lg-2 col-lg-8 ">

        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('pages.edit-page-details') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pages.update', ['page' => $page->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <label class="col-form-label col-sm-2 pt-1">{{ __('pages.parent-page') }} *</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="page_id">
                                    <option value="0">-- {{ __('pages.top-level') }} --</option>
                                    @if(count($pagesTopLevel) > 0)
                                    @foreach($pagesTopLevel as $value)
                                    <option value="{{ $value->id }}" {{ (old('page_id', $page->page_id) == $value->id ) ? 'selected' : '' }}>{{ $value->title }}</option>

                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        @error('page_id')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('pages.title') }} *</label>
                        <input name="title" type="text" value="{{ old('title', $page->title) }}" class="form-control">
                        @error('title')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{!! __('pages.description') !!} *</label>
                        <textarea name="description" rows="10" class="form-control">{{ old('description', $page->description) }}</textarea>
                        @error('description')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Current image</label>                        
                        <img class="w-100 mb-3" src="{{  $page->getImage('m') }}" alt="">
                        <!-- <img class="w-100 mb-3" src="{{  imageSize($page->image,'s') }}" alt=""> -->
                    </div>
                    <div class="form-group">
                        <label>{{ __('pages.new-image') }} </label>
                        <input name="image" type="file" class="">
                        @error('image')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{!! __('pages.content') !!} *</label>
                        <textarea id="content-field" name="content" rows="10" class="form-control">{{ old('content', $page->content) }}</textarea>
                        @error('content')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-form-label col-sm-2 pt-1">{{ __('pages.layout') }} *</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="layout">
                                    <option value="">-- {{ __('pages.choose-layout') }} --</option>
                                    <option value="fullwidth" {{ (old('layout', $page->layout) == 'fullwidth') ? 'selected' : '' }}>{{ __('pages.fullwidth') }}</option>
                                    <option value="leftaside" {{ (old('layout', $page->layout) == 'leftaside') ? 'selected' : '' }}>{{ __('pages.leftaside') }}</option>
                                    <option value="rightaside" {{ (old('layout', $page->layout) == 'rightaside') ? 'selected' : '' }}>{{ __('pages.rightaside') }}</option>
                                </select>
                            </div>
                        </div>
                        @error('layout')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">{{ __('pages.contact-form') }}</legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input name="contact_form" type="radio" id="contact_form_1" value="0" {{ (old('contact_form', $page->contact_form) == 0) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="contact_form_1">{{ __('pages.no') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="contact_form" type="radio" id="contact_form_2" value="1" {{ (old('contact_form', $page->contact_form) == 1) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="contact_form_2">{{ __('pages.yes') }}</label>
                                </div>
                            </div>
                            @error('contact_form')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">{{ __('pages.header-menu') }}</legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input name="header" type="radio" id="header_1" value="0" {{ (old('header', $page->header) == 0) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="header_1">{{ __('pages.no') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="header" type="radio" id="header_2" value="1" {{ (old('header', $page->header) == 1) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="header_2">{{ __('pages.yes') }}</label>
                                </div>
                            </div>
                            @error('header')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">{{ __('pages.aside-menu') }}</legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input name="aside" type="radio" id="aside_1" value="0" {{ (old('aside', $page->aside) == 0) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="aside_1">{{ __('pages.no') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="aside" type="radio" id="aside_2" value="1" {{ (old('aside', $page->aside) == 1) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="aside_2">{{ __('pages.yes') }}</label>
                                </div>
                            </div>
                            @error('aside')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">{{ __('pages.footer-menu') }}</legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input name="footer" type="radio" id="footer_1" value="0" {{ (old('footer', $page->footer) == 0) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="footer_1">{{ __('pages.no') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="footer" type="radio" id="footer_2" value="1" {{ (old('footer', $page->footer) == 1) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="footer_2">{{ __('pages.yes') }}</label>
                                </div>
                            </div>
                            @error('footer')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0">{{ __('pages.active-menu') }}</legend>
                            <div class="col-sm-10">
                                <div class="form-check form-check-inline">
                                    <input name="active" type="radio" id="active_1" value="0" {{ (old('active', $page->active) == 0) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="active_1">{{ __('pages.no') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input name="active" type="radio" id="active_2" value="1" {{ (old('active', $page->active) == 1) ? 'checked' : '' }} class="form-check-input">
                                    <label class="form-check-label" for="active_2">{{ __('pages.yes') }}</label>
                                </div>
                            </div>
                            @error('active')
                            <div class="text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </fieldset>
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
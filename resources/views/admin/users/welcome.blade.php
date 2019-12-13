@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('users.welcome') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('users.welcome') . ' ' . auth()->user()->name }}</h1>
@if(session()->has('message-type'))
@include('admin.layout.partials.notification-message')
@endif
@endsection


@section('custom-js')

@endsection
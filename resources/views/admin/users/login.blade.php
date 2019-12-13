@extends('admin.layout.noauthenticated')

@section('seo-title')
<title>{{ __('users.login') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('content')
<div class="text-center">
    <h1 class="h4 text-gray-900 mb-4">{{ __('users.login') }}</h1>
    @if(session()->has('message-type'))
    @include('admin.layout.partials.notification-message')
    @endif
    @error('message')
    <div class="text text-danger">{{ $message }}</div>
    @enderror
</div>
<form class="user" method="post" action="">
    @csrf
    <div class="form-group">
        <input name="email" type="text" class="form-control form-control-user" value="{{ old('email') }}" placeholder="{{ __('users.enter-email-address') }}">
        @error('email')
        <div class="text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <input name="password" type="password" class="form-control form-control-user" placeholder="{{ __('users.password') }}">
        @error('password')
        <div class="text text-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary btn-user btn-block">
        {{ __('users.login') }}
    </button>

</form>
<hr>
<div class="text-center">
    <a class="small" href="{{ route('users.resetpassword') }}">{{__('users.forgot-password') }}</a>
</div>
@endsection
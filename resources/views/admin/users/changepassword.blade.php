@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('users.change-password') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('users.change-password') }} for user {{ $user->name }}</h1>
@if(session()->has('message-type'))
@include('admin.layout.partials.notification-message')
@endif
<div class="row">

    <div class="offset-lg-2 col-lg-8 ">

        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('users.password') }}</h6>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('users.password') }}</label>
                        <input name="password" type="password" class="form-control">
                        @error('password')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('users.confirm-password') }}</label>
                        <input name="password_confirmation" type="password" class="form-control">
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">{{ __('users.save') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection


@section('custom-js')

@endsection
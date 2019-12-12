@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('users.edit') }} {{ $user->name }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('users.edit') .  ' ' . $user->name }} </h1>
@if(session()->has('message-type'))
@include('admin.layout.partials.notification-message')
@endif
<div class="row">

    <div class="offset-lg-2 col-lg-8 ">

        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('users.user-details') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('users.name') }}</label>
                        <input name="name" type="text" value="{{ old('name', $user->name) }}" class="form-control">
                        @error('name')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('users.email-address') }}</label>
                        <input disabled name="email" type="text" value="{{ old('email', $user->email) }}" class="form-control">
                        @error('email')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('users.phone') }}</label>
                        <input name="phone" type="text" value="{{ old('phone', $user->phone) }}" class="form-control">
                        @error('phone')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{ __('users.address') }}</label>
                        <input name="address" type="text" value="{{ old('address', $user->address) }}" class="form-control">
                        @error('address')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group {{ (auth()->user()->role == \App\User::MODERATOR) ? 'd-none' : '' }}">
                        <label>{{ __('users.role') }}</label>
                        <select class="form-control" name="role">
                            <option value="">-- {{ __('users.choose-role') }} --</option>
                            <option value="{{ \App\User::ADMINISTRATOR }}" {{ (old('role', $user->role) == \App\User::ADMINISTRATOR) ? 'selected' : '' }}>{{ ucfirst(\App\User::ADMINISTRATOR) }}</option>
                            <option value="{{ \App\User::MODERATOR }}"  {{ (old('role', $user->role) == \App\User::MODERATOR) ? 'selected' : '' }}>{{ ucfirst(\App\User::MODERATOR) }}</option>
                        </select>
                        @error('role')
                        <div class="text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group text-right" >
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
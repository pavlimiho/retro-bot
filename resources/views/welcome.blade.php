@extends('layouts.landing')

@section('content')
<div class="container bg-inherit vh-100 d-table">
    <div class="d-table-cell align-middle text-center">
        <div class="bg-dark-50 rounded text-white py-4">
            <img src="{{ asset('images/retro_logo.png') }}" class="img-fluid rounded-lg" style="max-width: 300px;" />
            <h1 class="display-1 text-nowrap">@lang('Welcome to')<br>{{ config('app.name', 'Laravel') }}</h1>
            
            <a class="btn btn-primary btn-lg w-50" href="{{ route('login') }}">
                <i class="fa fa-sign-in"></i> @lang('Login')
            </a>
        </div>
    </div>
</div>
@endsection

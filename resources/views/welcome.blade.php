@extends('layouts.landing')

@section('content')
<div class="text-center text-white">
    <img src="{{ asset('images/retro_logo.png') }}" class="img-fluid rounded-lg mt-5" style="max-width: 300px;" />
    <h1 class="display-1">@lang('Welcome to')<br>{{ config('app.name', 'Retro-Silvermoon') }}</h1>

    <a class="btn btn-primary btn-lg w-25" href="{{ route('login') }}">
        <i class="fa fa-sign-in"></i> @lang('Login')
    </a>
</div>
@endsection

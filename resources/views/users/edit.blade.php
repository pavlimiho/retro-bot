@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('users.edit', $user) }}

@endsection
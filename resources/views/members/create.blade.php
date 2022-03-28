@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('members.create') }}

<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            
            <x-members.form/>
        </form>
    </div>
</div>

@endsection

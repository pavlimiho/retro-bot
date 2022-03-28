@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('members.edit', $member) }}

<div class="card shadow-lg">
    <div class="card-body">
        <form action="{{ route('members.update', $member) }}" method="POST">
            @csrf
            @method('PUT')
            
            <x-members.form :member="$member"/>
        </form>
    </div>
</div>

@endsection

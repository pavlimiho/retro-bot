@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @can ('edit-users')
        <div class="col-lg-6 col-md-6 col-xl-4 mb-4">
            <a href="{{ route('users.index') }}" class="card text-decoration-none shadow-sm shadow-hover rounded">
                <div class="card-body text-center text-success">
                    <i class="fa fa-users fa-4x mb-3"></i>
                    <h3>{{ __('Manage Users') }}</h3>
                </div>
            </a>
        </div>
        @endcan
        
        @can ('edit-members')
        <div class="col-lg-6 col-md-6 col-xl-4 mb-4">
            <a href="{{ route('members.index') }}" class="card text-decoration-none shadow-sm shadow-hover rounded">
                <div class="card-body text-center text-danger">
                    <i class="fa fa-users fa-4x mb-3"></i>
                    <h3>{{ __('Manage Roster') }}</h3>
                </div>
            </a>
        </div>
        @endcan
        
        <div class="col-lg-6 col-md-6 col-xl-4 mb-4">
            <a href="{{ route('lootsheet') }}" class="card text-decoration-none shadow-sm shadow-hover rounded">
                <div class="card-body text-center text-info">
                    <i class="fa fa-users fa-4x mb-3"></i>
                    <h3>{{ __('Lootsheet') }}</h3>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

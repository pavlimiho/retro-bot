@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('users') }}

<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>{{ __('Name') }}</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ Arr::get($user, 'name') }}</td>
                        <td class="text-right">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

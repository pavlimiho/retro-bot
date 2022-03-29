@extends('layouts.app')

@section('content')

{{ Breadcrumbs::render('members') }}

<a href="{{ route('members.create') }}" class="btn btn-success mb-3">
    <i class="fa fa-plus"></i> {{ __('Add Member') }}
</a>

<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Class') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                    <tr>
                        <td>{{ Arr::get($member, 'name') }}</td>
                        <td>
                            <span class="badge border" style="background-color: {{ Arr::get($member, 'wowClass.color') }}">{{ Arr::get($member, 'wowClass.name') }}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('members.edit', $member) }}" class="btn btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

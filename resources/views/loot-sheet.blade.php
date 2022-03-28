@extends('layouts.app')

@section('content')

<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        @foreach ($members as $member)
                        <td colspan="2" style="background-color: {{ Arr::get($member, 'wowClass.color') }}">{{ Arr::get($member, 'name') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>@lang('Link')</th>
                        @foreach ($members as $member)
                        <td colspan="2">
                            <form action="{{ route('members.sim', $member) }}" method="POST" data-simForm="true">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Insert Sim Link" value="{{ Arr::get($member, 'sim_link') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-refresh"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>@lang('Last Updated')</th>
                        @foreach ($members as $member)
                        <td colspan="2">{{ Arr::get($member, 'last_sim_update') }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <th>{{ Arr::get($instance, 'name') }}</th>
                        @foreach ($members as $member)
                        <th>@lang ('Item')</th>
                        <th>@lang ('DPS')</th>
                        @endforeach
                    </tr>
                    @foreach ($encounters as $encounter)
                    <tr>
                        <th>{{ Arr::get($encounter, 'name') }}</th>
                        @foreach ($members as $member)
                        <td></td>
                        <td></td>
                        @endforeach
                    </tr>
                    @endforeach
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection
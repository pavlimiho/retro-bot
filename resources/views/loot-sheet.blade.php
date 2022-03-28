@extends('layouts.app')

@section('content')

<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <div class="table table-bordered table-striped table-hover">
                <table>
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            @foreach ($members as $member)
                            <td style="background-color: {{ Arr::get($member, 'wowClass.color') }}">{{ Arr::get($member, 'name') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th>@lang('Link')</th>
                            <th>
                                @foreach ($members as $member)
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
                                @endforeach
                            </th>
                        </tr>
                        <tr>
                            <th>@lang('Last Updated')</th>
                            <th>
                                @foreach ($members as $member)
                                {{ Arr::get($member, 'last_sim_update') }}
                                @endforeach
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
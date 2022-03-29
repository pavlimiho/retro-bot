@extends('layouts.app')

@section('content')

<div class="card shadow-lg">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        @foreach ($members as $member)
                        <th colspan="2" style="background-color: {{ Arr::get($member, 'wowClass.color') }}">{{ Arr::get($member, 'name') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>@lang('Link')</th>
                        @foreach ($members as $member)
                        <td colspan="2">
                            <form action="{{ route('members.sim', $member) }}" method="POST" data-simForm="true" autocomplete="off">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="sim" class="form-control" placeholder="Insert Sim Link" value="{{ Arr::get($member, 'sim_link') }}" required>
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
                        <td colspan="2" data-dateSimUpdate="{{ Arr::get($member, 'id') }}">{{ printDate(Arr::get($member, 'last_sim_update')) }}</td>
                        @endforeach
                    </tr>
                    <tr class="bg-primary">
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
                        <td data-item="{{ Arr::get($member, 'id').'_'.Arr::get($encounter, 'external_id') }}"></td>
                        <td data-dps="{{ Arr::get($member, 'id').'_'.Arr::get($encounter, 'external_id') }}"></td>
                        @endforeach
                    </tr>
                    @endforeach
                </thead>
            </table>
        </div>
    </div>
</div>

@push ('scripts')
<script>
    $('[data-simForm]').submit(function (e) {
        e.preventDefault();
        
        customAjax({
            url: $(this).attr('action'),
            data: {
                _token: "{{ csrf_token() }}",
                sim: $(this).find('[name="sim"]').val()
            },
            success: function (response) {
                parseSimResponse(response.data)
            },
            error: function (response) {
                let error = '';
                if (response.errors && response.errors.sim) {
                    response.errors.sim.forEach(function (item) {
                        error = error + '<br/>' + item;
                    });
                    Swal.fire(response.message, error, 'error');
                } else if (response.message.substring(0, 5) === 'fopen') {
                    Swal.fire('Error', 'This sim has expired', 'error');
                } else {
                    Swal.fire(response.message, error, 'error');
                }
            }
        });
    });
    
    function parseSimResponse(data) {
        buildItemsTable(data.memberId, data.data);
        $('[data-dateSimUpdate="'+data.memberId+'"]').html(data.date);
    }
    
    function buildItemsTable(memberId, data) {
        Object.keys(data).forEach(function (encounterId) {
            let items = data[encounterId];
            let itemsHtml = '<table class="table table-sm m-0 text-primary font-weight-bold"><tbody>';
            let dpsHtml = '<table class="table table-sm m-0 text-primary font-weight-bold""><tbody>';
            Object.keys(items).forEach(function (key) {
                let item = items[key];
                itemsHtml = itemsHtml+'<tr><td>'+item.item+'</td></tr>';
                dpsHtml = dpsHtml+'<tr><td>'+item.dps+'</td></tr>';
            });
            itemsHtml = itemsHtml+'</tbody></table>';
            dpsHtml = dpsHtml+'</tbody></table>';
            
            $('[data-item="'+memberId+'_'+encounterId+'"]').html(itemsHtml);
            $('[data-dps="'+memberId+'_'+encounterId+'"]').html(dpsHtml);
        });
    }
    
    @foreach ($members as $member)
        @if (Arr::get($member, 'last_sim'))
            buildItemsTable({{ Arr::get($member, 'id') }}, JSON.parse('{!! Arr::get($member, 'last_sim') !!}'));
        @endif
    @endforeach
</script>
@endpush

@endsection
@extends('layouts.app')

@section('content')

<div class="card shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive table-fixed-header" style="height: calc(100vh - 2px);">
            <table class="table table-bordered table-sm text-nowrap table-hover table-clickable" id="lootsheetTable">
                <thead>
                    <tr>
                        <th class="position-sticky bg-white" style="left: 0;">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/retro_logo.png') }}" class="img-fluid rounded-circle" style="max-width: 25px;" />
                            </a>
                        </th>
                        @foreach ($members as $member)
                        <th colspan="2" style="background-color: {{ Arr::get($member, 'wowClass.color') }}; border-left: groove; min-width: 120px;">{{ Arr::get($member, 'name') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="position-sticky bg-white" style="left: 0;">@lang('Link')</th>
                        @foreach ($members as $member)
                        <td colspan="2" style="border-left: groove;">
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
                        <th class="position-sticky bg-white" style="left: 0;">@lang('Last Updated')</th>
                        @foreach ($members as $member)
                        <td colspan="2" data-dateSimUpdate="{{ Arr::get($member, 'id') }}" style="border-left: groove;"></td>
                        @endforeach
                    </tr>
                    <tr class="bg-primary">
                        <th class="position-sticky bg-white" style="left: 0;">{{ Arr::get($instance, 'name') }}</th>
                        @foreach ($members as $member)
                        <th style="border-left: groove;">@lang ('Item')</th>
                        <th>@lang ('DPS')</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($encounters as $encounter)
                    <tr>
                        <th class="position-sticky bg-white" style="left: 0;">
                            <!--{{ Arr::get($encounter, 'name') }}-->
                            <img src="{{ asset('images/encounters/'.Arr::get($encounter, 'external_id')).'.png' }}" class="img-fluid" style="width: 150px;" title="{{ Arr::get($encounter, 'name') }}" />
                        </th>
                        @foreach ($members as $member)
                        <td data-item="{{ Arr::get($member, 'id').'_'.Arr::get($encounter, 'external_id') }}" style="border-left: groove;"></td>
                        <td data-dps="{{ Arr::get($member, 'id').'_'.Arr::get($encounter, 'external_id') }}"></td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push ('scripts')
<script>
    $('[data-simForm]').submit(function (e) {
        e.preventDefault();
        let button = $(this).find('button');
        
        customAjax({
            url: $(this).attr('action'),
            data: {
                _token: "{{ csrf_token() }}",
                sim: $(this).find('[name="sim"]').val()
            },
            beforeSend: function () {
                button.addClass('btn-warning');
                button.find('i').addClass('fa-spin');
            },
            success: function (response) {
                buildItemsTable(response.data.memberId, response.data.data, response.data.date)
                
                button.removeClass('btn-warning');
                button.find('i').removeClass('fa-spin');
            },
            error: function (response) {
                button.removeClass('btn-warning');
                button.find('i').removeClass('fa-spin');
                
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
    
    function buildItemsTable(memberId, data, date) {
        $('[data-dateSimUpdate="'+memberId+'"]').html(parseLocalDateTime(date));
        
        $('[data-item^="'+memberId+'_"]').html('');
        $('[data-dps^="'+memberId+'_"]').html('');
        
        Object.keys(data).forEach(function (encounterId) {
            let items = data[encounterId];
            let itemsHtml = '<table class="table table-sm m-0 text-primary font-weight-bold"><tbody>';
            let dpsHtml = '<table class="table table-sm m-0 text-primary font-weight-bold""><tbody>';
            Object.keys(items).forEach(function (key) {
                let item = items[key];
                itemsHtml = itemsHtml+'<tr><td class="border-0 '+getDpsColor(item.dps)+'">'+item.item+'</td></tr>';
                dpsHtml = dpsHtml+'<tr><td class="border-0 '+getDpsColor(item.dps)+'">'+item.dps+'</td></tr>';
            });
            itemsHtml = itemsHtml+'</tbody></table>';
            dpsHtml = dpsHtml+'</tbody></table>';
            
            $('[data-item="'+memberId+'_'+encounterId+'"]').html(itemsHtml);
            $('[data-dps="'+memberId+'_'+encounterId+'"]').html(dpsHtml);
        });
    }
    
    function getDpsColor(dps) {
        if (dps >= 50) {
            return 'text-success';
        } else if (dps >= 20) {
            return 'text-orange';
        } else {
            return 'text-secondary';
        }
    }
    
    @foreach ($members as $member)
        @if (Arr::get($member, 'last_sim'))
            buildItemsTable({{ Arr::get($member, 'id') }}, JSON.parse('{!! Arr::get($member, 'last_sim') !!}'), '{{ Arr::get($member, 'last_sim_update') }}');
        @endif
    @endforeach
</script>
@endpush

@endsection
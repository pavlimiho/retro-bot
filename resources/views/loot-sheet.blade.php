@extends('layouts.app')

@section('content')

<div class="card shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive table-fixed-header" style="height: calc(100vh - 2px);">
            <table class="table table-sm text-nowrap mb-0" id="lootsheetTable">
                <thead>
                    <tr>
                        <th class="position-sticky bg-white" style="left: 0;">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/retro_logo.png') }}" class="img-fluid rounded-circle" style="max-width: 25px;" />
                            </a>
                            <div class="custom-control custom-switch pull-right">
                                <input class="custom-control-input cursor-pointer" type="checkbox" id="changeMode">
                                <label class="custom-control-label cursor-pointer" for="changeMode">
                                    <i class="fa fa-moon-o text-dark"></i>
                                </label>
                            </div>
                        </th>
                        @foreach ($members as $member)
                        <th class="text-center" colspan="2" class="text-dark" style="background-color: {{ Arr::get($member, 'wowClass.color') }}; border-left: groove; min-width: 120px;">{{ Arr::get($member, 'name') }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th class="position-sticky bg-white" style="left: 0; z-index: 3;">@lang('Link')</th>
                        @foreach ($members as $member)
                        <td colspan="2" style="border-left: groove;" data-simInputCell="true">
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
                        <th class="text-dark" style="border-left: groove;">@lang ('Item')</th>
                        <th class="text-dark">@lang ('DPS')</th>
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
                    <tr>
                        <th class="position-sticky bg-white text-right align-middle" style="left: 0;">Note</th>
                        @foreach ($members as $member)
                        <td colspan="2" style="border-left: groove;">
                            <form name="noteForm" action="{{ route('members.note', $member) }}" method="POST" autocomplete="off">
                                <textarea name="note" placeholder="Note" style="min-height: 100px;">{{ Arr::get($member, 'note') }}</textarea>
                                <button type="submit" class="btn btn-success btn-block btn-sm">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </form>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push ('scripts')
<script>
    let currentTheme = getCookie('retro_theme');
    
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
        $('[data-dateSimUpdate="'+memberId+'"]').html('<span class="'+getDateColor(date)+'" title="'+parseLocalDateTime(date)+'">'+parseLocalDateTime(date, 'ddd Do MMMM')+'</span>');
        
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
    
    function getDateColor(date) {
        let days = Math.round(moment.duration(moment().startOf('day') - moment(date)).asDays());
        
        if (days >= 6) {
            return currentTheme === 'dark' ? 'text-orange' : 'text-danger';
        }
    }
    
    $('#changeMode').change(function () {
        let mode = $(this).is(':checked') ? 'dark' : 'light';
        setCookie('retro_theme', mode, 30)
        
        if (mode === 'dark') {
            setDarkMode();
        } else {
            setLightMode();
        }
    });
    
    if (currentTheme === 'dark') {
        setDarkMode();
    }
    
    function setLightMode() {
        $('#lootsheetTable').removeClass('bg-dark');
        $('#lootsheetTable .bg-dark, [data-dateSimUpdate], [data-simInputCell]').removeClass('bg-dark').addClass('bg-white');
        $('#lootsheetTable').css('color', '#212529');
        $('[data-dateSimUpdte]').removeClass('bg-dark').addClass('bg-white');
        $('[data-dateSimUpdate] span.text-orange').removeClass('text-orange').addClass('text-danger');
        $('[name="sim"]').removeClass('bg-secondary text-white');
        $('[name="note"]').removeClass('bg-secondary text-white');
        $('[for="changeMode"] i').removeClass('text-white').addClass('text-dark');
    }
    
    function setDarkMode() {
        $('#changeMode').prop('checked', true);
        $('#lootsheetTable').addClass('bg-dark');
        $('#lootsheetTable .bg-white, [data-dateSimUpdate], [data-simInputCell]').removeClass('bg-white').addClass('bg-dark');
        $('#lootsheetTable').css('color', 'white');
        $('[data-dateSimUpdate] span.text-danger').removeClass('text-danger').addClass('text-orange');
        $('[name="sim"]').addClass('bg-secondary text-white');
        $('[name="note"]').addClass('bg-secondary text-white');
        $('[for="changeMode"] i').removeClass('text-dark').addClass('text-white');
    }
    
    $('[name="noteForm"]').submit(function (e) {
        e.preventDefault();
        let button = $(this).find('button');
        
        customAjax({
            url: $(this).attr('action'),
            data: {
                _token: "{{ csrf_token() }}",
                note: $(this).find('[name="note"]').val()
            },
            beforeSend: function () {
                button.addClass('btn-warning');
                button.find('i').removeClass('fa-save').addClass('fa-refresh fa-spin');
            },
            success: function (response) {
                button.removeClass('btn-warning');
                button.find('i').removeClass('fa-refresh fa-spin').addClass('fa-save');
            },
            error: function (response) {
                button.removeClass('btn-warning');
                button.find('i').removeClass('fa-refresh fa-spin').addClass('fa-save');
                
                let error = '';
                Swal.fire(response.message, error, 'error');
            }
        });
    });
    
    @foreach ($members as $member)
        @if (Arr::get($member, 'last_sim'))
            buildItemsTable({{ Arr::get($member, 'id') }}, JSON.parse('{!! Arr::get($member, 'last_sim') !!}'), '{{ Arr::get($member, 'last_sim_update') }}');
        @endif
    @endforeach
</script>
@endpush

@endsection
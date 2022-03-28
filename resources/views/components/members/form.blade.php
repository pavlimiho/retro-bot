<div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label">@lang('Name')</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="name" value="{{ Arr::get($member, 'name') }}" required>
    </div>
</div>

<div class="form-group row">
    <label for="wow_class_id" class="col-sm-2 col-form-label">@lang('Class')</label>
    <div class="col-sm-10">
        <select class="form-control" name="wow_class_id" required>
            <option value="">Select the class</option>
            @foreach ($wowClasses as $class)
            <option value="{{ Arr::get($class, 'id') }}" style="background-color: {{ Arr::get($class, 'color') }}" {{ $isSelected(Arr::get($class, 'id')) ? 'selected="selected"' : '' }}>{{ Arr::get($class, 'name') }}</option>
            @endforeach
        </select>
    </div>
</div>

<button type="submit" class="btn btn-success pull-right">
    <i class="fa fa-save"></i> Save
</button>
        
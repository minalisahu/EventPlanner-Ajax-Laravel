<div class="form-group row">
    <label for="name"
        class="col-4 control-label required-label {{ $errors->has('name') ? 'has-error' : '' }}">{{__('Name')}}</label>
    <div class="col-8">
        <input class="form-control title-input" name="name" type="text" id="name"
            value="{{ old('name', optional($event)->name) }}" minlength="1" maxlength="255"
            placeholder="{{__('Enter name here...')}}">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group row">
    <label for="description"
        class="col-4 control-label {{ $errors->has('description') ? 'has-error' : '' }}">{{__('Description')}}</label>
    <div class="col-8">
        <textarea class="form-control" name="description" rows="6" type="text" id="description"
            placeholder="{{__('Enter description here...')}}">{{ old('description', optional($event)->description) }}</textarea>
        {!! $errors->first('descr(iption', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group row">
    <label for="start_date" class="col-4 control-label required-label {{ $errors->has('start_date') ? 'has-error' : '' }}">{{__('Start Date')}}</label>
    <div class="col-8">
    <input class="form-control datepicker  " name="start_date" type="text" value="{{old('start_date', optional($event)->StartdateEdit)}}"   placeholder="__/__/____ __:__" autocomplete="off">
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group row">
    <label for="end_date" class="col-4 control-label {{ $errors->has('end_date') ? 'has-error' : '' }}">{{__('End Date')}}</label>
    <div class="col-8">
    <input class="form-control datepicker" name="end_date" type="text" value="{{old('end_date', optional($event)->EnddateEdit)}}" placeholder="__/__/____ __:__"  autocomplete="off">
        {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<drop-down
 :label="'{{__('Recurrence Type')}}'"
 :name="'recurrence_type'"
 :data="{{json_encode([['id'=>'Single','name'=>'Single'],['id'=>'Daily','name'=>'Daily'],['id'=>'Weekly','name'=>'Weekly'],['id'=>'Monthly','name'=>'Monthly'],['id'=>'Yearly','name'=>'Yearly']])}}"
 :value="'{{old('recurrence_type', optional($event)->recurrence_type) ?? ''}}'"
 :error="'{{$errors->first('recurrence_type')}}'"
 :labelclass="'required-label'"
>
</drop-down>
<div class="form-group">
    <label for="name" class="control-label required">{{ trans('modules.base::forms.name') }}</label>
    {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'name', 'placeholder' => trans('modules.base::forms.name'), 'data-counter' => 120]) !!}
</div>
<div class="form-group">
    <label for="description" class="control-label required">{{ trans('modules.base::forms.description') }}</label>
    {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 4, 'id' => 'description', 'placeholder' => trans('modules.base::forms.description'), 'data-counter' => 400]) !!}
</div>
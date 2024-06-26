@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        <div {!! $options['wrapperAttrs'] !!}>
    @endif
@endif

@if ($showLabel && $options['label'] !== false && $options['label_show'])
    {!! Form::customLabel($name, $options['label'], $options['label_attr']) !!}
@endif
@if ($showField)
    <div class="input-group">
        {!! Form::text($name, $options['value'] ?? now(config('app.timezone'))->format('G:i'), array_merge($options['attr'], ['class' => Arr::get($options['attr'], 'class', '') . str_replace(Arr::get($options['attr'], 'class'), '', ' form-control time-picker timepicker timepicker-24')])) !!}
        <span class="input-group-prepend">
            <button class="btn default" type="button">
                <i class="fa fa-clock"></i>
            </button>
        </span>
    </div>
    @include('modules.base::forms.partials.help_block')
@endif

@include('modules.base::forms.partials.errors')

@if ($showLabel && $showField)
    @if ($options['wrapper'] !== false)
        </div>
    @endif
@endif

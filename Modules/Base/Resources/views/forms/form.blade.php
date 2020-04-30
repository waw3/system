@extends('modules.base::layouts.master')
@section('content')
    @if ($showStart)
        {!! Form::open(Arr::except($formOptions, ['template'])) !!}
    @endif

    @php
        do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), $form->getModel())
    @endphp
    <div class="row">
        <div class="col-md-9">
            @if ($showFields && $form->hasMainFields())
                <div class="main-form">
                    <div class="{{ $form->getWrapperClass() }}">
                        @foreach ($fields as $key => $field)
                            @if ($field->getName() == $form->getBreakFieldPoint())
                                @break
                            @else
                                @unset($fields[$key])
                            @endif
                            @if (!in_array($field->getName(), $exclude))
                                {!! $field->render() !!}
                                @if ($field->getName() == 'name')
                                    {!! apply_filters('slug-area', $form->getModel()) !!}
                                @endif
                            @endif
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endif

            @foreach ($form->getMetaBoxes() as $key => $metaBox)
                {!! $form->getMetaBox($key) !!}
            @endforeach

            @php do_action('meta_boxes', 'advanced', $form->getModel()) @endphp
        </div>
        <div class="col-md-3 right-sidebar">
            {!! $form->getActionButtons() !!}
            @php do_action('meta_boxes', 'top', $form->getModel()) @endphp

            @foreach ($fields as $field)
                @if (!in_array($field->getName(), $exclude))
                    <div class="widget meta-boxes">
                        <div class="widget-title">
                            <h4>{!! Form::customLabel($field->getName(), $field->getOption('label'), $field->getOption('label_attr')) !!}</h4>
                        </div>
                        <div class="widget-body">
                            {!! $field->render([], in_array($field->getType(), ['radio', 'checkbox'])) !!}
                        </div>
                    </div>
                @endif
            @endforeach

            @php do_action('meta_boxes', 'side', $form->getModel()) @endphp
        </div>
    </div>

    @if ($showEnd)
        {!! Form::close() !!}
    @endif

    @yield('form_end')
@stop

@if ($form->getValidatorClass())
    @if ($form->isUseInlineJs())
        {!! Assets::scriptToHtml('jquery') !!}
        {!! Assets::scriptToHtml('form-validation') !!}
        {!! $form->renderValidatorJs() !!}
    @else
        @push('footer')
            {!! $form->renderValidatorJs() !!}
        @endpush
    @endif
@endif

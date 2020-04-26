@extends('modules.base::layouts.master')
@section('content')
    {!! Form::open(['route' => ['setting.email.template.store']]) !!}
    <div class="max-width-1200">
        <div class="flexbox-annotated-section">
            <div class="flexbox-annotated-section-annotation">
                <div class="annotated-section-title pd-all-20">
                    <h2>{{ trans('modules.setting::setting.email.title') }}</h2>
                </div>
                <div class="annotated-section-description pd-all-20 p-none-t">
                    <p class="color-note">
                        {!! trans('modules.setting::setting.email.description') !!}
                    </p>
                    <div class="available-variable">
                        @foreach(MailVariable::getVariables('core') as $coreKey => $coreVariable)
                            <p><code>{{ $coreKey }}</code>: {{ $coreVariable }}</p>
                        @endforeach
                            @foreach(MailVariable::getVariables($pluginData['name']) as $moduleKey => $moduleVariable)
                                <p><code>{{ $moduleKey }}</code>: {{ $moduleVariable }}</p>
                            @endforeach
                    </div>
                </div>
            </div>

            <div class="flexbox-annotated-section-content">
                <div class="wrapper-content pd-all-20 email-template-edit-wrap">
                    @if ($emailSubject)
                        <div class="form-group">
                            <label class="text-title-field"
                                   for="email_subject">
                                {{ trans('modules.setting::setting.email.subject') }}
                            </label>
                            <input type="hidden" name="email_subject_key"
                                   value="{{ get_setting_email_subject_key($pluginData['type'], $pluginData['name'], $pluginData['template_file']) }}">
                            <input data-counter="300" type="text" class="next-input"
                                   name="email_subject"
                                   id="email_subject"
                                   value="{{ $emailSubject }}">
                        </div>
                    @endif
                    <div class="form-group">
                        <input type="hidden" name="template_path" value="{{ get_setting_email_template_path($pluginData['name'], $pluginData['template_file']) }}">
                        <label class="text-title-field"
                               for="email_content">{{ trans('modules.setting::setting.email.content') }}</label>
                        <textarea id="mail-template-editor" name="email_content" class="form-control" style="overflow-y:scroll; height: 500px;">{{ $emailContent }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="flexbox-annotated-section" style="border: none">
            <div class="flexbox-annotated-section-annotation">
                &nbsp;
            </div>
            <div class="flexbox-annotated-section-content">
                <a href="{{ route('settings.email') }}" class="btn btn-secondary">{{ trans('modules.setting::setting.email.back') }}</a>
                <a class="btn btn-warning btn-trigger-reset-to-default" data-target="{{ route('setting.email.template.reset-to-default') }}">{{ trans('modules.setting::setting.email.reset_to_default') }}</a>
                <button class="btn btn-info" type="submit" name="submit">{{ trans('modules.setting::setting.save_settings') }}</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    {!! Form::modalAction('reset-template-to-default-modal', trans('modules.setting::setting.email.confirm_reset'), 'info', trans('modules.setting::setting.email.confirm_message'), 'reset-template-to-default-button', trans('modules.setting::setting.email.continue')) !!}
@endsection

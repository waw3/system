@extends('modules.base::layouts.master')
@section('content')
    <div id="main-settings">
        <license-component
            verify-url="{{ route('settings.license.verify') }}"
            activate-license-url="{{ route('settings.license.activate') }}"
            deactivate-license-url="{{ route('settings.license.deactivate') }}"
        ></license-component>
    </div>
    {!! Form::open(['route' => ['settings.edit']]) !!}
        <div class="max-width-1200">
            <div class="flexbox-annotated-section">

                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>{{ trans('modules.setting::setting.general.general_block') }}</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">{{ trans('modules.setting::setting.general.description') }}</p>
                    </div>
                </div>

                <div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">
                        <div class="form-group">
                            <label class="text-title-field"
                                   for="admin_email">{{ trans('modules.setting::setting.general.admin_email') }}</label>
                            <input type="email" class="next-input" name="admin_email" id="admin_email"
                                   value="{{ setting('admin_email') }}">
                        </div>

                        <div class="form-group">
                            <label class="text-title-field"
                                   for="time_zone">{{ trans('modules.setting::setting.general.time_zone') }}
                            </label>
                            <div class="ui-select-wrapper">
                                <select name="time_zone" class="ui-select" id="time_zone">
                                    @foreach(DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $timezone)
                                        <option value="{{ $timezone }}" @if (setting('time_zone', 'UTC') === $timezone) selected @endif>{{ $timezone }}</option>
                                    @endforeach
                                </select>
                                <svg class="svg-next-icon svg-next-icon-size-16">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                                </svg>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="enable_send_error_reporting_via_email" value="0">
                            <label>
                                <input type="checkbox" class="hrv-checkbox" value="1" @if (setting('enable_send_error_reporting_via_email')) checked @endif name="enable_send_error_reporting_via_email">
                                {{ trans('modules.setting::setting.general.enable_send_error_reporting_via_email') }}
                            </label>
                        </div>

                    </div>
                </div>

            </div>

            <div class="flexbox-annotated-section">

                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>{{ trans('modules.setting::setting.general.admin_appearance_title') }}</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">{{ trans('modules.setting::setting.general.admin_appearance_description') }}</p>
                    </div>
                </div>

                <div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">
                        <div class="form-group">
                            <label class="text-title-field"
                                   for="admin-logo">{{ trans('modules.setting::setting.general.admin_logo') }}
                            </label>
                            <div class="admin-logo-image-setting">
                                {!! Form::mediaImage('admin_logo', setting('admin_logo'), ['allow_thumb' => false]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-title-field"
                                   for="admin-favicon">{{ trans('modules.setting::setting.general.admin_favicon') }}
                            </label>
                            <div class="admin-favicon-image-setting">
                                {!! Form::mediaImage('admin_favicon', setting('admin_favicon'), ['allow_thumb' => false]) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="text-title-field"
                                   for="admin_title">{{ trans('modules.setting::setting.general.admin_title') }}</label>
                            <input data-counter="120" type="text" class="next-input" name="admin_title" id="admin_title"
                                   value="{{ setting('admin_title', config('app.name')) }}">
                        </div>

                        <div class="form-group">

                            <label class="text-title-field"
                                   for="rich_editor">{{ trans('modules.setting::setting.general.rich_editor') }}
                            </label>
                            <label class="hrv-label">
                                <input type="radio" name="rich_editor" class="hrv-radio" value="ckeditor"
                                       @if (setting('rich_editor', 'ckeditor') == 'ckeditor') checked @endif>{{ __('CKEditor') }}
                            </label>
                            <label class="hrv-label">
                                <input type="radio" name="rich_editor" class="hrv-radio" value="tinymce"
                                       @if (setting('rich_editor', 'ckeditor') == 'tinymce') checked @endif>{{ __('TinyMCE') }}
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="text-title-field"
                                   for="default_admin_theme">{{ trans('modules.setting::setting.general.default_admin_theme') }}
                            </label>
                            <div class="ui-select-wrapper">
                                <select name="default_admin_theme" class="ui-select" id="default_admin_theme">
                                    @foreach(Assets::getThemes() as $theme => $path)
                                        <option value="{{ $theme }}" @if (setting('default_admin_theme', mconfig('base.config.default-theme')) === $theme) selected @endif>
                                            {{ Str::studly($theme) }}
                                        </option>
                                    @endforeach
                                </select>
                                <svg class="svg-next-icon svg-next-icon-size-16">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                                </svg>
                            </div>
                        </div>

                        <div class="form-group">
                                <input type="hidden" name="enable_change_admin_theme" value="0">
                                <label><input type="checkbox" class="hrv-checkbox" value="1"
                                              @if (setting('enable_change_admin_theme')) checked @endif name="enable_change_admin_theme"> {{ trans('modules.setting::setting.general.enable_change_admin_theme') }} </label>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="enable_multi_language_in_admin" value="0">
                            <label><input type="checkbox" class="hrv-checkbox" value="1"
                                          @if (setting('enable_multi_language_in_admin')) checked @endif name="enable_multi_language_in_admin"> {{ trans('modules.setting::setting.general.enable_multi_language_in_admin') }} </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flexbox-annotated-section">
                <div class="flexbox-annotated-section-annotation">
                    <div class="annotated-section-title pd-all-20">
                        <h2>{{ trans('modules.setting::setting.general.cache_block') }}</h2>
                    </div>
                    <div class="annotated-section-description pd-all-20 p-none-t">
                        <p class="color-note">{{ trans('modules.setting::setting.general.cache_description') }}</p>
                    </div>
                </div>

                <div class="flexbox-annotated-section-content">
                    <div class="wrapper-content pd-all-20">

                        <div class="form-group">
                            <label class="text-title-field"
                                   for="enable_cache">{{ trans('modules.setting::setting.general.enable_cache') }}
                            </label>
                            <label class="hrv-label">
                                <input type="radio" name="enable_cache" class="hrv-radio" value="1" @if (setting('enable_cache')) checked @endif>
                                {{ trans('modules.setting::setting.general.yes') }}
                            </label>
                            <label class="hrv-label">
                                <input type="radio" name="enable_cache" class="hrv-radio" value="0" @if (!setting('enable_cache')) checked @endif>
                                {{ trans('modules.setting::setting.general.no') }}
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="text-title-field"
                                   for="cache_time">{{ trans('modules.setting::setting.general.cache_time') }}</label>
                            <input type="number" class="next-input" name="cache_time" id="cache_time"
                                   value="{{ setting('cache_time', 10) }}">
                        </div>

                        <div class="form-group">
                            <label class="text-title-field"
                                   for="enable_cache">{{ trans('modules.setting::setting.general.cache_admin_menu') }}
                            </label>
                            <label class="hrv-label">
                                <input type="radio" name="cache_admin_menu_enable" class="hrv-radio" value="1" @if (setting('cache_admin_menu_enable')) checked @endif>
                                {{ trans('modules.setting::setting.general.yes') }}
                            </label>
                            <label class="hrv-label">
                                <input type="radio" name="cache_admin_menu_enable" class="hrv-radio" value="0" @if (!setting('cache_admin_menu_enable')) checked @endif>
                                {{ trans('modules.setting::setting.general.no') }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {!! apply_filters('base-filter-after-setting-content', null) !!}

            <div class="flexbox-annotated-section" style="border: none">
                <div class="flexbox-annotated-section-annotation">
                    &nbsp;
                </div>
                <div class="flexbox-annotated-section-content">
                    <button class="btn btn-info" type="submit">{{ trans('modules.setting::setting.save_settings') }}</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

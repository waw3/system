<div class="flexbox-annotated-section">
    <div class="flexbox-annotated-section-annotation">
        <div class="annotated-section-title pd-all-20">
            <h2>{{ trans('modules.plugins.captcha::captcha.settings.title') }}</h2>
        </div>
        <div class="annotated-section-description pd-all-20 p-none-t">
            <p class="color-note">{{ trans('modules.plugins.captcha::captcha.settings.description') }}</p>
        </div>
    </div>

    <div class="flexbox-annotated-section-content">
        <div class="wrapper-content pd-all-20">
            <div class="form-group">
                <label class="text-title-field"
                       for="enable_captcha">{{ trans('modules.plugins.captcha::captcha.settings.enable_captcha') }}
                </label>
                <label class="hrv-label">
                    <input type="radio" name="enable_captcha" class="hrv-radio"
                                                value="1"
                                                @if (setting('enable_captcha')) checked @endif>{{ trans('modules.setting::setting.general.yes') }}
                </label>
                <label class="hrv-label">
                    <input type="radio" name="enable_captcha" class="hrv-radio"
                                                value="0"
                                                @if (!setting('enable_captcha')) checked @endif>{{ trans('modules.setting::setting.general.no') }}
                </label>
            </div>

            <div class="form-group">
                <label class="text-title-field"
                       for="captcha_site_key">{{ trans('modules.plugins.captcha::captcha.settings.captcha_site_key') }}</label>
                <input data-counter="120" type="text" class="next-input" name="captcha_site_key" id="captcha_site_key"
                       value="{{ setting('captcha_site_key', config('modules.plugins.captcha.general.site_key')) }}" placeholder="{{ trans('modules.plugins.captcha::captcha.settings.captcha_site_key') }}">
            </div>
            <div class="form-group">
                <label class="text-title-field"
                       for="captcha_secret">{{ trans('modules.plugins.captcha::captcha.settings.captcha_secret') }}</label>
                <input data-counter="120" type="text" class="next-input" name="captcha_secret" id="captcha_secret"
                       value="{{ setting('captcha_secret', config('modules.plugins.captcha.general.secret')) }}" placeholder="{{ trans('modules.plugins.captcha::captcha.settings.captcha_secret') }}">
            </div>
            <div class="form-group">
                <span class="help-ts">{{ trans('modules.plugins.captcha::captcha.settings.helper') }}</span>
            </div>
        </div>
    </div>
</div>
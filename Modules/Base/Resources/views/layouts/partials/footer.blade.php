<div class="page-footer">
    <div class="page-footer-inner">
        <div class="row">
            <div class="col-md-6">
                {!! trans('modules.base::layouts.copyright', ['year' => now(config('app.timezone'))->format('Y'), 'company' => setting('admin_title', mconfig('base.config.base_name')), 'version' => get_cms_version()]) !!}
            </div>
            <div class="col-md-6 text-right">
                @if (defined('LARAVEL_START')) {{ trans('modules.base::layouts.page_loaded_time') }} {{ round((microtime(true) - LARAVEL_START), 2) }}s @endif
            </div>
        </div>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up-circle"></i>
    </div>
</div>

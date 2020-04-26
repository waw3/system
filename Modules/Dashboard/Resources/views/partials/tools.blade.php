<div class="tools">
    <a href="#" class="{{ Arr::get($settings, 'state', 'expand') }}" data-toggle="tooltip" title="{{ trans('modules.dashboard::dashboard.collapse_expand') }}" data-state="{{ Arr::get($settings, 'state', 'expand') == 'collapse' ? 'expand' : 'collapse' }}"></a>
    <a href="#" class="reload" data-toggle="tooltip" title="{{ trans('modules.dashboard::dashboard.reload') }}"></a>
    <a href="#" class="fullscreen" data-toggle="tooltip" data-original-title="{{ trans('modules.dashboard::dashboard.fullscreen') }}" title="{{ trans('modules.dashboard::dashboard.fullscreen') }}"> </a>
    <a href="#" class="remove" data-toggle="tooltip" title="{{ trans('modules.dashboard::dashboard.hide') }}"></a>
</div>
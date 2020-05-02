@if (!is_in_admin() || (Auth::check() && Auth::user()->hasPermission($route . '.edit')))
    <a href="{{ Route::has($route . '.edit') ? route($route . '.edit', $item->id) : '#' }}" class="tip" title="{{ trans('modules.language::language.current_language') }}"><i class="fa fa-check text-success"></i></a>
@else
    <i class="fa fa-check text-success"></i>
@endif

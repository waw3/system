<div class="form-group">
    <label for="widget-name">{{ __('Name') }}</label>
    <input type="text" id="widget-name" class="form-control" name="name" value="{{ $config['name'] }}">
</div>
<div class="form-group">
    <label for="widget_menu">{{ __('Select menu') }}</label>
    {!! Form::select('menu_id', app(\Modules\Menu\Repositories\Interfaces\MenuInterface::class)->all()->pluck('name', 'slug')->all(), $config['menu_id'], ['class' => 'form-control select-full']) !!}
</div>
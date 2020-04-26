<div class="widget meta-boxes">
    <div class="widget-title">
        <h4><span class="required">{{ trans('modules.base::tables.status') }}</span></h4>
    </div>
    <div class="widget-body">
        <div class="ui-select-wrapper">
            {!! Form::select(isset($name) ? $name : 'status', isset($values) ? $values : \Modules\Base\Enums\BaseStatusEnum::labels(), isset($selected) ? $selected : old(isset($name) ? $name : 'status', \Modules\Base\Enums\BaseStatusEnum::PUBLISHED), ['class' => 'ui-select']) !!}
            <svg class="svg-next-icon svg-next-icon-size-16">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
            </svg>
        </div>
    </div>
</div>

@extends('modules.base::layouts.master')
@section('content')
    <div id="plugin-list" class="clearfix app-grid--blank-slate row">
        @foreach ($list as $plugin)
            <div class="app-card-item col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="app-item app-{{ $plugin->path }}">
                    <div class="app-icon">
                        @if ($plugin->image)
                            <img src="data:image/png;base64,{{ $plugin->image }}">
                        @endif
                    </div>
                    <div class="app-details">
                        <h4 class="app-name">{{ $plugin->name }}</h4>
                    </div>
                    <div class="app-footer">
                        <div class="app-description" title="{{ $plugin->description }}">{{ $plugin->description }}</div>
                        <div class="app-author">{{ trans('modules.pluginmanagement::plugin.author') }}: <a href="{{ $plugin->url }}" target="_blank">{{ $plugin->author }}</a></div>
                        <div class="app-version">{{ trans('modules.pluginmanagement::plugin.version') }}: {{ $plugin->version }}</div>
                        <div class="app-actions">
                            @if (Auth::user()->hasPermission('plugins.edit'))
                                <button class="btn @if ($plugin->status) btn-warning @else btn-info @endif btn-trigger-change-status" data-plugin="{{ $plugin->path }}" data-status="{{ $plugin->status }}">@if ($plugin->status) {{ trans('modules.pluginmanagement::plugin.deactivate') }} @else {{ trans('modules.pluginmanagement::plugin.activate') }} @endif</button>
                            @endif

                            @if (Auth::user()->hasPermission('plugins.remove'))
                            <button class="btn btn-danger btn-trigger-remove-plugin" data-plugin="{{ $plugin->path }}">{{ trans('modules.pluginmanagement::plugin.remove') }}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {!! Form::modalAction('remove-plugin-modal', trans('modules.pluginmanagement::plugin.remove_plugin'), 'danger', trans('modules.pluginmanagement::plugin.remove_plugin_confirm_message'), 'confirm-remove-plugin-button', trans('modules.pluginmanagement::plugin.remove_plugin_confirm_yes')) !!}
@stop

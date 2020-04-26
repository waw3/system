@extends('modules.base::layouts.master')
@section('content')
    <div class="clearfix"></div>
    <p><button class="btn btn-primary" id="generate_backup">{{ trans('modules.plugins.backup::backup.generate_btn') }}</button></p>
    <table class="table table-striped" id="table-backups">
        <thead>
            <tr>
                <th>{{ trans('modules.base::tables.name') }}</th>
                <th>{{ trans('modules.base::tables.description') }}</th>
                <th>{{ __('Size') }}</th>
                <th>{{ trans('modules.base::tables.created_at') }}</th>
                <th>{{ trans('modules.base::tables.operations') }}</th>
            </tr>
        </thead>
        <tbody>
            @if (count($backups) > 0)
                @foreach($backups as $key => $backup)
                    @include('modules.plugins.backup::partials.backup-item', ['data' => $backup, 'key' => $key, 'odd' => $loop->index % 2 == 0 ? true : false])
                @endforeach
            @else
                <tr class="text-center no-backup-row">
                    <td colspan="5">{{ __('There is no backup now!') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! Form::modalAction('create-backup-modal', trans('modules.plugins.backup::backup.create'), 'info', view('modules.plugins.backup::partials.create')->render(), 'create-backup-button', trans('modules.plugins.backup::backup.create_btn')) !!}
    {!! Form::modalAction('restore-backup-modal', trans('modules.plugins.backup::backup.restore'), 'info', trans('modules.plugins.backup::backup.restore_confirm_msg'), 'restore-backup-button', trans('modules.plugins.backup::backup.restore_btn')) !!}
    <div data-route-create="{{ route('backups.create') }}"></div>

    @include('modules.table::modal')
@stop

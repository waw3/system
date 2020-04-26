@if ($requests->count() > 0)
<div class="scroller">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('modules.base::tables.url') }}</th>
                <th>{{ trans('modules.plugins.request-log::request-log.status_code') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($requests as $request)
            <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td><a href="{{ $request->url }}" target="_blank">{{ Str::limit($request->url, 80) }}</a></td>
                <td>{{ $request->status_code }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@if ($requests->total() > $limit)
    <div class="widget_footer">
        @include('modules.dashboard::partials.paginate', ['data' => $requests, 'limit' => $limit])
    </div>
@endif
@else
    @include('modules.dashboard::partials.no-data', ['message' => trans('modules.plugins.request-log::request-log.no_request_error')])
@endif

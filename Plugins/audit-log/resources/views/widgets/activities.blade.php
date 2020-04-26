@if ($histories->count() > 0)
    <div class="scroller">
        <ul class="item-list padding">
            @foreach ($histories as $history)
                <li>
                    @include('modules.plugins.audit-log::activity-line', compact('history'))
                </li>
            @endforeach
        </ul>
    </div>
    @if ($histories->total() > $limit)
        <div class="widget_footer">
            @include('modules.dashboard::partials.paginate', ['data' => $histories, 'limit' => $limit])
        </div>
    @endif
@else
    @include('modules.dashboard::partials.no-data')
@endif

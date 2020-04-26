@if ($posts->count() > 0)
    <div class="scroller">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('modules.base::tables.name') }}</th>
                <th>{{ trans('modules.base::tables.created_at') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>@if ($post->slug) <a href="{{ $post->url }}" target="_blank">{{ Str::limit($post->name, 100) }}</a> @else <strong>{{ Str::limit($post->name, 100) }}</strong> @endif</td>
                    <td>{{ date_from_database($post->created_at, 'd-m-Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($posts->total() > $limit)
        <div class="widget_footer">
            @include('modules.dashboard::partials.paginate', ['data' => $posts, 'limit' => $limit])
        </div>
    @endif
@else
    @include('modules.dashboard::partials.no-data', ['message' => trans('modules.plugins.blog::posts.no_new_post_now')])
@endif

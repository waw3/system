@if ($products->count() > 0)
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
            @foreach($products as $product)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>@if ($product->slug) <a href="{{ $product->url }}" target="_blank">{{ Str::limit($product->name, 100) }}</a> @else <strong>{{ Str::limit($product->name, 100) }}</strong> @endif</td>
                    <td>{{ date_from_database($product->created_at, 'd-m-Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if ($products->total() > $limit)
        <div class="widget_footer">
            @include('modules.dashboard::partials.paginate', ['data' => $products, 'limit' => $limit])
        </div>
    @endif
@else
    @include('modules.dashboard::partials.no-data', ['message' => trans('modules.plugins.product::products.no_new_product_now')])
@endif

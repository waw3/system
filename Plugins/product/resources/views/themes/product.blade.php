<div>
    <h3>{{ $product->name }}</h3>
    {!! Theme::breadcrumb()->render() !!}
</div>
<header>
    <h3>{{ $product->name }}</h3>
    <div>
        @if (!$product->procategories->isEmpty())
            <span>
                <a href="{{ $product->procategories->first()->url }}">{{ $product->procategories->first()->name }}</a>
            </span>
        @endif
        <span>{{ date_from_database($product->created_at, 'M d, Y') }}</span>

        @if (!$product->protags->isEmpty())
            <span>
                @foreach ($product->protags as $protag)
                    <a href="{{ $protag->url }}">{{ $protag->name }}</a>
                @endforeach
            </span>
        @endif
    </div>
</header>
{!! clean($product->content) !!}
<br />
{!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null) !!}
<footer>
    @foreach (get_related_products($product->slug, 2) as $pro_item)
        <div>
            <article>
                <div><a href="{{ $pro_item->url }}"></a>
                    <img src="{{ url($pro_item->image) }}" alt="{{ $pro_item->name }}">
                </div>
                <header><a href="{{ $pro_item->url }}"> {{ $pro_item->name }}</a></header>
            </article>
        </div>
    @endforeach
</footer>

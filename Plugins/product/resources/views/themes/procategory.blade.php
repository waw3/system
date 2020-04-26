<div>
    <h3>{{ $procategory->name }}</h3>
    {!! Theme::breadcrumb()->render() !!}
</div>
<div>
    @if ($products->count() > 0)
        @foreach ($products as $product)
            <article>
                <div>
                    <a href="{{ $product->url }}"><img src="{{ url($product->image) }}" alt="{{ $product->name }}"></a>
                </div>
                <div>
                    <header>
                        <h3><a href="{{ $product->url }}">{{ $product->name }}</a></h3>
                        <div><span><a href="#">{{ date_from_database($product->created_at, 'M d, Y') }}</a></span><span>{{ $product->user->getFullName() }}</span> - <a href="{{ $category->url }}">{{ $category->name }}</a></div>
                    </header>
                    <div>
                        <p>{{ $product->description }}</p>
                    </div>
                </div>
            </article>
        @endforeach
        <div>
            {!! $products->links() !!}
        </div>
    @else
        <div>
            <p>{{ __('There is no data to display!') }}</p>
        </div>
    @endif
</div>

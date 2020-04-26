@if ($products->count() > 0)
    @foreach ($products as $product)
        <article>
            <div>
                <a href="{{ $product->url }}"><img src="{{ url($product->image) }}" alt="{{ $product->name }}"></a>
            </div>
            <div>
                <header>
                    <h3><a href="{{ $product->url }}">{{ $product->name }}</a></h3>
                    <div><span><a href="#">{{ date_from_database($product->created_at, 'M d, Y') }}</a></span><span>{{ $product->user->getFullName() }}</span> -
                        {{ __('Categories') }}:
                        @foreach($product->categories as $category)
                            <a href="{{ $category->url }}">{{ $category->name }}</a>
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </div>
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
@endif

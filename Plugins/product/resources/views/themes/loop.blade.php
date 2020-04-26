@foreach ($products as $product)
    <div>
        <article>
            <div><a href="{{ $product->url }}"></a>
                <img src="{{ get_object_image($product->image, 'medium') }}" alt="{{ $product->name }}">
            </div>
            <header><a href="{{ $product->url }}"> {{ $product->name }}</a></header>
        </article>
    </div>
@endforeach

<div class="pagination">
    {!! $products->links() !!}
</div>

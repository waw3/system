@if (function_exists('get_galleries'))
    @php $galleries = get_galleries($limit); @endphp
    @if (!$galleries->isEmpty())
        <div class="page-content">
            <div class="post-group post-group--single">
                <div class="post-group__header">
                    <h3 class="post-group__title"><a href="{{ route('public.galleries') }}">{{ trans('modules.gallery::gallery.galleries') }}</a></h3>
                </div>
                <div class="post-group__content">
                    <div class="gallery-wrap">
                        @foreach ($galleries as $gallery)
                            <div class="gallery-item">
                                <div class="img-wrap">
                                    <a href="{{ route('public.gallery', ['slug' => $gallery->slug]) }}"><img src="{{ get_object_image($gallery->image, 'medium') }}" alt="{{ $gallery->name }}"></a>
                                </div>
                                <div class="gallery-detail">
                                    <div class="gallery-title"><a href="{{ route('public.gallery', ['slug' => $gallery->slug]) }}">{{ $gallery->name }}</a></div>
                                    <div class="gallery-author">{{ trans('modules.gallery::gallery.by') }} {{ $gallery->user ? $gallery->user->getFullName() : '' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

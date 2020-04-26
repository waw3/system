@foreach(mconfig('media.config.libraries.javascript', []) as $js)
    <script src="{{ url($js) }}" type="text/javascript"></script>
@endforeach

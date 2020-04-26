
@php $object_colors = old('colors', !empty($object) ? $object->colors : null); @endphp
@if (is_array($object_colors) && !empty($object_colors))
    @foreach($object_colors as $color)
        @include('modules.plugins.product::colors.components.color', [
                'name' => 'colors[]',
                'value' => $color
            ])
    @endforeach
@endif
<button type="button" id="add_sub_color" class="btn btn-flat btn-success">
        <i class="fa fa-plus" aria-hidden="true"></i>
        {{ trans('modules.plugins.product::features.form.button_add_color') }}
</button>


<script>
// Add sub images
var id_sub_color = {{ old('colors')?count(old('colors')):0 }};
$('#add_sub_color').click(function(event) {
    id_sub_color +=1;
    $(this).before('<div class="group-image color-input"><div class="input-group"><input type="text" id="sub_image_'+id_sub_color+'" name="colors[]" value="" class="form-control input-sm sub_color" placeholder="Nhập màu"  /><span class="input-group-btn"><span title="Remove" class="btn btn-flat btn-sm btn-danger removeColor"><i class="fa fa-times"></i></span></span></div></div>');

    $('.removeColor').click(function(event) {
        $(this).closest('.color-input').remove();
    });
   
});

</script>

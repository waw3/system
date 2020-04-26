
@php $object_sizes = old('sizes', !empty($object) ? $object->sizes : null); @endphp
@if (is_array($object_sizes) && !empty($object_sizes))
    @foreach($object_sizes as $size)
        @include('modules.plugins.product::sizes.components.size', [
                'name' => 'sizes[]',
                'value' => $size
            ])
    @endforeach
@endif
<button type="button" id="add_sub_size" class="btn btn-flat btn-success">
        <i class="fa fa-plus" aria-hidden="true"></i>
        {{ trans('modules.plugins.product::features.form.button_add_size') }}
</button>

<script>
// Add sub images
var id_sub_size = {{ old('sizes')?count(old('sizes')):0 }};
$('#add_sub_size').click(function(event) {
    id_sub_size +=1;
    $(this).before('<div class="group-image size-input"><div class="input-group"><input type="text" id="sub_image_'+id_sub_size+'" name="sizes[]" value="" class="form-control input-sm sub_size" placeholder="Nhập màu"  /><span class="input-group-btn"><span title="Remove" class="btn btn-flat btn-sm btn-danger removesize"><i class="fa fa-times"></i></span></span></div></div>');

    $('.removesize').click(function(event) {
        $(this).closest('.size-input').remove();
    });
   
});

//end sub images
</script>

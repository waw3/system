
@php 



    $object_pricesale = old('pricesale', !empty($object) ? $object->pricesale : null); 
    $object_sale_start = old('price_sale_start', !empty($object) ? $object->price_sale_start : null); 
    $object_sale_end = old('price_sale_end', !empty($object) ? $object->price_sale_end : null); 




@endphp
@if (!empty($object_pricesale) && !empty($object_sale_start) && !empty($object_sale_end))
<div class="price_promotionOld">
   
        
        <div class="row">
            <div class="col-md-6">
                <span class="input-group-addon"><i class="fas fa-hryvnia"></i> {{ trans('modules.plugins.product::sell.form.timesale') }}</span>
                <input type="number" id="price_promotion" name="pricesale" value="{{$object->pricesale}}" class="form-control input-sm price" placeholder="" />
            </div>
            <div class="col-md-6">
                <span class="input-group-addon"><i class="fas fa-hryvnia"></i> {{ trans('modules.plugins.product::sell.form.amoundprice') }}</span>
                <input type="number"  id="price_promotion_amound" name="amound" value="{{$object->amound}}" class="form-control input-sm price" placeholder="" />
            </div>
            <!-- <div class="col-md-2">
                <span title="Remove" class="btn btn-flat btn-sm btn-danger removePromotionOld"><i class="fa fa-times"></i></span>
            </div> -->
        </div>
        
    

        
        <div class="row">
            <div class="col-md-6">
                <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i> {{ trans('modules.plugins.product::sell.form.price_promotion_start') }}</span>
                <input type="text" id="price_promotion_start" name="price_sale_start" value="{{$object->price_sale_start}}" class="form-control input-sm price_promotion_start datepicker date_time" placeholder="" />
            </div>
            <div class="col-md-6">
                <span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i> {{ trans('modules.plugins.product::sell.form.price_promotion_end') }}</span>
                <input type="text" id="price_promotion_end" name="price_sale_end" value="{{$object->price_sale_end}}" class="form-control input-sm price_promotion_end datepicker date_time" placeholder="" />
            </div>
        </div>
</div>

@endif


@if (!empty($object_pricesale) && !empty($object_sale_start) && !empty($object_sale_end))

@else
<button type="button" id="add_product_promotion" class="btn btn-flat btn-success">
    <i class="fa fa-plus" aria-hidden="true"></i>
     {{ trans('modules.plugins.product::sell.form.button_add_timesaleoff') }}
</button>
@endif
<!-- daterangepicker -->

<script>
    // Promotion
$('#add_product_promotion').click(function(event) {
    $(this).before('<div class="price_promotion"><div class="row"><div class="col-md-5"><span class="input-group-addon"><i class="fas fa-hryvnia"></i> {{ trans('modules.plugins.product::sell.form.timesale') }}</span><input type="number"  id="price_promotion" name="pricesale" value="" placeholder="{{ trans('modules.plugins.product::sell.form.timesale') }}" class="form-control input-sm price" placeholder="" /></div><div class="col-md-5"><span class="input-group-addon"><i class="fas fa-sort-amount-up"></i> {{ trans('modules.plugins.product::sell.form.amoundprice') }}</span><input type="number"   id="price_promotion_amound" name="amound" value="" placeholder="{{ trans('modules.plugins.product::sell.form.amoundprice') }}" class="form-control input-sm price" placeholder="" /></div><div class="col-md-2"><span title="Remove" class="btn btn-flat btn-sm btn-danger removePromotion"><i class="fa fa-times"></i></span></div></div>     <div class="row"><div class="col-md-6"><span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i> {{ trans('modules.plugins.product::sell.form.price_promotion_start') }}</span> <input type="text"   id="price_promotion_start" name="price_sale_start" value="" class="form-control input-sm price_promotion_start datepicker date_time" placeholder="" /></div><div class="col-md-6"><span class="input-group-addon"><i class="fa fa-calendar fa-fw"></i> {{ trans('modules.plugins.product::sell.form.price_promotion_end') }}</span><input type="text"   id="price_promotion_end" name="price_sale_end" value="" class="form-control input-sm price_promotion_end datepicker date_time" placeholder="" /></div></div>      </div>');
    $(this).hide();
    $('.removePromotion').click(function(event) {
        $(this).closest('.price_promotion').remove();
        $('#add_product_promotion').show();
    });
    $('.date_time').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd'
    })
});
$('.removePromotion').click(function(event) {
    $('#add_product_promotion').show();
    $(this).closest('.price_promotion').remove();
});

$('.removePromotionOld').click(function(event) {

    $(this).closest('.price_promotionOld').remove();
});
//End promotion

//Date picker
$('.date_time').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd'
})


</script>



 
@php $object_products = old('products', !empty($object) ? $object->products : null); @endphp
@if (is_array($object_products) && !empty($object_products))
    @foreach($object_products as $product)
        @include('modules.plugins.product::products.components.product', [
                'name' => 'products[]',
                'value' => $product
            ])
    @endforeach
@endif

<!-- <button type="button" id="id_sub_product" class="btn btn-flat btn-success">
        <i class="fa fa-plus" aria-hidden="true"></i>
        {{ trans('modules.plugins.product::products.form.button_add_product') }}
</button> -->

<!-- <div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Products info </h3>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <input type="text" class="form-controller" id="search" name="search"></input>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div> -->


    
<script type="text/javascript">
// Add sub images
/*var id_sub_product = {{ old('products')?count(old('products')):0 }};
$('#id_sub_product').click(function(event) {
    id_sub_product +=1;
    $(this).before(
        '<div class="group-image product-input" id="orderr">'
        +'<div class="input-group">'
        +'<input type="text"  name="products[]" id="product_list" value="" class="form-control input-sm sub_product products" placeholder="Chọn sản phẩm"  />'
        +'<input type="text"  value="" class="form-control input-sm sub_product mahang" disabled placeholder="Mã Hàng"  />'
        +'<input type="text"  value="" class="form-control input-sm sub_product price" onChange="update_total($(this));" placeholder="Giá bán"  />'
        +'<input type="text"  value="" class="form-control input-sm sub_product qty" onChange="update_total($(this));" placeholder="Số lượng"  />'
        +'<input type="text"  value="" class="form-control input-sm sub_product sumprice" disabled placeholder="Tổng Tiền"  />'
        +'<span class="input-group-btn">'
        +'  <span title="Remove" class="btn btn-flat btn-sm btn-danger removeProduct">'
        +'      <i class="fa fa-times"></i>'
        +'  </span>'
        +'</span>'
        +'</div>'
        +'</div>'
        );

    $('.removeProduct').click(function(event) {
        $(this).closest('.product-input').remove();
    });
   
});

function update_total(e){
    node = e.closest('#orderr');
    var price = node.find('.price').eq(0).val();
    var qty = node.find('.qty').eq(0).val();
    var sumprice = node.find('.sumprice').eq(0).val(qty*price);
}*/

 /*$('#search').on('keyup',function(){
    $value = $(this).val();
    $.ajax({
        type: 'get',
        url: '{{ route('products.search') }}',
        data: {
            $value
        },
        success:function(data){
            $('tbody').html(data);
        }
    });
})
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });*/
</script>




















<!-- 
  <form id="form-add-item" action="" method="">
      @csrf
      <input type="hidden" name="carts_id"  value="{{$object->id}}" id="carts_id">
      <div class="row">
        <div class="col-sm-12">
          <div class="box collapsed-box">
          <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>{{ trans('product.name') }}</th>
                    <th>{{ trans('product.sku') }}</th>
                    <th class="product_price">{{ trans('product.price') }}</th>
                    <th class="product_qty">{{ trans('product.quantity') }}</th>
                    <th class="product_total">{{ trans('product.total_price') }}</th>
                    <th>{{ trans('admin.action') }}</th>
                  </tr>
                </thead>
                <tbody>
                   {{-- @foreach ($order->details as $item)
                          <tr>
                            <td>{{ $item->name }}
                              @php
                              $html = '';
                                if($item->attribute && is_array(json_decode($item->attribute,true))){
                                  $array = json_decode($item->attribute,true);
                                      foreach ($array as $key => $element){
                                        $html .= '<br><b>'.$attributesGroup[$key].'</b> : <i>'.$element.'</i>';
                                      }
                                }
                              @endphp
                            {!! $html !!}
                            </td>
                            <td>{{ $item->sku }}</td>
                            <td class="product_price"><a href="#" class="edit-item-detail" data-value="{{ $item->price }}" data-name="price" data-type="number" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ trans('product.price') }}">{{ $item->price }}</a></td>
                            <td class="product_qty">x <a href="#" class="edit-item-detail" data-value="{{ $item->qty }}" data-name="qty" data-type="number" min=0 data-pk="{{ $item->id }}" data-url="{{ route("admin_order.edit_item") }}" data-title="{{ trans('order.qty') }}"> {{ $item->qty }}</a></td>
                            <td class="product_total item_id_{{ $item->id }}">{{ sc_currency_render_symbol($item->total_price,$order->currency)}}</td>
                            <td>
                                <span  onclick="deleteItem({{ $item->id }});" class="btn btn-danger btn-xs" data-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></span>
                            </td>
                          </tr>
                    @endforeach--}}

                    <tr  id="add-item" class="not-print">
                      <td colspan="6">
                        <button  type="button" class="btn btn-sm btn-flat btn-success" id="add-item-button"  title="{{trans('product.add_product') }}"><i class="fa fa-plus"></i> {{ trans('product.add_product') }}</button>
                        &nbsp;&nbsp;&nbsp;<button style="display: none; margin-right: 50px" type="button" class="btn btn-sm btn-flat btn-warning" id="add-item-button-save"  title="Save"><i class="fa fa-save"></i> {{ trans('admin.save') }}</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
        </div>

      </div>
</form>
 -->
<!-- 

@php
  $htmlSelectProduct = '<tr>
              <td style="    width: 30%;">
                <select onChange="selectProduct($(this));"  class="add_id form-control select2" name="add_id[]" style="width:100% !important;">
                <option value="0">'.trans('Lựa chọn Sản Phẩm').'</option>';
                if(count($products)){
                  foreach ($products as $productName){
                    $htmlSelectProduct .='<option  value="'.$productName->id.'" class="Product-'.$productName->id.'" id="product_id">'.$productName->name.'</option>';
                   }
                }
  $htmlSelectProduct .='
              </select>
                <span class="add_attr"></span>
                </td>

              <td><input type="text" disabled class="add_sku form-control"  value="" name="add_sku[]"></td>
              <input type="hidden" disabled class="product_id form-control"  value="" name="product_id[]">
              <td><input onChange="update_total($(this));" type="number" min="0" class="add_price form-control" name="add_price[]" value="0"></td>
              <td><input onChange="update_total($(this));" type="number" min="0" class="add_qty form-control" name="add_qty[]" value="0"></td>
              <td><input type="number" disabled class="add_total form-control" value="0"></td>
              <td><button onClick="$(this).parent().parent().remove();" class="btn btn-danger btn-md btn-flat" data-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button></td>
            </tr>
          <tr>
          </tr>';
        $htmlSelectProduct = str_replace("\n", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("\t", '', $htmlSelectProduct);
        $htmlSelectProduct = str_replace("\r", '', $htmlSelectProduct);
@endphp

<span id="loading" style="display: none;">@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@</span> -->






<script type="text/javascript">



/*function update_total(e){
    node = e.closest('tr');
    var qty = node.find('.add_qty').eq(0).val();
    var price = node.find('.add_price').eq(0).val();
    node.find('.add_total').eq(0).val(qty*price);
}



    function selectProduct(element){
        node = element.closest('tr');
        var id = parseInt(node.find('option:selected').eq(0).val());
        if(id == 0){
            node.find('.add_sku').val('');
            node.find('.add_qty').eq(0).val('');
            node.find('.add_price').eq(0).val('');
            node.find('.product_id').html('');
        }else{
            $.ajax({
                url : '{{ route('products.search') }}',
                type : "get",
                dateType:"application/json; charset=utf-8",
                data : {
                     id:id,
                     
                },
            beforeSend: function(){
                $('#loading').show();
            },
            success: function(returnedData){
                
               
                
                
                node.find('.add_qty').eq(0).val(1);
                node.find('.add_sku').val(returnedData.pricesale);
                node.find('.product_id').eq(0).val(returnedData.id);

                node.find('.add_price').eq(0).val(returnedData.pricesell);

                node.find('.add_total').eq(0).val(returnedData.pricesell * {!! ($order->exchange_rate)??1 !!});
                
                $('#loading').hide();
               
                }
            });
        }

    }
$('#add-item-button').click(function() {
  var html = '{!! $htmlSelectProduct !!}';
  $('#add-item').before(html);
  $('.select2').select2();
  $('#add-item-button-save').show();
});*/




/*$(document).ready(function(){

  // Fetch records
  //fetchRecords();

  // Add record
  $('#add-item-button-save').click(function(){

    var carts_id = $('#carts_id').val();
    var price = $('.add_price').val();
    var qty = $('.add_qty').val();
    var carts_amound = price*qty;
    var product_id = $('#product_id').val();

   
    if(carts_id != '' && carts_amound != ''){
      $.ajax({
        url: '{{ route('products.add_item')}}',
        type: 'post',
        data: {carts_id: carts_id,carts_amound: carts_amound},
        success: function(response){

          if(response > 0){
            var id = response;
            var findnorecord = $('#userTable tr.norecord').length;

            if(findnorecord > 0){
              $('#userTable tr.norecord').remove();
            }
            var tr_str = "<tr>"+
            "<td align='center'><input type='text' value='" + username + "' id='username_"+id+"' disabled ></td>" +
            "<td align='center'><input type='text' value='" + name + "' id='name_"+id+"'></td>" +
            "<td align='center'><input type='email' value='" + email + "' id='email_"+id+"'></td>" +
            "<td align='center'><input type='button' value='Update' class='update' data-id='"+id+"' ><input type='button' value='Delete' class='delete' data-id='"+id+"' ></td>"+
            "</tr>";

            $("#userTable tbody").append(tr_str);
          }else if(response == 0){
            alert('Username already in use.');
          }else{
            alert(response);
          }

          alert(response);

          
          $('#carts_id').val('');
          $('.add_price').val('');
          $('.add_qty').val('');
          $('.add_qty').val('');
        }
      });
    }else{
      alert('Fill all fields');
    }
  });

});
*/

</script>

        
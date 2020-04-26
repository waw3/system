<div class="row">
	<div class="col-md-4">
		<span>Trạng Thái Đơn Hàng</span><br>
		<select name="orderstatus">
			<option value="0">--None--</option>
			@foreach ($orderstatus as $order)
			    <label class="checkbox-inline">
			    	<option value="{{ $order->id }}" @if (in_array($order->id, $selectedOrderstatus)) selected @endif>
			        	{{ $order->name }} 
			        </option>
			    </label>&nbsp;
			@endforeach
		</select>
	</div>
	<div class="col-md-4">
		<span>Trạng Thái Thanh Toán</span><br>
		<select name="payment">
			<option value="0">--None--</option>
			@foreach ($payments as $payment)
			    <label class="checkbox-inline">
			    	<option value="{{ $payment->id }}" @if (in_array($payment->id, $selectedPayment)) selected @endif>
			        	{{ $payment->name }} 
			        </option>
			    </label>&nbsp;
			@endforeach
		</select>
	</div>
	<div class="col-md-4">
		<span>Trạng Thái Vận Chuyển</span><br>
		<select name="shipping">
			<option value="0">--None--</option>
			@foreach ($shippings as $shipping)
			    <label class="checkbox-inline">
			    	<option value="{{ $shipping->id }}" @if (in_array($shipping->id, $selectedShipping)) selected @endif>
			        	{{ $shipping->name }} 
			        </option>
			    </label>&nbsp;
			@endforeach
		</select>
	</div>
</div>

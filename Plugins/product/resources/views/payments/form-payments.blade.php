<div class="form-group">
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
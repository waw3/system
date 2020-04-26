<div class="form-group">
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
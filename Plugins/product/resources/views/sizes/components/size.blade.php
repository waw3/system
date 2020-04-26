

<div class="group-image size-old">
	<div class="input-group">
		<input type="text" name="{{$name}}" value="{{$value}}" class="form-control input-sm sub_size" placeholder="Nhập màu"  />
		<span class="input-group-btn">
			<span title="Remove" class="btn btn-flat btn-sm btn-danger removesizeOld"><i class="fa fa-times"></i></span>
		</span>
	</div>
</div>


<script>
$('.removesizeOld').click(function(event) {
        $(this).closest('.size-old').remove();
    });
</script>

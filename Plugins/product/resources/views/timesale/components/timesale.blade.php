

<div class="group-image color-old">
	<div class="input-group">
		<input type="text" name="{{$name}}" value="{{$value}}" class="form-control input-sm sub_color" placeholder="Nhập màu"  />
		<span class="input-group-btn">
			<span title="Remove" class="btn btn-flat btn-sm btn-danger removeColorOld"><i class="fa fa-times"></i></span>
		</span>
	</div>
</div>


<script>
$('.removeColorOld').click(function(event) {
        $(this).closest('.color-old').remove();
    });
</script>

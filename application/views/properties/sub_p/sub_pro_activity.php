<?php

?>
<div class="row">
	<div class="col-md-12 table-responsive">
		<table class="table table-striped table-bordered base-styl activities">
			<thead>
				<tr>
					<th>Select</th>
					<th>Name</th>
					<th>Paid/Free</th>
					<th>price</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($activity as $row) { ?>
				<tr>
					<td>
						<input type="checkbox" name="" class="activity" value="<?=$row->id?>" <?=$row->checked?> >
					</td>
					<td><?=$row->activity_name?></td>
					<td>
						<select name="paidorfree" class="activity_data" dataId="<?=$row->id?>">
							<option value=""> -- Select --</option>
							<option value="0" <?=($row->paidorfree==0) ? 'selected': '' ?> >Free</option>
							<option value="1" <?=($row->paidorfree==1) ? 'selected': '' ?>>Paid</option>
						</select>
					</td>
					<td>
						<input type="number" name="price" class="activity_data" value="<?=$row->price?>" dataId="<?=$row->id?>" >
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$('.activities .activity').change(function(event){
		$this = $(this);
		var id = $this.val();
		if (event.currentTarget.checked) {
			var type = 'set';  
	   }
	   else{
	   	var type = 'remove';
	   }
	   $.post('<?=base_url()?>sub_properties/<?=$pro_id?>/activity/<?=$flat_id?>',{a_id:id,type:type})
		.done(function(data){
			console.log(data);
			data = JSON.parse(data);
			alert_toastr(data.res,data.msg);

		})
  	})

	var timer;
	$(document).on('keyup change','.activities .activity_data' ,function(event) {
		clearInterval(timer);
		$this = $(this);
		timer = setTimeout(function() {
			var cloumn = $this.attr('name');
			var value = $this.val();
			var id = $this.attr('dataId');
			var type = 'data';  
			$.post('<?=base_url()?>sub_properties/<?=$pro_id?>/activity/<?=$flat_id?>',{a_id:id,type:type,cloumn:cloumn,value:value})
			.done(function(data){
				console.log(data);
				data = JSON.parse(data);
				if (data.res=="error") {
					$this.val('');
					$('.activities').click();
				}
				alert_toastr(data.res,data.msg);
			})
		}, 1000);
  	})


</script>
<?php
// echo "<pre>";
// print_r($policies);
// print_r($apolicies);
// echo "</pre>";
?>
<div class="row">
	<div class="col-md-12 table-responsive">
		<table class="table table-striped table-bordered base-styl amenities">
			<thead>
				<tr>
					<th>
						<input type="checkbox" name="" class="amenity" value="select_all" > 
						Select All
					</th>
					<th>Name</th>
					<th>Icon</th>
					<th>Highlighted</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($amenities as $row) { ?>
				<tr>
					<td>
						<input type="checkbox" name="" class="amenity" value="<?=$row->id?>" <?=$row->checked?> >
					</td>
					<td><?=$row->name?></td>
					<td>
						<img src="<?=base_url('assets/icons/'.$row->icon)?>" class="icon-sm">
					</td>
					<td>
						<select name="is_highlighted" class="amenity_data" dataId="<?=$row->id?>">
							<option value=""> -- Select --</option>
							<option value="1" <?=($row->is_highlighted==1) ? 'selected': '' ?> >Yes</option>
							<option value="0" <?=($row->is_highlighted==0) ? 'selected': '' ?>>No</option>
						</select>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$('.amenities .amenity').change(function(event){
		$this = $(this);
		var id = $this.val();
		if (event.currentTarget.checked) {
			var type = 'set';  
			if (id=='select_all') {
				$('.amenity').prop('checked',true);
			} 
	   }
	   else{
		   	var type = 'remove';
		   	if (id=='select_all') {
				$('.amenity').prop('checked',false);
			} 
	   }
	   $.post('<?=base_url()?>properties/amenities/<?=$property_id?>',{a_id:id,type:type})
		.done(function(data){
			console.log(data);
			data = JSON.parse(data);
			alert_toastr(data.res,data.msg);
		})
  })

	var timer;
	$(document).on('keyup change','.amenities .amenity_data' ,function(event) {
		clearInterval(timer);
		$this = $(this);
		timer = setTimeout(function() {
			var cloumn = $this.attr('name');
			var value = $this.val();
			var id = $this.attr('dataId');
			var type = 'data';  
			$.post('<?=base_url()?>properties/amenities/<?=$property_id?>',{a_id:id,type:type,cloumn:cloumn,value:value})
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
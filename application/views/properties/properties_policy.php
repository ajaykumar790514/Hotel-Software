<?php
// echo "<pre>";
// print_r($policies);
// print_r($apolicies);
// echo "</pre>";
?>
<div class="row">
	<div class="col-md-12 table-responsive">
		<table class="table table-striped table-bordered base-styl policies">
			<thead>
				<tr>
					<th>
						<input type="checkbox" name="" class="apolicy" value="select_all" > 
						Select All
					</th>
					<th>Type</th>
					<th>Name</th>
					<th>Highlighted</th>
					<th>Highlighted Desc.</th>

				</tr>
			</thead>
			<tbody>
			<?php foreach ($policies as $policy) { ?>
				<tr>
					<td>
						<input type="checkbox" name="" class="apolicy" value="<?=$policy->id?>" <?=$policy->checked?> >
					</td>
					<td><?=$policy->policy_type?></td>
					<td><?=$policy->policy_name?></td>
					<td>
						<select name="is_highlighted" class="policy_data" dataId="<?=$policy->id?>">
							<option value=""> -- Select --</option>
							<option value="1" <?=($policy->is_highlighted==1) ? 'selected': '' ?> >Yes</option>
							<option value="0" <?=($policy->is_highlighted==0) ? 'selected': '' ?>>No</option>
						</select>
					</td>
					<td>
						<textarea name="highlighted_description" class="policy_data" dataId="<?=$policy->id?>"><?=$policy->highlighted_description?></textarea>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	$('.policies .apolicy').change(function(event){
		$this = $(this);
		var id = $this.val();
		var flatid = $this.val();
		if (event.currentTarget.checked) {
			var type = 'set'; 
			if (id=='select_all') {
				$('.apolicy').prop('checked',true);
			} 
	   }
	   else{
		   	var type = 'remove';
		   	if (id=='select_all') {
					$('.apolicy').prop('checked',false);
				}
	   }
	   $.post('<?=base_url()?>properties/policy/<?=$property_id?>',{p_id:id,type:type})
		.done(function(data){
			// console.log(data);
			data = JSON.parse(data);
			alert_toastr(data.res,data.msg);
		})
  })

	var timer;
	$(document).on('keyup change','.policies .policy_data' ,function(event) {
		clearInterval(timer);
		$this = $(this);
		timer = setTimeout(function() {
			var cloumn = $this.attr('name');
			var value = $this.val();
			var id = $this.attr('dataId');
			var type = 'data';  
			$.post('<?=base_url()?>properties/policy/<?=$property_id?>',{p_id:id,type:type,cloumn:cloumn,value:value})
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
<?php 
	// echo "<pre>";
	// print_r($booking);
	// echo "</pre>";
	 ?>
<div class="row">
	<div class="col-md-6">
		<table>
			<tr>
				<th>Guest Name</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$booking->guest_name?></td>
			</tr>

			<tr>
				<th>Gender</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$booking->gender?></td>
			</tr>

			<tr>
				<th>Email</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$booking->email?></td>
			</tr>

			<tr>
				<th>Contact</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$booking->contact?></td>
			</tr>

			<tr>
				<th>Booking For</th>
				<td class="pl-1 pr-1"> : </td>
				<td>
					<?=date('D, M d ,Y',strtotime($booking->start_date))?> - <?=date('D, M d ,Y',strtotime($booking->end_date))?>
				</td>
			</tr>
			<tr>
				<th>Price</th>
				<td class="pl-1 pr-1"> : </td>
				<td>₹ <?=$booking->price?></td>
			</tr>
		</table>
	</div>
	<div class="col-md-6">
		<form class="form ajaxsubmit reload-tb load-receipt close-win" action="<?=base_url()?>change-flat/<?=$booking->id?>" method="POST" enctype="multipart/form-data">
		<table style="width:90%;" >
			<tr class="change-flat">
				<th class="text-right">Change From</th>
				<td class="pl-1 pr-1"> : </td>
				<td><input type="date" name="startDate" class="form-control input-sm startDate" placeholder="Change From" min='<?=date("Y-m-d",strtotime($booking->start_date))?>' max='<?=date("Y-m-d",strtotime($booking->end_date. ' -1 day'))?>' b="<?=$booking->id?>"></td>
			</tr>

			<tr>
				<th class="text-right">Select Flat</th>
				<th class="pl-1 pr-1"> : </th>
				<td class="change-flat">
					<select name="flat_id" id="flat_id" class="form-control input-sm flat" b="<?=$booking->id?>" >
						<?php
                            echo optionStatus('','-- Select --');
	                        foreach ($properties as $row) {
	                        	$selected = '';
	                        	$title = $row->flat_code_name;
	                        	if ($row->flat_id==$booking->flat_id) {
	                        		$selected = 'Selected';
	                        		$title = $row->flat_code_name.' ( Current Flat )';
	                        	}
	                            echo optionStatus($row->flat_id,$title,1,$selected);
	                        }
                        ?>
					</select>
				</td>
			</tr>
			

			<tr>
				<th class="text-right">Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td><input type="text" name="change_flat_remark" class="form-control input-sm" placeholder="Change Flat Remark"></td>
			</tr>

			


			<tr>
				<th class="text-right">Amount</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="">
					<input type="number" name="price" id="price" class="form-control input-sm" readonly>
				</td>
			</tr>

			<tr>
				<th class="text-right">Total Amount</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					 <input type="number" class="form-control input-sm" name="total-price" readonly="" >
				</td>
			</tr>

			<tr>
				<th class="text-right">Wave Off Amount</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="">
					<input type="number" name="wave_off_amount" id="wave_off_amount" class="form-control input-sm">
				</td>
			</tr>
			<tr>
				<th class="text-right">Wave Off Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="">
					<input type="text" name="wave_off_remark" id="wave_off_remark" class="form-control input-sm" >
				</td>
			</tr>

			

			<tr>
				<th></th>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary btn-sm float-right">Change Flat</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>
<section id="cal">
    <div id="msg"></div>
	<?=$cal?>	
</section>





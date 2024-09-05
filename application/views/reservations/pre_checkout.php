<div class="row">
	<div class="col-md-12">
		<form class="form ajaxsubmit load-receipt close-win" action="<?=base_url()?>pre-check-out/<?=$row->id?>" method="POST" enctype="multipart/form-data">
		<table style="width:90%;">

			<tr>
				<th>Guest Name</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$row->guest_name?></td>
			</tr>

			<tr>
				<th>Gender</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$row->gender?></td>
			</tr>

			<tr>
				<th>Email</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$row->email?></td>
			</tr>

			<tr>
				<th>Contact</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$row->contact?></td>
			</tr>

			<tr>
				<th>Booking For</th>
				<td class="pl-1 pr-1"> : </td>
				<td>
					<?=date('D, M d ,Y',strtotime($row->start_date))?> - <?=date('D, M d ,Y',strtotime($row->end_date))?>
				</td>
			</tr>

			<tr>
				<th>Price</th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=setting()->currency;?><?=$booking_item->price?></td>
			</tr>
	
			<tr>
				<th>Check Out Time</th>
				<td class="pl-1 pr-1"> : </td>
				<td>
					<input type="datetime-local" id="checkout_time" class="form-control" name="checkout_time" min='<?=date("Y-m-d T H:i a",strtotime($row->start_date. ' +1 day'))?>'>
				</td>
			</tr>

			<tr>
				<th>Check Out Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td><input type="text" name="checkout_remark" class="form-control input-sm"></td>
			</tr>

			<tr>
				<th>Wave Off Amount <span class="float-right"><?=setting()->currency;?></span></th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="number" name="wave_off_amount" id="wave_off_amount" class="form-control input-sm">
				</td>
			</tr>

			<tr>
				<th>Wave Off Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="text" name="wave_off_remark" id="wave_off_remark" class="form-control input-sm" >
				</td>
			</tr>

			<tr>
				<th >Check List</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="pt-1 pb-1">
					<?php foreach($checklist as $chrow) {  ?>
					<label for="checklist<?=$chrow->id?>" class="cursor-pointer">
					 	<input type="checkbox" name="checklist[]" id="checklist<?=$chrow->id?>" value="<?=$chrow->id?>" > <?=$chrow->checklistname?>
					</label><br>
					<?php } ?>
				</td>
			</tr>

			

			<tr>
				<th></th>
				<th></th>
				<td class="d-flex justify-content-end">
					<input type="reset" data-dismiss="modal" class="btn btn-danger btn-sm mr-1" value="Cancel / Back">
					<button type="submit" class="btn btn-primary btn-sm">Check Out</button>
				</td>
			</tr>

		</table>
		</form>
	</div>
</div>


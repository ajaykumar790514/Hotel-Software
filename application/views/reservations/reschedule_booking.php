<div class="row">
	<div class="col-md-12">
		<form class="form ajaxsubmit load-receipt close-win" action="<?=base_url()?>reschedule-booking/<?=$row->id?>" method="POST" enctype="multipart/form-data">
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
				<th>Price <span class="float-right">₹</span></th>
				<td class="pl-1 pr-1"> : </td>
				<td><input type="number" name="price" id="price" class="form-control input-sm" value="<?=$row->price?>" readonly ></td>
			</tr>

			<tr>
				<th>Total Amount <span class="float-right">₹</span></th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					 <input type="number" class="form-control input-sm" name="total-price" readonly="" >
				</td>
			</tr>
	
			<tr>
				<th>Start Date</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="date" id="newStartDate" class="form-control start-date-reschedule" name="newStartDate" value="<?=$row->start_date?>" f="<?=$flat_id?>" b="<?=$row->id?>">
				</td>
			</tr>

			<tr>
				<th>End Date</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="date" id="newEndDate" class="form-control end-date-reschedule" name="newEndDate" value="<?=$row->end_date?>" f="<?=$flat_id?>" b="<?=$row->id?>">
				</td>
			</tr>

			<tr>
				<th>Reschedule Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td><input type="text" name="reschedule_remark" id="reschedule_remark" class="form-control input-sm"></td>
			</tr>

			<tr>
				<th>Wave Off Amount <span class="float-right">₹</span></th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="number" name="reschedule_wave_off_amount" id="reschedule_wave_off_amount" class="form-control input-sm">
				</td>
			</tr>

			<tr>
				<th>Wave Off Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="text" name="reschedule_wave_off_remark" id="reschedule_wave_off_remark" class="form-control input-sm" >
				</td>
			</tr>

			<tr>
				<th></th>
				<th></th>
				<td class="text-center">
					<input type="reset" data-dismiss="modal" class="btn btn-danger btn-sm mr-1" value="Cancel / Back">
					<button type="submit" class="btn btn-primary btn-sm">Reschedule</button>
				</td>
			</tr>

		</table>
		</form>
	</div>
</div>


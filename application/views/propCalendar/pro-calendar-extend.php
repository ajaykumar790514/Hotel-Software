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
			<?php if (@$extended) { ?>
			<tr class="border">
				<th colspan="3">Previous extend:</th>
			</tr>
			<?php foreach ($extended as $extrow) { ?>
			<tr class="border">
				<th>From </th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$extrow->start_date?></td>
			</tr>
			<tr class="border">
				<th>To </th>
				<td class="pl-1 pr-1"> : </td>
				<td><?=$extrow->end_date?></td>
			</tr>
			<?php } } ?>
		</table>
	</div>
	<div class="col-md-6">
		<form class="form ajaxsubmit reload-tb load-receipt close-win" action="<?=base_url()?>extend/<?=$booking->id?>" method="POST" enctype="multipart/form-data">
		<table style="width:90%;" >
			<tr>
				<th class="text-right">Start Date Extend</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="date" name="newStartDate" class="form-control input-sm start-date" value="<?=date("Y-m-d",strtotime($booking->end_date))?>" min='<?=date("Y-m-d",strtotime($booking->end_date))?>' f="<?=$flat_id?>">
				</td>
			</tr>

			<tr>
				<th class="text-right">End Date Extend</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="date" name="newEndDate" class="form-control input-sm end-date" min='<?=date("Y-m-d",strtotime($booking->end_date. ' +1 day'))?>' f="<?=$flat_id?>">
				</td>
			</tr>

			<tr>
				<th class="text-right">Extend Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td><input type="text" name="extend_remark" class="form-control input-sm"></td>
			</tr>

			<tr>
				<th class="text-right">Amount</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
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
				<th class="text-right">Discount</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="number" name="discount_amount" id="discount_amount" class="form-control input-sm">
				</td>
			</tr>
			<tr>
				<th class="text-right">Discount Remark</th>
				<td class="pl-1 pr-1"> : </td>
				<td class="select-date">
					<input type="text" name="discount_remark" id="discount_remark" class="form-control input-sm" >
				</td>
			</tr>

			

			<tr>
				<th></th>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary float-right btn-sm">Extend</button>
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>
<!-- <div class="table-responsive">
			
</div> -->

<section id="cal">
    <div id="msg"></div>
	<?=$cal?>	
</section>




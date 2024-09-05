<div class="row">
	<div class="col-md-12 checkout" id="checkout">
		
	</div>
	<div class="col-md-12 checked-in-list">
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<!-- <th>Sr. No.</th> -->
						<!-- <th class="flat_no">Property Details</th> -->
						<th>Guest Name</th>
						<th>Booked From</th>
						<th>Room Plan</th>
						<th>Arrival</th>
						<th>Departure</th>
						<th>Booked</th>
						<th>Total Payout</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php $i = 0; foreach ($rows as $row) { ?>
					<tr>
						<!-- <td><?=++$i?></td> -->
						<!-- <td>
							<?php 
								// $propid = title('property',$row->flat_id,'flat_id','propid'); 
								// $propname = title('propmaster',$propid,'id','propname'); 
								// $propcode = title('propmaster',$propid,'id','propcode'); 
								// $flat_no = title('property',$row->flat_id,'flat_id','flat_no');								 
								// echo $propname.' ('.$propcode.')'.'<br>'.$flat_no;
							?>
						</td> -->
						<td><?=$row->guest_name?></td>
					<td><?=title('booking_type',$row->booking_from,'id','type') ?>  ( <span class="text-primary"><?= title('agent', $row->agent, 'id', 'mobile') ?> , <?= title('agent', $row->agent, 'id', 'company_name') ?> </span>)</td>
						<td><?=title('booking_type_master',$row->booking_type,'id','name') ?></td>
						<td><?=$row->start_date?></td>
						<td><?=$row->end_date?></td>
						<td><?=$row->booking_date?></td>
						<td>
							<?=$row->total?>
							<?=($row->extended==1) ? ' <strong>Extended</strong>' : '' ?>
						</td>
						<td>
							<a href="<?=$detail_url?><?=$row->id?>" class="btn btn-primary btn-sm js-click no-alert checkout-open mr-1" data-target="#checkout" >Details</a>

	                        <!-- <a href="<?=$check_out_url?><?=$row->id?>" class="btn btn-primary btn-sm js-click no-alert checkout-open mr-1" data-target="#checkout" >Check Out</a>
	                        
	                        
	                        <a href="<?=$check_pre_out_url?><?=$row->id?>/yes" class="btn btn-primary btn-sm js-click no-alert checkout-open " data-target="#checkout" >Pre Check Out</a> -->
	                    </td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).on('click','.checkout-open',function(event) {
		// $('.checkin').toggle();
		$('.checked-in-list').hide();
	})
	$(document).on('click','.checkout-close',function(event) {
		$('.checkout').html('');
		$('.checked-in-list').show();
	})
</script>

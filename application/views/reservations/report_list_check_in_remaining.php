<div class="row">
	<div class="col-md-12 checkin" id="checkin">
		
	</div>
	<div class="col-md-12 check-in-remaining-list reservation-checked-in-list">
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
								$propid = title('property',$row->flat_id,'flat_id','propid'); 
								$propname = title('propmaster',$propid,'id','propname'); 
								$propcode = title('propmaster',$propid,'id','propcode'); 
								$flat_no = title('property',$row->flat_id,'flat_id','flat_no');								 
								echo $propname.' ('.$propcode.')'.'<br>'.$flat_no;
							?>								
						</td> -->
						<td><?=$row->guest_name?></td>
						<td><?=title('booking_type',$row->booking_from,'id','type') ?>  ( <span class="text-primary"><?= title('agent', $row->agent, 'id', 'mobile') ?> , <?= title('agent', $row->agent, 'id', 'company_name') ?> </span>)</td>
						<td><?=title('booking_type_master',$row->booking_type,'id','name') ?></td>
						<td><?=_date($row->start_date)?></td>
						<td><?=_date($row->end_date)?></td>
						<td><?=date_time($row->booking_date)?></td>
						<td>
							<?=$row->total?>
							<?=($row->extended==1) ? ' <strong>Extended</strong>' : '' ?>
						</td>
						<td>
	                        <a href="<?=$detail_url?><?=$row->id?>" class="btn btn-primary btn-sm js-click no-alert checkout-open checkin-open mr-1" data-target="#checkin" >Details</a>
	                        <!-- <a href="<?=$check_in_url?><?=$row->id?>" class="btn btn-primary btn-sm js-click no-alert checkin-open" data-target="#checkin" >Check In</a> -->
	                    </td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- <script type="text/javascript">
	$(document).on('click','.checkin-open',function(event) {
		// $('.checkin').toggle();
		$('.check-in-remaining-list').hide();
	})
	$(document).on('click','.checkin-close',function(event) {
		$('.checkin').html('');
		$('.check-in-remaining-list').show();
	})
</script> -->
<script type="text/javascript">
	$(document).on('click','.checkout-open',function(event) {
		// $('.checkin').toggle();
		$('.reservation-checked-in-list').hide();
	})
	$(document).on('click','.checkout-close',function(event) {
		$('.checkout').html('');
		$('.reservation-checked-in-list').show();
	})
</script>

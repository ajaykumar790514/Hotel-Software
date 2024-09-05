<section>
	<div class="row">
	<div class="col-md-12 edit_checkout" id="edit_checkout">
		
		</div>
	</div>
</section>
<div class="row p-0 reservation-checked-in-list">
	<div class="col">
        <?php  if($booking->status !=4){?>
      <table class="table table-bordered  vertical-align-middle">
           <thead>
            <tr>
                <th>Bill No.</th>
                <th>Booking ID</th>
                <th>Guest Name</th>
                <th>Contact Number</th>
                <th>Guest Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
           </thead>
           <tbody>
            <?php 
            
              foreach($checkout as $c):?>
            <tr>
                <td><?=$c->bill_no;?></td>
                <td><?=$c->booking_id;?></td>
                <td><?=$c->guest_name;?></td>
                <td><?=$c->contact_no;?></td>
                <td><?=$c->email;?></td>
                <td><?=$c->address;?></td>
                <td>
				<?php $checkgst = $this->model->CheckGST($booking->property_id);?>
                 <a href="<?=$receipt_url ?><?= $c->bill_no ?>"  class="text-success" target="_blank" title="Receipt" >
                <i class=" la la-print" style="font-size:2rem"></i>
                </a>
                <a href="<?=$edit_checkout_url;?><?= $c->id ?>" class="js-click no-alert checkout-open mb-1  float-right" data-target="#edit_checkout" > <i class="la la-pencil-square" style="font-size:2rem"></i></a>
               
                </a>
                </td>
            </tr>
            <?php endforeach;
           
              ?>
           </tbody>
      </table>
      <?php 
        }else
        {?>
<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<!-- <th>Sr. No.</th> -->
						<!-- <th class="flat_no">Property Details</th> -->
						<th>Guest Name</th>
						<th>Booked From</th>
						<th>Booking Type</th>
						<th>From</th>
						<th>To</th>
						<th>Booked</th>
						<th>Total Payout</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php  ?>
					<tr>
						<td><?=$booking->guest_name?></td>
						<td><?=title('booking_type',$booking->booking_from,'id','type') ?>  ( <span class="text-primary"><?= title('agent', $booking->agent, 'id', 'mobile') ?> </span>)</td>
						<td><?=title('booking_type_master',$booking->booking_type,'id','name') ?></td>
						<td><?=_date($booking->start_date)?></td>
						<td><?=_date($booking->end_date)?></td>
						<td><?=date_time($booking->booking_date)?></td>
						<td>
							<?=$booking->total - $booking->discount_amount?>
							<?=($booking->extended==1) ? ' <strong>Extended</strong>' : '' ?>
						</td>
						<td>
						<?php $checkgst = $this->model->CheckGST($booking->property_id);
				   if($checkgst->gst_no!=''){?>	
                        <a href="<?=$cancel_receipt_url ?><?=$checkouts->bill_no ?>"  class="text-success" target="_blank" title="Receipt" >
                <i class=" la la-print" style="font-size:2rem"></i>
                </a>
				<?php }?>
	                    </td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
    </div>
</div>   

<script type="text/javascript">
	$(document).on('click','.checkout-open',function(event) {
		// $('.checkin').toggle();
		$('.reservation-checked-in-list').hide();
	})
	$(document).on('click','.checkout-close',function(event) {
		$('.edit_checkout').html('');
		$('.reservation-checked-in-list').show();
	})
</script>

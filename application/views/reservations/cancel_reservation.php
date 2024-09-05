<form class="form ajaxsubmit reload-tb" action="<?=$a_url?>" method="POST">
<div class="row">
	<div class="col-12 text-center">
		<?php
		//  $firstdate =  $row->start_date;
		//  $lastdate = date('Y-m-d');
		//  $given_datetime2 = new DateTime($row->booking_date);
		//  $bookingtime = $given_datetime2->format('H:i:s');
		//  $given_time = $property->checkintime;
		//  $given_datetime = new DateTime($given_time);
		//  $one_hour_later = $given_datetime->sub(new DateInterval('PT1H'));
	    //  $result_time = $one_hour_later->format('H:i:s');
		//  $start_date = new DateTime($row->start_date);
		//  $end_date = new DateTime($row->end_date);
		//  $date_range = new DatePeriod($start_date, new DateInterval('P1D'), $end_date);
		// // print_r($date_range);
		//  foreach ($date_range as $date) {
		//   $newdatabooking =  $date->format('Y-m-d');
		//   if( $result_time <= $bookingtime)
		//   {
		// 	echo "<h2 class='text-danger'>We can't cancel this booking!.</h2>";
		// 	die();
		//   }
		// }
		foreach($cancellation as $can)
		{
		   $firstdate =   $row->start_date;
		   $lastdate = date('Y-m-d');
		   $days = abs(_days_diff($firstdate,$lastdate));
		 if( $days == $can->before_days)
		 {
			  if($can->discount_type==0)
			  {
				
			    $totalpayout = ($row->total-$can->cancellation_charge)-($transaction->credit);
			    $cancellationcharge = $can->cancellation_charge;
			  }elseif($can->discount_type==1)
			  {
				 //$can->cancellation_charge;
				$pervalue = ($row->total*$can->cancellation_charge)/100;
				$totalpayout = ($row->total-$pervalue)-($transaction->credit);
				$cancellationcharge =$pervalue;
			} 
		 }elseif( $days == 5)
		 {
			if($can->discount_type==0)
			{
			  
			  $totalpayout = ($row->total-$can->cancellation_charge)-($transaction->credit);
			  $cancellationcharge = $can->cancellation_charge;
			}elseif($can->discount_type==1)
			{
			   //$can->cancellation_charge;
			  $pervalue = ($row->total*$can->cancellation_charge)/100;
			  $totalpayout = ($row->total-$pervalue)-($transaction->credit);
			  $cancellationcharge =$pervalue;
		  } 
		 }
		}
       
	
		;?>
		
		<table class="table bg-secondary">
			<tr class="text-white">
				<th style="text-align:left;">Total Booking Amount</th>
				<th style="text-align:right;"><?php echo setting()->currency.''.bcdiv(@$row->total-$row->discount_amount, 1, 2) ;?></th>
			</tr>
			<tr class="text-white">
				<th style="text-align:left;">Cancellation Charge</th>
				<th style="text-align:right;"><?php echo setting()->currency.''.bcdiv(abs(@$cancellationcharge ? : '0.00'), 1, 2) ;?></th>
			</tr>
			<tr class="text-white">
				<th style="text-align:left;">Received Amount</th>
				<th style="text-align:right;"><?php echo setting()->currency.''.bcdiv(abs(@$transaction->credit), 1, 2) ;?></th>
			</tr>
			<tr class="text-white">
				<th style="text-align:left;">Total</th>
				<th style="text-align:right;"><input type="text" value="<?php echo setting()->currency.''.bcdiv(abs(@$totalpayout ? : '0.00'), 1, 2) ;?>" name="total" readonly></th>
			</tr>
		</table>
	</div>
</div>

<input type="hidden" name="cancellation_charge" value="<?=@$cancellationcharge;?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label for="cancellation_reason_id">Cancellation Reason</label>
				<select name="cancellation_reason_id" id="cancellation_reason_id" class="form-control" required>
					<?php 
					echo optionStatus('','-- Select --',1);
					foreach ($creason as $row) {
						echo optionStatus($row->id,$row->title,1);
					}
					?>
				</select>
	        </div>
		</div>
		<div class="col-md-6">
			
			<div class="form-group">
				<label for="refund_amount">Refund Amount</label>
	           	<input type="number" class="form-control" id="refund_amount" placeholder="Refund Amount" name="refund_amount" required>
	        </div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<!-- <label for="cancellation_reason_id">Cancellation Reason</label> -->
				<textarea name="cancellation_note" id="cancellation_note" class="form-control" required></textarea>
	        </div>
		</div>

          <div class="col-md-6">
			<div class="form-group">
				<label for="refund_amount">Is IGST :</label>
	           	<input type="checkbox"  id="is_igst"  name="is_igst" value="1" style="height: 25px;width:25px" >
	        </div>
		</div>


		<div class="col-sm-12">
			<div class="form-actions text-center">
				<button autocomplete="false"  type="submit" class="btn btn-primary btn-sm mr-1">
	                <i class="ft-check"></i> Cancel Booking
	            </button>
	            
	            <button type="reset" data-dismiss="modal" class="btn btn-danger btn-sm mr-1">
	                <i class="ft-x"></i> Close
	            </button>
	            
	        </div>
		</div>
		
	</div>	
</form>

	
<?php //}?>
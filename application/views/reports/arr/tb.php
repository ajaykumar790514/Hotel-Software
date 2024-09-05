<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
               <tr>
                    <th>Property</th>
                   <th>Arrival - Departure</th>
                    <th>Guest</th>
                    <th>Booked From</th>
                    <th>Room Plan</th>
                    <th>Booked On</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Sales</th>
					<th>Occupied Room</th>
					<th>Average</th>
               </tr>
               </thead>
                <tbody>
                    <?php $i=0;$TAverage=$Average=$Troom=$Rooms=$TSale =$TotalCreditAmount=$TotalDebitAmount=$TotalCredit=$TotalDebit=0;
                    foreach ($rows as $row):
					$Rooms = count($this->model->getDataRoomAllotment('room_allotment',['property_id'=>$row->property_id,'booking_id'=>$row->id,'is_checkout'=>'0']));	
                    $TotalCredit = $row->TCR;
                    $TotalDebit = $row->TDR; 
                     $TotalCreditAmount=$TotalCreditAmount+$TotalCredit;
                     $TotalDebitAmount=$TotalDebitAmount+$TotalDebit;
					 $TSale +=$row->total;
					 $Troom +=$Rooms;
					 if($Rooms > 0){
					 $Average = $row->total/$Rooms;
					 $TAverage = $TSale/$Troom;
					 }
                    ?>
                    <tr align="center">
                    <td><?= title('propmaster', $row->property_id, 'id', 'propname') ?>  <span class="text-info"><?= title('propmaster', $row->property_id, 'id', 'propcode') ?> </span> </td>
                        <td>
                            <?= _date($row->start_date) ?> <strong>&nbsp;-&nbsp;</strong> <?= _date($row->end_date) ?>
                        </td>
                        <td>
                            <?= $row->guest_name ?> <span class="text-info"><?= $row->contact ?></span>
                        </td>
                        <td><?=title('agent', $row->agent, 'id', 'name') ?> <span class="text-info"><?= title('agent', $row->agent, 'id', 'mobile') ?> </span> , <span class="text-info"><?= title('agent', $row->agent, 'id', 'company_name') ?> </span> </td>
                        <td><?= title('booking_type_master', $row->booking_type, 'id', 'name') ?></td>
                        <td><?= date_time($row->booking_date) ?></td>
                        <td>
                            <?= title('booking_status', $row->status, 'id', 'status') ?>
                        </td>
                        <td><?= title('payment_status', $row->payment_status, 'id', 'status') ?></td>
                        <td><?php echo setting()->currency.''.number_format($row->total,2); ?></td>
						<td><?=$Rooms;?></td>
						<td><?=setting()->currency.''.number_format($Average,2);?></td>
                    </tr> 
                    <?php endforeach; ?>
                    <tr>
                     <td colspan="8" align="right"><strong>Grand Total :</strong></td>
                      <td colspan="1" align="center"><strong><?=setting()->currency.number_format($TSale,2);?></strong></td>
					  <td colspan="1" align="center"><strong><?=$Troom;?></strong></td>
					  <td colspan="1" align="center"><strong><?=setting()->currency.number_format($TAverage,2);?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

 
<!-- </div> -->

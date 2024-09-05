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
                    <th>Total payout</th>
                    <th>Payment</th>
                    <th>Sales</th>
               </tr>
               </thead>
                <tbody>
                    <?php $i=0;$TSale =$TotalCreditAmount=$TotalDebitAmount=$TotalCredit=$TotalDebit=0;
                    foreach ($rows as $row):
                        $TotalCredit = $row->TCR;
                        $TotalDebit = $row->TDR; 
                     $TotalCreditAmount=$TotalCreditAmount+$TotalCredit;
                     $TotalDebitAmount=$TotalDebitAmount+$TotalDebit;
					 $TSale +=$row->total;
                    ?>
                    <tr>
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
                        <td><?php echo setting()->currency.''.$row->total; ?></td>
                        <td><?= title('payment_status', $row->payment_status, 'id', 'status') ?></td>
                        <td><?php echo setting()->currency.''.$row->total; ?></td>
                    </tr> 
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="9" align="right"><strong>Grand Total :</strong></td>
                      <td colspan="2" align="right"><strong><?=setting()->currency.$TSale;?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

 
<!-- </div> -->

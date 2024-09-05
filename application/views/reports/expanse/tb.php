<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
               <tr>
                    <th>Property</th>
                   <th>Expanse type</th>
                    <th>Transaction Date</th>
                    <th>Amount</th>
               </tr>
               </thead>
                <tbody>
                    <?php $i=0;$FinalAmount=$TotalAmount=0;
                    foreach ($rows as $row):
                        $TotalAmount = $row->Tamount;
                     $FinalAmount=$FinalAmount+$TotalAmount;
                    ?>
                    <tr>
                    <td><?= title('propmaster', $row->prop_master_id, 'id', 'propname') ?>  <span class="text-info"><?= title('propmaster', $row->prop_master_id, 'id', 'propcode') ?> </span> </td>
                        <td>
                        <?= title('expense_master', $row->expense_master_id, 'id', 'name') ?> 
                        </td>
                        <td>
                            <?= _date($row->date);?> </td>
                        <td><?=setting()->currency.$TotalAmount; ?></td>
                    </tr> 
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" align="right"><strong>Grand Total :</strong></td>
                      <td colspan="1" align="left"><strong><?=setting()->currency.$FinalAmount;?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

 
<!-- </div> -->

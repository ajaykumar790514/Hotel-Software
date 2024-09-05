<div class="card-body card-dashboard">
   <div class="table-responsive pt-1">
       <table class="table table-bordered base-style" id="mytable">
           <thead>
               <tr>
                    <th>Property</th>
                   <th>Bill No.</th>
                    <th>Transaction Date</th>
                    <th>Taxable Amount</th>
                    <th>IGST</th>
                    <th>CGST</th>
                    <th>SGST</th>
                    <th>Total Amount</th>
               </tr>
               </thead>
                <tbody>
                    <?php $i=0;$FinalTaxAbleAmount=$FinalIGSTAmount=$FinalSGSTAmount=$FinalCGSTAmount=$TotalAmount=0;
                    foreach ($rows as $row):
                     $receivedamount = $row->TCR;
                     $IGST_RATE=0.00;
                     $CGST_RATE=0.00;
                     $SGST_RATE=0.00;
                     $IgstSubTaxAmount=0.00;
                     $CgstSubTaxAmount=0.00;
                     $SGSTSubTaxAmount=0.00;
                     $IGSTFLAG=$CGSTFLAG=$SGSTFLAG=0;
                      if($row->is_igst==1)
                      {
                        $IGSTFLAG=1;
                        $CgstSubTaxAmount=0.00;
                        $SGSTSubTaxAmount=0.00;
                        $IGST_RATE  = tax_rate($receivedamount);
                        $SubTaxRate = get_tax_amount($receivedamount)['taxRate'];
                        $IgstSubTaxAmount = get_tax_amount($receivedamount)['taxAmount'];
                        $SubAmount = get_tax_amount($receivedamount)['Amount'];
                        $SubTotalAmount = get_tax_amount($receivedamount)['TotalAmount'];
                      }else
                      {
                       $CGSTFLAG=$SGSTFLAG=1;
                       $TaxRate  = tax_rate($receivedamount);
                       $CGST_RATE=$TaxRate/2;
                       $SGST_RATE=$TaxRate/2;
                       $IGST_RATE = 0.00;
                       $IgstSubTaxAmount=0.00;
                       $SubTaxRate = get_tax_amount($receivedamount)['taxRate'];
                       $SubTaxAmount = get_tax_amount($receivedamount)['taxAmount'];
                       $SubAmount = get_tax_amount($receivedamount)['Amount'];
                       $SubTotalAmount = get_tax_amount($receivedamount)['TotalAmount'];
                       $CgstSubTaxAmount=$SubTaxAmount/2;
                       $SGSTSubTaxAmount=$SubTaxAmount/2;
                      }
                     $FinalTaxAbleAmount = $FinalTaxAbleAmount+$SubAmount;
                     $FinalIGSTAmount = $FinalIGSTAmount+$IgstSubTaxAmount;
                     $FinalCGSTAmount = $FinalCGSTAmount+$CgstSubTaxAmount;
                     $FinalSGSTAmount = $FinalSGSTAmount+$SGSTSubTaxAmount;
                     $TotalAmount = $TotalAmount + $SubTotalAmount;
                    ?>
                    <tr>
                    <td><?= title('propmaster', $row->property_id, 'id', 'propname') ?>  <span class="text-info"><?= title('propmaster', $row->property_id, 'id', 'propcode') ?> </span> </td>
                    <td>
                        <?=$row->bill_no;?>
                    </td>
                        <td>
                            <?= _date($row->tr_date);?> </td>
                        <td><?=setting()->currency.$SubAmount; ?></td>
                        <td>
                            <?php if($IGSTFLAG==1){?>
                           ( <?=$IGST_RATE;?> % )
                           <p><?=$IgstSubTaxAmount;?></p>
                           <?php }?>
                        </td>
                        <td>
                        <?php if($CGSTFLAG==1){?>
                           ( <?=$CGST_RATE;?> % )
                           <p><?=$CgstSubTaxAmount;?></p>
                           <?php }?>
                        </td>
                        <td>
                        <?php if($SGSTFLAG==1){?>
                           ( <?=$SGST_RATE;?> % )
                           <p><?=$SGSTSubTaxAmount;?></p>
                           <?php }?>
                        </td>
                        <td>
                           <p><?=$SubTotalAmount;?></p>
                        </td>
                    </tr>  
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" align="right"><strong>Grand Total :</strong></td>
                      <td colspan="1" align="left"><strong><?=setting()->currency._number_format($FinalTaxAbleAmount);?></strong></td>
                      <td colspan="1" align="left"><strong><?=setting()->currency._number_format($FinalIGSTAmount);?></strong></td>
                      <td colspan="1" align="left"><strong><?=setting()->currency._number_format($FinalCGSTAmount);?></strong></td>
                      <td colspan="1" align="left"><strong><?=setting()->currency._number_format($FinalSGSTAmount);?></strong></td>
                      <td colspan="1" align="left"><strong><?=setting()->currency._number_format($TotalAmount);?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

 
<!-- </div> -->

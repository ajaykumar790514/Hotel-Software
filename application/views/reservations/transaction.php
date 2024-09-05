<section class="card">
	<div class="card-body">
		<form class="form ajaxsubmit reload-tb"  action="<?=$action_url?>" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group col-md-3">
		            <label>Select Payment/Received </label>
	                <select class="form-control" name="debit_type" required>
	                    <option value="1">Received </option>
	                    <option value="2">Payment </option>
	                </select>
		        </div>

				<div class="form-group col-md-3">
		            <label>Type</label>
		            <select class="form-control" name="type" required>
	                <?php 
	                echo optionStatus('','-- Select --',1);
	                foreach ($mode as $tmrow) { 
	                    $selected = '';                            
	                    echo optionStatus($tmrow->id,$tmrow->mode,$tmrow->status,$selected);                        
	                } ?>
	                </select>
		        </div>
		        
		        <div class="form-group col-md-3">
		            <label>Amount</label>
		            <input type="number" name="amount" class="form-control" step="0.01">
		        </div>

		        <div class="form-group col-md-3">
		            <label>Reference No.</label>
		            <input type="text" name="reference_no" class="form-control">
		        </div>
			</div>

			<div class="form-actions text-right">
                <button type="reset" data-dismiss="modal" class="btn btn-danger mr-1">
                    <i class="ft-x"></i> Cancel
                </button>
				<?php if($booking->status !=5){?>
                <button type="submit" class="btn btn-primary mr-1"  >
                    <i class="ft-check"></i> Save
                </button>
				<?php }?>
            </div>
		</form>
	</div>
	
</section>

<section>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped table-bordered">
			<input type="hidden" value="<?=$booking_id;?>" id="BookindID">
				<thead>
					<tr>
						<th>Date</th>
						<th>Type</th>
						<th>Credit</th>
						<th>Debit</th>
						<th>Reference No.</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="transactionTableBody">
					
					<?php
						$total_credit = 0;
						$total_debit = 0;

					 foreach($transaction as $row): ?>
					<tr>
						<th><?=date('d-m-Y',strtotime($row->tr_date))?></th>
						<td>
							<?php 
								foreach($mode as $m_row):
									if($row->type == $m_row->id):
										echo $m_row->mode;
									endif;
								endforeach;
							?>
						</td>
						<td><?=$row->credit?></td>
						<td><?=$row->debit?></td>
						<td><?=$row->reference_no?></td>
						<td>
						<?php if($booking->status !=5){?>
							<a href="javascript:void(0)" onclick="_deleteloadTrTable(this)" url="<?=$delete_url?>/<?=$row->id?>" title="Delete" >
                               <i class="la la-trash"></i>
                           	</a>
							<?php }?>
							<a  href="<?=$tr_receipt_url;?><?=$row->id ?>"  class="text-success" target="_blank" title="Receipt" >
							<i class=" la la-print" style="font-size:2rem"></i>
                           	</a>
						</td>
					</tr>
					<?php 
						$total_credit += $row->credit;
						$total_debit += $row->debit;
						endforeach; 
					?>
					<tr>
						<td colspan="2"><strong>Total</strong></td>
						<td><?=number_format($total_credit, 2)?></td>
						<td><?=number_format($total_debit, 2)?></td>
						<td></td>
						<td></td>
					</tr>
					
				</tbody>
			</table>
		</div>		
	</div>
</section>

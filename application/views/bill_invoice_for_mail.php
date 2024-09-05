<html>
	<head>
	<style>
    @media print {
        /* General Styles */
        body {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        
        .app-content {
            margin: 0;
            padding: 0;
        }

        .content-wrapper {
            padding: 0;
            margin: 0;
        }

        .reservation-checked-in-list {
            padding: 0;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .tb-width-fit-content {
            width: auto;
        }

        .no-border {
            border: none;
        }

        /* Hide elements that should not be printed */
        .print-hide {
            display: none;
        }
		.content-wrapper {
        margin: 0px;
    }
    }

    /* Screen Styles */
    .app-content {
        padding: 20px;
    }

    .content-wrapper {
        margin: 0px;
    }

    .reservation-checked-in-list {
        padding: 20px;
        margin: 20px 0;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
        text-align: center;
    }

    .text-center {
        text-align: center;
    }

    .tb-width-fit-content {
        width: auto;
    }

    .no-border {
        border: none;
    }
</style>
	</head>
	 <body onload="window.print()">
	
<div class="app-content content">
    <div class="content-wrapper">
<?php
$amount = tax_amount($row);
?>
<section class="card reservation-checked-in-list pt-3 mt-5 pb-5 pl-2 pr-2">
	<div class="row" id="print-div">
		<div class="col-md-12 ">
		<table class="table table-striped table-bordered">
				<thead>
				       <tr>
						<th colspan="12" rowspan="2" class="text-center">
							Hotel Details
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
					<td colspan="6" rowspan="2" class="text-center">
                            <p><strong style="text-align:center;font-size:1.4rem"><?=$propmaster->propname;?></strong>
                            <br><?= $propmaster->address ?></p>
                        </td>
						<td colspan="6" rowspan="3" class="text-center">
                            <p> <img src="<?=IMGS_URL.$propmaster->logo?>" height="70px"></p>
                        </td>
					</tr>
				</tbody>
		</table>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="2" class="text-center">
							Booking Details
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<table class="table table-striped table-bordered mb-0">

								<tbody>
									<tr>
										<th>Booking From</th>
										<td><?= title('booking_type', $row->booking_from, 'id', 'type') ?></td>
									</tr>
									<tr>
										<th>Status</th>
										<td><?= title('booking_status', $row->status, 'id', 'status') ?></td>
									</tr>

									<tr>
										<th>Arrival</th>
										<td><?= _date($row->start_date) ?></td>
									</tr>

									<tr>
										<th>Departure</th>
										<td><?= _date($row->end_date) ?></td>

									</tr>


									<tr>
										<th>Confirmation Code</th>
										<td><?= @$row->confirmation_code ?></td>
									</tr>


									<?php if ($row->status == 4) : ?>
										<tr>
											<th>Cancellation Reason</th>
											<td><?= title('cancellation_reason_master', $row->cancellation_reason_id, 'id', 'title') ?> </td>
										</tr>

										<?php if ($row->cancellation_note != '') : ?>
											<tr>
												<th>Cancellation Note</th>
											</tr>
											<tr>
												<td><?= $row->cancellation_note ?></td>
											</tr>
										<?php endif ?>
									<?php endif ?>
									<tr>
										<th>Room Plan</th>
										<td><?= title('booking_type_master', $row->booking_type, 'id', 'name') ?></td>

									</tr>
									<tr>
										<th>Booking Status</th>
										<td><?= title('booking_status', $row->status, 'id', 'status') ?></td>

									</tr>

								</tbody>
							</table>
						</td>
						<td class="p-0">
							<table class="table table-striped table-bordered mb-0">

								<tbody>

									<tr>
										<th>Amount </th>
										<td int><?=setting()->currency;?> <?= _number_format($row->total_withouttax+$row->discount_amount)?></td>
									</tr>

									<tr>
										<th>Discount</th>
										<td int><?=setting()->currency;?> <?= $row->discount_amount?></td>
									</tr>
								
									<tr>
										<th>Taxable Amount </th>
										<td int><?=setting()->currency;?> <?= $row->total_withouttax ?></td>
									</tr>
                                   <?php if($propmaster->is_gst=='YES'):?>
									<tr>
										<th>GST</th>
										<td int><?=setting()->currency;?> <?= $row->tax_value ?></td>
									</tr>

									<?php 
									endif;
										 $extra_amount = 0;
										   $end_date = $row->end_date;
										   $extra_nights_count =calculate_extra_nights($end_date);
										   $no_of_extra_nights = $extra_nights_count;
										   if($no_of_extra_nights > 0){
											$extra_amount = ($row->tax_value+$row->total_withouttax) * $no_of_extra_nights;
										   
										  
									 ?>
									 	<tr>
										<th>Extra Days Amount</th>
										<td int><?=setting()->currency;?> <?=_number_format($extra_amount) ?></td>
									</tr>
									<?php }?>
									<tr>
										<th>Sub Total </th>
										<td int><?=setting()->currency;?> <?= _number_format(($row->tax_value+$row->total_withouttax)+$extra_amount) ?></td>
									</tr>
									<?php $tr = $this->model->getRow('transaction',['booking_id'=>$row->id,'action'=>'booking'])?>
									<?php $trCheckout = $this->model->getData('transaction',['booking_id'=>$row->id,'action'=>'checkout']);
									 $trTransaction = $this->model->getData('transaction',['booking_id'=>$row->id,'action'=>'booking','remark'=>'Transaction']);
									  $trCheckoutAmt = 0;
									  $trTransactionAmt=0;
                                      foreach($trCheckout as $amt):
										$trCheckoutAmt +=$amt->credit ;
									  endforeach;
									  foreach($trTransaction as $tamt):
										$trTransactionAmt +=$tamt->credit ;
									  endforeach;
									  ?>
									  <?php $checkout_new = $this->model->getData('checkout_new',['booking_id'=>$row->id]);
									 $recieved= $food_amt=$other_amt=$discount_amt =$round_off= 0;
                                      foreach($checkout_new as $checkout):
										$food_amt +=$checkout->food_amount ;
										$other_amt +=$checkout->other_amount ;
										$discount_amt +=$checkout->lump_sum_discount ;
										$round_off +=$checkout->round_off ;
									  endforeach;
									  if((($food_amt+$other_amt)-$discount_amt)+(-$round_off) > 0){
										$recieved = (($food_amt+$other_amt)-$discount_amt)+(-$round_off);
									  }
									   
									  ?>
									<tr>
										<th>Advance</th>
										<td int><?=setting()->currency;?> <?=$tr->credit;?></td>
									</tr>

									<?php if ($row->checkin_status=='1') : ?>
										<tr>
											<th> Checkin Amount</th>
											<td int><?=setting()->currency;?><?= $amount['pre_checkin_amount'] ?></td>
										</tr>

									<?php endif ?>
									<?php if ($trCheckoutAmt > 0) : ?>
										<tr>
											<th>Checkout Amount</th>
											<td int><?=setting()->currency;?><?= _number_format($trCheckoutAmt)?></td>
										</tr>

									<?php endif ?>


									<?php if ($row->status == 4) : ?>
										<tr>
											<th>Refund Amount</th>
											<td int><?=setting()->currency;?><?= $row->refund_amount ?></td>
										</tr>

									<?php endif ?>
									<?php if ($trTransactionAmt > 0) : ?>
										<tr>
											<th>Transaction</th>
											<td int><?=setting()->currency;?><?= $trTransactionAmt ?></td>
										</tr>

									<?php endif ?>
									


								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th center>Balance</th>
						<td style="text-align: center;"> <?=setting()->currency;?> <?= _number_format((((((($row->tax_value+$row->total_withouttax)+$extra_amount)-$tr->credit)-$amount['pre_checkin_amount'])-$trCheckoutAmt)-$trTransactionAmt)+$recieved)?></td>

					</tr>
				</tfoot>
			</table>




		</div>

		<div class="col-md-3 ">
			<table class="table table-new table-striped table-bordered" >
				<thead>
					<tr>
						<th colspan="2" class="text-center">
							Guest Details
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>Guest Name</th>
						<td><?= $row->guest_name ?></td>
					</tr>

					<tr>
						<th>Gender</th>
						<td><?= $row->gender ?></td>
					</tr>

					<tr>
						<th>Email</th>
						<td><?= $row->email ?></td>
					</tr>

					<tr>
						<th>Contact</th>
						<td><?= $row->contact ?></td>
					</tr>

					<tr>
						<th>Of Adults</th>
						<td><?= $row->of_adults ?></td>
					</tr>

					<tr>
						<th>Of Children</th>
						<td><?= $row->of_children ?></td>
					</tr>

					<tr>
						<th>Of Infants</th>
						<td><?= $row->of_infants ?></td>
					</tr>

					<tr>
						<th>Booked On</th>
						<td><?= date_time($row->booking_date) ?></td>
					</tr>

					<tr>

					</tr>
				</tbody>
			</table>
		</div>

		<div class="col-md-9 ">
			<table class="table table-new table-striped table-bordered" >
				<thead>
					<tr>
						<th>Rooms Type</th>
						<th int class="tb-width-fit-content">Price</th>
						<th int class="tb-width-fit-content">Quantity</th>
						<th int class="tb-width-fit-content">Extra Bedding</th>
						<th int class="tb-width-fit-content">Discount</th>
						<th int class="tb-width-fit-content">Total WithoutTax</th>
						<?php if($propmaster->is_gst=='YES'):?>
						<th int class="tb-width-fit-content">Tax</th>
						<?php endif;?>
						<th int class="tb-width-fit-content">Total WithTax</th>
					</tr>
				</thead>
				<tbody>
					<?php if (@$items) { ?>
						<?php foreach ($items as $key => $value) { ?>
							<tr>
								<td><?= $value->type ?> <?= (@$value->flats) ? '(<b>' . $value->flats . '</b>)' : '' ?></td>
								<td int class="tb-width-fit-content"><?= $value->price ?></td>
								<td int class="tb-width-fit-content"><?= $value->qty ?></td>
								<td int class="tb-width-fit-content"><?= $value->extra_bedding_total ?></td>
								<td int class="tb-width-fit-content"><?= $value->total_discount ?></td>
								<td int class="tb-width-fit-content"><?= $value->total_withouttax ?></td>
								<?php if($propmaster->is_gst=='YES'):?>
								<td int class="tb-width-fit-content">( <?= $value->tax_per ?> % )  <?= $value->tax_value ?></td>
								<?php endif;?>
								<td int class="tb-width-fit-content"><?= $value->total?></td>
							</tr>

						<?php } ?>
					<?php } ?>
				</tbody>
			</table>


			<table class="table table-new table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="2" class="text-center">
							Agent Details
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>Agent Name</th>
						<td>
							<?= @$agent->name ?>
						</td>
					</tr>
					<tr>
						<th>Mobile No.</th>
						<td>
							<?= @$agent->mobile ?>
						</td>
					</tr>

				</tbody>
			</table>
		</div>


		<?php if (@$transaction) { ?>
			<div class="col-md-12">
				<table class="table table-new table-striped table-bordered">
					<thead>
						<tr>
							<th colspan="5" class="text-center">
								Transactions
							</th>
						</tr>

						<tr>
							<th>Date</th>
							<th>Type</th>
							<th>Credit</th>
							<th>Debit</th>
							<th>Reference No.</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$total_credit = 0;
						$total_debit = 0;
						foreach ($transaction as $row) : ?>
							<tr>
								<th><?= $row->tr_date ?></th>
								<td>
									<?= title('payment_mode', $row->type, 'id', 'mode') ?>

								</td>
								<td><?= $row->credit ?></td>
								<td><?= $row->debit ?></td>
								<td><?= $row->reference_no ?></td>

							</tr>
						<?php
							$total_credit += $row->credit;
							$total_debit += $row->debit;
						endforeach;
						?>
						<tr>
							<td colspan="2" center><strong>Total</strong></td>
							<td><?= number_format($total_credit, 2) ?></td>
							<td><?= number_format($total_debit, 2) ?></td>
							<td></td>
						</tr>

					</tbody>
				</table>
			</div>
		<?php } ?>



		<?php if (isset($document)) { ?>
			<div class="col-md-12">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th colspan="9" class="text-center">
								Guest Document Details
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Guest Name</th>
							<th>Nationality</th>
							<th>Proof Type</th>
							<th>Proof No.</th>
							<th>Proof Front</th>
							<th>Proof Back</th>
							<th>Agreement</th>
							<th>Guest Photo</th>
						</tr>
						<?php foreach ($document as $doc) : ?>
							<tr>
								<td><?= $doc->name ?></td>
								<td><?= $doc->nationality ?></td>
								<td><?= $doc->id_proof_type ?></td>
								<td><?= $doc->id_proof_no ?></td>
								<td><img src="<?= IMGS_URL . $doc->id_proof_pic_front ?>" class="zoom-img" width="100"></td>
								<td><img src="<?= IMGS_URL . $doc->id_proof_pic_back ?>" class="zoom-img" width="100"></td>
								<td><a href="<?= IMGS_URL . $doc->agreement_doc ?>" target="_blank" class="btn btn-primary btn-sm">View</a></td>
								<td><img src="<?= IMGS_URL . $doc->guest_photo ?>" class="zoom-img" width="100"></td>
								
							</tr>
						<?php endforeach; ?>

					</tbody>
				</table>

			</div>
		<?php } ?>
	</div>
</section>
</div>
</div>
	
	 
</body>
</html>

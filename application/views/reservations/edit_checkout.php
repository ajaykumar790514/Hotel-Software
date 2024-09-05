
<form class="form ajaxsubmit reload-page" action="<?= base_url() ?>checkout/edit_checkout/<?= $checkout_new->id ?>" method="POST" enctype="multipart/form-data" autocomplete="off">

	<!-- <div class="row m-1 pt-1 pb-1">
		<div class="col-md-12 ">
			<div class="form-group">
				<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">
			</div>
		</div>
	</div> -->
<input type="hidden" name="booking_id" value="<?=$booking->id;?>">
	<div class="row p-0 mt-4">
	<div class="col">
	<div class="table-responsive pt-1">
	<table class="table table-bordered base-style">
				<thead>
					<tr>
						<th colspan="12" center> <?= $propmaster->propname ?> </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th>GUEST NAME</th>
						<td colspan="7">
							<input class="form-control input-sm" name="guest_name" value="<?=$checkout_new->guest_name;?>">
							<input type="hidden" name="checkout_id" value="<?=$checkout_new->id?>">
						</td>
						<td colspan="5" rowspan="3" center><?= $propmaster->address ?></td>
					</tr>

					<tr>
						<th>CONTACT NO.</th>
						<td colspan="7">
							<input type="number" class="form-control input-sm" name="contact_no" value="<?=$checkout_new->contact_no;?>">
						</td>
					</tr>

					<tr>
						<th>EMAIL</th>
						<td colspan="7">
							<input type="email" class="form-control input-sm" name="email" value="<?=$checkout_new->email;?>">
						</td>
					</tr>

					<tr>
						<th>COMPANY NAME</th>
						<td colspan="7">
							<input class="form-control input-sm" name="company_name" value="<?=$checkout_new->company_name;?>">
						</td>
						<th>BILL NO.</th>
						<th colspan="3"><?=$checkout_new->bill_no;?></th>
					</tr>

					<tr>
						<th>ADDRESS</th>
						<td colspan="7">
							<input class="form-control input-sm" name="address" value="<?=$checkout_new->address;?>">
						</td>
						<th>COMPANY NAME(HOTEL)</th>
						<td colspan="3"><?= $propmaster->propname ?></td>
					</tr>

					<tr>
						<th>GST NO.</th>
						<td colspan="7">
							<input class="form-control input-sm" name="gst_no" value="<?=$checkout_new->gst_no;?>">
						</td>
						<th>GST NO.</th>
						<td colspan="3"><?=$checkout_new->property_gst;?></td>
					</tr>

					<tr>
						<th>ROOM NO.</th>
						<th>ARRIVAL</th>
						<th>DEPARTURE</th>
						<th int>DAYS</th>
						<th int>EXTRA DAYS</th>
						<th int>ROOM RENT</th>
						<th>EXTRA BEDDING</th>
						<th int class="tb-width-fit-content">TAX</th>
						<th int class="tb-width-fit-content">DISCOUNT</th>
						<th int class="tb-width-fit-content">CHECKIN AMOUNT</th>
						<th int class="tb-width-fit-content">EXTRA DAYS AMT</th>
						<th int class="tb-width-fit-content">TOTAL AMOUNT</th>
					</tr>
					
					<?php
					$TPre = $Tqty = 0;
					foreach ($checkin_rooms as $key => $value) { 
						$CheckExistCheckin = $this->model->CheckExistCheckin($value->id);
                         ?>
						<tr class="<?= ($value->is_checked_out) ?>" >
							<td>
								<label>
									<input type="checkbox" id="check_in_id" name="check_in_id[]" value="<?= $value->id ?>" <?php if($CheckExistCheckin>=1){ echo "checked";} ;?> >
									<?= $value->room_no ?> (<?= $value->room_type_name ?>)
								</label>
							</td>
							<td><?= _date($value->start_date) ?></td>
							<td><?= _date($value->end_date) ?></td>
							<td int><?= $value->no_of_nights ?></td>
							<td int><?php echo $value->no_of_extra_nights;?></td>
							<td int><?= $value->price ?></td>
							<td int><?= $value->extra_bed_price ?></td>
							<td int class="tb-width-fit-content"><?= $value->taxAmount ?></td>
							<td int class="tb-width-fit-content"><?= _number_format($value->discount) ?></td>
							<td int class="tb-width-fit-content"> <span class="pre_checkin_total"><?= $value->pre_checkin_amount ?></td>
							<td int class="tb-width-fit-content"><?php echo $extra_amt=_number_format(($value->total_new)*$value->no_of_extra_nights)?></td>
							<td int class="tb-width-fit-content"> <span class="total-room"><?=_number_format(($value->total)+$extra_amt)?></span></td>
						</tr>
						<?php 
                        $TPre = $TPre+$value->pre_checkin_amount;
                        $Tqty = $Tqty+1;?>
					<?php } ?>
					<?php 
					$tr = $this->model->getData('transaction', ['booking_id' => $booking->id,'action'=>'booking']);
					$PerRoomDiscount =$Tcredit = 0;
					foreach($tr as $t)
					{
                     $Tcredit = $Tcredit +$t->credit;
					}
					 $roomqty =  $booking_items_qty;
				     $Tprice = $booking_items->total-$booking_items->total_discount;
					  $TAdvance = $Tcredit;
				      $PerRoomDiscount = $TAdvance / $roomqty;
                       $PaidAmount = ($PerRoomDiscount * $Tqty)+$TPre;
					  ?>
					  <input type="hidden" name="per_room_discount" class="per_room_discount" value="<?=$PerRoomDiscount;?>">
					  <input type="hidden" name="total_amount_booking" value="<?=$Tprice;?>">
					<tr>
						<th colspan="7" center>MODE OF PAYMENT</th>
						<th colspan="5" center>TOTAL</th>
					</tr>

					<tr>
						<td colspan="7" class="p-0" style="vertical-align: top!important;">
							<table class="table table-bordered m-0">
								<thead>
									<tr>
										<th>AMOUNT</th>
										<th>MODE OF PAYMENT</th>
										<th>DATE OF PAYMENT</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($transaction as $t_key => $t_value) {
									?>
										<tr>
											<td class="<?= (@$t_value->debit) ? 'text-danger' : '' ?>">
												<?= (@$t_value->debit) ? _number_format($t_value->debit) : ''  ?>
												<?= (@$t_value->credit) ? _number_format($t_value->credit) : ''  ?>
											</td>
											<td><?= title('payment_mode', $t_value->type, 'id', 'mode') ?></td>
											<td><?= _date($t_value->tr_date) ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</td>
						<td></td>
						<td colspan="5" center class="p-0">
							<table class="table table-bordered m-0">

								<tbody>
									<tr>
										<th>FOOD AMOUNT</th>
										<td>
											<input type="number" step="0.01" id="food_amount" name="food_amount" style="float:right;" value="<?=$checkout_new->food_amount;?>">
										</td>
									</tr>
									<tr>
										<th>OTHER AMOUNT</th>
										<td>
											<input type="number" step="0.01" id="other_amount" name="other_amount" style="float:right;" value="<?=$checkout_new->other_amount;?>">
										</td>
									</tr>
									<tr>
										<th>GRAND TOTAL</th>
										<td id="grand_total" int>
											<input type="number" step="0.01" name="grand_total" value="<?=$checkout_new->grand_total;?>" readonly>
										</td>
									</tr>
									<tr>
										<th>PAID</th>
										<td id="paid_total" int>
											<input type="number" step="0.01" name="paid_total" value="<?=$PaidAmount;?>" readonly>
										</td>
									</tr>
									<tr>
										<th>BALANCE</th>
										<td id="balance_total" int>
											<input type="number" step="0.01" class="balance_total" name="balance_total" value="<?=$checkout_new->grand_total-$PaidAmount;?>" readonly>
										</td>
									</tr>
									<tr>
										<th>LUMP SUM DISCOUNT</th>
										<td>
											<input type="number" id="lump_sum_discount" name="lump_sum_discount" class="lump_sum_discount" value="<?=$checkout_new->lump_sum_discount;?>" style="float:right;"  oninput="validate_lumsum()">
										</td>
									</tr>
									<tr>
									<th>ROUNDED OFF</th>
									<td>
										<input type="number" step="0.01" name="rounded_balance" style="float:right;" value="<?=$checkout_new->round_off;?>" readonly>
									</td>
								   </tr>
									<tr>
										<th>PAYMENT RECEIVED</th>
										<td><input type="number" step="0.01" name="paidable_amount" value="<?=$checkout_new->received_amount;?>" style="float:right;" ></td>
									</tr>
									<tr>
										<th>IGST</th>
										<td><input type="checkbox" value="1" name="is_igst" <?php if($checkout_new->is_igst==1){echo "checked";} ;?> style="height:20px;width:20px"></td>
									</tr>
									<tr>
										<th>BILL TO COMPANY</th>
										<td><input type="checkbox" value="1" name="bill_to_company" style="height:20px;width:20px"  <?php if($checkout_new->bill_to_company==1){echo "checked";} ;?>></td>
										
									</tr>
								</tbody>
							</table>
						</td>
					</tr>

				</tbody>
			</table>
		</div>
		</div>
	</div>




<div class="row pt-1 pb-1">
<div class="col-md-3">
            <div class="form-group">
                <label for="discount_amount">Payment Mode <sup>*</sup></label>
                <select autocomplete="random-value" name="payment_mode" id="payment_mode" class="form-control payment_mode">
					<option value="">--Select--</option>
                    <?php
                    foreach ($payment_mode as $row):?>
					<option value="<?=$row->id;?>"  <?php if($row->id==$checkout_new->payment_status){echo "selected";} ;?>  ><?=$row->mode;?></option>
                <?php endforeach;?>
                </select>
            </div>

        </div>

        <div class="col-md-4 reference_id d-none">
            <div class="form-group">
                <label for="reference_id">Reference Id</label>
                <input autocomplete="random-value" type="text" class="form-control" id="reference_id" placeholder="Reference Id" name="reference_id">
            </div>
        </div>
</div>

	<div class="row m-1 pt-1 pb-1">
		<div class="col-md-12 ">
			<div class="form-group">
				<input type="submit" class="btn btn-primary btn-sm float-right" value="Check Out">
				<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Cancel / Back">
			</div>
		</div>
	</div>
</form>


	
</script>

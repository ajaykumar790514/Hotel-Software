
<form class="form ajaxsubmit reload-page" action="<?= base_url() ?>checkout/<?= $booking->id ?>" method="POST" enctype="multipart/form-data" autocomplete="off">

	<!-- <div class="row m-1 pt-1 pb-1">
		<div class="col-md-12 ">
			<div class="form-group">
				<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Back">
			</div>
		</div>
	</div> -->

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
							<input class="form-control input-sm" name="guest_name" placeholder="Guest Name" value="<?=@$booking->guest_name;?>">
							<input type="hidden" name="booking_id" value="<?=$booking->id?>">
						</td>
						<td colspan="4" rowspan="3" center><?= $propmaster->address ?></td>
					</tr>

					<tr>
						<th>CONTACT NO.</th>
						<td colspan="7">
							<input type="number" class="form-control input-sm" name="contact_no" placeholder="CONTACT NO." value="<?=@$booking->contact;?>">
						</td>
					</tr>

					<tr>
						<th>EMAIL</th>
						<td colspan="7">
							<input type="email" class="form-control input-sm" name="email" value="<?=@$booking->email;?>" placeholder="EMAIL">
						</td>
					</tr>

					<tr>
						<th>COMPANY NAME</th>
						<td colspan="7">
							<input class="form-control input-sm" name="company_name" placeholder="COMPANY NAME">
						</td>
						<th>BILL NO.</th>
						<th colspan="3">##########</th>
					</tr>

					<tr>
						<th>ADDRESS</th>
						<td colspan="7">
							<input class="form-control input-sm" name="address" placeholder="ADDRESS">
						</td>
						<th>COMPANY NAME(HOTEL)</th>
						<td colspan="3"><?= $propmaster->propname ?></td>
					</tr>

					<tr>
						<th>GST NO.</th>
						<td colspan="7">
							<input class="form-control input-sm" name="gst_no" placeholder="GST NO.">
						</td>
						<?php if($propmaster->is_gst=='YES'):?>
						<th>GST NO.</th>
						<td colspan="3">AUTOMATIC</td>
						<?php endif;?>
					</tr>

					<tr>
						<th>ROOM NO.</th>
						<th>ARRIVAL</th>
						<th>DEPARTURE</th>
						<th int>DAYS</th>
						<th int>EXTRA DAYS</th>
						<th int>ROOM RENT</th>
						<th int>EXTRA BEDDING</th>
						<?php if($propmaster->is_gst=='YES'):?>
						<th int class="tb-width-fit-content">GST</th>
						<?php endif;?>
						<th int class="tb-width-fit-content">DISCOUNT</th>
						<th int class="tb-width-fit-content">CHECKIN AMOUNT</th>
						<th int class="tb-width-fit-content">EXTRA DAYS AMT</th>
						<th int class="tb-width-fit-content">TOTAL AMOUNT</th>
					</tr>
					<?php 
					
					$tr = $this->model->getData('transaction', ['booking_id' => $booking->id,'action'=>'booking']);
					$Tcredit = 0;
					foreach($tr as $t)
					{
                     $Tcredit = $Tcredit +$t->credit;
					}
					
					$PerRoomDiscount =$Tprice= 0;
					if(!empty($booking_items)){
					 $roomqty =  $booking_items_qty;
				     $Tprice = $booking_items->total-$booking_items->total_discount;
					
					  $TAdvance = $Tcredit;
					  $PerRoomDiscount = $TAdvance / $roomqty;
					}
					// short amount
					$Tshort =$TshortQtywise= 0;
					foreach($checkout as $out)
					{
                    $Tshort = $Tshort + $out->short_amount;
					}
					if(!empty($Tshort)){
					$TshortQtywise = $Tshort/($roomqty-$Tchechoutqty);
					}
				   $TshortQtywise;
					  ?>
					 
					<?php
					$Tqty = 0;
					foreach ($checkin_rooms as $key => $value) { ?>
						<tr class="<?= ($value->is_checked_out) ? 'text-line-through' : '' ?>" >
							<td>
								<label>
									<input type="checkbox" name="check_in_id[]" value="<?= $value->id ?>" <?= ($value->is_checked_out) ? 'disabled' : '' ?>>
									<?= $value->room_no ?> (<?= $value->room_type_name ?>)
								</label>
							</td>
							<td><?= _date($value->start_date) ?></td>
							<td><?= _date($value->end_date) ?></td>
							<td int><?= $value->no_of_nights ?></td>
							<td int><?php echo $value->no_of_extra_nights;?></td>
							<td int><?= $value->price ?></td>
							<td int><?= $value->extra_bed_price;?></td>
							<?php if($propmaster->is_gst=='YES'):?>
							<td int class="tb-width-fit-content"><?= $value->taxAmount ?></td>
							<?php endif;?>
							<td int class="tb-width-fit-content"><?= _number_format($value->discount) ?></td>
							
							<td int class="tb-width-fit-content"> <span class="pre_checkin_total"><?= $value->pre_checkin_amount ?></span></td>
							<td int class="tb-width-fit-content"><?php echo $extra_amt=_number_format(($value->total_new)*$value->no_of_extra_nights)?></td>
							<td int class="tb-width-fit-content"> <span class="total-room"><?=_number_format(($value->total)+$extra_amt)?></span></td>
						</tr>
						<?php $Tqty = $Tqty+1;?>
					<?php } ?>
					  <input type="hidden" name="per_room_discount" class="per_room_discount" value="<?=$PerRoomDiscount;?>">
					  <input type="hidden" name="total_amount_booking" value="<?=$Tprice;?>">
					  <input type="hidden" id="shortamountqty" class="shortamountqty" value="<?=$TshortQtywise;?>">
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
											<input type="number" step="0.01" name="food_amount" style="float:right;">
										</td>
									</tr>
									<tr>
										<th>OTHER AMOUNT</th>
										<td>
											<input type="number" step="0.01" name="other_amount" style="float:right;">
										</td>
									</tr>
									<tr>
										<th>GRAND TOTAL</th>
										<td id="grand_total" int>
											<input type="number" step="0.01" name="grand_total" readonly>
										</td>
									</tr>
									<tr>
										<th>Short Amount</th>
										<td id="short_amount" int>
											<input type="number" step="0.01" name="short_amount" readonly>
										</td>
									</tr>
									<tr>
										<th>PAID</th>
										<td id="paid_total" int>
											<input type="number" step="0.01" name="paid_total" readonly>
										</td>
									</tr>
									<tr>
										<th>BALANCE</th>
										<td id="balance_total" int>
											<input type="number" step="0.01" class="balance_total" name="balance_total" readonly>
										</td>
									</tr>
									<tr>
										<th>LUMP SUM DISCOUNT</th>
										<td>
											<input type="number" name="lump_sum_discount" class="lump_sum_discount" style="float:right;"  oninput="validate_lumsum()">
										</td>
									</tr>
									<tr>
									<th>ROUNDED OFF</th>
									<td>
										<input type="number" step="0.01" name="rounded_balance" style="float:right;" readonly>
									</td>
								   </tr>
									<tr>
										<th>PAYMENT RECEIVED</th>
										<td><input type="number" step="0.01"  class="paidable_amount" name="paidable_amount" style="float:right;"></td>
									</tr>
									<?php if($propmaster->is_gst=='YES'):?>
									<tr>
										<th>IGST</th>
										<td><input type="checkbox" value="1" name="is_igst" style="height:20px;width:20px"></td>
										
									</tr>
									<?php endif;?>
									<tr>
										<th>BILL TO COMPANY</th>
										<td><input type="checkbox" value="1" name="bill_to_company" style="height:20px;width:20px"></td>
										
									</tr>
									<tr style="display: none;">
										<td><input type="number" step="0.01" name="paidable_short_amount" id=""></td>
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
                <select autocomplete="random-value" name="payment_mode" id="payment_mode" class="form-control payment_mode" required>
                    <?php
                    echo optionStatus('', '-- Select --', 1);
                    foreach ($payment_mode as $row) {
                        echo optionStatus($row->id, $row->mode, 1);
                    }
                    ?>
                </select>
            </div>

        </div>

        <div class="col-md-4 reference_id d-none">
            <div class="form-group">
                <label for="reference_id">Reference Id</label>
                <input autocomplete="random-value" type="text" class="form-control" id="reference_id" placeholder="Reference Id" name="reference_id" >
            </div>
        </div>
</div>



	<div class="row m-1 pt-1 pb-1">
		<div class="col-md-12 ">
			<div class="form-group">
			<?php 
				 $count = $this->model->Counter('booking_new', array('id' => $booking->id,'status'=>'4'));
				 if($count==0){?>
				<input type="submit" class="btn btn-primary btn-sm float-right" value="Check Out">
				<?php }?>
				<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkout-close" value="Cancel / Back">
				
			</div>
		</div>
	</div>
</form>


<script>
	// $(document).on('change | keyup',
	// 	`[name="check_in_id[]"], [name="food_amount"], [name="other_amount"], [name="lump_sum_discount"], [name="paidable_amount"]`,
	// 	function() {
	// 		let _form = $(this).parents('form');
	// 		calculate_grand_total(_form);
	// 	})

	
	// function calculate_grand_total(_form) {
	// 	let room_no = _form.find(`[name="check_in_id[]"]`);
    //     let pre_checkin_amount=0;
	// 	let grand_total = 0;
    //     let room_qty =0; 
    //     let short_amount =0; 
    //     let short=0;
	// 	$.each(room_no, function() {
	// 		let _this = $(this);
	// 		if (_this.is(':checked')) {
	// 			let _tr = _this.parents('tr');
    //             let shortamountqty = $(".shortamountqty").val();
    //             let per_room_discount = $(".per_room_discount").val();
	// 			let total_room = parseFloat(_tr.find('.total-room').text());
	// 			grand_total += total_room;
    //             let pre_checkin_total = parseFloat(_tr.find('.pre_checkin_total').text());
    //             pre_checkin_amount += pre_checkin_total;
                
    //             room_qty +=1;
    //             total_paid = (room_qty*per_room_discount)+pre_checkin_amount;
    //             short_amount = room_qty*shortamountqty;
	// 			// console.log(_this.val());
	// 		} else {
	// 			// console.log('not');
	// 		}

	// 	})

	// 	setTimeout(() => {
           
	// 		let food_amount = _form.find(`[name="food_amount"]`).val();
	// 		let other_amount = _form.find(`[name="other_amount"]`).val();
	// 		let lump_sum_discount = _form.find(`[name="lump_sum_discount"]`).val();
    //         let paidable_amount = _form.find(`[name="paidable_amount"]`).val();
            
	// 		// let discount = $(`[name="discount_amount"]`).val(finalDiscount);
	// 		food_amount = (food_amount) ? parseInt(food_amount) : 0;
	// 		other_amount = (other_amount) ? parseInt(other_amount) : 0;
	// 		lump_sum_discount = (lump_sum_discount) ? parseInt(lump_sum_discount) : 0;
    //         paidable_amount = (paidable_amount) ? parseInt(paidable_amount) : 0;


	// 		grand_total += food_amount;
	// 		grand_total += other_amount;
	// 		grand_total -= lump_sum_discount;
           
    //         if(paidable_amount==0)
    //         {
    //            short=0;
    //         }
    //         else
    //         {
    //             short = ((grand_total-total_paid)+short_amount)-paidable_amount;
    //         }
	// 		_form.find(`[name="grand_total"]`).val((grand_total.toFixed(2)))
    //         _form.find(`[name="paid_total"]`).val((total_paid.toFixed(2)))
    //         _form.find(`[name="balance_total"]`).val((((grand_total-total_paid)+short_amount)-paidable_amount).toFixed(2))
    //         _form.find(`[name="short_amount"]`).val((short_amount.toFixed(2)))
    //         _form.find(`[name="paidable_short_amount"]`).val(short.toFixed(2));
            
	// 		console.log(grand_total);
	// 	}, 1000)
	// }
	$(document).on('change keyup', 
    `[name="check_in_id[]"], [name="food_amount"], [name="other_amount"], [name="lump_sum_discount"], [name="paidable_amount"]`, 
    function() {
        let _form = $(this).parents('form');
        calculate_grand_total(_form);
    }
);

function calculate_grand_total(_form) {
    let room_no = _form.find(`[name="check_in_id[]"]`);
    let pre_checkin_amount = 0;
    let grand_total = 0;
    let room_qty = 0; 
    let short_amount = 0;
    let short = 0;
    $.each(room_no, function() {
        let _this = $(this);
        if (_this.is(':checked')) {
            let _tr = _this.parents('tr');
            let shortamountqty = $(".shortamountqty").val();
            let per_room_discount = $(".per_room_discount").val();
            let total_room = parseFloat(_tr.find('.total-room').text());
            grand_total += total_room;
            let pre_checkin_total = parseFloat(_tr.find('.pre_checkin_total').text());
            pre_checkin_amount += pre_checkin_total;
            room_qty += 1;
            total_paid = (room_qty * per_room_discount) + pre_checkin_amount;
            short_amount = room_qty * shortamountqty;
        }
    });

    setTimeout(() => {
        let food_amount = _form.find(`[name="food_amount"]`).val();
        let other_amount = _form.find(`[name="other_amount"]`).val();
        let lump_sum_discount = _form.find(`[name="lump_sum_discount"]`).val();
        let paidable_amount = _form.find(`[name="paidable_amount"]`).val();

        food_amount = food_amount ? parseFloat(food_amount) : 0;
        other_amount = other_amount ? parseFloat(other_amount) : 0;
        lump_sum_discount = lump_sum_discount ? parseFloat(lump_sum_discount) : 0;
        paidable_amount = paidable_amount ? parseFloat(paidable_amount) : 0;

        grand_total += food_amount;
        grand_total += other_amount;
        grand_total -= lump_sum_discount;

        if (paidable_amount == 0) {
            short = 0;
        } else {
            short = ((grand_total - total_paid) + short_amount) - paidable_amount;
        }

        let balance = ((grand_total - total_paid) + short_amount) - paidable_amount;
        let rounded_balance = Math.round(balance);
        let decimal_balance = (balance - rounded_balance).toFixed(2);

     

        _form.find(`[name="grand_total"]`).val(grand_total.toFixed(2));
        _form.find(`[name="paid_total"]`).val(total_paid.toFixed(2));
        _form.find(`[name="balance_total"]`).val(rounded_balance);
        _form.find(`[name="short_amount"]`).val(short_amount.toFixed(2));
        _form.find(`[name="paidable_short_amount"]`).val(short.toFixed(2));
        _form.find(`[name="rounded_balance"]`).val(decimal_balance);

        console.log(grand_total);
    }, 1000);
}

	
</script>

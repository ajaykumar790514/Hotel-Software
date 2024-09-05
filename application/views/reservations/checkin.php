<!-- <form class="form ajaxsubmit reload-page-content" action="<?= base_url() ?>checkin/<?= $booking->id ?>" method="POST" enctype="multipart/form-data" autocomplete="off"> -->

<div class="row m-1">
	
<div class="col-md-10">
<?php 
$totaladults = $booking->of_adults;
$totalchild = $booking->of_children;
$totalinfant = $booking->of_infants;
$extrabed  = $items->extra_bedding;
$extra_bedding_price  = $items->extra_bedding_price;
?>
		<h4><strong>Total No of Persons</strong></h4>
		<div class="table-responsive">
		<table class="table  table-bordered table-stripped">
			<tr>
				<th>Adults</th>
				<th>Children</th>
				<th>Children</th>
				<th>Total</th>
				<th>Total Received Amount</th>
				<th>Remaining Amount</th>
				<th>Other Charges</th>
			</tr>
			<tr>
				<td><?=$booking->of_adults;?></td>
				<td><?=$booking->of_children;?></td>
				<td><?=$booking->of_infants;?></td>
				<td><?=setting()->currency;?> <?=bcdiv($totalpayout, 1, 2);?></td>
				<td><?=setting()->currency;?>  <?=bcdiv($totalreceived, 1, 2);?></td>
				<td><?=setting()->currency;?>  <?php echo  bcdiv(($totalpayout-$totalreceived)+$othercharges, 1, 2);?></td>
				<td><?=setting()->currency;?> <?=bcdiv($othercharges, 1, 2);?></td>
			</tr>
		</table>
		</div>
	</div>
	<input type="hidden" name="final_total" id="final_total" value="<?=$totalpayout-$totalreceived;?>">
	<div class="col-md-2 ">
		<div class="form-group">
			<input type="reset" class="btn btn-danger btn-sm float-right mr-1 checkin-close checkout-close" value="Back">
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<h5><strong>Room Allotment</strong> <button type="button" class="bg-success ml-2" style="border: none;height:15px"></button> = Room Alloted <button type="button" class="bg-warning ml-2" style="border: none;height:15px"></button> = Room Not Alloted</h5>
		<span></span>
	</div>
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-bordered table-stripped">
				<thead>

					<tr>
						<th>Room</th>
						<th class="tb-width-fit-content">Arrival Time</th>
						<th class="tb-width-fit-content">Adults <small> Ages 13 or above </small></th>
						<th class="tb-width-fit-content">Children <small> Ages 6-12 </small></th>
						<th class="tb-width-fit-content">Children <small> Under 6 years </small></th>
						<th class="tb-width-fit-content">Extra Bedding</th>
						<th class="tb-width-fit-content"> Check In Amount</th>
						<th class="tb-width-fit-content" style="width:170px">Check In</th>
					</tr>
				</thead>
				<tbody>

					<?php $icount = 0; $Ttotalqty = 0;foreach ($booking_items as $bi_key => $bi_value) {
						// $rooms = array_map(function ($data) use ($bi_value) {
						// 	if ($data->spt_id == $bi_value->room_type) {
						// 		return $data->rooms;
						// 	}
						// }, $roomTypes);
						// prx($rooms);
						// $rooms = (@$rooms) ? $rooms[0] : [];
						$rooms = [];
						foreach ($roomTypes as $data) {
							if ($data->spt_id == $bi_value->room_type) {
								$rooms[] = $data->rooms;
							}
						}
						$rooms = (!empty($rooms)) ? $rooms[0] : [];
						// prx($rooms);
						$capacity = title('property', $bi_value->room_type, 'sub_property_type_id', 'capacity');
						$extra_bedding = $bi_value->extra_bedding;
						
					?>
	                       
						<tr>
							<td colspan="8" center data-roomType="<?= $bi_value->room_type ?>" data-extraBedding="<?= $extra_bedding ?>">
								<?= title('sub_property_types', $bi_value->room_type, 'spt_id', 'name') ?>
								<!-- (<?= $bi_value->qty ?>) -->
								<?= (@$extra_bedding) ? ' ( Extra Bedding: ' . $extra_bedding . ')' : '' ?>
							</td>
						</tr>

						 <?php
						 	$rs = $this->model->getRow('room_allotment',['booking_id'=>$bi_value->booking_id,'property_id'=>$bi_value->property_id]); 
						//   if( @$rs->booking_item_id==$bi_value->id)
						//   {
					     $checkedInRooms_cond['booking_id'] = $bi_value->booking_id;

				          $checkedInRooms = $this->db->where($checkedInRooms_cond)->where('room_type',$bi_value->room_type)->get('checkin')->result();
						// prx($checkedInRooms);
						 $Ttoatlcheckinadult =$Ttoatlcheckinchild=$Ttoatlcheckininfant= $totalcheckinExtrabed=0;
						  foreach ($checkedInRooms as $checkedInKey => $checkedInValue) {
							$Ttoatlcheckinadult = $Ttoatlcheckinadult+ $checkedInValue->of_adults;
							$Ttoatlcheckinchild = $Ttoatlcheckinchild+ $checkedInValue->of_children;
							$Ttoatlcheckininfant = $Ttoatlcheckininfant+ $checkedInValue->of_infant;
							$Ttoatlcheckininfant = $Ttoatlcheckininfant+ $checkedInValue->of_infant;
							$totalcheckinExtrabed = $totalcheckinExtrabed+$checkedInValue->extra_bedding;
						 ?>
						 	<tr action="<?= base_url() ?>checkin/<?= $booking->id ?>">
							 <input type="hidden" name="total_amount" value="<?=bcdiv($totalpayout, 1, 2);?>">
							<input type="hidden" name="total_remaining" value="<?=bcdiv($totalpayout-$totalreceived, 1, 2);?>">
							<input type="hidden" value="<?=$extra_bedding_price;?>" name="extra_bedding_price">
							<td>
							
								<select name="room_no" class="form-control bg-success">
									<option value="">-- Select --</option>
									<?php foreach ($rooms as $r_row => $r_value) {
										 if($r_value->flat_no ==$checkedInValue->room_no){  
											$value = $bi_value->room_type . '-' . $r_value->flat_id . '-' . $r_value->flat_no;?>  
											<option value="<?= $value ?>" class="bg-primary" <?php if($r_value->flat_no==$checkedInValue->room_no){echo "selected";} ;?>  >
											<?= $r_value->flat_no ?>
										</option>
										<?php  }
                                       if($r_value->flat_no !=$checkedInValue->room_no){    
										$value = $bi_value->room_type . '-' . $r_value->flat_id . '-' . $r_value->flat_no;
										$disable = ((@$r_value->allotment_id) ? 'disabled' : '') ?>
										<option value="<?= $value ?>" <?= $disable ?> class="<?= (@$disable) ? ' text-danger' : '' ?>" <?php if($r_value->flat_no==$checkedInValue->room_no){echo "selected";} ;?>>
											<?= $r_value->flat_no ?>
											<?= (@$disable) ? ' (Not Available)' : '' ?>
										</option>

									<?php } } ?>
								</select>
							</td>
							<td class="tb-width-fit-content">
								<input type="datetime-local" min="0" name="intime" class="form-control bg-success" value="<?=($checkedInValue->intime) ?>" <?php if($checkedInValue->checkout_id !=''){echo "readonly" ;};?> >
							</td>
							<td class="tb-width-fit-content">
								<input type="number" min="0" name="adults" class="form-control bg-success" value="<?= $checkedInValue->of_adults ?>"  <?php if($checkedInValue->checkout_id !=''){echo "readonly" ;};?>>
							</td>
							<td class="tb-width-fit-content">
								<input type="number" min="0" name="children" class="form-control bg-success" value="<?= $checkedInValue->of_children ?>"  <?php if($checkedInValue->checkout_id !=''){echo "readonly" ;};?>>
							</td>
							<td class="tb-width-fit-content">
								<input type="number" min="0" name="infants" class="form-control bg-success" value="<?= $checkedInValue->of_infant ?>"  <?php if($checkedInValue->checkout_id !=''){echo "readonly" ;};?>>
							</td>
							<td class="tb-width-fit-content">
								<input type="number" min="0" name="extra_bedding" value="<?= $checkedInValue->extra_bedding ?>" class="form-control bg-success" data-roomTypeId="<?= $bi_value->room_type ?>"  <?php if($checkedInValue->checkout_id !=''){echo "readonly" ;};?>>
							</td>
							<td class="tb-width-fit-content">
								<input type="number" min="0" oninput="validateInputs2()" id="pre_checkin_amount2" name="pre_checkin_amount" class="form-control bg-success" value="<?= $checkedInValue->pre_checkin_amount ?>"  <?php if($checkedInValue->checkout_id !=''){echo "readonly" ;};?>>
							</td>
							<td class="tb-width-fit-content">
							<?php if($checkedInValue->checkout_id ==''){?>
							<a href='<?= base_url('checkin-guests-details/' . $checkedInValue->id) ?>' target='_blank' class='btn btn-primary btn-sm check_in_submits float-left'>
										Guests Details
									</a>
							<input type="hidden" value="<?=$checkedInValue->id;?>" name="check_in_id">
								<button type="button" class="btn btn-danger btn-sm check_in_submit_edit  mt-1" >Check In Modify</button>
								<?php };?>
							</td>
						</tr>
						<?php  }?>
						   <input type="hidden" name="total_adult" class="total_adult" value="<?=$totaladults-$Ttoatlcheckinadult;?>" >
							<input type="hidden" name="total_child" class="total_child" value="<?=$totalchild-$Ttoatlcheckinchild;?>" >
							<input type="hidden" name="total_infant" class="total_infant" value="<?=$totalinfant-$Ttoatlcheckininfant;?>" >
							<input type="hidden" name="" value="<?=$extrabed-$totalcheckinExtrabed;?>" id="extra">
						<?php  for ($i = 0; $i < ($bi_value->qty - count($checkedInRooms)); $i++) { ?>
							<tr id="trID" action="<?= base_url() ?>checkin-new/<?= $booking->id ?>">
							<input type="hidden" value="<?=$extra_bedding_price;?>" name="extra_bedding_price">
							<input type="hidden" name="total_amount" value="<?=bcdiv($totalpayout, 1, 2);?>">
							<input type="hidden" name="booking_id" value="<?= $booking->id ?>">
							<input type="hidden" name="total_remaining" value="<?=bcdiv($totalpayout-$totalreceived, 1, 2);?>">
								<td>
								
									<select name="room_no" class="form-control bg-warning">
										<option value="">-- Select --</option>
										<?php  foreach ($rooms as $r_row => $r_value) {
											$value = $bi_value->room_type . '-' . $r_value->flat_id . '-' . $r_value->flat_no;
											$disable = ((@$r_value->allotment_id) ? 'disabled' : '') ?>
											<option value="<?= $value ?>" <?= $disable ?> class="<?= (@$disable) ? ' text-danger' : '' ?>">
												<?= $r_value->flat_no ?>
												<?= (@$disable) ? ' (Not Available)' : '' ?>
											</option>
										<?php } ?>
									</select>
								</td>
								<td class="tb-width-fit-content">
									<input type="datetime-local" min="0" name="intime" class="form-control bg-warning" value="<?= date('Y-m-d H:i') ?>">
								</td>
								<td class="tb-width-fit-content">
									<input type="number" min="0" oninput="validateadult()" name="adults" class="form-control bg-warning adults" value="0">
								</td>
								<td class="tb-width-fit-content">
									<input type="number" min="0" oninput="validatechild()" name="children" class="form-control bg-warning children" value="0">
								</td>
								<td class="tb-width-fit-content">
									<input type="number" min="0" oninput="validateinfant()" name="infants" class="form-control bg-warning infants" value="0">
								</td>
								<td class="tb-width-fit-content">
									<input type="number" min="0" name="extra_bedding" value="0" class="form-control bg-warning" id="extra_bedding" oninput="validateExtraBedding()" data-roomTypeId="<?= $bi_value->room_type ?>">
								</td>
								<td class="tb-width-fit-content">
									<input type="number" min="0" oninput="validateInputs1()" id="pre_checkin_amount1" name="pre_checkin_amount" class="form-control bg-warning" value="0">
								</td>
								<td class="tb-width-fit-content">
								<input type="hidden" value="" name="check_in_id">
									<button type="button" class="btn btn-primary btn-sm check_in_submit"  >Check In</button>
								</td>
							</tr>
							<tr>
								<td colspan="8">
								<div id="checkinFormContainer" style="display: none;">
								<form id="checkinForm">
								</form>
								</div>
								</td>
							</tr>
							

							
							
						<?php } ?>
					

					<?php   } ?>
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
                <input autocomplete="random-value" type="text" class="form-control" id="reference_id" placeholder="Reference Id" name="reference_id">
            </div>
        </div>
</div>


<?php for ($i = 1; $i <= $guest_count; $i++) { } ?>


<div class="row m-1 pt-1 pb-1">
</div>
<!-- </form> -->
<script type="text/javascript">
     $('body').on('change', 'input[type="file"]', function() {
        var fileSizeInBytes = this.files[0].size;
        var fileSizeInKB = fileSizeInBytes / 1024; // Convert bytes to KB
        if (fileSizeInKB > 100) {
            alert_toastr('error', 'Maximum file size should be 100 KB.');
            $('#submitCheckin').prop('disabled', true);
        } else {
            $('#submitCheckin').prop('disabled', false);
        }
    });
</script>
<script>
$('body').on('click', '.check_in_submit', function(e) {
	var rooms = <?= json_encode($rooms) ?>;
	var room_type = <?= json_encode($bi_value->room_type) ?>;
    var _this = $(this);
    var _tr = _this.closest('tr');
    var checkin_data = {};
      console.log(rooms);
    _tr.find('input, select').each(function() {
        var inputName = $(this).attr('name');
        var inputVal = $(this).val();
        checkin_data[inputName] = inputVal;
    });
    if (!checkin_data.room_no) {
		alert_toastr('error', `Room not Selected!`);
        return false;
    }
    if (parseInt(checkin_data.adults) <= 0) {
		alert_toastr('error', `Enter the number of adults!`);
        return false;
    }
	var payment_mode = $('#payment_mode').val();
	var reference_id = $('#reference_id').val();
	console.log(payment_mode);
	if (!payment_mode) {
				alert_toastr('error', `Payment mode not Selected!`);
			    return true;
			    }
    var formHtml = `
        <input type="hidden" name="extra_bedding_price" value="${checkin_data.extra_bedding_price}">
        <input type="hidden" name="total_amount" value="${checkin_data.total_amount}">
        <input type="hidden" name="total_remaining" value="${checkin_data.total_remaining}">
		<input type="hidden" name="payment_mode" value="${payment_mode}">
		<input type="hidden" name="reference_id" value="${reference_id}">
        <div class="form-group">
            <select name="room_no" class="form-control bg-warning" required hidden>
                <option value="${checkin_data.room_no}">${checkin_data.room_no}</option>
            </select>
        </div>
        <div class="form-group">
            <input type="hidden" min="0" name="intime" class="form-control bg-warning" value="${checkin_data.intime}" required>
        </div>
        <div class="form-group">
            <input type="hidden" min="0" name="adults" class="form-control bg-warning" value="${checkin_data.adults}" required>
        </div>
        <div class="form-group">
            <input type="hidden" min="0" name="children" class="form-control bg-warning" value="${checkin_data.children}">
        </div>
        <div class="form-group">
            <input type="hidden" min="0" name="infants" class="form-control bg-warning" value="${checkin_data.infants}">
        </div>
        <div class="form-group">
            <input type="hidden" min="0" name="extra_bedding" class="form-control bg-warning" value="${checkin_data.extra_bedding}">
        </div>
        <div class="form-group">
            <input type="hidden" min="0" name="pre_checkin_amount" class="form-control bg-warning" value="${checkin_data.pre_checkin_amount}">
        </div>
		<input type="hidden" value="" name="check_in_id">
        ${generateGuestsTable(checkin_data, '', checkin_data.booking_id)}
		
        <button type="button" class="btn btn-primary float-right mr-2" id="submitCheckin">Submit</button>
    `;

    $('#checkinForm').html(formHtml);
    $('#checkinFormContainer').show();
    _tr.hide();

    $('#submitCheckin').off('click').on('click', function() {
        var checkin_data = $('#checkinForm').serialize();
        $.ajax({
            url: _tr.attr('action'),
            type: 'POST',
            data: checkin_data,
            beforeSend: function() {
                if (!$('[name="room_no"]').val()) {
                    alert('Room not Selected!');
                    return false;
                }
                if (parseInt($('[name="adults"]').val()) <= 0) {
                    alert('Enter the number of adults!');
                    return false;
                }
			
			
            },
            success: function(res) {
                res = JSON.parse(res);
				alert_toastr(res.res,res.msg);
                if (res.res === 'success') {
                    _tr.html(res.html).show();
                    $('#checkinFormContainer').hide();
                    setTimeout(function() {
                        window.location.reload(1);
                    }, 1000);
					
                }
            }
        });
    });
});
function generateGuestsTable(checkin_data, checkin_id, booking_id) {
    let guestsHtml = ' <div class="table-responsive"><table class="table vertical-align-middle"><thead><tr><th center>Guests</th></tr></thead><tbody>';

    const guestInputs = [];
	guestsHtml+=  '<tr> <th>Adults</th> </tr>';
    for (let i = 0; i < checkin_data.adults; i++) {
		 guestsHtml+=  '<tr><td class="tb-width-fit-content">';
        const id_append = '_adults' + i;
        const type = 'adults';
        const rs = {}; 
		guestsHtml += (generateGuestInput(i, id_append, checkin_id, booking_id, rs, checkin_data.adults, type));
		
		 guestsHtml +=  '</td></tr>';
    }

	if(checkin_data.children){
	 guestsHtml +=  '<tr> <th>Children</th> </tr>';
    for (let i = 0; i < checkin_data.children; i++) {
		guestsHtml +=  '<tr><td class="tb-width-fit-content">';
        const id_append = '_children' + i;
        const type = 'children';
        const rs = {}; 
        guestsHtml += (generateGuestInput(i, id_append, checkin_id, booking_id, rs, checkin_data.children, type));
		// guestsHtml += guestInputs;
		guestsHtml +=  '</td></tr>';
    }
  }

  if(checkin_data.infants){
	guestsHtml +=  '<tr> <th>Children</th> </tr>';
    for (let i = 0; i < checkin_data.infants; i++) {
		guestsHtml +=  '<tr><td class="tb-width-fit-content">';
        const id_append = '_infants' + i;
        const type = 'infants';
        const rs = {};  
        guestsHtml += (generateGuestInput(i, id_append, checkin_id, booking_id, rs, checkin_data.infants, type));
		// guestsHtml += guestInputs;
		guestsHtml+=  '</td></tr>';
    }
}

   
    guestsHtml += '</tbody></table></div>';

    return guestsHtml;
}
function generateGuestInput(i, id_append, checkin_id, booking_id, rs, total_persons, type) {
    return `
    <div class="row border rounded m-1 pt-1 pb-1">
        <div class="col-md-12">
            <h5><strong>Guest - ${i + 1}</strong></h5>
        </div>
        <input type="hidden" name="guest_row_count[]" value="${id_append}">
        <input type="hidden" name="checkin_id[]" value="${checkin_id}">
        <input type="hidden" name="booking_id[]" value="${booking_id}">
        <input type="hidden" name="id[]" value="${rs?.id || ''}">
        <input type="hidden" name="total_person[]" value="${total_persons}">
        <div class="col-md-3">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name[]" placeholder="Enter Name" required value="${rs?.name || ''}">
                <input type="hidden" class="form-control" name="type[]" value="${type}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Nationality</label>
                <input type="text" class="form-control" name="nationality[]" placeholder="Enter Nationality" value="${rs?.nationality || ''}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Id Proof Type</label>
                <select class="form-control" name="id_proof_type[]">
                    <option value="">-- Select --</option>
                    <option value="Aadhaar card" ${rs?.id_proof_type === 'Aadhaar card' ? 'selected' : ''}>Aadhaar Card</option>
                    <option value="Driver Licence" ${rs?.id_proof_type === 'Driver Licence' ? 'selected' : ''}>Driver Licence</option>
                    <option value="Voter card" ${rs?.id_proof_type === 'Voter card' ? 'selected' : ''}>Voter card</option>
                    <option value="Visa" ${rs?.id_proof_type === 'Visa' ? 'selected' : ''}>Visa</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Id Proof No</label>
                <input type="text" class="form-control" name="id_proof_no[]" placeholder="Enter ID Proof Doc Number" value="${rs?.id_proof_no || ''}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="id_proof_pic_front${id_append}">Id Proof Pic Front <span style="font-size:10px" class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                <fieldset class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="id_proof_pic_front${id_append}" name="id_proof_pic_front[]">
                        <label class="custom-file-label" for="id_proof_pic_front${id_append}">Choose file</label>
                    </div>
                </fieldset>
                ${rs?.id_proof_pic_front ? `<img src="${IMGS_URL + rs.id_proof_pic_front}" alt="" height="50px" width="80px">` : ''}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="id_proof_pic_back${id_append}">Id Proof Pic Back <span style="font-size:10px" class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                <fieldset class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="id_proof_pic_back${id_append}" name="id_proof_pic_back[]">
                        <label class="custom-file-label" for="id_proof_pic_back${id_append}">Choose file</label>
                    </div>
                </fieldset>
                ${rs?.id_proof_pic_back ? `<img src="${IMGS_URL + rs.id_proof_pic_back}" alt="" height="50px" width="80px">` : ''}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="agreement_doc${id_append}">Agreement Document <span style="font-size:10px" class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                <fieldset class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="agreement_doc${id_append}" name="agreement_doc[]">
                        <label class="custom-file-label" for="agreement_doc${id_append}">Choose file</label>
                    </div>
                </fieldset>
                ${rs?.agreement_doc ? `<img src="${IMGS_URL + rs.agreement_doc}" alt="" height="50px" width="80px">` : ''}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="guest_photo${id_append}">Guest Photo <span style="font-size:10px" class="text-danger"> ( Maximum file size 100 kb.)</span></label>
                <fieldset class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="guest_photo${id_append}" name="guest_photo[]">
                        <label class="custom-file-label" for="guest_photo${id_append}">Choose file</label>
                    </div>
                </fieldset>
                ${rs?.guest_photo ? `<img src="${IMGS_URL + rs.guest_photo}" alt="" height="50px" width="80px">` : ''}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Contact Number</label>
                <input type="number" class="form-control" placeholder="Enter Contact" name="contact[]" value="${rs?.contact || ''}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" placeholder="Enter Email" name="email[]" value="${rs?.email || ''}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" placeholder="Enter Address" name="address[]" value="${rs?.address || ''}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Coming From</label>
                <input type="text" class="form-control" placeholder="Enter Coming From" name="coming[]" value="${rs?.coming || ''}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>Going To</label>
                <input type="text" class="form-control" placeholder="Enter Going To" name="going[]" value="${rs?.going || ''}">
            </div>
        </div>
    </div>`;
}



		$('body').on('click', '.check_in_submit_edit', function(e) {
		var _this = $(this);
		var _tr = _this.parents('tr');
		var checkin_data = {};
		checkin_data['payment_mode'] = $(`[name="payment_mode"]`).val();
		checkin_data['reference_id'] = $(`[name="reference_id"]`).val();
		//alert(payment_mode);
		_tr.find('input,select').each(function() {
			var inputName = $(this).attr('name')
			var inputVal = $(this).val();
			checkin_data[inputName] = inputVal;
		})
		if (!checkin_data.room_no) {
		alert_toastr('error', `Room not Selected!`);
		return false;
		}
		if (parseInt(checkin_data.adults) <= 0) {
		alert_toastr('error', `Enter the number of adults!`);
		return false;
		}
		$.ajax({
			url: _tr.attr('action'),
			type: 'POST',
			data: checkin_data,
			beforeSend: function() {
				if (!checkin_data.room_no) {
					alert_toastr('error', `Room not Selected!`);
					return false;
				}
				if (parseInt(checkin_data.adults) <= 0) {
					alert_toastr('error', `Enter the number of adults!`);
					return false;
				}
			},
			success: function(res) {
				res = JSON.parse(res);
				alert_toastr(res.res, res.msg);
				if (res.res == 'success') {
					_tr.html(res.html);
					setTimeout(function(){
					window.location.reload(1);
					}, 2000);
				}
			}
		})

	})
	 function validateadult() {
	 
	 var firstInputValue = $('.total_adult').val();
	 var secondInputValue = $(".adults").val();
	 // Perform the validation
	 if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
	   $(".adults").val(firstInputValue),
	  alert_toastr("error","Sorry checkin adult  not greater than  remaining adult")
	 } else {
	   
	 }
   }
   function validatechild() {
	 
	 var firstInputValue = $('.total_child').val();
	 var secondInputValue = $(".children").val();
	 // Perform the validation
	 if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
	   $(".children").val(firstInputValue),
	  alert_toastr("error","Sorry checkin children  not greater than  remaining children")
	 } else {
	   
	 }
   }
   function validateinfant() {
	 
	 var firstInputValue = $('.total_infant').val();
	 var secondInputValue = $(".infants").val();
	 // Perform the validation
	 if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
	   $(".infants").val(firstInputValue),
	  alert_toastr("error","Sorry checkin infant  not greater than  remaining infant")
	 } else {
	   
	 }
   }


	function edit_btn(id)
	{
		get_edit_data(id);
		//$("#checked-in").hide();
		$("#edit-checkin").show();
	}

    function validateInputs1() {
	 
      var firstInputValue = $('#final_total').val();
      var secondInputValue = $("#pre_checkin_amount1").val();
      // Perform the validation
      if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
        $("#pre_checkin_amount1").val(firstInputValue),
       alert_toastr("error","Sorry pre checkin amount value not greater than total remaining amount")
      } else {
        
      }
    }
	function validateExtraBedding() {
	 
	 var firstInputValue = $('#extra').val();
	 var secondInputValue = $("#extra_bedding").val();
	 // Perform the validation
	 if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
	   $("#extra_bedding").val(firstInputValue),
	  alert_toastr("error","Sorry pre checkin amount value not greater than total remaining amount")
	 } else {
	   
	 }
   }
	function validateInputs2() {
	 
	 var firstInputValue = $('#final_total').val();
	 var secondInputValue = $("#pre_checkin_amount2").val();
	 // Perform the validation
	 if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
	   $("#pre_checkin_amount2").val(firstInputValue),
	  alert_toastr("error","Sorry pre checkin amount value not greater than total remaining amount")
	 } else {
	   
	 }
   }
  </script>
<script>

	$('body').on('keyup', '[name="extra_bedding[]"]', function() {
		let _this = $(this);
		if (_this.val() > 2) {
			_this.val(2)
		}
		let _roomType = _this.attr('data-roomTypeId');
		let _extraBedding = $(`[data-roomType="${_roomType}"]`).attr('data-extraBedding');
		let _total_extra_bedding = 0;

		$(`[data-roomTypeId="${_roomType}"]`).each(function() {
			var tmpVal = parseInt($(this).val());
			if (tmpVal) {
				_total_extra_bedding += tmpVal;
			}
		})

		let check = _extraBedding - _total_extra_bedding;

		if (check < 0) {
			_this.val(0);
			alert_toastr('error', `Only ${_extraBedding} extra bedding allowed!`);
		}
	})

	// $(document).on('click', '[data-toggle="show-hide"]', function(event) {
	// 	var dataTarget = $(this).attr('data-target');
	// 	$('.show-' + dataTarget).toggle(100);
	// 	$('.hide-' + dataTarget).toggle(100);
	// })
</script>

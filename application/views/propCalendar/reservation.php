
<?php if (!@$pro_id) { ?>
    <div class="row">
        <div class="col-12" center style="height: 100px;">
            <h1>Select a property!</h1>
        </div>
    </div>
<?php die();
} ?>
<form class="form ajaxsubmit reload-page" action="<?= $action_url ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="propmaster">Property<sup>*</sup></label>
                <select id="propmaster" name="propmaster" class="form-control propmaster pro_id">
                    <?php
                    echo optionStatus('', '-- Select --');
                    foreach ($rows as $row) {
                        $selected = (@$pro_id == $row->id) ? 'selected' : '';
                        $title = $row->propname . '( ' . $row->propcodename . ' ) - ' . title('cities', $row->city, 'id', 'name');
                        echo optionStatus($row->id, $title, 1, $selected);
                    }
                    ?>
                </select>
            </div>

        </div>
        <div class="col-md-3">
            <div class="form-group select-date">
                <label for="startDate">Arrival<sup>*</sup></label>
                <input autocomplete="random-value" type="date" min="<?=$minDate = date('Y-m-d', strtotime('-15 days'));?>" class="form-control" name="startDate" min="<?= date('Y-m-d') ?>" value="<?= $startDate ?>">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group select-date">

                <label for="endDate">Departure<sup>*</sup> </label>
                <input autocomplete="random-value" type="date" class="form-control" name="endDate" min="<?= date('Y-m-d') ?>" value="<?= $endDate ?>">
            </div>
            <input type="hidden" name="nights" value="1">
        </div>

        <div class="col-md-3 float-left">
            <div class="form-group">
                <label for="booking_type">Booking From</label>
                <select autocomplete="random-value" class="form-control" id="booking_from" name="booking_from">
                    <?php
                    echo optionStatus('', '-- Select --', 1);
                    foreach ($booking_type as $row) {
                        echo optionStatus($row->id, $row->type, 1);
                    }
                    ?>
                </select>
            </div>
        </div>
          <div class="col-md-6" id="agent-box">

            </div>
        <div class="col-md-3 float-left">
            <div class="form-group">
                <label for="booking_type">Room Plan</label>
                <select autocomplete="random-value" class="form-control" id="booking_type" name="booking_type">
                    <?php
                    echo optionStatus('', '-- Select --', 1);
                    foreach ($booking_type_master as $rows) {
                        echo optionStatus($rows->id, $rows->name, 1);
                    }
                    ?>
                </select>
            </div>
        </div>
       
     
    </div>
    <style>
        #search-box {
            padding: 10px;
            border: #a8d4b1 1px solid;
            border-radius: 4px;
        }

        #country-list {
            float: left;
            list-style: none;
            margin-top: -3px;
            padding: 0;
            width: 190px;
            position: absolute;
            z-index: 999999;
            max-height: 180px;
            overflow-y: scroll;
        }

        #country-list li {
            padding: 10px;
            background: #f0f0f0;
            border-bottom: #bbb9b9 1px solid;
        }

        #country-list li:hover {
            background: #ece3d2;
            cursor: pointer;
        }

        #search-box {
            padding: 10px;
            border: #a8d4b1 1px solid;
            border-radius: 4px;
        }

        .inc-dec {
            width: 150px;
            text-align: center;
        }

        .input-group-text {
            cursor: pointer;
        }
        /* .width-fit-content{
            width: fit-content;
        } */
       
    </style>
    <input type="hidden" name="booking_id" id="booking_id" value="" >
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="mobile">Mobile<sup>*</sup> </label>
                <input type="number" id="search-box" class="form-control" placeholder="Mobile Number" name="mobile" autocomplete="random-value">
                <div id="suggesstion-box"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="name">Name </label>
                <input type="text" class="form-control" placeholder="Name" id="cname" name="name" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" placeholder="Date of Birth" id="cdob" name="dob" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="gender">Gender </label>
                <select class="form-control" id="cgender" name="gender">
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="email">Email </label>
                <input type="email" class="form-control" id="cemail" placeholder="Email" name="email" />
            </div>
        </div>

        <div class="col-md-3">
            <label for="of_adults">Adults <small>Ages 13 or above</small> </label>

            <div class="input-group mb-1">
                <div class="input-group-prepend noselect">
                    <span class="input-group-text dec" data-target="#of_adults">&#9866;</span>
                </div>
                <input autocomplete="random-value" type="number" class="form-control inc-dec" id="of_adults" value="1" name="of_adults" readonly="" min="1" >
                <div class="input-group-append noselect">
                    <span class="input-group-text inc" data-target="#of_adults">&#10010;</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <label for="of_children">Children <small>Ages 8-12</small> </label>

            <div class="input-group mb-1">
                <div class="input-group-prepend noselect">
                    <span class="input-group-text dec" data-target="#of_children">&#9866;</span>
                </div>
                <input autocomplete="random-value" type="number" class="form-control inc-dec" id="of_children" value="0" name="of_children" readonly="" min="0">
                <div class="input-group-append noselect">
                    <span class="input-group-text inc" data-target="#of_children">&#10010;</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <label for="of_infants">Children <small>Under 6 years</small> </label>

            <div class="input-group mb-1">
                <div class="input-group-prepend noselect">
                    <span class="input-group-text dec" data-target="#of_infants">&#9866;</span>
                </div>
                <input autocomplete="random-value" type="number" class="form-control inc-dec" id="of_infants" value="0" name="of_infants" readonly="" min="0" >
                <div class="input-group-append noselect">
                    <span class="input-group-text inc " data-target="#of_infants">&#10010;</span>
                </div>
            </div>


        </div>


    </div>

    <div class="row">
        <div class="col-12">
            Select Rooms
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-sm table-bordered rooms_tb">
                <thead>
                    <tr>
                        <th  style="width:250px">Room Type</th>
                        <th int class="tb-width-fit-content">Price</th>
                        <th int style="width:50px">Available</th>
                        <th int style="width:50px">Capacity</th>
                        <th int style="width:50px">Quantity</th>
                        <th int style="width:50px">Extra <br> Bedding</th>
                        <th int style="width:50px">Discount /<br> Room</th>
                        <th int style="width:140px">Total <br> Discount</th>
                        <th int style="width:140px">Amount</th>
						<?php if($property->is_gst=='YES'):?>
						<th int style="width:50px">GST RATE <br>( % )</th>
                        <th int style="width:140px">GST</th>
						<?php endif?>
                        <th int style="width:140px">Sub Total</th>
                        <th center style="width:70px">
                            <a href="javascript:void(0)" class="add-room">
                                <i class="la la-plus"></i>
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="rooms_row">
                        <td>
                            <select name="room_type[]" class="form-control room_type">
                                <?php
                                echo optionStatus('', '-- Select --');
                                foreach ($sub_property_types as $row) {
                                    echo optionStatus($row->spt_id, $row->name, $row->active);
                                }
                                ?>
                            </select>
                        </td>
                        <td int class="tb-width-fit-content">
                        Price : <span class="room_price room_txt"></span><br>
                        Extra Bedding : <span class="extra_bedding_price room_txt"></span><br>
                        </td>
                        <td int style="width:50px">
                            <span class="available_rooms room_txt"></span>
                        </td>
                        <td int style="width:50px">
                            <span class="capacity room_txt"></span>
                        </td>
                        <td int style="width:50px">
                            <input int type="number" name="quantity[]" class="form-control" value="1" min="0">
                        </td>
                        <td int style="width:50px">
                            <input int type="number" name="extra_bedding[]" class="form-control" value="0" min="0" max="10">
                        </td>
                        <td int style="width:50px">
                            <input int type="number" name="discount[]" class="form-control" value="0" min="0">
                        </td>
                        <td int style="width:140px">
                            <input int type="number" name="total_discount[]" class="form-control" value="0" min="0" readonly>
                        </td>
                        <td int style="width:140px">
                            <input int type="number" name="amount[]" class="form-control" value="0" readonly>
                        </td>
						<?php if($property->is_gst=='YES'):?>
						<td int style="width:50px">
						<input int type="number" name="taxRate[]" class="form-control" value="0" readonly>
                        </td>
                        <td int style="width:140px">
                            <input int type="number" name="taxAmount[]" class="form-control" value="0" readonly>
							
                        </td>
						<?php else:?>
							<input int type="hidden" name="taxRate[]" class="form-control" value="0" readonly>
							<input int type="hidden" name="taxAmount[]" class="form-control" value="0" readonly>
							<?php endif;?>
                        <td int style="width:140px">
                            <input int type="number" name="totalAmount[]" class="form-control" value="0" readonly>
                        </td>
                        <td center style="width:70px">
                            <a href="javascript:void(0)" class="remove-room">
                                <i class="la la-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="<?php if($property->is_gst=='YES'):?>11<?php else : echo "9"; endif;?>" int><span id="inventory_label"></span> Total </td>
                        <td int> <span class="total_amount"></span></td>
                        <input type="hidden"  id="total_amount" class="final_total">
						
                    </tr>
					<?php if($property->is_gst=='YES'):?>
                    <tr>
                        <td colspan="<?php if($property->is_gst=='YES'):?>11<?php else : echo "9"; endif;?>" int></span> GST </td>
                        <td int> <span class="tax_amount"></span></td>
                        <input type="hidden"  id="tax_amount" class="tax_amount">
                    </tr>
					<?php endif;?>
                    <tr>
                        <td colspan="<?php if($property->is_gst=='YES'):?>11<?php else : echo "9"; endif;?>" int>Sub Total</td>
                        <td int> <span class="sub_total_amount"></span></td>
                        <input type="hidden"  id="sub_total_amount" class="sub_total_amount_val">
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
<input type="hidden" id="is_gst" value="<?php echo $property->is_gst?>">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="discount_amount">Discount ₹</label>
                <input autocomplete="random-value" type="number" name="discount_amount" id="discount_amount" class="form-control new" placeholder="Discount Amount" readonly>
            </div>

        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="discount_remark">Discount Remark</label>
                <input autocomplete="random-value" type="text" class="form-control" id="discount_remark" placeholder="Discount Remark" name="discount_remark">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="advanced">Advanced</label>
                <input type="number" class="form-control advancedsw" placeholder="Advanced" id="advanced" name="advanced" oninput="validateInputs()">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="booking_remark">Booking Remark</label>
                <input autocomplete="random-value" type="text" class="form-control" id="booking_remark" placeholder="Booking Remark" name="booking_remark">
            </div>
        </div>

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
                <input autocomplete="random-value" type="text" class="form-control" id="reference_id" placeholder="Reference Id" name="reference_id">
            </div>
        </div>
		<div class="col-md-3">
			<div class="form-group">
				<label class="checkbox-label">
					<input type="checkbox" name="mail" value="1" class="styled-checkbox">
					<span class="custom-checkbox"></span>
					If Send Receipt In Mail
				</label>
			</div>
		</div>

    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-action float-right">
                <input type="reset" class="btn btn-sm btn-danger mr-1" value="Reset">
                <input type="submit" class="btn btn-sm btn-primary" value="Submit">
            </div>
        </div>

    </div>
<p id="validationMessage"></p>
</form>

<script type="text/javascript">
    var rooms_row = $('.rooms_row').html();
</script>

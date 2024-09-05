<?php foreach($value as $v)
{
    $pro_id= $v->property_id;
;?>
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
                <input autocomplete="random-value" type="date" min="<?=$minDate = date('Y-m-d', strtotime('-15 days'));?>" class="form-control" name="startDate" min="<?= date('Y-m-d') ?>" value="<?= $startDate ?>" readonly>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group select-date">

                <label for="endDate">Departure<sup>*</sup> </label>
                <input autocomplete="random-value" type="date" class="form-control" name="endDate" min="<?= date('Y-m-d') ?>" value="<?= $endDate ?>" readonly>
            </div>
            <input type="hidden" name="nights" value="1">
            <input type="hidden" name="booking_id" id="booking_id" value="<?=$v->id;?>" >
        </div>

        <div class="col-md-3 float-left">
            <div class="form-group">
                <label for="booking_type">Booking From</label>
                <select autocomplete="random-value" class="form-control" id="booking_from" name="booking_from">
                    <?php
                    echo optionStatus('', '-- Select --', 1);
                    foreach ($booking_type as $row) {
                        ?>
                       <option value="<?=$row->id;?>" <?php if($v->booking_from==$row->id){echo "selected";} ;?>><?=$row->type;?></option>
                        <?php 
                    //   if($v->booking_from==$row->id){}
                    //     echo optionStatus($row->id, $row->type, 1);

                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-6" id="agent-box">
        <div class="col-md-12">
		<div class="form-group">
           	<label for="agent">Agent</label><br>
           	<select autocomplete="random-value" class="form-control" id="agent" name="agent">
           		<?php 
				echo optionStatus($agent->id,$agent->name.'( '.$agent->mobile.','.$agent->company_name.' )','selected',1);
				// foreach ($agent as $row) {
				// 	echo optionStatus($row->id,$row->name.' ('.$row->mobile.')',1);
				// }
				?>           		
           	</select>
        </div>	
    </div>
        </div>
        <div class="col-md-3 float-left">
            <div class="form-group">
                <label for="booking_type">Room Plan</label>
                <select autocomplete="random-value" class="form-control" id="booking_type" name="booking_type">
                    <?php
                    echo optionStatus('', '-- Select --', 1);
                    foreach ($booking_type_master as $rows) {
                        ?>
                        <option value="<?=$rows->id;?>" <?php if($v->booking_type==$rows->id){echo "selected";} ;?>><?=$rows->name;?></option>
                         <?php 
                        // echo optionStatus($rows->id, $rows->name, 1);
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
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="mobile">Mobile<sup>*</sup> </label>
                <input type="number" id="search-box" class="form-control" value="<?=$v->contact;?>" name="mobile" autocomplete="random-value">
                <div id="suggesstion-box"></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="name">Name </label>
                <input type="text" class="form-control" value="<?=$v->guest_name;?>" id="cname" name="name" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" value="<?=$v->dob;?>" id="cdob" name="dob" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="gender">Gender </label>
                <select class="form-control" id="cgender" name="gender">
                    <option value="">-- Select --</option>
                    <option value="Male" <?php if($v->gender=='Male'){echo "selected";} ;?>>Male</option>
                    <option value="Female"  <?php if($v->gender=='Female'){echo "selected";} ;?>>Female</option>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="email">Email </label>
                <input type="email" class="form-control" id="cemail" value="<?=$v->email;?>" name="email" />
            </div>
        </div>

        <div class="col-md-3">
            <label for="of_adults">Adults <small>Ages 13 or above</small> </label>

            <div class="input-group mb-1">
                <div class="input-group-prepend noselect">
                    <span class="input-group-text dec" data-target="#of_adults">&#9866;</span>
                </div>
                <input autocomplete="random-value" type="number" class="form-control inc-dec" id="of_adults" value="<?=$v->of_adults;?>" name="of_adults" readonly="" min="1" >
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
                <input autocomplete="random-value" type="number" class="form-control inc-dec" id="of_children" value="<?=$v->of_children;?>" name="of_children" readonly="" min="0" >
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
                <input autocomplete="random-value" type="number" class="form-control inc-dec" id="of_infants" value="<?=$v->of_infants;?>" name="of_infants" readonly="" min="0" >
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
	<input type="hidden" id="is_gst" value="<?php echo $property->is_gst?>">

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
                <?php foreach($booking_new_items as $items){?>
                    <tr class="rooms_row">
                   
                        <td>
                            <select name="room_type[]" class="form-control room_type">
                                <?php
                                echo optionStatus('', '-- Select --');
                                foreach ($sub_property_types as $row) {
                                   ?>
                                   <option value="<?=$row->spt_id;?>"  <?php  if($row->spt_id==$items->room_type){echo "selected";} ;?> ><?php echo $row->name.''.$row->active;?></option>
                                    <!-- // echo optionStatus($row->spt_id, $row->name, $row->active); -->
                     <?php   }?>
                            </select>
                        </td>
                       
                        <td int class="tb-width-fit-content">
                        Price : <span class="room_price room_txt"><?=$items->price;?></span><br>
                        Extra Bedding : <span class="extra_bedding_price room_txt"><?php echo $items->extra_bedding_price;?></span><br>
                        </td>
                        <td int style="width:50px">
                            <span class="available_rooms room_txt"></span>
                        </td>
                        <td int style="width:50px">
                            <span class="capacity room_txt"></span>
                        </td>
                        <td int style="width:50px">
                            <input int type="number" name="quantity[]" class="form-control" value="<?=$items->qty;?>" min="0">
                        </td>
                        <td int style="width:50px">
                            <input int type="number" name="extra_bedding[]" class="form-control" value="<?=$items->extra_bedding;?>" min="0" max="10">
                        </td>
                        <td int style="width:50px">
                            <input int type="number" name="discount[]" class="form-control" value="<?=$items->discount;?>" min="0">
                        </td>
                        <td int style="width:140px">
                            <input int type="number" name="total_discount[]" class="form-control" value="<?=$items->total_discount;?>" min="0" readonly>
                        </td>
                        <td int style="width:140px">
                            <input int type="number" name="amount[]" class="form-control" value="<?=$items->total_withouttax-$items->total_discount;?>" readonly>
                        </td>
						
						<?php if($property->is_gst=='YES'):?>
							<td int style="width:50px">
						<input int type="number" name="taxRate[]" class="form-control" value="<?=$items->tax_per;?>" readonly>
                        </td>
                        <td int style="width:140px">
                            <input int type="number" name="taxAmount[]" class="form-control" value="<?=$items->tax_value;?>" readonly>
                        </td>
						<?php else:?>
							<input int type="hidden" name="taxRate[]" class="form-control" value="0" readonly>
							<input int type="hidden" name="taxAmount[]" class="form-control" value="0" readonly>
							<?php endif;?>
                        <td int style="width:140px">
                            <input int type="number" name="totalAmount[]" class="form-control" value="<?=$items->total-$items->total_discount;?>" readonly>
                        </td>
                        <td center style="width:70px">
                            <a href="javascript:void(0)" class="remove-room">
                                <i class="la la-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="<?php if($property->is_gst=='YES'):?>11<?php else : echo "9"; endif;?>" int> <span id="inventory_label"></span> Total</td>
                        <td int> <span class="total_amount"><?php echo setting()->currency.''.$v->total_withouttax-$v->discount_amount;?></span></td>
                        <input type="hidden"  id="total_amount" class="final_total" value="<?=$v->total_withouttax-$v->discount_amount;?>">
                    </tr>
					<?php if($property->is_gst=='YES'):?>
                    <tr>
                        <td colspan="<?php if($property->is_gst=='YES'):?>11<?php else : echo "9"; endif;?>" int></span> GST </td>
                        <td int> <span class="tax_amount"><?php echo setting()->currency.''.$v->tax_value;?></span></td>
                        <input type="hidden"  id="tax_amount" value="<?php echo $v->tax_value;?>" class="tax_amount">
                    </tr>
					<?php endif;?>
                    <tr>
                        <td colspan="<?php if($property->is_gst=='YES'):?>11<?php else : echo "9"; endif;?>" int>Sub Total</td>
                        <td int> <span class="sub_total_amount"><?php echo setting()->currency.''.$v->total-$v->discount_amount;?></span></td>
                        <input type="hidden"  id="sub_total_amount" value="<?php echo $v->total-$v->discount_amount;?>" class="sub_total_amount_val">
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="discount_amount">Discount ₹</label>
                <input autocomplete="random-value" type="number" name="discount_amount" id="discount_amount" class="form-control new" value="<?=$v->discount_amount;?>" readonly>
            </div>

        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="discount_remark">Discount Remark</label>
                <input autocomplete="random-value" type="text" class="form-control" id="discount_remark" value="<?=$v->discount_remark;?>" name="discount_remark">
            </div>
        </div>
           <?php $tr = $this->model->getRow('transaction',['booking_id'=>$v->id,'action'=>'booking'])?>
        <div class="col-md-3">
            <div class="form-group">
                <label for="advanced">Advanced</label>
                <input type="number" class="form-control" placeholder="Advanced" id="advanced" name="advanced" value="<?=$tr->credit;?>" oninput="validateInputs()">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="booking_remark">Booking Remark</label>
                <input autocomplete="random-value" type="text" class="form-control" id="booking_remark" value="<?=$v->booking_remark;?>" name="booking_remark">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="discount_amount">Payment Mode <sup>*</sup></label>
                <select autocomplete="random-value" name="payment_mode" id="payment_mode" class="form-control payment_mode" required>
                    <?php
                    echo optionStatus('', '-- Select --', 1);
                    foreach ($payment_mode as $row) {?>
                        <!-- //echo optionStatus($row->id, $row->mode, 1); -->
                            <option value="<?=$row->id;?>"  <?php if($v->payment_status==$row->id){echo "selected";} ;?> >  <?=$row->mode;?></option>
                 <?php    }?>
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

    <div class="row">
        <div class="col-12">
            <div class="form-action float-right">
                <input type="reset" class="btn btn-sm btn-danger mr-1" value="Reset">
                <input type="submit" class="btn btn-sm btn-primary" value="Update">
            </div>
        </div>

    </div>

</form>
<?php }?>
 <script type="text/javascript">
    var rooms_row = $('.rooms_row').html();
	$(document).ready(function(){
		setTimeout(() => {
			let startDate = $(`[name="startDate"]`).val();
			let endDate = $(`[name="endDate"]`).val();
			if (startDate && endDate) {
            $.ajax({
                url: `${BASE_URL}reservations/count_nights`,
                data: {
                    startDate,
                    endDate
                },
                type: 'POST',
                success: function(data) {
                    $(`[name="nights"]`).val(data);
                    calculate_amount();
                }

            })
		}
		}, 10);
		
	})
</script>
<!--

<script type="text/javascript">
 


    $('body').on('change | keyup ', `[name="startDate"]`, function(e) {
        let _this = $(this);
        let _form = _this.parents('form');
        _form.find(`[name="endDate"]`).attr('min', _this.val())
        count_nights(_this);
    });
    $('body').on('change | keyup', `[name="endDate"]`, function(e) {
        let _this = $(this);
        let _form = _this.parents('form');
        let startDate = _form.find(`[name="startDate"]`).val();
        // _form.find(`[name="endDate"]`).attr('min', _this.val())
        if (!startDate) {
            alert_toastr('error', 'Select start date!');
            _this.val('');
        }
        count_nights(_this);
    });

    function count_nights(_this) {
        let _form = _this.parents('form');
        let startDate = _form.find(`[name="startDate"]`).val();
        let endDate = _form.find(`[name="endDate"]`).val();
        if (startDate && endDate) {
            $.ajax({
                url: `${BASE_URL}reservation/count_nights_update`,
                data: {
                    startDate,
                    endDate
                },
                type: 'POST',
                success: function(data) {
                    _form.find(`[name="nights"]`).val(data);
                    calculate_amount();
                }

            })
        } else {
            alert_toastr('error', 'Select start date and end date!');
            // _this.val('');
        }

    }


    $(document).on('change', '#booking_from', function() {
        let value = $(this).val();
        if (value == 4) {
            $("#agent-box").load(`${BASE_URL}reservations/load_agent`, function() {
                setTimeout(() => {
                    $('#agent').select2();
                }, 1000)
            });
        } else {
            $("#agent-box").html('');
        }
    })

    // $('body').on('click', '.add-room', function(e) {
    //     $('.rooms_tb>tbody').append(`<tr>${rooms_row}</tr>`);
    // })

    $('body').on('click', '.remove-room', function(e) {
        $(this).parents('tr').remove();
        calculate_amount();
    })

    $('body').on('keyup', `[name="discount_amount"]`, function(e) {
        calculate_amount();
    })

    
    $('body').on('change | keyup', '[name="room_type[]"] , [name="quantity[]"]', function(e) {
       //b  alert('Hello');
        let _this = $(this);
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        let room_type = _row.find(`[name="room_type[]"]`).val();
        let pro_id = _form.find(`[name="propmaster"]`).val();
        let qty = _row.find(`[name="quantity[]"]`).val();
        let startDate = _form.find(`[name="startDate"]`).val();
        let endDate = _form.find(`[name="endDate"]`).val();
        let booking_id = _form.find(`[name="booking_id"]`).val();
        var check = 1;
        if (!startDate || !endDate) {
            alert_toastr('error', 'Select start date and end date!');
            _row.find(`[name="room_type[]"]`).val('');
            return false;
        }

        if (_this.attr('name') == "room_type[]") {
            $.each(_form.find(`[name="room_type[]"]`).not(_this), function() {
                if ($(this).val() == room_type) {
                    check = 0;
                }
            })
        }


        setTimeout(() => {

            if (check == 1) {
                $.ajax({
                    url: `${BASE_URL}reservation/check_availability_update`,
                    data: {
                        room_type,
                        pro_id,
                        startDate,
                        endDate,
                        booking_id
                    },
                    type: 'POST',
                    success: function(data) {
                        // console.log({data,qty});
                        if (data && (data - qty) >= 0) {
                            _row.find('.available_rooms').text(data);
                            $.ajax({
                                url: `${BASE_URL}reservation/get_price_update`,
                                data: {
                                    room_type,
                                    pro_id,
                                    qty
                                },
                                type: 'POST',
                                'dataType':'JSON',
                                success: function(data) {
                                    console.log(data);
                                    if (data) {
                                        extra_bedding_price = (data.extra_bedding_price ? data.extra_bedding_price : 'N/A') ;
                                        if(!qty){
                                            _row.find(`[name="quantity[]"]`).val(1);
                                        }
                                        _form.find(`[name="startDate"]`).attr('readonly');
                                        _form.find(`[name="endDate"]`).attr('readonly');
                                        _row.find('.room_price').text(data.daily_price);
                                        _row.find('.extra_bedding_price').text(extra_bedding_price);
                                        _row.find('.capacity').text(data.capacity);
                                        _row.find(`[name="amount[]"]`).val(data.daily_price);
                                        calculate_amount();
                                    } else {
                                        alert_toastr('error', 'Price not available!');
                                        reset_room_row(_row);
                                        calculate_amount();
                                        return false;
                                    }
                                }
                            })
                        } else {
                            _row.find('.available_rooms').text('');
                            alert_toastr('error', 'Room Not available!');
                            // _row.find('[name="quantity[]"]').val(data).change();
                            reset_room_row(_row);
                            calculate_amount();
                            return false;
                        }
                    }

                })


            } else {
                alert_toastr('error', 'Room type already selected!');
                _row.find(`[name="room_type[]"]`).val('');
                reset_room_row(_row);
            }

        }, 1000);
    })

    $('body').on('keyup','[name="extra_bedding[]"]',function(e){
        let _this = $(this);
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        if(_this.val() > 2){ _this.val(2) }
        calculate_amount();
    })

    $('body').on('keyup','[name="discount[]"]',function(e){
        let _this = $(this);
        let discount = _this.val();
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        let price = parseInt(_row.find('.room_price').text());
        if(_this.val() >price ){ _this.val(price) }
        calculate_amount();
    })


    function room_duplicate_type() {
        return 'test';
    }

    function calculate_amount() {
        let rooms = $(`[name="room_type[]"]`);
        let nights = parseInt($(`[name="nights`).val());
        let totalAmount = 0;
        let finalDiscount = 0;
        $.each(rooms, function() {
            var _this = $(this);
            let _row = _this.parents('tr');
            if (_this.val()) {
                var price = parseInt(_row.find('.room_price').text());
                var extra_bedding_price = parseInt(_row.find('.extra_bedding_price').text());
                var qty = _row.find(`[name="quantity[]"]`).val();
                var extra_bedding = _row.find(`[name="extra_bedding[]"]`).val();
                var discount = parseInt(_row.find(`[name="discount[]"]`).val());
                var total_discount = 0;
                if(discount){
                    total_discount = discount * qty;
                }
                _row.find(`[name="total_discount[]"]`).val(total_discount);
                let total = price * qty;
                if(extra_bedding_price && qty){
                    total = total + (extra_bedding_price * extra_bedding);
                }
                if(discount){
                    finalDiscount = parseInt(finalDiscount) + total_discount;
                    total = total - total_discount;
                }

                _row.find(`[name="amount[]"]`).val(total);
                // _row.find(`[name="amount[]"]`).val(price * qty);
                console.log({
                    price,
                    qty
                });
                totalAmount = parseInt(totalAmount) + parseInt(_row.find(`[name="amount[]"]`).val());
            }
        })

        setTimeout(() => {
            let discount = $(`[name="discount_amount"]`).val(finalDiscount);
            // discount = (discount) ? parseInt(discount) : 0;
            $('.total_amount').text((totalAmount * nights))
        }, 1000)
    }

    function reset_room_row(_row) {
        _row.find('input').val('');
        _row.find('.room_txt').text('');
    }

    // $(document).ready(function() {

    // });
</script> -->

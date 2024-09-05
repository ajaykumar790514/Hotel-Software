<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
                <h3 class="content-header-title mb-0 d-inline-block"><?= $title ?></h3>
                <div class="breadcrumbs-top d-inline-block">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url() ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <?= $title ?> List
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            .res-page,
            .res-page input,
            .res-page select {
                font-size: 13px !important;
            }
        </style>
        <div class="content-body">
            <!-- Base style table -->
            <section id="base-style">

                <div class="row">

                    <div class="col-12">
                        <div class="card res-page" style="font-size:13px!important">
                            <div class="card-header p-1 pb-0">
                                <!-- <div class="row"> -->
                                <form autocomplete="off" class="form filterTb" action="<?= $tb_url ?>" method="POST" enctype="multipart/form-data">

                                    <div class="row justify-content-center mt-2">
                                        <!-- <div class="col-md-2">
                                                <div class="form-group select-date">
                                                    <label for="startDate">Start Date</label>
                                                    <input autocomplete="false"  type="date" id="startDate" class="form-control start-date" name="startDate" min='<?= date("Y-m-d") ?>' f="<?= $flat_id ?>">
                                                </div>
                                            </div> -->
                                         <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="propmaster">Property Master</label>
                                                <select id="propmaster" name="propmaster" class="form-control propmaster input-sm">
                                                <?php
                                                   echo optionStatus('','-- Select --');
                                                    foreach ($propmaster as $row) {
                                                        $title = $row->propname .'( '.$row->propcodename.' ) - '.title('cities',$row->city,'id','name');
                                                        $select = (@$_COOKIE['property_id'] == $row->id) ? 'selected' : '';
                                                        echo optionStatus($row->id,$title,$row->status,$select);
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div> 


                                        <div class="col-md-3">
                                            <label>Arrival Date</label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <div class="input-group-prepend">
                                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                                        <i class="ft-calendar"></i>&nbsp;
                                                        <span></span> <i class="ft-chevron-down"></i>
                                                    </div>
                                                    <input type="hidden" name="daterange" id="daterangepickerinput">
                                                </div>


                                            </div>
                                        </div>

                                        <!--  <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="property">Property</label>
                                                        <select id="property" name="property" class="form-control property">
                                                        <?= optionStatus('', '-- Select --') ?>
                                                        </select>
                                                    </div>
                                                </div> -->


                                        <!-- <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="discount_amount">Status</label>
                                                    <select autocomplete="false"  name="status" id="status" class="form-control">
                                                        <?php
                                                        echo optionStatus('', '-- Select --', 1);
                                                        foreach ($b_status as $row) {
                                                            echo optionStatus($row->id, $row->status, 1);
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div> -->

                                        <!--  <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="discount_amount">Paymemt Status</label>
                                                    <select autocomplete="false"  name="payment_status" id="payment_status" class="form-control">
                                                        <?php
                                                        echo optionStatus('', '-- Select --', 1);
                                                        foreach ($p_status as $row) {
                                                            echo optionStatus($row->id, $row->status, 1);
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                            </div> -->

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="discount_amount">Search <small>(Guest Name / Mobile)</small></label>
                                                <input autocomplete="false" name="search" id="search" class="form-control input-sm" placeholder="Guest Name / Mobile" />
                                            </div>

                                        </div>

                                        <div class="col-md-1 pt-2">
                                            <div class="form-group">
                                                <label for="checked_in">
                                                    <input autocomplete="false" type="checkbox" name="checked_in" id="checked_in" /> Checked In </label>

                                            </div>

                                        </div>


                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-sm mt-2"> Filter</button>
                                            </div>
                                        </div>
                                        <div class="col-md-3  ">
                                                <div class="form-group">
                                                    <label></label>
                                                    <button type="button" onclick="myfunction(<?=$cookie_property_id?>)" data-toggle="modal" data-target="#showModal-xl" data-whatever="Booking" data-url="<?= base_url('reservations/reservation_new_form') ?>" class="btn btn-sm btn-primary prop_reservation  mt-2">
                                                      New  Booking
                                                    </button>
                                                </div>


                                            </div>
                                    </div>
                                </form>

                                <!-- <script type="text/javascript">
                    $(document).on('change','.propmaster',function(event) {
                       var value = $(this).val();
                       $('#property').load('<?= base_url() ?>subProperty/'+value);
                    })
                </script> -->
                                <!-- </div> -->



                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                    </ul>
                                </div>


                            </div>

                            <div class="card-content collapse show" id="tb">


                            </div>
                        </div>
                    </div>
                </div>

                
            </section>
            <!--/ Base style table -->
        </div>
    </div>
</div>
<!-- END: Content-->

<style type="text/css">
    .res-tb .show>.dropdown-menu {
        left: 30px !important;
    }

    .table.res-tb th,
    .table.res-tb td {
        white-space: nowrap;
    }
</style>
<script type="text/javascript">
   
	$(document).on('click','.checkout-open',function(event) {
		// $('.checkin').toggle();
		$('.reservation-checked-in-list').hide();
	})
	$(document).on('click','.checkout-close',function(event) {
		$('.checkout').html('');
		$('.reservation-checked-in-list').show();
	})
</script>
<script type="text/javascript">
function myfunction(value)
{
    $('.prop_reservation').data('url', '<?= base_url() ?>reservations/reservation_new_form/' + value)
}
    // $('body').on('focusin','input[type="date"]',function(e){
    //     // alert()
    //     e.which = 32; let booking_type = $("#booking_type").val();
    //     $('body').trigger(e);
    //     // $( this ).trigger({type: 'keypress', which: 32, keyCode: 32});
    // })

    $(document).ready(function() {
        // $(function() {
        setTimeout(function() {

            var start = moment().subtract(2, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#daterangepickerinput').val(start.format('YYYY-MM-DD') + ' , ' + end.format('YYYY-MM-DD'));
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 2 Days': [moment().subtract(2, 'days'), moment()],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

            $('.load-content').submit();

        }, 100);

    });

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
            let shortamountqty = $(".shortamountqty").val() || 0;
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

        console.log(food_amount);
    }, 1000);
}


</script>
<script type="text/javascript">
    $(document).ready(function(){
        if('<?=$cookie_property_id?>'){
            $('.propmaster').val(<?=$cookie_property_id?>).change();
        }
    })

    $(document).on('change', '.propmaster', function(event) {
        var value = $(this).val();
        $('.prop_reservation').data('url', '<?= base_url() ?>reservation_new_form/' + value)
        //$('#tb').load('<?= base_url() ?>propCalendar/calendar/' + value);
    })


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
                url: `${BASE_URL}reservations/count_nights`,
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

    $('body').on('click', '.add-room', function(e) {
        $('.rooms_tb>tbody').append(`<tr>${rooms_row}</tr>`);
    })

    $('body').on('click', '.remove-room', function(e) {
        $(this).parents('tr').remove();
        calculate_amount();
    })

    $('body').on('keyup', `[name="discount_amount"]`, function(e) {
        calculate_amount();
    })

    $('body').on('change | keyup', `[name="room_type[]"] , [name="quantity[]"]`, function(e) {
        let _this = $(this);
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        let room_type = _row.find(`[name="room_type[]"]`).val();
        let pro_id = _form.find(`[name="propmaster"]`).val();
        let qty = _row.find(`[name="quantity[]"]`).val();
        let startDate = _form.find(`[name="startDate"]`).val();
        let endDate = _form.find(`[name="endDate"]`).val();
        var check = 1;
        let booking_id = $("#booking_id").val();
        let booking_type = $("#booking_type").val();
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
     if(booking_id=='')
     {
        // if booking id null means reservation
        setTimeout(() => {

if (check == 1) {
	
    $.ajax({
        url: `${BASE_URL}reservations/check_availability`,
        data: {
            room_type,
            pro_id,
            startDate,
            endDate,
            booking_id
        },
        type: 'POST',
        success: function(data) {
           // alert(data);
            // console.log({data,qty});
            if (data && (data - qty) >= 0) {
                _row.find('.available_rooms').text(data);
                $.ajax({
                    url: `${BASE_URL}reservations/get_price`,
                    data: {
                        room_type,
                        pro_id,
                        qty,
                        startDate,
                        endDate,
                        booking_type:booking_type
                    },
                    type: 'POST',
                    'dataType':'JSON',
                    success: function(data) {
                        
                        console.log(data);
                        if (data) {
                            extra_bedding_price = (data.extra_bedding_price ? data.extra_bedding_price : 'N/A') ;
                            // alert(qty);
                            // if(!qty){
                                // _row.find(`[name="quantity[]"]`).val(1);
                                _row.find(`[name="quantity[]"]`).val(data.qty);
                            // }
                            _form.find(`[name="startDate"]`).attr('readonly');
                            _form.find(`[name="endDate"]`).attr('readonly');
                            _row.find('.room_price').text(data.daily_price);
                            _row.find('.extra_bedding_price').text(extra_bedding_price);
                            _row.find('.capacity').text(data.capacity);
                            _row.find(`[name="amount[]"]`).val(data.daily_price);
                            _row.find(`[name="taxAmount[]"]`).val(data.taxAmount*data.qty);
							_row.find(`[name="taxRate[]"]`).val(data.taxRate);
                            _row.find(`[name="totalAmount[]"]`).val(data.totalAmount);
							if(data.inventory_yes=='YES'){
										$("#inventory_label").html('<label class="text-danger">( Property Inventory Price Included )</label>');
										}
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
     }else
     {
        // if booking id not null means update reservation
        setTimeout(() => {

if (check == 1) {
    $.ajax({
        url: `${BASE_URL}reservations/check_availability_update`,
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
                    url: `${BASE_URL}reservations/get_price_update`,
                    data: {
                        room_type,
                        pro_id,
						startDate,
                        endDate,
                        qty,
                       booking_type:booking_type
                    },
                    type: 'POST',
                    'dataType':'JSON',
                    success: function(data) {
                        console.log(data);
                        if (data) {
                            extra_bedding_price = (data.extra_bedding_price ? data.extra_bedding_price : 'N/A') ;
                            // if(!qty){
                                _row.find(`[name="quantity[]"]`).val(data.qty);
                            // }
                            _form.find(`[name="startDate"]`).attr('readonly');
                            _form.find(`[name="endDate"]`).attr('readonly');
                            _row.find('.room_price').text(data.daily_price);
                            _row.find('.extra_bedding_price').text(extra_bedding_price);
                            _row.find('.capacity').text(data.capacity);
                            _row.find(`[name="amount[]"]`).val(data.daily_price);
                            _row.find(`[name="taxAmount[]"]`).val(data.taxAmount*data.qty);
							_row.find(`[name="taxRate[]"]`).val(data.taxRate);
                            _row.find(`[name="totalAmount[]"]`).val(data.totalAmount);
							if(data.inventory_yes=='YES'){
										$("#inventory_label").html('<label class="text-danger">( Property Inventory Price Included )</label>');
										}
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
     }

       
    })

    $('body').on('keyup','[name="extra_bedding[]"]',function(e){
        let _this = $(this);
        let _row = _this.parents('tr');
        let _form = _this.parents('form');
        if(_this.val() > 10){ _this.val(10) }
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
    let nights = parseInt($(`[name="nights"]`).val());
    let totalAmount = 0;
    let finalDiscount = 0;
    let totalTax = 0;
	let extra_bedding_amt=0;
	let ExtraAmt=0;

    $.each(rooms, function() {
        var _this = $(this);
        let _row = _this.parents('tr');
        if (_this.val()) {
            let price = parseInt(_row.find('.room_price').text());
            let extra_bedding_price = parseInt(_row.find('.extra_bedding_price').text());
            let qty = _row.find(`[name="quantity[]"]`).val();
            let extra_bedding = _row.find(`[name="extra_bedding[]"]`).val();
            let discount = parseInt(_row.find(`[name="discount[]"]`).val());
			let is_gst = $('#is_gst').val();
            var taxable_price = price-discount;
			var total_discount = 0;
                if(discount){
                    total_discount = discount * qty * nights;
                }
                _row.find(`[name="total_discount[]"]`).val(total_discount);
                let total = price * qty;
                if(extra_bedding_price && extra_bedding>0){
                    extra_bedding_amt = (extra_bedding_price * extra_bedding) * nights;
					if(is_gst=='YES'){
					ExtraAmt = (extra_bedding_amt * 12)/100;
					}
                }
				var FlatTotal = total * nights;
                if(discount){
                    finalDiscount = parseInt(finalDiscount) + total_discount;
					console.log(total_discount);
                    FlatTotal = FlatTotal - total_discount;
                }

                find_taxRate(taxable_price).then(taxRate => {
                let tax_Amount = (FlatTotal * taxRate) / 100;
				tax_Amount = tax_Amount+ExtraAmt;
				_row.find(`[name="taxRate[]"]`).val(taxRate);
                _row.find(`[name="amount[]"]`).val(FlatTotal+extra_bedding_amt);
                _row.find(`[name="totalAmount[]"]`).val((FlatTotal+extra_bedding_amt + tax_Amount));
                _row.find(`[name="taxAmount[]"]`).val(tax_Amount);

                totalAmount += parseInt(_row.find(`[name="amount[]"]`).val());
                totalTax += parseInt(_row.find(`[name="taxAmount[]"]`).val());

                updateTotals(totalAmount, totalTax, finalDiscount);
            });
        }
    });
	setTimeout(() => {
            let discount = $(`[name="discount_amount"]`).val(finalDiscount);
        }, 1000)
}

function reset_room_row(_row) {
    _row.find('input').val('');
    _row.find('.room_txt').text('');
}

function find_taxRate(amount) {
    return new Promise((resolve, reject) => {
        if (amount) {
            $.ajax({
                url: `${BASE_URL}reservations/find_taxRate`,
                data: { amount },
                type: 'POST',
                success: function(data) {
                    // console.log(amount + '-' + data);
                    resolve(parseFloat(data)); // Return the parsed tax rate
                },
                error: function() {
                    reject('Error fetching tax rate');
                }
            });
        } else {
            reject('Invalid amount');
        }
    });
}

function updateTotals(totalAmount, totalTax, finalDiscount) {
	let Ttotal = totalAmount ;
    $('.total_amount').text(Ttotal || 0);
    $('.tax_amount').text(totalTax || 0);
    $('.sub_total_amount').text((Ttotal + totalTax) || 0);
    $('.sub_total_amount_val').val((Ttotal + totalTax) || 0);
    $("#total_amount").val(Ttotal);
}


</script>
<script>
    function validateInputs() {
      var firstInputValue = $('.sub_total_amount_val').val();
      var secondInputValue = $("#advanced").val();
      // Perform the validation
      if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
        $("#advanced").val(firstInputValue),
       alert_toastr("error","Sorry advance value not greater than total")
      } else {
        
      }
    }
  </script>
  <script>
    function validate_lumsum() {
      var firstInputValue = $('.balance_total').val();
      var secondInputValue = $(".lump_sum_discount").val();
      // Perform the validation
      //alert(firstInputValue);
      if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
        $(".lump_sum_discount").val(firstInputValue),
       alert_toastr("error","Sorry lum sum discount amount not greater than balance")
      } else {
        
      }
    }
    function validate_payable() {
      var firstInputValue = $('.balance_total').val();
      var secondInputValue = $(".paidable_amount").val();
      // Perform the validation
      //alert(firstInputValue);
      if (parseInt(secondInputValue) > parseInt(firstInputValue)) {
        $(".paidable_amount").val(firstInputValue),
       alert_toastr("error","Sorry payable amount not greater than balance")
      } else {
        
      }
    }
  </script>
